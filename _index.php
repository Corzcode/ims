<?php
//本程序只用来抓取蓝苺的界面
function get_url_contents ($url, $src = '', $gzip = false) {
	//if (ini_get("allow_url_fopen") == "1" && empty($src) && ! $gzip) return file_get_contents($url);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0; Trident/4.0)');
	if (! empty($src)) curl_setopt($ch, CURLOPT_REFERER, $src);
	if ($gzip) curl_setopt($ch, CURLOPT_ENCODING, "gzip");
	//curl_setopt($ch, CURLOPT_HEADER, true);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_TIMEOUT, 15);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	//if (! empty($this->proxy)) curl_setopt($ch, CURLOPT_PROXY, $this->proxy);
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;
}
$url = 'http://121.199.22.39/blumedia/ims/';
$content = get_url_contents($url . substr($_SERVER['REQUEST_URI'], 5));
/*file_put_contents('catch/' . str_replace(array('/', '?'), array('_', '!'), substr($_SERVER['REQUEST_URI'], 5)), 
print_r($_SERVER, true) . $content);*/
$header = str_replace("\n", "\r\n", print_r($_SERVER, true));
file_put_contents('catch/' . str_replace(array('/', '?'), array('_', '!'), substr($_SERVER['PATH_INFO'], 1)), $header . $content);
$pos = strpos($content, '<');
//$content = $pos ? substr($content, $pos) : $content;
echo str_replace(array($url), array('http://192.168.1.254/ims/'), $content);