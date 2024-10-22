<?php

namespace App\Repositories\Panel;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\WithdrawalRequests;
use App\Models\Balances;
use App\Models\LecturerSetting;
use DataTables;

class WithdrawalRequestsEloquent
{
    public function getDataTable()
    {


        $data = WithdrawalRequests::orderByDesc('created_at')->with(['user:id,name'])
        ->select('withdrawal_requests.*', \DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d ") as date'))->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', 'panel.withdrawal_requests.partials.actions')
            ->rawColumns(['action'])
            ->make(true);
    }

    public function view($id)
    {
        $data['item'] = WithdrawalRequests::orderByDesc('created_at')->with(['user:id,name'])
            ->select('withdrawal_requests.*', \DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d ") as date'))
            ->where('id', $id)->first();

        $data['user_details'] = LecturerSetting::where('user_id', $data['item']->user_id)
            ->select('id', 'bank_id', 'account_num', 'name_in_bank', 'iban')->first();

        if ($data['item']=='') {
            abort(404);
        }
        return $data;
    }

    public function update($id, $request)
    {
        DB::beginTransaction();

        try {
            $data=$request->all();
            $status=$request->get('status');
            $item=WithdrawalRequests::find($id);
            if (!in_array($item->status, ['pending','underway'])) {
                $message = __('message_error');
                $status = false;

                $response = [
                    'message' => $message,
                    'status' => $status,
                ];
                return $response;
            }
            if ($item->status!=$status) {
                if ($status==WithdrawalRequests::COMPLETED) {
                    Balances::create([
                        'description'=>'withdrawal_of_profits',
                        'user_id'=>$item->user_id,
                        'user_type'=>$item->user_type,
                        'transaction_id'=>$id,
                        'transaction_type'=>'withdrawal_requests',
                        'amount'=>$item->amount,
                        'type'=>Balances::WITHDROW
                    ]);
                }
            }

            WithdrawalRequests::updateOrCreate(['id' => $id], $data);

            //sendNotification
            $title = 'طلبات سحب الارباح ';
            $status_name = "";
            if($status==WithdrawalRequests::UNACCEPRABEL) {
                $status_name = "تم رفض طلبك";
            } elseif($status==WithdrawalRequests::UNDERWAY) {
                $status_name = "طلبك اصبح قيد المراجعة";
            } elseif($status==WithdrawalRequests::COMPLETED) {
                $status_name = "تم قبول طلبك";
            }

            $text = $status_name;
            $action_type='withdrawal_requests';
            $action_data=$id;
            $permation='';
            $user_type='user';
            $user_ids[]  =$item->user_id;
          //  sendNotifications($title, $text, $action_type, $action_data, $permation, $user_type, $user_ids);


            DB::commit();


            $message = __('message_done');
            $status = true;

            $response = [
                'message' => $message,
                'status' => $status,
            ];

            return $response;
      } catch(\Exception $e) {
            DB::rollback();
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
