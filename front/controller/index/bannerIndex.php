<?php
class ControllerIndexBannerIndex extends Controller {
    public function index() {
        $data = array();

        $this->load->model('design/banner');
        $this->load->model('tool/image');

        $banner_images = $this->model_design_banner->getBanner(9);

        foreach ($banner_images as $key => $val) {
            $banner_images[$key]['origin_image'] = $this->model_tool_image->url($val['image']);
        }

        $data['banner_images'] = $banner_images;

        return $this->load->view('index/bannerIndex.tpl', $data);
    }
}