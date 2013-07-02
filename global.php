<?php

error_reporting(E_ALL ^ E_NOTICE);

// credentials etc.
require_once 'inc/config.php';
// mysql handler class
require_once 'inc/classes/MySQL.class.php';
// template engine
require_once 'inc/classes/Smarty-3.1.7/libs/Smarty.class.php';

// functions

require_once 'inc/func/strptime.func.php'; // for windows


// set up connection
$db = new MySQL(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);
// set up template engine
$tpl = new Smarty();
$tpl->setTemplateDir('templates');
$tpl->caching = 0;
$tpl->compile_check = true;
$tpl->force_compile = true;

define('HASH', 'BACON');
session_start();

?>