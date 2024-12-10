<?php

namespace App\Services;

use App\Http\Requests\Api\UpdateStudentRequest;
use App\Repositories\ParentRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ParentService extends MainService
{
    public ParentRepository $parentRepository;

    public function __construct(ParentRepository $parentRepository)
    {
        $this->parentRepository = $parentRepository;
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

            if ($request->file('file')) {
                //path
                $image = uploadImage($request->all());
                $data['image'] = str_replace('/', '-', $image);
            }

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
    public function getProfile($request): array
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
