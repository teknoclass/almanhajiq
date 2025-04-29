<?php

namespace App\Repositories\Panel;

use App\Helper\CouponGenerator;
use App\Jobs\CouponExcelHandle;
use App\Models\CouponMarketers;
use App\Models\Coupons;
use App\Models\Courses;
use App\Models\CoursesCoupon;
use App\Models\Transactios;
use DataTables;
use Exception;
use Illuminate\Support\Facades\Log;

class CouponsEloquent
{
    public function getDataTable()
    {
        $data = Coupons::orderByDesc('created_at')
            ->select('id', 'title', 'code')->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', 'panel.coupons.partials.actions')
            ->rawColumns(['action'])
            ->make(true);
    }
    public function getDataTableGroup()
    {
        $data = Coupons::orderByDesc('created_at')->selectRaw('group_name, COUNT(*) as total_coupons,MIN(id) as id')->whereNotNull('group_name')
            ->groupBy('group_name')
            ->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', 'panel.coupons.partials.actionsGroup')
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

        try {
            $data = $request->all();

            if ($request->expiry_date) {
                $data['expiry_date'] = date('Y-m-d ', strtotime($request->expiry_date));
            }

            $coupon = Coupons::updateOrCreate(['id' => 0], $data);
            if ($request->course_ids) {

                foreach ($request->course_ids as $id) {
                    CoursesCoupon::firstOrCreate([
                        'course_id' => $id,
                        'coupon_id' => $coupon->id
                    ]);
                }
            }
            $marketer_id = $request->marketer_id;
            $check_coupon = CouponMarketers::where('user_id', $marketer_id)
                ->where('coupon_id', '!=', $coupon->id)
                ->first();
            if ($check_coupon) {
                $response = [
                    'message' => 'المسوق له كوبون اخر',
                    'status' => false,
                ];

                return $response;
            }
            if ($marketer_id) {
                CouponMarketers::create([
                    'user_id' => $marketer_id,
                    'coupon_id' => $coupon->id,
                    'add_by' => CouponMarketers::MANUALLY
                ]);
            }


            $message = 'تمت العملية بنجاح';
            $status = true;

            $response = [
                'message' => $message,
                'status' => $status,
            ];

            return $response;
        } catch (Exception $e) {
            Log::info($e->getMessage());
        }
    }
    public function storeMultiple($request)
    {

        try {
            $coupons = array();
            for ($i = 0; $i < $request->number; $i += 1) {

                $data = $request->all();
                $data['code'] = CouponGenerator::generateCoupon();
                $coupons[] = $data['code'];
                if ($request->expiry_date) {
                    $data['expiry_date'] = date('Y-m-d ', strtotime($request->expiry_date));
                }

                $coupon = Coupons::updateOrCreate(['id' => 0], $data);
                if ($request->course_ids) {

                    foreach ($request->course_ids as $id) {
                        CoursesCoupon::firstOrCreate([
                            'course_id' => $id,
                            'coupon_id' => $coupon->id
                        ]);
                    }
                }
                $marketer_id = $request->marketer_id;
                $check_coupon = CouponMarketers::where('user_id', $marketer_id)
                    ->where('coupon_id', '!=', $coupon->id)
                    ->first();
                if ($check_coupon) {
                    $response = [
                        'message' => 'المسوق له كوبون اخر',
                        'status' => false,
                    ];

                    return $response;
                }
                if ($marketer_id) {
                    CouponMarketers::create([
                        'user_id' => $marketer_id,
                        'coupon_id' => $coupon->id,
                        'add_by' => CouponMarketers::MANUALLY
                    ]);
                }
            }


            $message = 'تمت العملية بنجاح';
            $status = true;

            $response = [
                'message' => $message,
                'status' => $status,
            ];

            //CouponExcelHandle::dispatch($coupons);
            return $response;
        } catch (Exception $e) {
            Log::info($e->getMessage());
        }
    }

    public function edit($id)
    {
        $data['item'] = Coupons::where('id', $id)->first();
        if ($data['item'] == '') {
            abort(404);
        }
        $data['couponCourses'] = CoursesCoupon::where('coupon_id', $id)->get();


        return $data;
    }

