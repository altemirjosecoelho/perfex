<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Multi100 extends App_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        set_alert('warning', 'Não encontrado');
        redirect(admin_url(), 'refresh');
    }
}