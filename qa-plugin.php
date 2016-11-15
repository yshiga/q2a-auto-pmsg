<?php

/*
	Plugin Name: Auto PMSG
	Plugin URI: 
	Plugin Description: Automatically send direct message from administrator
	Plugin Version: 1.0
	Plugin Date: 2016-11-15
	Plugin Author: 38qa.net
	Plugin Author URI: http://38qa.net/
	Plugin License: GPLv2
	Plugin Minimum Question2Answer Version: 1.7
	Plugin Update Check URI:
*/

if (!defined('QA_VERSION')) { // don't allow this page to be requested directly from browser
	header('Location: ../../');
	exit;
}

// language
qa_register_plugin_phrases('qa-auto-pmsg-lang-*.php', 'qa_apmsg_lang');
// admin
qa_register_plugin_module('module', 'qa-auto-pmsg-admin.php', 'qa_auto_pmsg_admin', 'Auto PMSG Admin');
