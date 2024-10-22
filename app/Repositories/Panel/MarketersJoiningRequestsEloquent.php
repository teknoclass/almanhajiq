<?php

namespace App\Repositories\Panel;

use App\Models\Admins;
use App\Models\Category;
use App\Models\CouponMarketers;
use App\Models\Coupons;
use App\Models\RequestJoinMarketer;
use App\Models\User;
use App\Models\UserRoles;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use DataTables;

class MarketersJoiningRequestsEloquent
{
    public function index()
    {
        $data['countries'] = Category::query()->select('id', 'value', 'parent')
        ->with('translations:category_id,name,locale')
        ->where('parent', 'countries')
        ->orderByDesc('created_at')
        ->get();

        return $data;
    }

    public function getDataTable()
    {

        $data =RequestJoinMarketer::select('*', DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d ") as date'))
            ->with(['country'])->orderByDesc('created_at')->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', 'panel.marketers_joining_requests.partials.actions')
            ->rawColumns(['action'])
            ->make(true);
    }




    public function edit($id)
    {
        $data['item'] = RequestJoinMarketer::where('id', $id)
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

            if ($item->status != RequestJoinMarketer::PENDING) {
                $message = 'حدث خطأ غير متوقع';
                $status = false;

                $response = [
                    'message' => $message,
                    'status' => $status,
                ];
                return $response;
            }

            RequestJoinMarketer::updateOrCreate(['id' => $id], $request->all());
            $title_msg='طلب إنضمامك كمسوق';
            if ($request->status == RequestJoinMarketer::UNACCEPTABLE) {
                $text_msg='نأسف تم رفض طلب  إنضمامك كمسوق';
                if($request->reason_unacceptable!='') {
                    $text_msg.=' بسبب: ';
                    $text_msg.=$request->reason_unacceptable;
                }
            } elseif ($request->status == RequestJoinMarketer::ACCEPTABLE) {
                $user=User::where('email', $item->email)->first();

                if(!$user) {
                    $password=quickRandom(8);
                    $user=User::Create([
                        'name'          => $item->name,
                        'email'         => $item->email,
                        'password'      => Hash::make($password),
                        'mobile'        => $item->mobile,
                        'code_country'=>$item->code_country,
                        'slug_country'=>$item->slug_country,
                        'country_id'          => $item->country_id,
                        'city'          => $item->city,
                        'gender'=>$item->gender,
                        'is_validation' => 1,
                        'role'          => User::MARKETER,
                        'add_by'        => User::ADD_BY_ADMIN,
                    ]);

                    $text_msg="<p>تهانينا ! تم قبول طلب إنضمامك كمسوق </p>";
                    $text_msg.="<p>بإمكانك الدخول على حسابك من خلال الرابط بالاسفل:</p> ";
                    $text_msg.="<a href='".route('user.auth.login')."'>رابط الدخول</a>";
                    $text_msg.="<p>البريد الإلكترونى: " . $item->email."</p>";
                    $text_msg.="<p>كلمة المرور : " . $password."</p>";

                } else {
                    $user->update([
                        'name'          => $item->name,
                        'email'         => $item->email,
                        'mobile'        => $item->mobile,
                        'code_country'=>$item->code_country,
                        'slug_country'=>$item->slug_country,
                        'country_id'          => $item->country_id,
                        'city'          => $item->city,
                        'gender'=>$item->gender,
                        'is_validation' => 1,
                        'validation_at' => now(),
                        'role'          => User::MARKETER,
                        'add_by'        => User::ADD_BY_ADMIN,
                    ]);
                    $text_msg='<p>تهانينا ! تم قبول طلب إنضمامك كمسوق </p>';
                    $text_msg.=' بإمكانك الدخول على لوحة تحكم المسوق من خلال بيانات حسابك     ';

                }

                // save role
                UserRoles::create([
                    'user_id'=>$user->id,
                    'role'=>UserRoles::MARKETER
                ]);

                // save coupon

                $coupon_id=$request->coupon_id;
                Coupons::where('id', $coupon_id)->update([
                   'marketer_amount_type'=>$request->marketer_amount_type,
                   'marketer_amount'=>$request->marketer_amount,
                   'marketer_amount_of_registration'=>$request->marketer_amount_of_registration,
                ]);


                $is_found_coupon=CouponMarketers::where([
                    ['coupon_id',$coupon_id],
                    ['user_id',$user->id]
                ])->first();
                if(!$is_found_coupon) {
                    CouponMarketers::create([
                        'coupon_id'=>$coupon_id,
                        'user_id'=>$user->id,
                        'add_by'=>CouponMarketers::THROUGH_REQUEST
                    ]);
                }

            }

            // sendEmail($title_msg, $text_msg, $item->email);

            $message = 'تمت العملية بنجاح';
            $status = true;

            $response = [
                'message' => $message,
                'status' => $status,
            ];

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $message ='حدث خطا غير متوقع';
            $status = false;
            $response = [
                'message' => $message,
                'status' => $status,
            ];

        }


        return $response;
    }


    public function delete($id)
    {
        $item = RequestJoinMarketer::find($id);
        if ($item) {
            $item->delete();
            $message = 'تم الحذف بنجاح  ';
            $status = true;
            $response = [
                'message' => $message,
                'status' => $status,
            ];
            return $response;
        }
        $message = 'حدث خطأ غير متوقع';
        $status = false;

        $response = [
            'message' => $message,
            'status' => $status,
        ];

        return $response;
    }
}
