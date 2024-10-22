<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Repositories\Panel\TranslationEloquent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TranslationController extends Controller
{
    //
    private $translation;
    public function __construct(TranslationEloquent $translation_eloquent)
    {
        $this->middleware('auth:admin');

        $this->translation = $translation_eloquent;
    }


    public function index($lang, Request $request)
    {

        $data = $this->translation->index($lang);

        return view('panel.languages.translation', $data);
    }

    public function update($lang, Request $request)
    {
        return $this->translation->updateAjax($request, $lang);
    }

}
