<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Partners extends AdminController
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('multi100');
        $this->load->helper('multi100');
        $this->load->model('multi100_model');

        if (!check_multi100_config()) {
            set_alert('warning', 'Preencha as credenciais de api');
            redirect(admin_url('multi100/config'), 'refresh');
        }

        $get_config = $this->multi100_model->get_config();

        $api_token = $get_config->multi100_api_token;

        $api_url = $get_config->multi100_api_url;

        $this->multi100->setCreds($api_url, $api_token);
    }

    public function index()
    {
        $get_partners = $this->multi100->get_partners();

        if ($get_partners->error) {
            $error = $get_partners->error;

            set_alert('danger', $error);
            redirect(admin_url());
        }

        $data = [
            'get_partners' => $get_partners,
            'title' => 'Parceiros'
        ];

        $this->load->view('multi100/partners/list', $data);
    }

    public function read($id = NULL)
    {
        if (!$id) {
            set_alert('error', 'Não encontrado');
            redirect(admin_url('multi100/partners'), 'refresh');
        }

        $get_partner = $this->multi100->get_partner($id);

        $data = [
            'get_partner' => $get_partner,
            'title' => 'Detalhes do Parceiro'
        ];

        $this->load->view('multi100/partners/read', $data);
    }

    public function create()
    {
        if ($this->input->post()) {

            $post_data = json_encode([
                "name" => $this->input->post('name', TRUE),
                "phone" => $this->input->post('phone', TRUE),
                "email" => $this->input->post('email', TRUE),
                "document" => $this->input->post('document', TRUE),
                "walletId" => $this->input->post('walletId', TRUE),
                "typeCommission" => $this->input->post('typeCommission', TRUE),
                "commission" => $this->input->post('commission', TRUE),
            ]);

            $create_partner = $this->multi100->create_partner($post_data);

            if (is_array($create_partner) && !empty($create_partner['error'])) {
                $error = $create_partner['error'];

                return $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(400)
                    ->set_output(json_encode($error));
            }

            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode(['success' => true, 'message' => 'Parceiro criado com sucesso']));
        }

        $data = [
            'title' => 'Adicionar novo Parceiro'
        ];

        $this->load->view('multi100/partners/create', $data);
    }

    public function update($id = NULL)
    {
        if (!$id) {
            set_alert('error', 'Não encontrado');
            redirect(admin_url('multi100/partners'), 'refresh');
        }

        if ($this->input->post()) {
            $post_data = json_encode([
                "name" => $this->input->post('name', TRUE),
                "phone" => $this->input->post('phone', TRUE),
                "email" => $this->input->post('email', TRUE),
                "document" => $this->input->post('document', TRUE),
                "walletId" => $this->input->post('walletId', TRUE),
                "typeCommission" => $this->input->post('typeCommission', TRUE),
                "commission" => $this->input->post('commission', TRUE),
            ]);

            $update_partner = $this->multi100->update_partner($id, $post_data);

            if (is_array($update_partner) && !empty($update_partner['error'])) {
                $error = $update_partner['error'];

                return $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(400)
                    ->set_output(json_encode($error));
            }

            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode(['success' => true, 'message' => 'Parceiro atualizado com sucesso']));
        }

        $get_partner = $this->multi100->get_partner($id);

        $data = [
            'get_partner' => $get_partner,
            'title' => 'Editar Parceiro'
        ];

        $this->load->view('multi100/partners/update', $data);
    }

    public function delete($id = NULL)
    {
        if (!$id) {
            set_alert('error', 'Não encontrado');
            redirect(admin_url('multi100/partners'), 'refresh');
        }

        $delete_partner = $this->multi100->delete_partner($id);

        if ($delete_partner->error) {
            $error = $delete_partner->error;

            set_alert('danger', $error);
            redirect(admin_url('multi100/partners'));
        }

        set_alert('success', 'Deletado');
        redirect(admin_url('multi100/partners'), 'refresh');
    }
}
