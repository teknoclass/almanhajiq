<?php

namespace App\Repositories\Panel;

use App\Models\MarketersTemplates;
use App\Models\MarketersTemplatesTexts;
use Illuminate\Support\Facades\DB;

class MarketersTemplatesEloquent
{
    public function index()
    {
        return [];
    }

    public function getDataTable()
    {
        $items = MarketersTemplates::orderByDesc('created_at');

        return filterData($items);
    }

    public function create()
    {
        $data = $this->index();

        return $data;
    }

    public function store($request)
    {
        DB::beginTransaction();

        try {

            //


            $template=MarketersTemplates::updateOrCreate(['id' => 0], $request->all());

            $this->saveTexts($template->id, $request);


            $message = 'تمت العملية بنجاح';
            $status = true;

            $response = [
                'message' => $message,
                'status' => $status,
            ];

            DB::commit();
        } catch (\Exception $e) {
            $message = ' حدث خطأ غير متوقع';
            $status = false;

            $response = [
                'message' => $message,
                'status' => $status,
            ];

            DB::rollback();
        }


            return $response;
    }

    public function edit($id)
    {
        $data = $this->create();
        $data['item'] = MarketersTemplates::where([
            ['id', $id]
            ])->first();
        if ($data['item'] == '') {
            abort(404);
        }

        return $data;
    }

    public function update($id, $request)
    {
        DB::beginTransaction();

        try {


            MarketersTemplates::updateOrCreate(['id' => $id], $request->all());

            $this->saveTexts($id, $request);

            $message = 'تمت العملية بنجاح';
            $status = true;

            $response = [
                'message' => $message,
                'status' => $status,
            ];

            DB::commit();
        } catch (\Exception $e) {
            $message = ' حدث خطأ غير متوقع';
            $status = false;
            $response = [
                'message' => $message,
                'status' => $status,
            ];
            DB::rollback();
        }

            return $response;
    }

    public function saveTexts($marketers_template_id, $request)
    {
        MarketersTemplatesTexts::where('marketers_template_id', $marketers_template_id)->delete();

        $template_texts=json_decode($request->get('template_texts'));
        foreach ($template_texts as $template_text) {
            MarketersTemplatesTexts::create([
                'marketers_template_id'=>$marketers_template_id,
                'text'=>$template_text->text,
                'coordinates'=>json_encode($template_text->position),
                'font_size_css'=>$template_text->font_size,
                'font_color_css'=>$template_text->font_color,
                'transform_css'=>$template_text->transform,
                'type'=>$template_text->type??MarketersTemplatesTexts::OTHERS,

            ]);
        }

        return;
    }


    public function delete($id)
    {
        $item = MarketersTemplates::where([
            ['id', $id]
        ]);

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

        $item = MarketersTemplates::where([
            ['id', $id]
        ])->first();

        if ($item) {
            if($operation=='active') {
                $item->is_active = !@$item->is_active;
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
}
