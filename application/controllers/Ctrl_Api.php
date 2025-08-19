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
        // Reconstruct case data from individual form fields
        $data = array();
        
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
        }
        else {
            $response = $this->Model_Api->update_crime_type($data);
        }
        echo json_encode($response);
    }
}
