<?php
/**
 * Created by PhpStorm.
 * User: hui.zhou
 * Date: 2015/7/8
 * Time: 17:14
 */
class User {
    private $user_id;
    private $username;
    private $permission = array();

    public function __construct($registry) {
        $this->db = $registry->get('db');
        $this->db_ci = $registry->get('db_ci');
        $this->request = $registry->get('request');
        $this->session = $registry->get('session');

        if (isset($this->session->data['user_id'])) {
            $user_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "user WHERE user_id = '" . (int)$this->session->data['user_id'] . "' AND status = '1'");

            if ($user_query->num_rows) {
                $this->user_id = $user_query->row['user_id'];
                $this->username = $user_query->row['username'];
                $this->user_group_id = $user_query->row['user_group_id'];

                $this->db->query("UPDATE " . DB_PREFIX . "user SET ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "' WHERE user_id = '" . (int)$this->session->data['user_id'] . "'");

                $user_group_query = $this->db->query("SELECT permission FROM " . DB_PREFIX . "user_group WHERE user_group_id = '" . (int)$user_query->row['user_group_id'] . "'");

                $permissions = unserialize($user_group_query->row['permission']);

                if (is_array($permissions)) {
                    foreach ($permissions as $key => $value) {
                        $this->permission[$key] = $value;
                    }
                }
            } else {
                $this->logout();
            }
        }
    }

    public function login($username, $password) {
        //$user_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "user WHERE username = '" . $this->db->escape($username) . "' AND (password = SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1('" . $this->db->escape($password) . "'))))) OR password = '" . $this->db->escape(md5($password)) . "') AND status = '1'");
        $query = $this->db_ci->from('user')->where('username', $username)->get();
        $user = $query->result_one_array();
        //$db_password = $user['password'];
        $user['password'] = $password;
        $input_password = user_password($user);

        $where = array(
            'username'  => $username,
            'password'  => $input_password,
            'status'    => 1
        );

        $query = $this->db_ci->from('user')->where($where)->get();
        $user = $query->result_one_array();

        if ($user) {
            $this->session->data['user_id'] = $user['user_id'];

            $this->user_id = $user['user_id'];
            $this->username = $user['username'];
            $this->user_group_id = $user['user_group_id'];

            //$user_group_query = $this->db->query("SELECT permission FROM " . DB_PREFIX . "user_group WHERE user_group_id = '" . (int)$user['user_group_id'] . "'");
            $query = $this->db_ci->from('user_group')->where('user_group_id', $user['user_group_id'])->get();
            $user_group = $query->result_one_array();

            $permissions = unserialize($user_group['permission']);

            if (is_array($permissions)) {
                foreach ($permissions as $key => $value) {
                    $this->permission[$key] = $value;
                }
            }

            return true;
        } else {
            return false;
        }
    }

    public function logout() {
        unset($this->session->data['user_id']);

        $this->user_id = '';
        $this->username = '';
    }

    public function hasPermission($key, $value) {
        if (isset($this->permission[$key])) {
            return in_array($value, $this->permission[$key]);
        } else {
            return false;
        }
    }

    public function isLogged() {
        return $this->user_id;
    }

    public function getId() {
        return $this->user_id;
    }

    public function getUserName() {
        return $this->username;
    }

    public function getGroupId() {
        return $this->user_group_id;
    }
}