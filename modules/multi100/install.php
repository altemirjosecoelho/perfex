<?php

$CI = &get_instance();

#
# Structure for table "tblmulti100_submissions"
#

if (!$CI->db->table_exists(db_prefix() . 'multi100_submissions')) {
$CI->db->query("CREATE TABLE `" . db_prefix() . "multi100_submissions` (
   `id` int(11) NOT NULL AUTO_INCREMENT,
  `payload` text DEFAULT NULL,
  `form_id` varchar(255) DEFAULT NULL,
  `form_name` varchar(255) DEFAULT NULL,
  `multi100_plan` int(11) DEFAULT NULL,
  `is_trial` int(11) DEFAULT NULL,
  `perfex_lead` int(11) DEFAULT NULL,
  `perfex_lead_id` varchar(255) DEFAULT NULL,
  `perfex_client` int(11) DEFAULT NULL,
  `perfex_client_id` varchar(255) DEFAULT NULL,
  `perfex_contact` int(11) DEFAULT NULL,
  `perfex_contact_id` varchar(255) DEFAULT NULL,
  `asaas_customer` int(11) DEFAULT NULL,
  `asaas_customer_id` varchar(255) DEFAULT NULL,
  `asaas_subscription` int(11) DEFAULT NULL,
  `asaas_subscription_id` varchar(255) DEFAULT NULL,
  `multi100_client` int(11) DEFAULT NULL,
  `multi100_client_id` varchar(255) DEFAULT NULL,
  `multi100_plan_payload` text DEFAULT NULL,
  `asaas_customer_payload` text DEFAULT NULL,
  `asaas_subscription_payload` text DEFAULT NULL,
  `multi100_client_payload` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=" . $CI->db->char_set . ";");
}

#
# Structure for table "tblmulti100_webhooks"
#

if (!$CI->db->table_exists(db_prefix() . 'multi100_webhooks')) {
$CI->db->query("CREATE TABLE `" . db_prefix() . "multi100_webhooks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `payload` text DEFAULT NULL,
  `event` varchar(255) DEFAULT NULL,
  `payment_id` varchar(255) DEFAULT NULL,
  `subscription_id` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;");
}

if (!$CI->db->table_exists(db_prefix() . 'multi100_config')) {
$CI->db->query("CREATE TABLE `" . db_prefix() . "multi100_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `multi100_api_token` varchar(255) DEFAULT NULL,
  `multi100_api_url` varchar(255) DEFAULT NULL,
  `multi100_split_type` varchar(255) DEFAULT NULL,
  `multi100_split_value` varchar(255) DEFAULT NULL,
  `multi100_split_wallet` varchar(255) DEFAULT NULL,  
  `multi100_client_api_url` varchar(255) DEFAULT NULL,
  `multi100_client_token` varchar(255) DEFAULT NULL,
  `asaas_sandbox` varchar(255) DEFAULT NULL,
  `asaas_api_key` varchar(255) DEFAULT NULL,
  `asaas_api_key_sandbox` varchar(255) DEFAULT NULL,
  `elementor_api_assigned` varchar(255) DEFAULT NULL,
  `elementor_api_source` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;");
}


if ($CI->db->table_exists(db_prefix() . 'multi100_config')) {
$CI->db->insert(db_prefix() . 'multi100_config', [
'id' => '1',
'multi100_api_token' => '',
'multi100_api_url' => '',
'multi100_split_type' => '',
'multi100_split_value' => '',

]);
}