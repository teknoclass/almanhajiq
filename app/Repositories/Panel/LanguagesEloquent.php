<?php

namespace App\Repositories\Panel;

use App\Models\Languages;
use DataTables;


class LanguagesEloquent
{

    public function getDataTable()
    {

        //$items = Languages::orderByDesc('created_at')->select('id','title','lang');
       // return filterData($items);


        $data = Languages::select('id','title','lang')->orderByDesc('created_at')->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', 'panel.languages.partials.actions')
            ->rawColumns(['action'])
            ->make(true);
    }


    public function store($request)
    {

        $data = $request->all();
        $data['lang'] = strtolower($request->lang);

        if ($request->is_default == 1) {
            Languages::where('is_default', 1)->update([
                'is_default' => 0
            ]);
        }

        Languages::updateOrCreate(['id' => 0], $data);

        $message =__('message_done');
        $status = true;

        $response = [
            'message' => $message,
            'status' => $status,
        ];

        return $response;
    }

    public function edit($id)
    {

        $data['item'] = Languages::where('id', $id)->first();
        if ($data['item'] == '') {
            abort(404);
        }

        return $data;
    }

    public function update($id, $request)
    {
        $data = $request->all();
        $data['lang'] = strtolower($request->lang);

        if ($request->is_default == 1) {
            Languages::where('is_default', 1)->update([
                'is_default' => 0
            ]);
        } else {
            if (Languages::where('is_default', 1)->count()) {
                $message = __('lang_error');
                $status = false;

                $response = [
                    'message' => $message,
                    'status' => $status,
                ];

                return $response;
            }
        }

        Languages::updateOrCreate(['id' => $id], $data);

        $message = __('message_error');
        $status = true;

        $response = [
            'message' => $message,
            'status' => $status,
        ];

        return $response;
    }


    public function delete($id)
    {
        $item = Languages::find($id);
        if ($item) {
            if ($item->can_delete == 1) {
                //is_default
                if ($item->is_default == 1) {
                    Languages::last()->update([
                        'is_default' => 1
                    ]);
                }
                $item->delete();
                $message = __('delete_done');
                $status = true;
                $response = [
                    'message' => $message,
                    'status' => $status,
                ];
                return $response;
            }
            else{
                $message =__('delete_lang_error');
                $status = false;

                $response = [
                    'message' => $message,
                    'status' => $status,
                ];
                return $response;
            }

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
