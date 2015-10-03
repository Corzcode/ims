<?php
include '../init.php';
$videoid = intval($_GET['video']);
$videoid = $videoid ? $videoid : 1;
$page = intval($_GET['pn']);
$page = $page ? $page : 1;
if (empty($_GET['key'])) {
	$type = intval($_GET['type']);
	$type = $type ? $type : 1;
	function getlist ($type, $cate, $page) {
		$url = "http://list.iqiyi.com/www/{$type}/-{$cate}---------0---11-{$page}-1-iqiyi--.html";
		//$url = "http://list.pptv.com/channel_list.html?page={$page}&type={$type}&sort=6";
		$content = get_url_contents($url, 'http://list.iqiyi.com/');
		//<ul class="site-piclist site-piclist-180236 site-piclist-auto">
		preg_match('/<ul class="site-piclist site-piclist-180236 site-piclist-auto">.+<\/ul>/Uis', $content, $matche);
		preg_match_all('/<li>.+<a.+title="(.+)".+href="(.*)".+class="site-piclist_pic_link".+<img.+rseat=".+".+src = "(.+)".+\/>.+<\/li>/Uis', $matche[0], 
		$matches);
		$list = array();
		foreach ($matches[1] as $k => $v) {
			$list[] = array(
				'title' => $v, 
				'id' => get_encode($matches[2][$k]), 
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
	$webnum = 30;
	$startnum = $page * $shownum - $shownum;
	$endnum = $page * $shownum;
	$qp = ceil($startnum / $webnum);
	$qp = $qp ? $qp : 1;
	$qpcount = $qp * $webnum;
	$list = getlist($videoid, $type, $qp);
	if ($endnum > $qpcount) {
		$y = $endnum % $webnum;
		$m = $shownum - $y;
		$list = array_values(array_slice($list, $m * - 1, $m));
		$t = array_slice(getlist($videoid, $type, $qp + 1), 0, $y);
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
	$url = "http://suggest.video.iqiyi.com/?key={$key}";
	$content = get_url_contents($url, 'http://www.iqiyi.com/');
	//$content = substr($content, strpos($content, '(') + 1, - 1);
	$json = json_decode($content, true);
	$list = array();
	foreach ($json['data'] as $value) {
		empty($value['aid']) || $list[] = array(
			'title' => $value['name'], 
			'id' => get_encode($value['link']), 
			'pic' => $value['picture_url'], 
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