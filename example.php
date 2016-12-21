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
 * Date: 2016/11/2
 * Time: 17:05
 */

use Frowhy\Authentication\AuthenticationSSL;


require_once __DIR__ . '/vendor/autoload.php';
//header('Content-type: application/json');

$str = 'b2StCBQ3V1Cfqz2AQ@GaDWD!3ex!@vwQ';
//$salt = 'z$d$CtX$W3rX27U1%l&HcOk!Or6ogj7Q';
//$make = Authentication::make($str, $salt);
////$make = 'UTdqZ282ck8ha09jSCZsJTFVNzJYcjNXJFh0QyRkJHo9Y1EvRlA5K3dGZEFsTmxlS0ZHYkdSVlVUZFdUWHAxWWFSemRGOWtUemdEYWtsbk5tWmtXMjkwUTBkRFpqTjFkREpFTnk4R05GSmpNTVZYYzBwRkp3RURKaEpESjU0MTQ0NjU2MTk3NDE=';
//$state = Authentication::verify($make);
//$sign  = Authentication::get($make, $salt);

//echo json_encode(['make' => $make, 'state' => $state, 'sign' => $sign]);
//var_dump(array('make' => $make, 'state' => $state, 'sign' => $sign));
//var_dump(PasswordCompat\binary\check());
//exit;

/**
 * 7.1.0 Example
 */
if (FALSE === version_compare('7.1.0', PHP_VERSION, '>=') || FALSE === extension_loaded('openssl')) {
    die;
}
$keys  = [
    'private_key' => dirname(__FILE__) . '/rsa_private_key.pem',
    'public_key'  => dirname(__FILE__) . '/rsa_public_key.pem',
];
$make  = AuthenticationSSL::make($str, $keys);
$state = AuthenticationSSL::verify($make);
$sign  = AuthenticationSSL::get($make, $keys);
//echo json_encode(['make' => $make, 'state' => $state, 'sign' => $sign]);
var_dump(['make' => $make, 'state' => $state, 'sign' => $sign]);