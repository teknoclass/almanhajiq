<?php

namespace App\Repositories\Front\User;

use App\Models\Balances;
use App\Models\Notifications;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Packages;
use App\Models\UserPackages;
use App\Models\Transactios;
use Illuminate\Database\Eloquent\Builder;

class PackagesEloquent extends HelperEloquent
{

    public function index($is_web=true , $is_paid_only = false)
    {

        $data['user'] = $this->getUser($is_web);

        $packages = UserPackages::where('user_id', $data['user']->id)
        ->when($is_paid_only , function($package){
            $package->whereHas('transaction' , function($payment){
                $payment->where('is_paid' , 1);
            });
        })
        ->with(['package', 'package.translations']);

        $data['userPackages'] = $packages->paginate(10);

        $data['packages'] = Packages::with(['translations'])->get();

        return $data;
    }

    public function book($request, $id, $is_web=true)
    {
        if (checkUser('lecturer')) {
            $message = __("As_a_teacher_you_cant_register_in_the_package");
            $status = false;
            $response = [
                'message' => $message,
                'status' => $status,
            ];
            return $response;
        }
        $user = $this->getUser($is_web);
        $data['user'] = $user;

        $package = Packages::find($id);

        // only 1 free
        if(!$package->price){
            // check if this user subscribed before
            if($package->user_packages()->paid()->where('user_id' , $user->id)->count()){
                $response = [
                    'message'      => __("You cann`t subscribe more than 1 free package."),
                    'status'       => false,
                ];
                return $response;
            }
        }
        if ($package) {

            $UserPackages = UserPackages::create([
                'user_id'    => $data['user']->id,
                'package_id' => $package->id,
                'price'      => $package->price,
                'num_hours'  => $package->num_hours
            ]);

            //Add student hours balance
            $data['user']->hours_balance += $package->num_hours;
            $data['user']->save();

            // save Transactios
            $params_transactios=[
                'description'            => " الاشتراك بالباقة " . $package->title,
                'user_id'                => $data['user']->id,
                'user_type'              => Transactios::LECTURER,
                'payment_id'             => uniqid(),
                'amount'                 => $package->price,
                'amount_before_discount' => $package->price,
                'type'                   => Transactios::DEPOSIT,
                'transactionable_id'     => $UserPackages->id, // UserPackages not package
                'transactionable_type'   => get_class($UserPackages),
                'coupon'                 => '',
                'is_paid'                => $package->price ? 0 : 1,
            ];

            $transaction = $this->saveTransactios($params_transactios);

            $message =__('message_done');
            $status = true;
            $response = [
                'message'      => $message,
                'status'       => $status,
            ];
            if($package->price){
                $response['redirect_url'] = route('user.payment.checkout' , $transaction->id);
            }
            return $response;
        }

        $message =__('message_error');
        $status = false;

        $response = [
            'message' => $message,
            'status' => $status,
        ];

        return $response;
    }

    public function joinMeeting($id, $is_web=true)
    {
        $data['user'] = $this->getUser($is_web);


        $session = Packages::where('id', $id)
        ->whereNotNull('meeting_link')->first();

        if ($session=='') {
            abort(404);
        }

        $meeting_id = 'meeting_id_'.$id;

        $url=
            \Bigbluebutton::join([
                'meetingID' => $meeting_id,
                'userName' => auth()->user()->name,
                'role'=>'VIEWER',
                'password' => 'attendee' //which user role want to join set password here
            ]);


        $data['url']=$url;
        $data['status']=true;

        return $data;

    }


    public function saveTransactios(array $params)
    {
        return Transactios::create([
            'description'            => $params['description'],
            'user_id'                => $params['user_id'],
            'user_type'              => $params['user_type'],
            'payment_id'             => $params['payment_id'],
            'amount'                 => $params['amount'],
            'amount_before_discount' => $params['amount_before_discount'],
            'type'                   => $params['type'],
            'transactionable_id'     => $params['transactionable_id'],
            'transactionable_type'   => $params['transactionable_type'],
            'coupon'                 => isset($params['coupon']) ? $params['coupon'] : '',
            'is_paid'                => @$params['is_paid'],
        ]);
    }

    public function addBalance(array $params)
    {
        Balances::create([
            'description'=>$params['description'],
            'user_id'=>$params['user_id'],
            'user_type'=>$params['user_type'],
            'type'=>Balances::DEPOSIT,
            'transaction_id'=>$params['transaction_id'],
            'transaction_type'=>$params['transaction_type'],
            'amount'=>$params['amount'],
            'system_commission'=>$params['system_commission'],
            'amount_before_commission'=>$params['amount_before_commission'],
            'becomes_retractable_at'=>$params['becomes_retractable_at'],
            'is_retractable'=>$params['is_retractable'],

        ]);

        // Run Job to change its state to make it draggable

        return true;
    }
}
