<?php

namespace App\Repositories\Panel;

use App\Models\Setting;
use App\Models\SocialMedia;
use Illuminate\Support\Facades\DB;

class SettingEloquent
{

    public function index()
    {

        $data['settings'] = new Setting();

        $data['socials'] = SocialMedia::all();

        return $data;
    }

    public function update($request)
    {

        DB::beginTransaction();


        try {


            $setting = new Setting();

            $keys = SocialMedia::all()->pluck('key')->toArray();
            $socialItems = $request->only($keys);
            $settingItems = $request->except(array_merge($keys, ['_token', '_method', 'file', 'name_ar', 'link']));



            foreach ($settingItems as $i => $input) {

                $setting->updateOrCreate(['key' => $i], ['value' => (isset($input)) ? $input : '']);
            }

            foreach ($socialItems as $i => $input) {
                $social = SocialMedia::where('key', $i)->first();
                if (!isset($social)) {
                    $message = 'حدث خطأ غير متوقع';
                    $status = false;
                }
                $social->updateItem($input);
            }

            $message = 'تمت العملية بنجاح';
            $status = true;

            DB::commit();
        } catch (\Exception $e) {
            $message = 'حدث خطأ غير متوقع' . $e->getMessage();
            $status = false;
            DB::rollback();
        }
        $response = [
            'message' => $message,
            'status' => $status,
        ];

        return $response;
    }
}
