<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_Main extends CI_Model 
{

    public function get_citizen_records()
    {
        $query = $this->db->query("CALL GetAllCitizenRecords()");
        $result = $query->result_array();
        $query->free_result();
        return $result;
    }

    public function get_barangay_masterlist()
    {
        $query = $this->db->query("CALL GetAllBarangayRecords()");
        $result = $query->result_array();
        $query->free_result();
        return $result;
    }

}