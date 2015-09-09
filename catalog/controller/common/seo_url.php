<?php
class ControllerCommonSeoUrl extends Controller {
	public function index() {
		// Add rewrite to url class
        //性能有严重的问题
		if ($this->config->get('config_seo_url')) {
			$this->url->addRewrite($this);
		}

        $url_current = $this->request->server['PHP_SELF'] . isset($this->request->server['QUERY_STRING'])? $this->request->server['QUERY_STRING']:'';

        if (isset($this->request->get['_route_'])) {
            $url_current = substr($url_current, strpos($url_current, '=') + 1);
            $url_current = str_replace('&amp;', '&', $url_current);

            $parts = explode('/', $this->request->get['_route_']);

            // remove any empty arrays from trailing
            if (utf8_strlen(end($parts)) == 0) {
                array_pop($parts);
            }

            $url_rules = array(
                //product
                '(.*)_p([0-9]+)\.html' => 'index.php?route=product/product&product_id=$2',
                //category
                '(.*)_c([0-9]+)' => 'index.php?route=product/category&category_id=$2',
                //tag
                'tag\/(.*)\.html' => 'index.php?route=product/search&tag==$1',
                //brand
                'brand\/(.*)_b([0-9]+)' => 'index.php?route=product/manufacturer/info&manufacturer_id=$2',
                //information/
                'information\/(.*)_info([0-9]+)\.html' => 'index.php?route=information/information&information_id=$2',
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
                } else {
                    //如果包含参数，截取&之前的网址再试试
                    if (strpos($url_current, '&') !== false) {
                        $url_current = substr($url_current, 0, strpos($url_current, '&'));
                        //echo $url_current;exit;
                        if (preg_match($pattern, $url_current, $matches) > 0) {
                            for ($i = 1; $i <= count($matches) - 1; $i++) {
                                $url_real = str_replace('$' . $i, $matches[$i], $url_real);
                            }
                            $url = $url_real;
                            break;
                        }
                    }
                }
            }

            //echo $url;
            $url_info = parse_url($url);
            $data = array();
            parse_str($url_info['query'], $data);

            $this->request->get['route'] = $data['route'];


            switch($this->request->get['route']) {
                case 'product/product':
                    $this->request->get['product_id'] = $data['product_id'];
                    break;
                case 'product/category':
                    $this->request->get['category_id'] = $data['category_id'];
                    break;
                case 'product/search':
                    $this->request->get['tag'] = $data['tag'];
                    break;
                case 'product/manufacturer/info':
                    $this->request->get['manufacturer_id'] = $data['manufacturer_id'];
                    break;
                case 'information/information':
                    $this->request->get['information_id'] = $data['information_id'];
                    break;
            }

            if (isset($this->request->get['route'])) {
                return new Action($this->request->get['route']);
            }
		}
	}

	public function rewrite($link) {
		$url_info = parse_url(str_replace('&amp;', '&', $link));

		$url = '';
		$data = array();
		parse_str($url_info['query'], $data);

		foreach ($data as $key => $value) {
			if (isset($data['route'])) {
                if ($data['route'] == 'common/home') {
                    $url .= '/';
                } else if (($data['route'] == 'product/product' && $key == 'product_id') || (($data['route'] == 'product/manufacturer/info' || $data['route'] == 'product/product') && $key == 'manufacturer_id') || ($data['route'] == 'information/information' && $key == 'information_id')) {

                    if ($data['route'] == 'product/product' && $key == 'product_id') {
                        $this->load->model('catalog/product');
                        $product_info = $this->model_catalog_product->getProduct($data['product_id']);

                        $url .= '/' . $product_info['keyword'] . '_p' . $data['product_id'] . '.html';
                        unset($data['product_id']);
                        unset($data['category_id']);
                    } else if ($data['route'] == 'product/manufacturer/info' && $key == 'manufacturer_id') {
                        $this->load->model('catalog/manufacturer');
                        $manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($data['manufacturer_id']);
                        $url .= '/brand/' . $manufacturer_info['keyword'] . '_b'. $manufacturer_info['manufacturer_id'];
                        unset($data['manufacturer_id']);

                    } else if ($data['route'] == 'information/information' && $key == 'information_id') {

                        $this->load->model('catalog/information');
                        $information_info = $this->model_catalog_information->getInformation($data['information_id']);

                        $url .= '/information/' . $information_info['keyword'] . '_info'. $information_info['information_id'] . '.html';
                        unset($data['information_id']);
                    } else {
                        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = '" . $this->db->escape($key . '=' . (int)$value) . "'");

                        if ($query->num_rows && $query->row['keyword']) {
                            $url .= '/' . $query->row['keyword'];

                            unset($data[$key]);
                        }
                    }
                } elseif ($data['route'] == 'product/search' && $key == 'tag') {

//                    $this->load->model('catalog/category');
//                    $category_info = $this->model_catalog_category->getCategory($data['category_id']);

                    $url .= '/' . $data['tag'] . '.html';
                    unset($data['tag']);

                } elseif ($data['route'] == 'product/category' && $key == 'category_id') {

                    $this->load->model('catalog/category');
                    $category_info = $this->model_catalog_category->getCategory($data['category_id']);

                    $url .= '/' . $category_info['keyword'] . '_c' . $data['category_id'];

                    unset($data['category_id']);
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
