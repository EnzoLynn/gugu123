<?php
class ControllerCommonSubMenu extends Controller {
    public function index() {
        $data = array();

        return $this->load->view('common/subMenu.tpl', $data);
    }
}