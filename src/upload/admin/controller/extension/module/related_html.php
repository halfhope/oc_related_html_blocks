<?php
/**
 * @author Shashakhmetov Talgat <talgatks@gmail.com>
 */

class ControllerExtensionModuleRelatedHTML extends Controller {

	private $_route 	= 'extension/module/related_html';
	private $_model 	= 'model_extension_module_related_html';
	private $_version 	= '1.0';

	private $error = [];

	/*
	*	STATIC DATA
	*/

	private $_event = [
		// Add widget html
		[
			'trigger'	=> 'admin/view/catalog/category_form/after',
			'action'	=> 'eventRHTMLFormViewAfter'
		],
		[
			'trigger'	=> 'admin/view/catalog/product_form/after',
			'action'	=> 'eventRHTMLFormViewAfter'
		],
		[
			'trigger'	=> 'admin/view/catalog/manufacturer_form/after',
			'action'	=> 'eventRHTMLFormViewAfter'
		],
		// Save widget data
			// category
		[
			'trigger'	=> 'admin/model/catalog/category/addCategory/after',
			'action'	=> 'eventRHTMLFormModelAfter'
		],
		[
			'trigger'	=> 'admin/model/catalog/category/editCategory/after',
			'action'	=> 'eventRHTMLFormModelAfter'
		],
		[
			'trigger'	=> 'admin/model/catalog/category/deleteCategory/after',
			'action'	=> 'eventRHTMLFormModelAfter'
		],
			// product
		[
			'trigger'	=> 'admin/model/catalog/product/addProduct/after',
			'action'	=> 'eventRHTMLFormModelAfter'
		],
		[
			'trigger'	=> 'admin/model/catalog/product/editProduct/after',
			'action'	=> 'eventRHTMLFormModelAfter'
		],
		[
			'trigger'	=> 'admin/model/catalog/product/deleteProduct/after',
			'action'	=> 'eventRHTMLFormModelAfter'
		],
			// manufacturer
		[
			'trigger'	=> 'admin/model/catalog/manufacturer/addManufacturer/after',
			'action'	=> 'eventRHTMLFormModelAfter'
		],
		[
			'trigger'	=> 'admin/model/catalog/manufacturer/editManufacturer/after',
			'action'	=> 'eventRHTMLFormModelAfter'
		],
		[
			'trigger'	=> 'admin/model/catalog/manufacturer/deleteManufacturer/after',
			'action'	=> 'eventRHTMLFormModelAfter'
		],
	];

	private $_entity_data = [
		'category' => [
			'table' 			=> 'category_to_related_html',
			'column' 			=> 'category_id',
			'query_selector'	=> '#tab-data'
		],
		'product' => [
			'table' 			=> 'product_to_related_html',
			'column' 			=> 'product_id',
			'query_selector'	=> '#tab-data'
		],
		'manufacturer' => [
			'table' 			=> 'manufacturer_to_related_html',
			'column' 			=> 'manufacturer_id',
			'query_selector'	=> '#tab-general'
		]
	];

	/*
	*	INSTALLATION
	*/

	public function install() {
		$this->load->model('setting/event');

		foreach ($this->_event as $key => $_event) {
			$_event['code'] = 'rhtml_' . substr(md5(http_build_query($_event)), 6);

			if(!$this->model_setting_event->getEventByCode($_event['code'])) {
				$this->model_setting_event->addEvent($_event['code'], $_event['trigger'], $this->_route . '/' . $_event['action']);
			}
		}

		$this->load->model($this->_route);
		$this->{$this->_model}->install();
	}

	public function uninstall() {
		$this->load->model('setting/event');

		foreach ($this->_event as $key => $_event) {
			$_event['code'] = 'rhtml_' . substr(md5(http_build_query($_event)), 6);

			$this->model_setting_event->deleteEventByCode($_event['code']);
		}

		$this->load->model($this->_route);
		$this->{$this->_model}->uninstall();
	}

	/*
	*	MODULE
	*/

