<?php

class Http {

    public static function get($func, $params) {
        $config = require(BASE_DIR . "/config/config.php");
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_USERAGENT, "/dingNotice");
        $url = $config['URL'] . '/' . $func;
        if (!empty($params)) {
            $paramsStr = '?';
            foreach ($params as $key => $value) {
                $paramsStr .= "{$key}={$value}&";
            }
            $paramsStr = substr($paramsStr, 0, -1);
            $url .= $paramsStr;
        }
        curl_setopt($curl, CURLOPT_URL, $url);
        $response = curl_exec($curl);
        if (curl_errno($curl)) {
            throw new Exception(curl_error($curl), curl_errno($curl));
        } else {
            $retCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if ($retCode != '200') { 
                throw new Exception($response, $retCode);
            }
        }
        curl_close($curl);
        return $response;
    }

    public static function post($func, $params) {
        $config = require(BASE_DIR . "/config/config.php");
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_USERAGENT, "/dingNotice");
        $url = $config['URL'] . '/' . $func;
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        $paramsStr = json_encode($params);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $paramsStr);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                            'Content-Type: application/json; charset=utf-8',
                            'Content-Length:' . strlen($paramsStr)));
        $response = curl_exec($curl);
        if (curl_errno($curl)) {
            throw new Exception(curl_error($curl), curl_errno($curl));
        } else {
            $retCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if ($retCode != '200') { 
                throw new Exception($response, $retCode);
            }
        }
        curl_close($curl);
        return $response;
    }
}
