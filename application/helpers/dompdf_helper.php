<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * DomPDF Helper for CodeIgniter
 * 
 * This helper provides easy integration of DomPDF with CodeIgniter
 * Make sure to install DomPDF via Composer or manually include the library
 */

if (!function_exists('load_dompdf')) {
    /**
     * Load DomPDF library
     * 
     * @return object DomPDF instance
     */
    function load_dompdf() {
        // Check if Composer autoloader exists
        if (file_exists(FCPATH . 'vendor/autoload.php')) {
            require_once FCPATH . 'vendor/autoload.php';
        } else {
            // Fallback: try to include DomPDF manually
            $dompdf_path = FCPATH . 'application/third_party/dompdf/';
            if (file_exists($dompdf_path . 'autoload.inc.php')) {
                require_once $dompdf_path . 'autoload.inc.php';
            } else {
                show_error('DomPDF library not found. Please install via Composer or download manually.');
            }
        }
        
        return new \Dompdf\Dompdf();
    }
}

if (!function_exists('generate_pdf')) {
    /**
     * Generate PDF from HTML content
     * 
     * @param string $html HTML content to convert
     * @param string $filename Output filename
     * @param string $paper_size Paper size (A4, Letter, etc.)
     * @param string $orientation Paper orientation (portrait, landscape)
     * @param bool $download Whether to force download or display in browser
     * @return void
     */
    function generate_pdf($html, $filename = 'document.pdf', $paper_size = 'A4', $orientation = 'portrait', $download = false) {
        $dompdf = load_dompdf();
        
        // Load HTML content
        $dompdf->loadHtml($html);
        
        // Set paper size and orientation
        $dompdf->setPaper($paper_size, $orientation);
        
        // Render the HTML as PDF
        $dompdf->render();
        
        // Output the generated PDF
        $dompdf->stream($filename, ['Attachment' => $download]);
    }
}

if (!function_exists('generate_pdf_from_view')) {
    /**
     * Generate PDF from CodeIgniter view
     * 
     * @param string $view_name View name to load
     * @param array $data Data to pass to view
     * @param string $filename Output filename
     * @param string $paper_size Paper size (A4, Letter, etc.)
     * @param string $orientation Paper orientation (portrait, landscape)
     * @param bool $download Whether to force download or display in browser
     * @return void
     */
    function generate_pdf_from_view($view_name, $data = [], $filename = 'document.pdf', $paper_size = 'A4', $orientation = 'portrait', $download = false) {
        $CI =& get_instance();
        
        // Load the view and capture output
        $html = $CI->load->view($view_name, $data, TRUE);
        
        // Generate PDF
        generate_pdf($html, $filename, $paper_size, $orientation, $download);
    }
}

if (!function_exists('save_pdf_to_file')) {
    /**
     * Save PDF to file instead of outputting to browser
     * 
     * @param string $html HTML content to convert
     * @param string $filepath Full path where to save the PDF
     * @param string $paper_size Paper size (A4, Letter, etc.)
     * @param string $orientation Paper orientation (portrait, landscape)
     * @return bool Success status
     */
    function save_pdf_to_file($html, $filepath, $paper_size = 'A4', $orientation = 'portrait') {
        $dompdf = load_dompdf();
        
        // Load HTML content
        $dompdf->loadHtml($html);
        
        // Set paper size and orientation
        $dompdf->setPaper($paper_size, $orientation);
        
        // Render the HTML as PDF
        $dompdf->render();
        
        // Get PDF output
        $output = $dompdf->output();
        
        // Save to file
        return file_put_contents($filepath, $output) !== false;
    }
}

if (!function_exists('get_pdf_output')) {
    /**
     * Get PDF output as string
     * 
     * @param string $html HTML content to convert
     * @param string $paper_size Paper size (A4, Letter, etc.)
     * @param string $orientation Paper orientation (portrait, landscape)
     * @return string PDF output as binary string
     */
    function get_pdf_output($html, $paper_size = 'A4', $orientation = 'portrait') {
        $dompdf = load_dompdf();
        
        // Load HTML content
        $dompdf->loadHtml($html);
        
        // Set paper size and orientation
        $dompdf->setPaper($paper_size, $orientation);
        
        // Render the HTML as PDF
        $dompdf->render();
        
        // Return PDF output
        return $dompdf->output();
    }
}
