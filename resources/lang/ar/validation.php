<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | such as the size rules. Feel free to tweak each of these messages.
    |
    */

    'message' => 'البيانات المدخلة غير صالحة',
    'student_name' => 'يجب على :attribute أن يكون اسما من ثلاث خانات',
    'accepted' => 'يجب قبول :attribute',
    'active_url' => ':attribute لا يُمثّل رابطًا صحيحًا',
    'after' => 'يجب على :attribute أن يكون تاريخًا لاحقًا للتاريخ :date.',
    'after_or_equal' => ':attribute يجب أن يكون تاريخاً لاحقاً أو مطابقاً للتاريخ :date.',
    'alpha' => 'يجب أن لا يحتوي :attribute سوى على حروف',
    'alpha_dash' => 'يجب أن لا يحتوي :attribute على حروف، أرقام ومطّات.',
    'alpha_num' => 'يجب أن يحتوي :attribute على حروفٍ وأرقامٍ فقط',
    'array' => 'يجب أن يكون :attribute ًمصفوفة',
    'before' => 'يجب على :attribute أن يكون تاريخًا سابقًا للتاريخ :date.',
    'before_or_equal' => ':attribute يجب أن يكون تاريخا سابقا أو مطابقا للتاريخ :date',
    'between' => [
        'numeric' => 'يجب أن تكون قيمة :attribute بين :min و :max.',
        'file' => 'يجب أن يكون حجم الملف :attribute بين :min و :max كيلوبايت.',
        'string' => 'يجب أن يكون عدد حروف النّص :attribute بين :min و :max',
        'array' => 'يجب أن يحتوي :attribute على عدد من العناصر بين :min و :max',
    ],
    'boolean' => 'يجب أن تكون قيمة :attribute إما true أو false ',
    'confirmed' => 'حقل التأكيد غير مُطابق للحقل :attribute',
    'date' => ':attribute ليس تاريخًا صحيحًا',
    'date_format' => 'لا يتوافق :attribute مع الشكل :format.',
    'different' => 'يجب أن يكونان :attribute و :other مُختلفان',
    'digits' => 'يجب أن يحتوي :attribute على :digits رقمًا/أرقام',
    'digits_between' => 'يجب أن يحتوي :attribute بين :min و :max رقمًا/أرقام ',
    'dimensions' => 'الـ :attribute يحتوي على أبعاد صورة غير صالحة.',
    'distinct' => 'للحقل :attribute قيمة مُكرّرة.',
    'email' => 'يجب أن يكون :attribute صحيح البُنية',
    'exists' => ':attribute غير موجود',
    'file' => 'الـ :attribute يجب أن يكون من ملفا.',
    'filled' => ':attribute إجباري',
    'image' => 'يجب أن يكون :attribute صورةً',
    'in' => ':attribute المدخل غير مدعوم',
    'in_array' => ':attribute غير موجود في :other.',
    'integer' => 'يجب أن يكون :attribute عددًا صحيحًا',
    'ip' => 'يجب أن يكون :attribute عنوان IP ذا بُنية صحيحة',
    'ipv4' => 'يجب أن يكون :attribute عنوان IPv4 ذا بنية صحيحة.',
    'ipv6' => 'يجب أن يكون :attribute عنوان IPv6 ذا بنية صحيحة.',
    'json' => 'يجب أن يكون :attribute نصا من نوع JSON.',
    'max' => [
        'numeric' => 'يجب أن تكون قيمة :attribute مساوية أو أصغر لـ :max.',
        'file' => 'يجب أن لا يتجاوز حجم الملف :attribute :max كيلوبايت',
        'string' => 'يجب أن لا يتجاوز طول النّص :attribute :max حروفٍ/حرفًا',
        'array' => 'يجب أن لا يحتوي :attribute على أكثر من :max عناصر/عنصر.',
    ],
    'mimes' => 'يجب أن يكون ملفًا من نوع : :values.',
    'mimetypes' => 'يجب أن يكون ملفًا من نوع : :values.',
    'min' => [
        'numeric' => 'يجب أن تكون قيمة :attribute مساوية أو أكبر لـ :min.',
        'file' => 'يجب أن يكون حجم الملف :attribute على الأقل :min كيلوبايت',
        'string' => 'يجب أن يكون طول النص :attribute على الأقل :min حروفٍ/حرفًا',
        'array' => 'يجب أن يحتوي :attribute على الأقل على :min عُنصرًا/عناصر',
    ],
    'not_in' => ':attribute لاغٍ',
    'numeric' => 'يجب على :attribute أن يكون رقمًا',
    'present' => 'يجب تقديم :attribute',
    'regex' => 'صيغة :attribute .غير صحيحة',
    'required' => ':attribute مطلوب.',
    'required_if' => ':attribute مطلوب في حال ما إذا كان :other يساوي :value.',
    'required_unless' => ':attribute مطلوب في حال ما لم يكن :other يساوي :values.',
    'required_with' => ':attribute مطلوب لانك ادخلت :values.',
    'required_with_all' => ':attribute إذا توفّر :values.',
    'required_without' => ':attribute إذا لم يتوفّر :values.',
    'required_without_all' => ':attribute إذا لم يتوفّر :values.',
    'same' => 'يجب أن يتطابق :attribute مع :other',
    'size' => [
        'numeric' => 'يجب أن تكون قيمة :attribute مساوية لـ :size',
        'file' => 'يجب أن يكون حجم الملف :attribute :size كيلوبايت',
        'string' => 'يجب أن يحتوي النص :attribute على :size حروفٍ/حرفًا بالظبط',
        'array' => 'يجب أن يحتوي :attribute على :size عنصرٍ/عناصر بالظبط',
    ],
    'string' => 'يجب أن يكون :attribute نصآ.',
    'timezone' => 'يجب أن يكون :attribute نطاقًا زمنيًا صحيحًا',
    'unique' => 'قيمة :attribute مُستخدمة من قبل',
    'uploaded' => 'فشل في تحميل الـ :attribute',
    'url' => 'صيغة الرابط :attribute غير صحيحة',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */


    'custom' => [
        'mobile' => [
            'unique' => 'رقم الموبايل مسجل بالفعل',
        ],
        'email' => [
            'unique' => 'البريد الالكترونى  مسجل بالفعل',
        ],
        'username' => [
            'unique' => 'اسم المستخدم  مسجل بالفعل',
        ],
        'agree_conditions' => [
            'required' => 'يرجى الموافقة على الشروط والاحكام',
        ],
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'name' => 'الاسم',
        'sulg' => 'مفتاح الصفحة',
        'mobile'=>'الجوال',
        'email'=>'البريد الالكترونى',
        'username'=>'اسم المستخدم',
        'password'=>'كلمة المرور',
        'file'=>'الملف او الصورة',
        'gender'=>'الجنس',
        'code_1'=>'كود التفعيل',
        'code_2'=>'كود التفعيل',
        'code_3'=>'كود التفعيل',
        'code_4'=>'كود التفعيل',
        'code_5'=>'كود التفعيل',
        'code_6'=>'كود التفعيل',
        'city'=>'المدينة',
        'id_image'=>'صورة الهوية',
        'job_proof_image'=>'إثبات المهنة',
        'cv_file'=>'السيره الذاتية',
        'video'=>'الفيديو',
        'start_date'=>'تاريخ البدء',
        'num_free_lesson' => 'عدد الدروس المجانية',
        'allow_fee_installments' => 'السماح بتقسيط الرسوم',
        'monthly_installment' => 'القسط الشهري',
        'installment_period_months' => 'مدة القسط',
        'allow_fee_refunds' => 'السماح باسترداد الرسوم',
        'allowed_fee_refund_period'=>'مدة استرداد الرسوم',
        "description"=>"الوصف",
        "details"=>"التفاصيل",
        "days"=>'الايام',
        "course_id"=>'الدورة',
        "lecturer_id"=>'المحاضر',
        "level_id"=>'المستوى',
        "group_id"=>'المجموعة',
        "num_students"=>'عدد الطلبة',
        'background'=>'الخلفية',
        'cover_image'=>'صورة الغلاف',
        'suggested_date_id'=>'الموعد المقترح',
        'bio'=>'نبذة مختصرة',
        "account_num"=> "رقم الحساب",
        "ipan"=> "الإيبان",
        "bank"=> "البنك",
        "about"=>"نبذة",
        "dob"=> "تاريخ الميلاد"
    ],
    "installment_not_foud"=> "لا يوجد أقساط متاحة لهذه الدورة.",
    "installment_not_Free"=> "القسط التالي ليس مجاني",






];
