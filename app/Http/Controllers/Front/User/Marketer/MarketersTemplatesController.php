<?php

namespace App\Http\Controllers\Front\User\Marketer;

use App\Http\Controllers\Controller;
use App\Repositories\Front\User\Marketer\MarketersTemplatesEloquent;
use Illuminate\Http\Request;

class MarketersTemplatesController extends Controller
{
    //

    private $marketers_templates;


    public function __construct(
        MarketersTemplatesEloquent $marketers_templates_eloquent
    ) {
        $this->marketers_templates = $marketers_templates_eloquent;
    }

    public function index(Request $request)
    {
        $data = $this->marketers_templates->all($request);


        return view('front.user.marketer.marketers_templates.index', $data);
    }

    public function download($id)
    {
        return $this->marketers_templates->download($id);

    }

}
