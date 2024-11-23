<?php

use App\Models\Languages;
use Carbon\Carbon;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Models\Setting;
use App\Models\Admin;
use App\Models\User;
use App\Models\Notifications;
use App\Models\Sliders;
use Illuminate\Support\Facades\Auth;
use App\Models\Image;
use App\Logic\ImageRepository;
use App\Mail\ReplayMail;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use App\Models\{CourseSession,CourseSessionsGroup,CourseSessionSubscription,UserCourse,
    StudentSessionInstallment,CourseSessionInstallment};
use Twilio\Rest\Client;
use Illuminate\Support\Str;

function checkAllPermissionsAdmin($permissions)
{
    $has_permission = true;
    $count_not_permission = 0;

    foreach (@$permissions as $permission) {
        if (!Auth::user()->can($permission)) {
            $count_not_permission++;
        }
    }

    if ($count_not_permission == count(@$permissions)) {
        $has_permission = false;
    }

    return $has_permission;
}


function checkShowMenu($memu)
{
    $has_permission = true;
    $count_not_permission = 0;
    if (count(@$memu['sub_menu']) > 0) {
        $sub_menus = @$memu['sub_menu'];
        foreach ($sub_menus as $sub_menu) {
            if (!Auth::user()->can($sub_menu['permissions'])) {
                $count_not_permission++;
            }
        }

        if ($count_not_permission == count(@$memu['sub_menu'])) {
            $has_permission = false;
        }
    } else {
        if (!Auth::user()->can($memu['permissions'])) {
            $has_permission = false;
        }
    }

    return $has_permission;
}

function filterData($items)
{
    $pagination = \Input::get('pagination');
    $query      = \Input::get('query');
    $search     = isset($query['generalSearch']) ? $query['generalSearch'] : null;
    if(isset($pagination) ) {
        if ($pagination['perpage'] == -1 || $pagination['perpage'] == null) {
            $pagination['perpage'] = 10;
        }
    }
    if (isset($search)) {
        $items->filter($search);
    }
    $itemsCount          = $items->count();
    $items               = $items->take($pagination['perpage'])->skip($pagination['perpage'] * ($pagination['page'] - 1))->get();
    $pagination['total'] = $itemsCount;
    $pagination['pages'] = ceil($itemsCount / $pagination['perpage']);
    $data['meta']        = $pagination;
    $data['data']        = $items;
    return $data;
}

function getFirstCharacter($srt)
{
    return mb_substr($srt, 0, 1, "UTF-8");
}

function getHeaderId()
{
 $silder=Sliders::where('name','header')->select('id')->first();
 return $silder->id;
}
function getStudentOpinionId()
{
    $silder=Sliders::where('name','student_opinions')->select('id')->first();
    return $silder->id;
}

function imageUrl_past($img, $size = '')
{
    $image =  (!empty($size)) ? url('/image/' . $size . '/' . $img) : url('/image/' . $img);
    if (!File::exists($image)) {
        return url('/image/' . (new Setting)->valueOf('logo'));
    }
    return $image;
}

function imageUrl($img, $size = '')
{
    if($img == "avatar.png")
    {
        return url('/image/' . (new Setting)->valueOf('logo'));
    }
    $image =  (!empty($size)) ? url('/image/' . $size . '/' . $img) : url('/image/' . $img);
    $path = storage_path('app/uploads/images/'.$img);

    if (!$img || !File::exists($path)) {
       return url('/image/' . (new Setting)->valueOf('logo'));
    }
    return $image;
}

function certificateImage($id)
{
    return url('/image/certificate/' . $id);
}

function centerCertificateImage($id)
{
    return url('/image/center-certificate/' . $id);
}
function changeDateFormate($date, $date_format='Y-m-d')
{
    if (app()->isLocale('ar')) {
        \Carbon\Carbon::setLocale('ar');
    } else {
        \Carbon\Carbon::setLocale('en');
    }
    return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->format($date_format);
}

function getDayName($date)
{
    return \Carbon\Carbon::createFromFormat('Y-m-d', $date)->translatedFormat('l');
}

function getMonthName($date)
{
    return \Carbon\Carbon::createFromFormat('Y-m-d', $date)->translatedFormat('M');
}

