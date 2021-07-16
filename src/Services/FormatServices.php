<?php


namespace App\Services;


class FormatServices
{
    public function TelFormat($tel): ?string
    {
        $str = '+33'. $tel;
        return $str;
    }
    public function TelFormatTwig($tel): ?string
    {
        $str = '0'. $tel;
        $res = substr($str, 0, 2) .' ';
        $res .= substr($str, 2, 2) .' ';
        $res .= substr($str, 4, 2) .' ';
        $res .= substr($str, 6, 2) .' ';
        $res .= substr($str, 8, 2) .' ';
        $res .= substr($str, 10, 2) .' ';
        return $res;
    }
}