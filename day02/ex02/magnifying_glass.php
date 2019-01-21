#!/usr/bin/php
<?php

function    conc($s)
{
    return ($s[1].strtoupper($s[2]).$s[3]);
}

function    find($src)
{
    $src[0] = preg_replace_callback("/(title=\")(.*?)(\")/", "conc", $src[0]);
    $src[0] = preg_replace_callback('/(>)(.*?)(<)/', "conc", $src[0]);
    return ($src[0]);
}

if ($argc > 1 && file_exists($argv[1]))
{
    $fd = fopen($argv[1], 'r');
    while (!feof($fd))
        $res[] = fgets($fd);
    $res = preg_replace_callback('/(<a)(.*)(\/a>)/', "find", $res);
    $out = implode("", $res);
    echo $out;
}

?>