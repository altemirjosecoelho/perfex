<?php


function get_payment_status_name($status)
{
    $CI = &get_instance();
    if ($status == 'ACTIVE') {
        return "<span class=\"label label-success\">Pago</span>";
    }
    if ($status == 'PENDING') {
        //  return "<span class=\"label label-warning\">Não pago</span>";
        return "<span class=\"label label-warning\">Aguardando pagamento</span>";
    }


    if ($status == 'OVERDUE') {
        return "<span class=\"label label-danger\">Atrasado</span>";
    }

    return $status;
}


function check_number($phonenumber)
{
    $number_size = strlen($phonenumber);

    if ($number_size == '11') {

        $number_prefix = substr($phonenumber, 0, 2);

        if ($number_prefix > '30') {

            $number_nine = substr($phonenumber, 2, 1);

            if ($number_nine == '9') {

                $phonenumber = substr($phonenumber, 3);

                return $number_prefix . $phonenumber;
            }
        } else {

            return $phonenumber;
        }
    }
}

function get_months_between_dates($date1, $date2)
{

    $date1 = date('Y-m-d');
    $date2 = '2025-02-20';

    $ts1 = strtotime($date1);
    $ts2 = strtotime($date2);

    $year1 = date('Y', $ts1);
    $year2 = date('Y', $ts2);

    $month1 = date('m', $ts1);
    $month2 = date('m', $ts2);

    $diff = (($year2 - $year1) * 12) + ($month2 - $month1);
    var_dump($diff);
    echo "<hr>";
    die();
}

function prx($array, $is_not_die = false)
{
    echo '<pre>';
    print_r($array);
    echo '</pre>';

    $is_not_die ? '' : die;
}

function get_payment_method($method)
{
    $CI = &get_instance();

    if ($method == 'BOLETO') {

        return "<div class=\"text-center\"><span class=\"label label-default\"><i class=\"fa fa-barcode fa-3x\"></i></span></div>";
    } else if ($method == 'CREDIT_CARD') {

        return "<div class=\"text-center\"> <span class=\"label label-default\"><i class=\"fa fa-credit-card fa-3x\"></i></span></div>";
    } else if ($method == 'PIX') {

        return "<div class=\"text-center\"> <span class=\"label label-default\"><i class=\"fa fa-qrcode fa-3x\"></i></span></div>";
    } else {
        return $method;
    }
}

function get_conditional_name($status)
{
    $CI = &get_instance();
    if ($status == '1') {
        return "<span class=\"label label-default\">Sim</span>";
    }

    if ($status == '0') {
        return "<span class=\"label label-default\">Não</span>";
    }
}

function get_status_name($status)
{
    $CI = &get_instance();
    if ($status == 'ACTIVE') {
        return "<span class=\"label label-success\">Ativo</span>";
    }
    if ($status == 'CANCELLED') {
        return "<span class=\"label label-warning\">Expirado</span>";
    }
    if ($status == 'EXPIRED') {
        return "<span class=\"label label-danger\">Cancelado</span>";
    }
}

function get_cycle_name($cycle)
{
    $CI = &get_instance();
    if ($cycle == 'WEEKLY') {
        return "<span class=\"label label-default\">Semanal</span>";
    }
    if ($cycle == 'BIWEEKLY') {
        return "<span class=\"label label-default\">Quinzenal</span>";
    }
    if ($cycle == 'MONTHLY') {
        return "<span class=\"label label-default\">Mensal</span>";
    }
    if ($cycle == 'QUARTERLY') {
        return "<span class=\"label label-default\">Trimestral</span>";
    }
    if ($cycle == 'SEMIANNUALLY') {
        return "<span class=\"label label-default\">Semestral</span>";
    }
    if ($cycle == 'YEARLY') {
        return "<span class=\"label label-default\">Anual</span>";
    }
}

function check_multi100_config()
{
    $CI = &get_instance();


    $CI->db->where('id', 1);
    $get_config = $CI->db->get(db_prefix() . 'multi100_config')->row();

    $multi100_api_token = $get_config->multi100_api_token;
    $multi100_api_url = $get_config->multi100_api_url;


    if (!$multi100_api_token || !$multi100_api_url) {

        return false;
    }

    return true;
}

function check_asaas_config()
{
    $CI = &get_instance();

    $CI->db->where('id', 1);
    $get_config = $CI->db->get(db_prefix() . 'multi100_config')->row();

    $asaas_sandbox = $get_config->asaas_sandbox;

    $asaas_api_key = $get_config->asaas_api_key;

    $asaas_api_key_sandbox = $get_config->asaas_api_key_sandbox;

    if (!$asaas_api_key && !$asaas_api_key_sandbox) {

        return false;
    }

    return true;
}

function check_config()
{
    $CI = &get_instance();

    $CI->db->where('id', 1);
    $get_config = $CI->db->get(db_prefix() . 'multi100_config')->row();

    $multi100_api_token = $get_config->multi100_api_token;
    $multi100_api_url = $get_config->multi100_api_url;

    $multi100_split_type = $get_config->multi100_split_type;
    $multi100_split_value = $get_config->multi100_split_value;

    $multi100_client_token = $get_config->multi100_client_token;

    $asaas_sandbox = $get_config->asaas_sandbox;

    $asaas_api_key = $get_config->asaas_api_key;

    $asaas_api_key_sandbox = $get_config->asaas_api_key_sandbox;

    $elementor_api_assigned = $get_config->elementor_api_assigned;
    $elementor_api_source = $get_config->elementor_api_source;

    if (!$multi100_api_token || !$multi100_api_url) {

        return false;
    }

    if (!$asaas_api_key && !$asaas_api_key_sandbox) {

        return false;
    }

    return true;
}

function date_fmt($date)
{
    if(!$date) {
        return '00/00/0000 00:00';
    }
    return date('d/m/Y H:i', strtotime($date));
}

function get_commission($commission, $count)
{
    if ($count <= 10) {
        return $commission;
    }

    if ($count > 10 && $count <= 15) {
        return $commission + 5;
    }

    if ($count > 15 && $count <= 20) {
        return $commission + 10;
    }

    if ($count > 20) {
        return $commission + 15;
    }
}
