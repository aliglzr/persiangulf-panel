<?php

use Illuminate\Support\Facades\DB;

if (!function_exists('get_svg_icon')) {
    function get_svg_icon($path, $class = null, $svgClass = null)
    {
        if (strpos($path, 'media') === false) {
            $path = theme()->getMediaUrlPath() . $path;
        }

        $file_path = public_path($path);

        if (!file_exists($file_path)) {
            return '';
        }

        $svg_content = file_get_contents($file_path);

        if (empty($svg_content)) {
            return '';
        }

        $dom = new DOMDocument();
        $dom->loadXML($svg_content);

        // remove unwanted comments
        $xpath = new DOMXPath($dom);
        foreach ($xpath->query('//comment()') as $comment) {
            $comment->parentNode->removeChild($comment);
        }

        // add class to svg
        if (!empty($svgClass)) {
            foreach ($dom->getElementsByTagName('svg') as $element) {
                $element->setAttribute('class', $svgClass);
            }
        }

        // remove unwanted tags
        $title = $dom->getElementsByTagName('title');
        if ($title['length']) {
            $dom->documentElement->removeChild($title[0]);
        }
        $desc = $dom->getElementsByTagName('desc');
        if ($desc['length']) {
            $dom->documentElement->removeChild($desc[0]);
        }
        $defs = $dom->getElementsByTagName('defs');
        if ($defs['length']) {
            $dom->documentElement->removeChild($defs[0]);
        }

        // remove unwanted id attribute in g tag
        $g = $dom->getElementsByTagName('g');
        foreach ($g as $el) {
            $el->removeAttribute('id');
        }
        $mask = $dom->getElementsByTagName('mask');
        foreach ($mask as $el) {
            $el->removeAttribute('id');
        }
        $rect = $dom->getElementsByTagName('rect');
        foreach ($rect as $el) {
            $el->removeAttribute('id');
        }
        $xpath = $dom->getElementsByTagName('path');
        foreach ($xpath as $el) {
            $el->removeAttribute('id');
        }
        $circle = $dom->getElementsByTagName('circle');
        foreach ($circle as $el) {
            $el->removeAttribute('id');
        }
        $use = $dom->getElementsByTagName('use');
        foreach ($use as $el) {
            $el->removeAttribute('id');
        }
        $polygon = $dom->getElementsByTagName('polygon');
        foreach ($polygon as $el) {
            $el->removeAttribute('id');
        }
        $ellipse = $dom->getElementsByTagName('ellipse');
        foreach ($ellipse as $el) {
            $el->removeAttribute('id');
        }

        $string = $dom->saveXML($dom->documentElement);

        // remove empty lines
        $string = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $string);

        $cls = array('svg-icon');

        if (!empty($class)) {
            $cls = array_merge($cls, explode(' ', $class));
        }

        $asd = explode('/media/', $path);
        if (isset($asd[1])) {
            $path = 'assets/media/' . $asd[1];
        }

        $output = "<!--begin::Svg Icon | path: $path-->\n";
        $output .= '<span class="' . implode(' ', $cls) . '">' . $string . '</span>';
        $output .= "\n<!--end::Svg Icon-->";

        return $output;
    }
}

if (!function_exists('theme')) {
    /**
     * Get the instance of Theme class core
     *
     * @return \App\Core\Adapters\Theme|\Illuminate\Contracts\Foundation\Application|mixed
     */
    function theme()
    {
        return app(\App\Core\Adapters\Theme::class);
    }
}

if (!function_exists('util')) {
    /**
     * Get the instance of Util class core
     *
     * @return \App\Core\Adapters\Util|\Illuminate\Contracts\Foundation\Application|mixed
     */
    function util()
    {
        return app(\App\Core\Adapters\Util::class);
    }
}

if (!function_exists('bootstrap')) {
    /**
     * Get the instance of Util class core
     *
     * @return \App\Core\Adapters\Util|\Illuminate\Contracts\Foundation\Application|mixed
     * @throws Throwable
     */
    function bootstrap()
    {
        $bootstrap = "\App\Core\Bootstraps\Bootstrap";

        if (!class_exists($bootstrap)) {
            abort(404, 'Demo has not been set or ' . $bootstrap . ' file is not found.');
        }

        return app($bootstrap);
    }
}

