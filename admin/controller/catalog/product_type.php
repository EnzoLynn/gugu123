<?php
/**
 * Created by PhpStorm.
 * User: hui.zhou
 * Date: 2015/7/2
 * Time: 10:30
 */
class ControllerCatalogProductType extends Controller {
    private $error = array();

    public function index() {
        $this->load->language('catalog/product_type');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/product_type');

        $this->getList();
    }

    public function add() {
        $this->load->language('catalog/product_type');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/product_type');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

            $data = array();
            $temp = $this->request->post;
            $data['type_name'] = $temp['type_name'];
            $data['filter_group_ids'] = implode(',', $temp['filter_group_id']);
            $data['attribute_ids'] = implode(',', $temp['attribute_id']);

            $this->model_catalog_product_type->addProductType($data);

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            $this->response->redirect($this->url->link('catalog/product_type', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }

        $this->getForm();
    }

    public function edit() {
        $this->load->language('catalog/product_type');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/product_type');
        $this->load->model('catalog/attribute');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

            $data = array();
            $temp = $this->request->post;
            $data['type_name'] = $temp['type_name'];
            $data['filter_group_ids'] = implode(',', $temp['filter_group_id']);
            $data['attribute_ids'] = implode(',', $this->model_catalog_attribute->orderListAttributes($temp['attribute_id']));

            $this->model_catalog_product_type->editProductType($this->request->get['type_id'], $data);

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            $this->response->redirect($this->url->link('catalog/product_type', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }

        $this->getForm();
    }

    public function delete() {
        $this->load->language('catalog/product_type');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/product_type');

        $type_id = (int)$this->request->get['type_id'];
        $this->model_catalog_product_type->deleteProductType($type_id);

        $this->getList();
    }

    public function copy() {
        $this->load->language('catalog/product_type');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/product_type');

        if (isset($this->request->post['selected']) && $this->validateCopy()) {
            foreach ($this->request->post['selected'] as $type_id) {
                $this->model_catalog_product_type->copyProductType($type_id);
            }

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            $this->response->redirect($this->url->link('catalog/product_type', 'token=' . $this->session->data['token'] . $url, 'SSL'));
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
            'href' => $this->url->link('catalog/product_type', 'token=' . $this->session->data['token'] . $url, 'SSL')
        );

        $data['add'] = $this->url->link('catalog/product_type/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['copy'] = $this->url->link('catalog/product_type/copy', 'token=' . $this->session->data['token'] . $url, 'SSL');

        $data['product_types'] = array();

        $results = $this->model_catalog_product_type->getProductTypes();

        foreach ($results as $result) {
            $data['product_types'][] = array(
                'type_id'  => $result['type_id'],
                'type_name'=> $result['type_name'],
                'download'       => $this->url->link('catalog/product_type/download', 'token=' . $this->session->data['token'] . '&type_id=' . $result['type_id'] . $url, 'SSL'),
                'edit'               => $this->url->link('catalog/product_type/edit', 'token=' . $this->session->data['token'] . '&type_id=' . $result['type_id'] . $url, 'SSL'),
                'delete'               => $this->url->link('catalog/product_type/delete', 'token=' . $this->session->data['token'] . '&type_id=' . $result['type_id'] . $url, 'SSL')
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
        $data['button_download'] = $this->language->get('button_download');

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

        $this->response->setOutput($this->load->view('catalog/product_type_list.tpl', $data));
    }

    protected function getForm() {
        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_form'] = !isset($this->request->get['type_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

        $data['entry_type_name'] = $this->language->get('entry_type_name');
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
            'href' => $this->url->link('catalog/product_type', 'token=' . $this->session->data['token'] . $url, 'SSL')
        );

        if (!isset($this->request->get['type_id'])) {
            $data['action'] = $this->url->link('catalog/product_type/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
        } else {
            $data['action'] = $this->url->link('catalog/product_type/edit', 'token=' . $this->session->data['token'] . '&type_id=' . $this->request->get['type_id'] . $url, 'SSL');
        }

        $data['cancel'] = $this->url->link('catalog/product_type', 'token=' . $this->session->data['token'] . $url, 'SSL');

        $data['product_type_info'] = array();
        $data['product_type_info']['type_name'] = '';
        if (isset($this->request->get['type_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $data['product_type_info'] = $this->model_catalog_product_type->getProductType($this->request->get['type_id']);
        }

        // Filters
        $this->load->model('catalog/filter');

        $filter_groups_ids = array();
        if (isset($this->request->post['filter_group_id'])) {
            $filter_groups_ids = $this->request->post['filter_group_id'];
        } elseif (isset($this->request->get['type_id']) && !empty($data['product_type_info']['filter_group_ids'])) {
            $filter_groups_ids = explode(',', $data['product_type_info']['filter_group_ids']);
        }

        $data['filter_groups_ids'] = $filter_groups_ids;

        $data['filter_groups'] = $this->model_catalog_filter->getFilterGroups([]);

        // Attributes
        $this->load->model('catalog/attribute');
        $this->load->model('catalog/attribute_group');

        $attribute_ids = array();
        if (isset($this->request->post['attribute_id'])) {
            $attribute_ids = $this->request->post['attribute_id'];
        } elseif (isset($this->request->get['type_id'])  && !empty($data['product_type_info']['attribute_ids'])) {
            $attribute_ids = explode(',', $data['product_type_info']['attribute_ids']);
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

        $this->response->setOutput($this->load->view('catalog/product_type_form.tpl', $data));
    }

    protected function validateCopy() {
        if (!$this->user->hasPermission('modify', 'catalog/product_type')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }

    protected function validateForm() {
        if (!$this->user->hasPermission('modify', 'catalog/attribute_group')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if(empty($this->request->post['type_name'])){
            $this->error['name'] = $this->language->get('error_name');
        }

        return !$this->error;
    }

    public function getAttributeJSON() {
        $this->load->model('catalog/attribute');
        $this->load->model('catalog/product_type');

        $type_id = (int)$this->request->get['type_id'];

        $product_type_info = array();
        $product_type_info = $this->model_catalog_product_type->getProductType($type_id);

        // Attributes
        $attribute_ids = explode(',', $product_type_info['attribute_ids']);

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

    public function getFilterJSON() {
        $data['filter_groups'] = array();
        $this->load->model('catalog/filter');
        $this->load->model('catalog/product_type');

        $type_id = (int)$this->request->get['type_id'];

        $product_type_info = array();
        $product_type_info = $this->model_catalog_product_type->getProductType($type_id);

        // Filter group
        $filter_group_ids = explode(',', $product_type_info['filter_group_ids']);
        foreach ($filter_group_ids as $filter_group_id) {
            $filters = $this->model_catalog_filter->getFiltersByGroupID($filter_group_id);

            $filter_group = $this->model_catalog_filter->getFilterGroup($filter_group_id);
            $data['filter_groups'][] = array(
                'group_name' => $filter_group['name'],
                'filters'   => $filters
            );
        }
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($data['filter_groups']));
    }

    public function download() {
        $type_id = (int)$this->request->get['type_id'];

        $this->load->model('catalog/product_type');
        $this->load->model('catalog/filter');
        $this->load->model('catalog/attribute');

        /** Error reporting */
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
//        date_default_timezone_set('Europe/London');

        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');

        require_once(DIR_SYSTEM . 'library/excel/PHPExcel.php');

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

// Set document properties
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
            ->setLastModifiedBy("Maarten Balliauw")
            ->setTitle("Office 2007 XLSX Test Document")
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Test result file");


// Add some data
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', '商品名称')
            ->setCellValue('B1', '商品描述')
            ->setCellValue('C1', 'SEO title')
            ->setCellValue('D1', '商品标签')
            ->setCellValue('E1', '视频地址')
            ->setCellValue('F1', '货号')
            ->setCellValue('G1', '图像')
            ->setCellValue('H1', '生产地')
            ->setCellValue('I1', '价格')
            ->setCellValue('J1', '数量')
            ->setCellValue('K1', '最小购买数量')
            ->setCellValue('L1', '减少库存')
            ->setCellValue('M1', '缺货时状态')
            ->setCellValue('N1', '需要配送')
            ->setCellValue('O1', '上架日期')
            ->setCellValue('P1', '重量')
            ->setCellValue('Q1', '重量单位')
            ->setCellValue('R1', '状态')
            ->setCellValue('S1', '排序')
            ->setCellValue('T1', '品牌')
            ->setCellValue('U1', '主分类')
            ->setCellValue('V1', '额外分类')
            ->setCellValue('W1', '')
            ->setCellValue('X1', '')
            ->setCellValue('Y1', '')
            ->setCellValue('Z1', '');
            //->setCellValue('AA1', '');

        $cell_column_filter = array();
        for($i = 65; $i < 91; $i++){//AA1 - AZ1
            $cell_column_filter[] = 'A'.chr($i).'1';
        }

        $product_type_info = $this->model_catalog_product_type->getProductType($type_id);

        // Filter group
        $filter_group_ids = explode(',', $product_type_info['filter_group_ids']);
        $i = 0;
        foreach ($filter_group_ids as $filter_group_id) {
            $filter_group = $this->model_catalog_filter->getFilterGroup($filter_group_id);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cell_column_filter[$i], $filter_group['name']);
            $i++;
        }



        $cell_column_attribute = array();
        for($i = 66; $i < 91; $i++){//从BA1开始……
            for($j = 65; $j < 91; $j++) {
                $cell_column_attribute[] = chr($i) . chr($j) . '1';
            }
        }

        $product_type_info = array();
        $product_type_info = $this->model_catalog_product_type->getProductType($type_id);

        // Attributes
        $attribute_ids = explode(',', $product_type_info['attribute_ids']);

        $data['attributes'] = array();

        $i = 0;
        foreach ($attribute_ids as $attribute_id) {
            $attribute_info = $this->model_catalog_attribute->getAttribute($attribute_id);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cell_column_attribute[$i], $attribute_info['name']);
            $i++;
        }




// Miscellaneous glyphs, UTF-8
//        $objPHPExcel->setActiveSheetIndex(0)
//            ->setCellValue('A4', 'Miscellaneous glyphs')
//            ->setCellValue('A5', 'éàèùâêîôûëïüÿäöüç');

// Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle($product_type_info['type_name'].'的商品模版'.date('Ymd'));


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$product_type_info['type_name'].'的商品模版'.date('Ymd').'.xls"');
        header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }
}