<?php
/**
 * Created by PhpStorm.
 * User: yanximin
 * Date: 2018/7/4
 * Time: 下午9:30
 */

require 'vendor/autoload.php';
use \Baidu\Duer\Botsdk\Directive\AudioPlayer\Play;
require 'Http.php';


class Bot extends Baidu\Duer\Botsdk\Bot
{
    public function __construct($postData = []){
        parent::__construct($postData);
        //搜索
        $this->addIntentHandler('com.yanximin.search', function(){
            $musicName = json_decode($this->getSlot('sys.music'),true);
            $musicName = $musicName['music'];
            $ret = json_decode(
                Common_Http::get('https://c.y.qq.com/soso/fcgi-bin/search_for_qq_cp?g_tk=5381&uin=0&format=json&inCharset=utf-8&outCharset=utf-8&notice=0&platform=h5&needNewCode=1&w='.$musicName.
                    '&zhidaqu=1&catZhida=1&t=0&flag=1&ie=utf-8&sem=1&aggr=0&perpage=20&n=20&p=1&remoteplace=txt.mqq.all&_=1520833663464'),true);
            $musicUrl = 'http://ws.stream.qqmusic.qq.com/C100'.$ret['data']['song']['list'][0]['songmid'].'.m4a?fromtag=0&guid=126548448';

            $singer = $ret['data']['song']['list'][0]['singer'][0]['name'];
            $song = $ret['data']['song']['list'][0]['songname'];

            $albumname = $ret['data']['song']['list'][0]['albumname'];
            $albumid = $ret['data']['song']['list'][0]['albumid'];
            $albumImg = "http://imgcache.qq.com/music/photo/album_300/" . $albumid%100 . "/300_albumpic_" . $albumid . "_0.jpg";
            $playInfo = new \Baidu\Duer\Botsdk\Directive\AudioPlayer\PlayerInfo();
            $playInfo -> setTitle($song);
            $playInfo -> setTitleSubtext1($singer);
            $playInfo -> setTitleSubtext2($albumname);
            $playInfo -> setArt($albumImg);
            $playInfo -> setLyric('http://yanximin.gz01.bdysite.com/lyric.php?songid='.$ret['data']['song']['list'][0]['songmid']);
            $lyricButton = new \Baidu\Duer\Botsdk\Directive\AudioPlayer\Control\LyricButton();
            $lyricButton -> setEnabled(true);
            $lyricButton -> setSelected(true);
            $playInfo -> addControl($lyricButton);
            $directive = new Play($musicUrl, Play::REPLACE_ALL);
            $directive ->setPlayerInfo($playInfo);

            return [
                'directives' => [$directive],
                'outputSpeech' => '西瓜音乐正在播放：'.$musicName,
            ];
        });
        //播放热门歌曲
        $this->addIntentHandler('com.yanximin.toplist', function(){
            $topMusicUrl = 'http://c.y.qq.com/v8/fcg-bin/fcg_v8_toplist_cp.fcg?g_tk=5381&uin=0&format=json&inCharset=utf-8&outCharset=utf-8&notice=0'.
                '&platform=h5&needNewCode=1&tpl=3&page=detail&type=top&topid=26&_=1530710420453';
            $ret = json_decode(Common_Http::get($topMusicUrl),true);
            $songs = $ret['songlist'];
            $index = rand(0,count($songs));
            $musicUrl = 'http://ws.stream.qqmusic.qq.com/C100'.$songs[$index]['data']['songmid'].'.m4a?fromtag=0&guid=126548448';
            $singer = $songs[$index]['data']['singer'][0]['name'];
            $song = $songs[$index]['data']['songname'];

            $albumname = $songs[$index]['data']['albumname'];
            $albumid = $songs[$index]['data']['albumid'];
            $albumImg = "http://imgcache.qq.com/music/photo/album_300/" . $albumid%100 . "/300_albumpic_" . $albumid . "_0.jpg";
            $playInfo = new \Baidu\Duer\Botsdk\Directive\AudioPlayer\PlayerInfo();
            $playInfo -> setTitle($song);
            $playInfo -> setTitleSubtext1($singer);
            $playInfo -> setTitleSubtext2($albumname);
            $playInfo -> setArt($albumImg);
            $playInfo -> setLyric('http://yanximin.gz01.bdysite.com/lyric.php?songid='.$songs[$index]['data']['songmid']);
            $lyricButton = new \Baidu\Duer\Botsdk\Directive\AudioPlayer\Control\LyricButton();
            $lyricButton -> setEnabled(true);
            $lyricButton -> setSelected(true);
            $playInfo -> addControl($lyricButton);

            $directive = new Play($musicUrl, Play::REPLACE_ALL);

            $directive -> setPlayerInfo($playInfo);
            return [
                'directives' => [$directive],
                'outputSpeech' => '西瓜音乐为您播放：'.$singer.'的'.$song,
            ];
        });

        //下一首
        $this->addIntentHandler('ai.dueros.common.next_intent', function(){
            $topMusicUrl = 'http://c.y.qq.com/v8/fcg-bin/fcg_v8_toplist_cp.fcg?g_tk=5381&uin=0&format=json&inCharset=utf-8&outCharset=utf-8&notice=0'.
                '&platform=h5&needNewCode=1&tpl=3&page=detail&type=top&topid=26&_=1530710420453';
            $ret = json_decode(Common_Http::get($topMusicUrl),true);
            $songs = $ret['songlist'];
            $index = rand(0,count($songs));
            $musicUrl = 'http://ws.stream.qqmusic.qq.com/C100'.$songs[$index]['data']['songmid'].'.m4a?fromtag=0&guid=126548448';
            $singer = $songs[$index]['data']['singer'][0]['name'];
            $song = $songs[$index]['data']['songname'];

            $albumname = $songs[$index]['data']['albumname'];
            $albumid = $songs[$index]['data']['albumid'];
            $albumImg = "http://imgcache.qq.com/music/photo/album_300/" . $albumid%100 . "/300_albumpic_" . $albumid . "_0.jpg";
            $playInfo = new \Baidu\Duer\Botsdk\Directive\AudioPlayer\PlayerInfo();
            $playInfo -> setTitle($song);
            $playInfo -> setTitleSubtext1($singer);
            $playInfo -> setTitleSubtext2($albumname);
            $playInfo -> setArt($albumImg);
            $playInfo -> setLyric('http://yanximin.gz01.bdysite.com/lyric.php?songid='.$songs[$index]['data']['songmid']);
            $lyricButton = new \Baidu\Duer\Botsdk\Directive\AudioPlayer\Control\LyricButton();
            $lyricButton -> setEnabled(true);
            $lyricButton -> setSelected(true);
            $playInfo -> addControl($lyricButton);

            $directive = new Play($musicUrl, Play::REPLACE_ALL);

            $directive -> setPlayerInfo($playInfo);

            return [
                'directives' => [$directive],
                'outputSpeech' => '西瓜音乐为您播放：'.$singer.'的'.$song,
            ];
        });

        $this->addEventListener('AudioPlayer.PlaybackFinished', function($event){
            $topMusicUrl = 'http://c.y.qq.com/v8/fcg-bin/fcg_v8_toplist_cp.fcg?g_tk=5381&uin=0&format=json&inCharset=utf-8&outCharset=utf-8&notice=0'.
                '&platform=h5&needNewCode=1&tpl=3&page=detail&type=top&topid=26&_=1530710420453';
            $ret = json_decode(Common_Http::get($topMusicUrl),true);
            $songs = $ret['songlist'];
            $index = rand(0,count($songs));
            $musicUrl = 'http://ws.stream.qqmusic.qq.com/C100'.$songs[$index]['data']['songmid'].'.m4a?fromtag=0&guid=126548448';
            $singer = $songs[$index]['data']['singer'][0]['name'];
            $song = $songs[$index]['data']['songname'];

            $albumname = $songs[$index]['data']['albumname'];
            $albumid = $songs[$index]['data']['albumid'];
            $albumImg = "http://imgcache.qq.com/music/photo/album_300/" . $albumid%100 . "/300_albumpic_" . $albumid . "_0.jpg";
            $playInfo = new \Baidu\Duer\Botsdk\Directive\AudioPlayer\PlayerInfo();
            $playInfo -> setTitle($song);
            $playInfo -> setTitleSubtext1($singer);
            $playInfo -> setTitleSubtext2($albumname);
            $playInfo -> setArt($albumImg);
            $playInfo -> setLyric('http://yanximin.gz01.bdysite.com/lyric.php?songid='.$songs[$index]['data']['songmid']);
            $lyricButton = new \Baidu\Duer\Botsdk\Directive\AudioPlayer\Control\LyricButton();
            $lyricButton -> setEnabled(true);
            $lyricButton -> setSelected(true);
            $playInfo -> addControl($lyricButton);

            $directive = new Play($musicUrl, Play::REPLACE_ALL);

            $directive -> setPlayerInfo($playInfo);

            return [
                'directives' => [$directive],
                'outputSpeech' => '西瓜音乐为您播放：'.$singer.'的'.$song,
            ];
        });

        $this->addLaunchHandler(function(){
            return [
                'outputSpeech' => '<speak>欢迎光临</speak>'
            ];

        });

        $this->addSessionEndedHandler(function(){
            // clear status
            // 清空状态，结束会话。
            return null;
        });
    }
}
$bot = new Bot();

print $bot->run();