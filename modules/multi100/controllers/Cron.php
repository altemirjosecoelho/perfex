<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Cron extends CRM_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('clients_model');
        $this->load->library('multi100');
        $this->load->library('multi100_gateway');
        $this->load->helper('multi100');

        $get_config = $this->multi100_model->get_config();

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
    }

    public function run()
    {
        $get_submissions = $this->db->get(db_prefix() . 'multi100_submissions')->result();

        foreach ($get_submissions as $get_submission) {
            if ($get_submission->is_trial == 1) {
                $submission_payload = json_decode($get_submission->payload);

                $get_plan = $this->multi100->get_plan($submission_payload->fields->plan_id->value);

                if (!$get_plan->error) {
                    $trial_end = $get_submission->created_at . ' + ' . $get_plan->trialDays . 'days';

                    $trial_end_date = date('Y-m-d', strtotime($trial_end));

                    $created_at = date('Y-m-d', strtotime($get_submission->created_at));

                    if ($created_at >= $trial_end_date) {
                        $contact = $this->clients_model->get_contact_by_email($submission_payload->fields->email->value);

                        if (!$contact) {
                            $client = $this->clients_model->get($contact->userid);

                            $document = str_replace('/', '', str_replace('-', '', str_replace('.', '', $client->vat)));

                            $asaas_customer = $this->multi100_gateway->get_customer($document);

                            $customer_id = $asaas_customer->data[0]->id;

                            if ($customer_id) {
                                $post_data = json_encode([
                                    "customer" => $customer_id,
                                    "dateCreated" => date('Y-m-d H:i:s'),
                                    "billingType" => $submission_payload->fields->payment_method->value,
                                    "nextDueDate" => date('Y-m-d', strtotime('+5 day')),
                                    //     "dueDate" => $invoice->duedate,
                                    "value" => $get_plan->price,
                                    "description" => $get_plan->name,
                                    "cycle" => "MONTHLY",
                                    "endDate" => $submission_payload->fields->due_date->value,
                                    // "maxPayments" => $post_data["max_payments"],
                                    "externalReference" => $contact->userid . '-' . $contact->id . '-' . $submission_payload->fields->plan_id->value,
                                    //     "discount" => $discount,
                                    // "fine" => [
                                    //     "value" => $fine,
                                    // ],
                                    // "interest" => [
                                    //     "value" => $interest,
                                    // ],
                                    // "split" => $split,
                                    "postalService" => true
                                ]);

                                $create_subscription = $this->multi100_gateway->create_subscription($post_data);
                            }
                        }
                    }
                }
            }
        }
    }

    public function run_backup()
    {
        $get_submissions = $this->db->get(db_prefix() . 'multi100_submissions')->result();

        foreach ($get_submissions as $get_submission) {
            echo 'istrial<hr>';
            echo $get_submission->is_trial;
            echo '<hr>';

            if ($get_submission->is_trial == 1) {
                $submission_payload = json_decode($get_submission->payload);
                echo 'plan_id<hr>';
                echo $submission_payload->fields->plan_id->value;
                //		  var_dump($submission_payload);
                echo '<hr>';

                $get_plan = $this->multi100->get_plan($submission_payload->fields->plan_id->value);

                echo 'get_plan<hr>';
                var_dump($get_plan);
                echo '<hr>';
                if (!$get_plan->error) {

                    echo 'created_at<hr>';
                    echo $get_submission->created_at;
                    echo '<hr>';
                    echo 'trialDays<hr>';
                    echo $get_plan->trialDays;
                    echo '<hr>';
                    echo 'plan_id<hr>';
                    echo $get_plan->id;
                    echo '<hr>';

                    $trial_end = $get_submission->created_at . ' + ' . $get_plan->trialDays . 'days';

                    echo 'trial_end_date<hr>';
                    $trial_end_date = date('Y-m-d', strtotime($trial_end));
                    echo $trial_end_date;
                    echo '<hr>';
                    echo 'created_at<hr>';

                    $created_at = date('Y-m-d', strtotime($get_submission->created_at));
                    echo $created_at;
                    echo '<hr>';
                    echo 'trial_end_date original<hr>';
                    var_dump(($created_at >= $trial_end_date));
                    echo '<hr>';
                    echo 'created_at fake<hr>';
                    $created_at = date('Y-m-d', strtotime('2023-02-22'));
                    echo $created_at;
                    echo '<hr>';
                    echo 'trial_end_date fake<hr>';
                    var_dump(($created_at >= $trial_end_date));
                    echo '<hr>';
                    echo 'time<hr>';
                    echo time();
                    echo '<hr>';
                    echo 'strtotime<hr>';
                    echo strtotime($trial_end);

                    echo '<hr>';
                    echo 'trial_end<hr>';
                    echo time() - strtotime($trial_end);

                    echo '<hr>';
                    echo 'trial_end<hr>';
                    echo (int)time() - strtotime($trial_end);

                    echo '<hr>';
                }
            }
        }
    }
}
