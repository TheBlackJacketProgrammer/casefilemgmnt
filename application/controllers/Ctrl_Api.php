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

}
