<?php

namespace App\Repositories\Front\User;

use Carbon\Carbon;
use App\Models\Notifications;
use App\Models\CourseAssignments;
use Illuminate\Support\Facades\Hash;
use App\Models\CourseAssignmentResults;
use Illuminate\Support\Facades\Response;
use App\Models\CourseAssignmentsResultsAnswer;
use App\Http\Resources\Assignment\StartAssignmentResource;

class AssignmentsEloquent extends HelperEloquent
{

    public function start($request, $course_id, $id,$is_web = true)
    {
        $assignment = CourseAssignments::where('id', $id)
            ->with('assignmentQuestions', 'course')
            ->first();

        $user = $this->getUser($is_web);

        if ($assignment) {
            // Does the user started the assignment
            $userAssignmentSolution = CourseAssignmentResults::where('assignment_id', $assignment->id)
                ->where('student_id', $user->id)
                ->first();

            // The user didn't start one before so start one
            if (!$userAssignmentSolution) {
                $assignmentResult = CourseAssignmentResults::create([
                    'course_id'     => $assignment->course_id,
                    'lecturer_id'   => $assignment->user_id,
                    'student_id'    => $user->id,
                    'assignment_id' => $assignment->id,
                    'results'       => '',
                    'grade'         => 0,
                    'status'        => CourseAssignmentResults::$notSubmitted,
                    'started_at'    => now(),
                    'created_at'    => now(),
                ]);

                $assignment = CourseAssignments::where('id', $id)
                ->with(['assignmentQuestions' => function ($query) use ($assignmentResult){
                    $query->with(['userAnswers' => function ($query) use ($assignmentResult){
                        $query->where('result_id',$assignmentResult->id);
                    }]);
                }], 'course')
                ->first();

                $data = [
                    'assignment'            => $assignment,
                    'assignmentQuestions'   => $assignment->assignmentQuestions,
                    'assignmentResult'      => $assignmentResult
                ];
                if(!$is_web){
                    $data['assignment'] = new StartAssignmentResource($assignment);
                    $end_time = Carbon::createFromFormat('Y-m-d H:i:s', $assignmentResult->started_at)->addMinutes($assignment->time);
                    $current = Carbon::now();
                    $data['remaining_time'] = $current->diffInSeconds($end_time);

                    unset($data['assignmentResult']);
                    unset($data['assignmentQuestions']);


                }

                return $data;
            }
            // The user started one before
            else
            {
                // Check if the user submitted his solution
                if ($userAssignmentSolution->status == CourseAssignmentResults::$notSubmitted) {
                    $now = Carbon::now();
                    $end_time = Carbon::createFromFormat('Y-m-d H:i:s',  $userAssignmentSolution->started_at)->addMinutes($assignment->time);

                    $is_passed_time = $now > $end_time;

                    // If the user didn't submit the solution and he still has time
                    if (!$is_passed_time) {

                        $diffInSeconds = $end_time->diffInSeconds($now);
                        $assignment->time = $diffInSeconds / 60;

                        $assignment = CourseAssignments::where('id', $id)
                        ->with(['assignmentQuestions' => function ($query) use ($userAssignmentSolution){
                            $query->with(['userAnswers' => function ($query) use ($userAssignmentSolution){
                                $query->where('result_id',$userAssignmentSolution->id);
                            }]);
                        }], 'course')
                        ->first();
                        //return $assignment;
                        $data = [
                            'assignment'            => $assignment,
                            'assignmentQuestions'   => $assignment->assignmentQuestions,
                            'assignmentResult'      => $userAssignmentSolution
                        ];
                        if(!$is_web){
                            $data['assignment'] = new StartAssignmentResource($assignment);
                            $end_time = Carbon::createFromFormat('Y-m-d H:i:s', $userAssignmentSolution->started_at)->addMinutes($assignment->time);
                            $current = Carbon::now();
                            $data['remaining_time'] = $current->diffInSeconds($end_time);
                            unset($data['assignmentResult']);
                            unset($data['assignmentQuestions']);

                        }

                        return $data;
                    }
                    // If the user didn't submit the solution and he Doesn't have time
                    else
                    {
                        // Set the user as failed and close the solution attemption
                        $userAssignmentSolution->update([
                            'results'    => '',
                            'status'     => CourseAssignmentResults::$notPassed,
                            'created_at' => now()
                        ]);

                        // update the progress
                        $course = $assignment->course;
                        $course->updateProgress();

                        $data['error']          = 'assignment_time_passed';
                        $data['assignment_id']  = $assignment->id;
                        $data['course_id']      = $assignment->course_id;

                        return $data;
                    }
                }
                else {
                    $data['error'] = 'assignment_done';
                    return $data;
                }
            }
        }
        abort(404);
    }

