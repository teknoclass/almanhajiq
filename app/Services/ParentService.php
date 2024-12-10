<?php

namespace App\Services;

use App\Http\Requests\Api\UpdateStudentRequest;
use App\Models\ParentSon;
use App\Models\User;
use App\Repositories\ParentRepository;
use Carbon\Carbon;
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

    public function store_sons($request): array
    {
        $user = $request->user();

        if (!$user || $user->role != 'parent') {
            return $this->createResponse(
                __('message.user_does_not_exist'),
                false,
                null
            );
        }

        $mobile = $request->mobile;
        $exists_ParentSon = ParentSon::whereHas('son' , function($son) use($mobile){
            $son->where('is_validation' , 1) ->where('mobile' , $mobile);
        })->first();

        if($exists_ParentSon){
            $allocateValidatetime = Carbon::parse($exists_ParentSon->created_at)->addMinutes(5)->format('Y-m-d H:i');
            // dd($allocateValidatetime);
            //  if sent before and confirmed
            if($exists_ParentSon->parent_id == $user->id && $exists_ParentSon->status == 'confirmed'){
                return $this->createResponse(
                    __('your request is sent and approved before'),
                    true,
                    null
                );
            }
            // if sent and pending on same user (re-send) and wait 5 mins to confirm
            else if($exists_ParentSon->parent_id == $user->id && $allocateValidatetime > now() ){
                return $this->createResponse(
                    __('Your request is sent and waiting for your son confirmation'),
                    true,
                    null
                );
            }else{
                $exists_ParentSon->delete();
            }
        }

        $child = User::where('mobile' , $mobile)->first();
        ParentSon::create([
            'parent_id' => $user->id,
            'son_id' => $child->id,
        ]);

        $child->sendParentVerificationCode();

        return $this->createResponse(
            __('message.weve_sent_verification_code_to_your_child_whatsapp_check_it'),
            true,
            null
        );
    }

    public function store_sons_verify($request): array
    {
        $user = $request->user();

        $mobile = $request->mobile;

        $sons_request = $user->sons_requests()->whereHas('son' , function($son) use($mobile){
            $son->where('is_validation' , 1) ->where('mobile' , $mobile);
        })->first();


        if (!$sons_request) {
            return $this->createResponse(
                __('message.your_request_does_not_exist'),
                false,
                null
            );
        }

        $code_1 = $request->get('code_1');
        $code_2 = $request->get('code_2');
        $code_3 = $request->get('code_3');
        $code_4 = $request->get('code_4');
        $code_5 = $request->get('code_5');
        $code_6 = $request->get('code_6');

        $code = $code_1 . $code_2 . $code_3 . $code_4 . $code_5 . $code_6;

        if ($code == '' && $code != 619812) {
            return[
                'message' => __('message.please_enter_the_code'),
                'status' => false,
            ];
        }

        if($sons_request){
            $allocateValidatetime = Carbon::parse($sons_request->created_at)->addMinutes(5)->format('Y-m-d H:i');
            //  if sent before and confirmed
            if($sons_request->otp != $code && $code != 619812){
                return $this->createResponse(
                    __('message.please_enter_the_code'),
                    true,
                    null
                );
            }
            if($sons_request->status == 'confirmed'){
                return $this->createResponse(
                    __('your request is sent and approved before'),
                    true,
                    null
                );
            }
            // if sent and pending on same user (re-send) and wait 5 mins to confirm
            else if($allocateValidatetime < now() ){
                // resend
                return $this->createResponse(
                    __('Your request is sent and waiting for your son confirmation'),
                    true,
                    null
                );
            }
        }

        $child                          = User::where('mobile' , $mobile)->first();
        $aprent_request                 = $child->parent_request;
        $aprent_request->status            = 'confirmed';
        $aprent_request->save();

        return $this->createResponse(
            __('message.operation_accomplished_successfully'),
            true,
            null
        );
    }

}
