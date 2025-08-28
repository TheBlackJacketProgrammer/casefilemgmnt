<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ctrl_Api extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function login()
	{
		$data = json_decode(file_get_contents('php://input'),true); 
        $response = $this->Model_Api->login($data);

        if($response !== false)
        {
            $this->session->set_userdata('user_id', $response['user_id']);
            $this->session->set_userdata('user_logged_in', true);

            // Prepare Event Log
            $log["user_id_logged_in"] = $response['user_id'];
            $log["date_created"] = date('Y-m-d H:i:s');
            $log['log_action'] = 'Login';

            // Save Event Log
            $this->Model_Api->save_event_log($log);

            echo json_encode(['status' => 'success', 'user' => $response]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid credentials']);
        }
	}

    public function get_records()
    {
        if($this->session->userdata('user_logged_in'))
        {
            $records = $this->Model_Api->get_records();
            $response = [
                'status' => 'success',
                'message' => 'Records fetched successfully',
                'records' => $records
            ];
            echo json_encode($response);
        }
        else
        {
            echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
        }
    }

    public function get_crime_options(){
        $crime_options = $this->Model_Api->get_crime_options();
        $response = [
            'status' => 'success',
            'message' => 'Crime options fetched successfully',
            'crimeOptions' => $crime_options
        ];
        echo json_encode($response);
    }

    public function get_crime_types()
    {
        $crime_types = $this->Model_Api->get_crime_types();
        $response = [
            'status' => 'success',
            'message' => 'Crime types fetched successfully',
            'crimeTypes' => $crime_types
        ];
        echo json_encode($response);
    }

    private function parseJavaScriptDate($dateString) 
    {
        // Handle JavaScript Date object format: "Fri Aug 15 2025 08:00:00 GMT+0800 (Taipei Standard Time)"
        if (preg_match('/(\w{3})\s+(\w{3})\s+(\d{1,2})\s+(\d{4})\s+(\d{2}):(\d{2}):(\d{2})\s+GMT([+-]\d{4})/', $dateString, $matches)) {
            $month = $matches[2];
            $day = $matches[3];
            $year = $matches[4];
            $hour = $matches[5];
            $minute = $matches[6];
            $second = $matches[7];
            
            // Convert month abbreviation to number
            $months = [
                'Jan' => '01', 'Feb' => '02', 'Mar' => '03', 'Apr' => '04',
                'May' => '05', 'Jun' => '06', 'Jul' => '07', 'Aug' => '08',
                'Sep' => '09', 'Oct' => '10', 'Nov' => '11', 'Dec' => '12'
            ];
            
            if (isset($months[$month])) {
                return sprintf('%s-%s-%s %s:%s:%s', $year, $months[$month], str_pad($day, 2, '0', STR_PAD_LEFT), $hour, $minute, $second);
            }
        }
        
        // Fallback to standard PHP date parsing
        $timestamp = strtotime($dateString);
        if ($timestamp === false) {
            return null;
        }
        
        return date('Y-m-d H:i:s', $timestamp);
    }

    public function save_record()
    {
        // Get all POST data
        $post_data = $this->input->post();
        
        // Loop through POST data to reconstruct the case record
        foreach($post_data as $key => $value) {
            // Skip image fields as they're handled separately
            if ($key !== 'complainant_image' && $key !== 'complainee_image') {
                $data[$key] = $value;
            }
        }

        // Upload images
        $data['complainant_pic'] = upload_file('complainant_image', 'complainant', $data['complainant_name'], $data['complainant_pic']);
        $data['complainee_pic'] = upload_file('complainee_image', 'complainee', $data['complainee_name'], $data['complainee_pic']);

        // Prepare data for model
        $params = array();
        
        if($data['case_id'] == "null"){
            // Prepare data for new record
            $params['complainant'] = array(
                'complainant_age' => $data['complainant_age'],
                'complainant_address' => $data['complainant_address'],
                'complainant_birthday' => $this->parseJavaScriptDate($data['complainant_birthday']),
                'complainant_contactNum' => $data['complainant_contactNum'],
                'complainant_name' => $data['complainant_name'],
                'complainant_pic' => $data['complainant_pic']
            );
            
            $params['complainee'] = array(
                'complainee_age' => $data['complainee_age'],
                'complainee_address' => $data['complainee_address'],
                'complainee_birthday' => $this->parseJavaScriptDate($data['complainee_birthday']),
                'complainee_contactNum' => $data['complainee_contactNum'],
                'complainee_name' => $data['complainee_name'],
                'complainee_pic' => $data['complainee_pic']
            );
            
            $params['case'] = array(
                'case_dateFiled' => $this->parseJavaScriptDate($data['case_dateFiled']),
                'case_crimeDate' => $this->parseJavaScriptDate($data['case_crimeDate']),
                'case_crimeDetails' => $data['case_crimeDetails'],
                'case_crimeScene' => $data['case_crimeScene'],
                'case_crimeType' => $data['case_crimeType'],
                'case_crimeWitness' => $data['case_crimeWitness'],
                'case_status' => $data['case_status']
            );
            
            $response = $this->Model_Api->save_record($params);

            // Prepare Event Log
            $log["user_id_logged_in"] = $this->session->userdata('user_id');
            $log["date_created"] = $this->parseJavaScriptDate($data['case_dateFiled']);
            $log['log_action'] = 'Success Save New Record. Case ID: ' . $response['case_id'];

            // Save Event Log
            $this->Model_Api->save_event_log($log);
        }
        else{
            // Prepare data for update
            $params['complainant_id'] = $data['complainant_id'];
            $params['complainee_id'] = $data['complainee_id'];
            $params['case_id'] = $data['case_id'];
            
            $params['complainant'] = array(
                'complainant_age' => $data['complainant_age'],
                'complainant_address' => $data['complainant_address'],
                'complainant_birthday' => $this->parseJavaScriptDate($data['complainant_birthday']),
                'complainant_contactNum' => $data['complainant_contactNum'],
                'complainant_name' => $data['complainant_name'],
                'complainant_pic' => $data['complainant_pic']
            );
            
            $params['complainee'] = array(
                'complainee_age' => $data['complainee_age'],
                'complainee_address' => $data['complainee_address'],
                'complainee_birthday' => $this->parseJavaScriptDate($data['complainee_birthday']),
                'complainee_contactNum' => $data['complainee_contactNum'],
                'complainee_name' => $data['complainee_name'],
                'complainee_pic' => $data['complainee_pic']
            );
            
            $params['case'] = array(
                'case_crimeDate' => $this->parseJavaScriptDate($data['case_crimeDate']),
                'case_crimeDetails' => $data['case_crimeDetails'],
                'case_crimeScene' => $data['case_crimeScene'],
                'case_crimeType' => $data['case_crimeType'],
                'case_crimeWitness' => $data['case_crimeWitness'],
                'case_dateUpdated' => $this->parseJavaScriptDate($data['case_dateUpdated']),
                'case_status' => $data['case_status']
            );
            
            $response = $this->Model_Api->update_record($params);

            // Prepare Event Log
            $log["user_id_logged_in"] = $this->session->userdata('user_id');
            $log["date_created"] = $this->parseJavaScriptDate($data['case_dateUpdated']);
            $log['log_action'] = 'Success Update Record. Case ID: ' . $data['case_id'];

            // Save Event Log
            $this->Model_Api->save_event_log($log);
        }

        // Check the response format from the model
        if(isset($response['success']) && $response['success'] === true) {
            echo json_encode([
                'status' => 'success', 
                'message' => $response['message'], 
                'affected_rows' => $response['affected_rows']
            ]);
        } else {
            echo json_encode([
                'status' => 'error', 
                'message' => $response['message'] ?? 'Failed to save record',
                'error_code' => $response['error_code'] ?? null
            ]);
        }
    }

    public function save_crime_type()
    {
        $data = json_decode(file_get_contents('php://input'),true); 
        if($data['crimeType_id'] == "null" || $data['crimeType_id'] == null || $data['crimeType_id'] == "") {
            $response = $this->Model_Api->save_crime_type($data);
            // Prepare Event Log
            $log["user_id_logged_in"] = $this->session->userdata('user_id');
            $log["date_created"] = date('Y-m-d H:i:s');
            $log['log_action'] = 'Success Save New Crime Type. Crime Name: ' . $data['crimeType_name'];

            // Save Event Log
            $this->Model_Api->save_event_log($log);
        }
        else {
            $response = $this->Model_Api->update_crime_type($data);

            // Prepare Event Log
            $log["user_id_logged_in"] = $this->session->userdata('user_id');
            $log["date_created"] = date('Y-m-d H:i:s');
            $log['log_action'] = 'Success Update Crime Type. Crime Name: ' . $data['crimeType_name'];

            // Save Event Log
            $this->Model_Api->save_event_log($log);
        }
        echo json_encode($response);
    }

    public function get_user_masterlist(){
        $user_masterlist = $this->Model_Api->get_user_masterlist();
        $response = [
            'status' => 'success',
            'message' => 'User masterlist fetched successfully',
            'users' => $user_masterlist
        ];
        echo json_encode($response);
    }

    public function get_org_chart(){
        $org_chart = $this->Model_Api->get_org_chart();
        $response = [
            'status' => 'success',
            'message' => 'Org chart fetched successfully',
            'orgchart' => $org_chart
        ];
        echo json_encode($response);
    }

    // Save User Details
    public function save_user_details(){
        $post_data = $this->input->post();

        // Loop through POST data to reconstruct the user details
        foreach($post_data as $key => $value) {
            // Skip image fields as they're handled separately
            if ($key !== 'user_image') {
                $data[$key] = $value;
            }
        }

        // Parse date
        $data['user_birthdate'] = $this->parseJavaScriptDate($data['user_birthdate']);
        $data['user_datecreated'] = $this->parseJavaScriptDate($data['user_datecreated']);
        $person_name = $data['user_firstname'] . "_" . $data['user_middlename'] . "_" . $data['user_lastname'];

        // Upload images
        $data['user_pic'] = upload_file('user_image', 'user', $person_name , $data['user_pic']);

        // Set Static Values
        $data['user_is_first_login'] = 1;
        $data['user_status'] = 1;

        if($data['user_id'] == "null"){
            $response = $this->Model_Api->save_user_details($data);

            // Prepare Event Log
            $log["user_id_logged_in"] = $this->session->userdata('user_id');
            $log["date_created"] = $this->parseJavaScriptDate($data['user_datecreated']);
            $log['log_action'] = 'Success Save New User. User ID: ' . $response['user_id'];

            // Save Event Log
            $this->Model_Api->save_event_log($log);
        }
        else{
            $response = $this->Model_Api->update_user_details($data);
            
            // Prepare Event Log
            $log["user_id_logged_in"] = $this->session->userdata('user_id');
            $log["date_created"] = date('Y-m-d H:i:s');
            $log['log_action'] = 'Success Update User. User ID: ' . $response['user_id'];

            // Save Event Log
            $this->Model_Api->save_event_log($log);
        }

        // Check the response format from the model
        if(isset($response['success']) && $response['success'] === true) {
            echo json_encode([
                'status' => 'success', 
                'message' => $response['message'], 
                'affected_rows' => $response['affected_rows']
            ]);
        } else {
            echo json_encode([
                'status' => 'error', 
                'message' => $response['message'] ?? 'Failed to save record',
                'error_code' => $response['error_code'] ?? null
            ]);
        }

    }

    // Update User Status
    public function update_user_status(){
        $data = json_decode(file_get_contents('php://input'),true);
        $status = $data['user_status'] == 1 ? 0 : 1;
        $response = $this->Model_Api->update_user_status($data, $status);

        // Prepare Event Log
        $log["user_id_logged_in"] = $this->session->userdata('user_id');
        $log["date_created"] = date('Y-m-d H:i:s');
        $log['log_action'] = 'Success Update User Status. User ID: ' . $data['user_id'] . ' Status: ' . ($status == 1 ? 'Active' : 'Deactivated');

        // Save Event Log
        $this->Model_Api->save_event_log($log);

        echo json_encode($response);
    }

    // Get Event Logs
    public function get_event_logs(){
        $event_logs = $this->Model_Api->get_event_logs();
        
        // Format date_created to show AM/PM format
        foreach ($event_logs as &$log) {
            if (isset($log['date_created']) && !empty($log['date_created'])) {
                $log['date_created'] = date('M d, Y g:i A', strtotime($log['date_created']));
            }
        }
        
        $response = [
            'status' => 'success',
            'message' => 'Event logs fetched successfully',
            'eventlogs' => $event_logs
        ];
        echo json_encode($response);
    }
}
