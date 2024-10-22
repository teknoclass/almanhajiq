<?php

namespace App\Repositories\Front\User;

use App\Models\CourseAssignments;
use App\Models\CourseAssignmentResults;
use App\Models\Notifications;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class AssignmentsEloquent extends HelperEloquent
{

    public function start($request, $course_id, $id)
    {
        $assignment = CourseAssignments::where('id', $id)
            ->with('assignmentQuestions', 'course')
            ->first();

        $user = auth()->user();

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

                $data = [
                    'assignment'            => $assignment,
                    'assignmentQuestions'   => $assignment->assignmentQuestions,
                    'assignmentResult'      => $assignmentResult
                ];

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

                        $data = [
                            'assignment'            => $assignment,
                            'assignmentQuestions'   => $assignment->assignmentQuestions,
                            'assignmentResult'      => $userAssignmentSolution
                        ];

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

    public function uploadFile($request, $course_id)
    {

        if ($request->file('file'))
        {
            $file = $request->file;

            $extension = $file->getClientOriginalExtension();
            $filename  = 'file_'.time().mt_rand().'.'.$extension;

            $file->move(storage_path() . '/app/uploads/files/courses/'. $course_id .'/assignments', $filename);

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
}
