<?php

return array(
    // Main menu
    'main' => array(
        //// Dashboard
        array(
            'title' => 'Dashboard',
            'path' => '',
            'icon' => theme()->getSvgIcon("demo1/media/icons/duotune/art/art002.svg", "svg-icon-2"),
        ),

        //// Modules
        array(
            'classes' => array('content' => 'pt-8 pb-2'),
            'content' => '<span class="menu-section text-muted text-uppercase fs-8 ls-1">Modules</span>',
        ),

        // Account
        array(
            'title' => 'Account',
            'icon' => array(
                'svg' => theme()->getSvgIcon("demo1/media/icons/duotune/communication/com006.svg", "svg-icon-2"),
                'font' => '<i class="bi bi-person fs-2"></i>',
            ),
            'classes' => array('item' => 'menu-accordion'),
            'attributes' => array(
                "data-kt-menu-trigger" => "click",
            ),
            'sub' => array(
                'class' => 'menu-sub-accordion menu-active-bg',
                'items' => array(
                    array(
                        'title' => 'Overview',
                        'path' => 'account/overview',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                    ),
                    array(
                        'title' => 'Settings',
                        'path' => 'account/settings',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                    ),
                    array(
                        'title' => 'Security',
                        'path' => '#',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                        'attributes' => array(
                            'link' => array(
                                "title" => "Coming soon",
                                "data-bs-toggle" => "tooltip",
                                "data-bs-trigger" => "hover",
                                "data-bs-dismiss" => "click",
                                "data-bs-placement" => "right",
                            ),
                        ),
                    ),
                ),
            ),
        ),

        // System
        array(
            'title' => 'System',
            'icon' => array(
                'svg' => theme()->getSvgIcon("demo1/media/icons/duotune/general/gen025.svg", "svg-icon-2"),
                'font' => '<i class="bi bi-layers fs-3"></i>',
            ),
            'classes' => array('item' => 'menu-accordion'),
            'attributes' => array(
                "data-kt-menu-trigger" => "click",
            ),
            'sub' => array(
                'class' => 'menu-sub-accordion menu-active-bg',
                'items' => array(
                    array(
                        'title' => 'Settings',
                        'path' => '#',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                        'attributes' => array(
                            'link' => array(
                                "title" => "Coming soon",
                                "data-bs-toggle" => "tooltip",
                                "data-bs-trigger" => "hover",
                                "data-bs-dismiss" => "click",
                                "data-bs-placement" => "right",
                            ),
                        ),
                    ),
                    array(
                        'title' => 'Audit Log',
                        'path' => 'log/audit',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                    ),
                    array(
                        'title' => 'System Log',
                        'path' => 'log/system',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                    ),
                    array(
                        'title' => 'Error 404',
                        'path' => 'error/error-404',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                    ),
                    array(
                        'title' => 'Error 500',
                        'path' => 'error/error-500',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                    ),
                ),
            ),
        ),

        //// Help
        array(
            'classes' => array('content' => 'pt-8 pb-2'),
            'content' => '<span class="menu-section text-muted text-uppercase fs-8 ls-1">Help</span>',
        ),

        // Documentation
        array(
            'title' => 'Documentation',
            'icon' => theme()->getSvgIcon("demo1/media/icons/duotune/abstract/abs027.svg", "svg-icon-2"),
            'path' => 'documentation/getting-started/overview',
        ),

        // Changelog
        array(
            'title' => 'Changelog v' . theme()->getVersion(),
            'icon' => theme()->getSvgIcon("demo1/media/icons/duotune/coding/cod003.svg", "svg-icon-2"),
            'path' => 'documentation/getting-started/changelog',
        ),

    ),

    // Horizontal menu
    'horizontal' => array(
        // Dashboard
        array(
            'title' => 'خرید طرح',
            'path' => '/plans/buy',
            'role' => 'agent',
            'classes' => array('item' => 'me-lg-1'),
        ),

        array(
            'title' => 'خرید اشتراک',
            'path' => '/buy',
            'role' => 'client',
            'classes' => array('item' => 'me-lg-1'),
        ),

        // Resources
        array(
            'title' => 'تیکت جدید',
            'classes' => array('item' => 'menu-lg-down-accordion me-lg-1', 'arrow' => 'd-lg-none'),
            'attributes' => array(
                'data-bs-toggle' => "modal",
                'data-bs-target' => "#submit_ticket_modal",
            ),
            'role' => array(
                'client', 'agent'
            )
        ),

        // Resources
        array(
            'title' => 'ثبت اشتراک',
            'classes' => array('item' => 'menu-lg-down-accordion me-lg-1', 'arrow' => 'd-lg-none'),
            'attributes' => array(
                'data-bs-toggle' => "modal",
                'data-bs-target' => "#quickAccessRenewSubscriptionModal",
            ),
            'role' => array(
                'agent'
            )
        ),
        array(
            'title' => 'ثبت مشتری',
            'classes' => array('item' => 'menu-lg-down-accordion me-lg-1', 'arrow' => 'd-lg-none'),
            'attributes' => array(
                'data-bs-toggle' => "modal",
                'data-bs-target' => "#addSubscriptionModal",
            ),
            'role' => array(
                'agent'
            )
        ),
    ),
);
