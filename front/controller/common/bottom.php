<?php
class ControllerCommonBottom extends Controller {
    public function index() {
        $data = array();

        $this->load->model('catalog/information');

        $informations = $this->model_catalog_information->getInformations();

        foreach ($informations as $key=>$result) {
            $result['link'] =  $this->url->link('information/information', 'information_id=' . $result['information_id']);
            $data['informations'][$result['information_id']] = $result;
        }


        return $this->load->view('common/bottom.tpl', $data);
    }
}