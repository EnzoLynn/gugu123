<?php
// HTTP
define('HTTP_SERVER', 'http://opencn.com/');
//define('HTTP_SERVER', 'http://192.168.91.102/');

// HTTPS
define('HTTPS_SERVER', 'http://opencn.com/');
define('DIR_FRONT', 'front');

// DIR
define('DIR_ROOT', 'E:/website/opencart_cn/');

define('DIR_APPLICATION',   DIR_ROOT . DIR_FRONT . '/');
define('DIR_SYSTEM',        DIR_ROOT . 'system/');
define('DIR_LANGUAGE',      DIR_ROOT . DIR_FRONT . '/language/');
define('DIR_TEMPLATE',      DIR_ROOT . DIR_FRONT . '/view/theme/');
define('DIR_CONFIG',        DIR_ROOT . 'system/config/');
define('DIR_IMAGE',         DIR_ROOT . 'image/');
define('DIR_CACHE',         DIR_ROOT . 'system/cache/');
define('DIR_DOWNLOAD',      DIR_ROOT . 'system/download/');
define('DIR_UPLOAD',        DIR_ROOT . 'system/upload/');
define('DIR_MODIFICATION', DIR_ROOT . 'system/modification/');
define('DIR_LOGS',          DIR_ROOT . 'system/logs/');

// DB
require_once(DIR_ROOT . 'config_db.php');
