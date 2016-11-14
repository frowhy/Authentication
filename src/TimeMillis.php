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
 * Time: 16:44
 */

namespace Frowhy\Authentication;


class TimeMillis
{
    public static function getTimeMillis()
    {
        list($t1, $t2) = explode(' ', microtime());
        return sprintf('%.0f', (floatval($t1) + floatval($t2)) * 1000);
    }
}