<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ctrl_Api_Brgy extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

    public function get_barangay_masterlist()
    {
        $barangay_masterlist = $this->Model_Main->get_barangay_masterlist();
        $response = [
            'status' => 'success',
            'message' => 'Citizen records fetched successfully',
            'barangayMasterlist' => $barangay_masterlist
        ];
        echo json_encode($response);
    }

    public function save_brgy_profile()
    {
        $payload = json_decode(file_get_contents('php://input'), true);
        if(empty($payload['brgy_id'])){
            $response = $this->Model_Api->save_brgy_profile($payload);
        }
        else {
            $response = $this->Model_Api->update_brgy_profile($payload);
        }
        echo json_encode($response);
    }
}
