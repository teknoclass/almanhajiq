<?php

namespace App\Repositories\Common;

use I18N_Arabic;
use App\Models\CertificateTemplates;
use App\Models\CertificateTemplateTexts;
use Illuminate\Support\Facades\File;

class CertificateIssuanceEloquent
{
    protected $fontPath;
    protected $arabic;

    public function __construct()
    {
        $this->fontPath = public_path("assets/front/certificate_settings/din-next-regular.ttf");
        $this->arabic = new I18N_Arabic('Glyphs');
    }

    public function generate($templateId, $userData = [], $outputPath)
    {
        $certificateTemplate = CertificateTemplates::findOrFail($templateId);
        $templateTexts = $certificateTemplate->texts;
        $imagePath = storage_path("app/public/uploads/images/" . $certificateTemplate->background);
        
        $image = $this->createImageFromPath($imagePath);

        foreach ($templateTexts as $templateText) {
            $text = $this->getText($templateText, $userData);
            $coordinates = json_decode($templateText->coordinates);
            $color = hexToRgb($templateText->font_color_css);
            $allocatedColor = imagecolorallocate($image, $color['r'], $color['g'], $color['b']);

            $width = $coordinates->width ?? 100;
            $left = $coordinates->left;
            $top = (str_replace('px', '', $coordinates->top));

            if(! in_array($templateText->type,["qrcode_location"]) )
            {
                $this->writeTextOnImage(
                    $image,
                    $this->fontPath,
                    $text,
                    $left,
                    $top + 30,
                    $left + $width,
                    $top + 100,
                    $allocatedColor
                );
            }
        }

        $this->saveImage($image, $outputPath);
    }

    protected function createImageFromPath($path)
    {
        $extension = File::extension($path);
        return $extension == 'png' ? imagecreatefrompng($path) : imagecreatefromjpeg($path);
    }

    protected function getText($templateText, $userData)
    {
        switch ($templateText->type)
        {
            case CertificateTemplateTexts::STUDENT_NAME_LOCATION:
                return $this->arabic->utf8Glyphs( $userData['name'] ?? 'Student Name');
            case CertificateTemplateTexts::COURSE_NAME_LOCATION:
                return $this->arabic->utf8Glyphs($userData['courseTitle'] ?? 'Here Is The Default Course Title');
			case CertificateTemplateTexts::DepartmentNAMELOCATION:
                return $this->arabic->utf8Glyphs($userData['departmentName'] ?? 'department Name');
            case CertificateTemplateTexts::CERTIFICATE_DATE:
                return $userData['date'] ?? date('Y-m-d');
            default:
                return strip_tags($this->arabic->utf8Glyphs($templateText->text));
        }
    }

    protected function writeTextOnImage($im, $font, $text, $x1, $y1, $x2, $y2, $allocatedcolor)
    {
        $maxwidth = $x2 - $x1;
        $drawsize = 1;
        $drawX = $x1;

        for ($size = 1; true; $size++) {
            $bbox = imagettfbbox($size, 0, $font, $text);
            $width = $bbox[2] - $bbox[0];
            if ($width > $maxwidth) {
                $drawsize = $size - 1;
                break;
            }
        }

        $bbox = imagettfbbox($drawsize, 0, $font, $text);
        $textWidth = $bbox[2] - $bbox[0];
        $drawX = $x1 + ($maxwidth - $textWidth) / 2;

        imagettftext($im, $drawsize, 0, $drawX, $y1, $allocatedcolor, $font, $text);
    }

    protected function saveImage($image, $outputPath)
    {
        $directory = dirname($outputPath);
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }
        imagejpeg($image, $outputPath);
        imagedestroy($image);
    }
}