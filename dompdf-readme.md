# DomPDF Integration for CodeIgniter

This project includes DomPDF integration for generating PDF documents from HTML content in CodeIgniter.

## Installation

### Method 1: Using Composer (Recommended)

1. Make sure Composer is installed on your system
2. Run the following command in your project root:
   ```bash
   composer install
   ```

### Method 2: Manual Installation

If Composer installation fails due to permission issues:

1. Download DomPDF from: https://github.com/dompdf/dompdf/releases
2. Extract the files to `application/third_party/dompdf/`
3. The helper and library will automatically detect the manual installation

## Files Added

- `application/helpers/dompdf_helper.php` - Helper functions for easy PDF generation
- `application/libraries/Dompdf_lib.php` - CodeIgniter library for DomPDF
- `application/controllers/Ctrl_Pdf.php` - Sample controller demonstrating usage
- `application/views/pdf/sample_pdf.php` - Sample PDF view template

## Usage

### Using Helper Functions

```php
// Load the helper
$this->load->helper('dompdf');

// Generate PDF from HTML string
$html = '<h1>Hello World!</h1>';
generate_pdf($html, 'document.pdf');

// Generate PDF from view
$data = ['title' => 'My PDF', 'content' => 'PDF content'];
generate_pdf_from_view('pdf/sample_pdf', $data, 'view_document.pdf');

// Save PDF to file
save_pdf_to_file($html, '/path/to/save/document.pdf');
```

### Using Library

```php
// Load the library
$this->load->library('dompdf_lib');

// Basic usage
$this->dompdf_lib
    ->load_html('<h1>Hello World!</h1>')
    ->render()
    ->stream('document.pdf');

// Advanced usage with options
$this->dompdf_lib
    ->load_html($html)
    ->set_paper('A4', 'landscape')
    ->set_options(['defaultFont' => 'Arial'])
    ->render()
    ->stream('custom_document.pdf', true); // true = force download
```

### Using Controller Methods

Access these URLs to test the integration:

- `http://your-domain/ctrl_pdf/simple` - Generate a simple PDF
- `http://your-domain/ctrl_pdf/from_view` - Generate PDF from view
- `http://your-domain/ctrl_pdf/custom` - Generate PDF with custom options
- `http://your-domain/ctrl_pdf/save_file` - Save PDF to file
- `http://your-domain/ctrl_pdf/download` - Force download PDF

## Configuration

### Paper Sizes
- A4, A3, A2, A1, A0
- Letter, Legal, Tabloid
- Custom sizes: [width, height] in points

### Orientations
- portrait
- landscape

### Common Options
```php
$options = [
    'defaultFont' => 'Arial',
    'isRemoteEnabled' => true,  // Allow remote images/CSS
    'isHtml5ParserEnabled' => true,
    'isPhpEnabled' => false,    // Security: disable PHP in HTML
    'debugPng' => false,
    'debugKeepTemp' => false,
    'debugCss' => false
];
```

## Troubleshooting

### Common Issues

1. **Permission Errors**: Make sure the web server has write permissions to the project directory
2. **Font Issues**: DomPDF includes basic fonts. For custom fonts, place them in the DomPDF fonts directory
3. **CSS Issues**: Some CSS properties may not be supported. Test your HTML/CSS in a browser first
4. **Memory Issues**: For large documents, increase PHP memory limit in php.ini

### Debug Mode

Enable debug mode to see detailed error messages:
```php
$options = [
    'debugPng' => true,
    'debugKeepTemp' => true,
    'debugCss' => true
];
```

## Examples

### Generate Report PDF
```php
public function generate_report() {
    $this->load->helper('dompdf');
    
    $data = [
        'report_title' => 'Monthly Report',
        'report_data' => $this->get_report_data(),
        'generated_date' => date('Y-m-d H:i:s')
    ];
    
    generate_pdf_from_view('reports/monthly_report', $data, 'monthly_report.pdf');
}
```

### Generate Invoice PDF
```php
public function generate_invoice($invoice_id) {
    $this->load->library('dompdf_lib');
    
    $invoice_data = $this->get_invoice_data($invoice_id);
    
    $this->dompdf_lib
        ->from_view('invoices/invoice_template', $invoice_data, 'invoice_' . $invoice_id . '.pdf')
        ->set_paper('A4', 'portrait');
}
```

## Support

For more information about DomPDF, visit: https://github.com/dompdf/dompdf

For CodeIgniter documentation, visit: https://codeigniter.com/user_guide/
