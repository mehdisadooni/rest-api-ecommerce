<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    "accepted" => ":attribute باید پذیرفته شده باشد.",
    "active_url" => "آدرس :attribute معتبر نیست",
    "after" => ":attribute باید تاریخی بعد از :date باشد.",
    "alpha" => ":attribute باید شامل حروف الفبا باشد.",
    "alpha_dash" => ":attribute باید شامل حروف الفبا و عدد و خظ تیره(-) باشد.",
    "alpha_num" => ":attribute باید شامل حروف الفبا و عدد باشد.",
    "alpha_spaces" => ':attribute باید به صورت اعداد و حروف انگلیسی و بدون فاصله باشد.',
    "array" => ":attribute باید شامل آرایه باشد.",
    "before" => ":attribute باید تاریخی قبل از :date باشد.",
    "between" => array(
        "numeric" => ":attribute باید بین :min و :max باشد.",
        "file" => ":attribute باید بین :min و :max کیلوبایت باشد.",
        "string" => ":attribute باید بین :min و :max کاراکتر باشد.",
        "array" => ":attribute باید بین :min و :max آیتم باشد.",
    ),
    "boolean" => "The :attribute field must be true or false",
    "confirmed" => ":attribute با تاییدیه مطابقت ندارد.",
    "date" => ":attribute یک تاریخ معتبر نیست.",
    "date_format" => ":attribute با الگوی :format مطاقبت ندارد.",
    "different" => ":attribute و :other باید متفاوت باشند.",
    "digits" => ":attribute باید :digits رقم باشد.",
    "digits_between" => ":attribute باید بین :min و :max رقم باشد.",
    "email" => "فرمت :attribute معتبر نیست.",
    "exists" => ":attribute انتخاب شده، معتبر نیست.",
    "image" => "فرمت :attribute معتبر نیست.",
    "in" => ":attribute انتخاب شده، معتبر نیست.",
    "integer" => ":attribute باید نوع داده ای عددی (integer) باشد.",
    "ip" => ":attribute باید IP آدرس معتبر باشد.",
    "max" => array(
        "numeric" => ":attribute نباید بزرگتر از :max باشد.",
        "file" => ":attribute نباید بزرگتر از :max کیلوبایت باشد.",
        "string" => ":attribute نباید بیشتر از :max کاراکتر باشد.",
        "array" => ":attribute نباید بیشتر از :max آیتم باشد.",
    ),
    "mimes" => ":attribute باید یکی از فرمت های :values باشد.",
    "min" => array(
        "numeric" => ":attribute نباید کوچکتر از :min باشد.",
        "file" => ":attribute نباید کوچکتر از :min کیلوبایت باشد.",
        "string" => ":attribute نباید کمتر از :min کاراکتر باشد.",
        "array" => ":attribute نباید کمتر از :min آیتم باشد.",
    ),
    "not_in" => ":attribute انتخاب شده، معتبر نیست.",
    "numeric" => ":attribute باید شامل عدد باشد.",
    "regex" => ":attribute یک فرمت معتبر نیست",
    "required" => "وارد کردن فیلد :attribute الزامی است.",
    "required_if" => "فیلد :attribute هنگامی که :other برابر با :value است، الزامیست.",
    "required_with" => ":attribute الزامی است زمانی که :values موجود است.",
    "required_with_all" => ":attribute الزامی است زمانی که :values موجود است.",
    "required_without" => ":attribute الزامی است زمانی که :values موجود نیست.",
    "required_without_all" => ":attribute الزامی است زمانی که :values موجود نیست.",
    "same" => ":attribute و :other باید مانند هم باشند.",
    "size" => array(
        "numeric" => ":attribute باید برابر با :size باشد.",
        "file" => ":attribute باید برابر با :size کیلوبایت باشد.",
        "string" => ":attribute باید برابر با :size کاراکتر باشد.",
        "array" => ":attribute باسد شامل :size آیتم باشد.",
    ),
    "timezone" => "The :attribute must be a valid zone.",
    "unique" => ":attribute وارد شده قبلا ثبت شده است، لطفا :attribute دیگر انتخاب کنید.",
    "url" => "فرمت آدرس :attribute اشتباه است.",

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

    'custom' => array(),

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
    'attributes' => array(
        "name" => "نام",
        "user_id" => "کاربر",
        "email" => "ایمیل",
        "password" => "رمز عبور",
        "password_confirmation" => "تاییدیه ی رمز عبور",
        "address" => "نشانی",
        "tell" => "تلفن",
        "mobile" => "تلفن همراه",
        "age" => "سن",
        "sex" => "جنسیت",
        "title" => "عنوان",
        "about" => "متن",
        "content" => "محتوا",
        "subject" => "موضوع",
        "description" => "توضیح کوتاه",
        "date" => "تاریخ",
        "time" => "تاریخ",
        "size" => "اندازه",
        "body" => "محتوا",
        "img" => "تصویر",
        "video" => "ویدیو",
        "slug" => "آدرس",
        "tag" => "تگ",
        "cat" => "دسته بندی",
        "category" => "دسته بندی",
        "cats" => "دسته بندی",
        "code" => "کد",
        "percent" => "درصد",
        "capacity" => "ظرفیت",
        "type" => "نوع",
        "why" => "علت",
        "value" => "مقدار",
        "lang" => "lang",
        "source_name" => "منبع خبر",
        "source_link" => "لینک منبع خبر",
        "sort" => "اولویت",
        "state" => "وضعیت",
        "parent_id" => "سردسته",
        "icon" => "آیکون",
        "gallery" => "گالری",
        "imagefile" => "تصویر",
        "file" => "فایل",
        "ip" => "آی پی",
        "position" => "موقعیت",
        "url" => "آدرس",
        "link" => "آدرس",
        "view_count" => "بازدید",
        "label" => "نام",
        "active" => "وضعیت",
        "group" => "گروه کاربری",
        "meli" => "کد ملی",
        "postal_code" => "کد پستی",
        "country" => "کشور",
        "region" => "استان",
        "city" => "شهر",
        "web" => "وب‌سایت",
        "company" => "شرکت",
        "fax" => "فکس",
        "nick_name" => "نام مستعار",
        "permission" => "مجوز",
        "first_name" => "نام",
        "last_name" => "نام خانوادگی",
        "fa_name" => "نام فارسی",
        "en_name" => "نام لاتین",
        "scientific_name" => "نام علمی",
        "priority" => "اولویت",
        "unit" => "واحد",
        "display_name" => 'نام نمایشی'
    ),
);
