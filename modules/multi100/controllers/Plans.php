<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Plans extends AdminController
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
        $get_plans = $this->multi100->get_plans();

        if ($get_plans->error) {
            $error = $get_plans->error;

            set_alert('danger', $error);
            redirect(admin_url());
        }

        $data = [
            'get_plans' => $get_plans,
            'title' => 'Planos'
        ];

        $this->load->view('multi100/plans/list', $data);
    }

    public function read($id = NULL)
    {
        if (!$id) {
            set_alert('danger', 'Não encontrado');
            redirect(admin_url('multi100/plans'), 'refresh');
        }

        $get_plan = $this->multi100->get_plan($id);

        if ($get_plan->error) {
            $error = $get_plan->error;

            set_alert('danger', $error);
            redirect(admin_url('multi100/plans'), 'refresh');
        }

        $data = [
            'get_plan' => $get_plan,
            'title' => 'Plano'
        ];

        $this->load->view('multi100/plans/read', $data);
    }

    public function create()
    {
        if ($this->input->post()) {
            $post_data = json_encode([
                "name" => $this->input->post('name', TRUE),
                "users" => $this->input->post('users', TRUE),
                "connections" => $this->input->post('connections', TRUE),
                "queues" => $this->input->post('queues', TRUE),
                "amount" => $this->input->post('amount', TRUE),
                "useWhatsapp" => $this->input->post('useWhatsapp', TRUE),
                "useFacebook" => $this->input->post('useFacebook', TRUE),
                "useInstagram" => $this->input->post('useInstagram', TRUE),
                "useCampaigns" => $this->input->post('useCampaigns', TRUE),
                "useSchedules" => $this->input->post('useSchedules', TRUE),
                "useInternalChat" => $this->input->post('useInternalChat', TRUE),
                "useExternalApi" => $this->input->post('useExternalApi', TRUE),
                "trial" => $this->input->post('trial', TRUE),
                "trialDays" => $this->input->post('trialDays', TRUE),
                "recurrence" => $this->input->post('recurrence', TRUE),
            ]);

            $create_plan = $this->multi100->create_plan($post_data);

            if (is_array($create_plan) && !empty($create_plan['error'])) {
                $error = $create_plan['error'];

                return $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(400)
                    ->set_output(json_encode($error));
            }
            
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode(['success' => true, 'message' => 'Plano criado com sucesso']));
        }

        $data = [
            //   'get_plan' => $get_plan,
            'title' => 'Adicionar novo Plano'
        ];

        $this->load->view('multi100/plans/create', $data);
    }

    public function update($id = NULL)
    {
        if (!$id) {
            set_alert('danger', 'Não encontrado');
            redirect(admin_url('multi100/plans'), 'refresh');
        }

        if ($this->input->post()) {
            $post_data = json_encode([
                "name" => $this->input->post('name', TRUE),
                "users" => $this->input->post('users', TRUE),
                "connections" => $this->input->post('connections', TRUE),
                "queues" => $this->input->post('queues', TRUE),
                "amount" => $this->input->post('amount', TRUE),
                "useWhatsapp" => $this->input->post('useWhatsapp', TRUE),
                "useFacebook" => $this->input->post('useFacebook', TRUE),
                "useInstagram" => $this->input->post('useInstagram', TRUE),
                "useCampaigns" => $this->input->post('useCampaigns', TRUE),
                "useSchedules" => $this->input->post('useSchedules', TRUE),
                "useInternalChat" => $this->input->post('useInternalChat', TRUE),
                "useExternalApi" => $this->input->post('useExternalApi', TRUE),
                "trial" => $this->input->post('trial', TRUE),
                "trialDays" => $this->input->post('trialDays', TRUE),
                "recurrence" => $this->input->post('recurrence', TRUE),
            ]);

            $update_plan = $this->multi100->update_plan($id, $post_data);

            if (is_array($update_plan) && !empty($update_plan['error'])) {
                $error = $update_plan['error'];

                return $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(400)
                    ->set_output(json_encode($error));
            }

            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode(['success' => true, 'message' => 'Plano atualizado com sucesso']));
        }

        $get_plan = $this->multi100->get_plan($id);

        $data = [
            'get_plan' => $get_plan,
            'title' => 'Editar Plano'
        ];

        $this->load->view('multi100/plans/update', $data);
    }

    public function delete($id)
    {
        if (!$id) {
            set_alert('danger', 'Não encontrado');
            redirect(admin_url('multi100/plans'), 'refresh');
        }

        $delete_plan = $this->multi100->delete_plan($id);

        if ($delete_plan->error) {
            $error = $delete_plan->error;

            set_alert('danger', $error);
            redirect(admin_url('multi100/plans'));
        }

        set_alert('success', 'Deletado');
        redirect(admin_url('multi100/plans'), 'refresh');
    }
}
