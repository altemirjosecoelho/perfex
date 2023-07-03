<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Callback extends APP_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('multi100_gateway');
        $this->load->library('multi100');
        $this->load->model('multi100_model');
        $this->load->model('invoices_model');

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
        if (strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') == 0) {

            $response = trim(file_get_contents("php://input"));
            // $content = json_decode($response)->body;
            $content = json_decode($response);

            $event = $content->event;
            $payment_id = $content->payment->id;
            $dateCreated = $content->payment->dateCreated;
            $due_date = $content->payment->dueDate;
            $customer = $content->payment->customer;
            $subscription = $content->payment->subscription;
            $status = $content->payment->status;
            $externalReference = $content->payment->externalReference;
            $externalReference = explode("-", $externalReference);

            $client_id = $externalReference[0];
            $contact_id = $externalReference[1];
            $plan_id = $externalReference[2];
            $company_id = $externalReference[3];

            if ($event == "PAYMENT_CREATED") {
                $get_plan = $this->multi100->get_plan($plan_id);

                $this->create_invoice($client_id, $get_plan->amount, $due_date, $payment_id, $get_plan->name);

                $company = $this->multi100->get_company($company_id);

                $dueDate = $company->dueDate ?? null;

                $company_due_date = new DateTime($dueDate);

                $new_due_date = $company_due_date->format('Y-m-d H:i:s');

                $post_data = json_encode([
                    "name" => $company->name,
                    "phone" => $company->phone,
                    "email" => $company->email,
                    "document" => $company->document,
                    "planId" => $company->planId,
                    "partnerId" => $company->partnerId,
                    "dueDate" => $new_due_date
                ]);

                $this->multi100->update_company($company_id, $post_data);

                echo json_encode([
                    'status' => 'success',
                    'message' => 'Pagamento criado com sucesso'
                ]);
            }

            if ($event == "PAYMENT_OVERDUE") {
            }

            // $event == "PAYMENT_CONFIRMED" || $event == "PAYMENT_RECEIVED"

            if ($event == "PAYMENT_RECEIVED") {

                $this->db->where('token', $payment_id);
                $invoice = $this->db->get('tblinvoices')->row();

                if ($invoice) {

                    if ($invoice->status !== "2") {

                        if ($status == "RECEIVED" || $status == "CONFIRMED") {
                        }

                        $this->multi100_gateway->addPayment([
                            'amount' => $invoice->total,
                            'invoiceid' => $invoice->id,
                            'paymentmode' => 'Asaas',
                            'paymentmethod' => $content->payment->billingType,
                            'transactionid' => $content->payment->id,
                        ]);

                        $company = $this->multi100->get_company($company_id);

                        $company_due_date = new DateTime($company->dueDate);

                        switch ($company->recurrence){
                            case "SEMANAL":
                                $cycle = new DateInterval('P7D');
                                break;
                            case "QUINZENAL":
                                $cycle = new DateInterval('P15D');
                                break;
                            case "MENSAL":
                                $cycle = new DateInterval('P30D');
                                break;
                            case "BIMESTRAL":
                                $cycle = new DateInterval('P60D');
                                break;
                            case "TRIMESTRAL":
                                $cycle = new DateInterval('P90D');
                                break;
                            case "SEMESTRAL":
                                $cycle = new DateInterval('P180D');
                                break;
                            case "ANUAL":
                                $cycle = new DateInterval('P365D');
                                break;
                            default:
                                $cycle = new DateInterval('P30D');
                        }

                        $new_due_date = $company_due_date->add($cycle)->format('Y-m-d H:i:s');

                        $post_data = json_encode([
                            "name" => $company->name,
                            "phone" => $company->phone,
                            "email" => $company->email,
                            "document" => $company->document,
                            "dueDate" => $new_due_date,
                            "planId" => $company->planId,
                            "partnerId" => $company->partnerId
                        ]);

                        $this->multi100->update_company($company_id, $post_data);

                        echo json_encode([
                            'status' => 'success',
                            'message' => 'Pagamento recebido com sucesso'
                        ]);
                    }
                }
            }

            if ($event == "PAYMENT_CONFIRMED") {
                $this->db->where('token', $payment_id);
                $invoice = $this->db->get('tblinvoices')->row();

                if ($invoice) {

                    if ($invoice->status !== "2") {

                        if ($status == "RECEIVED" || $status == "CONFIRMED") {
                        }

                        $this->multi100_gateway->addPayment([
                            'amount' => $invoice->total,
                            'invoiceid' => $invoice->id,
                            'paymentmode' => 'Asaas',
                            'paymentmethod' => $content->payment->billingType,
                            'transactionid' => $content->payment->id,
                        ]);

                        $company = $this->multi100->get_company($company_id);

                        $company_due_date = new DateTime($company->dueDate);

                        switch ($company->recurrence){
                            case "SEMANAL":
                                $cycle = new DateInterval('P7D');
                                break;
                            case "QUINZENAL":
                                $cycle = new DateInterval('P15D');
                                break;
                            case "MENSAL":
                                $cycle = new DateInterval('P30D');
                                break;
                            case "BIMESTRAL":
                                $cycle = new DateInterval('P60D');
                                break;
                            case "TRIMESTRAL":
                                $cycle = new DateInterval('P90D');
                                break;
                            case "SEMESTRAL":
                                $cycle = new DateInterval('P180D');
                                break;
                            case "ANUAL":
                                $cycle = new DateInterval('P365D');
                                break;
                            default:
                                $cycle = new DateInterval('P30D');
                        }

                        $new_due_date = $company_due_date->add($cycle)->format('Y-m-d H:i:s');

                        $post_data = json_encode([
                            "name" => $company->name,
                            "phone" => $company->phone,
                            "email" => $company->email,
                            "document" => $company->document,
                            "dueDate" => $new_due_date,
                            "planId" => $company->planId,
                            "partnerId" => $company->partnerId
                        ]);

                        $update_company = $this->multi100->update_company($company_id, $post_data);

                        echo json_encode([
                            'status' => 'success',
                            'message' => 'Pagamento confirmado com sucesso'
                        ]);
                    }
                }
            }

            $this->db->insert(db_prefix() . 'multi100_webhooks', [
                'payment_id' => $payment_id,
                'subscription_id' => $subscription,
                'event' => $event,
                'payload' => $response,
                'created_at' => date('Y-m-d H:i:s')
            ]);

            exit;
        }
    }


    function create_invoice($client_id, $total, $due_date, $payment_id, $description)
    {
        $this->db->where('isdefault', '1');
        $currency = $this->db->get(db_prefix() . 'currencies')->row()->id;

        $invoice_data = [
            'sent' => 1,
            'datesend' => date('Y-m-d H:i:s'),
            'clientid' => $client_id,
            'number' => get_option('next_invoice_number'),
            'prefix' => get_option('invoice_prefix'),
            'number_format' => get_option('invoice_number_format'),
            'datecreated' => date('Y-m-d H:i:s'),
            'date' => date('Y-m-d'),
            'duedate' => $due_date,
            'currency' => $currency,
            'subtotal' => $total,
            'total_tax' => 0,
            'total' => $total,
            'adjustment' => 0,
            'addedfrom' => 0,
            'hash' => app_generate_hash(),
            'status' => "1",
            'clientnote' => "",
            'adminnote' => "",
            'last_due_reminder' => "",
            'cancel_overdue_reminders' => "0",
            'allowed_payment_modes' => [
                'multi100'
            ],
            'token' => $payment_id,
            'discount_percent' => "",
            'discount_total' => 0,
            'discount_type' => "",
            'recurring' => "0",
            'custom_recurring' => 0,
            'cycles' => 0,
            'total_cycles' => 0,
            'terms' => "",
            'billing_street' => '',
            'billing_city' => '',
            'billing_state' => '',
            'billing_zip' => '',
            'billing_country' => "32",
            'shipping_street' => '',
            'shipping_city' => '',
            'shipping_state' => '',
            'shipping_zip' => '',
            'shipping_country' => "32",
            'include_shipping' => 0,
            'show_shipping_on_invoice' => 0,
            'show_quantity_as' => "",
            'project_id' => "",
            'subscription_id' => "",
            'newitems' => [
                "1" => [
                    "order" => "1",
                    "description" => $description,
                    "long_description" => "",
                    "qty" => "1",
                    "unit" => "1",
                    "rate" => $total
                ]
            ],
        ];

        $invoice_id = $this->invoices_model->add($invoice_data);

        return $invoice_id;
    }
}
