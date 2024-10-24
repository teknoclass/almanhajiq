<?php

namespace App\Services;

use App\Http\Requests\Api\UpdateStudentRequest;
use App\Repositories\StudentRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StudentService extends MainService
{
    public StudentRepository $studentRepository;

    public function __construct(StudentRepository $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }
    public function editProfile(UpdateStudentRequest $request): array
    {

        DB::beginTransaction();

        try {
            $user = $request->user();

            if (!$user) {
                return $this->createResponse(
                    __('message.user_does_not_exist'),
                    false,
                    null
                );
            }

            $data = $request->all();

            $user->update($data);

            DB::commit();

            return $this->createResponse(
                __('message.success'),
                true,
                $user
            );

        } catch (\Exception $e) {
            DB::rollback();

            Log::alert($e->getMessage());

            return $this->createResponse(
                __('message.unexpected_error'),
                false,
                null
            );
        }
    }
    public function getStudentProfile($request): array
    {
        $user = $request->user();

        if (!$user) {
            return $this->createResponse(
                __('message.user_does_not_exist'),
                false,
                null
            );
        }
        return $this->createResponse(
            __('message.success'),
            true,
            $user
        );
    }

}
