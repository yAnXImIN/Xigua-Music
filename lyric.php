<?php
/**
 * Created by PhpStorm.
 * User: yanximin
 * Date: 2018/7/10
 * Time: 下午10:02
 */

require 'Http.php';
header("Content-type: text/html; charset=utf-8");
$songId = $_REQUEST['songid'];
$LyricUrl = "https://c.y.qq.com/lyric/fcgi-bin/fcg_query_lyric_new.fcg?pcachetime=1494070301711&songmid=".$songId."&g_tk=5381&jsonpCallback=MusicJsonCallback_lrc&loginUin=0&hostUin=0&format=json&inCharset=utf8&outCharset=utf-8&ice=0&platform=yqq&needNewCode=0";
$ret = Common_Http::get($LyricUrl, [CURLOPT_REFERER=>'https://y.qq.com/portal/player.html']);
$ret = str_replace('MusicJsonCallback_lrc(', '', $ret);
$ret = str_replace(')', '', $ret);
$ret = json_decode($ret,true);

$data = ['lycContent' => base64_decode($ret['lyric']), 'lycUrl' => 'http://www.xiami.com/song/1772019687', 'wap_lycUrl' => 'http://h.xiami.com/song.html?id=1772019687&ch=255200', 'lycDownload' => 'http://www.xiami.com/song/1772019687'];
$result = ['status' => 0, 'code' => '', 'message' => '', 'data' => $data];
echo json_encode($result);