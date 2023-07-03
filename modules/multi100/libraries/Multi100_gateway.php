<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Multi100_gateway extends App_gateway
{
    private $api_url;
    private $api_key;

    public function __construct()
    {
        parent::__construct();
        $this->setId('multi100');
        $this->setName('Asaas subscription');
        $this->setSettings(array(
            array(
                'name' => 'api_key',
                'encrypted' => true,
                'label' => 'Api key Produção',
                'type' => 'input',
            ),
            array(
                'name' => 'api_key_sandbox',
                'encrypted' => true,
                'label' => 'Api key Sandbox',
                'type' => 'input',
            ),
            array(
                'name' => 'sandbox',
                'label' => 'Sandbox',
                'type' => 'yes_no',
                'default_value' => 0,
            ),
            array(
                'name' => 'currencies',
                'label' => 'settings_paymentmethod_currencies',
                'default_value' => 'BRL'
            ),
            array(
                'name' => 'description',
                'label' => 'settings_paymentmethod_description',
                'type' => 'textarea',
                'default_value' => 'Pagamento da Fatura {invoice_number}',
            ),
            array(
                'name' => 'interest_value',
                'label' => 'Valor juros',
                'type' => 'input',
                'default_value' => '0.00',
            ),
            array(
                'name' => 'fine_value',
                'label' => 'Valor multa',
                'type' => 'input',
                'default_value' => '0.00',
            ),
            array(
                'name' => 'billet_only',
                'label' => 'Habilitar boleto',
                'type' => 'yes_no',
                'default_value' => 1,
            ),
            array(
                'name' => 'card_only',
                'label' => 'Habilitar cartão de crédito',
                'type' => 'yes_no',
                'default_value' => 1,
            ),
            array(
                'name' => 'pix_only',
                'label' => 'Habilitar PIX',
                'type' => 'yes_no',
                'default_value' => 1,
            )
        ));
    }

    public function setCreds($api_url, $api_key)
    {
        $this->api_url = $api_url;
        $this->api_key = $api_key;
    }

    public function process_payment($data)
    {
        if (empty($data)) {
            return;
        }

        $invoice_id = $data['invoice']->id;

        $CI = &get_instance();

        $CI->db->where('id', $invoice_id);
        $invoice = $CI->db->get(db_prefix() . 'invoices')->row();

        redirect(site_url('multi100/checkout/index/' . $invoice->id . '/' . $invoice->hash), 'refresh');
    }

    public function charge_billet($hash)
    {
        $CI = &get_instance();

        $CI->db->where('hash', $hash);
        $invoice = $CI->db->get(db_prefix() . 'invoices')->row();

        $CI->db->where('userid', $invoice->clientid);
        $client = $CI->db->get(db_prefix() . 'clients')->row();

        $CI->db->where('userid', $invoice->clientid);
        $CI->db->where('is_primary', 1);
        $primary_contact = $CI->db->get(db_prefix() . 'contacts')->row();

        $description = $this->getSetting('description');

        $fine = $this->getSetting('fine_value');

        $interest = $this->getSetting('interest_value');

        $addressNumber = "30";

        $document = str_replace('/', '', str_replace('-', '', str_replace('.', '', $client->vat)));
        $postalCode = str_replace('-', '', str_replace('.', '', $client->zip));


        if (empty($document)) {
            exit;
        }
        $customer = $this->get_customer($document);

        if ($customer->totalCount == 0) {
            $post_data = json_encode([
                "name" => $client->company,
                "email" => $primary_contact->email,
                "cpfCnpj" => $document,
                "postalCode" => $postalCode,
                "address" => $client->address,
                "addressNumber" => $addressNumber,
                "phone" => $client->phonenumber,
                "mobilePhone" => $client->phonenumber,
                "complement" => "",
                "externalReference" => $client->userid,
                "notificationDisabled" => false
            ]);

            $create_customer = $this->create_customer($post_data);

            if ($create_customer->error) {

                return $create_customer;
            }

            $customer_id = $customer->id;
        } else {

            $customer_id = $customer->data[0]->id;
        }

        $invoice_number = $invoice->prefix . str_pad($invoice->number, 6, "0", STR_PAD_LEFT);
        $description = utf8_encode(str_replace("{invoice_number}", $invoice_number, $description));

        $post_data = json_encode([
            "customer" => $customer_id,
            "billingType" => "BOLETO",
            "nextDueDate" => date('Y-m-d', strtotime('+90 day')),
            //     "dueDate" => $invoice->duedate,
            "value" => $invoice->total,
            "description" => $description,
            "cycle" => "MONTHLY",
            //  "endDate" => date('Y-m-d', strtotime('+90 day')),
            // "maxPayments" => $maxPayments,

            "externalReference" => $invoice->hash,
            //     "discount" => $discount,
            "fine" => [
                "value" => $fine,
            ],
            "interest" => [
                "value" => $interest,
            ],

            "postalService" => true
        ]);

        $create_subscription = $this->create_subscription($post_data);

        return $create_subscription;
    }

    public function charge_credit_card($hash, $data)
    {
        $CI = &get_instance();

        $CI->db->where('hash', $hash);
        $invoice = $CI->db->get(db_prefix() . 'invoices')->row();

        $CI->db->where('userid', $invoice->clientid);
        $client = $CI->db->get(db_prefix() . 'clients')->row();

        $CI->db->where('userid', $invoice->clientid);
        $CI->db->where('is_primary', 1);
        $primary_contact = $CI->db->get(db_prefix() . 'contacts')->row();

        $description = $this->getSetting('description');

        $fine = $this->getSetting('fine_value');

        $interest = $this->getSetting('interest_value');

        $addressNumber = "30";

        $document = str_replace('/', '', str_replace('-', '', str_replace('.', '', $client->vat)));
        $postalCode = str_replace('-', '', str_replace('.', '', $client->zip));


        if (empty($document)) {
            exit;
        }
        $customer = $this->get_customer($document);

        if ($customer->totalCount == 0) {
            $post_data = json_encode([
                "name" => $client->company,
                "email" => $primary_contact->email,
                "cpfCnpj" => $document,
                "postalCode" => $postalCode,
                "address" => $client->address,
                "addressNumber" => $addressNumber,
                "phone" => $client->phonenumber,
                "mobilePhone" => $client->phonenumber,
                "complement" => "",
                "externalReference" => $client->userid,
                "notificationDisabled" => false
            ]);

            $create_customer = $this->create_customer($post_data);

            if ($create_customer->error) {

                return $create_customer;
            }

            $customer_id = $customer->id;
        } else {

            $customer_id = $customer->data[0]->id;
        }

        $invoice_number = $invoice->prefix . str_pad($invoice->number, 6, "0", STR_PAD_LEFT);
        $description = utf8_encode(str_replace("{invoice_number}", $invoice_number, $description));

        $post_data = json_encode([
            "customer" => $customer_id,
            "billingType" => "CREDIT_CARD",
            "nextDueDate" => date('Y-m-d', strtotime('+1 day')),
            "value" => $invoice->total,
            "cycle" => "MONTHLY",
            "description" => $description,
            "creditCard" => [
                "holderName" => $data["card"]["holderName"],
                "number" => $data["card"]["number"],
                "expiryMonth" => $data["card"]["expiryMonth"],
                "expiryYear" => $data["card"]["expiryYear"],
                "ccv" => $data["card"]["cvv"]
            ],
            "creditCardHolderInfo" => [
                "name" => $client->company,
                "email" => $primary_contact->email,
                "cpfCnpj" => $document,
                "postalCode" => $postalCode,
                "addressNumber" => $addressNumber,
                "addressComplement" => "",
                "phone" => $client->phonenumber,
                "mobilePhone" => $client->phonenumber
            ],
            "externalReference" => $invoice->hash,
            "fine" => [
                "value" => $fine,
            ],
            "interest" => [
                "value" => $interest,
            ],

            "postalService" => true
        ]);

        $create_subscription = $this->create_subscription($post_data);

        return $create_subscription;
    }

    public function charge_pix($hash)
    {

        $CI = &get_instance();

        // $CI->db->where('id', $invoiceId);
        $CI->db->where('hash', $hash);
        $invoice = $CI->db->get(db_prefix() . 'invoices')->row();

        $CI->db->where('userid', $invoice->clientid);
        $client = $CI->db->get(db_prefix() . 'clients')->row();

        $CI->db->where('userid', $invoice->clientid);
        $CI->db->where('is_primary', 1);
        $primary_contact = $CI->db->get(db_prefix() . 'contacts')->row();

        $description = $this->getSetting('description');

        $fine = $this->getSetting('fine_value');

        $interest = $this->getSetting('interest_value');

        $invoice->total_left_to_pay = get_invoice_total_left_to_pay($invoice->id, $invoice->total);

        $addressNumber = "30";

        $document = str_replace('/', '', str_replace('-', '', str_replace('.', '', $client->vat)));
        $postalCode = str_replace('-', '', str_replace('.', '', $client->zip));


        if (empty($document)) {
        }

        $customer = $this->get_customer($document);

        if ($customer->totalCount == 0) {

            $post_data = json_encode([
                "name" => $client->company,
                "email" => $primary_contact->email,
                "cpfCnpj" => $document,
                "postalCode" => $postalCode,
                "address" => $client->address,
                "addressNumber" => $addressNumber,
                "phone" => $client->phonenumber,
                "mobilePhone" => $client->phonenumber,
                "complement" => "",
                "externalReference" => $client->userid,
                "notificationDisabled" => false
            ]);

            $create_customer = $this->create_customer($post_data);

            if ($create_customer->error) {

                return $create_customer;
            }

            $customer_id = $customer->id;
        } else {

            $customer_id = $customer->data[0]->id;
        }

        $invoice_number = $invoice->prefix . str_pad($invoice->number, 6, "0", STR_PAD_LEFT);
        $description = utf8_encode(str_replace("{invoice_number}", $invoice_number, $description));

        $post_data = json_encode([
            "customer" => $customer_id,
            "billingType" => "PIX",
            "nextDueDate" => date('Y-m-d', strtotime('+1 day')),
            "value" => $invoice->total,
            "description" => $description,
            "cycle" => "MONTHLY",
            "externalReference" => $invoice->hash,
            "fine" => [
                "value" => $fine,
            ],
            "interest" => [
                "value" => $interest,
            ],

            "postalService" => true
        ]);

        $create_subscription = $this->create_subscription($post_data);

        return $create_subscription;
    }

    public function get_customers()
    {
        $url = $this->api_url . "/api/v3/customers";
        $token = $this->api_key;
        $response = $this->send_request('GET', $url, $token);

        return $response;
    }

    public function get_customer($document)
    {
        $url = $this->api_url . "/api/v3/customers?cpfCnpj=" . $document;
        $token = $this->api_key;
        $response = $this->send_request('GET', $url, $token);

        return $response;
    }

    public function get_customer_by_id($id)
    {
        $url = $this->api_url . "/api/v3/customers/" . $id;
        $token = $this->api_key;
        $response = $this->send_request('GET', $url, $token);

        return $response;
    }

    public function create_customer($post_data)
    {
        $url = $this->api_url . "/api/v3/customers";
        $token = $this->api_key;
        $response = $this->send_request('POST', $url, $token, $post_data);

        return $response;
    }

    public function delete_customer($id)
    {
        $url = $this->api_url . "/api/v3/customers/" . $id;
        $token = $this->api_key;
        $response = $this->send_request('DELETE', $url, $token);

        return $response;
    }

    public function get_subscriptions($offset, $limit, $customer = null)
    {
        $url = $this->api_url . '/api/v3/subscriptions?offset=' . $offset . '&limit=' . $limit;

        if ($customer) {
            $url = $url . '&customer=' . $customer;
        }

        $token = $this->api_key;
        $response = $this->send_request('GET', $url, $token);

        return $response;
    }

    public function get_subscription($id)
    {
        $url = $this->api_url . '/api/v3/subscriptions/' . $id;
        $token = $this->api_key;
        $response = $this->send_request('GET', $url, $token);

        return $response;
    }

    public function get_subscription_payments($id)
    {
        $url = $this->api_url . "/api/v3/subscriptions/{$id}/payments";
        $token = $this->api_key;
        $response = $this->send_request('GET', $url, $token);

        return $response;
    }

    public function create_subscription($post_data)
    {
        $url = $this->api_url . "/api/v3/subscriptions";
        $token = $this->api_key;
        $response = $this->send_request('POST', $url, $token, $post_data);

        return $response;
    }

    public function update_subscription($post_data, $id)
    {
        $url = $this->api_url . "/api/v3/subscriptions" . $id;
        $token = $this->api_key;
        $response = $this->send_request('POST', $url, $token, $post_data);

        return $response;
    }

    public function delete_subscription($id)
    {
        $url = $this->api_url . "/api/v3/subscriptions/" . $id;
        $token = $this->api_key;
        $response = $this->send_request('DELETE', $url, $token);

        return $response;
    }

    public function get_charges($offset, $limit)
    {
        $url = $this->api_url . '/api/v3/payments?offset=' . $offset . '&limit=' . $limit;
        $token = $this->api_key;
        $response = $this->send_request('GET', $url, $token);

        return $response;
    }

    public function get_charge($hash)
    {
        $url = $this->api_url . "/api/v3/payments";
        $token = $this->api_key;
        $response = $this->send_request('GET', $url, $token);
        $charges = $response->data;
        if ($charges) {
            foreach ($charges as $charge) {
                if ($charge->externalReference == $hash) {
                    return $charge;
                }
            }
        }
    }

    public function wallets()
    {
        $url = $this->api_url . "/api/v3/wallets";
        $token = $this->api_key;
        $response = $this->send_request('GET', $url, $token);

        return $response;
    }

    public function get_customer_customfields($id, $fieldto, $slug)
    {
        $ci = &get_instance();
        $ci->db->where('fieldto', $fieldto);
        $ci->db->where('slug', $slug);
        $customfields = $ci->db->get(db_prefix() . 'customfields')->result();
        foreach ($customfields as $row) {
            $ci->db->where('fieldto', $fieldto);
            $ci->db->where('relid', $id);
            $ci->db->where('fieldid', $row->id);
            $customfieldsvalues = $ci->db->get(db_prefix() . 'customfieldsvalues')->row();
        }
        if (isset($customfieldsvalues)) {
            return $customfieldsvalues->value;
        } else {
            return NULL;
        }
    }

    protected function send_request($method, $url, $token = null, $data = null)
    {
        try {
            $client = new \GuzzleHttp\Client();

            if ($data) {
                $headers['Content-Type'] = 'application/json';
            }

            if ($token) {
                $headers['access_token'] = $token;
            }

            $response = $client->request($method, $url, [
                'headers' => $headers,
                'body' => $data
            ]);

            $response = $response->getBody()->getContents();

            return json_decode($response);
        } catch (Exception $e) {
            return [
                'error' => $e->getMessage()
            ];
        }
    }
}
