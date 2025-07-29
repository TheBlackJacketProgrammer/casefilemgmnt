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

	public function logout()
	{
		$this->session->sess_destroy();
		return true;
	}

}
