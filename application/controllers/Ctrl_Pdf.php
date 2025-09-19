<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * PDF Controller
 * 
 * This controller demonstrates how to use DomPDF in CodeIgniter
 */

class Ctrl_Pdf extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        
        // Load DomPDF library
        // $this->load->library('dompdf_lib');
        
        // // Load helper
        // $this->load->helper('dompdf');
    }
    
    // Generate PDF
    public function simple() {
        $html = $this->load->view('pdf/pdf_report_form', [], true);
        
        // Generate PDF using helper function
        generate_pdf($html, 'simple_document.pdf', 'A4', 'portrait', false);
    }
    
    // View PDF Report Form
    public function from_view() {
        $data = [
            'title' => 'This is test PDF',
            'content' => 'This PDF was generated from a CodeIgniter view.',
            'date' => date('Y-m-d H:i:s'),
            'items' => [
                ['name' => 'Item 1', 'price' => '$10.00'],
                ['name' => 'Item 2', 'price' => '$20.00'],
                ['name' => 'Item 3', 'price' => '$30.00']
            ]
        ];
        
        // Generate PDF using library
        $this->dompdf_lib->from_view('pdf/sample_pdf', $data, 'view_document.pdf', false);
    }
    
    /**
     * Generate PDF with custom options
     */
    public function custom() {
        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <title>Custom PDF</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                .header { background-color: #f0f0f0; padding: 20px; text-align: center; }
                .content { margin: 20px 0; }
                table { width: 100%; border-collapse: collapse; }
                th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                th { background-color: #f2f2f2; }
            </style>
        </head>
        <body>
            <div class="header">
                <h1>Custom PDF Document</h1>
                <p>Generated on ' . date('Y-m-d H:i:s') . '</p>
            </div>
            <div class="content">
                <h2>Sample Table</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>John Doe</td>
                            <td>john@example.com</td>
                            <td>Active</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Jane Smith</td>
                            <td>jane@example.com</td>
                            <td>Inactive</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </body>
        </html>';
        
        // Use library with custom options
        $this->dompdf_lib
            ->load_html($html)
            ->set_paper('A4', 'landscape')
            ->set_options([
                'defaultFont' => 'Arial',
                'isRemoteEnabled' => true
            ])
            ->render()
            ->stream('custom_document.pdf', false);
    }
    
    /**
     * Save PDF to file
     */
    public function save_file() {
        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <title>Saved PDF</title>
        </head>
        <body>
            <h1>This PDF will be saved to a file</h1>
            <p>Generated on: ' . date('Y-m-d H:i:s') . '</p>
        </body>
        </html>';
        
        $filepath = FCPATH . 'assets/pdfs/saved_document_' . time() . '.pdf';
        
        // Create directory if it doesn't exist
        $dir = dirname($filepath);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        
        // Save PDF to file
        if (save_pdf_to_file($html, $filepath)) {
            echo "PDF saved successfully to: " . $filepath;
        } else {
            echo "Failed to save PDF";
        }
    }
    
    /**
     * Download PDF
     */
    public function download() {
        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <title>Download PDF</title>
        </head>
        <body>
            <h1>This PDF will be downloaded</h1>
            <p>Generated on: ' . date('Y-m-d H:i:s') . '</p>
        </body>
        </html>';
        
        // Force download
        generate_pdf($html, 'download_document.pdf', 'A4', 'portrait', true);
    }
}
