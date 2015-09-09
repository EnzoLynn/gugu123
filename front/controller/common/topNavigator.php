<?php
class ControllerCommonTopNavigator extends Controller {
    public function index() {
        $data = array();

        return $this->load->view('common/topNavigator.tpl', $data);
    }
}