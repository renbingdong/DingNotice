<?php

require_once(BASE_DIR . '/util/cache/FileCache.php');

class CacheFactory {

    private static $_cacheInst = null;
    public static function getCacheInstance() {
        if (self::$_cacheInst == null) {
            $config = require(BASE_DIR . '/config/config.php');
            $cacheType = $config['CACHE_TYPE'];
            self::$_cacheInst = new FileCache();
        }
        return self::$_cacheInst;
    }
}
