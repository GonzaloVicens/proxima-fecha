<?php
namespace Proyecto\Tools;

class Hash
{
    public static function encrypt($value)
    {
        return password_hash($value, PASSWORD_DEFAULT);
    }

    public static function verify($value, $hash)
    {
        return password_verify($value, $hash);
    }
}