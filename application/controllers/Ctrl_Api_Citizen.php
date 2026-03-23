<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ctrl_Api_Citizen extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

    public function get_citizen_records()
    {
        $citizen_records = $this->Model_Main->get_citizen_records();
        $response = [
            'status' => 'success',
            'message' => 'Citizen records fetched successfully',
            'citizenRecords' => $citizen_records
        ];
        echo json_encode($response);
    }

    public function save_citizen_profile()
    {
        $data = json_decode(file_get_contents('php://input'),true);
        if(empty($data['citizen_id'])){
            $response = $this->Model_Api->save_citizen_profile($data);
        } else {
            $response = $this->Model_Api->update_citizen_profile($data);
        }
        echo json_encode($response);
    }

}
