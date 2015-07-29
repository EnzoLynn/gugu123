<?php
class ControllerCommonHome extends Controller {
	public function index() {
//		$this->document->setTitle($this->config->get('config_meta_title'));
//		$this->document->setDescription($this->config->get('config_meta_description'));
//		$this->document->setKeywords($this->config->get('config_meta_keyword'));

        if ($this->request->server['HTTPS']) {
            $server = $this->config->get('config_ssl');
        } else {
            $server = $this->config->get('config_url');
        }

        $data['base'] = $server;
        $data['title'] = $this->document->getTitle();
        $data['description'] = $this->document->getDescription();
        $data['keywords'] = $this->document->getKeywords();

//		if (isset($this->request->get['route'])) {
//			$this->document->addLink(HTTP_SERVER, 'canonical');
//		}

//		$data['column_left'] = $this->load->controller('common/column_left');
//		$data['column_right'] = $this->load->controller('common/column_right');
//		$data['content_top'] = $this->load->controller('common/content_top');
//		$data['content_bottom'] = $this->load->controller('common/content_bottom');
//		$data['footer'] = $this->load->controller('common/footer');
//		$data['header'] = $this->load->controller('common/header');

        $data['indexBrandFloor'] = $this->load->controller('index/indexBrandFloor');

        $this->response->setOutput($this->load->view('common/home.tpl', $data));
	}
}