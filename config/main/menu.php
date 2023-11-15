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
    ),
);
