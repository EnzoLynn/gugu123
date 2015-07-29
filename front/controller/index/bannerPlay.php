<?php
class ControllerIndexBannerPlay extends Controller {
    public function index() {
        $data = array();

        return $this->load->view('index/bannerPlay.tpl', $data);
    }
}