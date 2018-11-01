<?php

class Common_Http
{

    /**
     * @param null
     * @return null
     */
    public static function get($url, $opt=[])
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6)');
        foreach ($opt as $key => $value){
            curl_setopt($ch, $key, $value);

        }
        $output = curl_exec($ch);

        curl_close($ch);

        return $output;
    }

    public static function post($url, Array $post)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

        $output = curl_exec($ch);

        curl_close($ch);

        return $output;
    }

}
