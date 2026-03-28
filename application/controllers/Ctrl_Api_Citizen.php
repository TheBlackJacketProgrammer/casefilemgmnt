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
        $post_data = $this->input->post();
        $data = [];

        // String path from DB when user is not uploading a new file (not present when only $_FILES is set)
        $existing_img_path = isset($post_data['citizen_img_path']) ? $post_data['citizen_img_path'] : '';
        if ($existing_img_path === '[object File]') {
            $existing_img_path = '';
        }

        foreach ($post_data as $key => $value) {
            if ($key === 'citizen_img_path') {
                continue;
            }
            if ($key === 'current_img_path') {
                $current_img_path = $value;
                continue;
            }
            $data[$key] = $value;
        }

        $full_name = $data['last_name'] . "_" . $data['first_name'] . "_" . $data['middle_name'];

        // First argument is the $_FILES field name, not the posted value
        $data['citizen_img_path'] = upload_file('citizen_img_path', 'citizen', $full_name, $current_img_path);

        if(empty($data['citizen_id'])){
            $response = $this->Model_Api->save_citizen_profile($data);
        } 
        else 
        {
            $response = $this->Model_Api->update_citizen_profile($data);
        }
        echo json_encode($response);
    }

    public function generate_barangay_certificate()
    {
        $templatePath = FCPATH . 'assets/templates/template_brgy_cert.docx';
        if (!is_file($templatePath)) {
            $this->output->set_status_header(404);
            $this->output->set_content_type('application/json');
            echo json_encode(['success' => false, 'message' => 'Certificate template not found (assets/templates/template_brgy_cert.docx).']);
            return;
        }

        $raw = $this->input->raw_input_stream;
        $input = json_decode($raw, true);
        if (!is_array($input)) {
            $input = $this->input->post(null, true);
        }
        if (!is_array($input)) {
            $input = [];
        }

        $first = isset($input['first_name']) ? (string) $input['first_name'] : '';
        $middle = isset($input['middle_name']) ? (string) $input['middle_name'] : '';
        $last = isset($input['last_name']) ? (string) $input['last_name'] : '';
        $fullname = $last . ", " . $first . " " . $middle;
        $age = isset($input['age']) ? trim((string) $input['age']) : '';
        $nationality = isset($input['nationality']) ? (string) $input['nationality'] : 'N/A';
        $civil_status = isset($input['civil_status']) ? (string) $input['civil_status'] : 'N/A';

        $d = (int) date('j');
        if ($d >= 11 && $d <= 13) {
            $day = $d . 'th';
        } else {
            switch ($d % 10) {
                case 1:
                    $day = $d . 'st';
                    break;
                case 2:
                    $day = $d . 'nd';
                    break;
                case 3:
                    $day = $d . 'rd';
                    break;
                default:
                    $day = $d . 'th';
            }
        }
        $month = date('F');
        $year = date('Y');

        
        try {
            load_phpword_bootstrap();
            $processor = new \PhpOffice\PhpWord\TemplateProcessor($templatePath);
            $processor->setValues([
                'fullname' => $fullname,
                'age' => $age,
                'nationality' => $nationality,
                'civil_status' => $civil_status,
                'day' => $day,
                'month' => $month,
                'year' => $year,
            ]);
        } catch (\Throwable $e) {
            $this->output->set_status_header(500);
            $this->output->set_content_type('application/json');
            echo json_encode(['success' => false, 'message' => 'Could not generate certificate.']);
            return;
        }

        $tempFile = tempnam(sys_get_temp_dir(), 'brgy_cert_');
        if ($tempFile === false) {
            $this->output->set_status_header(500);
            $this->output->set_content_type('application/json');
            echo json_encode(['success' => false, 'message' => 'Could not create temporary file.']);
            return;
        }

        $docxPath = $tempFile . '.docx';
        if (!@rename($tempFile, $docxPath)) {
            $docxPath = $tempFile;
        }

        try {
            $processor->saveAs($docxPath);
        } catch (\Throwable $e) {
            @unlink($docxPath);
            if ($docxPath !== $tempFile) {
                @unlink($tempFile);
            }
            $this->output->set_status_header(500);
            $this->output->set_content_type('application/json');
            echo json_encode(['success' => false, 'message' => 'Could not save certificate.']);
            return;
        }

        $binary = file_get_contents($docxPath);
        @unlink($docxPath);
        if (is_file($tempFile)) {
            @unlink($tempFile);
        }

        if ($binary === false) {
            $this->output->set_status_header(500);
            $this->output->set_content_type('application/json');
            echo json_encode(['success' => false, 'message' => 'Could not read certificate.']);
            return;
        }

        $safeLast = preg_replace('/[^a-zA-Z0-9_-]/', '_', $last);
        $filename = 'barangay_certificate_' . ($safeLast !== '' ? $safeLast : 'resident') . '.docx';

        $this->output->set_content_type('application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        $this->output->set_header('Content-Disposition: attachment; filename="' . $filename . '"');
        $this->output->set_header('Content-Length: ' . strlen($binary));
        $this->output->set_output($binary);
    }

}
