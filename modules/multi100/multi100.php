<?php

defined('BASEPATH') or exit('No direct script access allowed');

/*

Module Name: Multi100
Description: Modulo administrador integração de assinaturas Asaas com api multi100.
Requires at least: 2.3.*

*/

$CI = &get_instance();

register_activation_hook('multi100', 'multi100_activation_hook');

function multi100_activation_hook()
{
    require(__DIR__ . '/install.php');
}

register_deactivation_hook('multi100', 'multi100_deactivation_hook');

function multi100_deactivation_hook()
{
}

register_uninstall_hook('multi100', 'multi100_uninstall_hook');

function multi100_uninstall_hook()
{
}

hooks()->add_action('admin_init', 'multi100_admin_menu');

function multi100_admin_menu()
{
    $CI = &get_instance();
    $CI->app_menu->add_sidebar_menu_item('multi100', [
        'collapse' => true,
        'name' => 'Multi 100',
        'icon' => 'fa fa-shield',
        'position' => 12,
        'badge' => [],
        'slug' => 'multi100',
    ]);

    $CI->app_menu->add_sidebar_children_item('multi100', [
        'name' => 'Assinaturas',
        'href' => admin_url('multi100/subscriptions'),
        'position' => 12,
        'badge' => [],
        'slug' => 'multi100',
    ]);

    $CI->app_menu->add_sidebar_children_item('multi100', [
        'name' => 'Clientes',
        'href' => admin_url('multi100/companies'),
        'position' => 12,
        'badge' => [],
        'slug' => 'multi100',
    ]);

    $CI->app_menu->add_sidebar_children_item('multi100', [
        'name' => 'Parceiros',
        'href' => admin_url('multi100/partners'),
        'position' => 12,
        'badge' => [],
        'slug' => 'multi100',
    ]);

    $CI->app_menu->add_sidebar_children_item('multi100', [
        'name' => 'Planos',
        'href' => admin_url('multi100/plans'),
        'position' => 12,
        'badge' => [],
        'slug' => 'multi100',
    ]);

    $CI->app_menu->add_sidebar_children_item('multi100', [
        'name' => 'Ajuda',
        'href' => admin_url('multi100/helps'),
        'position' => 12,
        'badge' => [],
        'slug' => 'multi100',
    ]);

    $CI->app_menu->add_sidebar_children_item('multi100', [
        'name' => 'Formulários',
        'href' => admin_url('multi100/submissions'),
        'position' => 12,
        'badge' => [],
        'slug' => 'multi100',
    ]);

    $CI->app_menu->add_sidebar_children_item('multi100', [
        'name' => 'Configurações',
        'href' => admin_url('multi100/config'),
        'position' => 12,
        'badge' => [],
        'slug' => 'multi100',
    ]);
}

function multi100_after_client_added($userid)
{
    $CI = &get_instance();


    return $userid;
}

function multi100_after_client_updated($id)
{
    $CI = &get_instance();


    return $id;
}

function multi100_before_client_deleted($id)
{
    $CI = &get_instance();


    return $id;
}

function multi100_after_client_deleted($id)
{
    $CI = &get_instance();


    return $id;
}

function multi100_contact_created($contact_id)
{
    $CI = &get_instance();


    $CI->load->library('multi100/multi100');

    $CI->load->library('multi100/multi100_gateway');


    return $contact_id;
}

function multi100_contact_updated($id)
{
    $CI = &get_instance();

    $CI->load->library('multi100/multi100');


    $CI->load->library('multi100/multi100_gateway');


    return $id;
}

function multi100_before_delete_contact($id)
{
    $CI = &get_instance();


    return $id;
}

// hooks()->add_action('contact_deleted', 'multi100_contact_deleted');

function multi100_contact_deleted($id, $result)
{
    $CI = &get_instance();

    $CI->load->library('multi100/multi100');

    $CI->load->library('multi100/multi100_gateway');


    return $id;
}
