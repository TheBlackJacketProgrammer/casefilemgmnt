<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_Api extends CI_Model 
{
    public function login($data)
    {
        $this->db->where('user_account', $data['username']);
		$this->db->where('user_password', $data['password']);
		$query = $this->db->get('user');
		$isExist = $query->num_rows();
        
        if($isExist > 0) {
            return $query->row_array(); // Return user data as array
        } else {
            return false; // Return false if no user found
        }
    }

    public function get_records()
    {
        $query = $this->db->query("CALL GetRecordsOrderedByDate()");
        return $query->result_array();
    }
}