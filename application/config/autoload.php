<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$autoload['packages'] = array();

$autoload['libraries'] = array('database','email','session','parser','upload');

$autoload['drivers'] = array();

$autoload['helper'] = array('html','date','url','file','form','download');

$autoload['config'] = array();

$autoload['language'] = array();

$autoload['model'] = array('Model_Main', 'Model_Api');