    public function update($id, $request)
    {
        try {
            $data = $request->all();

            if ($request->expiry_date) {
                $data['expiry_date'] = date('Y-m-d ', strtotime($request->expiry_date));
            }
            if ($request->get('is_group') == 1) {
                $coupon = Coupons::find($id);
                $ids = Coupons::where('group_name', $coupon->group_name)->pluck('id')->toArray();
            } else {
                $ids = [$id];
            }
            foreach ($ids as $id) {

                $coupon = Coupons::updateOrCreate(['id' => $id], $data);


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
                $check_coupon = CouponMarketers::where('user_id', $marketer_id)
                    ->where('coupon_id', '!=', $coupon->id)
                    ->first();
                if ($check_coupon) {
                    continue;
                }



                if ($marketer_id) {

                    CouponMarketers::updateOrCreate([
                        'user_id' => $marketer_id,
                        'coupon_id' => $coupon->id
                    ], [

                        'add_by' => CouponMarketers::MANUALLY
                    ]);
                }
            }

            $message = 'تمت العملية بنجاح';
            $status = true;

            $response = [
                'message' => $message,
                'status' => $status,
            ];

            return $response;
        } catch (Exception $e) {
            $response = [
                'message' => 'asd',
                'status' => false,
            ];
            Log::info($e->getMessage());
            return $response;
        }
    }


    public function delete($id, $request)
    {

        if ($request->get('is_group') == 1) {
            $coupon = Coupons::find($id);
            $ids = Coupons::where('group_name', $coupon->group_name)->pluck('id')->toArray();
        } else {
            $ids = [$id];
        }
        try {

            foreach ($ids as $id) {

                $item = Coupons::find($id);
                if ($item) {
                    $item->delete();
                }
            }
            $message = 'تم الحذف بنجاح  ';
            $status = true;

            $response = [
                'message' => $message,
                'status' => $status,
            ];

            return $response;
        } catch (Exception $e) {
            $message = 'حدث خطأ غير متوقع';
            $status = false;

            $response = [
                'message' => $message,
                'status' => $status,
            ];

            return $response;
        }
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
        if (is_array($marketer_ids)) {
            foreach ($marketer_ids as $marketer_id) {
                CouponMarketers::create([
                    'user_id' => $marketer_id,
                    'coupon_id' => $coupon_id,
                    'add_by' => CouponMarketers::MANUALLY
                ]);
            }
        }
        return true;
    }

    function download()
    {


        $data = Transactios::whereNotNull('coupon')->where('coupon', '!=', "")->where('transactionable_type', Courses::class)->where('status', 'completed')->get();
        $colspan = 5;
        $i = 1;
        $table = chr(239) . chr(187) . chr(191);
        $table .= '<table border="1">
        <thead>
        <tr style="text-align: center;font-size:16px;">
        <th colspan="' . $colspan . '" style="background-color:#eee;">' . __('coupon') . '
        </th></tr>
        <tr style="font-size:16px;text-align: center;" >
            <th >#</th>
            <th > '.__('coupon').' </th>
            <th > '.__('course').' </th>
            <th > '.__('user').' </th>
            <th > '.__('date').' </th>
        </tr>
        </thead>
        <tbody>';

        if (count($data) > 0) {
            foreach ($data as $item) {
                $row = "<tr style='font-size:16px;text-align: center;'>" .
                    "<td >" . $i . "</td>" .
                    "<td >" . $item->coupon . "</td>".
                    "<td >" . @$item->transactionable->title . "</td>".
                    "<td >" . @$item->user->name . "</td>".
                    "<td >" . $item->created_at . "</td>";
                $row .= "</tr>";
                ++$i;
                $table .= $row;
            }
        } else {
            $table .= '<tr style="text-align: center;font-size:16px;"><th colspan="' . $colspan . '" style="background-color:#eee;">' . __('dashboard.no_data') . '</th></tr>';
        }

        $table = $table . '</tbody></table>';

        return $table;
    }
}
