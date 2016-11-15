<?php

class ControllerPaymentCheckoutPersonalizado extends Controller {
    public $data = array();

    public function __construct($registry) {
        parent::__construct($registry);
        $this->defaultData();
    }

    public function index() {
        $this->view('payment/checkout_personalizado');
    }

    private function defaultData() {
        $this->load->language('payment/checkout_personalizado');

        $this->data['heading_title'] = $this->language->get('heading_title');
        $this->data['breadcrumbs'] = array();

        $this->data['header'] = $this->load->controller('common/header');
        $this->data['column_left'] = $this->load->controller('common/column_left');
        $this->data['footer'] = $this->load->controller('common/footer');
    }

    private function view($template) {
        $output = $this->load->view("${template}.tpl", $this->data);
        $this->response->setOutput($output);
    }
}
