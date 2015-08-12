<?php
/**
 * Created by PhpStorm.
 * User: 周
 * Date: 2015/8/11
 * Time: 14:58
 */

class ControllerCatalogProductGroupItem extends Controller {
    private $error = array();

    public function edit() {
        $this->load->language('catalog/product_group');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/product_group');

        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {

            $data = array();
            $temp = $this->request->post;
//            echo $this->request->get['group_id'];
//            echo '<pre>';print_r($temp['item']);exit;
            $data = $temp['item'];

            $this->model_catalog_product_group->editProductGroupItems($this->request->get['group_id'], $data);

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            $this->response->redirect($this->url->link('catalog/product_group', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }

        $this->getForm();
    }

    protected function getForm() {

        $group_id = (int)$this->request->get['group_id'];

        $data['text_list'] = $this->language->get('text_list');

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_form'] = !isset($this->request->get['group_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

        $data['entry_group_name'] = $this->language->get('entry_group_name');
        $data['entry_option_value_ids'] = $this->language->get('entry_option_value_ids');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        $data['token'] = $this->session->data['token'];

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

        if (isset($this->error['name'])) {
            $data['error_name'] = $this->error['name'];
        } else {
            $data['error_name'] = array();
        }

        $url = '';

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('catalog/product_group', 'token=' . $this->session->data['token'] . $url, 'SSL')
        );

        if (!isset($this->request->get['group_id'])) {
            $data['action'] = $this->url->link('catalog/product_group/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
        } else {
            $data['action'] = $this->url->link('catalog/product_group_item/edit', 'token=' . $this->session->data['token'] . '&group_id=' . $this->request->get['group_id'] . $url, 'SSL');
        }

        $data['cancel'] = $this->url->link('catalog/product_group', 'token=' . $this->session->data['token'] . $url, 'SSL');

        $data['product_group_info'] = array();
        $data['product_group_info']['group_name'] = '';
        if (isset($this->request->get['group_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $data['product_group_info'] = $this->model_catalog_product_group->getProductGroup($this->request->get['group_id']);
        }

        // Options
        $this->load->model('catalog/option');

        $data['option_data'] = $this->model_catalog_option->getOptionAndValues(explode(',', $data['product_group_info']['option_value_ids']));

        $option_rows = array();

        $option_num = count($data['option_data']);
        if ($option_num == 1) {
            for($i = 0; $i < count($data['option_data'][0]['option_value_data']); $i++) {
                $option_rows[] = array(
                    'html'      => '<td>'. $data['option_data'][0]['option_value_data'][$i]['name'] .'</td>',
                    'key'       =>  $data['option_data'][0]['option_value_data'][$i]['option_value_id']
                );
            }
        } else if($option_num == 2) {
            for($i = 0; $i < count($data['option_data'][0]['option_value_data']); $i++) {
                for($j = 0; $j < count($data['option_data'][1]['option_value_data']); $j++) {
                    $option_rows[] = array(
                        'html'      => '<td>'. $data['option_data'][0]['option_value_data'][$i]['name'] .'</td><td>'. $data['option_data'][1]['option_value_data'][$j]['name'] .'</td>',
                        'key'       =>  $data['option_data'][0]['option_value_data'][$i]['option_value_id'].','.$data['option_data'][1]['option_value_data'][$j]['option_value_id']
                    );
                }
            }
        } else if($option_num == 3) {
            for($i = 0; $i < count($data['option_data'][0]['option_value_data']); $i++) {
                for($j = 0; $j < count($data['option_data'][1]['option_value_data']); $j++) {
                    for($k = 0; $k < count($data['option_data'][2]['option_value_data']); $k++) {
                        $option_rows[] = array(
                            'html'      => '<td>'. $data['option_data'][0]['option_value_data'][$i]['name'] .'</td><td>'. $data['option_data'][1]['option_value_data'][$j]['name'] .'</td><td>'. $data['option_data'][2]['option_value_data'][$k]['name'] .'</td>',
                            'key'       =>  $data['option_data'][0]['option_value_data'][$i]['option_value_id'].','.$data['option_data'][1]['option_value_data'][$j]['option_value_id'].','.$data['option_data'][2]['option_value_data'][$k]['option_value_id']
                        );
                    }
                }
            }
        }
        $data['option_rows'] = $option_rows;

        $this->load->model('catalog/product');

        $data['option_items'] = array();
        $temp = $this->model_catalog_product_group->getProductGroupItem($group_id);
        foreach($temp as $row) {

            $temp_product_name = '';
            if($row['product_id'] > 0) {
                $temp_product = $this->model_catalog_product->getProduct($row['product_id']);
                $temp_product_name = $temp_product['name'];
            }

            $data['option_items'][$row['option_value_ids']] = array(
                'title' => $row['title'],
                'product_id' => $row['product_id'],
                'product_name' => $temp_product_name

            );
        }

//        echo '<pre>';print_r($data['option_rows']);
//        echo '<pre>';print_r($data['option_items']);exit;

        $this->load->model('localisation/language');

        $data['languages'] = $this->model_localisation_language->getLanguages();

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('catalog/product_group_item_form.tpl', $data));
    }

}