    public function storeResult($request, $course_id, $id)
    {
        $user = auth()->user();
        $assignment = CourseAssignments::where('id', $id)->with('assignmentQuestions', 'course')->first();

        if ($assignment) {

            $results = $request->get('question');
            $assignmentResultId = $request->get('assignment_result_id');

            if (!empty($assignmentResultId)) {

                $assignmentResult = CourseAssignmentResults::where('id', $assignmentResultId)
                    ->where('student_id', $user->id)
                    ->first();

                if (!empty($assignmentResult)) {

                    $now = Carbon::now();
                    $end_time = Carbon::createFromFormat('Y-m-d H:i:s',  $assignmentResult->started_at)->addMinutes($assignment->time);

                    $is_passed_time = $now > $end_time;

                    if (empty($results) || $is_passed_time) {
                        $results = '';
                    }
                    else {
                        foreach ($results as $questionId => $result) {

                            if (!is_array($result)) {
                                unset($results[$questionId]);

                            } else {
                                $results = array_map(function ($questionData) {
                                    $questionData['grade'] = 0;
                                    return $questionData;
                                }, $results);
                            }
                        }

                        $results = json_encode($results);
                    }

                    $status = 'pending';

                    $result_token = Hash::make(quickRandom(16)) . $assignmentResult->id;
                    $result_token = str_replace('%', '', $result_token);
                    $result_token = str_replace('/', '', $result_token);

                    $assignmentResult->update([
                        'results'   => $results,
                        'status'    => $status,
                        'result_token' => $result_token,
                        'created_at'=> now()
                    ]);

                    // update the progress
                    $course = $assignment->course;
                    $course->updateProgress();

                    // Send notification if need reviewing
                    $title = 'حل الواجب ' . $assignment->title;
                    $text = "قام " . $user->name . " بالاجابة على اسئلة الواجب: " . $assignment->title;
                    $notification['title'] = $title;
                    $notification['text'] = $text;
                    $notification['user_type'] = 'user';
                    $notification['action_type'] = 'solve_assignment';
                    $notification['action_id'] = $assignment->id;
                    $notification['created_at'] = \Carbon\Carbon::now();

                    $teacher_id = $course->user_id;
                    $notification['user_id'] = $teacher_id;

                    Notifications::insert($notification);
                    sendWebNotification($teacher_id, 'user', $title, $text);


                    $data['assignment_id']  = $assignment->id;
                    $data['course_id']      = $assignment->course_id;

                    return $data;
                }
            }


        }
        abort(404);
    }

    public function uploadFile($request, $course_id,$is_web,$assignment_id = null, $question_id = null)
    {

        if ($request->file('file')) {
            $file=$request->file;

            $extension = $file->getClientOriginalExtension();
            $filename = 'file_'.time().mt_rand().'.'.$extension;

            $file->move(storage_path() . '/app/uploads/files/courses/'. $course_id .'/assignments', $filename);
            if(!$is_web){
                return $filename;
            }

            $user = $this->getUser($is_web);
            $result = CourseAssignmentResults::where('student_id',$user->id)->where('assignment_id',$assignment_id)->first();


            $answer = CourseAssignmentsResultsAnswer::updateOrCreate([
                'result_id' => $result->id,
                'question_id' => $question_id],[
                'file' => $filename
            ]);
            return Response::json([
                'status' => true,
                'file_name' => $filename
            ], 200);
        }
    }

