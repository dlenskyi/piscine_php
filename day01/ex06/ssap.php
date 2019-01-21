#!/usr/bin/php
<?php

$res = array_slice($argv, 1);
$split = [];

foreach($res as $elem)
    foreach(explode(' ', preg_replace('/ +/', ' ', trim($elem))) as $arr)
        $split[] = $arr;
sort($split);
foreach($split as $out)
    echo $out."\n";

?>