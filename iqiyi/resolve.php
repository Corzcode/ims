<?php
include '../init.php';
//视频解析地址
//$url = 'http://203.195.187.39/resolve2.php?site=pptv&url=' . $_GET['url'];
$url = 'http://121.199.22.39/blumedia/ims/resolve.php?url='.$_GET['url'];
$content = get_url_contents($url);
echo $content;