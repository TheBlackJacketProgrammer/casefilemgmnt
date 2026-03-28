<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * PHPWord library wrapper for CodeIgniter
 *
 * Bundled source: application/third_party/PHPWord/
 * Dependencies: run composer install in application/third_party/phpword/
 */
class Phpword_lib {

	/** @var \PhpOffice\PhpWord\PhpWord */
	private $phpword;

	private $CI;

	public function __construct($config = []) {
		$this->CI =& get_instance();
		$this->load_phpword();
		$this->phpword = new \PhpOffice\PhpWord\PhpWord();

		if (!empty($config) && is_array($config)) {
			$this->apply_config($config);
		}
	}

	/**
	 * Load PHPWord (and phpoffice/math when installed via Composer in third_party/phpword).
	 */
	private function load_phpword() {
		if (file_exists(FCPATH . 'vendor/autoload.php')) {
			require_once FCPATH . 'vendor/autoload.php';
		}

		$bootstrap = FCPATH . 'application/third_party/phpword/autoload.inc.php';
		if (file_exists($bootstrap)) {
			require_once $bootstrap;
			return;
		}

		show_error('PHPWord bootstrap not found. Expected application/third_party/phpword/autoload.inc.php');
	}

	/**
	 * Optional defaults (extend as needed).
	 *
	 * @param array $config
	 */
	private function apply_config($config) {
		if (!empty($config['default_font_name']) && !empty($config['default_font_size'])) {
			$this->phpword->setDefaultFontName($config['default_font_name']);
			$this->phpword->setDefaultFontSize((int) $config['default_font_size']);
		}
	}

	/**
	 * @return \PhpOffice\PhpWord\PhpWord
	 */
	public function get_phpword() {
		return $this->phpword;
	}

	/**
	 * Replace the in-memory document (e.g. after loading a file).
	 *
	 * @param \PhpOffice\PhpWord\PhpWord $phpword
	 * @return $this
	 */
	public function set_phpword(\PhpOffice\PhpWord\PhpWord $phpword) {
		$this->phpword = $phpword;
		return $this;
	}

	/**
	 * Load an existing document from disk.
	 *
	 * @param string $filepath
	 * @param string $readerName Word2007, ODText, RTF, MsDoc, HTML, …
	 * @return $this
	 */
	public function load_file($filepath, $readerName = 'Word2007') {
		$this->phpword = \PhpOffice\PhpWord\IOFactory::load($filepath, $readerName);
		return $this;
	}

	/**
	 * Save the current document.
	 *
	 * @param string $filepath
	 * @param string $writerName Word2007, ODText, RTF, HTML, PDF, …
	 * @return $this
	 */
	public function save($filepath, $writerName = 'Word2007') {
		$writer = \PhpOffice\PhpWord\IOFactory::createWriter($this->phpword, $writerName);
		$writer->save($filepath);
		return $this;
	}

	/**
	 * Save to a temp file and send to the browser (same idea as Dompdf stream()).
	 *
	 * @param string $filename Suggested download filename
	 * @param string $writerName
	 * @return void
	 */
	public function stream($filename = 'document.docx', $writerName = 'Word2007') {
		$extMap = [
			'Word2007' => '.docx',
			'ODText' => '.odt',
			'RTF' => '.rtf',
			'HTML' => '.html',
		];
		$ext = isset($extMap[$writerName]) ? $extMap[$writerName] : '.tmp';
		$out = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'phpword_' . uniqid('', true) . $ext;

		$this->save($out, $writerName);

		$this->CI->load->helper('download');
		force_download($filename, file_get_contents($out));

		if (is_file($out)) {
			@unlink($out);
		}
	}

	/**
	 * Render a view as HTML into a new section, then stream the document (Dompdf from_view pattern).
	 *
	 * @param string $view_name
	 * @param array $data
	 * @param string $filename
	 * @param bool $download Unused for Office formats (CI force_download is always attachment); kept for API parity with dompdf_lib
	 * @param string $writerName
	 * @return void
	 */
	public function from_view($view_name, $data = [], $filename = 'document.docx', $download = false, $writerName = 'Word2007') {
		$html = $this->CI->load->view($view_name, $data, true);
		$section = $this->phpword->addSection();
		\PhpOffice\PhpWord\Shared\Html::addHtml($section, $html, false, false);
		$this->stream($filename, $writerName);
	}
}
