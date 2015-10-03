<?php
include '../init.php';
$idmap = array(1 => 1, 2 => 2, 3 => 3, 4 => 4);
$videoid = intval($_GET['videoid']);
$videoid = $videoid ? $videoid : 1;
$maptype = $idmap[$videoid];
$url = 'http://list.pptv.com/?type=' . $maptype;
$content = get_url_contents($url);
preg_match('/<dt>按分类：.+<dt>按地区：/Uis', $content, $matches);
preg_match_all('/<a.+href=".+\?type=(\d+)&.+".+title="(.+)"/Uis', $matches[0], $matches);
$typelist = array_combine($matches[1], $matches[2]);
$tpl = Template::getInstance();
$tpl->assign('videoid', $maptype);
$tpl->assign('videos', $maplist[$videoid]);
$tpl->assign('typelist', $typelist);
$tpl->display('vod_xml.html');