<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\ContactUsRequest;
use App\Repositories\Front\ContactUsEloquent;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    //
    private $contact;
    public function __construct(ContactUsEloquent $contact_eloquent)
    {

        $this->contact = $contact_eloquent;
    }

    public function index()
    {
        return view('front.contact.index');
    }

    public function store(ContactUsRequest $request)
    {

        $response = $this->contact->store($request);

        return $this->response_api($response['status'], $response['message']);
    }
}
