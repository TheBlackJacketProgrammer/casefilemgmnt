<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * DomPDF Library for CodeIgniter
 * 
 * This library provides easy integration of DomPDF with CodeIgniter
 * Make sure to install DomPDF via Composer or manually include the library
 */

class Dompdf_lib {
    
    private $dompdf;
    private $CI;
    
    public function __construct($config = []) {
        $this->CI =& get_instance();
        
        // Load DomPDF
        $this->load_dompdf();
        
        // Initialize DomPDF
        $this->dompdf = new \Dompdf\Dompdf();
        
        // Set default options
        $this->set_default_options($config);
    }
    
    /**
     * Load DomPDF library
     */
    private function load_dompdf() {
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
    }
    
    /**
     * Set default options
     */
    private function set_default_options($config) {
        $defaults = [
            'paper_size' => 'A4',
            'orientation' => 'portrait',
            'default_font' => 'Arial'
        ];
        
        $options = array_merge($defaults, $config);
        
        // Set paper size and orientation
        $this->dompdf->setPaper($options['paper_size'], $options['orientation']);
        
        // Set default font if specified
        if (isset($options['default_font'])) {
            $this->dompdf->getOptions()->setDefaultFont($options['default_font']);
        }
    }
    
    /**
     * Load HTML content
     * 
     * @param string $html HTML content
     * @return object $this
     */
    public function load_html($html) {
        $this->dompdf->loadHtml($html);
        return $this;
    }
    
    /**
     * Load HTML from file
     * 
     * @param string $filepath Path to HTML file
     * @return object $this
     */
    public function load_html_file($filepath) {
        $html = file_get_contents($filepath);
        $this->dompdf->loadHtml($html);
        return $this;
    }
    
    /**
     * Set paper size and orientation
     * 
     * @param string $paper_size Paper size (A4, Letter, etc.)
     * @param string $orientation Paper orientation (portrait, landscape)
     * @return object $this
     */
    public function set_paper($paper_size, $orientation = 'portrait') {
        $this->dompdf->setPaper($paper_size, $orientation);
        return $this;
    }
    
    /**
     * Set options
     * 
     * @param array $options DomPDF options
     * @return object $this
     */
    public function set_options($options) {
        $this->dompdf->getOptions()->set($options);
        return $this;
    }
    
    /**
     * Render PDF
     * 
     * @return object $this
     */
    public function render() {
        $this->dompdf->render();
        return $this;
    }
    
    /**
     * Output PDF to browser
     * 
     * @param string $filename Output filename
     * @param bool $download Whether to force download
     * @return void
     */
    public function stream($filename = 'document.pdf', $download = false) {
        $this->dompdf->stream($filename, ['Attachment' => $download]);
    }
    
    /**
     * Get PDF output as string
     * 
     * @return string PDF output
     */
    public function output() {
        return $this->dompdf->output();
    }
    
    /**
     * Save PDF to file
     * 
     * @param string $filepath Full path where to save the PDF
     * @return bool Success status
     */
    public function save($filepath) {
        $output = $this->output();
        return file_put_contents($filepath, $output) !== false;
    }
    
    /**
     * Generate PDF from view
     * 
     * @param string $view_name View name to load
     * @param array $data Data to pass to view
     * @param string $filename Output filename
     * @param bool $download Whether to force download
     * @return void
     */
    public function from_view($view_name, $data = [], $filename = 'document.pdf', $download = false) {
        // Load the view and capture output
        $html = $this->CI->load->view($view_name, $data, TRUE);
        
        // Load HTML and render
        $this->load_html($html)->render();
        
        // Output PDF
        $this->stream($filename, $download);
    }
    
    /**
     * Get DomPDF instance for advanced usage
     * 
     * @return object DomPDF instance
     */
    public function get_dompdf() {
        return $this->dompdf;
    }
}
