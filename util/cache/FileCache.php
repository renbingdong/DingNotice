<?php

## 文件缓存类
require_once(BASE_DIR . '/util/cache/AbstractCache.php');

class FileCache extends AbstractCache {

    private $_dir = null;

    public function __construct() {
        $config = require(BASE_DIR . "/config/config.php");
        $this->_dir = $config['FILE_CACHE'];
        if (!is_dir($this->_dir)) {
            mkdir($this->_dir, 0777);
        }
    }

    public function get($key) {
        if ($key) {
            $file = $this->_dir . '/' . $key;
            if (!file_exists($file)) {
                return false;
            }
            $content = trim(file_get_contents($file));
            $data = json_decode($content, true);
            if ($data && array_key_exists($key, $data)) {
                $value = $data[$key];
                if (!$value) {
                    return false;
                }
                if ($data['expire_time'] > 0 && $data['expire_time'] < time()) {
                    return false;
                }
                return $value;
            }
            return false;
        }
        return false;
    }

    public function set($key, $value, $expireTime = 0) {
        if ($key && $value) {
            $file = $this->_dir . '/' . $key;
            if (file_exists($file)) {
                unlink($file);
            }
            $data = array();
            $data[$key] = $value;
            $data['expire_time'] = $expireTime;
            $data['create_time'] = time();
            $content = json_encode($data);
            $fh = @fopen($file, 'w');
            fwrite($fh, $content);
            fclose($fh);
        }
    } 

}
