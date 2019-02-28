<?php

namespace App\Service;

class UrlService
{
    public static function slug(string $text)
    {
        $text = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $text)));
        return $text;
    }
}