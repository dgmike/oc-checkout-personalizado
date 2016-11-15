<?php

class ControllerPaymentCheckoutPersonalizado extends Controller {
    public $data = array();

    public function __construct($registry) {
        parent::__construct($registry);

        $this->load->language('payment/checkout_personalizado');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->defaultData();
    }

    public function index() {
        $this->setData(
            array(
                'text_edit',
                'tab_geral', 'tab_api', 'tab_situacoes', 'tab_finalizacao',
            )
        );

        $this->breadcrumb('text_home', 'common/dashboard');
        $this->breadcrumb('text_payment', 'extension/payment');
        $this->breadcrumb('heading_title', 'payment/checkout_personalizado');

        $this->setData('action', $this->linkTo('payment/checkout_personalizado'));

        $this->view('payment/checkout_personalizado');
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

    private function breadcrumb($title, $uri) {
        $breadcrumb = array(
            'href' => $this->linkTo($uri),
            'text' => $this->language->get($title),
        );
        array_push($this->data['breadcrumbs'], $breadcrumb);
    }

    private function defaultData() {
        $this->setData('token', $this->session->data['token']);

        $this->setData('heading_title');
        $this->setData('breadcrumbs', array());

        $this->setData('header', $this->load->controller('common/header'));
        $this->setData('column_left', $this->load->controller('common/column_left'));
        $this->setData('footer', $this->load->controller('common/footer'));
    }

    private function linkTo($uri) {
        return $this->url->link($uri, 'token=' . $this->session->data['token'], true);
    }

    private function view($template) {
        $output = $this->load->view("${template}.tpl", $this->data);
        $this->response->setOutput($output);
    }
}
