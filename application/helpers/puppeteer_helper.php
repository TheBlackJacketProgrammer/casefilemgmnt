<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Puppeteer Helper for CodeIgniter
 * 
 * This helper provides easy integration of Puppeteer with CodeIgniter
 * Requires Node.js and Puppeteer to be installed
 * 
 * Installation:
 * 1. Install Node.js: https://nodejs.org/
 * 2. Install Puppeteer: npm install puppeteer
 * 3. Create a Node.js script for PDF generation
 */

if (!function_exists('generate_pdf_puppeteer')) {
    /**
     * Generate PDF from HTML content using Puppeteer
     * 
     * @param string $html HTML content to convert
     * @param string $filename Output filename
     * @param string $paper_size Paper size (A4, Letter, etc.)
     * @param string $orientation Paper orientation (portrait, landscape)
     * @param bool $download Whether to force download or display in browser
     * @param array $options Additional Puppeteer options
     * @return void
     */
    function generate_pdf_puppeteer($html, $filename = 'document.pdf', $paper_size = 'A4', $orientation = 'portrait', $download = false, $options = []) {
        // Create temporary HTML file
        $temp_html = FCPATH . 'application/cache/temp_' . uniqid() . '.html';
        $temp_pdf = FCPATH . 'application/cache/temp_' . uniqid() . '.pdf';
        
        // Write HTML to temporary file
        file_put_contents($temp_html, $html);
        
        // Default Puppeteer options
        $default_options = [
            'format' => $paper_size,
            'landscape' => $orientation === 'landscape',
            'margin' => [
                'top' => '20px',
                'right' => '20px',
                'bottom' => '20px',
                'left' => '20px'
            ],
            'printBackground' => true,
            'displayHeaderFooter' => false
        ];
        
        // Merge with custom options
        $puppeteer_options = array_merge($default_options, $options);
        
        // Create Node.js script
        $node_script = "
const puppeteer = require('puppeteer');
const fs = require('fs');

(async () => {
    const browser = await puppeteer.launch({
        headless: true,
        args: ['--no-sandbox', '--disable-setuid-sandbox']
    });
    
    const page = await browser.newPage();
    
    // Load HTML file
    await page.goto('file://" . str_replace('\\', '/', $temp_html) . "', {
        waitUntil: 'networkidle0'
    });
    
    // Generate PDF
    const pdf = await page.pdf(" . json_encode($puppeteer_options) . ");
    
    // Save PDF
    fs.writeFileSync('" . str_replace('\\', '/', $temp_pdf) . "', pdf);
    
    await browser.close();
})();
";
        
        // Write Node.js script
        $node_script_file = FCPATH . 'application/cache/puppeteer_script_' . uniqid() . '.js';
        file_put_contents($node_script_file, $node_script);
        
        // Execute Node.js script
        $output = [];
        $return_var = 0;
        exec("node \"$node_script_file\" 2>&1", $output, $return_var);
        
        // Clean up temporary files
        unlink($temp_html);
        unlink($node_script_file);
        
        if ($return_var !== 0) {
            show_error('PDF generation failed: ' . implode("\n", $output));
        }
        
        if (!file_exists($temp_pdf)) {
            show_error('PDF file was not created');
        }
        
        // Set headers
        if ($download) {
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
        } else {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename="' . $filename . '"');
        }
        
        // Output PDF
        readfile($temp_pdf);
        
        // Clean up PDF file
        unlink($temp_pdf);
    }
}

if (!function_exists('generate_pdf_from_view_puppeteer')) {
    /**
     * Generate PDF from CodeIgniter view using Puppeteer
     * 
     * @param string $view_name View name to load
     * @param array $data Data to pass to view
     * @param string $filename Output filename
     * @param string $paper_size Paper size (A4, Letter, etc.)
     * @param string $orientation Paper orientation (portrait, landscape)
     * @param bool $download Whether to force download or display in browser
     * @param array $options Additional Puppeteer options
     * @return void
     */
    function generate_pdf_from_view_puppeteer($view_name, $data = [], $filename = 'document.pdf', $paper_size = 'A4', $orientation = 'portrait', $download = false, $options = []) {
        $CI =& get_instance();
        
        // Load the view and capture output
        $html = $CI->load->view($view_name, $data, TRUE);
        
        // Generate PDF
        generate_pdf_puppeteer($html, $filename, $paper_size, $orientation, $download, $options);
    }
}

if (!function_exists('save_pdf_to_file_puppeteer')) {
    /**
     * Save PDF to file using Puppeteer
     * 
     * @param string $html HTML content to convert
     * @param string $filepath Full path where to save the PDF
     * @param string $paper_size Paper size (A4, Letter, etc.)
     * @param string $orientation Paper orientation (portrait, landscape)
     * @param array $options Additional Puppeteer options
     * @return bool Success status
     */
    function save_pdf_to_file_puppeteer($html, $filepath, $paper_size = 'A4', $orientation = 'portrait', $options = []) {
        // Create temporary HTML file
        $temp_html = FCPATH . 'application/cache/temp_' . uniqid() . '.html';
        
        // Write HTML to temporary file
        file_put_contents($temp_html, $html);
        
        // Default Puppeteer options
        $default_options = [
            'format' => $paper_size,
            'landscape' => $orientation === 'landscape',
            'margin' => [
                'top' => '20px',
                'right' => '20px',
                'bottom' => '20px',
                'left' => '20px'
            ],
            'printBackground' => true,
            'displayHeaderFooter' => false
        ];
        
        // Merge with custom options
        $puppeteer_options = array_merge($default_options, $options);
        
        // Create Node.js script
        $node_script = "
const puppeteer = require('puppeteer');
const fs = require('fs');

(async () => {
    const browser = await puppeteer.launch({
        headless: true,
        args: ['--no-sandbox', '--disable-setuid-sandbox']
    });
    
    const page = await browser.newPage();
    
    // Load HTML file
    await page.goto('file://" . str_replace('\\', '/', $temp_html) . "', {
        waitUntil: 'networkidle0'
    });
    
    // Generate PDF
    const pdf = await page.pdf(" . json_encode($puppeteer_options) . ");
    
    // Save PDF
    fs.writeFileSync('" . str_replace('\\', '/', $filepath) . "', pdf);
    
    await browser.close();
})();
";
        
        // Write Node.js script
        $node_script_file = FCPATH . 'application/cache/puppeteer_script_' . uniqid() . '.js';
        file_put_contents($node_script_file, $node_script);
        
        // Execute Node.js script
        $output = [];
        $return_var = 0;
        exec("node \"$node_script_file\" 2>&1", $output, $return_var);
        
        // Clean up temporary files
        unlink($temp_html);
        unlink($node_script_file);
        
        return $return_var === 0 && file_exists($filepath);
    }
}

