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
 *
 * @package    Frowhy\Libraries
 */
class AuthenticationSSL
{
    /**
     * @var int $__overtime 默认一分钟
     */
    private static $__overtime = 100000;

    /**
     * @param        $str
     * @param        $keys
     *
     * @return string
     * @internal param string $salt
     */
    public static function make($str, $keys)
    {
        if (TRUE === array_key_exists('public_key', $keys)) {
            $openSSL        = new OpenSSL();
            $time           = TimeMillis::getTimeMillis();
            $timeHash       = password_hash($time, PASSWORD_BCRYPT);
            $timeHashEncode = base64_encode($timeHash);
            $sign           = $openSSL
                ->setPublicKey($keys['public_key'])
                ->encrypt($str);
            $merge          = $time . $timeHashEncode . $sign;
            $num            = strlen($merge);
            for ($i = 0; $i < $num; $i++) {
                $array[ $num - $i - 1 ] = substr($merge, $i, 1);
            }
            ksort($array);
            $string = implode('', $array);
            $token  = base64_encode($string);

            //            var_dump(['time' => $time, 'timeHash' => $timeHash, 'timeHashEncode' => $timeHashEncode, 'token' => $token, 'sign' => $sign]);

            return $token;
        } else {
            return FALSE;
        }
    }

    /**
     * @param $token
     *
     * @return bool
     */
    public static function verify($token)
    {
        if (!$token) {
            return FALSE;
        }
        $stringDeCode = base64_decode($token);
        $num          = strlen($stringDeCode);
        for ($i = 0; $i < $num; $i++) {
            $array[ $num - $i - 1 ] = substr($stringDeCode, $i, 1);
        }
        ksort($array);
        $string         = implode('', $array);
        $time           = (int)substr($string, 0, 13);
        $timeHashEncode = substr($string, 13, 81);
        $timeHash       = base64_decode($timeHashEncode);

        //        var_dump(['time' => $time, 'timeHash' => $timeHash, 'timeHashEncode' => $timeHashEncode, 'token' => $token]);
        return TimeMillis::getTimeMillis() - $time < self::$__overtime && password_verify($time, $timeHash);
    }

    /**
     * @param        $token
     * @param        $keys
     *
     * @return bool|string
     * @internal param string $salt
     */
    public static function get($token, $keys)
    {
        if (FALSE === empty($token) && TRUE === array_key_exists('private_key', $keys)) {
            $openSSL      = new OpenSSL();
            $stringDeCode = base64_decode($token);
            $num          = strlen($stringDeCode);
            for ($i = 0; $i < $num; $i++) {
                $array[ $num - $i - 1 ] = substr($stringDeCode, $i, 1);
            }
            ksort($array);
            $string    = implode('', $array);
            $encrypted = substr($string, 93, $num - 93);
            $sign      = $openSSL
                ->setPrivateKey($keys['private_key'])
                ->decrypt($encrypted);

            //        var_dump(['$DES3Str' => $DES3Str, '$DES3Salt' => $DES3Salt, '$sign' => $sign]);
            return $sign;
        } else {
            return FALSE;
        }
    }
}