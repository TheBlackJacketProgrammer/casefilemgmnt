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

    public function get_crime_options()
    {
        $query = $this->db->query("CALL GetCrimeList()");
        return $query->result_array();
    }

    public function get_crime_types()
    {
        $query = $this->db->query("CALL GetCrimeTypes()");
        return $query->result_array();
    }

    public function save_record($params)
    {
        try {
            // Insert complainant
            $this->db->insert('complainant', $params['complainant']);

            // Get the last inserted ID
            $complainant_id = $this->db->insert_id();

            // Insert complainee
            $this->db->insert('complainee', $params['complainee']);

            // Get the last inserted ID
            $complainee_id = $this->db->insert_id();

            // Set the complainant and complainee IDs to the case record
            $params['case']['case_complainant_id'] = $complainant_id;
            $params['case']['case_complainee_id'] = $complainee_id;
            $params['case']['case_user_id'] = $this->session->userdata('user_id');

            // Insert case
            $this->db->insert('records', $params['case']);
            
            return array(
                'success' => true,
                'message' => 'Record saved successfully',
                'affected_rows' => $this->db->affected_rows(),
                'case_id' => $this->db->insert_id()
            );
        }
        catch (Exception $e) {
            return array(
                'success' => false,
                'message' => 'Error saving record: ' . $e->getMessage(),
                'error_code' => $e->getCode()
            );
        }

    }

    public function update_record($params)
    {
        try {

            // Update complainant
            $this->db->where('complainant_id', $params['complainant_id']);
            $this->db->update('complainant', $params['complainant']);

            // Update complainee
            $this->db->where('complainee_id', $params['complainee_id']);
            $this->db->update('complainee', $params['complainee']);

            // Update case
            $this->db->where('case_id', $params['case_id']);
            $this->db->update('records', $params['case']);
           
            
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

    public function save_crime_type($params)
    {
        try {
            $this->db->insert('crime_types', $params);
            return array(
                'success' => true,
                'message' => 'Crime type saved successfully',
                'affected_rows' => $this->db->affected_rows()
            );
        }
        catch (Exception $e) {
            return array(
                'success' => false,
                'message' => 'Error saving crime type: ' . $e->getMessage(),
                'error_code' => $e->getCode()
            );
        }
    }

    public function update_crime_type($params)
    {
        try {
            $this->db->where('crimeType_id', $params['crimeType_id']);
            $this->db->update('crime_types', $params);
            return array(
                'success' => true,
                'message' => 'Crime type updated successfully',
                'affected_rows' => $this->db->affected_rows()
            );
        }
        catch (Exception $e) {
            return array(
                'success' => false,
                'message' => 'Error updating crime type: ' . $e->getMessage(),
                'error_code' => $e->getCode()
            );
        }
    }

    public function get_user_masterlist(){
        $query = $this->db->query("CALL GetUserList()");
        return $query->result_array();
    }

    public function get_org_chart(){
        $query = $this->db->query("CALL GetOrgChart()");
        return $query->result_array();
    }

    public function save_user_details($data){
        try{
            $this->db->insert('user', $data);
            return array(
                'success' => true,
                'message' => 'User details saved successfully',
                'affected_rows' => $this->db->affected_rows(),
                'user_id' => $this->db->insert_id()
            );
        }

        catch (Exception $e) {
            return array(
                'success' => false,
                'message' => 'Error saving user details: ' . $e->getMessage(),
                'error_code' => $e->getCode()
            );
        }
    }

    public function update_user_details($data){
        try{
            $this->db->where('user_id', $data['user_id']);
            $this->db->update('user', $data);
            return array(
                'success' => true,
                'message' => 'User details updated successfully',
                'affected_rows' => $this->db->affected_rows()
            );
        }
        catch (Exception $e) {
            return array(
                'success' => false,
                'message' => 'Error updating user details: ' . $e->getMessage(),
                'error_code' => $e->getCode()
            );
        }
    }

    public function update_user_status($data, $status){
        try{
            $this->db->where('user_id', $data['user_id']);
            $this->db->update('user', array('user_status' => $status));
            return array(
                'success' => true,
                'message' => 'User status updated successfully',
                'affected_rows' => $this->db->affected_rows()
            );
        }
        catch (Exception $e) {
            return array(
                'success' => false,
                'message' => 'Error updating user status: ' . $e->getMessage(),
                'error_code' => $e->getCode()
            );
        }
    }

    // Event Logs
    public function save_event_log($data){
        try{
            $this->db->insert('event_logs', $data);
            return true;
        }
        catch (Exception $e) {
            return false;
        }
    }

    // Get Event Logs
    public function get_event_logs(){
        $query = $this->db->query("CALL GetEventLogs()");
        return $query->result_array();
    }

    // Data Statistics Queries Here 

    // Get Report by Month
    public function get_report_by_month(){
        $query = $this->db->query("CALL GetReportByMonth()");
        return $query->result_array();
    }

    // Get Report by Crime Type
    public function get_report_by_crime_type(){
        $query = $this->db->query("CALL GetReportByCrimeType()");
        return $query->result_array();
    }

    // Get Report by Status
    public function get_report_by_status(){
        $query = $this->db->query("CALL GetReportByStatus()");
        return $query->result_array();
    }

    // Get Record Totals
    public function get_record_totals(){
        $query = $this->db->query("CALL GetRecordTotals()");
        return $query->result_array();
    }

    // Get Record Status Totals
    public function get_record_status_totals(){
        $query = $this->db->query("CALL GetRecordStatusTotals()");
        return $query->result_array();
    }

    // Get Record Status Filtered by Time Period
    public function get_total_status_per_period($time_period){
        $query = $this->db->query("CALL GetTotalStatusPerPeriod('$time_period')");
        return $query->result_array();
    }

    // Get Total Records by Gender
    public function get_records_per_gender(){
        $query = $this->db->query("CALL GetRecordsPerGender()");
        return $query->result_array();
    }

    // Get Total Records by Age Group
    public function get_records_per_age_group(){
        $query = $this->db->query("CALL GetAgeRange(3)");
        return $query->result_array();
    }

    // Get Total Records per Hour Range
    public function get_records_per_hour(){
        $query = $this->db->query("CALL GetRecordsPerHour()");
        return $query->result_array();
    }

    // Get Total Records per Day of the Week
    public function get_records_per_day_of_week(){
        $query = $this->db->query("CALL GetRecordsPerDayOfWeek()");
        return $query->result_array();
    }

}