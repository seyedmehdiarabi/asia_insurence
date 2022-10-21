<?php
$array['public'] = [
    'label' => 'دسترسی های عمومی',
    'access' => [
        'view_shop' => ['label' => 'نمایش صفحه نخست'],
        'desk' => ['label' => 'نمایش میزکار', 'routes' => ['admin_panel']],
        'profile' => ['label' => 'پروفایل کاربری'],
    ]];
$array['galleries'] = [
    'label' => 'گالری تصاویر',
    'access' => [
        'galleries_edit' => ['label' => 'ثبت و ویرایش گالری تصاویر', 'routes' => [
            'pics.index', 'pics.create', 'pics.store', 'pics.edit', 'pics.update'
        ]],
        'remove_galleries' => ['label' => 'حذف گالری تصاویر', 'routes' => ['pics.index', 'pics.destory']],
        'restore_galleries' => ['label' => 'بازیابی گالری تصاویر', 'routes' => ['pics.index', 'pics.restore']]
    ],
];
$array['orders'] = [
    'label' => 'سفارشات',
    'access' => [
        'order_list' => ['label' => 'مدیریت سفارشات', 'routes' => ['orders.index', 'orders.show']],
        'change_status' => ['label' => 'تغییر وضعیت سفارش', 'routes' => ['order.change_status','change_order_status']],
        'order.destroy' => ['label' => 'حذف سفارش', 'routes' => ['orders.index', 'orders.destroy']],
        'order.restore' => ['label' => 'بازیابی سفارش', 'routes' => ['orders.index', 'orders.restore']],
        'submissions' => ['label' => 'مدیریت مرسوله ها', 'routes' => ['orders.submissions', 'submissions_info', 'submissions_factor']],
        'submission_approved' => ['label' => ' مرسوله های تایید شده', 'routes' => ['orders.submissions_approved', 'submissions_info', 'submissions_factor']],
        'items_today' => ['label' => 'مرسوله های ارسالی امروز', 'routes' => ['orders.items_today', 'submissions_info', 'submissions_factor']],
        'submissions_ready' => ['label' => 'مرسوله های اماده ارسال', 'routes' => ['orders.submissions_ready', 'submissions_info', 'submissions_factor']],
        'postings_sent' => ['label' => 'مرسوله های ارسال شده به پست', 'routes' => ['orders.postings_sent', 'submissions_info', 'submissions_factor']],
        'postings_receive' => ['label' => 'مرسوله های آماده دریافت از پست', 'routes' => ['orders.postings_receive', 'submissions_info', 'submissions_factor']],
        'delivered_shipping' => ['label' => 'مرسوله های تحویل داده شده', 'routes' => ['orders.delivered_shipping', 'submissions_info', 'submissions_factor']],
        'return_product' => ['label' => 'مرجوع کردن سفارش', 'routes' => ['orders.index', 'orders.return_product_list', 'return-product']],
    ]
];
$array['stockrooms'] = [
    'label' => 'انبار',
    'access' => [
        'stockroom_edit' => ['label' => 'مدیریت انبار ها', 'routes' => [
            'stockrooms.index', 'stockrooms.show', 'stockrooms.create', 'stockrooms.store', 'stockrooms.edit', 'stockrooms.update'
        ]],
        'add_input' => ['label' => 'ثبت ورودی انبار', 'routes' => ['stockroom.input', 'stockroom.show_input', 'stockroom.add_product', 'stockroom.add_input', 'get_product_warrnty', 'stockroom.input_factor']],
        'add_output' => ['label' => 'ثبت خروجی انبار', 'routes' => ['stockroom.output', 'stockroom.show_output', 'stockroom.show_output', 'stockroom.add_output', 'get_inventory', 'stockroom.output_factor']],
        'package' => ['label' => 'مدیریت محموله ها', 'routes' => ['packages.index', 'packages.show', 'packages.destory', 'packages.restore']]
    ]
];
$array['report'] = [
    'label' => 'گزارشات',
    'access' => [
        'report_sale' => ['label' => 'آمار فروش فروشگاه', 'routes' => ['sale_report', 'get_sale_report']],
        'report_view' => ['label' => 'آمار بازید', 'routes' => []],
        'commission' => ['label' => 'کمیسیون ها', 'routes' => ['commissions.index', 'commissions.edit', 'commissions.update', 'commissions.create', 'commissions.store',
            'commissions.destroy', 'commissions.restore']],
        'payment' => ['label' => 'پرداخت ها', 'routes' => ['payments']],
    ]
];
$array['finance'] = [
    'label' => 'امور مالی',
    'access' => [
        'custompayment' => ['label' => 'واریزی‌های دلخواه', 'routes' => [
            'custompayment.index', 'custompayment.destroy', 'custompayment.restore'
        ]],
        'transaction' => ['label' => 'ثبت پرداختی کاربران', 'routes' => [
            'transaction.index', 'transaction.create', 'transaction.store', 'transaction.edit', 'transaction.update', 'transaction.destroy', 'transaction.restore'
        ]],
    ]
];
$array['setting'] = [
    'label' => 'تنظیمات',
    'access' => [
        'enamad_edit' => ['label' => 'مدیریت مجوزها', 'routes' => [
            'enamad.index', 'enamad.create', 'enamad.store', 'enamad.edit', 'enamad.update', 'enamad.destroy', 'enamad.restore'
        ]],
        'order_price' => ['label' => 'هزینه ارسال سفارشات', 'routes' => ['send_order_price']],
        'send_type' => ['label' => 'انواع ارسال سفارشات', 'routes' => [
            'send_type.index', 'send_type.create', 'send_type.store', 'send_type.edit', 'send_type.update', 'send_type.destroy', 'send_type.restore'
        ]],
        'warranties_edit' => ['label' => 'مدیریت گارانتی‌ها', 'routes' => [
            'warranties.index', 'warranties.create', 'warranties.store', 'warranties.edit', 'warranties.update', 'warranties.destroy', 'warranties.restore'
        ]],
        'brands_edit' => ['label' => 'مدیریت برندها', 'routes' => [
            'brands.index', 'brands.create', 'brands.store', 'brands.edit', 'brands.update', 'brands.destroy', 'brands.restore'
        ]],
        'colors_edit' => ['label' => 'مدیریت رنگ‌ها', 'routes' => [
            'colors.index', 'colors.create', 'colors.store', 'colors.edit', 'colors.update', 'colors.destroy', 'colors.restore'
        ]],
    ]
];
$array['service'] = [
    'label' => 'مدیریت سرویس',
    'access' => [
        'service' => ['label' => 'مدیریت سرویس', 'routes' => [
            'service'
        ]],
    ]
];
