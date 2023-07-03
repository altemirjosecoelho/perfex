<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Config extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('leads_model');
        $this->load->model('staff_model');
        $this->load->model('multi100_model');
    }

    public function index()
    {
        if ($this->input->post()) {
            $post_data = $this->input->post(NULL, TRUE);

            $data = [
                'multi100_api_token' => $post_data['multi100_api_token'],
                'multi100_api_url' => $post_data['multi100_api_url'],
                'multi100_split_type' => $post_data['multi100_split_type'],
                'multi100_split_value' => $post_data['multi100_split_value'],
                'multi100_client_token' => $post_data['multi100_client_token'],
                'asaas_sandbox' => $post_data['asaas_sandbox'],
                'asaas_api_key' => $post_data['asaas_api_key'],
                'asaas_api_key_sandbox' => $post_data['asaas_api_key_sandbox'],
                'elementor_api_assigned' => $post_data['elementor_api_assigned'],
                'elementor_api_source' => $post_data['elementor_api_source']
            ];


            $this->multi100_model->update_config($data);

            set_alert('success', 'Atualizado!');
            redirect(admin_url('multi100/config'), 'refresh');
        }

        $sources = $this->leads_model->get_source();

        $get_config = $this->multi100_model->get_config();

        $staffs = $this->staff_model->get();

        $data = [
            'multi100_api_token' => $get_config->multi100_api_token,
            'multi100_api_url' => $get_config->multi100_api_url,
            'multi100_split_type' => $get_config->multi100_split_type,
            'multi100_split_value' => $get_config->multi100_split_value,
            'multi100_client_token' => $get_config->multi100_client_token,
            'asaas_sandbox' => $get_config->asaas_sandbox,
            'asaas_api_key' => $get_config->asaas_api_key,
            'asaas_api_key_sandbox' => $get_config->asaas_api_key_sandbox,
            'elementor_api_assigned' => $get_config->elementor_api_assigned,
            'elementor_api_source' => $get_config->elementor_api_source,
            'sources' => $sources,
            'staffs' => $staffs,
            'title' => 'Configurações'
        ];

        $this->load->view('multi100/config', $data);
    }
}
