<?php

namespace App\Repositories\Panel;

use App\Helper\CouponGenerator;
use App\Jobs\CouponExcelHandle;
use App\Models\CouponMarketers;
use App\Models\Coupons;
use App\Models\CoursesCoupon;
use DataTables;
use Exception;
use Illuminate\Support\Facades\Log;

class CouponsEloquent
{
    public function getDataTable()
    {
        $data =Coupons::orderByDesc('created_at')
        ->select('id', 'title', 'code')->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', 'panel.coupons.partials.actions')
            ->rawColumns(['action'])
            ->make(true);
    }

    public function getAll()
    {
        $items = Coupons::orderByDesc('created_at')
        ->select('id', 'title', 'code')->orderBy('id', 'desc')->get();

        return $items;
    }

    public function getAllGeneral()
    {
        $items = Coupons::orderByDesc('created_at')
        ->select('id', 'title', 'code')->orderBy('id', 'desc')
        ->withCount('marketers')
         ->having('marketers_count', '=', 0)
        ->get();

        return $items;

    }


    public function store($request)
    {

        try{
            $data = $request->all();

            if ($request->expiry_date) {
                $data['expiry_date'] = date('Y-m-d ', strtotime($request->expiry_date));
            }

            $coupon=Coupons::updateOrCreate(['id' => 0], $data);
            if($request->course_ids){

                foreach($request->course_ids as $id){
                    CoursesCoupon::firstOrCreate([
                        'course_id' => $id,
                        'coupon_id' => $coupon->id
                    ]);
                }
            }
            $marketer_id = $request->marketer_id;
            $check_coupon=CouponMarketers::where('user_id', $marketer_id)
            ->where('coupon_id', '!=', $coupon->id)
            ->first();
            if($check_coupon) {
                $response = [
                    'message' => 'المسوق له كوبون اخر',
                    'status' =>false,
                ];

                return $response;
            }
            if($marketer_id){
                CouponMarketers::create([
                    'user_id'=>$marketer_id,
                    'coupon_id'=>$coupon->id,
                    'add_by'=>CouponMarketers::MANUALLY
                ]);
            }


            $message = 'تمت العملية بنجاح';
            $status = true;

            $response = [
                'message' => $message,
                'status' => $status,
            ];

            return $response;
        }
        catch(Exception $e){
            Log::info($e->getMessage());
        }
    }
    public function storeMultiple($request)
    {

        try{
            $coupons = array();
            for($i = 0 ; $i < $request->number ; $i+=1){

                $data = $request->all();
                $data['code'] = CouponGenerator::generateCoupon();
                $coupons[] = $data['code'];
                if ($request->expiry_date) {
                    $data['expiry_date'] = date('Y-m-d ', strtotime($request->expiry_date));
                }

                $coupon=Coupons::updateOrCreate(['id' => 0], $data);
                if($request->course_ids){

                    foreach($request->course_ids as $id){
                        CoursesCoupon::firstOrCreate([
                            'course_id' => $id,
                            'coupon_id' => $coupon->id
                        ]);
                    }
                }
                $marketer_id = $request->marketer_id;
                $check_coupon=CouponMarketers::where('user_id', $marketer_id)
                ->where('coupon_id', '!=', $coupon->id)
                ->first();
                if($check_coupon) {
                    $response = [
                        'message' => 'المسوق له كوبون اخر',
                        'status' =>false,
                    ];

                    return $response;
                }
                if($marketer_id){
                    CouponMarketers::create([
                        'user_id'=>$marketer_id,
                        'coupon_id'=>$coupon->id,
                        'add_by'=>CouponMarketers::MANUALLY
                    ]);
                }
            }


            $message = 'تمت العملية بنجاح';
            $status = true;

            $response = [
                'message' => $message,
                'status' => $status,
            ];

            CouponExcelHandle::dispatch($coupons);
            return $response;

        }
        catch(Exception $e){
            Log::info($e->getMessage());
        }
    }

    public function edit($id)
    {
        $data['item'] = Coupons::where('id', $id)->first();
        if ($data['item'] == '') {
            abort(404);
        }
        $data['couponCourses'] = CoursesCoupon::where('coupon_id',$id)->get();


        return $data;
    }

    public function update($id, $request)
    {
        try{
            $data = $request->all();

            if ($request->expiry_date) {
                $data['expiry_date'] = date('Y-m-d ', strtotime($request->expiry_date));
            }

            $coupon=Coupons::updateOrCreate(['id' => $id], $data);


            $newCourseIds = $request->input('course_ids', []);

            $existingCourseIds = CoursesCoupon::where('coupon_id', $id)
                ->pluck('course_id')
                ->toArray();

            $coursesToRemove = array_diff($existingCourseIds, $newCourseIds);

            $coursesToAdd = array_diff($newCourseIds, $existingCourseIds);

            if (!empty($coursesToRemove)) {
                CoursesCoupon::where('coupon_id', $id)
                    ->whereIn('course_id', $coursesToRemove)
                    ->delete();
            }

            foreach ($coursesToAdd as $courseId) {
                CoursesCoupon::create([
                    'course_id' => $courseId,
                    'coupon_id' => $id,
                ]);
            }


            $marketer_id = $request->marketer_id;
            $check_coupon=CouponMarketers::where('user_id', $marketer_id)
            ->where('coupon_id', '!=', $coupon->id)
            ->first();
            if($check_coupon) {
                $response = [
                    'message' => 'المسوق له كوبون اخر',
                    'status' =>false,
                ];

                return $response;
            }



            if($marketer_id){

                CouponMarketers::updateOrCreate([ 'user_id'=>$marketer_id,
                'coupon_id'=>$coupon->id],[

                    'add_by'=>CouponMarketers::MANUALLY
                ]);
            }

            $message = 'تمت العملية بنجاح';
            $status = true;

            $response = [
                'message' => $message,
                'status' => $status,
            ];

            return $response;
        }catch(Exception $e){
            $response = [
                'message' => 'asd',
                'status' => false,
            ];
            Log::info($e->getMessage());
            return $response;
        }
    }


    public function delete($id)
    {
        $item = Coupons::find($id);
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


    public function operation($request)
    {
        $id = $request->get('id');
        $operation = $request->get('operation');

        $item = Coupons::find($id);
        if ($item) {
            if ($operation == 'active') {
                $item->is_active = !$item->is_active;
                $item->update();
            }


            $message = 'تمت العملية بنجاح';
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

    public function saveMarketers($coupon_id, $marketer_ids)
    {
        CouponMarketers::where('coupon_id', $coupon_id)
        ->where('add_by', CouponMarketers::MANUALLY)
        ->delete();
        if(is_array($marketer_ids)) {
            foreach($marketer_ids as $marketer_id) {
                CouponMarketers::create([
                    'user_id'=>$marketer_id,
                    'coupon_id'=>$coupon_id,
                    'add_by'=>CouponMarketers::MANUALLY
                ]);
            }
        }
        return true;
    }
}
