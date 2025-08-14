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

    // public function get_crime_id()
    // {
    //     $crime_id = $this->Model_Api->get_crime_id();
        
    //     if ($crime_id !== null) {
    //         $response = [
    //             'status' => 'success',
    //             'message' => 'Crime id fetched successfully',
    //             'crimeId' => $crime_id
    //         ];
    //     } else {
    //         $response = [
    //             'status' => 'error',
    //             'message' => 'Failed to fetch crime id'
    //         ];
    //     }

    //     echo json_encode($response);
    // }

    public function save_record()
    {
        $data = json_decode(file_get_contents('php://input'),true);
        if($data['case_id'] == null){
            $response = $this->Model_Api->save_record($data);
        }
        else{
            $response = $this->Model_Api->update_record($data);
        }
        
        if($response > 0)
        {
            echo json_encode(['status' => 'success', 'message' => 'Record saved successfully']);
        }
        else
        {
            echo json_encode(['status' => 'error', 'message' => 'Failed to save record']);
        }
    }
}
