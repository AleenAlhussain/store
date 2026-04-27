<?php
if (! function_exists('env')) {
    function env($key, $default = null) {
        // ...
    }
}
if (! function_exists('str_slug')) {
    function str_slug($string, $delimiter = '-')
    {
        $string = preg_replace("/[~`{}.'\"\!\@\#\$\%\^\&\*\(\)\_\=\+\/\?\>\<\,\[\]\:\;\|\\\]/", "", $string);
        $string = preg_replace("/[\/_|+ -]+/", $delimiter, $string);
        return $string;

    }
}
