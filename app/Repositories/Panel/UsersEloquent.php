<?php

namespace App\Repositories\Panel;

use App\Http\Resources\UsersResources;
use App\Imports\ImportStudents;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;
use App\Http\Requests\Panel\UsersRequest;

class UsersEloquent
{
    public function getDataTable()
    {
        $data = User::orderByDesc('created_at')
                    ->select(
                        'id',
                        'name',
                        'email',
                        'is_block',
                        'is_validation',
                        'role',
                        DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as date')
                    )
                    ->whereNull('deleted_at');

        return Datatables::of($data)
                         ->addIndexColumn()
                         ->filter(function($query) {
                             $keyword = request()->get('search')['value'];

                             if ($keyword) {

                                 $query->where(function($query) use ($keyword) {
                                     $query->where('name', 'LIKE', "%{$keyword}%")
                                           ->orWhere('email', 'LIKE', "%{$keyword}%")
                                           ->orWhere('role', 'LIKE', "%{$keyword}%")
                                           ->orWhere('role', 'LIKE', "%{$keyword}%")
                                           ->orWhere(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d ")'), 'LIKE', "%{$keyword}%");
                                 });
                             }
                         })
                         ->filterColumn('role', function($query, $keyword) {
                             return $query->where('role', $keyword);
                         })
                         ->addColumn('role', function($row) {
                             $roles = [
                                 'student' => ['title' => 'طالب', 'class' => 'badge bg-success role-badge badge-custom'],
                                 'lecturer' => ['title' => 'محاضر', 'class' => 'badge bg-primary role-badge badge-custom'],
                                 'marketer' => ['title' => 'مسوق', 'class' => 'badge bg-warning role-badge badge-custom'],
                                 'parent' => ['title' => 'ولى أمر', 'class' => 'badge bg-warning role-badge badge-custom'],
                             ];

                             return '<span class="label font-weight-bold label-lg ' . $roles[$row->role]['class'] . ' label-inline">' . $roles[$row->role]['title'] . '</span>';
                         })
                         ->addColumn('action', "panel.users.partials.actions")
                         ->rawColumns(['role', 'is_block', 'is_validation', 'action'])
                         ->orderColumns(['name', 'email', 'role'], '-:column $1')
                         ->make(true);
    }

    //    public function getDataTableMarketers()
    //    {
    //
    //        $data = User::orderByDesc('created_at')
    //            ->select(
    //                'users.id',
    //                'users.name',
    //                'users.email',
    //                'users.is_block',
    //                'users.is_validation',
    //                'users.role',
    //                DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d ") as date'))
    //            ->where('role', User::MARKETER)
    //            ->get();
    //
    //        return Datatables::of($data)
    //            ->addIndexColumn()
    //            ->addColumn('action', 'panel.users.partials.actions')
    //            ->rawColumns(['action'])
    //            ->make(true);
    //    }
    //
    //    public function getDataTableLecturers()
    //    {
    //
    //        $data = User::orderByDesc('created_at')
    //            ->select(
    //                'users.id',
    //                'users.name',
    //                'users.email',
    //                'users.is_block',
    //                'users.is_validation',
    //                'users.role',
    //                DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d ") as date'))
    //            ->where('role', User::LECTURER)
    //            ->get();
    //        return Datatables::of($data)
    //            ->addIndexColumn()
    //            ->addColumn('action', 'panel.users.partials.actions')
    //            ->rawColumns(['action'])
    //            ->make(true);
    //    }
    //
    //    public function getDataTableStudents()
    //    {
    //
    //        $data = User::orderByDesc('created_at')
    //            ->select(
    //                'users.id',
    //                'users.name',
    //                'users.email',
    //                'users.is_block',
    //                'users.is_validation',
    //                'users.role',
    //                DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d ") as date'))
    //            ->where('role', User::STUDENTS)
    //            ->get();
    //        return Datatables::of($data)
    //            ->addIndexColumn()
    //            ->addColumn('action', 'panel.users.partials.actions')
    //            ->rawColumns(['action'])
    //            ->make(true);
    //    }

    public function store(UsersRequest $request)
    {
        DB::beginTransaction();
        try
        {
            $data                  = $request->all();
            $data['password_c']    = $request->get('password');
            $data['password']      = bcrypt($request->get('password'));
            $data['is_validation'] = 1;
            $data['add_by']        = User::ADD_BY_ADMIN;
            $data['image']         = $request->get('image') ? $request->get('image') : 'avatar.png';

            $user = User::updateOrCreate(['id' => 0], $data);

            sendEmail(__('login'),__('email').": ".$request->email." ".__('password').": ".$request->password,$request->email);

            if ($request->file('id_image')) {
                //path
                $custome_path   = 'users/' . $user->id . '/id_image';
                $id_image       = $custome_path . '/' . uploadFile($request->file('id_image'), $custome_path);
                $user->id_image = str_replace('/', '-', $id_image);
                $user->update();
            }

            if ($request->file('job_proof_image')) {
                //path
                $custome_path          = 'users/' . $user->id . '/job_proof_image';
                $job_proof_image       = $custome_path . '/' . uploadFile($request->file('job_proof_image'), $custome_path);
                $user->job_proof_image = str_replace('/', '-', $job_proof_image);
                $user->update();

            }

            if ($request->file('cv_file')) {
                //path
                $custome_path  = 'users/' . $user->id . '/cv_file';
                $cv_file       = $custome_path . '/' . uploadFile($request->file('cv_file'), $custome_path);
                $user->cv_file = str_replace('/', '-', $cv_file);
                $user->update();

            }


            $message = __('message_done');
            $status  = true;

            $response = [
                'message' => $message,
                'status' => $status,
            ];

            DB::commit(); 

            return $response;

        } catch (\Exception $e)
        {
            DB::rollback(); 
            $response = [
                'message' => $e->getMessage(),
                'status' => false,
            ];

           return $response;
        }
    }

    public function update($id, UsersRequest $request)
    {
        $data = $request->all();
        if (filled($data['password'])) {
            $data['password_c'] = $request->get('password');
            $data['password']   = bcrypt($request->get('password'));
        }
        else {
            unset($data['password']);
        }

        if ($request->file('id_image')) {
            //path
            $custome_path     = 'users/' . $id . '/id_image';
            $id_image         = $custome_path . '/' . uploadFile($request->file('id_image'), $custome_path);
            $data['id_image'] = str_replace('/', '-', $id_image);
        }

        if ($request->file('job_proof_image')) {
            //path
            $custome_path            = 'users/' . $id . '/job_proof_image';
            $job_proof_image         = $custome_path . '/' . uploadFile($request->file('job_proof_image'), $custome_path);
            $data['job_proof_image'] = str_replace('/', '-', $job_proof_image);
        }

        if ($request->file('cv_file')) {
            //path
            $custome_path    = 'users/' . $id . '/cv_file';
            $cv_file         = $custome_path . '/' . uploadFile($request->file('cv_file'), $custome_path);
            $data['cv_file'] = str_replace('/', '-', $cv_file);
        }

        $data['can_add_half_hour'] = isset($data['can_add_half_hour']) ? $data['can_add_half_hour'] : false;

        User::updateOrCreate(['id' => $id], $data);

        $message = __('message_done');
        $status  = true;

        $response = [
            'message' => $message,
            'status' => $status,
        ];

        return $response;
    }

    public function edit($id)
    {
        $data = $this->create();

        $data['item'] = User::where('id', $id)->first();
        if ($data['item'] == '') {
            abort(404);
        }


        return $data;
    }

    public function create()
    {
        $countries = Category::query()
                             ->select('id', 'value', 'parent')
                             ->with('translations:category_id,name,locale')
                             ->where('parent', 'countries')
                             ->get()
                             ->sortBy(function ($country) {
                                 return $country->translations->first()->name; // Assuming `name` is the translated field
                             });

        $data['countries'] = $countries;

        $data['levels'] = Category::query()->select('id', 'value', 'parent')
                                  ->with('translations:category_id,name,locale')
                                  ->where('parent', 'competition_levels')
                                  ->orderByDesc('created_at')->get();

        $data['majors'] = Category::query()->select('id', 'value', 'parent')
                                  ->with('translations:category_id,name,locale')
                                  ->where('parent', 'lecturers_majors')
                                  ->orderByDesc('created_at')->get();

        // materials
        $parent = Category::select('id', 'value', 'parent', 'key')->where('key', "joining_course")->first();
        $data['materials'] = Category::query()->select('id', 'value', 'parent', 'key')->where('parent', $parent->key)
        ->orderByDesc('created_at')->with(['translations:category_id,name,locale', 'parent'])->get();

        $data['languages'] = Category::getCategoriesByParent('course_languages')->get();

        return $data;
    }

    public function delete($id)
    {
        $item = User::find($id);
        if ($item) {
            if ($item->join_request) {
                $item->join_request()->update(['status' => 'unacceptable']);
            }
            if ($item->join_request_marketer) {
                $item->join_request_marketer()->update(['status' => 'unacceptable']);
            }
            $item->update(['email' => $item->id . '-' . $item->email]);
            $item->delete();
            $message  = __('delete_done');
            $status   = true;
            $response = [
                'message' => $message,
                'status' => $status,
            ];

            return $response;
        }
        $message = __('message_error');
        $status  = false;

        $response = [
            'message' => $message,
            'status' => $status,
        ];

        return $response;
    }


    public function operation($request)
    {
        $id        = $request->get('id');
        $operation = $request->get('operation');

        $item = User::find($id);
        if ($item) {
            if ($operation == 'block') {
                $item->is_block = !$item->is_block;
                $item->update();
            }

            if ($operation == 'validation') {
                $item->is_validation = !$item->is_validation;
                $item->update();
            }

            if ($operation == 'accredited') {
                $item->is_accredited = !$item->is_accredited;
                $item->update();
            }

            $message  = __('message_done');
            $status   = true;
            $response = [
                'message' => $message,
                'status' => $status,
            ];

            return $response;
        }

        $message  = __('message_error');
        $status   = false;
        $response = [
            'message' => $message,
            'status' => $status,
        ];

        return $response;
    }


    public function exportExcel($request)
    {
        $data_after_import = false;
        $colspan           = 6;
        if ($request->get('data_after_import')) {
            $data_after_import = true;
            $colspan           = 5;
        }
        $items = User::orderByDesc('created_at')
                     ->select('users.*', DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d ") as date'));

        $items = $items->filter($request->all());

        $items = $items->get();


        $i     = 1;
        $table = chr(239) . chr(187) . chr(191);
        $table .= '<table border="1">
        <thead>
        <tr style="text-align: center;font-size:16px;"><th colspan="' . $colspan . '" style="background-color:#eee;">المستخدمين
        </th></tr>
        <tr style="font-size:16px;text-align: center;" >
            <th >#</th>
            <th >الاسم</th>
            <th >الايميل</th>';
        if ($data_after_import) {
            $table .= "<th >كلمة المرور</th>";
        }
        else {
            $table .= "<th >رقم الجوال </th>
                        <th> نوع الحساب </th>
            ";
        }
        $table .= "<th >تاريخ التسجيل </th>";
        $table .= '</tr>
        </thead>
        <tbody>';

        if (count($items) > 0) {
            foreach ($items as $item) {
                $row = "<tr style='font-size:16px;text-align: center;'>" .
                    "<td >" . $item->id . "</td>" .
                    "<td >" . $item->name . "</td>" .
                    "<td >" . $item->email . "</td>";
                if ($data_after_import) {
                    $row .= "<td >" . $item->password_c . "</td>";
                }
                else {
                    $row .= "<td >" . $item->mobile . "</td>";
                    $row .= "<td >" . __($item->role) . "</td>";
                }
                $row .= "<td >" . $item->date . "</td>";
                $row .= "</tr>";
                ++$i;
                $table .= $row;
            }
        }
        else {
            $table .= '<tr style="text-align: center;font-size:16px;"><th colspan="' . $colspan . '" style="background-color:#eee;">لا يوجد بيانات </th></tr>';
        }

        $table = $table . '</tbody></table>';

        return response($table)->withHeaders(["Content-Type" => 'application/vnd.ms-excel', "Content-Disposition" => 'attachment; filename="users_' . date('d_m_Y') . '.xls"']);

    }

    public function searchStudents($request)
    {
        $search = $request->get('search');

        $users = User::select('id', 'name', 'email')->where(function(Builder $query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
        })->where('role', User::STUDENTS)->take(10)->get();


        $items = UsersResources::collection($users);

        $response = ['status' => true, 'message' => 'done', 'items' => $items];


        return response()->json($response);
    }

    public function searchLecturers($request)
    {
        $search = $request->get('search');

        $users = User::select('id', 'name', 'email')->where(function(Builder $query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
        })->where('role', User::LECTURER)->take(10)->get();


        $items = UsersResources::collection($users);

        $response = ['status' => true, 'message' => 'done', 'items' => $items];

        return response()->json($response);
    }

    public function searchMarketers($request)
    {
        $search = $request->get('search');

        $users = User::select('id', 'name', 'email')->where(function(Builder $query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
        })->where('role', User::MARKETER)->take(10)->get();

        $items = UsersResources::collection($users);

        $response = ['status' => true, 'message' => 'done', 'items' => $items];

        return response()->json($response);
    }


    public function getAllByRole($role)
    {
        $users = User::active()->where('role', $role)
            // ->whereHas('userRoles', function (Builder $query) use ($role) {
            //     $query->where('role', $role);
            // })
                     ->orderBy('id', 'desc')->get();

        return $users;
    }

    public function getAllRoles(): \Illuminate\Support\Collection
    {
        return DB::table('user_roles')
                 ->select('role')
                 ->distinct()
                 ->get();
    }

}
