<?php
error_reporting(E_ALL & ~ (E_STRICT | E_NOTICE));
define('ROOT_PATH', __DIR__);
define('APP_PATH', str_replace('/', DIRECTORY_SEPARATOR, dirname($_SERVER['SCRIPT_FILENAME'])));
define('TPL_PATH', __DIR__ . '/tpl');
define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']));
include __DIR__ . '/core/function.php';
include __DIR__ . '/core/template.php';
$maplist = array(1 => 'mov', 2 => 'tvb', 3 => 'show', 4 => 'comic');
Template::getInstance()->assign('site_url', SITE_URL);
//建立UI软链接
/*if (! file_exists(APP_PATH . DIRECTORY_SEPARATOR . 'ui')) {
	if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
		exec('mklink /D "' . APP_PATH . DIRECTORY_SEPARATOR . 'ui" "' . ROOT_PATH . DIRECTORY_SEPARATOR . 'ui"');
	} else {
		;
	}
}*/