<?php


namespace App\Core\Extensions\Verta\Traits;


trait PersianFormatting
{
    public function persianFormat($format): array|string {
        $formatted = $this->format($format);
        $num_a = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
        $key_a = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
        return str_replace($num_a, $key_a, $formatted);
    }
}
