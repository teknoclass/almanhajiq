<?php

namespace App\Repositories\Panel;
;

use App\Http\Requests\Panel\MessageRequest;
use App\Mail\ReplayMail;
use App\Models\Setting;
use App\Models\VisitorMessage;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\DataTables;

class InboxEloquent
{

    public function getDataTable()
    {
        $data = VisitorMessage::select('visitor_messages.id', 'visitor_messages.name',
            'visitor_messages.subject', 'visitor_messages.text',
            \DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as date'))
                              ->orderByDesc('created_at');

        return Datatables::of($data)
                         ->addIndexColumn()
                         ->filter(function($query) {
                             $keyword = request()->get('search')['value'];

                             if ($keyword) {

                                 $query->where(function($query) use ($keyword) {
                                     $query->where('subject', 'LIKE', "%{$keyword}%")
                                           ->orWhere('text', 'LIKE', "%{$keyword}%")
                                           ->orWhere(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d ")'), 'LIKE', "%{$keyword}%");
                                 });
                             }
                         })
                         ->addColumn('name', function($row) {
                             $path = url('admin/inbox/view') . '/' . $row->id;
                             if ($row->read_at != '' && $row->read_at != null) {
                                 return '<a href="' . $path . '">' . $row->name . '</a>';
                             }

                             return '<a href="' . $path . '"><b>' . $row->name . '</b></a>';
                         })
                         ->addColumn('action', 'panel.inbox.partials.actions')
                         ->addColumn('text', function($row) {
                             $truncatedText = strlen($row->text) > 50 ? substr($row->text, 0, 50) . '...' : $row->text;

                             return $truncatedText;
                         })
                         ->rawColumns(['name','action', 'text'])
                         ->make(true);
    }

    public function view($id)
    {
        $data['item'] = VisitorMessage::find($id);
        if (isset($data['item'])) {
            $data['item']->update(['read_at' => Carbon::now()]);
        }
        else {
            abort(404);
        }

        return $data;
    }


    public function delete($id)
    {
        $item = VisitorMessage::find($id);
        if ($item) {
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

    public function replay($id, MessageRequest $request)
    {
        DB::beginTransaction();
        try {

            $message = VisitorMessage::find($id);
            $setting = new Setting();
            $title   = 'رد على رسالتك من ' . $setting->valueOf('title_ar');
            Mail::to($message->email)->send(new  ReplayMail($title, $request->text, $message->email));

            $message->replay($request);

            DB::commit();
            $message = __('message_done');
            $status  = true;
        } catch (\Exception $e) {
            $message = __('message_error');
            $status  = false;
            DB::rollback();
        }

        $response = [
            'message' => $message,
            'status' => $status,
        ];

        return $response;
    }
}
