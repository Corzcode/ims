<?php
include '../init.php';
$id = $_GET['id'];
$url = get_decode($id);
$content = get_url_contents($url);
preg_match_all('/data-delegate="albumlist-page" data-avlist-page="\d+".+>(.+)<\/a>/Uis', $content, $page);
$list = array('IQIYI' => array('播放' => $url));
if (! empty($page[1])) {
	preg_match('/Q\.PageInfo\.playPageInfo = {.+albumId:\s(\d+),.+};/Uis', $content, $matches);
	$index = count($page[1]) / 2;
	$list = array();
	for ($i = 1; $i <= $index; $i ++) {
		$url = "http://cache.video.qiyi.com/jp/avlist/{$matches[1]}/{$i}/50/?albumId={$matches[1]}&pageNum=50&pageNo={$i}&callback=";
		$json = get_url_contents($url);
		$json = substr($json, strpos($json, '=') + 1);
		$json = trim($json, ' ');
		$data = json_decode($json, true);
		if (is_array($data)) {
			foreach ($data['data']['vlist'] as $key => $value) {
				$pkey = $page[1][$i - 1];
				$key = '第' . $value['pd'] . '集';
				$list[$pkey][$key] = $value['vurl'];
			}
		}
	}
}
$tpl = Template::getInstance();
$tpl->assign('list', $list);
$tpl->assign('player', 'iqiyi.com');
$tpl->display('get_sites.html');