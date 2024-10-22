<?php

namespace App\Repositories\Front\User\Marketer;

use App\Models\Coupons;
use App\Models\MarketersTemplatesTexts;
use App\Repositories\Front\User\HelperEloquent;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use App\Models\MarketersTemplates;

class MarketersTemplatesEloquent extends HelperEloquent
{
    public function all($request, $is_web = true, $count_itmes = 8)
    {
        $data['user'] = $this->getUser($is_web);

        $data['templates']=MarketersTemplates::orderBy('id', 'desc')->active()
        ->paginate($count_itmes);


        return $data;


    }

    public function download($id, $is_web=true)
    {


        $data['user'] = $this->getUser($is_web);

        try {
            $template=MarketersTemplates::where([
                ['id',$id],
            ])->first();

            if ($template=='') {
                return back();
            }

            $texts_template=$template->texts;

            $user_id=$data['user']->id;
            $coupon=Coupons::whereHas('allMarketers', function (Builder $query) use ($user_id) {
                $query->where('user_id', $user_id);
            })->first();



            $Arabic = new \I18N_Arabic('Glyphs');
            $our_image = imagecreatefromjpeg(storage_path("app/uploads/images/".$template->background));
            $font_path = public_path("assets/front/certificate_settings/din-next-regular.ttf");
            $imagewidth = imagesx($our_image);
            $angle = 0;

            // Coupon code
            foreach($texts_template as $text_template) {
                $size = floatval(str_replace('px', '', $text_template->font_size_css));
                $color_text=hexToRgb($text_template->font_color_css);
                $coordinates=json_decode($text_template->coordinates);
                if($text_template->type==MarketersTemplatesTexts::COUPON_CODE) {
                    $text='كود الكوبون  '. $coupon->code;
                } else {
                    $text=strip_tags($text_template->text);
                }
                $color = imagecolorallocate($our_image, $color_text['r'], $color_text['g'], $color_text['b']);
                $text = $Arabic->utf8Glyphs($text);
                $right = $coordinates->left;
                $top = $coordinates->top;
                $box = @imageTTFBbox($size, $angle, $font_path, $text);
                $textwidth = abs($box[4] - $box[0]);
                $right = $imagewidth - ($textwidth) - $right;
                imagettftext($our_image, $size, $angle, $right, $top, $color, $font_path, $text);
            }



            // Send Image to Browser
            $name = time() . ".jpeg";


            $path=storage_path("app/template/". $data['user']->id);
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            imagejpeg($our_image, $path.'/' . $name);
            // Clear Memory
            imagedestroy($our_image);
            return response()->download($path.'/' . $name);
        } catch (\Exception $e) {
            return back();
        }

    }

}
