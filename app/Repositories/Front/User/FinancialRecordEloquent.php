<?php

namespace App\Repositories\Front\User;

use App\Repositories\Front\User\HelperEloquent;
use Illuminate\Support\Facades\DB;
use App\Models\Balances;
use App\Models\WithdrawalRequests;

class FinancialRecordEloquent extends HelperEloquent
{
    public function all($user_type, $is_web=true)
    {
        $data['user'] = $this->getUser($is_web);

        $data['available_balance'] = $this->getAvailableBalances($data['user']->id, $user_type);


        //suspended_balance
        $data['suspended_balance'] = abs(
            (Balances::select('user_id', 'type', 'amount')->where('user_id', $data['user']->id)->where('type', 'deposit')
            ->whereRaw(("case WHEN becomes_retractable_at IS  NOT NULL THEN becomes_retractable_at > now()  END"))
            ->where('user_type', $user_type)
            ->sum('amount'))

        );

        //retractable_balance
        $data['retractable_balance'] =
        $this->getRetractableBalance($data['user']->id, $user_type);


        $data['balance_transactions'] = Balances::select('id', 'description', 'user_id', 'transaction_id', 'transaction_type', 'amount', 'type', 'created_at')
        ->orderBy('id', 'desc')
        ->where('user_id', $data['user']->id)
        ->where('user_type', $user_type)
        ->paginate(10);

        $data['last_withdrawal_request'] = WithdrawalRequests::select(
            'id',
            'user_id',
            'withdrawal_method',
            'amount',
            'details',
            'status',
            'created_at'
        )->where('user_id', $data['user']->id)
        ->whereIn('status', [WithdrawalRequests::PENDING,WithdrawalRequests::UNDERWAY])
        ->where('user_type', $user_type)
        ->orderBy('id', 'desc')->first();



        return $data;
    }

    public function cancelRequest($request, $user_type, $is_web=true)
    {
        $data['user'] = $this->getUser($is_web);

        $withdrawal_request = WithdrawalRequests::where([
            ['user_id', $data['user']->id],
            ['user_type',$user_type]
        ])
        ->whereIn('status', [WithdrawalRequests::PENDING,WithdrawalRequests::UNDERWAY])
        ->first();

        if ($withdrawal_request) {
            $withdrawal_request->update([
               'status'=> WithdrawalRequests::CANCELED
            ]);

            $message = __('message.operation_accomplished_successfully');
            $status = true;

            $response = [
                'message' => $message,
                'status' => $status,
            ];
        } else {
            $message = __('message.unexpected_error');
            $status = false;
            $response = [
                'message' => $message,
                'status' => $status,
            ];
        }

        return $response;
    }


    public function storeRequest($request, $user_type, $is_web=true)
    {
        $data['user'] = $this->getUser($is_web);

        $withdrawal_request = WithdrawalRequests::where([
            ['user_id', $data['user']->id],
            ['user_type',$user_type]
            ])
            ->whereIn('status', [WithdrawalRequests::PENDING,WithdrawalRequests::UNDERWAY])
            ->first();

        if ($withdrawal_request) {
            $message = __('message.unexpected_error');
            $status = false;
            $response = [
                'message' => $message,
                'status' => $status,
            ];
            return $response;
        }

        //check available points
        $retractable_balance = $this->getRetractableBalance($data['user']->id, $user_type);
        if ($request->amount > $retractable_balance) {
            $message = __('message.your_balance_is_not_enough');
            $status = false;
            $response = [
                'message' => $message,
                'status' => $status,
            ];
            return $response;
        }

        //minimum_withdrawal_balances
        $minimum_withdrawal_balances=getSeting('minimum_withdrawal_balances');
        if ($request->amount < $minimum_withdrawal_balances) {
            $message = __('message.can_not_withdraw_less_than') .' '.$minimum_withdrawal_balances ;
            $status = false;
            $response = [
                'message' => $message,
                'status' => $status,
            ];
            return $response;
        }


        DB::beginTransaction();

        try {
            $request['user_id']=$data['user']->id;
            $request['user_type']=$user_type;

            $item=WithdrawalRequests::updateOrCreate(['id' => 0], $request->all());



            //sendNotification
            $name_user=$data['user']->name;
            $title = 'طلبات سحب الارباح ';
            $text = "طلب  جديد من  $name_user";
            $action_type='withdrawal_requests';
            $action_data=$item->id;
            $permation='show_withdrawal_requests';
            $user_type='admin';
            sendNotifications($title, $text, $action_type, $action_data, $permation, $user_type);


            $message = __('message.operation_accomplished_successfully');
            $status = true;

            $response = [
                'message' => $message,
                'status' => $status,
            ];

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $message = __('message.unexpected_error');
            $status = false;
            $response = [
                'message' => $message,
                'status' => $status,
            ];
        }


        return $response;
    }

    public function getAvailableBalances($user_id, $user_type)
    {
        $available_balances=

          abs(
              (Balances::select('user_id', 'type', 'amount')->where('user_id', $user_id)
              ->where('type', 'deposit')
              ->where('user_type', $user_type)
              ->sum('amount'))
                  -
                  (Balances::select('user_id', 'type', 'amount')
                  ->where('user_id', $user_id)
                  ->where('type', 'withdrow')
                  ->where('user_type', $user_type)
                  ->sum('amount'))
          );

        return $available_balances;
    }

    public function getRetractableBalance($user_id, $user_type)
    {

        $retractable_balance=abs(
            (Balances::select('user_id', 'type', 'amount')->where('user_id', $user_id)
            ->where('type', 'deposit')
            ->where('user_type', $user_type)
            ->whereRaw(("case WHEN becomes_retractable_at IS  NOT NULL THEN becomes_retractable_at < now()  END"))
            ->sum('amount'))
                -
                (Balances::select('user_id', 'type', 'amount')
                ->where('user_id', $user_id)->where('type', 'withdrow')
                ->where('user_type', $user_type)
                ->sum('amount'))
        );

        return $retractable_balance;


    }
}
