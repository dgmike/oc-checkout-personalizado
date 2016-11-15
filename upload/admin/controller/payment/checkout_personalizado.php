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
        $this->setData('action', $this->linkTo('payment/checkout_personalizado'));

        $this->view('payment/checkout_personalizado');
    }

    private function setData($key, $value) {
        $this->data[$key] = $value;
    }

    private function defaultData() {
        $this->setData('token', $this->session->data['token']);

        $this->setData('heading_title', $this->language->get('heading_title'));
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
