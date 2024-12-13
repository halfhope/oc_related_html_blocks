<?php
/**
 * @author Shashakhmetov Talgat <talgatks@gmail.com>
 */

class ControllerExtensionModuleRelatedHTML extends Controller {

	private $_route = 'extension/module/related_html';
	private $_model = 'model_extension_module_related_html';

	private $_entity_data = [
		'product/category' => [
			'table' 			=> 'category_to_related_html',
			'column' 			=> 'category_id',
			'get_param'			=> 'path'
		],
		'product/product' => [
			'table' 			=> 'product_to_related_html',
			'column' 			=> 'product_id',
			'get_param'			=> 'product_id'
		],
		'product/manufacturer/info' => [
			'table' 			=> 'manufacturer_to_related_html',
			'column' 			=> 'manufacturer_id',
			'get_param' 		=> 'manufacturer_id'
		]
	];

	public function index($setting) {
		
		if (isset($this->_entity_data[$this->request->get['route']])) {
			$this->load->language($this->_route);

			$this->load->model($this->_route);

			$_entity_data = $this->_entity_data[$this->request->get['route']];
			$value = isset($this->request->get[$_entity_data['get_param']]) ? $this->request->get[$_entity_data['get_param']] : '';

			if ($_entity_data['get_param'] == 'path') {
				$path = explode('_', $value);
				$value = end($path);
			}

			$data['htmls'] = $this->{$this->_model}->getRelatedHTMLsByRelatedParam($_entity_data['table'], $_entity_data['column'], $value);

			if ($data['htmls']) {
				$language_id = $this->config->get('config_language_id');
				
				$data['content'] = '';
				foreach ($data['htmls'] as $key => $value) {
					$data['htmls'][$key]['code'] = html_entity_decode($value['code'][$language_id], ENT_QUOTES, 'UTF-8');
					$data['content'] .= $data['htmls'][$key]['code'];
				}

				if (isset($setting['file_name'][$language_id]) && !empty($setting['file_name'][$language_id])) {
					return $this->load->view($setting['file_name'][$language_id], $data);
				} else {
					$result = str_replace(['{{content}}', '{{ content }}'], $data['content'], html_entity_decode($setting['code'][$language_id], ENT_QUOTES, 'UTF-8'));
					return $result;
				}
			}
		}
	}
}