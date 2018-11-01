<?php
/**
 * Created by PhpStorm.
 * User: yanximin
 * Date: 2018/7/4
 * Time: 下午9:03
 */

require 'Http.php';
$topMusicUrl = "https://c.y.qq.com/lyric/fcgi-bin/fcg_query_lyric_new.fcg?pcachetime=1494070301711&songmid=000Mx3v34Y6R45&g_tk=5381&jsonpCallback=MusicJsonCallback_lrc&loginUin=0&hostUin=0&format=json&inCharset=utf8&outCharset=utf-8&ice=0&platform=yqq&needNewCode=0";
$ret = Common_Http::get($topMusicUrl, [CURLOPT_REFERER=>'https://y.qq.com/portal/player.html']);
$ret = str_replace('MusicJsonCallback_lrc(', '', $ret);
$ret = str_replace(')', '', $ret);
$ret = json_decode($ret,true);
echo base64_decode($ret['lyric']);