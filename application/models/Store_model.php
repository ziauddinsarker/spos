<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Store_model extends CI_Model
{
        function __construct()
        {
            // Call the Model constructor
            parent::__construct();
        }


    /**
     * @return array
     */
    function get_store_name()
    {
        $this->db->select('id,store_name');
        $this->db->from('tbl_store');
        $this->db->order_by('store_name','ASC');
        $query = $this->db->get();
        $result = $query->result();

        //array to store department id & department name
        $store_id = array('');
        $store_name = array('-select-');

        for ($i = 0; $i < count($result); $i++) {
            array_push($store_id, $result[$i]->id);
            array_push($store_name, $result[$i]->store_name);
        }
        return $doc_specility_result = array_combine($store_id, $store_name);
    }

    /**
     * @return array
     */
    function get_user_name()
    {
        $this->db->select('id,username');
        $this->db->from('users');
        $this->db->order_by('username','ASC');
        $query = $this->db->get();
        $result = $query->result();

        //array to store department id & department name
        $user_id = array('');
        $user_name = array('-select-');

        for ($i = 0; $i < count($result); $i++) {
            array_push($user_id, $result[$i]->id);
            array_push($user_name, $result[$i]->username);
        }
        return $doc_specility_result = array_combine($user_id, $user_name);
    }

    }
