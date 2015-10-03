<?php
include '../init.php';
$py = $_GET['pinyin'];
$url = "http://tip.soku.com/search_tip_1?jsoncallback=&query=$py&site=14";
$content = get_url_contents($url);
$content = json_decode($content, true);
$list = array();
foreach ($content['r'] as $value) {
	$list[] = $value['w'];
}
$tpl = Template::getInstance();
$tpl->assign('list', $list);
$tpl->display('search.html');