<?php

require_once(BASE_DIR . '/util/http/Http.php');
require_once(BASE_DIR . '/util/cache/CacheFactory.php');
require_once(BASE_DIR . '/util/Logger.php');

class Api {

    public function getAccessToken() {
        $logger = Logger::getInstance();
        $cache = CacheFactory::getCacheInstance();
        $accessToken = $cache->get('access_token');
        if (!$accessToken) {
            $config = require(BASE_DIR . '/config/config.php');
            $params = array();
            $params['corpid'] = $config['USERID'];
            $params['corpsecret'] = $config['SECRET'];
            try {
                $result = Http::get('gettoken', $params);
                $result = json_decode($result, true);
                $accessToken = $result['access_token'];
                $expireTime = time() + 7000;
                $cache->set('access_token', $accessToken, $expireTime);
            } catch (Exception $e) {
                $logger->log($e->__toString());
                return false;
            }
        }
        return $accessToken;
    }

    public function getTalk($accessToken, $chatName, $owner, $userList) {
        $logger = Logger::getInstance();
        $cache = CacheFactory::getCacheInstance();
        $chatId = $cache->get('chat_id');
        if (!$chatId) {
            $params = array();
            $params['name'] = $chatName;
            $params['owner'] = $owner;
            $params['useridlist'] = $userList;
            try {
                $func = 'chat/create?access_token=' . $accessToken;
                $result = Http::post($func, $params);
                $result = json_decode($result, true);
                $chatId = $result['chatid'];
                $cache->set('chat_id', $chatId);
            } catch (Exception $e) {
                $logger->log($e->__toString());
                return false;
            }
        }
        return $chatId;
    }

    public function sendMessage($accessToken, $chatId, $message, $messageType = 'text') {
        $logger = Logger::getInstance();    
        $params = array();
        $params['chatid'] = $chatId;
        $params['msgtype'] = $messageType;
        $params['text'] = array('content' => $message);
        try {
            $func = 'chat/send?access_token=' . $accessToken;
            $result = Http::post($func, $params);
            $result = json_decode($result, true);
            if ($result['errcode'] != 0) {
                $logger->log('params: ' . json_encode($params) . ', result: ' . json_encode($result));
            }
            return $result;
        } catch (Exception $e) {
            $logger->log($e->__toString());
            $logger->log('params: ' . json_encode($params));
        }
    }

}
