<?php

class ControllerPaymentCheckoutPersonalizado extends Controller {
    public $data = array();

    public function index() {
        $this
            ->setUp()
            ->breadcrumbsFor('index')
            ->setDataFor('index');

        $this->load->model('localisation/geo_zone');
        $this->setData(
            'geo_zones',
            $this->model_localisation_geo_zone->getGeoZones()
        );

        $this->load->model('localisation/order_status');
        $this->setData(
            'order_statuses',
            $this->model_localisation_order_status->getOrderStatuses()
        );

        $this->view('payment/checkout_personalizado');
    }

    private function setUp() {
        $this->defaultData();
        $this->document->setTitle($this->language->get('heading_title'));
        return $this;
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
                $this->setData(
                    array(
                        'text_edit',
                        'tab_geral', 'tab_api', 'tab_situacoes', 'tab_finalizacao',

                        'entry_total', 'help_total',
                        'entry_geo_zone', 'text_all_zones',
                        'entry_status', 'text_enabled', 'text_disabled',
                        'entry_sort_order',
                    )
                );
                $this->setData('action', $this->linkTo('payment/checkout_personalizado'));
                break;
        }
        return $this;
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
}
