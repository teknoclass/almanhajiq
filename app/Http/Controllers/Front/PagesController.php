<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Repositories\Front\PagesEloquent;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    //

    private $pages;
    public function __construct(PagesEloquent $pages_eloquent)
    {

        $this->pages = $pages_eloquent;
    }


    public function single($sulg){

        $data=$this->pages->getPage($sulg);

        return view('front.pages.single',$data);

    }


    public function about(){

        $data=$this->pages->about();

        return view('front.pages.about',$data);

    }
}
