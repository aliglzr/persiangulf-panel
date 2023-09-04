<?php
return array(
    'dashboard' => array(
        'title' => 'پیشخوان',
        'description' => '',
        'view' => 'index',
        'layout' => array(
            'page-title' => array(
                'description' => true,
                'breadcrumb' => false,
            ),
        ),
        'assets' => array(
            'custom' => array(
                'js' => array(
                    'js/widgets.bundle.js',
                ),
            ),
            'vendors' => array('fullcalendar', 'amcharts', 'amcharts-maps'),
        ),
    ),

    'managers' => array(
        'title' => 'لیست مدیران',
        'assets' => array(
            'custom' => array(
                'css' => array(
                    'plugins/custom/datatables/datatables.bundle.css',
                ),
                'js' => array(
                    'plugins/custom/datatables/datatables.bundle.js',
                ),
            ),
        ),
        '*' => array(
            'title' => 'نمایه مدیر',
            'assets' => array(
                'custom' => array(
                    'css' => array(
                        'plugins/custom/datatables/datatables.bundle.css',
                    ),
                    'js' => array(
                        'plugins/custom/datatables/datatables.bundle.js',
                    ),
                ),
            ),
        ),
    ),


    'clients' => array(
        'title' => 'لیست مشتریان',
        '*' => array(
            'title' => 'لیست مشتریان',
            'assets' => array(
                'custom' => array(
                    'css' => array(
                        'plugins/custom/datatables/datatables.bundle.css',
                    ),
                    'js' => array(
                        'plugins/custom/datatables/datatables.bundle.js',
                    ),
                ),
            ),
        ),
    ),


    'plans' => array(
        'title' => 'لیست طرح ها',
        'assets' => array(
            'custom' => array(
                'css' => array(
                    'plugins/custom/datatables/datatables.bundle.css',
                ),
                'js' => array(
                    'plugins/custom/datatables/datatables.bundle.js',
                ),
            ),
        ),
//        '*'  => array(
//            'title'  => 'نمایه مدیر',
//            'assets' => array(
//                'custom' => array(
//                    'css' => array(
//                        'plugins/custom/datatables/datatables.bundle.css',
//                    ),
//                    'js'  => array(
//                        'plugins/custom/datatables/datatables.bundle.js',
//                    ),
//                ),
//            ),
//        ),
    ),

    'roles' => array(
        'title' => 'لیست نقش ها',
        'assets' => array(
            'custom' => array(
                'css' => array(
                    'plugins/custom/datatables/datatables.bundle.css',
                ),
                'js' => array(
                    'plugins/custom/datatables/datatables.bundle.js',
                ),
            ),
        ),
    ),

    'payments' => array(
        'title' => 'لیست پرداخت ها',
        'assets' => array(
            'custom' => array(
                'css' => array(
                    'plugins/custom/datatables/datatables.bundle.css',
                ),
                'js' => array(
                    'plugins/custom/datatables/datatables.bundle.js',
                ),
            ),
        ),
    ),

    'transactions' => array(
        'title' => 'لیست تراکنش ها',
        'assets' => array(
            'custom' => array(
                'css' => array(
                    'plugins/custom/datatables/datatables.bundle.css',
                ),
                'js' => array(
                    'plugins/custom/datatables/datatables.bundle.js',
                ),
            ),
        ),
    ),


    'invoices' => array(
        'title' => 'لیست فاکتور ها',
        'assets' => array(
            'custom' => array(
                'css' => array(
                    'plugins/custom/datatables/datatables.bundle.css',
                ),
                'js' => array(
                    'plugins/custom/datatables/datatables.bundle.js',
                ),
            ),
        ),
    ),

    'support' => array(
        'title' => 'پشتیبانی',
        'assets' => array(
            'custom' => array(
                'css' => array(
                    'plugins/custom/datatables/datatables.bundle.css',
                ),
                'js' => array(
                    'plugins/custom/datatables/datatables.bundle.js',
                ),
            ),
        ),
        'faq' => array(
            'title' => 'سوالات متداول',
            'assets' => array(
                'custom' => array(
                    'css' => array(
                        'plugins/custom/jkanban/jkanban.bundle.css',
                    ),
                    'js' => array(
                        'plugins/custom/jkanban/jkanban.bundle.js',
                    ),
                ),
            ),
        ),
        '*' => array(
            'title' => 'پشتیبانی',
            'assets' => array(
                'custom' => array(
                    'css' => array(
                        'plugins/custom/datatables/datatables.bundle.css',
                        'plugins/custom/jkanban/jkanban.bundle.css',

                    ),
                    'js' => array(
                        'plugins/custom/datatables/datatables.bundle.js',
                        'plugins/custom/jkanban/jkanban.bundle.js',
                    ),
                ),
            ),
        ),
    ),

    'layers' => array(
        'title' => 'مدیریت لایه ها',
        'assets' => array(
            'custom' => array(
                'css' => array(
                    'plugins/custom/datatables/datatables.bundle.css',
                ),
                'js' => array(
                    'plugins/custom/datatables/datatables.bundle.js',
                ),
            ),
        ),
        '*' => array(
            'title' => 'مدیریت لایه ها',
            'assets' => array(
                'custom' => array(
                    'css' => array(
                        'plugins/custom/datatables/datatables.bundle.css',
                    ),
                    'js' => array(
                        'plugins/custom/datatables/datatables.bundle.js',
                    ),
                ),
            ),
        ),
    ),

    'discounts' => array(
        'title' => 'مدیریت تخفیف ها',
        'assets' => array(
            'custom' => array(
                'css' => array(
                    'plugins/custom/datatables/datatables.bundle.css',
                ),
                'js' => array(
                    'plugins/custom/datatables/datatables.bundle.js',
                ),
            ),
        ),
        '*' => array(
            'title' => 'مدیریت تخفیف ها',
            'assets' => array(
                'custom' => array(
                    'css' => array(
                        'plugins/custom/datatables/datatables.bundle.css',
                    ),
                    'js' => array(
                        'plugins/custom/datatables/datatables.bundle.js',
                    ),
                ),
            ),
        ),
    ),


    'agents' => array(
        'title' => 'لیست نمایندگان',
        'assets' => array(
            'custom' => array(
                'css' => array(
                    'plugins/custom/datatables/datatables.bundle.css',
                ),
                'js' => array(
                    'plugins/custom/datatables/datatables.bundle.js',
                ),
            ),
        ),
        '*' => array(
            'title' => 'نمایه نماینده',
            'assets' => array(
                'custom' => array(
                    'css' => array(
                        'plugins/custom/datatables/datatables.bundle.css',
                    ),
                    'js' => array(
                        'plugins/custom/datatables/datatables.bundle.js',
                    ),
                ),
            ),
        ),
    ),

    'servers' => array(
        'title' => 'مدیریت سرور ها',
    ),

    'domains' => array(
        'title' => 'مدیریت دامنه ها',
    ),


    'logs' => array(
        'title' => 'نمایش لاگ ها',
        'assets' => array(
            'custom' => array(
                'css' => array(
                    'plugins/custom/datatables/datatables.bundle.css',
                ),
                'js' => array(
                    'plugins/custom/datatables/datatables.bundle.js',
                ),
            ),
        ),
        '*' => array(
            'title' => 'نمایش لاگ ها',
            'assets' => array(
                'custom' => array(
                    'css' => array(
                        'plugins/custom/datatables/datatables.bundle.css',
                    ),
                    'js' => array(
                        'plugins/custom/datatables/datatables.bundle.js',
                    ),
                ),
            ),
        ),
    ),

    'system' => array(
        'title' => 'سیستم',
        'assets' => array(
            'custom' => array(
                'css' => array(
                    'plugins/custom/datatables/datatables.bundle.css',
                ),
                'js' => array(
                    'plugins/custom/datatables/datatables.bundle.js',
                ),
            ),
        ),
        '*' => array(
            'title' => 'تنظیمات',
            'assets' => array(
                'custom' => array(
                    'css' => array(
                        'plugins/custom/datatables/datatables.bundle.css',
                    ),
                    'js' => array(
                        'plugins/custom/datatables/datatables.bundle.js',
                    ),
                ),
            ),
        ),
        'options' => array(
            'title' => 'تنظیمات',
        ),
    ),

    'login' => array(
        'title' => 'Login',
        'assets' => array(
            'custom' => array(
                'js' => array(
                    'js/custom/authentication/sign-in/general.js',
                ),
            ),
        ),
        'layout' => array(
            'main' => array(
                'type' => 'blank', // Set blank layout
                'body' => array(
                    'class' => theme()->isDarkMode() ? '' : 'bg-body',
                ),
            ),
        ),
    ),
    'register' => array(
        'title' => 'Register',
        'assets' => array(
            'custom' => array(
                'js' => array(
                    'js/custom/authentication/sign-up/general.js',
                ),
            ),
        ),
        'layout' => array(
            'main' => array(
                'type' => 'blank', // Set blank layout
                'body' => array(
                    'class' => theme()->isDarkMode() ? '' : 'bg-body',
                ),
            ),
        ),
    ),
    'forgot-password' => array(
        'title' => 'Forgot Password',
        'assets' => array(
            'custom' => array(
                'js' => array(
                    'js/custom/authentication/password-reset/password-reset.js',
                ),
            ),
        ),
        'layout' => array(
            'main' => array(
                'type' => 'blank', // Set blank layout
                'body' => array(
                    'class' => theme()->isDarkMode() ? '' : 'bg-body',
                ),
            ),
        ),
    ),

    'log' => array(
        'audit' => array(
            'title' => 'Audit Log',
            'assets' => array(
                'custom' => array(
                    'css' => array(
                        'plugins/custom/datatables/datatables.bundle.css',
                    ),
                    'js' => array(
                        'plugins/custom/datatables/datatables.bundle.js',
                    ),
                ),
            ),
        ),
        'system' => array(
            'title' => 'System Log',
            'assets' => array(
                'custom' => array(
                    'css' => array(
                        'plugins/custom/datatables/datatables.bundle.css',
                    ),
                    'js' => array(
                        'plugins/custom/datatables/datatables.bundle.js',
                    ),
                ),
            ),
        ),
    ),

    'error' => array(
        'error-404' => array(
            'title' => 'Error 404',
        ),
        'error-500' => array(
            'title' => 'Error 500',
        ),
    ),

    'account' => array(
        'overview' => array(
            'title' => 'Account Overview',
            'view' => 'account/overview/overview',
            'assets' => array(
                'custom' => array(
                    'js' => array(
                        'js/custom/widgets.js',
                    ),
                ),
            ),
        ),

        'settings' => array(
            'title' => 'Account Settings',
            'assets' => array(
                'custom' => array(
                    'js' => array(
                        'js/custom/account/settings/profile-details.js',
                        'js/custom/account/settings/signin-methods.js',
                        'js/custom/modals/two-factor-authentication.js',
                    ),
                ),
            ),
        ),
    ),

    'users' => array(
        'title' => 'User List',
        '*' => array(
            'title' => 'Show User',

            'edit' => array(
                'title' => 'Edit User',
            ),
        ),
    ),
);
