<?php

class BBCode {
	public static function decode($input) {
        $input = strip_tags($input);
        $input = htmlentities($input);

        $needles = [
            /**
             * text
             */
            //'/\[b\](.*?)\[\/b\]/mi',

            /**
             * links
             */
            //'/\[url\](.*?)\[\/url\]/mi',
            //'/\[url\=(.*?)\](.*?)\[\/url\]/mi',

            /**
             * quotes
             */
            //'/\[quote\](.*?)\[\/quote\]/mi',
            '/\\n/i',
            '/\[quote\=(.*?)\](.*?)\[\/quote\]/i',

        ];

        $replacements = [
            //'<b>$1</b>',
            //'<a href="//$1">$1</a>',
            //'<a href="//$1">$2</a>',
            //'<blockquote class="message-quote">$1</blockquote>',
            '<br />',
            '<blockquote class="message-quote"><header class="message-header">Kirjoitti: <a href="//$1">$1</a></header><div class="message-content">$2</div></blockquote>',
        ];

        for($i = 0; $i < count($needles); $i++) {
            $search = $needles[$i];
            $replace = $replacements[$i];
            $input = self::replace($search, $replace, $input);
        }
        //tapa($input);
        return $input;
    }

    private static function replace($search, $replace, $input) {
        $count = 1000;
        while(preg_match($search, $input)) {
            $input = preg_replace($search, $replace, $input);
            if(--$count <= 0) break;
        }
        //tulosta(1000 - $count);
        return $input;
    }

    public static function encode($input) {
        //tulosta($input);
        //tulosta("\n\n");
        $quote = '<blockquote><header>Kirjoitti: <a href="//(.*?)">(.*?)</a></header><div>(.*?)</div></blockquote>';
        $f = [
            '<',
            '>',
            ' ',
            '=',
            '"',
            '/'

        ];
        $r = [
            '\\<',
            '\\>',
            '\\h',
            '\\=',
            '\\"',
            '\\/',
        ];
        $quote = str_replace($f, $r, $quote);

        $f = [
            '/\hclass=".*"/mi',
        ];
        $r = [
            ''
        ];
        $input = self::replace($f[0], $r[0], $input);
        //tapa($input);

        tapa($quote);
        $needles = [
            $quote,
            //'/<quote><b><a href="\/\/(.*?)">(.*?):<\/a><\/b><br\h\/>(.*?)<\/quote>/mi',
            //'/\<a href\=\"\/\/(.*?)\"\>(.*?)\<\/a\>/mi',
            //'/\<quote\>(.*?)\<\/quote\>/mi',
            //'/\<b\>(.*?)\<\/b\>/mi',
            //'/\<br \/\>/mi',
        ];
        $replacements = [
            '[quote=$1]$3[/quote]',
            //'[url=$1]$2[/url]',
            //'[quote]$1[/quote]',
            //'[b]$1[/b]',
            //"\n",
        ];

        for($i = 0; $i < count($needles); $i++) {
            $search = $needles[$i];
            $replace = $replacements[$i];
            $input = self::replace($search, $replace, $input);
        }
        return $input;
    }
}