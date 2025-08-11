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

    public function get_crime_types()
    {
        $query = $this->db->query("CALL GetCrimeTypes()");
        return $query->result_array();
    }

    // public function get_crime_id()
    // {
    //     $query = $this->db->query("CALL GetNewCrimeId()");
    //     $result = $query->result_array();
        
    //     // Return just the new_id value if it exists
    //     if (!empty($result) && isset($result[0]['new_id'])) {
    //         return $result[0]['new_id'];
    //     }
        
    //     return null;
    // }

    public function save_record($params)
    {
        // Insert complainant
        $complainant['complainant_age'] = $params['complainant_age'];
		$complainant['complainant_address'] = $params['complainant_address'];
		$complainant['complainant_birthday'] = $params['complainant_birthday'];
		$complainant['complainant_contactNum'] = $params['complainant_contactNum'];
		$complainant['complainant_name'] = $params['complainant_name'];
        $this->db->insert('complainant',$complainant);

        // Get complainant id
        $complainant_id = $this->db->insert_id();

        // Insert complainee
        $complainee['complainee_age'] = $params['complainee_age'];
		$complainee['complainee_address'] = $params['complainee_address'];
		$complainee['complainee_birthday'] = $params['complainee_birthday'];
		$complainee['complainee_contactNum'] = $params['complainee_contactNum'];
		$complainee['complainee_name'] = $params['complainee_name'];
        $this->db->insert('complainee',$complainee);

        // Get complainee id
        $complainee_id = $this->db->insert_id();

        // Get user id
        $case['case_user_id'] = $this->session->userdata('user_id');
        $case['case_complainant_id'] = $complainant_id;
        $case['case_complainee_id'] = $complainee_id;

        // Insert case
		$case['case_dateFiled'] = $params['case_dateFiled'];
		$case['case_crimeDate'] = $params['case_crimeDate'];
        $case['case_crimeDetails'] = $params['case_crimeDetails'];
		$case['case_crimeScene'] = $params['case_crimeScene'];
		$case['case_crimeType'] = $params['case_crimeType'];
		$case['case_crimeWitness'] = $params['case_crimeWitness'];
        $case['case_notify'] = "Not Notify";

        $this->db->insert('records',$case);

        return $this->db->affected_rows();
    }
}