<?php


namespace App\Core\Extensions\Verta;


use App\Core\Extensions\Verta\Traits\PersianFormatting;

class Verta extends \Hekmatinasser\Verta\Verta {
    use PersianFormatting;

    protected array $digits = array(
        0 => 'صفر',
        1 => 'یک',
        2 => 'دو',
        3 => 'سه',
        4 => 'چهار',
        5 => 'پنج',
        6 => 'شش',
        7 => 'هفت',
        8 => 'هشت',
        9 => 'نه',
    );
    protected array $twoDigits = array(
        1 => 'یازده',
        2 => 'دوازده',
        3 => 'سیزده',
        4 => 'چهارده',
        5 => 'پانزده',
        6 => 'شانزده',
        7 => 'هفده',
        8 => 'هجده',
        9 => 'نوزده',
    );
    protected array $decimalDigits = array(
        1 => 'ده',
        2 => 'بیست',
        3 => 'سی',
        4 => 'چهل',
        5 => 'پنجاه',
        6 => 'شصت',
        7 => 'هفتاد',
        8 => 'هشتاد',
        9 => 'نود'
    );
    protected array $threeDigits = array(
        1 => 'صد',
        2 => 'دویست',
        3 => 'سیصد',
        4 => 'چهارصد',
        5 => 'پانصد',
        6 => 'ششصد',
        7 => 'هفتصد',
        8 => 'هشتصد',
        9 => 'نهصد',
    );
    protected array $steps = array(
        1 => 'هزار',
        2 => 'میلیون',
        3 => 'بیلیون',
        4 => 'تریلیون',
        5 => 'کادریلیون',
        6 => 'کوینتریلیون',
        7 => 'سکستریلیون',
        8 => 'سپتریلیون',
        9 => 'اکتریلیون',
        10 => 'نونیلیون',
        11 => 'دسیلیون',
    );

    public static function numberToWords($number, $lang = 'en'): string {
        $decimal = '';
        $postfix = '';
        if (str_contains(strval($number), '.')) {
            $arr = explode('.', $number);
            if (count($arr) == 2 && ($lang == 'fa' || $lang == 'en')) {
                if ($lang == 'fa') {
                    if($arr[0] == 0) {
                        $decimal = 'صفر ممیز ';
                    } else {
                        $decimal = notowo($arr[0], $lang) . ' ممیز ';
                    }
                } else {
                    if($arr[0] == 0) {
                        $decimal = 'zero point ';
                    } else {
                        $decimal = notowo($arr[0], $lang) . ' point ';
                    }
                }
                $number = $arr[1];
                $strNumber = strval($number);
                if ($lang == 'fa') {
                    if (mb_strlen($strNumber) == 1) {
                        $postfix = "دهم";
                    } else if (mb_strlen($strNumber) == 2) {
                        $postfix = "صدم";
                    } else if (mb_strlen($strNumber) >= 3) {
                        if ((mb_strlen($strNumber) - 1) % 3 == 0) {
                            $postfix = "ده ";
                        } else if ((mb_strlen($strNumber) - 2) % 3 == 0) {
                            $postfix = "صد ";
                        }
                        $postfix .= (new Verta())->steps[(mb_strlen($strNumber) - 3) / 3 + 1] . "م";
                    }
                    $postfix = ' ' . $postfix;
                    $number = notowo($number, $lang);

                } else {
                    $digits = range(0, 9);
                    $words = ['zero ', 'one ', 'two ', 'three ', 'four ', 'five ', 'six ', 'seven ', 'eight ', 'nine '];
                    $number = notowo(str_replace($digits, $words, $number), $lang);

                }
            } else {
                $number = notowo(str_replace('.', '', $number), $lang);
            }
        } else {
            $number = notowo(str_replace('.', '', $number), $lang);
        }
        return $decimal . $number . $postfix;
    }

    public static function months(string $calender = 'ja'): array {
        $months = [
            'gr' => [
                /** [ MONTH_NAME ,          DaysCount */
                [__("months.January"),     31],
                [__("months.February"),    29],
                [__("months.March"),       31],
                [__("months.April"),       30],
                [__("months.May"),         31],
                [__("months.June"),        30],
                [__("months.July"),        31],
                [__("months.August"),      31],
                [__("months.September"),   30],
                [__("months.October"),     31],
                [__("months.November"),    30],
                [__("months.December"),    31],
            ],
            'ja' => [
                [__("months.Farvardin"),   31],
                [__('months.Ordibehesht'), 31],
                [__('months.Khordad'),     31],
                [__('months.Tir'),         31],
                [__('months.Mordad'),      31],
                [__('months.Shahrivar'),   31],
                [__('months.Mehr'),        30],
                [__('months.Aban'),        30],
                [__('months.Azar'),        30],
                [__('months.Dey'),         30],
                [__('months.Bahman'),      30],
                [__('months.Esfand'),      30],
            ]
        ];

        return $months[$calender];
    }

    public static function convertNumbers($string, $mod = 'fa'): array|string {
        $num_a = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
        $key_a = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
        return ($mod == 'fa') ? str_replace($num_a, $key_a, $string) : str_replace($key_a, $num_a, $string);
    }
}