if (!function_exists('assetCustom')) {
    /**
     * Get the asset path of RTL if this is an RTL request
     *
     * @param $path
     * @param null $secure
     *
     * @return string
     */
    function assetCustom($path)
    {
        // Include rtl css file
        if (isRTL()) {
            return asset(dirname($path) . '/' . basename($path, '.css') . '.rtl.css');
        }

        // Include dark style css file
        if (theme()->isDarkModeEnabled() && theme()->getCurrentMode() !== 'light') {
            $darkPath = str_replace('.bundle', '.' . theme()->getCurrentMode() . '.bundle', $path);
            if (file_exists(public_path($darkPath))) {
                return asset($darkPath);
            }
        }

        // Include default css file
        return asset($path);
    }
}

if (!function_exists('isRTL')) {
    /**
     * Check if the request has RTL param
     *
     * @return bool
     */
    function isRTL()
    {
        return true;
        return request()->input('rtl') || (DB::getSchemaBuilder()->hasTable('settings') && setting('layout.rtl') === 'true');
    }
}

if (!function_exists('preloadCss')) {
    /**
     * Preload CSS file
     *
     * @return bool
     */
    function preloadCss($url)
    {
        return '<link rel="preload" href="' . $url . '" as="style" onload="this.onload=null;this.rel=\'stylesheet\'" type="text/css"><noscript><link rel="stylesheet" href="' . $url . '"></noscript>';
    }
}
if (!function_exists('formatBytes')) {

    function formatBytes($bytes, $precision = 2, $lang = "fa")
    {
        $units = array('بایت', 'کیلوبایت', 'مگابایت', 'گیگابایت', 'ترابایت');
        if ($lang == "en") {
            $units = array('B', 'KB', 'MB', 'GB', 'TB');
        }

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        // Uncomment one of the following alternatives
        $bytes /= pow(1024, $pow);
        // $bytes /= (1 << (10 * $pow));

        if ($lang == "en") {
            return round($bytes, $precision) . $units[$pow];
        }

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}

if (!function_exists('getRequestUri')) {
    function getRequestUri(string $url)
    {
        $uri = explode('/', $url);
        unset($uri[0]);
        unset($uri[1]);
        unset($uri[2]);
        return '/' . implode('/', $uri);
    }
}


if (!function_exists('applyDynamicHost')) {
    function applyDynamicHost($host)
    {
        app('url')->forceRootUrl("https://" . $host . "/");
    }
}


if (!function_exists('std_to_array')) {
    function std_to_array(object $stdClass)
    {
        return json_decode(json_encode($stdClass), true);
    }

}
if (!function_exists('convertNumbers')) {
    function convertNumbers($string, $mod = 'fa'): array|string
    {
        $num_a = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
        $key_a = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
        return ($mod == 'fa') ? str_replace($num_a, $key_a, $string) : str_replace($key_a, $num_a, $string);
    }
}
if (!function_exists('ip_range')) {
    function ip_range($start, $end): array
    {
        $start = ip2long($start);
        $end = ip2long($end);
        return array_map('long2ip', range($start, $end));
    }
}
if (!function_exists('string_to_color')) {
    function string_to_color($str): string
    {
        $hash = 0;
        for ($i = 0; $i < strlen($str); $i++) {
            $hash = ord($str[$i]) + (($hash << 5) - $hash);
        }
        $colour = '#';
        for ($i = 0; $i < 3; $i++) {
            $value = ($hash >> ($i * 8)) & 0xFF;
            $colour .= str_pad(dechex($value), 2, '0', STR_PAD_LEFT);
        }
        return $colour;
    }

}

if (!function_exists('countryToFlag')) {
    function countryToFlag(string $countryCode): string
    {
        return (string)preg_replace_callback(
            '/./',
            static fn(array $letter) => mb_chr(ord($letter[0]) % 32 + 0x1F1E5),
            $countryCode
        );
    }
}

