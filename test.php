<?php
/**
 * Created by PhpStorm.
 * User: snail
 * Date: 2018/10/12
 * Time: 下午5:55
 */

use GeTui\IGt;

require __DIR__ . '/vendor/autoload.php';
$host = "https://api.getui.com/apiex.htm";
$appid = "Z6wmlQS1Qq6Zp3IJiLWnpA";
$appsecret = "eE8i2paynnAZunkLGAXnu9";
$appkey = "ruAkywbBi06DvBorF012DA";
$mastersecret = "U7GqGDkaGe6HSmCyHKebS9";

$config = [
    'host'         => $host,
    'appid'        => $appid,
    'appsecret'    => $appsecret,
    'appkey'       => $appkey,
    'mastersecret' => $mastersecret,
];
$token = [
//    "c57e319f27a8be9abd6acf5306fe7e00" => "ios",
"8d9faec981cb393af8be510d42e59978" => "android",
];
$data = [
    "title"      => "测试111",
    "content"    => "只是测试222",
    "payload"    => '{"a":1231,"b":"234234"}',
    "badge"      => 1,
    "logo"       => "",
    "begin_time" => "",
    "end_time"   => "",
];
$res = IGt::getInstance($config)
    ->pushMessageToSingle(IGt::$notification_tpl,$token, $data);
var_dump($res);