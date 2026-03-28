<?php
/**
 * Load PHPWord from application/third_party/PHPWord and phpoffice/math from this folder's vendor/.
 * Mirrors application/third_party/dompdf/autoload.inc.php pattern.
 */

$phpwordBridgeDir = __DIR__;

if (is_file($phpwordBridgeDir . '/vendor/autoload.php')) {
	require_once $phpwordBridgeDir . '/vendor/autoload.php';
}

$phpWordAutoloader = dirname($phpwordBridgeDir) . DIRECTORY_SEPARATOR . 'PHPWord' . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'PhpWord' . DIRECTORY_SEPARATOR . 'Autoloader.php';

if (!is_file($phpWordAutoloader)) {
	if (function_exists('show_error')) {
		show_error('PHPWord not found. Expected: application/third_party/PHPWord/ (PHPOffice PHPWord source).');
	}
	trigger_error('PHPWord Autoloader.php missing at ' . $phpWordAutoloader, E_USER_ERROR);
}

require_once $phpWordAutoloader;

PhpOffice\PhpWord\Autoloader::register();
