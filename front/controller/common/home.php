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


        $data['commonSubMenu'] = $this->load->controller('common/subMenu');
        $data['commonTopNavigator'] = $this->load->controller('common/topNavigator');
        $data['commonTopMenu'] = $this->load->controller('common/topMenu');
        $data['commonBottom'] = $this->load->controller('common/bottom');

        $data['indexBannerPlay'] = $this->load->controller('index/bannerPlay');
        $data['indexBannerIndex'] = $this->load->controller('index/bannerIndex');
        $data['indexInteractive'] = $this->load->controller('index/interactive');

        $this->response->setOutput($this->load->view('common/home.tpl', $data));
	}
}