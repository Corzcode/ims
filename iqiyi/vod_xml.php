<?php
include '../init.php';
$idmap = array(1 => 1, 2 => 2, 3 => 4, 4 => 6);
$videoid = intval($_GET['videoid']);
$videoid = $videoid ? $videoid : 1;
$maptype = $idmap[$videoid];
$url = "http://list.iqiyi.com/www/{$maptype}/----------0---11-1-1-iqiyi--.html";
$content = get_url_contents($url);
preg_match('/<h3>类型：<\/h3>.+<\/ul>/Uis', $content, $matches);
//<a href="/www/1/-8---------0---11-1-1-iqiyi--.html">喜剧</a>
preg_match_all('/<a.+href="\/www\/\d+\/-(\d+)-.+">(.+)<\/a>/Uis', $matches[0], $matches);
$typelist = array();
$typelist = array('0' => '全部');
foreach ($matches[1] as $k => $v) {
	$typelist[$v] = $matches[2][$k];
}
$tpl = Template::getInstance();
$tpl->assign('videoid', $maptype);
$tpl->assign('videos', $maplist[$videoid]);
$tpl->assign('typelist', $typelist);
$tpl->display('vod_xml.html');