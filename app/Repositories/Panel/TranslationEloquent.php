<?php

namespace App\Repositories\Panel;

use App\Models\Languages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TranslationEloquent
{

    public function index($lang)
    {

        $defult_lang = getDefultLang()->lang;

        $backup = file_get_contents(base_path('lang/backup.json'));
        if (!file_exists(base_path("lang/{$lang}.json"))) {
            file_put_contents(base_path("lang/{$lang}.json"), $backup);
        }
        $jsonString = file_get_contents(base_path("lang/{$lang}.json"));

        $data['backup_data'] = json_decode($backup, true);
        $data['text_data'] = json_decode($jsonString, true);
        return $data;
    }

    public function update($request,$lang)
    {
        $keys = $request->get('keys');
        $values = $request->get('values');

        $escapers = array("\\", "\"");
        $replacements = array("\\\\", "\\\"");

        $result = [];
        //print_r($values);
        //echo '<br>';
        foreach ($keys as $key => $item) {

            $k = str_replace($escapers, $replacements, $item);
            $v = str_replace($escapers, $replacements, $values[$key]);
            $result[$k] = $v;
        }
        $new_json_string = json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PARTIAL_OUTPUT_ON_ERROR);
        file_put_contents(base_path("lang/{$lang}.json"), stripslashes($new_json_string));

        $message =__('message_done');
        $status = true;

        $response = [
            'message' => $message,
            'status' => $status,
        ];

        return $response;
    }

    public function updateAjax(Request $request, $lang)
    {
        Log::alert('xx');
        // Fetch the existing translation data
        $filePath = base_path("lang/{$lang}.json");

        $jsonString = file_get_contents($filePath);
        $data = json_decode($jsonString, true);

        // Escape special characters
        $escapers = array("\\", "\"");
        $replacements = array("\\\\", "\\\"");

        // Update the specific key-value pair
        $k = str_replace($escapers, $replacements, $request->key);
        $v = str_replace($escapers, $replacements, $request->value);
        $data[$k] = $v;

        // Encode the updated data and write it back to the file
        $newJsonString = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PARTIAL_OUTPUT_ON_ERROR);
        file_put_contents($filePath, stripslashes($newJsonString));
        return response()->json([
            'message' => __('message_done'),
            'status' => true,
        ]);
    }
}
