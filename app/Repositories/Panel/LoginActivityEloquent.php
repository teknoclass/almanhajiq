<?php

namespace App\Repositories\Panel;

use App\Models\LoginActivity;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class LoginActivityEloquent
{
    public function getDataTable()
    {
        $data = LoginActivity::select('login_activities.*', 'users.name as user_name', 'users.role as role',
            \DB::raw('DATE_FORMAT(login_activities.created_at, "%h:%i %Y-%m-%d") as date'))
                             ->join('users', 'login_activities.user_id', '=', 'users.id')
                             ->where('login_activities.user_type', LoginActivity::USER_TYPE_USER)
                             ->orderByDesc('login_activities.created_at');

        return Datatables::of($data)
                         ->addIndexColumn()
                         ->addColumn('role', function($row) {
                             $roles = [
                                 'student' => ['title' => 'طالب', 'class' => 'badge bg-success role-badge badge-custom'],
                                 'lecturer' => ['title' => 'محاضر', 'class' => 'badge bg-primary role-badge badge-custom'],
                                 'marketer' => ['title' => 'مسوق', 'class' => 'badge bg-warning role-badge badge-custom']
                             ];

                             return '<span class="label font-weight-bold label-lg ' . $roles[$row->role]['class'] . ' label-inline">' . $roles[$row->role]['title'] . '</span>';
                         })
                         ->filterColumn('role', function($query, $keyword) {
                             return $query->where('role', $keyword);
                         })
                         ->filter(function($query) {
                             $keyword = request()->get('search')['value'];

                             if ($keyword) {
                                 $query->where(function($query) use ($keyword) {
                                     $query->where('users.name', 'LIKE', "%{$keyword}%")
                                           ->where('users.role', 'LIKE', "%{$keyword}%")
                                           ->orWhere('login_activities.type', 'LIKE', "%{$keyword}%")
                                           ->orWhere('login_activities.ip_address', 'LIKE', "%{$keyword}%")
                                           ->orWhere('login_activities.user_agent', 'LIKE', "%{$keyword}%")
                                           ->orWhere(DB::raw('DATE_FORMAT(login_activities.created_at, "%Y-%m-%d")'), 'LIKE', "%{$keyword}%");
                                 });
                             }
                         })
                         ->rawColumns(['role'])
                         ->make(true);

    }
}
