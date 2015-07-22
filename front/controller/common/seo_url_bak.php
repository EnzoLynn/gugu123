<?php
class ControllerCommonSeoUrl extends Controller {
	public function index() {


        //preg_match('@^(?:http://)?([^/]+)@i', "http://www.php.net/index.html", $matches);

//RewriteRule ^(.*)_p([0-9]+)\.html$ index.php?_route_=product/product&product_id=$2 [L,QSA]


        $url_domain = (isset($this->request->server['SERVER_PORT']) && $this->request->server['SERVER_PORT'] == '443') ? 'https://' : 'http://';
        $url_domain .= $this->request->server['HTTP_HOST'];

        $url_current = $this->request->server['PHP_SELF'] . isset($this->request->server['QUERY_STRING'])? $this->request->server['QUERY_STRING']:'';
//echo $url_current;exit;

        $url_rules = array(
            //product
            //'(.*)_p([0-9]+)\.html' => 'index.php?_route_=product/product&product_id=$2',
            '(.*)_p([0-9]+)\.html' => 'product/product&product_id=$2',
        );

        $url = '';
        foreach($url_rules as $url_static => $url_real) {
            $matches = array();
            $pattern = '/^'. $url_static .'$/';
            if( preg_match($pattern, $url_current, $matches) > 0){
                for($i=1; $i<=count($matches) - 1; $i++) {
                    $url_real = str_replace('$'.$i, $matches[$i], $url_real);
                }
                $url = $url_real;
                break;
            }

        }

        //echo $url_domain .'/index.php?_route_='. $url_real;exit;

        //http://opencn.com/gibson-test-1960_p52.html

        //echo $url;exit;
        if(!empty($url)) {
            $data = explode('&', $url);
            $this->request->get['route'] = $data[0]; //substr($url, 0, strpos($url, '&'));
            $_GET = getURLPars($data[1]);

            if (isset($this->request->get['route'])) {
                return new Action($this->request->get['route']);
                //return new Action($this->request->get['route'], array('product_id' => 52));               //现在卡在这个地方
            }
        }

		// Add rewrite to url class
//		if ($this->config->get('config_seo_url')) {
//			$this->url->addRewrite($this);
//		}

//		// Decode URL
//		if (isset($this->request->get['_route_'])) {
//			$parts = explode('/', $this->request->get['_route_']);
//
//			// remove any empty arrays from trailing
//			if (utf8_strlen(end($parts)) == 0) {
//				array_pop($parts);
//			}
//
//			foreach ($parts as $part) {
//				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE keyword = '" . $this->db->escape($part) . "'");
//
//				if ($query->num_rows) {
//					$url = explode('=', $query->row['query']);
//
//					if ($url[0] == 'product_id') {
//						$this->request->get['product_id'] = $url[1];
//					}
//
//					if ($url[0] == 'category_id') {
//						if (!isset($this->request->get['path'])) {
//							$this->request->get['path'] = $url[1];
//						} else {
//							$this->request->get['path'] .= '_' . $url[1];
//						}
//					}
//
//					if ($url[0] == 'manufacturer_id') {
//						$this->request->get['manufacturer_id'] = $url[1];
//					}
//
//					if ($url[0] == 'information_id') {
//						$this->request->get['information_id'] = $url[1];
//					}
//
//					if ($query->row['query'] && $url[0] != 'information_id' && $url[0] != 'manufacturer_id' && $url[0] != 'category_id' && $url[0] != 'product_id') {
//						$this->request->get['route'] = $query->row['query'];
//					}
//				} else {
//					$this->request->get['route'] = 'error/not_found';
//
//					break;
//				}
//			}
//
//			if (!isset($this->request->get['route'])) {
//				if (isset($this->request->get['product_id'])) {
//					$this->request->get['route'] = 'product/product';
//				} elseif (isset($this->request->get['path'])) {
//					$this->request->get['route'] = 'product/category';
//				} elseif (isset($this->request->get['manufacturer_id'])) {
//					$this->request->get['route'] = 'product/manufacturer/info';
//				} elseif (isset($this->request->get['information_id'])) {
//					$this->request->get['route'] = 'information/information';
//				}
//			}
//
//			if (isset($this->request->get['route'])) {
//				return new Action($this->request->get['route']);
//			}
//		}
	}

	public function rewrite($link) {
		$url_info = parse_url(str_replace('&amp;', '&', $link));

		$url = '';

		$data = array();

		parse_str($url_info['query'], $data);

		foreach ($data as $key => $value) {
			if (isset($data['route'])) {
				if (($data['route'] == 'product/product' && $key == 'product_id') || (($data['route'] == 'product/manufacturer/info' || $data['route'] == 'product/product') && $key == 'manufacturer_id') || ($data['route'] == 'information/information' && $key == 'information_id')) {
					$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = '" . $this->db->escape($key . '=' . (int)$value) . "'");

					if ($query->num_rows && $query->row['keyword']) {
						$url .= '/' . $query->row['keyword'];

						unset($data[$key]);
					}
				} elseif ($key == 'path') {
					$categories = explode('_', $value);

					foreach ($categories as $category) {
						$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = 'category_id=" . (int)$category . "'");

						if ($query->num_rows && $query->row['keyword']) {
							$url .= '/' . $query->row['keyword'];
						} else {
							$url = '';

							break;
						}
					}

					unset($data[$key]);
				}
			}
		}

		if ($url) {
			unset($data['route']);

			$query = '';

			if ($data) {
				foreach ($data as $key => $value) {
					$query .= '&' . rawurlencode((string)$key) . '=' . rawurlencode((string)$value);
				}

				if ($query) {
					$query = '?' . str_replace('&', '&amp;', trim($query, '&'));
				}
			}

			return $url_info['scheme'] . '://' . $url_info['host'] . (isset($url_info['port']) ? ':' . $url_info['port'] : '') . str_replace('/index.php', '', $url_info['path']) . $url . $query;
		} else {
			return $link;
		}
	}
}
