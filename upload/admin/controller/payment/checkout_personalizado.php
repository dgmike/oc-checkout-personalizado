<?php

class ControllerPaymentCheckoutPersonalizado extends Controller {
    const MODIFICATION_CODE = 'checkoutp';
    public $data = array();

    // actions
    public function index() {
        $this
            ->setUp()
            ->breadcrumbsFor('index')
            ->setDataFor('index')
            ->loadSettingsData();

        if ($this->isPost() && $this->validate()) {
            $this->savePostData();
            return;
        }

        $this->view('payment/checkout_personalizado');
    }

    // support methods
    private function setUp() {
        $this->defaultData();
        $this->document->setTitle($this->language->get('heading_title'));
        $this->setData('version', $this->modification()->version);
        return $this;
    }

    private function modification() {
        $model = $this->model('extension/modification');
        $data = $model->getModificationByCode(self::MODIFICATION_CODE);
        return (object) $data;
    }

    private function setData($key, $value = null) {
        if (1 === func_num_args()) {
            if (!is_array($key)) {
                $key = array($key);
            }
            foreach ($key as $item) {
                $this->data[$item] = $this->language->get($item);
            }
            return;
        }
        $this->data[$key] = $value;
    }

    private function setDataFor($action) {
        switch ($action) {
            case 'index':
                $this->setDataForIndex();
                break;
        }
        return $this;
    }

    function setDataForIndex() {
        $this->setData(
            array(
                'text_edit',
                'tab_geral', 'tab_api', 'tab_situacoes', 'tab_finalizacao',

                // fields geral
                'entry_total', 'help_total',
                'entry_geo_zone', 'text_all_zones',
                'entry_status', 'text_enabled', 'text_disabled',
                'entry_sort_order',
            )
        );
        $this->setData('action', $this->linkTo('payment/checkout_personalizado'));

        $this->setData('geo_zones', $this->model('localisation/geo_zone')->getGeoZones());
        $this->setData(
            'order_statuses', $this->model('localisation/order_status')->getOrderStatuses()
        );
    }

    private function breadcrumb($title, $uri) {
        $breadcrumb = array(
            'href' => $this->linkTo($uri),
            'text' => $this->language->get($title),
        );
        array_push($this->data['breadcrumbs'], $breadcrumb);
        return $this;
    }

    private function breadcrumbsFor($action) {
        switch ($action) {
            case 'index':
                $this->breadcrumb('text_home', 'common/dashboard')
                     ->breadcrumb('text_payment', 'extension/payment')
                     ->breadcrumb('heading_title', 'payment/checkout_personalizado');
                break;
        }
        return $this;
    }

    private function defaultData() {
        $this->setData('modification_code', self::MODIFICATION_CODE);

        $this->setData('header', $this->load->controller('common/header'));
        $this->setData('column_left', $this->load->controller('common/column_left'));
        $this->setData('footer', $this->load->controller('common/footer'));
        $this->setData('token', $this->session->data['token']);

        $this->load->language('payment/checkout_personalizado');

        $this->setData('heading_title');
        $this->setData('breadcrumbs', array());
    }

    private function linkTo($uri) {
        return $this->url->link($uri, 'token=' . $this->session->data['token'], true);
    }

    private function view($template) {
        $output = $this->load->view("${template}.tpl", $this->data);
        $this->response->setOutput($output);
    }

    private function validate() {
        if (!$this->user->hasPermission('modify', 'payment/checkout_personalizado')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }

    private function isPost() {
        return $this->request->server['REQUEST_METHOD'] == 'POST';
    }

    private function model($model) {
        $this->load->model($model);
        $node = 'model_' . str_replace('/', '_', $model);
        return $this->$node;
    }

    private function savePostData() {
        $this->load->model('setting/setting');
        $this->model_setting_setting->editSetting(self::MODIFICATION_CODE, $this->request->post);
        $this->session->data['success'] = $this->language->get('text_success');
        $this->response->redirect($this->linkTo('payment/checkout_personalizado'));
    }

    private function loadSettingsData() {
        $settings = array(
            'total', 'status', 'geo_zone_id', 'sort_order',
        );
        foreach ($settings as $setting) {
            $setting = self::MODIFICATION_CODE . '_' . $setting;
            if ($this->isPost() && isset($this->request->post[$setting])) {
                $this->setData($setting, $this->request->post[$setting]);
            } else {
                $this->setData($setting, $this->config->get($setting));
            }
        }
    }
}
