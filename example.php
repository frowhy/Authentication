<?php
/**
 * Created by PhpStorm.
 * User: frowhy
 * Date: 2016/11/2
 * Time: 17:05
 */


use Frowhy\Authentication\Authentication;

require_once __DIR__ . '/vendor/autoload.php';
header('Content-type: application/json');

$str = 'aaa';
$salt = 'bbb';
$make = Authentication::make($str, $salt);
$state = Authentication::verify($make);
$sign = Authentication::get($make, $salt);

echo json_encode(['make' => $make, 'state' => $state, 'sign' => $sign]);
