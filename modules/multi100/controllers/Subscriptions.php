<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Subscriptions extends AdminController
{
    function __construct()
    {
        parent::__construct();

        $this->load->library('multi100');
        $this->load->library('multi100_gateway');
        $this->load->helper('multi100');
        $this->load->model('multi100_model');

        if (!check_asaas_config()) {
            set_alert('warning', 'Preencha as credenciais do asaas');
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
        $offset = 0;

        $limit = 100;

        $get_subscriptions = $this->multi100_gateway->get_subscriptions($offset, $limit);

        if ($get_subscriptions->error) {

            $error = $get_subscriptions->error;

            set_alert('danger', $error);
            redirect(admin_url());
        }

        $data = [
            'get_subscriptions' => $get_subscriptions,
            'title' => 'Assinaturas'
        ];

        $this->load->view('multi100/subscriptions/list', $data);
    }

    public function read($id)
    {
        $get_subscription_payments = $this->multi100_gateway->get_subscription_payments($id);

        if ($get_subscription_payments->error) {

            $error = $get_subscription_payments->error;

            set_alert('danger', $error);
            redirect(admin_url('multi100/subscriptions'), 'refresh');
        }

        $data = [
            'get_subscription_payments' => $get_subscription_payments,
            'title' => 'Assinaturas'
        ];

        $this->load->view('multi100/subscriptions/read', $data);
    }

    public function create()
    {
        if ($this->input->post()) {

            $customer = $this->input->post('customer', TRUE);

            $nextDueDate = $this->input->post('nextDueDate', TRUE);

            $endDate = $this->input->post('endDate', TRUE);

            $split_type = $this->input->post('split_type', TRUE);

            $split_value = $this->input->post('split_value', TRUE);

            $value = $this->input->post('value', TRUE);

            $fine = $this->input->post('fine_value', TRUE);

            $interest = $this->input->post('interest_value', TRUE);

            $walletId = $this->input->post('split_wallet', TRUE);

            $this->db->where('userid', $customer);
            $client = $this->db->get(db_prefix() . 'clients')->row();

            $this->db->where('userid', $customer);
            $this->db->where('is_primary', 1);
            $primary_contact = $this->db->get(db_prefix() . 'contacts')->row();

            $email = $primary_contact->email;

            $document = str_replace('/', '', str_replace('-', '', str_replace('.', '', $client->vat)));

            $asaas_customer = $this->multi100_gateway->get_customer($document);

            if (!$asaas_customer) {

                $error = $asaas_customer->errors[0]->description;

                set_alert('warning', $error);
                redirect(site_url('multi100/subscriptions/create'), 'refresh');
            }


            if ($asaas_customer->totalCount == 0) {

                $customer_data = json_encode([
                    "name" => $client->name,
                    "email" => $client->email,
                    "cpfCnpj" => $document,
                    "phone" => $client->phonenumber,
                    "mobilePhone" => $client->phonenumber,
                    "externalReference" => $client->userid,
                    "notificationDisabled" => false
                ]);

                $create_customer = $this->multi100_gateway->create_customer($customer_data);

                if ($create_customer->error) {
                    $error = $create_customer->errors[0]->description;

                    set_alert('warning', $error);
                    redirect(site_url('multi100/subscriptions/create'), 'refresh');
                }
                $customer_id = $create_customer->id;
            } else {
                $customer_id = $asaas_customer->data[0]->id;
            }

            if ($split_type == 'fixed') {
                $split = [
                    [
                        "walletId" => $walletId,
                        "fixedValue" => $split_value
                    ]
                ];
            }

            if ($split_type == 'percentual') {
                $split = [
                    [
                        "walletId" => $walletId,
                        "percentualValue" => $split_value
                    ]
                ];
            }

            $maxPayments = get_months_between_dates(date('Y-m-d'), $endDate);

            $post_data = [
                "customer" => $customer_id,
                "billingType" => $this->input->post('billingType', TRUE),
                "nextDueDate" => $this->input->post('nextDueDate', TRUE),
                "value" => $value,
                "description" => $this->input->post('description', TRUE),
                "cycle" => $this->input->post('cycle', TRUE),
                "endDate" => $this->input->post('endDate', TRUE),
                "maxPayments" => $maxPayments,
                "externalReference" => $client->userid . '-' . $primary_contact->id . '-' . $this->input->post('planId', TRUE),
                "fine" => [
                    "value" => $fine,
                ],
                "interest" => [
                    "value" => $interest,
                ],
                "split" => $split,
                "postalService" => true
            ];

            $create_subscription = $this->multi100_gateway->create_subscription($post_data);

            if (!$create_subscription) {
                $error = $create_subscription->errors[0]->description;

                set_alert('warning', $error);
                redirect(site_url('multi100/subscriptions/create'), 'refresh');
            }

            set_alert('success', 'Cadastrado');
            redirect(admin_url('multi100/subscriptions'), 'refresh');
        }

        $get_customers = $this->multi100_gateway->get_customers();

        $wallets = $this->multi100_gateway->wallets();

        $get_plans = $this->multi100->get_plans();

        $data = [
            'walletId' => $wallets->data[0]->id,
            'get_customers' => $get_customers,
            'get_plans' => $get_plans,
            'title' => 'Adicionar nova Assinatura'
        ];

        $this->load->view('multi100/subscriptions/create', $data);
    }

    public function update($id = NULL)
    {
        if (!$id) {
            set_alert('danger', 'Não encontrado');
            redirect(admin_url('multi100/subscriptions'), 'refresh');
        }

        $get_config = $this->multi100_model->get_config();

        $split_type = $get_config->multi100_split_type;

        $split_value = $get_config->multi100_split_value;

        $walletId = get_option('multi100_split_wallet');

        if ($this->input->post()) {
            $customer = $this->input->post('customer', TRUE);

            $nextDueDate = $this->input->post('nextDueDate', TRUE);

            $endDate = $this->input->post('endDate', TRUE);

            $split_type = $this->input->post('split_type', TRUE);

            $split_value = $this->input->post('split_value', TRUE);

            $fine = $this->input->post('fine_value', TRUE);

            $interest = $this->input->post('interest_value', TRUE);

            $this->db->where('userid', $customer);
            $client = $this->db->get(db_prefix() . 'clients')->row();

            $this->db->where('userid', $customer);
            $this->db->where('is_primary', 1);
            $primary_contact = $this->db->get(db_prefix() . 'contacts')->row();

            $email = $primary_contact->email;

            $document = str_replace('/', '', str_replace('-', '', str_replace('.', '', $client->vat)));

            $asaas_customer = $this->multi100_gateway->get_customer($document);

            if (!$asaas_customer) {
                $error = $asaas_customer->errors[0]->description;

                set_alert('warning', $error);
                redirect(site_url('multi100/subscriptions/update/' . $id), 'refresh');
            }

            if ($asaas_customer->totalCount == 0) {
                $customer_data = json_encode([
                    "name" => $client->name,
                    "email" => $client->email,
                    "cpfCnpj" => $document,
                    //    "postalCode" => $postalCode,
                    //    "address" => $client->address,
                    //     "addressNumber" => $addressNumber,
                    "phone" => $client->phonenumber,
                    "mobilePhone" => $client->phonenumber,
                    //      "complement" => "",
                    "externalReference" => $client->userid,
                    "notificationDisabled" => false
                ]);

                $create_customer = $this->multi100_gateway->create_customer($customer_data);

                if ($create_customer->error) {
                    $error = $create_customer->errors[0]->description;

                    set_alert('warning', $error);
                    redirect(site_url('multi100/subscriptions/update/' . $id), 'refresh');
                }

                $customer_id = $create_customer->id;
            } else {
                $customer_id = $asaas_customer->data[0]->id;
            }

            if ($split_type == 'fixed') {
                $split = [
                    [
                        "walletId" => $walletId,
                        "fixedValue" => $split_value
                    ]
                ];
            }

            if ($split_type == 'percentual') {
                $split = [
                    [
                        "walletId" => $walletId,
                        "percentualValue" => $split_value
                    ]
                ];
            }

            $maxPayments = get_months_between_dates(date('Y-m-d'), $endDate);

            $post_data = json_encode([
                "customer" => $customer_id,
                "billingType" => $this->input->post('billingType', TRUE),
                "nextDueDate" => $this->input->post('nextDueDate', TRUE),
                //     "dueDate" => $invoice->duedate,
                "value" => $this->input->post('value', TRUE),
                "description" => $this->input->post('description', TRUE),
                "cycle" => $this->input->post('cycle', TRUE),
                "endDate" => $this->input->post('endDate', TRUE),
                "maxPayments" => $maxPayments,
                //   "externalReference" => app_generate_hash(),
                //   "externalReference" => $this->input->post('billingType', TRUE),
                "externalReference" => $client->userid . '-' . $primary_contact->id . '-' . $this->input->post('planId', TRUE),
                "fine" => [
                    "value" => $fine,
                ],
                "interest" => [
                    "value" => $interest,
                ],
                "split" => $split,
                //    "updatePendingPayments" => $updatePendingPayments,
                "postalService" => true
            ]);

            $update_subscription = $this->multi100_gateway->update_subscription($post_data, $id);

            if (!$update_subscription) {

                $error = $update_subscription->errors[0]->description;

                set_alert('warning', $error);
                redirect(site_url('multi100/subscriptions/create'), 'refresh');
            }

            set_alert('success', 'Atualizado');
            redirect(admin_url('multi100/subscriptions'), 'refresh');
        }

        $get_subscription = $this->multi100_gateway->get_subscription($id);

        $get_customers = $this->multi100_gateway->get_customers();

        $get_plans = $this->multi100->get_plans();

        if ($get_subscription->split[0]->fixedValue) {
            $split_type = "fixed";

            $split_value = $get_subscription->split[0]->fixedValue;
        } else {
            $split_type = "percentual";

            $split_value = $get_subscription->split[0]->percentualValue;
        }

        $data = [
            'split_type' => $split_type,
            'split_value' => $split_value,
            //   'get_plan' => $get_plan,
            'get_customers' => $get_customers,
            'get_plans' => $get_plans,
            'get_subscription' => $get_subscription,
            'title' => 'Editar Assinatura'
        ];

        $this->load->view('multi100/subscriptions/update', $data);
    }

    public function delete($id = NULL)
    {
        if (!$id) {
            set_alert('danger', 'Não encontrado');
            redirect(admin_url('multi100/subscriptions'), 'refresh');
        }

        $delete_subscription = $this->multi100_gateway->delete_subscription($id);

        if ($delete_subscription->error) {

            $error = $delete_subscription->error;

            set_alert('danger', $error);
            redirect(admin_url('multi100/subscriptions'), 'refresh');
        }

        set_alert('success', 'Deletado');
        redirect(admin_url('multi100/subscriptions'), 'refresh');
    }
}
