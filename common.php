<?php
//http://kptest/tpsystem/
//baza ip 10.160.5.39

if(!defined('DEFAULT_LANG'))
	define('DEFAULT_LANG', 'en');

if(!defined('ROOT_PATH'))
	define('ROOT_PATH', str_replace('\\', '/',dirname(__FILE__)).'/');
if(!defined('CLASS_DIR'))
	define('CLASS_DIR','include/class/');
if(!defined('INCLUDE_DIR'))
	define('INCLUDE_DIR','include/');
if(!defined('TEMPLATE_DIR'))
	define('TEMPLATE_DIR','template/');
if(!defined('FUNCTION_DIR'))
	define('FUNCTION_DIR','include/function/');
if(!defined('IMAGE_DIR'))
	define('IMAGE_DIR','img/');

require_once(ROOT_PATH . CLASS_DIR . 'class.language.php');
require_once(ROOT_PATH . FUNCTION_DIR . 'general_fun.php');
require_once(ROOT_PATH . CLASS_DIR. 'class.db_query.php');

$lang = new language();
$db = new db_query();

if(session_id() == '') {
	session_start();
}

if(isset($_SESSION['id_acc'])) {
	
	$actual_time = calldate();
	$difference = strtotime($actual_time) - strtotime($_SESSION['session_time']);
	
	#session time 30 minutes (1800s)
	if($difference > 1800) {
		require('logout.php');
	} else {
		$_SESSION['session_time'] = $actual_time;
	}

}
