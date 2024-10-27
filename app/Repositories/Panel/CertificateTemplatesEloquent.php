<?php

declare(strict_types=1);

namespace App\Repositories\Panel;

use App\Models\Category;
use Exception;
use I18N_Arabic;
use App\Models\CertificateTemplates;
use App\Models\CertificateTemplateTexts;
use App\Models\Courses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class CertificateTemplatesEloquent
{
    public function index(): array
    {
        return [];
    }

    /**
     * @throws Exception
     */
    public function getDataTable(): JsonResponse
    {
        $data = CertificateTemplates::select('*', DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d ") as date'))
            ->orderByDesc('created_at')
            ->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', 'panel.certificate_templates.partials.actions')
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create(): array
    {
        $data = $this->index();

        $data['course_categories'] = Category::query()
            ->select('id', 'value', 'parent')
            ->with('translations:category_id,name,locale')
            ->where('parent', 'course_categories')
            ->orderByDesc('created_at')
            ->get();

        $data['courses'] = Courses::orderByDesc('created_at')
            ->select('id', 'is_active')
            ->with(['translations:courses_id,title,locale'])
            ->get();


        return $data;
    }

    public function store(Request $request): array
    {
        DB::beginTransaction();

        try {
            if ($request->get('certificate_type') === 'course') {
                $course_category_id = $request->get('course_category_id');
                if ($course_category_id === '') {
                    $items = CertificateTemplates::whereNull('course_category_id')->count();
                    if ($items > 0) {
                        return [
                            'message' => 'لا يمكن إضافة قالب اخر دون تحديد قسم معين له',
                            'status' => false,
                        ];
                    }
                }
            }

            $template = CertificateTemplates::updateOrCreate(['id' => 0], $request->all());

            $this->saveTexts($template->id, $request);

            DB::commit();

            return [
                'message' => 'تمت العملية بنجاح',
                'status' => true,
            ];
        } catch (Exception $e) {
            DB::rollback();

            return [
                'message' => ' حدث خطأ غير متوقع',
                'status' => false,
            ];
        }
    }

    public function edit(int $id): array
    {
        $data = $this->create();
        $data['item'] = CertificateTemplates::where('id', $id)->firstOrFail();

        return $data;
    }

    public function update($id, $request): array
    {
        DB::beginTransaction();

        try {
            if ($request->get('certificate_type') === 'course') {
                $course_category_id = $request->get('course_category_id');
                if ($course_category_id === '') {

                    $items = CertificateTemplates::whereNull('course_category_id')
                        ->where('id', '!=', $id)
                        ->count();

                    if ($items > 0) {
                        return [
                            'message' => 'لا يمكن إضافة قالب اخر دون تحديد قسم معين له',
                            'status' => false,
                        ];
                    }
                }
            }

            CertificateTemplates::updateOrCreate(['id' => $id], $request->all());

            $this->saveTexts($id, $request);

            DB::commit();

            return [
                'message' => 'تمت العملية بنجاح',
                'status' => true,
            ];
        } catch (Exception $e) {
            DB::rollback();

            return [
                'message' => ' حدث خطأ غير متوقع',
                'status' => false,
            ];
        }
    }

    private function saveTexts($certificate_template_id, Request $request): void
    {
        CertificateTemplateTexts::where('certificate_template_id', $certificate_template_id)->delete();

        $template_texts = json_decode($request->get('template_texts'));

        foreach ($template_texts as $template_text) {
            CertificateTemplateTexts::create([
                'certificate_template_id' => $certificate_template_id,
                'text' => $template_text->text,
                'coordinates' => json_encode($template_text->position),
                'font_size_css' => '30px',
                'font_color_css' => $template_text->font_color,
                'transform_css' => $template_text->transform,
                'type' => $template_text->type ?? CertificateTemplateTexts::OTHERS,
            ]);
        }
    }

    public function delete(int $id): array
    {
        $item = CertificateTemplates::find($id);

        if ($item) {
            $item->delete();
            return [
                'message' => 'تم الحذف بنجاح  ',
                'status' => true,
            ];
        }

        return [
            'message' => 'حدث خطأ غير متوقع',
            'status' => false,
        ];
    }

    public function operation(Request $request): array
    {
        $id = $request->get('id');
        $operation = $request->get('operation');

        $item = CertificateTemplates::find($id);

        if ($item) {
            if ($operation === 'active') {
                $item->is_active = !$item->is_active;
                $item->save();
            }

            if ($operation === 'default') {
                if ($item->is_default === 0) {
                    CertificateTemplates::query()
                        ->where('is_default', 1)
                        ->update([
                            'is_default' => 0
                        ]);
                }

                $item->is_default = !$item->is_default;
                $item->save();
            }

            return [
                'message' => 'تمت العملية بنجاح',
                'status' => true,
            ];
        }

        return [
            'message' => 'حدث خطأ غير متوقع',
            'status' => false,
        ];
    }

    public function certificateTestIssuance(int $id, bool $is_web = true): BinaryFileResponse|RedirectResponse
    {
        try {
            $certificate_templates = CertificateTemplates::findOrFail($id);
            $template_texts = $certificate_templates->texts;

            $Arabic = new I18N_Arabic('Glyphs');

            $extension = pathinfo($certificate_templates->background, PATHINFO_EXTENSION);

            $our_image = match ($extension) {
                'png' => imagecreatefrompng(storage_path("app/uploads/images/" . $certificate_templates->background)),
                default => imagecreatefromjpeg(storage_path("app/uploads/images/" . $certificate_templates->background)),
            };

            $font_path = public_path("assets/front/certificate_settings/din-next-regular.ttf");
            $imagewidth = imagesx($our_image);
            $angle = 0;

            foreach ($template_texts as $template_text) {
                $size = floatval(str_replace('px', '', $template_text->font_size_css));
                $color_text = $this->hexToRgb($template_text->font_color_css);
                $coordinates = json_decode($template_text->coordinates);

                $text = match ($template_text->type) {
                    CertificateTemplateTexts::STUDENT_NAME_LOCATION => "محمد بدري مرتضى",
                    CertificateTemplateTexts::COURSE_NAME_LOCATION => "الدورة الشاملة في التحكم الصناعي الآلي",
                    CertificateTemplateTexts::LECTURER_NAME_LOCATION => "وائل علي الأحمد",
                    CertificateTemplateTexts::CERTIFICATE_DATE => date('Y-m-d'),
                    default => strip_tags($template_text->text),
                };

                $color = imagecolorallocate($our_image, $color_text['r'], $color_text['g'], $color_text['b']);
                $text = $Arabic->utf8Glyphs($text);
                $box = imageTTFBbox($size, $angle, $font_path, $text);
                $textwidth = abs($box[4] - $box[0]);

                $text_center = $textwidth / 2;
                $left = (int)($coordinates->left - $text_center);
                $top = (int)((float)str_replace('px', '', (string) $coordinates->top) + 30);
                
                imagettftext($our_image, $size, $angle, $left, $top, (int) $color, $font_path, $text);
            }

            $name = time() . ".jpeg";

            $path = storage_path("app/certificates/test/$certificate_templates->id");

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            imagejpeg($our_image, "$path/$name");

            return response()->download("$path/$name");
        } catch (Exception $e) {
            return back();
        }
    }

    private function hexToRgb(string $hex): array
    {
        $hex = str_replace('#', '', $hex);

        if (strlen($hex) === 3) {
            $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
        } else {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }

        return ['r' => $r, 'g' => $g, 'b' => $b];
    }
}
