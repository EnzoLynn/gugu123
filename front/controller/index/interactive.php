<?php
class ControllerIndexInteractive extends Controller {
    public function index() {
        $data = array();

        return $this->load->view('index/interactive.tpl', $data);
    }
}