	public function index() {

		// init
		$this->document->addScript('view/javascript/jquery/switcher/jquery.switcher.min.js');
		$this->document->addStyle('view/javascript/jquery/switcher/switcher.css');

		$data = $this->load->language($this->_route);

		$this->document->setTitle($this->language->get('heading_title'));
		$data['version'] = $this->_version;

		$this->load->model($this->_route);

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validatePermissionAndName()) {
			$this->load->model('setting/module');

			if (!isset($this->request->get['module_id'])) {
				$this->model_setting_module->addModule('related_html', $this->request->post);
				$module_id = $this->db->getLastId();
			} else {
				$this->model_setting_module->editModule($this->request->get['module_id'], $this->request->post);
				$module_id = $this->request->get['module_id'];
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link($this->_route, 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $module_id, true));
		}

		// messages
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		// breadchrumbs
		$data['breadcrumbs'] = [];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
		];

		if (!isset($this->request->get['module_id'])) {
			$data['breadcrumbs'][] = [
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link($this->_route, 'user_token=' . $this->session->data['user_token'], true)
			];
		} else {
			$data['breadcrumbs'][] = [
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link($this->_route, 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true)
			];
		}

		// top menu
		if (!isset($this->request->get['module_id'])) {
			$data['save'] = $this->url->link($this->_route, 'user_token=' . $this->session->data['user_token'], true);
		} else {
			$data['save'] = $this->url->link($this->_route, 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true);
		}
		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

		$data['add_module'] = $this->url->link($this->_route, 'user_token=' . $this->session->data['user_token'], true);
		$data['modules_link'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);
		$this->load->model('setting/module');
		$data['modules'] = $this->model_setting_module->getModulesByCode('related_html');
		foreach ($data['modules'] as $key => $value) {
			$data['modules'][$key]['edit'] = $this->url->link($this->_route, 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $value['module_id'], true);
		}

		$data['list'] = $this->url->link($this->_route . '/list', 'user_token=' . $this->session->data['user_token'], true);
		$data['add_block'] = $this->url->link($this->_route . '/add', 'user_token=' . $this->session->data['user_token'], true);
		$data['htmls_top'] = $this->{$this->_model}->getAllRelatedHTMLs(false);
		foreach ($data['htmls_top'] as $key => $value) {
			$data['htmls_top'][$key]['edit'] = $this->url->link($this->_route . '/edit', 'user_token=' . $this->session->data['user_token'] . '&html_id=' . $value['html_id'], true);
		}

		// init page data
		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_setting_module->getModule($this->request->get['module_id']);
		}

		$data['text_form'] = !isset($this->request->get['module_id']) ? $this->language->get('text_add_module') : $this->language->get('text_edit_module');

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		$language_id = $this->config->get('config_language_id');

		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (isset($module_info) && !empty($module_info)) {
			$data['name'] = $module_info['name'];
		} else {
			$data['name'] = '';
		}

		if (isset($this->request->post['code'])) {
			$data['code'] = $this->request->post['code'];
		} elseif (isset($module_info) && !empty($module_info)) {
			$data['code'] = $module_info['code'];
		} else {
			$data['code'] = [];
			foreach ($data['languages'] as $language) {
				$data['code'][$language['language_id']] = '{{content}}';
			}
		}

		if (isset($this->request->post['file_name'])) {
			$data['file_name'] = $this->request->post['file_name'];
		} elseif (isset($module_info) && !empty($module_info)) {
			$data['file_name'] = $module_info['file_name'];
		} else {
			$data['file_name'] = [];
			foreach ($data['languages'] as $language) {
				$data['file_name'][$language['language_id']] = '';
			}
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (isset($module_info) && !empty($module_info)) {
			$data['status'] = $module_info['status'];
		} else {
			$data['status'] = 1;
		}

		// controllers
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view($this->_route . '/module', $data));
	}

	/*
	*	CRUD
	*/

	public function list() {
		$data = $this->load->language($this->_route);

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model($this->_route);

		$this->getList();
	}

	public function add() {
		$data = $this->load->language($this->_route);

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model($this->_route);

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validatePermissionAndName()) {
			$html_id = $this->{$this->_model}->addRelatedHTML($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link($this->_route . '/list', 'user_token=' . $this->session->data['user_token'] . $url . '&html_id=' . (int) $html_id, true));
		}

		$this->getForm();
	}

	public function edit() {
		$data = $this->load->language($this->_route);

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model($this->_route);

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validatePermissionAndName()) {
			$this->{$this->_model}->editRelatedHTML($this->request->get['html_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link($this->_route . '/list', 'user_token=' . $this->session->data['user_token'] . $url . '&html_id=' . (int) $this->request->get['html_id'], true));
		}

		$this->getForm();
	}

	public function delete() {
		$data = $this->load->language($this->_route);

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model($this->_route);

		if (isset($this->request->post['selected']) && $this->validatePermission()) {
			foreach ($this->request->post['selected'] as $html_id) {
				$this->{$this->_model}->deleteRelatedHTML($html_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link($this->_route . '/list', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getList();
	}

	public function clone() {
		$data = $this->load->language($this->_route);

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model($this->_route);

		if (isset($this->request->post['selected']) && $this->validatePermission()) {
			foreach ($this->request->post['selected'] as $html_id) {
				$this->{$this->_model}->cloneRelatedHTML($html_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link($this->_route . '/list', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList() {

		// init
		$this->document->addScript('view/javascript/jquery/switcher/jquery.switcher.min.js');
		$this->document->addStyle('view/javascript/jquery/switcher/switcher.css');

		$data = $this->load->language($this->_route);

		$this->document->setTitle($this->language->get('heading_title'));
		$data['version'] = $this->_version;

		$this->load->model($this->_route);

		// messages
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		// sort for url
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		// breadcrumbs
		$data['breadcrumbs'] = [];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
		];
		
		$data['breadcrumbs'][] = [
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link($this->_route . '/list', 'user_token=' . $this->session->data['user_token'] . $url, true)
		];

		// top menu
		$data['add_block'] = $this->url->link($this->_route . '/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
		$data['clone'] = $this->url->link($this->_route . '/clone', 'user_token=' . $this->session->data['user_token'] . $url, true);
		$data['multiple_edit'] = $this->url->link($this->_route . '/multipleEdit', 'user_token=' . $this->session->data['user_token'] . $url, true);
		$data['delete'] = $this->url->link($this->_route . '/delete', 'user_token=' . $this->session->data['user_token'] . $url, true);

		$data['add_module'] = $this->url->link($this->_route, 'user_token=' . $this->session->data['user_token'], true);
		$data['modules_link'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);
		$this->load->model('setting/module');
		$data['modules'] = $this->model_setting_module->getModulesByCode('related_html');
		foreach ($data['modules'] as $key => $value) {
			$data['modules'][$key]['edit'] = $this->url->link($this->_route, 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $value['module_id'], true);
		}

		$data['list'] = $this->url->link($this->_route . '/list', 'user_token=' . $this->session->data['user_token'] . $url, true);
		$data['add_block'] = $this->url->link($this->_route . '/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
		$data['htmls_top'] = $this->{$this->_model}->getAllRelatedHTMLs(false);
		foreach ($data['htmls_top'] as $key => $value) {
			$data['htmls_top'][$key]['edit'] = $this->url->link($this->_route . '/edit', 'user_token=' . $this->session->data['user_token'] . '&html_id=' . $value['html_id'] . $url, true);
		}

		// init page data
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'sort_order';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		if (isset($this->request->get['limit'])) {
			$limit = $this->request->get['limit'];
		} else {
			$limit = $this->config->get('config_limit_admin');
		}

		$data['sort'] = $sort;
		$data['order'] = $order;
		$data['page'] = $page;

		$filter_data = [
			'sort' => $sort,
			'order' => $order,
			'page' => $page,
			'start' => ($page - 1) * $limit,
			'limit' => $limit
		];

		$data['htmls'] = [];

		$htmls = $this->{$this->_model}->getRelatedHTMLs($filter_data);
		foreach ($htmls as $key => $html_info) {
			$data['htmls'][] = [
				'html_id' => $html_info['html_id'],
				'name' => $html_info['name'],
				'sort_order' => $html_info['sort_order'],
				'date_added' => $this->humanDatePrecise($html_info['date_added']),
				'date_edited' => $this->humanDatePrecise($html_info['date_edited']),
				'status' => $html_info['status'],
				'edit' => $this->url->link($this->_route . '/edit', 'user_token=' . $this->session->data['user_token'] . '&html_id=' . $html_info['html_id'] . $url, true)
			];
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = [];
		}

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_name'] = $this->url->link($this->_route . '/list', 'user_token=' . $this->session->data['user_token'] . '&sort=name' . $url , true);
		$data['sort_sort_order'] = $this->url->link($this->_route . '/list', 'user_token=' . $this->session->data['user_token'] . '&sort=sort_order' . $url , true);
		$data['sort_date_added'] = $this->url->link($this->_route . '/list', 'user_token=' . $this->session->data['user_token'] . '&sort=date_added' . $url , true);
		$data['sort_date_edited'] = $this->url->link($this->_route . '/list', 'user_token=' . $this->session->data['user_token'] . '&sort=date_edited' . $url , true);

		$data['change_status'] = html_entity_decode($this->url->link($this->_route . '/changeStatus', 'user_token=' . $this->session->data['user_token'], true), ENT_QUOTES, 'UTF-8');

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$html_total = $this->{$this->_model}->getTotalRelatedHTMLs();

		$pagination = new Pagination();
		$pagination->total = $html_total;
		$pagination->page = $page;
		$pagination->limit = $limit;
		$pagination->url = $this->url->link($this->_route . '/list', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($html_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($html_total - $limit)) ? $html_total : ((($page - 1) * $limit) + $limit), $html_total, ceil($html_total / $limit));

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view($this->_route . '/list', $data));
	}

	protected function getForm() {

		// init
		$this->document->addScript('view/javascript/jquery/switcher/jquery.switcher.min.js');
		$this->document->addStyle('view/javascript/jquery/switcher/switcher.css');

		$data = $this->load->language($this->_route);
		$data['version'] = $this->_version;

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model($this->_route);
		
		// messages 
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = [];
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		// sort for url
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		// breadchrumbs
		$data['breadcrumbs'] = [];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
		];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link($this->_route . '/list', 'user_token=' . $this->session->data['user_token'] . $url, true)
		];
		
		// top menu
		if (!isset($this->request->get['html_id'])) {
			$data['save'] = $this->url->link($this->_route . '/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
		} else {
			$data['save'] = $this->url->link($this->_route . '/edit', 'user_token=' . $this->session->data['user_token'] . '&html_id=' . (int) $this->request->get['html_id'] . $url, true);
		}
		$data['cancel'] = $this->url->link($this->_route . '/list', 'user_token=' . $this->session->data['user_token'], true);

		$data['add_module'] = $this->url->link($this->_route, 'user_token=' . $this->session->data['user_token'], true);
		$data['modules_link'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);
		$this->load->model('setting/module');
		$data['modules'] = $this->model_setting_module->getModulesByCode('related_html');
		foreach ($data['modules'] as $key => $value) {
			$data['modules'][$key]['edit'] = $this->url->link($this->_route, 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $value['module_id'], true);
		}

		$data['list'] = $this->url->link($this->_route . '/list', 'user_token=' . $this->session->data['user_token'], true);
		$data['add_block'] = $this->url->link($this->_route . '/add', 'user_token=' . $this->session->data['user_token'], true);
		$data['htmls_top'] = $this->{$this->_model}->getAllRelatedHTMLs(false);
		foreach ($data['htmls_top'] as $key => $value) {
			$data['htmls_top'][$key]['edit'] = $this->url->link($this->_route . '/edit', 'user_token=' . $this->session->data['user_token'] . '&html_id=' . $value['html_id'], true);
		}

		// init page data
		if (isset($this->request->get['html_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$html_info = $this->{$this->_model}->getRelatedHTML($this->request->get['html_id']);
		}

		if (isset($html_info['name'])) {
			$data['heading_title'] = $html_info['name'];
		}

		$data['text_form'] = !isset($this->request->get['html_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		$language_id = $this->config->get('config_language_id');

		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($html_info)) {
			$data['name'] = $html_info['name'];
		} else {
			$data['name'] = '';
		}

		if (isset($this->request->post['code'])) {
			$data['code'] = $this->request->post['code'];
		} elseif (!empty($html_info)) {
			$data['code'] = $html_info['code'];
		} else {
			$data['code'] = [];
			foreach ($data['languages'] as $language) {
				$data['code'][$language['language_id']] = '<div></div>';
			}
		}

		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($html_info)) {
			$data['sort_order'] = $html_info['sort_order'];
		} else {
			$data['sort_order'] = 0;
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($html_info)) {
			$data['status'] = $html_info['status'];
		} else {
			$data['status'] = 1;
		}

		// controllers
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view($this->_route . '/block', $data));
	}

	public function multipleSave() {
		$data = $this->load->language($this->_route);

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model($this->_route);

		if (isset($this->request->post['htmls']) && $this->validatePermissionAndMultipleName()) {
			$this->{$this->_model}->multipleEditRelatedHTML($this->request->post['htmls']);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}
	
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
	
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
	
			$this->response->redirect($this->url->link($this->_route . '/list', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->multipleEdit();
	}

	public function multipleEdit() {

		// init
		$data = $this->load->language($this->_route);

		$this->document->setTitle($this->language->get('heading_title'));
		$data['version'] = $this->_version;

		$this->load->model($this->_route);

		// messages
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = [];
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		// sort for url
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		// breadchrumbs
		$data['breadcrumbs'] = [];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
		];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link($this->_route . '/list', 'user_token=' . $this->session->data['user_token'] . $url, true)
		];

		// top menu
		$data['save'] = $this->url->link($this->_route . '/multipleSave', 'user_token=' . $this->session->data['user_token'] . $url, true);
		$data['cancel'] = $this->url->link($this->_route . '/list', 'user_token=' . $this->session->data['user_token'], true);
		
		$data['add_module'] = $this->url->link($this->_route, 'user_token=' . $this->session->data['user_token'], true);
		$data['modules_link'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);
		$this->load->model('setting/module');
		$data['modules'] = $this->model_setting_module->getModulesByCode('related_html');
		foreach ($data['modules'] as $key => $value) {
			$data['modules'][$key]['edit'] = $this->url->link($this->_route, 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $value['module_id'], true);
		}

		$data['list'] = $this->url->link($this->_route . '/list', 'user_token=' . $this->session->data['user_token'], true);
		$data['add_block'] = $this->url->link($this->_route . '/add', 'user_token=' . $this->session->data['user_token'], true);
		$data['htmls_top'] = $this->{$this->_model}->getAllRelatedHTMLs(false);
		foreach ($data['htmls_top'] as $key => $value) {
			$data['htmls_top'][$key]['edit'] = $this->url->link($this->_route . '/edit', 'user_token=' . $this->session->data['user_token'] . '&html_id=' . $value['html_id'], true);
		}

		// init page data
		$data['htmls'] = [];
		if (isset($this->request->post['selected'])) {
			foreach ($this->request->post['selected'] as $key => $html_id) {
				$data['htmls'][] = $this->{$this->_model}->getRelatedHTML($html_id);
			}
		} elseif (isset($this->request->post['htmls'])) {
			$data['htmls'] = $this->request->post['htmls'];
		}

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		$language_id = $this->config->get('config_language_id');

		// controller
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view($this->_route . '/multiple', $data));
	}

	public function changeStatus() {
		if (!$this->user->hasPermission('modify', $this->_route)) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error && $this->request->server['REQUEST_METHOD'] == 'POST') {
			$this->load->model($this->_route);
			$this->{$this->_model}->changeStatus($this->request->post['html_id'], $this->request->post['value']);

			header('Content-Type: application/json; charset=utf-8');
			$this->response->setOutput(json_encode(
				['success' => 1]
			));
		}
	}

	protected function validatePermission() {
		if (!$this->user->hasPermission('modify', $this->_route)) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	protected function validatePermissionAndName() {
		if (!$this->user->hasPermission('modify', $this->_route)) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['name']) <= 0) || (utf8_strlen($this->request->post['name']) > 255)) {
			$this->error['name'] = $this->language->get('error_name');
			$this->error['warning'] = $this->language->get('error_check_form');
		}

		return !$this->error;
	}

	protected function validatePermissionAndMultipleName() {
		if (!$this->user->hasPermission('modify', $this->_route)) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (isset($this->request->post['htmls'])) {
			foreach ($this->request->post['htmls'] as $html_id => $value) {
				if ((utf8_strlen($value['name']) <= 0) || (utf8_strlen($value['name']) > 255)) {
					$this->error['name'][$html_id] = $this->language->get('error_name');
					$this->error['warning'] = $this->language->get('error_check_form');
				}
			}
		}

		return !$this->error;
	}

	/*
	*	EVENTS
	*/

	public function eventRHTMLFormViewAfter(&$route, &$data, &$output) {

		$data = $this->load->language($this->_route);

		$this->load->model($this->_route);

		$path = explode('/', $this->request->get['route']);
		list($function, $controller) = [array_pop($path), array_pop($path)];

		$value = ($function == 'add') ? 0 : (int) $this->request->get[$this->_entity_data[$controller]['column']];

		$data['htmls'] = $this->{$this->_model}->getAllRelatedHTMLs();
		$data['related_htmls'] = $this->{$this->_model}->getRelatedHTMLsByRelatedParam($this->_entity_data[$controller]['table'], $this->_entity_data[$controller]['column'], $value);

		$data['add'] = $this->url->link($this->_route . '/add', 'user_token=' . $this->session->data['user_token'], true);
		
		$widget = $this->load->view($this->_route . '/widget', $data);

		$result = "
		<script>
		$(document).ready(function() {
			let widget = " . json_encode($widget) . ";
			$(widget).prependTo('" . $this->_entity_data[$controller]['query_selector'] . "');
			$('.related_html_widget [data-toggle=tooltip]').tooltip();
		});
		</script>";

		$output = $output . $result;
	}

	public function eventRHTMLFormModelAfter(&$route, &$args, &$output) {

		$this->load->model($this->_route);

		$path = explode('/', $this->request->get['route']);
		list($function, $controller) = [array_pop($path), array_pop($path)];

		// get category_id, product_id, manufacturer_id for add/edit/delete
		$value = ($function !== 'add') ? $args[0] : $output;

		// get related_htmls for add/edit/delete
		$passed = ($function == 'edit') ? $args[1] : $args[0];
		$related_htmls = isset($passed['related_htmls']) ? $passed['related_htmls'] : [];
		if ($function == 'delete') {
			$related_htmls = [];
		}

		$this->{$this->_model}->relateHTMLs($this->_entity_data[$controller]['table'], $this->_entity_data[$controller]['column'], $value, $related_htmls);
	}

	/*
	*	HELPER
	*/	

	private function humanDatePrecise($date, $format = 'Y-m-d H:i:s') {
		$r = false;
		$a = preg_split("/[:\.\s-]+/", $date);
		$d = time() - strtotime($date);
		if ($d > 0) {
			if ($d < 3600) {
				switch (floor($d / 60)) {
					case 0:
					case 1: return "<acronym title='$date'>" . $this->language->get('text_interval_less_than_a_minute_ago') . "</acronym>"; break;
					case 2: return "<acronym title='$date'>" . $this->language->get('text_interval_2_minutes_ago') . "</acronym>"; break;
					case 3: return "<acronym title='$date'>" . $this->language->get('text_interval_3_minutes_ago') . "</acronym>"; break;
					case 4: return "<acronym title='$date'>" . $this->language->get('text_interval_4_minutes_ago') . "</acronym>"; break;
					case 5: return "<acronym title='$date'>" . $this->language->get('text_interval_5_minutes_ago') . "</acronym>"; break;
					default: return "<acronym title='$date'>" . floor($d / 60) . " " . $this->language->get('text_interval_minutes_ago') . "</acronym>"; break;
				}
				;
			} elseif ($d < 18000) {
				switch (floor($d / 3600)) {
					case 1: return "<acronym title='$date'>" . $this->language->get('text_interval_1_hour_ago') . "</acronym>"; break;
					case 2: return "<acronym title='$date'>" . $this->language->get('text_interval_2_hour_ago') . "</acronym>"; break;
					case 3: return "<acronym title='$date'>" . $this->language->get('text_interval_3_hour_ago') . "</acronym>"; break;
					case 4: return "<acronym title='$date'>" . $this->language->get('text_interval_4_hour_ago') . "</acronym>"; break;
				}
				;
			} elseif ($d < 86400) {
				if (date('d') == $a[2]) {
					return "<acronym title='$date'>" . $this->language->get('text_interval_today_in') . " {$a[3]}:{$a[4]}</acronym>";
				}
				if (date('d', time() - 86400) == $a[2]) {
					return "<acronym title='$date'>" . $this->language->get('text_interval_yesterday_in') . " {$a[3]}:{$a[4]}</acronym>";
				}
			}
		} else {
			$d *= -1;
			if ($d < 3600) {
				switch (floor($d / 60)) {
					case 0:
					case 1: return "<acronym title='$date'>" . $this->language->get('text_interval_right_now') . "</acronym>"; break;
					case 2: return "<acronym title='$date'>" . $this->language->get('text_interval_in_2_minutes') . "</acronym>"; break;
					case 3: return "<acronym title='$date'>" . $this->language->get('text_interval_in_3_minutes') . "</acronym>"; break;
					case 4: return "<acronym title='$date'>" . $this->language->get('text_interval_in_4_minutes') . "</acronym>"; break;
					case 5: return "<acronym title='$date'>" . $this->language->get('text_interval_in_5_minutes') . "</acronym>"; break;
					default: return "<acronym title='$date'>" . sprintf($this->language->get('text_interval_in_minutes'), floor($d / 60)) . "</acronym>"; break;
				}
				;
			} elseif ($d < 18000) {
				switch (floor($d / 3600)) {
					case 1: return "<acronym title='$date'>" . $this->language->get('text_interval_in_an_hour') . "</acronym>"; break;
					case 2: return "<acronym title='$date'>" . $this->language->get('text_interval_in_2_hours') . "</acronym>"; break;
					case 3: return "<acronym title='$date'>" . $this->language->get('text_interval_in_3_hours') . "</acronym>"; break;
					case 4: return "<acronym title='$date'>" . $this->language->get('text_interval_in_4_hours') . "</acronym>"; break;
				}
				;
			} elseif ($d < 86400) {
				if (date('d') == $a[2]) {
					return "<acronym title='$date'>" . $this->language->get('text_interval_today_at') . " {$a[3]}:{$a[4]}</acronym>";
				}
				if (date('d', time() - 86400) == $a[2]) {
					return "<acronym title='$date'>" . $this->language->get('text_interval_tomorrow_at') . " {$a[3]}:{$a[4]}</acronym>";
				}
			}
			$d *= -1;
		}
		$r = "{$a[2]}.{$a[1]}";
		if ($a[0] != date('Y') OR $d > 0) {
			$r .= '.' . $a[0];
		}
		$r .= " {$a[3]}:{$a[4]}";
		$date = date_format(new \DateTime($date), $format);
		return "<acronym title='$date'>$date</acronym>";
	}
}