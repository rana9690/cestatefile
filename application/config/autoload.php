<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$autoload['packages'] = array();
$autoload['libraries'] = array('database', 'email', 'session', 'form_validation','throttle','zip','MY_Form_validation','PHPMailer','SMTP','PhpmailerException');
$autoload['drivers'] = array();
$autoload['helper'] = array('form', 'url', 'file', 'text', 'date','download','string','captcha','efiling');
$autoload['config'] = array();
$autoload['language'] = array('en');
$autoload['model'] = array();