function getCustomDateFormate($date, $date_format='Y-m-d')
{
    if (app()->isLocale('ar')) {
        \Carbon\Carbon::setLocale('ar');
    } else {
        \Carbon\Carbon::setLocale('en');
    }
    return \Carbon\Carbon::createFromFormat('Y-m-d', $date)->format($date_format);
}




function locales()
{
    $arr = [];
    foreach (LaravelLocalization::getSupportedLocales() as $key => $value) {
        $arr[$key] = __('translate.' . $key);
    }
    return $arr;
}


function getSeting($key)
{
    $setting = Setting::where('key', $key)->first();

    return @$setting->value;
}



function cutString($text, $length)
{
    $text = strip_tags($text);

    $text=str_replace("&nbsp;", " ", $text);

    if (strlen($text) > $length) {
        return mb_substr($text, 0, $length) . '...';
    } else {
        return $text;
    }
}


//////////////////////start  Notifications /////////////////////////////

function sendWebNotification($user_id, $user_type, $title, $text)
{
    $url = 'https://fcm.googleapis.com/fcm/send';
    if ($user_type == 'user') {
        $FcmToken = User::where('id', $user_id)->whereNotNull('device_token')->pluck('device_token')->all();
    } else {
        $FcmToken = Admin::where('id', $user_id)->whereNotNull('device_token')->pluck('device_token')->all();
    }


    $serverKey = env('FCM_SERVER_KEY');

    $data = [
        "registration_ids" => $FcmToken,
        "notification" => [
            "title" => $title,
            "body" => $text,
        ]
    ];
    $encodedData = json_encode($data);

    $headers = [
        'Authorization:key=' . $serverKey,
        'Content-Type: application/json',
    ];

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    // Disabling SSL Certificate support temporarly
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);

    // Execute post
    $result = curl_exec($ch);

    // dd($result);

    if ($result === false) {
        die('Curl failed: ' . curl_error($ch));
    }

    // Close connection
    curl_close($ch);

    // FCM response
    // dd($result);
}

function sendNotification($title, $text, $user_id, $user_type, $action_type = null, $action_id = null, $image = null, $sender_id = null)
{
    $data['title'] = $title;
    $data['text'] = $text;
    $data['user_id'] = $user_id;
    $data['user_type'] = $user_type;
    $data['action_type'] = $action_type;
    $data['action_id'] = $action_id;
    $data['image'] = $image;

    Notifications::updateOrCreate(['id' => 0], $data);

    sendWebNotification($user_id, $user_type, $title, $text);
}


function sendEmail($title, $msg, $to)
{
    // if(env('APP_ENV') == 'local') {
        $send = Mail::to($to)->send(new ReplayMail($title, $msg, $to));
        if (!$send) {
            $message = 'حدث خطأ غير متوقع';
            $status = false;
            $response = [
                'message' => $message,
                'status' => $status,
            ];
            return $response;
        }
    // }

    $response = [
        'message' => 'تم الإرسال بنجاح',
        'status' => true,
    ];
    return $response;
}

function getLastNotifications($type)
{
    if ($type=='admin') {
        $user =  Auth::user();
    } else {
        $user = auth('web')->user();
    }
    if ($user != '') {
        $data['notifications'] = Notifications::where('user_id', $user->id)->where('user_type', $type)->whereNull('read_at')->orderBy('id', 'desc')->take(3)->get();
        if ($type=='admin') {
            return View::make('panel.layouts.dropdown_notifications', $data)->render();
        } else {
            return View::make('front.layouts.dropdown_notifications', $data)->render();
        }
    }
}



function showNotifications()
{
    $user = auth('web')->user();
    if ($user == '') {
        return 0;
    }
    $user_id = $user->id;
    $items = Notifications::where('user_id', $user->id)->where('user_type', 'user')->whereNull('read_at')->get();

    Notifications::where('user_id', $user->id)->where('user_type', 'user')->whereNull('read_at')
    ->update([
        'read_at' => Carbon::now()
    ]);

    return 0;
}

