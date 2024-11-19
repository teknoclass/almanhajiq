<?php

namespace App\Repositories\Panel;

use App\Models\Category;
//use App\Models\Fonts;
use App\Models\CertificateTemplates;
use App\Models\CertificateTemplateTexts;
use App\Models\Courses;
use Illuminate\Support\Facades\DB;
use DataTables;
use App\Repositories\Common\CertificateIssuanceEloquent;

class CertificateTemplatesEloquent
{
	private $certificate_issuance;
	  public function __construct(CertificateIssuanceEloquent $certificate_issuance_eloquent)
    {

        $this->certificate_issuance = $certificate_issuance_eloquent;
    }


    public function index()
    {
        return [];
    }

   public function getDataTable()
   {
       $data = CertificateTemplates::select('*', DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d ") as date'))
           ->orderByDesc('created_at')->get();
       return Datatables::of($data)
           ->addIndexColumn()
           ->addColumn('action', 'panel.certificate_templates.partials.actions')
           ->rawColumns(['action'])
           ->make(true);
   }

   public function create()
   {
       $data = $this->index();

       $data['course_categories'] = Category::query()->select('id', 'value', 'parent')
       ->with('translations:category_id,name,locale')
       ->where('parent', 'joining_course')
       ->orderByDesc('created_at')->get();

       $data['courses'] = Courses::orderByDesc('created_at')
        ->select('id', 'is_active')
        ->with(['translations:courses_id,title,locale'])
        ->get();


       //$data['fonts'] = Fonts::active()->orderByDesc('id')->get();
       return $data;
   }

    public function store($request)
    {
        DB::beginTransaction();

        try {

            //
            if($request->get('certificate_type') == 'course'){
                $course_category_id=$request->get('course_category_id');
                if($course_category_id=='') {
                    $items=CertificateTemplates::whereNull('course_category_id')->count();
                    if($items>0) {
                        $message = 'لا يمكن إضافة قالب اخر دون تحديد قسم معين له';
                        $status = false;

                        $response = [
                            'message' => $message,
                            'status' => $status,
                        ];

                        return $response;
                    }
                }
            }

            $template=CertificateTemplates::updateOrCreate(['id' => 0], $request->all());

            $this->saveTexts($template->id, $request);


            $message = 'تمت العملية بنجاح';
            $status = true;

            $response = [
                'message' => $message,
                'status' => $status,
            ];

            DB::commit();
        } catch (\Exception $e) {
            $message = ' حدث خطأ غير متوقع';
            $status = false;

            $response = [
                'message' => $message,
                'status' => $status,
            ];

            DB::rollback();
        }


            return $response;
    }

    public function edit($id)
    {
        $data = $this->create();
        $data['item'] = CertificateTemplates::where([
            ['id', $id]
            ])->first();
        if ($data['item'] == '') {
            abort(404);
        }

        return $data;
    }

    public function update($id, $request)
    {
        DB::beginTransaction();

        try {
            if($request->get('certificate_type') == 'course'){
                    $course_category_id=$request->get('course_category_id');
                    if($course_category_id=='') {
                        $items=CertificateTemplates::whereNull('course_category_id')
                        ->where('id', '!=', $id)
                        ->count();
                        if($items>0) {
                            $message = 'لا يمكن إضافة قالب اخر دون تحديد قسم معين له';
                            $status = false;

                            $response = [
                                'message' => $message,
                                'status' => $status,
                            ];

                            return $response;
                        }
                    }
                }

            CertificateTemplates::updateOrCreate(['id' => $id], $request->all());

            $this->saveTexts($id, $request);

            $message = 'تمت العملية بنجاح';
            $status = true;

            $response = [
                'message' => $message,
                'status' => $status,
            ];

            DB::commit();
        } catch (\Exception $e) {
            $message = ' حدث خطأ غير متوقع';
            $status = false;
            $response = [
                'message' => $message,
                'status' => $status,
            ];
            DB::rollback();
        }

            return $response;
    }

    public function saveTexts($certificate_template_id, $request)
    {
        CertificateTemplateTexts::where('certificate_template_id', $certificate_template_id)->delete();

        $template_texts=json_decode($request->get('template_texts'));
        foreach ($template_texts as $template_text) {
            CertificateTemplateTexts::create([
                'certificate_template_id'=>$certificate_template_id,
                'text'=>$template_text->text,
                'coordinates'=>json_encode($template_text->position),
                'font_size_css'=> '30px', //$template_text->font_size,
                'font_color_css'=>$template_text->font_color,
                'transform_css'=>$template_text->transform,
                'type'=>$template_text->type??CertificateTemplateTexts::OTHERS,

            ]);
        }

        return;
    }


    public function delete($id)
    {
        $item = CertificateTemplates::where([
            ['id', $id]
        ]);

        if ($item) {
            $item->delete();
            $message = 'تم الحذف بنجاح  ';
            $status = true;
            $response = [
                'message' => $message,
                'status' => $status,
            ];
            return $response;
        }
        $message = 'حدث خطأ غير متوقع';
        $status = false;

        $response = [
            'message' => $message,
            'status' => $status,
        ];

        return $response;
    }


    public function operation($request)
    {
        $id = $request->get('id');
        $operation = $request->get('operation');

        $item = CertificateTemplates::where([
            ['id', $id]
        ])->first();

        if ($item) {
            if($operation=='active') {
                $item->is_active = !@$item->is_active;
                $item->update();
            }

            if($operation=='default') {
                if($item->is_default==0) {
                    CertificateTemplates::query()
                    ->where('is_default', 1)
                    ->update([
                        'is_default'=>0
                    ]) ;
                }

                //
                $item->is_default = !@$item->is_default;
                $item->update();
            }

            $message = 'تمت العملية بنجاح';
            $status = true;
            $response = [
                'message' => $message,
                'status' => $status,
            ];
            return $response;
        }

        $message = 'حدث خطأ غير متوقع';
        $status = false;

        $response = [
            'message' => $message,
            'status' => $status,
        ];

        return $response;
    }

    public function certificateTestIssuance($id, $is_web = true)
    {

        try {

		$certificate_templates = CertificateTemplates::where('id', $id)->first();

		 $name = time() . ".jpeg";

			$user_data['name']="Omar Hassan";
			$user_data['courseTitle']="Web design course";
			$user_data['date']=date('Y-m-d');
			$user_data['lecturerName']="Ahmed Ail";

            $path = storage_path("app/certificates/test/" . $certificate_templates->id);
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
			$this->certificate_issuance->generate($id,$user_data,$path . '/' . $name);
            return response()->download($path . '/' . $name);


/*
            $template_texts = $certificate_templates->texts;

            $Arabic = new \I18N_Arabic('Glyphs');

            $extension = \File::extension($certificate_templates->background);

            //header('Content-type: image/jpeg');

            if($extension=='png') {
                $our_image = imagecreatefrompng(storage_path("app/uploads/images/".$certificate_templates->background));
            } else {
                $our_image = imagecreatefromjpeg(storage_path("app/uploads/images/".$certificate_templates->background));
            }
            $font_path = public_path("assets/front/certificate_settings/din-next-regular.ttf");
            $imagewidth = imagesx($our_image);
            //$size = 31;
            $angle = 0;

            foreach($template_texts as $template_text) {
                $size = floatval(str_replace('px', '', $template_text->font_size_css));
                $color_text=hexToRgb($template_text->font_color_css);
                $coordinates=json_decode($template_text->coordinates);
                if($template_text->type==CertificateTemplateTexts::STUDENT_NAME_LOCATION) {
                    $text= "محمد بدري مرتضى";
                    $left = $coordinates->left;
                    $top = (str_replace('px', '', $coordinates->top)+70);
                }elseif($template_text->type==CertificateTemplateTexts::COURSE_NAME_LOCATION){
                    $text= "الدورة الشاملة في التحكم الصناعي الآلي";
                    $left = $coordinates->left;
                    $top = (str_replace('px', '', $coordinates->top)+90);
                }elseif($template_text->type==CertificateTemplateTexts::LECTURER_NAME_LOCATION){
                    $text= "وائل علي الأحمد";
                    $left = $coordinates->left;
                    $top = (str_replace('px', '', $coordinates->top)+60);
                } elseif($template_text->type==CertificateTemplateTexts::CERTIFICATE_DATE){
                    $text= date('Y-m-d');
                    $left = $coordinates->left;
                    $top = (str_replace('px', '', $coordinates->top)+130);
                } else {
                    $text=strip_tags($template_text->text);
                    $left = $coordinates->left;
                    $top = (str_replace('px', '', $coordinates->top)+45);
                }
                $color = imagecolorallocate($our_image, $color_text['r'], $color_text['g'], $color_text['b']);
                $text = $Arabic->utf8Glyphs($text);
                $box = @imageTTFBbox($size, $angle, $font_path, $text);
                $textwidth = abs($box[4] - $box[0]);
                if($template_text->type==CertificateTemplateTexts::STUDENT_NAME_LOCATION) {
                    if($left>($imagewidth/2)) {
                        $left = ($left + $textwidth);
                    } else {
                        $left = $imagewidth - ($left + $textwidth);
                    }
                }elseif($template_text->type==CertificateTemplateTexts::COURSE_NAME_LOCATION){
                    if($left>($imagewidth/2)) {
                        $left = ($left + $textwidth);
                    } else {
                        $left = $imagewidth - ($left + $textwidth);
                    }
                }elseif($template_text->type==CertificateTemplateTexts::CERTIFICATE_DATE){
                    if($left>($imagewidth/2)) {
                        $left = ($left + $textwidth);
                    } else {
                        $left = ($left + $textwidth-200);
                    }
                } else {
                    $left = ($left + $textwidth);
                }
                imagettftext($our_image, $size, $angle, $left, $top, $color, $font_path, $text);
            }

            $name = time() . ".jpeg";

            $path = storage_path("app/certificates/test/" . $certificate_templates->id);
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            imagejpeg($our_image, $path . '/' . $name);

            return response()->download($path . '/' . $name);
			*/
        } catch (\Exception $e) {
            $message = 'حدث خطأ غير متوقع';
            return back();
        }
    }

}