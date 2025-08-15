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

    public function save_record($params)
    {
        // Start transaction
        $this->db->trans_start();
        
        try {
            // Insert complainant
            $this->db->insert('complainant', $params['complainant']);
            
            // Check for database errors
            if ($this->db->affected_rows() <= 0) {
                throw new Exception('Failed to insert complainant: ' . $this->db->error()['message']);
            }

            // Get complainant id
            $complainant_id = $this->db->insert_id();
            if (!$complainant_id) {
                throw new Exception('Failed to get complainant ID');
            }

            // Insert complainee
            $this->db->insert('complainee', $params['complainee']);
            
            // Check for database errors
            if ($this->db->affected_rows() <= 0) {
                throw new Exception('Failed to insert complainee: ' . $this->db->error()['message']);
            }

            // Get complainee id
            $complainee_id = $this->db->insert_id();
            if (!$complainee_id) {
                throw new Exception('Failed to get complainee ID');
            }

            // Insert case
            $params['case']['case_complainant_id'] = $complainant_id;
            $params['case']['case_complainee_id'] = $complainee_id;
            $params['case']['case_user_id'] = $params['user_id'];
            $params['case']['case_status'] = "Pending";

            $this->db->insert('records', $params['case']);
            
            // Check for database errors
            if ($this->db->affected_rows() <= 0) {
                throw new Exception('Failed to insert case record: ' . $this->db->error()['message']);
            }

            // Complete transaction
            $this->db->trans_complete();
            
            if ($this->db->trans_status() === FALSE) {
                throw new Exception('Transaction failed');
            }
            
            return array(
                'success' => true,
                'message' => 'Record saved successfully',
                'affected_rows' => $this->db->affected_rows()
            );
            
        } catch (Exception $e) {
            // Rollback transaction on error
            $this->db->trans_rollback();
            
            return array(
                'success' => false,
                'message' => 'Error saving record: ' . $e->getMessage(),
                'error_code' => $e->getCode()
            );
        }
    }

    public function update_record($params)
    {
        // Start transaction
        $this->db->trans_start();
        
        try {
            // Update complainant
            $this->db->where('complainant_id', $params['complainant_id']);
            $this->db->update('complainant', $params['complainant']);
            
            // Check for database errors
            if ($this->db->affected_rows() < 0) {
                throw new Exception('Failed to update complainant: ' . $this->db->error()['message']);
            }

            // Update complainee
            $this->db->where('complainee_id', $params['complainee_id']);
            $this->db->update('complainee', $params['complainee']);
            
            // Check for database errors
            if ($this->db->affected_rows() < 0) {
                throw new Exception('Failed to update complainee: ' . $this->db->error()['message']);
            }

            // Update case
            $this->db->where('case_id', $params['case_id']);
            $this->db->update('records', $params['case']);
            
            // Check for database errors
            if ($this->db->affected_rows() < 0) {
                throw new Exception('Failed to update case record: ' . $this->db->error()['message']);
            }

            // Complete transaction
            $this->db->trans_complete();
            
            if ($this->db->trans_status() === FALSE) {
                throw new Exception('Transaction failed');
            }
            
            return array(
                'success' => true,
                'message' => 'Record updated successfully',
                'affected_rows' => $this->db->affected_rows()
            );
            
        } catch (Exception $e) {
            // Rollback transaction on error
            $this->db->trans_rollback();
            
            return array(
                'success' => false,
                'message' => 'Error updating record: ' . $e->getMessage(),
                'error_code' => $e->getCode()
            );
        }
    }
}