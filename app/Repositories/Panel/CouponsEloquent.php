<?php

namespace App\Repositories\Panel;

use App\Models\CouponMarketers;
use App\Models\Coupons;
use DataTables;

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
        $data = $request->all();

        if ($request->expiry_date) {
            $data['expiry_date'] = date('Y-m-d ', strtotime($request->expiry_date));
        }

        $coupon=Coupons::updateOrCreate(['id' => 0], $data);

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
    
        CouponMarketers::create([
            'user_id'=>$marketer_id,
            'coupon_id'=>$coupon->id,
            'add_by'=>CouponMarketers::MANUALLY
        ]);


        $message = 'تمت العملية بنجاح';
        $status = true;

        $response = [
            'message' => $message,
            'status' => $status,
        ];

        return $response;
    }

    public function edit($id)
    {
        $data['item'] = Coupons::where('id', $id)->first();
        if ($data['item'] == '') {
            abort(404);
        }


        return $data;
    }

    public function update($id, $request)
    {
        $data = $request->all();

        if ($request->expiry_date) {
            $data['expiry_date'] = date('Y-m-d ', strtotime($request->expiry_date));
        }

        $coupon=Coupons::updateOrCreate(['id' => $id], $data);

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
      
        CouponMarketers::updateOrCreate([ 'user_id'=>$marketer_id,
        'coupon_id'=>$coupon->id],[
           
            'add_by'=>CouponMarketers::MANUALLY
        ]);

        $message = 'تمت العملية بنجاح';
        $status = true;

        $response = [
            'message' => $message,
            'status' => $status,
        ];

        return $response;
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
