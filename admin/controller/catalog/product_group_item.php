<?php
/**
 * Created by PhpStorm.
 * User: 周
 * Date: 2015/8/11
 * Time: 14:58
 */

class ControllerCatalogProductGroupItem extends Controller {
    private $error = array();

    public function index() {
        $this->load->language('catalog/product_group');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/product_group');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

            $data = array();
            $temp = $this->request->post;
            $data['group_name'] = $temp['group_name'];
            $data['option_ids'] = implode(',', $temp['product_option_id']);

            $this->model_catalog_product_group->addProductGroupItem($data);

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            $this->response->redirect($this->url->link('catalog/product_group', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }

        //$this->getList();
        $this->getForm();
    }

    public function add() {
        $this->load->language('catalog/product_group');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/product_group');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

            $data = array();
            $temp = $this->request->post;
            $data['group_name'] = $temp['group_name'];
            $data['option_ids'] = implode(',', $temp['product_option_id']);

            $this->model_catalog_product_group->addProductGroupItem($data);

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            $this->response->redirect($this->url->link('catalog/product_group', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }

        $this->getForm();
    }

    public function edit() {
        $this->load->language('catalog/product_group');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/product_group');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

            $data = array();
            $temp = $this->request->post;
            $data['group_name'] = $temp['group_name'];
            $data['option_value_ids'] = implode(',', $temp['option_value']);

            $this->model_catalog_product_group->editProductGroupItem($this->request->get['group_id'], $data);

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            $this->response->redirect($this->url->link('catalog/product_group', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }

        $this->getForm();
    }

    public function delete() {
        $this->load->language('catalog/product_group');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/product_group');

        $group_id = (int)$this->request->get['group_id'];
        $this->model_catalog_product_group->deleteProductGroup($group_id);

        $this->getList();
    }

    public function copy() {
        $this->load->language('catalog/product_group');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/product_group');

        if (isset($this->request->post['selected']) && $this->validateCopy()) {
            foreach ($this->request->post['selected'] as $group_id) {
                $this->model_catalog_product_group->copyProductGroup($group_id);
            }

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            $this->response->redirect($this->url->link('catalog/product_group', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }

        $this->getList();
    }


    protected function getList() {
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

        $data['add'] = $this->url->link('catalog/product_group/add', 'token=' . $this->session->data['token'] . $url, 'SSL');

        $data['product_groups'] = array();

        $results = $this->model_catalog_product_group->getProductGroups();

        foreach ($results as $result) {
            $data['product_groups'][] = array(
                'group_id'  => $result['group_id'],
                'group_name'=> $result['group_name'],
                'edit'               => $this->url->link('catalog/product_group/edit', 'token=' . $this->session->data['token'] . '&group_id=' . $result['group_id'] . $url, 'SSL'),
                'delete'               => $this->url->link('catalog/product_group/delete', 'token=' . $this->session->data['token'] . '&group_id=' . $result['group_id'] . $url, 'SSL')
            );
        }

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_list'] = $this->language->get('text_list');
        $data['text_no_results'] = $this->language->get('text_no_results');
        $data['text_confirm'] = $this->language->get('text_confirm');

        $data['column_id'] = $this->language->get('column_id');
        $data['column_name'] = $this->language->get('column_name');

        $data['column_action'] = $this->language->get('column_action');

        $data['button_copy'] = $this->language->get('button_copy');
        $data['button_add'] = $this->language->get('button_add');
        $data['button_edit'] = $this->language->get('button_edit');
        $data['button_delete'] = $this->language->get('button_delete');

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

        if (isset($this->request->post['selected'])) {
            $data['selected'] = (array)$this->request->post['selected'];
        } else {
            $data['selected'] = array();
        }

        $url = '';

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('catalog/product_group_item_list.tpl', $data));
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
            $data['action'] = $this->url->link('catalog/product_group/edit', 'token=' . $this->session->data['token'] . '&group_id=' . $this->request->get['group_id'] . $url, 'SSL');
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

    protected function validateCopy() {
        if (!$this->user->hasPermission('modify', 'catalog/product_group')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }

    protected function validateForm() {
        if (!$this->user->hasPermission('modify', 'catalog/attribute_group')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if(empty($this->request->post['group_name'])){
            $this->error['name'] = $this->language->get('error_name');
        }

        return !$this->error;
    }

    public function getOptionsJSON() {
        $this->load->model('catalog/attribute');
        $this->load->model('catalog/product_group');

        $group_id = (int)$this->request->get['group_id'];

        $product_group_info = array();
        $product_group_info = $this->model_catalog_product_group->getProductGroup($group_id);

        // Attributes
        $attribute_ids = explode(',', $product_group_info['attribute_ids']);

        $data['attributes'] = array();

        foreach ($attribute_ids as $attribute_id) {
            $attribute_info = $this->model_catalog_attribute->getAttribute($attribute_id);

            if ($attribute_info) {
                $data['options'][] = array(
                    'option_id' => $attribute_info['option_id'],
                    'name'      => $attribute_info['name']
                );
            }
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($data['options']));
    }
}