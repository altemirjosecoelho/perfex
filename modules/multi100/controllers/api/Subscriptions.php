<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Subscriptions extends APP_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('multi100_model');
        $this->load->library('multi100');
        $this->load->library('multi100_gateway');

        $get_config = $this->multi100_model->get_config();

        $api_token = $get_config->multi100_api_token;

        $api_url = $get_config->multi100_api_url;

        $this->multi100->setCreds($api_url, $api_token);

        $asaas_sandbox = $get_config->asaas_sandbox;

        if ($asaas_sandbox == '0') {

            $api_key = $get_config->asaas_api_key;
            $api_url = "https://www.asaas.com";
        } else {
            $api_key = $get_config->asaas_api_key_sandbox;
            $api_url = "https://sandbox.asaas.com";
        }

        $this->multi100_gateway->setCreds($api_url, $api_key);

        $headers = $this->input->request_headers();
        $apiKey = $headers['apiKey'] ?? $headers['Apikey'];

        if (!$apiKey) {
            $data = array('Success' => false, 'Message' => 'Unauthorized');
            $json = json_encode($data);
            header('Content-Type: application/json');
            echo $json;
            exit();
        }

        if ($apiKey != $api_token) {
            $data = array('Success' => false, 'Message' => 'Unauthorized');
            $json = json_encode($data);
            header('Content-Type: application/json');
            echo $json;
            exit();
        }
    }

    public function index()
    {
        if (isset($_GET['companyId'])) {
            $companyId = $_GET['companyId'];

            $this->get($companyId);
        }
    }

    public function get($id)
    {
        $page_number = $this->input->get('pageNumber') ?? 1;

        $this->db->select('*');
        $this->db->from(db_prefix() . 'multi100_submissions');
        $this->db->like('multi100_client_payload', '"id":' . $id, 'both');
        $query = $this->db->get();
        $results = $query->result();

        $customer = json_decode($results[0]->asaas_subscription_payload)->customer;

        if (!$customer) {
            $json_data = json_encode([
                'records' => [],
                'count' => 0,
                'hasMore' => false
            ]);
            header('Content-Type: application/json');
            echo $json_data;
            exit();
        }

        $limit = 20;

        $offset = $limit * ($page_number - 1);

        $get_subscriptions = $this->multi100_gateway->get_subscriptions($offset, $limit, $customer);

        $data = [];
        $count = 0;

        foreach ($get_subscriptions->data as $item) {
            $get_subscription_payments = $this->multi100_gateway->get_subscription_payments($item->id);

            $data[] = [
                'object' => $item->object,
                'id' => $item->id,
                'dateCreated' => $item->dateCreated,
                'customer' => $item->customer,
                'value' => $item->value,
                'endDate' => $item->endDate,
                'cycle' => $item->cycle,
                'description' => $item->description,
                'billingType' => $item->billingType,
                'invoiceUrl' => $get_subscription_payments->data[0]->invoiceUrl,
                "status" => $get_subscription_payments->data[0]->status,
            ];

            $count += 1;
        }

        $has_more = $count > $offset + $count;

        $json_data = json_encode([
            'records' => $data,
            'count' => $count,
            'hasMore' => $has_more
        ]);
        header('Content-Type: application/json');
        echo $json_data;
    }
}
