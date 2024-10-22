<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Panel\CertificateTemplatesRequest;
use App\Repositories\Panel\CertificateTemplatesEloquent;

class CertificateTemplatesController extends Controller
{
    private CertificateTemplatesEloquent $certificate_templates;
    public function __construct(CertificateTemplatesEloquent $certificate_templates_eloquent)
    {
        $this->middleware('auth:admin');

        $this->certificate_templates = $certificate_templates_eloquent;
    }


    public function index(Request $request)
    {

        return view('panel.certificate_templates.all');
    }


    public function getDataTable()
    {
        return $this->certificate_templates->getDataTable();
    }

    public function create()
    {

        $data = $this->certificate_templates->create();

        return view('panel.certificate_templates.create', $data);
    }

    public function store(CertificateTemplatesRequest $request)
    {


        $response = $this->certificate_templates->store($request);

        return $this->response_api($response['status'], $response['message']);
    }

    public function edit($id)
    {

        $data = $this->certificate_templates->edit($id);


        return view('panel.certificate_templates.create', $data);
    }

    public function update($id, CertificateTemplatesRequest $request)
    {
        $response = $this->certificate_templates->update($id, $request);

        return $this->response_api($response['status'], $response['message']);
    }


    public function delete($id)
    {
        $response = $this->certificate_templates->delete($id);
        return $this->response_api($response['status'], $response['message']);
    }

    public function operation(Request $request)
    {

        $response = $this->certificate_templates->operation($request);
        return $this->response_api($response['status'], $response['message']);
    }

    public function certificateTestIssuance($id)
    {
        return $this->certificate_templates->certificateTestIssuance($id);
    }
}
