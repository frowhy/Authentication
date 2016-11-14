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
 * Date: 2016/11/14
 * Time: 17:55
 */

namespace Frowhy\Authentication;

class Mcrypt
{
    /**
     * @param $decrypted
     * @param $password
     * @param string $salt
     * @return bool|string
     */
    public static function encrypt($decrypted, $password, $salt = '')
    {
        $key = hash('SHA256', $salt . $password, true);
        srand();
        $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC), MCRYPT_RAND);
        if (strlen($iv_base64 = rtrim(base64_encode($iv), '=')) != 22) return false;
        $encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $decrypted . md5($decrypted), MCRYPT_MODE_CBC, $iv));
        return $iv_base64 . $encrypted;
    }

    /**
     * @param $encrypted
     * @param $password
     * @param string $salt
     * @return bool|string
     */
    public static function decrypt($encrypted, $password, $salt = '')
    {
        $key = hash('SHA256', $salt . $password, true);
        $iv = base64_decode(substr($encrypted, 0, 22) . '==');
        $encrypted = substr($encrypted, 22);
        $decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, base64_decode($encrypted), MCRYPT_MODE_CBC, $iv), "\0\4");
        $hash = substr($decrypted, -32);
        $decrypted = substr($decrypted, 0, -32);
        if (md5($decrypted) != $hash) return false;
        return $decrypted;
    }
}
