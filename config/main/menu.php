<?php

use App\Core\Adapters\Theme;

return array(
    'demo6-aside' => array(
        // Dashboard
        'dashboard'     => array(
            "title"      => "پیشخان",
            "icon"       => '<i class="bi bi-house fs-2"></i>',
            "attributes" => array(
                'link' => array(
                    "data-bs-trigger"   => "hover",
                    "data-bs-dismiss"   => "click",
                    "data-bs-placement" => "right",
                ),
            ),
            "classes"    => array(
                "item" => "py-2",
                "link" => "menu-center",
                "icon" => "me-0",
            ),
            "path"       => "/",
        ),

        // Managers
        'managers'    => array(
            "title"      => "اعضا",
            "icon"       => '<i class="bi bi-people-fill fs-2"></i>',
            "classes"    => array(
                "item" => "py-2",
                "link" => "menu-center",
                "icon" => "me-0",
            ),
            "attributes" => array(
                "item" => array(
                    "data-kt-menu-trigger"   => "click",
                    "data-kt-menu-placement" => Theme::isRTL() ? "left-start" : "right-start",
                ),
                'link' => array(
                    "data-bs-trigger"   => "hover",
                    "data-bs-dismiss"   => "click",
                    "data-bs-placement" => "right",
                ),
            ),
            "arrow"      => false,
            "sub"        => array(
                "class" => "menu-sub-dropdown w-225px px-1 py-4",
                "items" => array(
                    array(
                        'classes' => array('content' => ''),
                        'content' => '<span class="menu-section fs-5 fw-bolder ps-1 py-1">مدیریت اعضا</span>',
                    ),

                    array(
                        'title'      => 'لیست مدیران',
                        'path'       => 'managers',
                        'bullet'     => '<span class="bullet bullet-dot"></span>',
                        'attributes' => array(
                            'link' => array(
                                "title"             => "نمایش فهرستی از مدیران",
                                "data-bs-toggle"    => "tooltip",
                                "data-bs-trigger"   => "hover",
                                "data-bs-dismiss"   => "click",
                                "data-bs-placement" => "right",
                            ),
                        ),
                    ),
                    array(
                        'title'      => 'لیست نمایندگان',
                        'path'       => 'agents',
                        'bullet'     => '<span class="bullet bullet-dot"></span>',
                        'attributes' => array(
                            'link' => array(
                                "title"             => "نمایش فهرست نمایندگان",
                                "data-bs-toggle"    => "tooltip",
                                "data-bs-trigger"   => "hover",
                                "data-bs-dismiss"   => "click",
                                "data-bs-placement" => "right",
                            ),
                        ),
                    ),
                    array(
                        'title'      => 'لیست مشتریان',
                        'path'       => 'clients',
                        'bullet'     => '<span class="bullet bullet-dot"></span>',
                        'attributes' => array(
                            'link' => array(
                                "title"             => "نمایش فهرست مشتریان",
                                "data-bs-toggle"    => "tooltip",
                                "data-bs-trigger"   => "hover",
                                "data-bs-dismiss"   => "click",
                                "data-bs-placement" => "right",
                            ),
                        ),
                    ),
                ),
            ),
        ),

        // Agents
//        'agents'    => array(
//            "title"      => "نمایندگان",
//            "role"       => "agent",
//            "icon"       => '<i class="bi bi-people-fill fs-2"></i>',
//            "classes"    => array(
//                "item" => "py-2",
//                "link" => "menu-center",
//                "icon" => "me-0",
//            ),
//            "attributes" => array(
//                "item" => array(
//                    "data-kt-menu-trigger"   => "click",
//                    "data-kt-menu-placement" => Theme::isRTL() ? "left-start" : "right-start",
//                ),
//                'link' => array(
//                    "data-bs-trigger"   => "hover",
//                    "data-bs-dismiss"   => "click",
//                    "data-bs-placement" => "right",
//                ),
//            ),
//            "arrow"      => false,
//            "sub"        => array(
//                "class" => "menu-sub-dropdown w-225px px-1 py-4",
//                "items" => array(
//                    array(
//                        'classes' => array('content' => ''),
//                        'content' => '<span class="menu-section fs-5 fw-bolder ps-1 py-1">مدیریت نمایندگان</span>',
//                    ),
//
//                    array(
//                        'title'      => 'لیست نمایندگان',
//                        'path'       => '/agents',
//                        'bullet'     => '<span class="bullet bullet-dot"></span>',
//                        'attributes' => array(
//                            'link' => array(
//                                "title"             => "نمایش فهرستی از نمایندگان",
//                                "data-bs-toggle"    => "tooltip",
//                                "data-bs-trigger"   => "hover",
//                                "data-bs-dismiss"   => "click",
//                                "data-bs-placement" => "right",
//                            ),
//                        ),
//                    ),
//                    array(
//                        'title'  => 'افزودن نماینده جدید',
//
//                        'path'   => '/agents/create',
//                        'bullet' => '<span class="bullet bullet-dot"></span>',
//                    ),
//                ),
//            ),
//        ),

        // Plans
        'plans'    => array(
            "title"      => "طرح ها",
            "icon"       => '<i class="bi bi-layers fs-2"></i>',
            "role"       => array('agent','manager','support'),
            "classes"    => array(
                "item" => "py-2",
                "link" => "menu-center",
                "icon" => "me-0",
            ),
            "attributes" => array(
                "item" => array(
                    "data-kt-menu-trigger"   => "click",
                    "data-kt-menu-placement" => Theme::isRTL() ? "left-start" : "right-start",
                ),
                'link' => array(
                    "data-bs-trigger"   => "hover",
                    "data-bs-dismiss"   => "click",
                    "data-bs-placement" => "right",
                ),
            ),
            "arrow"      => false,
            "sub"        => array(
                "class" => "menu-sub-dropdown w-225px px-1 py-4",
                "items" => array(
                    array(
                        'classes' => array('content' => ''),
                        'content' => '<span class="menu-section fs-5 fw-bolder ps-1 py-1">مدیریت طرح ها</span>',
                    ),

                    array(
                        'title'      => 'لیست طرح ها',
                        'path'       => 'plans',
                        'bullet'     => '<span class="bullet bullet-dot"></span>',
                        'attributes' => array(
                            'link' => array(
                                "title"             => "نمایش طرح ها",
                                "data-bs-toggle"    => "tooltip",
                                "data-bs-trigger"   => "hover",
                                "data-bs-dismiss"   => "click",
                                "data-bs-placement" => "right",
                            ),
                        ),
                    ),
                    array(
                        'title'      => 'تغییر قیمت',
                        'path'       => '#',
                        'bullet'     => '<span class="bullet bullet-dot"></span>',
                        'attributes' => array(
                            'link' => array(
                                "title"             => "تغییر قیمت طرح و اشتراک مستقیم",
                                "data-bs-toggle"    => "modal",
                                "data-bs-target"   => "#changePrice",
                            ),
                        ),
                    ),
                    array(
                        'title'      => 'خرید طرح',
                        'path'       => 'plans/buy',
                        'bullet'     => '<span class="bullet bullet-dot"></span>',
                        'attributes' => array(
                            'link' => array(
                                "title"             => "خرید طرح",
                                "data-bs-toggle"    => "tooltip",
                                "data-bs-trigger"   => "hover",
                                "data-bs-dismiss"   => "click",
                                "data-bs-placement" => "right",
                            ),
                        ),
                    ),
                    array(
                        'title'      => 'ثبت اشتراک',
                        'path'       => '#',
                        'bullet'     => '<span class="bullet bullet-dot"></span>',
                        'attributes' => array(
                            'link' => array(
                                "title"             => "تمدید اشتراک برای مشتری",
                                "data-bs-toggle"    => "modal",
                                "data-bs-target"   => "#quickAccessRenewSubscriptionModal",
                            ),
                        ),
                    ),
                    array(
                        'title'      => 'ثبت مشتری',
                        'path'       => '#',
                        'bullet'     => '<span class="bullet bullet-dot"></span>',
                        'attributes' => array(
                            'link' => array(
                                "title"             => "ثبت مشتری جدید",
                                "data-bs-toggle"    => "modal",
                                "data-bs-target"   => "#addSubscriptionModal",
                            ),
                        ),
                    )
                ),
            ),
        ),


        // Plans
        'clientPlan'    => array(
            "title"      => "اشتراک",
            "role"       => "client",
            "icon"       => '<i class="bi bi-layers fs-2"></i>',
            "classes"    => array(
                "item" => "py-2",
                "link" => "menu-center",
                "icon" => "me-0",
            ),
            "attributes" => array(
                "item" => array(
                    "data-kt-menu-trigger"   => "click",
                    "data-kt-menu-placement" => Theme::isRTL() ? "left-start" : "right-start",
                ),
                'link' => array(
                    "data-bs-trigger"   => "hover",
                    "data-bs-dismiss"   => "click",
                    "data-bs-placement" => "right",
                ),
            ),
            "arrow"      => false,
            "sub"        => array(
                "class" => "menu-sub-dropdown w-225px px-1 py-4",
                "items" => array(
                    array(
                        'classes' => array('content' => ''),
                        'content' => '<span class="menu-section fs-5 fw-bolder ps-1 py-1">اشتراک</span>',
                    ),

                    array(
                        'title'      => 'خرید اشتراک',
                        'path'       => 'buy',
                        'bullet'     => '<span class="bullet bullet-dot"></span>',
                        'attributes' => array(
                            'link' => array(
                                "title"             => "خرید اشتراک",
                                "data-bs-toggle"    => "tooltip",
                                "data-bs-trigger"   => "hover",
                                "data-bs-dismiss"   => "click",
                                "data-bs-placement" => "right",
                            ),
                        ),
                    ),
                    array(
                        'title'      => 'اشتراک ها',
                        'path'       => 'my-subscriptions',
                        'bullet'     => '<span class="bullet bullet-dot"></span>',
                        'attributes' => array(
                            'link' => array(
                                "title"             => "اشتراک ها",
                                "data-bs-toggle"    => "tooltip",
                                "data-bs-trigger"   => "hover",
                                "data-bs-dismiss"   => "click",
                                "data-bs-placement" => "right",
                            ),
                        ),
                    ),
                ),
            ),
        ),

        // Plans
        'discount_vouchers'    => array(
            "title"      => "تخفیف",

            "icon"       => '<i class="bi bi-percent fs-2"></i>',
            "classes"    => array(
                "item" => "py-2",
                "link" => "menu-center",
                "icon" => "me-0",
            ),
            "attributes" => array(
                "item" => array(
                    "data-kt-menu-trigger"   => "click",
                    "data-kt-menu-placement" => Theme::isRTL() ? "left-start" : "right-start",
                ),
                'link' => array(
                    "data-bs-trigger"   => "hover",
                    "data-bs-dismiss"   => "click",
                    "data-bs-placement" => "right",
                ),
            ),
            "arrow"      => false,
            "sub"        => array(
                "class" => "menu-sub-dropdown w-225px px-1 py-4",
                "items" => array(
                    array(
                        'classes' => array('content' => ''),
                        'content' => '<span class="menu-section fs-5 fw-bolder ps-1 py-1">مدیریت تخفیف ها</span>',
                    ),

                    array(
                        'title'      => 'لیست تخفیف ها',
                        'path'       => 'discounts',
                        ''           => 'view-discount-table',
                        'bullet'     => '<span class="bullet bullet-dot"></span>',
                        'attributes' => array(
                            'link' => array(
                                "title"             => "نمایش تخفیف ها",
                                "data-bs-toggle"    => "tooltip",
                                "data-bs-trigger"   => "hover",
                                "data-bs-dismiss"   => "click",
                                "data-bs-placement" => "right",
                            ),
                        ),
                    ),
                ),
            ),
        ),

        // Financial
        'financial'    => array(
            "title"      => "امور مالی",
            "icon"       => '<i class="bi bi-currency-dollar fs-2"></i>',
            "classes"    => array(
                "item" => "py-2",
                "link" => "menu-center",
                "icon" => "me-0",
            ),
            "attributes" => array(
                "item" => array(
                    "data-kt-menu-trigger"   => "click",
                    "data-kt-menu-placement" => Theme::isRTL() ? "left-start" : "right-start",
                ),
                'link' => array(
                    "data-bs-trigger"   => "hover",
                    "data-bs-dismiss"   => "click",
                    "data-bs-placement" => "right",
                ),
            ),
            "arrow"      => false,
            "sub"        => array(
                "class" => "menu-sub-dropdown w-225px px-1 py-4",
                "items" => array(
                    array(
                        'classes' => array('content' => ''),
                        'content' => '<span class="menu-section fs-5 fw-bolder ps-1 py-1">امور مالی</span>',
                    ),
                    array(
                        'title'      => 'لیست پرداختی ها',
                        'path'       => 'payments',
                        'bullet'     => '<span class="bullet bullet-dot"></span>',
                        'attributes' => array(
                            'link' => array(
                                "title"             => "نمایش لیست پرداخت ها",
                                "data-bs-toggle"    => "tooltip",
                                "data-bs-trigger"   => "hover",
                                "data-bs-dismiss"   => "click",
                                "data-bs-placement" => "right",
                            ),
                        ),
                    ),
                    array(
                        'title'      => 'لیست صورتحساب ها',
                        'path'       => 'invoices',
                        'bullet'     => '<span class="bullet bullet-dot"></span>',
                        'attributes' => array(
                            'link' => array(
                                "title"             => "نمایش لیست صورتحساب ها",
                                "data-bs-toggle"    => "tooltip",
                                "data-bs-trigger"   => "hover",
                                "data-bs-dismiss"   => "click",
                                "data-bs-placement" => "right",
                            ),
                        ),
                    ),
                    array(
                        'title'      => 'لیست تراکنش ها',
                        'path'       => 'transactions',
                        'bullet'     => '<span class="bullet bullet-dot"></span>',
                        'attributes' => array(
                            'link' => array(
                                "title"             => "نمایش لیست تراکنش ها",
                                "data-bs-toggle"    => "tooltip",
                                "data-bs-trigger"   => "hover",
                                "data-bs-dismiss"   => "click",
                                "data-bs-placement" => "right",
                            ),
                        ),
                    ),
                    array(
                        'title'      => 'پرداختی ها',
                        'path'       => 'my-payments',
                        'bullet'     => '<span class="bullet bullet-dot"></span>',
                        'attributes' => array(
                            'link' => array(
                                "title"             => "نمایش لیست پرداخت ها",
                                "data-bs-toggle"    => "tooltip",
                                "data-bs-trigger"   => "hover",
                                "data-bs-dismiss"   => "click",
                                "data-bs-placement" => "right",
                            ),
                        ),
                    ),
                    array(
                        'title'      => 'صورتحساب ها',
                        'path'       => 'my-invoices',
                        'bullet'     => '<span class="bullet bullet-dot"></span>',
                        'attributes' => array(
                            'link' => array(
                                "title"             => "نمایش لیست صورتحساب ها",
                                "data-bs-toggle"    => "tooltip",
                                "data-bs-trigger"   => "hover",
                                "data-bs-dismiss"   => "click",
                                "data-bs-placement" => "right",
                            ),
                        ),
                    ),
                    array(
                        'title'      => 'تراکنش ها',
                        'path'       => 'my-transactions',
                        'bullet'     => '<span class="bullet bullet-dot"></span>',
                        'attributes' => array(
                            'link' => array(
                                "title"             => "نمایش لیست تراکنش ها",
                                "data-bs-toggle"    => "tooltip",
                                "data-bs-trigger"   => "hover",
                                "data-bs-dismiss"   => "click",
                                "data-bs-placement" => "right",
                            ),
                        ),
                    ),
                ),
            ),
        ),

        // Servers
        'servers'   => array(
            "title"      => "سرور",
            "icon"       => '<i class="bi bi-server fs-2"></i>',
            "classes"    => array(
                "item" => "py-2",
                "link" => "menu-center",
                "icon" => "me-0",
            ),
            "attributes" => array(
                "item" => array(
                    "data-kt-menu-trigger"   => "click",
                    "data-kt-menu-placement" => Theme::isRTL() ? "left-start" : "right-start",
                ),
                'link' => array(
                    "data-bs-trigger"   => "hover",
                    "data-bs-dismiss"   => "click",
                    "data-bs-placement" => "right",
                ),
            ),
            "arrow"      => false,
            "sub"        => array(
                "class" => "menu-sub-dropdown w-225px px-1 py-4",
                "items" => array(
                    array(
                        'classes' => array('content' => ''),
                        'content' => '<span class="menu-section fs-5 fw-bolder ps-1 py-1">مدیریت سرور ها</span>',
                    ),

                    array(
                        'title'  => 'لیست سرور ها',
                        'path'   => 'servers',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                    ),
                    array(
                        'title'  => 'لیست لایه ها',
                        'path'   => 'layers',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                    ),
                    array(
                        'title'  => 'لیست دامنه ها',
                        'path'   => 'domains',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                    ),
                ),
            ),
        ),

        // System
        'system'    => array(
            "title"      => "سیستم",
            "role"      => "manager",
            "icon"       => '<i class="bi bi-layers fs-2"></i>',
            "classes"    => array(
                "item" => "py-2",
                "link" => "menu-center",
                "icon" => "me-0",
            ),
            "attributes" => array(
                "item" => array(
                    "data-kt-menu-trigger"   => "click",
                    "data-kt-menu-placement" => Theme::isRTL() ? "left-start" : "right-start",
                ),
                'link' => array(
                    "data-bs-trigger"   => "hover",
                    "data-bs-dismiss"   => "click",
                    "data-bs-placement" => "right",
                ),
            ),
            "arrow"      => false,
            "sub"        => array(
                "class" => "menu-sub-dropdown w-225px px-1 py-4",
                "items" => array(
                    array(
                        'classes' => array('content' => ''),
                        'content' => '<span class="menu-section fs-5 fw-bolder ps-1 py-1">سیستم</span>',
                    ),
                    array(
                        'title'      => 'تنظیمات',
                        'path'       => 'system/options',
                        'bullet'     => '<span class="bullet bullet-dot"></span>',
                        'attributes' => array(
                            'link' => array(
                                "data-bs-toggle"    => "tooltip",
                                "data-bs-trigger"   => "hover",
                                "data-bs-dismiss"   => "click",
                                "data-bs-placement" => "right",
                            ),
                        ),
                    ),
                    array(
                        'title'      => 'تنظیمات ربات فروش',
                        'path'       => 'system/bot/sales/options',
                        'bullet'     => '<span class="bullet bullet-dot"></span>',
                        'attributes' => array(
                            'link' => array(
                                "data-bs-toggle"    => "tooltip",
                                "data-bs-trigger"   => "hover",
                                "data-bs-dismiss"   => "click",
                                "data-bs-placement" => "right",
                            ),
                        ),
                    ),
                    array(
                        'title'  => 'لاگ ها',
                        'path'   => 'system/logs',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                    ),
                    array(
                        'title'  => 'لاگ سیستم',
                        'path'   => 'system',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                    ),
                    array(
                        'title'  => 'دسترسی',
                        'path'   => 'roles',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                    ),
                ),
            ),
        ),

//        // System
//        'mail'    => array(
//            "title"      => "ایمیل",
//            "role"      => "manager",
//            "icon"       => '<i class="bi bi-mailbox fs-2"></i>',
//            "classes"    => array(
//                "item" => "py-2",
//                "link" => "menu-center",
//                "icon" => "me-0",
//            ),
//            "attributes" => array(
//                "item" => array(
//                    "data-kt-menu-trigger"   => "click",
//                    "data-kt-menu-placement" => Theme::isRTL() ? "left-start" : "right-start",
//                ),
//                'link' => array(
//                    "data-bs-trigger"   => "hover",
//                    "data-bs-dismiss"   => "click",
//                    "data-bs-placement" => "right",
//                ),
//            ),
//            "arrow"      => false,
//            "sub"        => array(
//                "class" => "menu-sub-dropdown w-225px px-1 py-4",
//                "items" => array(
//                    array(
//                        'classes' => array('content' => ''),
//                        'content' => '<span class="menu-section fs-5 fw-bolder ps-1 py-1">ارسال ایمیل</span>',
//                    ),
//
//                    array(
//                        'title'      => 'لیست ایمیل ها',
//
//                        'path'       => '/mailables',
//                        'bullet'     => '<span class="bullet bullet-dot"></span>',
//                        'attributes' => array(
//                            'link' => array(
//                                "data-bs-toggle"    => "tooltip",
//                                "data-bs-trigger"   => "hover",
//                                "data-bs-dismiss"   => "click",
//                                "data-bs-placement" => "right",
//                            ),
//                        ),
//                    ),
//                    array(
//                        'title'      => 'لیست قالب ها',
//                        'path'       => '/mailables/templates',
//
//                        'bullet'     => '<span class="bullet bullet-dot"></span>',
//                        'attributes' => array(
//                            'link' => array(
//                                "data-bs-toggle"    => "tooltip",
//                                "data-bs-trigger"   => "hover",
//                                "data-bs-dismiss"   => "click",
//                                "data-bs-placement" => "right",
//                            ),
//                        ),
//                    ),
//                ),
//            ),
//        ),

        // support
        'support'    => array(
            "title"      => "پشتیبانی",
            "icon"       => '<i class="bi bi-headset fs-2"></i>',
            "classes"    => array(
                "item" => "py-2",
                "link" => "menu-center",
                "icon" => "me-0",
            ),
            "attributes" => array(
                "item" => array(
                    "data-kt-menu-trigger"   => "click",
                    "data-kt-menu-placement" => Theme::isRTL() ? "left-start" : "right-start",
                ),
                'link' => array(
                    "data-bs-trigger"   => "hover",
                    "data-bs-dismiss"   => "click",
                    "data-bs-placement" => "right",
                ),
            ),
            "arrow"      => false,
            "sub"        => array(
                "class" => "menu-sub-dropdown w-225px px-1 py-4",
                "items" => array(
                    array(
                        'classes' => array('content' => ''),
                        'content' => '<span class="menu-section fs-5 fw-bolder ps-1 py-1">پشتیبانی</span>',
                    ),
                    array(
                        'title'      => 'تیکت ها',
                        'path'       => 'support/tickets',
                        'bullet'     => '<span class="bullet bullet-dot"></span>',
                        'attributes' => array(
                            'link' => array(
                                "data-bs-toggle"    => "tooltip",
                                "data-bs-trigger"   => "hover",
                                "data-bs-dismiss"   => "click",
                                "data-bs-placement" => "right",
                            ),
                        ),
                    ),
                    array(
                        'title'  => 'سوالات متداول',
                        'path'   => 'support/faq',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                    ),
                    array(
                        'title'  => 'آموزش',
                        'path'   => 'support/tutorials',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                    ),
                ),
            ),
        ),
    ),
);
