<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FaqCollection;
use App\Http\Response\ErrorResponse;
use App\Http\Response\SuccessResponse;
use App\Repositories\Front\ContactUsEloquent;
use App\Services\SettingService;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;


class SettingsController extends Controller
{
    public SettingService $settingService;
    private $contact;

    public function __construct(SettingService $settingService,ContactUsEloquent $contactUsEloquent)
    {
        $this->settingService = $settingService;
        $this->contact = $contactUsEloquent;
    }

    public function all()
    {
        $settings = $this->settingService->getAllSettings();

        if (!$settings['status']) {
            $response = new ErrorResponse($settings['message'], Response::HTTP_BAD_REQUEST);

            return response()->error($response);
        }
        $response = new SuccessResponse($settings['message'], $settings['data'], Response::HTTP_OK);

        return response()->success($response);
    }

    public function faqs()
    {
        $faqs = $this->settingService->getAllFaqs();

        if (!$faqs['status']) {
            $response = new ErrorResponse($faqs['message'], Response::HTTP_BAD_REQUEST);

            return response()->error($response);
        }

        $faqsCollection = new FaqCollection($faqs['data']);
        $response = new SuccessResponse($faqs['message'], $faqsCollection, Response::HTTP_OK);

        return response()->success($response);
    }

    public function contactUs(Request $request)
    {

        $response = $this->contact->store($request);

        return $this->response_api($response['status'], $response['message']);
    }


}
