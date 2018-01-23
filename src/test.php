<?php

##
##   消息发送入口文件

define('BASE_DIR', dirname(__FILE__));

require_once (BASE_DIR . '/core/Api.php');
$config = require(BASE_DIR . '/config/config.php');

$api = new Api();
$accessToken = $api->getAccessToken();

$owner = $config['owner'];
$talkId = $api->getTalk($accessToken, "支付日志异常", $owner, array($owner));
echo $talkId;

$result = $api->sendMessage($accessToken, $talkId, "测试测测谁的饭卡胡椒粉和数据库");
var_export($result);
