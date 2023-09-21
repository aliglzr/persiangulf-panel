<?php

return array(

    // Horizontal menu
    'horizontal' => array(
        // Dashboard
        array(
            'title' => 'خرید طرح',
            'path' => '/plans/buy',
            'classes' => array('item' => 'me-lg-1'),
        ),

        array(
            'title' => 'خرید اشتراک',
            'path' => '/buy',
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
        ),

        // Resources
        array(
            'title' => 'ثبت اشتراک',
            'classes' => array('item' => 'menu-lg-down-accordion me-lg-1', 'arrow' => 'd-lg-none'),
            'attributes' => array(
                'data-bs-toggle' => "modal",
                'data-bs-target' => "#quickAccessRenewSubscriptionModal",
            ),
        ),
        array(
            'title' => 'ثبت مشتری',
            'classes' => array('item' => 'menu-lg-down-accordion me-lg-1', 'arrow' => 'd-lg-none'),
            'attributes' => array(
                'data-bs-toggle' => "modal",
                'data-bs-target' => "#addSubscriptionModal",
            ),
        ),
    ),
);
