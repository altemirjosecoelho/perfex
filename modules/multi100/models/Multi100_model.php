<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Multi100_model extends App_Model
{

    public function __construct()
    {

    }

    public function get_config()
    {
        $this->db->where('id', 1);
        $get_config = $this->db->get(db_prefix() . 'multi100_config')->row();
        
        if ($get_config) {
            return $get_config;
        } else {
            // If the config data doesn't exist, insert empty values
            $data = array(
                'id' => 1,
                'multi100_api_token' => '',
                'multi100_api_url' => ''
            );
            $this->db->insert(db_prefix() . 'multi100_config', $data);
        
            // Get the inserted config data
            $this->db->where('id', 1);
            $get_config = $this->db->get(db_prefix() . 'multi100_config')->row();
        
            return $get_config;
        }

        return $get_config;

    }

    public function update_config($data)
    {

        $this->db->where('id', 1);
        $this->db->update(db_prefix() . 'multi100_config', $data);

    }

}