    public function delete_file($filename, $course_id)
    {
        @unlink(storage_path() . '/app/uploads/files/courses/'. $course_id .'/assignments\/'.$filename);

        return Response::json([
            'status'    => true,
        ], 200);
    }

    function submitAnswer($request,$is_web = true)
    {
        $user = $this->getUser($is_web);

        $result = CourseAssignmentResults::where('student_id',$user->id)->where('assignment_id',$request['assignment_id'])->first();

        $answer = CourseAssignmentsResultsAnswer::updateOrCreate([
            'result_id' => $result->id,
            'question_id' => $request['question_id']],[
            'answer' => $request['answer'] ?? null,
            'file' => $this->uploadFile($request,$result->course_id,$is_web)
        ]);
    }

    function endAssignmentApi($request,$is_web = true)
    {
        if($is_web)$guardType = 'web';
        else $guardType = 'api';

        $user = $this->getUser($is_web);
        $assignment = CourseAssignments::where('id', $request->get('assignment_id'))->first();
        $data['course_id'] = $assignment->course_id;
        $data['assignment_id'] = $assignment->id;

        if ($assignment) {

            $assignmentResult = CourseAssignmentResults::where('assignment_id', $request->get('assignment_id'))
                ->where('student_id', $user->id)
                ->first();

            if($assignmentResult == null){
                $assignmentResult = CourseAssignmentResults::create([
                    'asignment_id' => $request->get('assignment_id'),
                    'user_id' => $user->id,
                    'lecturer_id' => $assignment->user_id,
                    'course_id' => $assignment->course_id
                ]);
            }

            if($assignmentResult->result_token != null){
                $data['status'] = false;
                $data['message'] = __('assignment_done_before');
                return $data;
            }

            $now = Carbon::now();
            $end_time = Carbon::createFromFormat('Y-m-d H:i:s',  $assignmentResult->started_at)->addMinutes($assignment->time);

            $is_passed_time = $now > $end_time;

            if($is_passed_time){

                $data['status'] = false;
                $data['message'] = __('assignment_time_done');
                return $data;
            }else{
                $status = 'pending';
            }


            $result_token = Hash::make(quickRandom(16)) . $assignmentResult->id;
            $result_token = str_replace('%', '', $result_token);
            $result_token = str_replace('/', '', $result_token);

            $assignmentResult->update([
                'results'   => '',
                'status'    => $status,
                'result_token' => $result_token,
                'created_at'=> now()
            ]);

            // Send notification if need reviewing
            $title = 'حل الواجب ' . $assignment->title;
            $text = "قام " . $user->name . " بالاجابة على اسئلة الواجب: " . $assignment->title;
            $notification['title'] = $title;
            $notification['text'] = $text;
            $notification['user_type'] = 'user';
            $notification['action_type'] = 'solve_assignment';
            $notification['action_id'] = $assignment->id;
            $notification['created_at'] = \Carbon\Carbon::now();

            $teacher_id = $assignment->course->user_id;
            $notification['user_id'] = $teacher_id;

            Notifications::insert($notification);
            sendWebNotification($teacher_id, 'user', $title, $text);


            // update the progress
            $course = $assignment->course;
            $course->updateProgress($guardType);
            $data['status'] = true;
            $data['message'] = __('message.operation_accomplished_successfully');
            return $data;


        }
    }

    function showResult($id,$is_web = true)
    {
        $user = $this->getUser($is_web);
        $userAssignmentSolution = CourseAssignmentResults::where('student_id',$user->id)->where('assignment_id',$id)->first();
        $assignment = CourseAssignments::where('id', $id)
                        ->with(['assignmentQuestions' => function ($query) use ($userAssignmentSolution){
                            $query->with(['userAnswers' => function ($query) use ($userAssignmentSolution){
                                $query->where('result_id',$userAssignmentSolution->id);
                            }]);
                        }], 'course')
                        ->first();

        $data['question'] = new StartAssignmentResource($assignment);
        $data['user_grade'] = $userAssignmentSolution->grade;
        $data['status'] = $userAssignmentSolution->status;

        return $data;
    }

}
