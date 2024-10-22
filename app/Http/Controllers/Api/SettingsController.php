<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Response\ErrorResponse;
use App\Http\Response\SuccessResponse;
use App\Models\Setting;
use App\Models\SocialMedia;
use App\Services\SettingService;
use Symfony\Component\HttpFoundation\Response;

class SettingsController  extends Controller
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
            $response = new SuccessResponse($settings['message'],$settings['data'], Response::HTTP_OK);

            return response()->success($response);
        }

}
