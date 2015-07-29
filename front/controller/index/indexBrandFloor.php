<?php
/**
 * Created by PhpStorm.
 * User: 周
 * Date: 2015/7/29
 * Time: 15:07
 */
class ControllerIndexIndexBrandFloor extends Controller {
    public function index() {
        $data = array();
//        if (isset($this->request->get['route'])) {
//            $this->document->addLink(HTTP_SERVER, 'canonical');
//        }
//
//        $data['column_left'] = $this->load->controller('common/column_left');
//        $data['column_right'] = $this->load->controller('common/column_right');
//        $data['content_top'] = $this->load->controller('common/content_top');
//        $data['content_bottom'] = $this->load->controller('common/content_bottom');
//        $data['footer'] = $this->load->controller('common/footer');
//        $data['header'] = $this->load->controller('common/header');

        $this->load->model('design/banner');

        $banner_images = $this->model_design_banner->getBanner(9);
        $data['banner_images'] = $banner_images;

        return $this->load->view('index/indexBrandFloor.tpl', $data);
    }
}