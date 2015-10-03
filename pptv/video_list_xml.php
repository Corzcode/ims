<?php
include '../init.php';
$videoid = intval($_GET['video']);
$videoid = $videoid ? $videoid : 1;
$page = intval($_GET['pn']);
$page = $page ? $page : 1;
if (empty($_GET['key'])) {
	$type = intval($_GET['type']);
	$type = $type ? $type : 1;
	function getlist ($type, $page) {
		$url = "http://list.pptv.com/channel_list.html?page={$page}&type={$type}&sort=6";
		$content = get_url_contents($url, 'http://list.pptv.com/');
		preg_match_all('/<a class="ui-list-ct".+href=\'(.+)\?.+\'.+title="(.+)".+<img.+data-src2="(.+)"/Uis', $content, $matches);
		$list = array();
		foreach ($matches[2] as $k => $v) {
			$list[] = array(
				'title' => $v, 
				'id' => get_encode($matches[1][$k]), 
				'pic' => $matches[3][$k], 
				'actor' => '主演', 
				'director' => '导演', 
				'area' => '地方', 
				'year' => '2015');
		}
		return $list;
	}
	//处理分页不同量
	$shownum = 10;
	$webnum = 42;
	$startnum = $page * $shownum - $shownum;
	$endnum = $page * $shownum;
	$qp = ceil($startnum / $webnum);
	$qp = $qp ? $qp : 1;
	$qpcount = $qp * $webnum;
	$list = getlist($type, $qp);
	if ($endnum > $qpcount) {
		$y = $endnum % $webnum;
		$m = $shownum - $y;
		$list = array_values(array_slice($list, $m * - 1, $m));
		$t = array_slice(getlist($type, $qp + 1), 0, $y);
		foreach ($t as $value) {
			$list[] = $value;
		}
	} else {
		$y = $endnum % $webnum;
		$list = array_slice($list, $y - $shownum, $shownum);
	}
} else {
	//搜索
	$key = urlencode($_GET['key']);
	$url = "http://searchapi.pptv.com/query/nt?cb=recSearchData&q={$key}";
	$content = get_url_contents($url, 'http://www.pptv.com/');
	$content = substr($content, strpos($content, '(') + 1, - 1);
	$json = json_decode($content, true);
	$list = array();
	foreach ($json[1] as $value) {
		$list[] = array(
			'title' => $value['name'], 
			'id' => get_encode("http://v.pptv.com/redirect/{$value['vt']}/{$value['channelId']}/0"), 
			'pic' => "http://img6.pplive.cn/sp75/{$value['picUrl']}", 
			'actor' => '主演', 
			'director' => '导演', 
			'area' => '地方', 
			'year' => $value['years']);
	}
}
$tpl = Template::getInstance();
$tpl->assign('videoid', $videoid);
$tpl->assign('videos', $maplist[$videoid]);
$tpl->assign('list', $list);
$tpl->display('video_list_xml.html');