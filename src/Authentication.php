<?php
/**
 * Copyright (c) 2016. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

/**
 * Created by PhpStorm.
 * User: frowhy
 * Date: 2016/9/18
 * Time: 14:25
 */

namespace Frowhy\Authentication;


/**
 * Class Token
 * @package Frowhy\Libraries
 */
class Authentication
{
    /**
     * @var int $__overtime 默认一分钟
     */
    private static $__overtime = 100000;

    /**
     * @param $str
     * @param string $salt
     * @return string
     */
    public static function make($str, $salt = '')
    {
        $time = TimeMillis::getTimeMillis();
        $timeHash = password_hash($time, PASSWORD_BCRYPT);
        $timeHashEncode = base64_encode($timeHash);
        $sign = base64_encode(Mcrypt::encrypt($str, $salt));
        $merge = $time . $timeHashEncode . $sign . $salt;
        $num = strlen($merge);
        for ($i = 0; $i < $num; $i++) {
            $array[$num - $i - 1] = substr($merge, $i, 1);
        }
        ksort($array);
        $string = implode('', $array);
        $token = base64_encode($string);
//        var_dump(['time' => $time, 'timeHash' => $timeHash, 'timeHashEncode' => $timeHashEncode, 'token' => $token]);
        return $token;
    }

    /**
     * @param $token
     * @return bool
     */
    public static function verify($token)
    {
        if (!$token) {
            return false;
        }
        $stringDeCode = base64_decode($token);
        $num = strlen($stringDeCode);
        for ($i = 0; $i < $num; $i++) {
            $array[$num - $i - 1] = substr($stringDeCode, $i, 1);
        }
        ksort($array);
        $string = implode('', $array);
        $time = substr($string, 0, 13);
        $timeHashEncode = substr($string, 13, 81);
        $timeHash = base64_decode($timeHashEncode);
//        var_dump(['time' => $time, 'timeHash' => $timeHash, 'timeHashEncode' => $timeHashEncode, 'token' => $token]);
        return TimeMillis::getTimeMillis() - $time < self::$__overtime && password_verify($time, $timeHash);
    }

    /**
     * @param $token
     * @param string $salt
     * @return bool|string
     */
    public static function get($token, $salt = '')
    {
        if (!$token) {
            return false;
        }
        $stringDeCode = base64_decode($token);
        $num = strlen($stringDeCode);
        for ($i = 0; $i < $num; $i++) {
            $array[$num - $i - 1] = substr($stringDeCode, $i, 1);
        }
        ksort($array);
        $string = implode('', $array);
        $saltLen = strlen($salt);
        $mcryptSalt = substr($string, $num - $saltLen, $num);
        $mcrypt = base64_decode(substr($string, 93, $num - $saltLen - 93));
        $sign = Mcrypt::decrypt($mcrypt, $mcryptSalt);
//        var_dump(['$mcrypt' => $mcrypt, '$mcryptSalt' => $mcryptSalt, '$sign' => $sign]);
        return $sign;
    }
}