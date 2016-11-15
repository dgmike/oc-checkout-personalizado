<?php

class ControllerCheckoutPersonalizado extends Controller {
    public function index() {
        $this->load->language('payment/checkout_personalizado');

        $data['heading_title'] = $this->language->get('heading_title');
        $data['breadcrumb'] = array();

        $output = $this->load->view('payment/checkout_personalizado.tpl', $data);
        $this->response->setOutput($output);
    }
}
