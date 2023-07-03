<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Fields extends AdminController
{
    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        set_alert('warning', 'Indisponivel');
        redirect(admin_url('multi100/submissions'), 'refresh');

        $this->db->where('active', 1);
        $customfields = $this->db->get(db_prefix() . 'customfields')->result();

        if ($this->input->post()) {
            $post_data = $this->input->post();

            foreach ($post_data['customfield'] as $customfield) {
                $this->db->where('module_field', 'email');
                $email_field = $this->db->get(db_prefix() . 'asaas_customfields')->row();

                if ($email_field) {
                    $this->db->where('module_field', 'email');
                    $this->db->update(db_prefix() . 'asaas_customfields', ['custom_field' => $customfield['email']]);
                } else {
                    $this->db->insert(db_prefix() . 'asaas_customfields', ['module_field' => 'email', 'custom_field' => $customfield['email']]);
                }

                $this->db->where('module_field', 'address_number');
                $address_number_field = $this->db->get(db_prefix() . 'asaas_customfields')->row();

                if ($address_number_field) {
                    $this->db->where('module_field', 'address_number');
                    $this->db->update(db_prefix() . 'asaas_customfields', ['custom_field' => $customfield['address_number']]);
                } else {
                    $this->db->insert(db_prefix() . 'asaas_customfields', ['module_field' => 'address_number', 'custom_field' => $customfield['address_number']]);
                }
            }

            set_alert('success', 'Salvo!');
            redirect(site_url('multi100/fields'));
        }

        $asaas_customfields = $this->db->get(db_prefix() . 'asaas_customfields')->result_array();

        $this->db->where('module_field', 'email');
        $email = $this->db->get(db_prefix() . 'asaas_customfields')->row()->custom_field;

        $this->db->where('module_field', 'address_number');
        $address_number = $this->db->get(db_prefix() . 'asaas_customfields')->row()->custom_field;

        $module_fields = [

            'email' => 'Email do cliente',
            'address_number' => 'Numero do endereço'
        ];

        $data = [
            'email' => $email,
            'address_number' => $address_number,
            'asaas_customfields' => $asaas_customfields,
            'customfields' => $customfields,
            'module_fields' => $module_fields,
            'title' => 'Configurar campos'
        ];

        $this->load->view('multi100/fields', $data);
    }
}
