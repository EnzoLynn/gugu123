<?php
/**
 * Created by PhpStorm.
 * User: hui.zhou
 * Date: 2015/7/9
 * Time: 16:51
 */
class Customer {
    private $customer_id;
    private $username;
    private $fullname;
    private $email;
    private $telephone;
    private $fax;
    private $newsletter;
    private $customer_group_id;
    private $address_id;

    public function __construct($registry) {
        $this->config = $registry->get('config');
        $this->db = $registry->get('db');
        $this->db_ci = $registry->get('db_ci');
        $this->request = $registry->get('request');
        $this->session = $registry->get('session');

        if (isset($this->session->data['customer_id'])) {
            $customer_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$this->session->data['customer_id'] . "' AND status = '1'");

            if ($customer_query->num_rows) {
                $this->customer_id = $customer_query->row['customer_id'];
                $this->username = $customer_query->row['username'];
                $this->fullname = $customer_query->row['fullname'];
                $this->email = $customer_query->row['email'];
                $this->telephone = $customer_query->row['telephone'];
                $this->fax = $customer_query->row['fax'];
                $this->newsletter = $customer_query->row['newsletter'];
                $this->customer_group_id = $customer_query->row['customer_group_id'];
                $this->address_id = $customer_query->row['address_id'];

                $this->db->query("UPDATE " . DB_PREFIX . "customer SET cart = '" . $this->db->escape(isset($this->session->data['cart']) ? serialize($this->session->data['cart']) : '') . "', wishlist = '" . $this->db->escape(isset($this->session->data['wishlist']) ? serialize($this->session->data['wishlist']) : '') . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "' WHERE customer_id = '" . (int)$this->customer_id . "'");

                $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer_ip WHERE customer_id = '" . (int)$this->session->data['customer_id'] . "' AND ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "'");

                if (!$query->num_rows) {
                    $this->db->query("INSERT INTO " . DB_PREFIX . "customer_ip SET customer_id = '" . (int)$this->session->data['customer_id'] . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "', date_added = NOW()");
                }
            } else {
                $this->logout();
            }
        }
    }

    public function login($login_name, $password, $override = false) {
        $type = getLoginType($login_name);//email or telephone or username
        if(!$type) {
            return false;
        }

        if ($override) {
            $customer_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE `" . $type . "` = '" . $this->db->escape($login_name) . "' AND status = '1'");
        } else {
            //$customer_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE `" . $type . "` = '" . $this->db->escape($login_name) . "' AND (password = SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1('" . $this->db->escape($password) . "'))))) OR password = '" . $this->db->escape(md5($password)) . "') AND status = '1' AND approved = '1'");
            $customer_query = $customer_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE `" . $type . "` = '" . $this->db->escape($login_name) . "' AND `" . $type . "` <>'' AND status = '1'");
            if ($customer_query->num_rows > 0) {
                $data = array();
                $data['username'] = $customer_query->row['username'];
                $data['salt'] = $customer_query->row['salt'];
                $data['date_added'] = $customer_query->row['date_added'];
                $data['password'] = $password;

                $password_md5 = user_password($data);

                $customer_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE `" . $type . "` = '" . $this->db->escape(utf8_strtolower($login_name)) . "' AND password = '" . $password_md5 . "' AND status = '1' AND approved = '1'");
            }
        }


        if ($customer_query->num_rows) {
            $this->session->data['customer_id'] = $customer_query->row['customer_id'];

            if ($customer_query->row['cart'] && is_string($customer_query->row['cart'])) {
                $cart = unserialize($customer_query->row['cart']);

                foreach ($cart as $key => $value) {
                    if (!array_key_exists($key, $this->session->data['cart'])) {
                        $this->session->data['cart'][$key] = $value;
                    } else {
                        $this->session->data['cart'][$key] += $value;
                    }
                }
            }

            if ($customer_query->row['wishlist'] && is_string($customer_query->row['wishlist'])) {
                if (!isset($this->session->data['wishlist'])) {
                    $this->session->data['wishlist'] = array();
                }

                $wishlist = unserialize($customer_query->row['wishlist']);

                foreach ($wishlist as $product_id) {
                    if (!in_array($product_id, $this->session->data['wishlist'])) {
                        $this->session->data['wishlist'][] = $product_id;
                    }
                }
            }

            $this->customer_id = $customer_query->row['customer_id'];
            $this->username = $customer_query->row['username'];
            $this->fullname = $customer_query->row['fullname'];
            $this->email = $customer_query->row['email'];
            $this->telephone = $customer_query->row['telephone'];
            $this->fax = $customer_query->row['fax'];
            $this->newsletter = $customer_query->row['newsletter'];
            $this->customer_group_id = $customer_query->row['customer_group_id'];
            $this->address_id = $customer_query->row['address_id'];

            $this->db->query("UPDATE " . DB_PREFIX . "customer SET ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "' WHERE customer_id = '" . (int)$this->customer_id . "'");

            return true;
        } else {
            return false;
        }
    }

    public function qqlogin($email) {

        $customer_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "' AND status = '1' AND approved = '1'");


        if ($customer_query->num_rows) {
            $this->session->data['customer_id'] = $customer_query->row['customer_id'];

            if ($customer_query->row['cart'] && is_string($customer_query->row['cart'])) {
                $cart = unserialize($customer_query->row['cart']);

                foreach ($cart as $key => $value) {
                    if (!array_key_exists($key, $this->session->data['cart'])) {
                        $this->session->data['cart'][$key] = $value;
                    } else {
                        $this->session->data['cart'][$key] += $value;
                    }
                }
            }

            if ($customer_query->row['wishlist'] && is_string($customer_query->row['wishlist'])) {
                if (!isset($this->session->data['wishlist'])) {
                    $this->session->data['wishlist'] = array();
                }

                $wishlist = unserialize($customer_query->row['wishlist']);

                foreach ($wishlist as $product_id) {
                    if (!in_array($product_id, $this->session->data['wishlist'])) {
                        $this->session->data['wishlist'][] = $product_id;
                    }
                }
            }

            $this->customer_id = $customer_query->row['customer_id'];
            $this->fullname = $customer_query->row['fullname'];
            $this->email = $customer_query->row['email'];
            $this->telephone = $customer_query->row['telephone'];
            $this->fax = $customer_query->row['fax'];
            $this->newsletter = $customer_query->row['newsletter'];
            $this->customer_group_id = $customer_query->row['customer_group_id'];
            $this->address_id = $customer_query->row['address_id'];

            $this->db->query("UPDATE " . DB_PREFIX . "customer SET ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "' WHERE customer_id = '" . (int)$this->customer_id . "'");

            return true;
        } else {
            return false;
        }
    }

    public function logout() {
        $this->db->query("UPDATE " . DB_PREFIX . "customer SET cart = '" . $this->db->escape(isset($this->session->data['cart']) ? serialize($this->session->data['cart']) : '') . "', wishlist = '" . $this->db->escape(isset($this->session->data['wishlist']) ? serialize($this->session->data['wishlist']) : '') . "' WHERE customer_id = '" . (int)$this->customer_id . "'");

        unset($this->session->data['customer_id']);

        $this->customer_id = '';
        $this->fullname = '';
        $this->email = '';
        $this->telephone = '';
        $this->fax = '';
        $this->newsletter = '';
        $this->customer_group_id = '';
        $this->address_id = '';
    }

    public function isLogged() {
        return $this->customer_id;
    }

    public function getId() {
        return $this->customer_id;
    }


    public function getFullName() {
        return $this->fullname;
    }


    public function getEmail() {
        return $this->email;
    }

    public function getTelephone() {
        return $this->telephone;
    }

    public function getFax() {
        return $this->fax;
    }

    public function getNewsletter() {
        return $this->newsletter;
    }

    public function getGroupId() {
        return $this->customer_group_id;
    }

    public function getAddressId() {
        return $this->address_id;
    }

    public function getBalance() {
        $query = $this->db->query("SELECT SUM(amount) AS total FROM " . DB_PREFIX . "customer_transaction WHERE customer_id = '" . (int)$this->customer_id . "'");

        return $query->row['total'];
    }

    public function getRewardPoints() {
        $query = $this->db->query("SELECT SUM(points) AS total FROM " . DB_PREFIX . "customer_reward WHERE customer_id = '" . (int)$this->customer_id . "'");

        return $query->row['total'];
    }
}