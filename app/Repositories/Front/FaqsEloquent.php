<?php

namespace App\Repositories\Front;
use App\Models\Faqs;

class FaqsEloquent
{

    public function index()
    {
        $data['faqs'] = Faqs::select('id')->where('type', Faqs::GENERAL)
            ->with('translations:faqs_id,title,text,locale')->orderByDesc('created_at')->paginate(10);
        return $data;
    }
}
