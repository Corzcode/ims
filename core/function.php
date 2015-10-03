<?php
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
function get_encode ($string) {
	return strtr(base64_encode(addslashes(gzcompress(serialize($string), 9))), '+/=', '-_,');
}
function get_decode ($encoded) {
	return unserialize(gzuncompress(stripslashes(base64_decode(strtr($encoded, '-_,', '+/=')))));
}