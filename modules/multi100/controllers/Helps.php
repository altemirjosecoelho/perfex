<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Helps extends AdminController
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('multi100');
        $this->load->library('multi100_gateway');
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
        $get_helps = $this->multi100->get_helps();

        if ($get_helps->error) {
            $error = $get_helps->error;

            set_alert('danger', $error);
            redirect(admin_url());
        }

        $data = [
            'get_helps' => $get_helps,
            'title' => 'Ajudas'
        ];

        $this->load->view('multi100/helps/list', $data);
    }

    public function read($id = NULL)
    {
        if (!$id) {
            set_alert('error', 'Não encontrado');
            redirect(admin_url('multi100/helps'), 'refresh');
        }

        $get_help = $this->multi100->get_help($id);

        $data = [
            'get_help' => $get_help,
            'title' => 'Ajuda'
        ];

        $this->load->view('multi100/helps/read', $data);
    }

    public function create()
    {
        if ($this->input->post()) {
            $post_data = json_encode([
                "title" => $this->input->post('title', TRUE),
                "description" => $this->input->post('description', TRUE),
                "video" => $this->input->post('video', TRUE),
                "link" => $this->input->post('link', TRUE)

            ]);

            $create_help = $this->multi100->create_help($post_data);

            if (is_array($create_help) && !empty($create_help['error'])) {
                $error = $create_help['error'];

                return $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(400)
                    ->set_output(json_encode($error));
            }
            
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode(['success' => true, 'message' => 'Ajuda criado com sucesso']));
        }

        $data = [
            'title' => 'Adicionar nova Ajuda'
        ];

        $this->load->view('multi100/helps/create', $data);
    }

    public function update($id = NULL)
    {
        if (!$id) {
            set_alert('error', 'Não encontrado');
            redirect(admin_url('multi100/helps'), 'refresh');
        }

        if ($this->input->post()) {
            $post_data = json_encode([
                "title" => $this->input->post('title', TRUE),
                "description" => $this->input->post('description', TRUE),
                "video" => $this->input->post('video', TRUE),
                "link" => $this->input->post('link', TRUE)
            ]);

            $update_help = $this->multi100->update_help($id, $post_data);

            if (is_array($update_help) && !empty($update_help['error'])) {
                $error = $update_help['error'];

                return $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(400)
                    ->set_output(json_encode($error));
            }

            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode(['success' => true, 'message' => 'Ajuda atualizado com sucesso']));
        }

        $get_help = $this->multi100->get_help($id);

        $data = [
            'get_help' => $get_help,
            'title' => 'Editar Ajuda'
        ];

        $this->load->view('multi100/helps/update', $data);
    }

    public function delete($id = NULL)
    {
        if (!$id) {
            set_alert('error', 'Não encontrado');
            redirect(admin_url('multi100/helps'), 'refresh');
        }

        $delete_help = $this->multi100->delete_help($id);

        if ($delete_help->error) {
            $error = $delete_help->error;

            set_alert('danger', $error);
            redirect(admin_url('multi100/helps'));
        }

        set_alert('success', 'Deletado');
        redirect(admin_url('multi100/helps'), 'refresh');
    }
}
