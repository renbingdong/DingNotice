<?php

class Logger {

    private static $_logger = null;
    private $_file = null;

    private function __construct() {
        $config = require(BASE_DIR . '/config/config.php');
        $this->_file = $config['error_log'];
        $dir = dirname($this->_file);
        if (!is_dir($dir)) {
            mkdir($dir, 0777);
        }
    }

    public static function getInstance() {
        if (self::$_logger == null) {
            self::$_logger = new Logger();
        }
        return self::$_logger;
    }

    public function log($msg) {
        $msg = date('Y-d-m H:i:s') . " {$msg} \n";
        error_log($msg, 3, $this->_file);
    }
}
