<?php

namespace App\Helpers;

class StringHelper
{
    /**
     * Viết hoa chữ cái đầu tiên trong chuỗi Unicode (hỗ trợ tiếng Việt)
     */
    public static function mbUcFirst(string $string, string $encoding = 'UTF-8'): string
    {
        $firstChar = mb_substr($string, 0, 1, $encoding);
        $rest = mb_substr($string, 1, null, $encoding);

        return mb_strtoupper($firstChar, $encoding) . $rest;
    }
}
