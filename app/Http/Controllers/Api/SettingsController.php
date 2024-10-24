<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FaqCollection;
use App\Http\Response\ErrorResponse;
use App\Http\Response\SuccessResponse;
use App\Services\SettingService;
use Symfony\Component\HttpFoundation\Response;

class SettingsController extends Controller
{
    public SettingService $settingService;

    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
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


}
