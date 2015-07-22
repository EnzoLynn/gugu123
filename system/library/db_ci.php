<?php

define('BASEPATH', dirname(__FILE__).'/../../system/library/');
define('EXT', '.php');

class DB_CI {

    private static $instance;

    public static function get_instance($db_driver, $db_host, $db_username, $db_password, $db_name, $db_prefix)
    {
        if(self::$instance == null){

            require_once(BASEPATH . 'database/DB' . EXT);
            $params = array(
                'dbdriver' => $db_driver,
                'hostname' => $db_host,
                'username' => $db_username,
                'password' => $db_password,
                'database' => $db_name,
                'dbprefix' => $db_prefix,
                'pconnect' => FALSE,
                'db_debug' => FALSE,
                'cache_on' => FALSE,
                'char_set' => 'utf8',
                'dbcollat' => 'utf8_general_ci',
            );
            self::$instance = DB($params,TRUE);
        }
        return self::$instance;
    }
}
