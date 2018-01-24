<?php

##
##  钉钉消息推送入口
##
if ($argc != 2) {
    die("请输入推送消息 注：脚本只支持带一个参数");
}

$message = $argv[1];

define('BASE_DIR', dirname(__FILE__));
require_once (BASE_DIR . '/core/Api.php');
$config = require(BASE_DIR . '/config/config.php');

$api = new Api();
$accessToken = $api->getAccessToken();

$owner = $config['owner'];
$chatName = $config['chat_name'];
$talkId = $api->getTalk($accessToken, $chatName, $owner, array($owner));

$result = $api->sendMessage($accessToken, $talkId, $message);
