<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Balances;
use App\Repositories\Panel\TransactiosEloquent;
use Illuminate\Http\Request;
use DataTables;
use App\Models\Transactios;

class TransactiosController extends Controller
{
    //

    private $transactios;
    public function __construct(TransactiosEloquent $transactios_eloquent)
    {
        $this->middleware('auth:admin');

        $this->transactios = $transactios_eloquent;
    }

    public function index(Request $request)
    {

        return view('panel.transactios.all');
    }

    public function getDataTable()
    {
        return $this->transactios->getDataTable();
    }

    public function delete($id)
    {
        $response = $this->transactios->delete($id);
        
        return $this->response_api($response['status'], $response['message']);
    }

    public function lecturersProfits()
    {
        return view('panel.lecturers_profits.index');
    }

    public function lecturersProfitsDataTable()
    {
        $balances = Balances::selectRaw("
        user_id,
        SUM(CASE WHEN type = 'deposit' THEN amount ELSE 0 END) AS total_deposit,
        SUM(CASE WHEN type = 'withdrow' THEN amount ELSE 0 END) AS total_withdraw,
        SUM(CASE WHEN type = 'deposit' THEN amount ELSE 0 END) - SUM(CASE WHEN type = 'withdrow' THEN amount ELSE 0 END) AS balance
        ")
        ->whereHas('user')
        ->groupBy('user_id')
        ->orderBy('user_id', 'desc')
        ->get();

        return Datatables::of($balances)
            ->addIndexColumn()
            ->addColumn('lecturer', function ($row) {
                return $row->user->name ?? '-';
            })
            ->addColumn('balance', function ($row) {
                return number_format($row->balance, 2) . " " . __('currency');
            })
            ->addColumn('action', function ($row) {
                return '<button class="btn btn-primary btn-sm show-transactions" data-id="' . $row->user_id . '">'.__('details').'</button>';
            })
            ->filter(function ($query) {
                $search = request()->input('search.value');
                if ($search) {
                    $query->whereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })->orWhereHas('course.translations', function ($q) use ($search) {
                        $q->where('title', 'like', "%{$search}%");
                    });
                }
            })
            ->rawColumns(['action', 'balance', 'lecturer'])
            ->make(true);
    }
    
    public function getLecturerTransactions($id)
    {
        $transactions = Balances::where('user_id', $id)->get(['description', 'amount', 'type', 'created_at']);
        return response()->json($transactions);
    }
    
}
