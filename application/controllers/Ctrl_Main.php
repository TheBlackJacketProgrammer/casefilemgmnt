<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ctrl_Main extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['title'] = 'Brgy Case File Management System';
		if($this->session->userdata('user_logged_in'))
		{
			$data['content'] = 'pages/page_dashboard';
		} else {
			$data['content'] = 'pages/page_login';
		}
		$data['user_logged_in'] = $this->session->userdata('user_logged_in');
		$this->load->view('pages/page_template', $data);
	}

	public function open_records()
	{
		$result['view'] = $this->load->view('sections/records', '', true);
		echo json_encode($result);
	}

	public function open_incident_records()
	{
		$result['view'] = $this->load->view('sections/incident_records', '', true);
		echo json_encode($result);
	}

	public function open_user_portal()
	{
		$result['view'] = $this->load->view('sections/user_portal', '', true);
		echo json_encode($result);
	}

	public function open_citizen_records()
	{
		$result['view'] = $this->load->view('sections/citizen_records', '', true);
		echo json_encode($result);
	}

	public function open_event_logs()
	{
		$result['view'] = $this->load->view('sections/event_logs', '', true);
		echo json_encode($result);
	}

	public function open_data_statistics()
	{
		$result['view'] = $this->load->view('sections/data_statistics', '', true);
		echo json_encode($result);
	}

	public function logout()
	{
		// Prepare Event Log
		$log["user_id_logged_in"] = $this->session->userdata('user_id');
		$log["date_created"] = date('Y-m-d H:i:s');
		$log['log_action'] = 'Logout';

		// Save Event Log
		$this->Model_Api->save_event_log($log);

		// Destroy Session
		$this->session->sess_destroy();
		return true;
	}

	public function view_report_form() {
		$data = json_decode(file_get_contents('php://input'),true); 
        // Generate PDF using library with the data
        generate_pdf_from_view('pdf/pdf_report_form', $data, 'download_document.pdf', 'A4', 'portrait', true);
    }

}
