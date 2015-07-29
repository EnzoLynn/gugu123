<?php
class ControllerCommonBottom extends Controller {
    public function index() {
        $data = array();

        return $this->load->view('common/bottom.tpl', $data);
    }
}