function getCountNotificationsNotShow($type)
{
    if ($type == 'admin') {
        $user =  Auth::user();
        if ($user == '') {
            return 0;
        }
        $user_id = $user->id;
        $item = Notifications::where('user_id', $user->id)->where('user_type', 'admin')->whereNull('read_at')->get();
    } else {
        $user = auth('web')->user();
        if ($user == '') {
            return 0;
        }
        $user_id = $user->id;
        $item = Notifications::where('user_id', $user->id)->where('user_type', 'user')->whereNull('read_at')->get();
    }
    return count($item);
}


function showNotificationsAdmin()
{
    $user =  Auth::user();
    if ($user == '') {
        return 0;
    }
    $user_id = $user->id;
    $items = Notifications::where('user_id', $user->id)->where('user_type', 'admin')->whereNull('read_at')->get();
    Notifications::where('user_id', $user->id)->where('user_type', 'admin')->whereNull('read_at')
        ->update([
            'read_at' => Carbon::now()
        ]);

    return 0;
}

function getCountNotificationsNotShowAdmin()
{
    $user =  Auth::user();
    if ($user == '') {
        return 0;
    }
    $user_id = $user->id;
    $item = Notifications::where('user_id', $user->id)->where('user_type', 'admin')->whereNull('read_at')->get();
    return count($item);
}

//////////////////////end  Notifications /////////////////////////////

function diffForHumans($timestamp)
{
    if (app()->isLocale('ar')) {
        \Carbon\Carbon::setLocale('ar');
    } else {
        \Carbon\Carbon::setLocale('en');
    }
    return (is_string($timestamp)) ? \Carbon\Carbon::createFromTimestampUTC(strtotime($timestamp))->diffForHumans() : $timestamp->diffForHumans();
}

function formatTimestampDate($timestamp, $format)
{
    if (app()->isLocale('ar')) {
        \Carbon\Carbon::setLocale('ar');
        setLocale(LC_TIME, 'ar');
    } else {
        \Carbon\Carbon::setLocale('en');
    }
    return (isset($timestamp) && isset($format)) ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $timestamp)->format($format) : '';
}



function shareUrl($type)
{
    $url = \Request::url();
    switch ($type) {
        case 'facebook':
            return "https://www.facebook.com/sharer/sharer.php?u=$url";
            break;
        case 'twitter':
            return "https://twitter.com/share?url=$url";
            break;
        case 'linkedin':
            return "https://www.linkedin.com/shareArticle?mini=true&url=$url";
            break;
        case 'instagram':
            return "https://www.instagram.com/?url=$url";
            break;
        case 'pinterest':
            return "http://pinterest.com/pin/create/button/?url=$url";
            break;
        case 'whatsapp':
            return "https://wa.me/?text=$url";
            break;
    }
}




function mergeString($str1, $str2)
{
    $str = $str1 . ' '  . $str2;

    return str_replace(' ', '-', $str);
}


function uploadFile($file, $custome_path='', $is_full_path=false)
{
    if ($custome_path=='') {

        $path=storage_path() . '/app/uploads/files';

    } else {
        if(!$is_full_path) {
            $path=storage_path() . '/app/uploads/files/'.$custome_path;
        }else{
            $path=$custome_path;
        }
    }

    $extension = $file->getClientOriginalExtension();
    $filename = 'file_' . time() . mt_rand() . '.' . $extension;

    $originalName = str_replace('.' . $extension, '', $file->getClientOriginalName());
    $file->move($path, $filename);

    $image = new Image();
    $image->display_name = $originalName . '.' . $extension;
    $image->file_name = $filename;
    $image->mime_type = $extension;
    $image->save();
    return $filename;
}

function uploadImageBySendingFile($image, $custome_path='', $is_full_path=false)
{
    if ($custome_path=='') {
        $path = storage_path() . '/app/uploads/images';
    } else {
        if(!$is_full_path) {
            $path = storage_path() . '/app/uploads/images/'.$custome_path;
        }else{
            $path=$custome_path;
        }
    }

    $extension = $image->getClientOriginalExtension();
    $imagename = 'image_' . time() . mt_rand() . '.' . $extension;
    $originalName = str_replace('.' . $extension, '', $image->getClientOriginalName());
    $image->move($path, $imagename);

    $image = new Image();
    $image->display_name = $originalName . '.' . $extension;
    $image->file_name = $imagename;
    $image->mime_type = $extension;
    $image->save();
    return $imagename;
}

