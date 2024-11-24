<?php

namespace App\Repositories\Panel;

use App\Mail\ReplayMail;
use App\Mail\TeacherEvaluation;
use Illuminate\Support\Facades\Mail;
use App\Models\JoinAsTeacherRequests;
use App\Models\User;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class JoinAsTeacherRequestsEloquent
{
    public function getDataTable()
    {


        $data =JoinAsTeacherRequests::select('*', DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d ") as date'))
            ->with(['country','certificate'])->orderByDesc('created_at')->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', 'panel.join_as_teacher_requests.partials.actions')
            ->rawColumns(['action'])
            ->make(true);

    }


    public function store($request)
    {
        $data = $request->all();

        // This foreach is used to make the images uploaded compitable with the function uploadImage
        foreach ($request->file as $key => $file) {
            $data['file'] = $file;
            $data['image_'.$key+1] = uploadImage($data);
        }

        JoinAsTeacherRequests::updateOrCreate(['id' => 0], $data);

        $message = __('message_done');
        $status = true;

        $response = [
            'message' => $message,
            'status' => $status,
        ];

        return $response;
    }

    public function edit($id)
    {
        $data['item'] = JoinAsTeacherRequests::where('id', $id)
        ->select('*', DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d ") as date'))
        ->first();
        if ($data['item'] == '') {
            abort(404);
        }

        return $data;
    }

    public function update($id, $request)
    {
        DB::beginTransaction();

       try {
            $item=$this->edit($id)['item'];

            if ($item->status != JoinAsTeacherRequests::PENDING) {
                $message = __('message_error');
                $status = false;

                $response = [
                    'message' => $message,
                    'status' => $status,
                ];
                return $response;
            }

            JoinAsTeacherRequests::updateOrCreate(['id' => $id], $request->all());

            $user = User::where('email', $item->email)->first();

            if ($user) {
                $message = __('This_Email_is_used_before!!');
                $status = false;
                $response = [
                    'message' => $message,
                    'status' => $status,
                ];
                return $response;
            }


            if ($request->status == JoinAsTeacherRequests::ACCEPTABLE) {

                $password = substr(sprintf("%06d", mt_rand(1, 999999)), 0, 8);
                $user = User::create([
                    'name'          => $item->name,
                    'email'         => $item->email,
                    'password_c'    => $password,
                    'password'      => Hash::make($password),
                    'mobile'        => $item->mobile,
                    'country_id'    => $item->country_id,
                    'city'          => $item->city,
                    'id_image'      =>$item->id_image,
                    'job_proof_image'=>$item->job_proof_image,
                    'cv_file'       =>$item->cv_file,
                    'role'          => User::LECTURER,
                    'is_validation' => 1,
                    'validation_at' => now(),
                    'add_by'        => User::ADD_BY_ADMIN,
                    'gender'        => $item->gender,
                    'dob'           => $item->dob,
                    'material_id'   => $item->material_id,
                ]);

                $title = 'نتيجة تقييم طلب الانضمام كمدرب';
                $msg = "تم الموافقة على طلب انمضامك فى منصتنا";

                // Mail::to($user->email)->send(new  TeacherEvaluation($title, $user, $user->email , $password));
                sendEmail($title,$msg,$user->email);
            }

            if ($request->status == JoinAsTeacherRequests::UNACCEPTABLE) {

                $title = 'نتيجة تقييم طلب الانضمام كمدرب';
                $content = 'للأسف تم رفض الطلب الخاص بكم للسبب التالي: ' . $request->reason_unacceptable;

                // Mail::to($user->email)->send(new ReplayMail($title, $content, $user->email));
                sendEmail($title,$content,$user->email);
            }

           $message = __('message_done');
            $status = true;

            $response = [
                'message' => $message,
                'status' => $status,
            ];

            DB::commit();
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
           $message = __('message_error');
            $status = false;
           $error = sprintf('[%s],[%d] ERROR:[%s]', __METHOD__, __LINE__, json_encode($e->getMessage(), true));
            $response = [
                'message' => $message,
                'status' => $status,
            ];

        }


        return $response;
    }


    public function delete($id)
    {
        $item = JoinAsTeacherRequests::find($id);
        if ($item) {
            $item->delete();
            $message =__('delete_done');
            $status = true;
            $response = [
                'message' => $message,
                'status' => $status,
            ];
            return $response;
        }
        $message = __('message_error');
        $status = false;

        $response = [
            'message' => $message,
            'status' => $status,
        ];

        return $response;
    }
}
