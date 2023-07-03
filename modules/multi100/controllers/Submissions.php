<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Submissions extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('multi100');
        $this->load->library('multi100_gateway');
        $this->load->helper('multi100');
        $this->load->model('multi100_model');

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
    }

    public function index()
    {
        $get_submissions = $this->db->get(db_prefix() . 'multi100_submissions')->result();

        $data = [
            'get_submissions' => $get_submissions,
            'title' => 'Formularios'
        ];

        $this->load->view('multi100/submissions/list', $data);
    }

    public function read($id = NULL)
    {
        $this->db->select('*');
        $this->db->from(db_prefix() . 'multi100_submissions');
        $this->db->join('tblleads', 'tblleads.id = multi100_submissions.perfex_lead_id', 'inner');
        $this->db->where('multi100_submissions.id', $id);

        $get_submission = $this->db->get()->row();

        $data = [
            'get_submission' => $get_submission,
            'title' => 'Formulario'
        ];

        $this->load->view('multi100/submissions/read', $data);
    }

    public function payload($id = NULL, $step = NULL)
    {
        $this->db->where('id', $id);

        $get_submission = $this->db->get(db_prefix() . 'multi100_submissions')->row();

        if ($step == 'multi100_plan') {
            $payload = $get_submission->multi100_plan_payload;
        }

        if ($step == 'asaas_customer') {
            $payload = $get_submission->asaas_customer_payload;
        }

        if ($step == 'asaas_subscription') {
            $payload = $get_submission->asaas_subscription_payload;
        }

        if ($step == 'multi100_customer') {
            $payload = $get_submission->multi100_client_payload;
        }

        $data = [
            'payload' => $payload,
            'title' => 'Formulario'
        ];

        $this->load->view('multi100/submissions/payload', $data);
    }

    public function update($id = NULL)
    {
        if ($this->input->post()) {
            var_dump($this->input->post());

            die();
            // $get_submission = json_decode($get_submission->payload, true);
        }

        $this->db->where('id', $id);

        $get_submission = $this->db->get(db_prefix() . 'multi100_submissions')->row();

        $get_submission = json_decode($get_submission->payload);

        $get_plans = $this->multi100->get_plans();

        $data = [
            'get_plans' => $get_plans,
            'get_submission' => $get_submission->fields,
            //   'get_submissions' => $get_submissions,
            'title' => 'Formulario'
        ];

        $this->load->view('multi100/submissions/update', $data);
    }


    public function retry($id = NULL, $step = NULL)
    {
        set_alert('warning', 'Indisponivel');
        redirect(admin_url('multi100/submissions'), 'refresh');

        $this->db->where('id', $id);

        $get_submission = $this->db->get(db_prefix() . 'multi100_submissions')->row();

        $get_submission = json_decode($get_submission->payload, TRUE);

        $post_data = $get_submission["fields"];

        $document = str_replace('/', '', str_replace('-', '', str_replace('.', '', $post_data["document"]["value"])));

        if ($step == 'multi100_plan') {
            // multi100_plan
        }

        if ($step == 'asaas_customer') {
            // asaas_customer
        }

        if ($step == 'asaas_subscription') {
            // asaas_subscription
        }

        if ($step == 'multi100_customer') {
            // multi100_customer
        }
    }

    public function delete($id = NULL)
    {
        if (!$id) {
            set_alert('danger', 'Não encontrado');
            redirect(admin_url('multi100/submissions'), 'refresh');
        }
        $this->db->where('id', $id);
        $this->db->delete(db_prefix() . 'multi100_submissions');

        set_alert('success', 'Deletado');
        redirect(admin_url('multi100/submissions'), 'refresh');
    }
}