function uploadImage($request, $custome_path='')
{
    $photo            = $request['file'];
    $extension        = $photo->getClientOriginalExtension();
    $filename         = 'image_' . time() . mt_rand();
    $repo             = new ImageRepository();
    $allowed_filename = $repo->createUniqueFilename($filename, $extension, $custome_path);
    $uploadSuccess1   = $repo->original($photo, $allowed_filename, $custome_path);
    $originalName     = str_replace('.' . $extension, '', $photo->getClientOriginalName());

    $image               = new Image();
    $image->display_name = $originalName . '.' . $extension;
    $image->file_name    = $allowed_filename;
    $image->mime_type    = $extension;
    $image->save();
    return $allowed_filename;
}


function getEmail()
{
    $setting = Setting::where('key', 'email')->first();

    return $setting->value;
}

function getNameWebSite()
{
    $setting = Setting::where('key', 'title_ar')->first();

    return $setting->value;
}


function fileUrl($file)
{
    return url('files/' . $file);
}

function videoUrl($file)
{
    return url('files/video/' . $file);
}

function tagsFormate($tags)
{
    $keyword = '';

    if ($tags) {
        $i = 0;
        $tags = json_decode(@$tags);
        foreach ($tags as $tag) {
            $keyword .= $tag->value;
            $i++;
            if (count($tags) != $i) {
                $keyword .= ',';
            }
        }

        return $keyword;
    }
}

function getVersionAssets()
{
    return env('VERSION_ASSETS');
}


function sendWebNotifications($users_id, $user_type, $title, $text)
{
    $url = 'https://fcm.googleapis.com/fcm/send';
    if ($user_type == 'user') {
        $FcmToken = User::whereIn('id', $users_id)->whereNotNull('device_token')->pluck('device_token')->all();
    } else {
        $FcmToken = Admin::whereIn('id', $users_id)->whereNotNull('device_token')->pluck('device_token')->all();
    }


    $serverKey = env('FCM_SERVER_KEY');

    $data = [
        "registration_ids" => $FcmToken,
        "notification" => [
            "title" => $title,
            "body" => $text,
        ]
    ];
    $encodedData = json_encode($data);

    $headers = [
        'Authorization:key=' . $serverKey,
        'Content-Type: application/json',
    ];

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    // Disabling SSL Certificate support temporarly
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);

    // Execute post
    $result = curl_exec($ch);

    // dd($result);

    if ($result === false) {
        die('Curl failed: ' . curl_error($ch));
    }

    // Close connection
    curl_close($ch);

    // FCM response
    // dd($result);
}

function getUser($guard = 'web')
{
    return auth($guard)->user();
}

function checkUser($role,$guard='web')
{
    if (auth($guard)->check()) {
        if (getUser($guard)->role==$role) {
            return true;
        }
    }
    return false;
}

function diffInHours($to, $from)
{
    $to = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $to);
    $from = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $from);

    $diff_in_hours = $to->diffInHours($from);

    return $diff_in_hours;
}

function getDefultLang()
{
    $item=Languages::where('is_default', 1)->first();
    return $item;
}

function sendNotifications($title, $text, $action_type, $action_data, $permation, $user_type, $user_ids=[])
{
    $notifications = [];

    $notification['title'] = $title;
    $notification['text'] = $text;
    $notification['user_type'] = $user_type;
    $notification['action_type'] =$action_type;
    $notification['action_id'] = $action_data;
    $notification['created_at'] = \Carbon\Carbon::now();

    if ($user_type=='admin') {
        $admins =  Admin::all();
        foreach ($admins as $admin) {
            if ($admin->can($permation)) {
                //sendNotification
                $users_id[] = $admin->id;
                $notification['user_id'] = $admin->id;
                $notifications[] = $notification;
            }
        }
    } else {
        foreach ($user_ids as $user_id) {
            //sendNotification
            $users_id[] = $user_id;
            $notification['user_id'] = $user_id;
            $notifications[] = $notification;
        }
    }

    if (count($users_id) > 0) {
        Notifications::insert($notifications);
        sendWebNotifications($users_id, $user_type, $title, $text);
    }
    return true;
}

