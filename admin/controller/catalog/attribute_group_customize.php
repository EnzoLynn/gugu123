<?php
/**
 * Created by PhpStorm.
 * User: hui.zhou
 * Date: 2015/7/2
 * Time: 10:30
 */
class ControllerCatalogAttributeGroupCustomize extends Controller {
    private $error = array();

    public function index() {
        $this->load->language('catalog/attribute_group_customize');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/attribute_group_customize');

        $this->getList();
    }

    public function add() {
        $this->load->language('catalog/attribute_group_customize');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/attribute_group_customize');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

            $data = array();
            $temp = $this->request->post;
            $data['customize_name'] = $temp['customize_name'];
            $data['filter_group_ids'] = implode(',', $temp['filter_group_id']);
            $data['attribute_ids'] = implode(',', $temp['attribute_id']);

            $this->model_catalog_attribute_group_customize->addAttributeGroupCustomize($data);

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            $this->response->redirect($this->url->link('catalog/attribute_group_customize', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }

        $this->getForm();
    }

    public function edit() {
        $this->load->language('catalog/attribute_group_customize');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/attribute_group_customize');
        $this->load->model('catalog/attribute');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

            $data = array();
            $temp = $this->request->post;
            $data['customize_name'] = $temp['customize_name'];
            $data['filter_group_ids'] = implode(',', $temp['filter_group_id']);
            $data['attribute_ids'] = implode(',', $this->model_catalog_attribute->orderListAttributes($temp['attribute_id']));

            $this->model_catalog_attribute_group_customize->editAttributeGroupCustomize($this->request->get['customize_id'], $data);

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            $this->response->redirect($this->url->link('catalog/attribute_group_customize', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }

        $this->getForm();
    }

    public function delete($customize_id) {
        $this->load->language('catalog/attribute_group');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/attribute_group_customize');

        $this->model_catalog_attribute_group_customize->deleteAttributeGroupCustomize($customize_id);

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
            'href' => $this->url->link('catalog/attribute_group_customize', 'token=' . $this->session->data['token'] . $url, 'SSL')
        );

        $data['add'] = $this->url->link('catalog/attribute_group_customize/add', 'token=' . $this->session->data['token'] . $url, 'SSL');

        $data['attribute_group_customizes'] = array();

        $results = $this->model_catalog_attribute_group_customize->getAttributeGroupsCustomizes();

        foreach ($results as $result) {
            $data['attribute_group_customizes'][] = array(
                'customize_id'  => $result['customize_id'],
                'customize_name'=> $result['customize_name'],
                'edit'               => $this->url->link('catalog/attribute_group_customize/edit', 'token=' . $this->session->data['token'] . '&customize_id=' . $result['customize_id'] . $url, 'SSL'),
                'delete'               => $this->url->link('catalog/attribute_group_customize/delete', 'token=' . $this->session->data['token'] . '&customize_id=' . $result['customize_id'] . $url, 'SSL')
            );
        }


        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_list'] = $this->language->get('text_list');
        $data['text_no_results'] = $this->language->get('text_no_results');
        $data['text_confirm'] = $this->language->get('text_confirm');

        $data['column_id'] = $this->language->get('column_id');
        $data['column_name'] = $this->language->get('column_name');

        $data['column_action'] = $this->language->get('column_action');
        $data['column_attribute_num'] = $this->language->get('column_attribute_num');

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

        $url = '';

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('catalog/attribute_group_customize_list.tpl', $data));
    }

    protected function getForm() {
        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_form'] = !isset($this->request->get['customize_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

        $data['entry_customize_name'] = $this->language->get('entry_customize_name');
        $data['entry_filter_group_ids'] = $this->language->get('entry_filter_group_ids');
        $data['entry_attribute_ids'] = $this->language->get('entry_attribute_ids');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        $data['token'] = $this->session->data['token'];

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
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
            'href' => $this->url->link('catalog/attribute_group_customize', 'token=' . $this->session->data['token'] . $url, 'SSL')
        );

        if (!isset($this->request->get['customize_id'])) {
            $data['action'] = $this->url->link('catalog/attribute_group_customize/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
        } else {
            $data['action'] = $this->url->link('catalog/attribute_group_customize/edit', 'token=' . $this->session->data['token'] . '&customize_id=' . $this->request->get['customize_id'] . $url, 'SSL');
        }

        $data['cancel'] = $this->url->link('catalog/attribute_group_customize', 'token=' . $this->session->data['token'] . $url, 'SSL');

        $data['customize_info'] = array();
        $data['customize_info']['customize_name'] = '';
        if (isset($this->request->get['customize_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $data['customize_info'] = $this->model_catalog_attribute_group_customize->getAttributeGroupCustomize($this->request->get['customize_id']);
        }

        // Filters
        $this->load->model('catalog/filter');

        $filter_groups_ids = array();
        if (isset($this->request->post['filter_group_id'])) {
            $filter_groups_ids = $this->request->post['filter_group_id'];
        } elseif (isset($this->request->get['customize_id']) && !empty($data['customize_info']['filter_group_ids'])) {
            $filter_groups_ids = explode(',', $data['customize_info']['filter_group_ids']);
        }

        $data['filter_groups_ids'] = $filter_groups_ids;

        $data['filter_groups'] = $this->model_catalog_filter->getFilterGroups([]);

        // Attributes
        $this->load->model('catalog/attribute');
        $this->load->model('catalog/attribute_group');

        $attribute_ids = array();
        if (isset($this->request->post['attribute_id'])) {
            $attribute_ids = $this->request->post['attribute_id'];
        } elseif (isset($this->request->get['customize_id'])  && !empty($data['customize_info']['attribute_ids'])) {
            $attribute_ids = explode(',', $data['customize_info']['attribute_ids']);
        }

        $data['attributes'] = array();

        foreach ($attribute_ids as $attribute_id) {
            $attribute_info = $this->model_catalog_attribute->getAttribute($attribute_id);

            $attribute_group_info = $this->model_catalog_attribute_group->getAttributeGroupDescriptions($attribute_info['attribute_group_id']);

            if ($attribute_info) {
                $data['attributes'][] = array(
                    'attribute_id' => $attribute_info['attribute_id'],
                    'name'      => $attribute_group_info[$this->config->get('config_language_id')]['name'] . ' &gt; ' . $attribute_info['name']
                );
            }
        }

        $this->load->model('localisation/language');

        $data['languages'] = $this->model_localisation_language->getLanguages();

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('catalog/attribute_group_customize_form.tpl', $data));
    }

    protected function validateForm() {
        if (!$this->user->hasPermission('modify', 'catalog/attribute_group')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if(empty($this->request->post['customize_name'])){
            $this->error['name'] = $this->language->get('error_name');
        }

        return !$this->error;
    }

    public function getOptionsJSON() {

        $json = array();

        $this->load->model('catalog/attribute');
        $this->load->model('catalog/attribute_group_customize');

        $customize_id = (int)$this->request->get['customize_id'];

        $customize_info = array();
        $customize_info = $this->model_catalog_attribute_group_customize->getAttributeGroupCustomize($customize_id);


        // Attributes
        $attribute_ids = explode(',', $customize_info['attribute_ids']);

        $data['attributes'] = array();

        foreach ($attribute_ids as $attribute_id) {
            $attribute_info = $this->model_catalog_attribute->getAttribute($attribute_id);

            if ($attribute_info) {
                $data['attributes'][] = array(
                    'attribute_id' => $attribute_info['attribute_id'],
                    'name'      => $attribute_info['name']
                );
            }
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($data['attributes']));
    }
}