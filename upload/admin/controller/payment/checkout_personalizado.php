<?php

class ControllerPaymentCheckoutPersonalizado extends Controller {
    public function index() {
        $this->load->language('payment/checkout_personalizado');

        $data['heading_title'] = $this->language->get('heading_title');
        $data['breadcrumb'] = array();

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $output = $this->load->view('payment/checkout_personalizado.tpl', $data);
        $this->response->setOutput($output);
    }
}