function quickRandom($length = 16)
{
    $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
}


function defaultCountryCode()
{
    return '964';
}


function defaultCountrySlug()
{
    return 'iraq';
}

function uploadvideo($file, $custome_path='', $is_full_path=false)
{
    if ($custome_path=='') {

        $path=storage_path() . '/app/uploads/files/videos';

    } else {
        if(!$is_full_path) {
            $path=storage_path() . '/app/uploads/files/'.$custome_path;
        }else{
            $path=$custome_path;
        }
    }

    $extension = $file->getClientOriginalExtension();
    $filename = 'file_' . time() . mt_rand() . '.' . $extension;
    $originalName = str_replace('.' . $extension, '', $file->getClientOriginalName());
    $file->move($path, $filename);
    return $filename;
}

function uploadVoice($file, $custome_path='', $is_full_path=false)
{
    if ($custome_path=='') {

        $path=storage_path() . '/app/uploads/files';

    } else {
        if(!$is_full_path) {
            $path=storage_path() . '/app/uploads/files/'.$custome_path;
        }else{
            $path=$custome_path;
        }
    }
    $fileName  = uniqid() . '_' . trim($file->getClientOriginalName());
    $file->move($path, $fileName);
    return $fileName;
}

function CourseVideoUrl($course_id, $file)
{
    return url('get-course-file/' . $course_id . '/videos/' . $file);
}

function CourseAudioUrl($course_id, $file)
{
    return url('get-course-file/' . $course_id . '/listen/' . $file);
}

function CourseDocUrl($course_id, $file)
{
    return url('get-course-file/' . $course_id . '/docs/' . $file);
}

function CourseAssignmentUrl($course_id, $file)
{
    return url('get-course-file/' . $course_id . '/assignments/' . $file);
}

function CourseAttachmentUrl($course_id, $file)
{
    return url('get-course-file/' . $course_id . '/lesson_attachments/' . $file);
}

function CourseImageUrl($course_id, $file)
{
    return url('get-course-file/' . $course_id . '/images/' . $file);
}

function getCurriculumWidgetIcon($item_type, $file_type)
{
    switch ($item_type) {
        case 'lesson':
            switch ($file_type) {
                case 'video':
                    $icon = 'fa-video';
                    break;
                case 'listen':
                    $icon = 'fa-microphone';
                    break;
                case 'doc':
                    $icon = 'fa-file';
                    break;
                case 'image':
                    $icon = 'fa-image';
                    break;
                default:
                    $icon = 'fa-text';
                    break;
            }
            break;

        case 'quiz':
            $icon = 'fa-pen-line';
            break;

        case 'assignment':
            $icon = 'fa-list-check';
            break;

        case 'live_lesson':
            $icon = 'fa-podcast';
            break;
    }

    return $icon ?? null;
}

function getSystemCommission($user_id)
{
    $user = User::find($user_id);

    if ($user) {
        $systemCommission = $user->system_commission ?? null;
    } else {
        $systemCommission = null;
    }

    if (empty($systemCommission)) {
        $systemCommission = getSeting('system_commission');
    }

    $systemCommission = is_numeric($systemCommission) ? $systemCommission : 0;

    return $systemCommission;
}

function hexToRgb($hex, $alpha = false)
{
    $hex      = str_replace('#', '', $hex);
    $length   = strlen($hex);
    $rgb['r'] = hexdec($length == 6 ? substr($hex, 0, 2) : ($length == 3 ? str_repeat(substr($hex, 0, 1), 2) : 0));
    $rgb['g'] = hexdec($length == 6 ? substr($hex, 2, 2) : ($length == 3 ? str_repeat(substr($hex, 1, 1), 2) : 0));
    $rgb['b'] = hexdec($length == 6 ? substr($hex, 4, 2) : ($length == 3 ? str_repeat(substr($hex, 2, 1), 2) : 0));
    if ($alpha) {
        $rgb['a'] = $alpha;
    }
    return $rgb;
}

function isCourseHasSubscriptions($course_id)
{
    $courseSessionsGroupsIds = CourseSession::where('course_id',$course_id)->pluck('group_id')->toArray();

    $courseGroupsids = CourseSessionsGroup::whereIn('id',$courseSessionsGroupsIds)->pluck('id')->toArray();

   return CourseSessionSubscription::whereIn('course_session_group_id',$courseGroupsids)->exists();
}

