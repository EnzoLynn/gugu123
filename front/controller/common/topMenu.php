<?php
class ControllerCommonTopMenu extends Controller {
    public function index() {
        $data = array();

        return $this->load->view('common/topMenu.tpl', $data);
    }
}