<?php
include '../init.php';
$id = $_GET['id'];
$url = get_decode($id);
$content = get_url_contents($url);
preg_match('/var webcfg \=.+"pid":(\d+),.+"cat_id":(\d+),.+"share_content"/Uis', $content, $matches);
//var webcfg = {"id":18735751,"id_encode":"h6MhngZs3Bp9ib2M","pid":0
$list = array('PPTV' => array('播放' => $url));
if (! empty($matches[1])) {
	$jurl = "http://v.pptv.com/show/videoList?&cb=videoList&pid={$matches[1]}&page=1&pageSize=99999&cat_id={$matches[2]}&maxPage=&autoType=&highligh";
	$content = get_url_contents($jurl, $url);
	$content = substr($content, strpos($content, '(') + 1);
	$content = trim($content, '; )');
	$data = json_decode($content, true);
	if (is_array($data)) {
		$list = array();
		foreach ($data['data']['list'] as $key => $value) {
			$pkey = '第' . (floor($key / 50) + 1) . '页';
			$list[$pkey][$value['epTitle']] = $value['url'];
		}
	}
}
$tpl = Template::getInstance();
$tpl->assign('list', $list);
$tpl->assign('player', 'pptv.com');
$tpl->display('get_sites.html');