function isStudentSubscribeToSessionGroup($group_id)
{
   //check if student subscribe on all sessions of group
   $studentSubscribedSessionCount = CourseSessionSubscription::where('course_session_group_id',$group_id)->where('student_id',auth('web')->user()->id)->count();

   $groupSessionsCount = CourseSession::where('group_id',$group_id)->count();

    $isstudentSubscribedToGroup = CourseSessionSubscription::where('course_session_group_id',$group_id)->where('related_to_group_subscription', 1)
    ->where('student_id',auth('web')->user()->id)->exists();

    return $isstudentSubscribedToGroup || ($studentSubscribedSessionCount == $groupSessionsCount) ? true : false;
}

function isStudentSubscribeToSession($session_id)
{
    return CourseSessionSubscription::where('course_session_id',$session_id)->where('student_id',auth('web')->user()->id)->exists();
}

function studentSessionGroupSubscriptions()
{
    return CourseSessionSubscription::where('related_to_group_subscription',1)->where('student_id',auth('web')->user()->id)->get();
}

function studentSubscriptionCoursessIds($type = 'web')
{
    if(! auth($type)->check())
    {
        return [];
    }

    return CourseSessionSubscription::where('student_id',auth($type)->user()->id)->pluck('course_id')->toArray();
}

function isCourseonStudentCourse($course_id)
{
    $checkStudentCourses = UserCourse::select('id', 'user_id', 'course_id')
    ->where([
        ['user_id', auth('web')->user()->id],
        ['course_id', $course_id]
    ])->exists();

    return $checkStudentCourses;
}

//installments
function installementdLessonsIds($course_id)
{
   $studentLessonsUntilIds = StudentSessionInstallment::where('course_id',$course_id)
    ->where('student_id',auth('web')->user()->id)->pluck('access_until_session_id')->toArray();
    if($studentLessonsUntilIds)
    {
        $maxLessonId = max($studentLessonsUntilIds);

        return CourseSession::where("course_id",$course_id)->where("id","<=",$maxLessonId)->pluck('id')->toArray();
    } else{
        return [];
    }

}

function studentCourseSessionInstallmentsIDs($course_id)
{
    return  StudentSessionInstallment::where('course_id',$course_id)
    ->where('student_id',auth('web')->user()->id)->pluck('access_until_session_id')->toArray();
}

function studentInstallmentsCoursessIds($type = 'web')
{
    if(! auth($type)->check())
    {
        return [];
    }

    return StudentSessionInstallment::where('student_id',auth($type)->user()->id)->pluck('course_id')->toArray();
}

function checkIfInstallmentHasStudents($installment_id)
{
    $installment = CourseSessionInstallment::find($installment_id);
    $course_session_id = $installment->course_session_id;

    return StudentSessionInstallment::where('access_until_session_id',$course_session_id)->where('course_id',$installment->course_id)
    ->first();
}

function sendOtpToWhatsapp($to_mobile,$otp)
{

    $sid    = "ACa05313d6652bde58f9b50dca4af0d0ed";
    $token  = "9425fdbbbb027bf3cabcdaf86d3ddf3c";

    $fromNumber = '+9647869653275';

    // try {

        $twilio = new Client($sid, $token);

        $message = $twilio->messages->create(
            "whatsapp:+".$to_mobile, // To
            [
                "contentSid" => "HXa7993fb9898278580e512255d287f4a6",
                "contentVariables" => json_encode([
                    "1" => $otp,
                ]),
                "from" => "whatsapp:+9647869653275",
            ]
        );

        return 'SMS Sent Successfully.';
    // } catch (Exception $e) {
    //     return 'Error: ' . $e->getMessage();
    // }
}

function genereatePaymentOrderID()
{
    return preg_replace('/[^A-Za-z]/', '', Str::random(10)).rand(1,1000).rand(1,10);
}

function checkIfstudentFullySubscribeOnCourse($course_id)
{
    return UserCourse::where('user_id','student_id',auth('web')->user()->id)->where('course_id',$course_id)->first();
}
