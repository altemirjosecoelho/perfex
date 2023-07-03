<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Leads extends APP_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('leads_model');
        $this->load->model('clients_model');
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
    }

    public function register()
    {
        if (strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') == 0) {
            $data = json_decode(file_get_contents('php://input'));

            $partnerId = $data->partnerId ?? null;
            $planId = $data->planId;
            $name = $data->name;
            $phone = $data->phone;
            $email = $data->email;
            $document = $data->document;
            $password = $data->password ?? null;
            $payment_method = $data->payment_method ?? "UNDEFINED";

            $get_config = $this->multi100_model->get_config();

            $plan = $this->multi100->get_plan($planId);

            $return = [];

            // VERIFICA SE O PLANO É TESTE GRATIS
            if ($plan->trial) {
                $trial_days = $plan->trialDays;
                $today = new DateTime();
                $trial_end_date = $today->add(new DateInterval('P' . $trial_days . 'D'));

                $due_date = $trial_end_date->format('Y-m-d H:i:s');
            } else {
                $today = new DateTime();
                $due_date = $today->format('Y-m-d H:i:s');
            }

            $recurrence = $plan->recurrence;

            switch ($recurrence) {
                case 'SEMANAL' || 'WEEKLY':
                    $recurrence = "WEEKLY";
                    break;
                case 'QUIZENAL' || 'BIWEEKLY':
                    $recurrence = "BIWEEKLY";
                    break;
                case 'MENSAL' || 'MONTHLY':
                    $recurrence = "MONTHLY";
                    break;
                case 'TRIMESTRAL' || 'QUARTERLY':
                    $recurrence = "QUARTERLY";
                    break;
                case 'SEMESTRAL' || 'SEMIANNUALLY':
                    $recurrence = "SEMIANNUALLY";
                    break;
                case 'ANUAL' || 'ANNUALLY':
                    $recurrence = "YEARLY";
                    break;
                default:
                    $recurrence = "MONTHLY";
                    break;
            }

            // CRIA FORMULARIO
            $this->db->insert(db_prefix() . 'multi100_submissions', [
                'form_id' => null,
                'form_name' => 'cadastro sistema - Empresa: ' . $name,
                'payload' => json_encode($data),
                'created_at' => date('Y-m-d H:i:s')
            ]);
            $submission_id = $this->db->insert_id();

            // VERIFICA SE PLANO ESTA OK
            $this->db->where('id', $submission_id);
            $this->db->update(db_prefix() . 'multi100_submissions', ['multi100_plan' => 1, 'multi100_plan_payload' => json_encode($plan)]);

            $return['plan'] = ['multi100_plan' => 1, 'multi100_plan_payload' => json_encode($plan)];

            if (!$plan) {
                $this->db->where('id', $submission_id);
                $this->db->update(db_prefix() . 'multi100_submissions', ['multi100_plan' => 0, 'multi100_plan_payload' => json_encode($plan)]);
                $return['plan'] = ['multi100_plan' => 0, 'multi100_plan_payload' => json_encode($plan)];
            }

            // CRIA LEAD
            $lead_data = [
                'name' => $name,
                'title' => '',
                'description' => '',
                'country' => "32",
                'zip' => "",
                'city' => "",
                'state' => "",
                'address' => "",
                'assigned' => $get_config->elementor_api_assigned,
                'status' => "1",
                'source' => $get_config->elementor_api_source,
                'lastcontact' => date('Y-m-d'),
                'dateassigned' => date('Y-m-d'),
                'last_status_change' => '',
                'addedfrom' => '',
                'email' => $email,
                'website' => '',
                'leadorder' => "0",
                'phonenumber' => $phone,
                'date_converted' => date('Y-m-d'),
                'lost' => "0",
                'junk' => "0",
                'last_lead_status' => "",
                'is_imported_from_email_integration' => "0",
                'email_integration_uid' => "",
                'is_public' => "0",
            ];
            $lead_id = $this->create_lead($lead_data);

            $this->db->where('id', $submission_id);
            $this->db->update(db_prefix() . 'multi100_submissions', ['perfex_lead' => 1, 'perfex_lead_id' => $lead_id]);

            $return['lead'] = ['perfex_lead' => 1, 'perfex_lead_id' => $lead_id];

            if (!$lead_id) {
                $this->db->where('id', $submission_id);
                $this->db->update(db_prefix() . 'multi100_submissions', ['perfex_lead' => 0, 'perfex_lead_id' => NULL]);

                $return['lead'] = ['perfex_lead' => 0, 'perfex_lead_id' => NULL];
            }

            // VERIFICA SE É TRIAL
            $this->db->where('id', $submission_id);
            $this->db->update(db_prefix() . 'multi100_submissions', ['is_trial' => $plan->trial]);

            $return['trial'] = ['is_trial' => $plan->trial];

            // CRIA CLIENTE PERFEX
            $client_data = [
                'company' => $name,
                'vat' => str_replace(['/', '-', '.'], '', $document),
                'phonenumber' => $phone,
                'lead_id' => $lead_id
            ];

            $client_id = $this->create_client($client_data);

            $this->db->where('id', $submission_id);
            $this->db->update(db_prefix() . 'multi100_submissions', ['perfex_client' => 1, 'perfex_client_id' => $client_id]);

            $return['client'] = ['perfex_client' => 1, 'perfex_client_id' => $client_id];

            if (!$client_id) {
                $this->db->where('id', $submission_id);
                $this->db->update(db_prefix() . 'multi100_submissions', ['perfex_client' => 0, 'perfex_client_id' => NULL]);

                $return['client'] = ['perfex_client' => 0, 'perfex_client_id' => NULL];
            }

            // CRIA CONTATO PERFEX
            $contact_data = [
                'userid' => $client_id,
                'is_primary' => 1,
                'firstname' => $name,
                'lastname' => "",
                'email' => $email,
                'phonenumber' => $phone,
                'datecreated' => date('Y-m-d H:i:s'),
                'active' => 1,
                'send_set_password_email' => 1,
            ];

            $contact_id = $this->create_contact($contact_data);

            $this->db->where('id', $submission_id);
            $this->db->update(db_prefix() . 'multi100_submissions', ['perfex_contact' => 1, 'perfex_contact_id' => $contact_id]);

            $return['contact'] = ['perfex_contact' => 1, 'perfex_contact_id' => $contact_id];

            if (!$contact_id) {
                $this->db->where('id', $submission_id);
                $this->db->update(db_prefix() . 'multi100_submissions', ['perfex_contact' => 0, 'perfex_contact_id' => NULL]);

                $return['contact'] = ['perfex_contact' => 0, 'perfex_contact_id' => NULL];
            }

            // CRIA CLIENTE MULTI100
            $company_data = json_encode([
                'name' => $name,
                'phone' => $phone,
                'email' => $email,
                'document' => str_replace('/', '', str_replace('-', '', str_replace('.', '', $document))),
                'dueDate' => date('Y-m-d H:i:s'),
                'recurrence' => $plan->recurrence,
                'planId' => $plan->id,
                'partnerId' => $partnerId,
                'password' => $password
            ]);

            $create_company = $this->multi100->create_company($company_data);

            $company_id = $create_company->id;

            // AJUSTE DOCUMENT PARA ASAAS
            $document = str_replace('/', '', str_replace('-', '', str_replace('.', '', $document)));

            // AJUSTE PHONE PARA ASAAS
            $phone = str_replace(['(', ')', '-', ' '], '', $phone);
            if (strlen($phone) > 11) {
                $phone = substr($phone, 2);
            }

            // PROCURA CLIENTE DO ASAAS
            $asaas_customer = $this->multi100_gateway->get_customer($document);

            if (!$asaas_customer) {
                $this->db->where('id', $submission_id);
                $this->db->update(db_prefix() . 'multi100_submissions', ['asaas_customer' => 0, 'asaas_customer_id' => NULL]);

                $return['asaas_customer'] = ['asaas_customer' => 0, 'asaas_customer_id' => NULL];
            }

            // SE NAO EXISTIR CRIA CLIENTE ASAAS
            if ($asaas_customer->totalCount == 0) {
                $customer_data = json_encode([
                    "name" => $name,
                    "email" => $email,
                    "cpfCnpj" => $document,
                    "phone" => $phone,
                    "mobilePhone" => $phone,
                    "externalReference" => $company_id,
                    "notificationDisabled" => false
                ]);

                $create_customer = $this->multi100_gateway->create_customer($customer_data);

                $this->db->where('id', $submission_id);
                $this->db->update(db_prefix() . 'multi100_submissions', ['asaas_customer_payload' => json_encode($create_customer)]);

                $return['asaas_customer'] = ['asaas_customer_payload' => json_encode($create_customer)];

                if (is_array($create_customer) && !empty($create_customer['errors'])) {
                    $customer_id = null;
                } else {
                    $customer_id = $create_customer->id;
                }
            } else {
                $this->db->where('id', $submission_id);
                $this->db->update(db_prefix() . 'multi100_submissions', ['asaas_customer_payload' => json_encode($asaas_customer)]);

                $return['asaas_customer'] = ['asaas_customer_payload' => json_encode($asaas_customer)];

                $customer_id = $asaas_customer->data[0]->id;
            }

            // PUXA DADOS DO PARCEIRO
            $get_partner = $this->multi100->get_partner($partnerId);

            $this->db->where('id', $submission_id);
            $this->db->update(db_prefix() . 'multi100_submissions', ['asaas_customer' => 1, 'asaas_customer_id' => $customer_id]);

            $return['asaas_customer'] = ['asaas_customer' => 1, 'asaas_customer_id' => $customer_id];

            if (!$customer_id) {
                $this->db->where('id', $submission_id);
                $this->db->update(db_prefix() . 'multi100_submissions', ['asaas_customer' => 0, 'asaas_customer_id' => NULL]);

                $return['asaas_customer'] = ['asaas_customer' => 0, 'asaas_customer_id' => NULL];
            }

            // CRIA ASSINATURA NO ASAAS
            $subscription_data = [
                "plan_id" => $plan->id,
                'userid' => $client_id,
                "contact_id" => $contact_id,
                "company_id" => $company_id,
                "customer" => $customer_id,
                'document' => str_replace('/', '', str_replace('-', '', str_replace('.', '', $document))),
                "value" => $plan->amount,
                "description" => $plan->name,
                "cycle" => $recurrence,
                "end_date" => $due_date,
                'payment_method' => $payment_method,
                "walletId" => $get_partner->walletId ?? null,
                "typeSplit" => $get_partner->typeCommission ?? null,
                "commission" => $get_partner->commission ?? null,
            ];

            $create_subscription = $this->create_subscription($subscription_data);

            if (is_array($create_subscription) && !empty($create_subscription['errors'])) {
                $subscription_id = null;
            } else {
                $subscription_id = $create_subscription->id;
            }

            if (!$subscription_id) {
                $this->db->where('id', $submission_id);
                $this->db->update(db_prefix() . 'multi100_submissions', ['asaas_subscription' => 0, 'asaas_subscription_id' => NULL]);

                $return['asaas_subscription'] = ['asaas_subscription' => 0, 'asaas_subscription_id' => NULL];
            } else {
                $this->db->where('id', $submission_id);
                $this->db->update(db_prefix() . 'multi100_submissions', ['asaas_subscription' => 1, 'asaas_subscription_id' => $subscription_id]);

                $return['asaas_subscription'] = ['asaas_subscription' => 1, 'asaas_subscription_id' => $subscription_id];
            }

            $this->db->where('id', $submission_id);
            $this->db->update(db_prefix() . 'multi100_submissions', ['asaas_subscription_payload' => json_encode($create_subscription)]);

            $return['asaas_subscription_payload'] = ['asaas_subscription_payload' => json_encode($create_subscription)];

            // VALIDA CLIENTE MULTI100
            $this->db->where('id', $submission_id);
            $this->db->update(db_prefix() . 'multi100_submissions', ['multi100_client' => 1, 'multi100_client_id' => $company_id]);

            $return['multi100_client'] = ['multi100_client' => 1, 'multi100_client_id' => $company_id];

            if (!$create_company || is_array($create_company) && isset($create_company['error'])) {
                $this->db->where('id', $submission_id);
                $this->db->update(db_prefix() . 'multi100_submissions', ['multi100_client' => 0, 'multi100_client_id' => NULL, 'multi100_client_payload' => json_encode($create_company)]);

                $return['multi100_client'] = ['multi100_client' => 0, 'multi100_client_id' => NULL, 'multi100_client_payload' => json_encode($create_company)];
            }

            $this->db->where('id', $submission_id);
            $this->db->update(db_prefix() . 'multi100_submissions', ['multi100_client_payload' => json_encode($create_company)]);

            $return['multi100_client_payload'] = ['multi100_client_payload' => json_encode($create_company)];

            $data = array('success' => true, 'data' => $return);
            $json = json_encode($data);
            header('Content-Type: application/json');
            echo $json;
        }
    }

    function create_lead($post_data)
    {
        $data = [
            'hash' => '',
            'name' => $post_data["name"],
            'title' => '',
            'description' => '',
            'country' => '32',
            'zip' => str_replace('-', '', str_replace('.', '', $post_data["zip"])),
            'city' => $post_data["city"],
            'state' => $post_data["state"],
            'address' => $post_data["address"],
            'assigned' => $post_data["assigned"],
            'dateadded' => date('Y-m-d'),
            'from_form_id' => '0',
            'status' => '2',
            'source' => $post_data["source"],
            'lastcontact' => date('Y-m-d'),
            'dateassigned' => date('Y-m-d'),
            'last_status_change' => '',
            'addedfrom' => '',
            'email' => $post_data["email"],
            'website' => '',
            'leadorder' => '0',
            'phonenumber' => $post_data["phonenumber"],
            'date_converted' => date('Y-m-d'),
            'lost' => '0',
            'junk' => '0',
            'last_lead_status' => '',
            'is_imported_from_email_integration' => '0',
            'email_integration_uid' => '',
            'is_public' => "0",
            'default_language' => '',
            'client_id' => "",
            'lead_value' => '',
        ];
        $this->db->where('email', $post_data["email"]);
        $lead = $this->db->get(db_prefix() . 'leads')->row();
        if (!$lead) {
            $lead_id = $this->leads_model->add($data);
        } else {
            $lead_id = $lead->id;
        }
        return $lead_id;
    }

    function create_contact($contact_data)
    {
        $contact = $this->clients_model->get_contact_by_email($contact_data["email"]);
        if (!$contact) {
            $contact_id = $this->clients_model->add_contact($contact_data, $contact_data["userid"], true);
        } else {
            $contact_id = $contact->userid;
        }
        return $contact_id;
    }

    function create_client($post_data)
    {
        // helper?
        // retorna moeda BRL
        $this->db->where('name', 'BRL');
        $currency = $this->db->get(db_prefix() . 'currencies')->row()->id;
        $data = [
            'company' => $post_data["company"],
            'vat' => $post_data["vat"],
            'phonenumber' => $post_data["phonenumber"],
            'country' => "32",
            'city' => '',
            'zip' => '',
            'state' => '',
            'address' => '',
            'website' => "",
            'datecreated' => date('Y-m-d H:i:s'),
            'active' => 1,
            'leadid' => $post_data["lead_id"],
            'default_currency' => $currency,
            'show_primary_contact' => 1,
            'stripe_id' => "",
            'registration_confirmed' => 1,
            'addedfrom' => 0,
        ];

        $this->db->where('vat', str_replace('/', '', str_replace('-', '', str_replace('.', '', $post_data["vat"]))));
        $client = $this->db->get(db_prefix() . 'clients')->row();
        if (!$client) {
            $clientid = $this->clients_model->add($data);
        } else {
            $clientid = $client->userid;
        }
        return $clientid;
    }

    function create_subscription($post_data)
    {
        $data = [
            "customer" => $post_data["customer"],
            "dateCreated" => date('Y-m-d H:i:s'),
            "billingType" => $post_data["payment_method"],
            "nextDueDate" => $post_data["end_date"],
            "value" => $post_data["value"],
            "description" => $post_data["description"],
            "cycle" => $post_data["cycle"],
            "endDate" => $post_data["end_date"],
            "externalReference" => $post_data["userid"] . '-' . $post_data["contact_id"] . '-' . $post_data["plan_id"] . '-' . $post_data["company_id"],
            "postalService" => true,
        ];

        if (isset($post_data["walletId"]) && $post_data["walletId"] != null) {
            if ($post_data["typeSplit"] == "fixedValue") {
                $data["split"] = [
                    "fixedValue" => $post_data["commission"],
                    "walletId" => $post_data["walletId"]
                ];
            } else {
                $data["split"] = [
                    "percentualValue" => $post_data["commission"],
                    "walletId" => $post_data["walletId"]
                ];
            }
        }

        $create_subscription = $this->multi100_gateway->create_subscription(json_encode($data));
        return $create_subscription;
    }
}
