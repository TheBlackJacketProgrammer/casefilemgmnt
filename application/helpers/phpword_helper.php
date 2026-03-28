<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * PHPWord helper — same loading pattern as dompdf_helper.
 */

if (!function_exists('load_phpword_bootstrap')) {
	/**
	 * Require PHPWord autoload (bundled + phpoffice/math).
	 *
	 * @return void
	 */
	function load_phpword_bootstrap() {
		static $loaded = false;
		if ($loaded) {
			return;
		}
		$loaded = true;

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
}

if (!function_exists('phpword_new')) {
	/**
	 * @return \PhpOffice\PhpWord\PhpWord
	 */
	function phpword_new() {
		load_phpword_bootstrap();
		return new \PhpOffice\PhpWord\PhpWord();
	}
}

if (!function_exists('phpword_save')) {
	/**
	 * @param \PhpOffice\PhpWord\PhpWord $phpWord
	 * @param string $filepath
	 * @param string $writerName
	 * @return void
	 */
	function phpword_save(\PhpOffice\PhpWord\PhpWord $phpWord, $filepath, $writerName = 'Word2007') {
		load_phpword_bootstrap();
		$writer = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, $writerName);
		$writer->save($filepath);
	}
}

if (!function_exists('phpword_load')) {
	/**
	 * @param string $filepath
	 * @param string $readerName
	 * @return \PhpOffice\PhpWord\PhpWord
	 */
	function phpword_load($filepath, $readerName = 'Word2007') {
		load_phpword_bootstrap();
		return \PhpOffice\PhpWord\IOFactory::load($filepath, $readerName);
	}
}
