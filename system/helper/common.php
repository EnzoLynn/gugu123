<?php
/**
 * Created by PhpStorm.
 * User: hui.zhou
 * Date: 2015/6/24
 * Time: 17:12
 */
/*
 * 集成codeigniter的数据访问类，需要用到该函数
 * @author 周辉
 * */
function log_message($level = 'error', $message, $php_error = FALSE)
{
    echo($message);
    $handle = fopen(DIR_LOGS . 'error_sql.log', 'a');
    fwrite($this->handle, date('Y-m-d G:i:s') . ' - ' . print_r($message, true) . "\n");
    fclose($this->handle);
}
/*
 * @author 周辉
 * //ECStore的用户密码加密规则，以下是加密方式，亲测有效
$STRING_MD5 = md5(md5("密码")."用户名"."注册时间");//三个参数组合：密码先MD5加密+用户名+注册时间（10位时间戳数字）
$FRONT_STRING = substr($STRING_MD5,0,31);//截取了一位
$END_STRING = 's'.$FRONT_STRING;//
 * @password 是明文
 * */
function user_password($data) {
    //后台用户是username，前台是fullname
    $data['username'] = isset($data['username']) ? $data['username'] : $data['fullname'];
    $str1 = md5(md5($data['password']).$data['username'].strtotime($data['date_added']));
    $str2 = 's'.substr($str1, 0, 31);
    return $str2;

    //常规的加密方式如下：
    //return md5($data['password'], $data['salt']);
}

/*
 * 根据登录名的数据类型判断返回登录类型
 * @param $loginName
 * @return email or telephone or username
 * */
function getLoginType($loginName) {
    $loginName = trim($loginName);
    if(empty($loginName)) {
        echo '不能为空';
        return false;
    }
    if(preg_match("/\s/", $loginName)) {
        echo '不能包含空格';
        return false;
    }
    if(preg_match("/^[a-zA-Z0-9][a-zA-Z0-9_]{3,24}@[0-9a-zA-Z]{1,10}\.[a-z]{2,5}$/", $loginName)){
        return 'email';
    }
    if(preg_match("/1\d{10}$/", $loginName)) {
        return 'telephone';
    }
    return 'username';
}

/*
 * 从字符串获取参数
 * @param string 网址
 * @param string key
 * @return 类似于$_GET['key']
 * */
function getURLVar($url, $key) {
    $value = array();
    $query = explode('?', $url);
    $part = array();
    if(count($query)==2) {
        $part = explode('&', $query[1]);
    }else{
        $part = explode('&', $query[0]);
    }
    for ($i = 0; $i < count($part); $i++) {
        $data = explode('=', $part[$i]);
        if(count($data)==2) {
            if ($data[0] && $data[1]) {
                $value[$data[0]] = $data[1];
            }
        }
    }
    if ($value[$key]) {
        return $value[$key];
    } else {
        return '';
    }
}
/*
 * 根据类型生成静态url
 * @param string $route 路由
 * @param array $data 参数
 * @return string 生成后的url
 * */
function initURL($route, $data) {

}

/*
 * 在网址中显示的名字
 * @param string $str 字符串，可能带中文
 * @return string 生成后的url
 * */
function getURLString($str) {
    $str = trim($str);
    $str = preg_replace("/\s+/","-",$str);//没有空格了
    $str = preg_replace("/[^-\w]/", "-",$str);//只保留-,数字或者字符,不区分大小写
    $str = preg_replace("/[-]{2,}/","-",$str);//2个以上的-都换成一个
    $str = trim($str, '-'); //去掉两头的-
    $str = strtolower($str);
    return $str;
}

/*
 * 判断在网址中显示字符串是否合法
 * @param string $str 字符串
 * @return boolean
 * */
function checkURLString($str) {
    $str = trim($str);
    $str = strtolower($str);
    return $str == getURLString($str);
}