<?php

namespace App\Http\Controllers\Panel;

use App\Models\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Front\User\Lecturer\Courses\AddQuiz;
use App\Http\Requests\Front\User\Lecturer\Courses\AddLesson;
use App\Http\Requests\Front\User\Lecturer\Courses\AddLiveLesson;
use App\Http\Requests\Front\User\Lecturer\Courses\AddSectionRequest;
use App\Repositories\Common\CurriculumCreationEloquent;

class CurriculumCreationController extends Controller
{
    //
    private $curriculum_creation;
    public function __construct(
        CurriculumCreationEloquent $curriculum_creation_eloquent,
    ) {
        $this->middleware('auth:admin');

        $this->curriculum_creation    = $curriculum_creation_eloquent;
    }

    // show modals

    public function getLessonModal()
    {

        $content = $this->curriculum_creation->getModal('lesson');

        return response()->json(['content' => $content]);
    }


    public function getExamModal()
    {
        $content = $this->curriculum_creation->getModal('quiz');

        return response()->json(['content' => $content]);
    }

    public function getTaskModal()
    {
        $content = $this->curriculum_creation->getModal('assignment');

        return response()->json(['content' => $content]);
    }

    public function getCorrectModal()
    {
        $content = $this->curriculum_creation->getCorrectModal();

        return response()->json(['content' => $content]);
    }

    public function getQuizSolutionModal()
    {
        $content = $this->curriculum_creation->getQuizSolutionModal();

        return response()->json(['content' => $content]);
    }

    public function addSection(AddSectionRequest $request) {
        $data = $this->curriculum_creation->addSection($request);
        return response()->json($data);
    }

    public function deleteSection(Request $request)
    {
        $response = $this->curriculum_creation->deleteSection($request);
        return response()->json($response);
    }


    public function addLesson(AddLesson $request) {
        $data = $this->curriculum_creation->addLesson($request);
        return response()->json($data);
    }

    public function updateLesson(AddLesson $request) {
        $data = $this->curriculum_creation->updateLesson($request);
        return response()->json($data);
    }

    public function deleteLesson(Request $request)
    {
        $response = $this->curriculum_creation->deleteLesson($request);
        return response()->json($response);
    }

    public function deleteOuterLesson(Request $request)
    {
        $response = $this->curriculum_creation->deleteOuterLesson($request);
        return response()->json($response);
    }




    public function addQuiz(AddQuiz $request) {
      // dd($request->all());
        $data = $this->curriculum_creation->addQuiz($request);
        return response()->json($data);
    }
    public function updateQuiz(AddQuiz $request) {
        // dd($request->all());
        $data = $this->curriculum_creation->updateQuiz($request);
        return response()->json($data);
    }

    public function deleteQuiz(Request $request)
    {
        $response = $this->curriculum_creation->deleteQuiz($request);
        return response()->json($response);
    }

    public function deleteOuterQuiz(Request $request)
    {
        $response = $this->curriculum_creation->deleteOuterQuiz($request);
        return response()->json($response);
    }






    public function addTask(Request $request) {
          $data = $this->curriculum_creation->addTask($request);
          return response()->json($data);
    }

    public function updateTask(Request $request) {
        $data = $this->curriculum_creation->updateTask($request);
        return response()->json($data);
    }

    public function deleteTask(Request $request)
    {
        $response = $this->curriculum_creation->deleteTask($request);
        return response()->json($response);
    }

    public function deleteOuterTask(Request $request)
    {
        $response = $this->curriculum_creation->deleteOuterTask($request);
        return response()->json($response);
    }



    public function deleteCourseAttachment(Request $request , $img_id) {
        $data = $this->curriculum_creation->deleteCourseAttachment($request , $img_id);
        return response()->json($data);
    }

}
