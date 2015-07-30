<?php
class ControllerIndexBannerPlay extends Controller {
    public function index() {
        $data = array();

        $this->load->model('design/banner');
        $this->load->model('tool/image');

        $banner_images = $this->model_design_banner->getBanner(7);

        foreach ($banner_images as $key => $val) {
            $banner_images[$key]['origin_image'] = $this->model_tool_image->url($val['image']);
            $banner_images[$key]['thumb']         = $this->model_tool_image->resize($val['image'], 73, 45);
        }

        $data['banner_image_first'] = $banner_images[0];

        $data['banner_images'] = $banner_images;

        return $this->load->view('index/bannerPlay.tpl', $data);
    }
}