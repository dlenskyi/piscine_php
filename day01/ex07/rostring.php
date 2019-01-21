#!/usr/bin/php
<?php

$arr = explode(' ', trim(preg_replace('/ +/', ' ', $argv[1])));
$start = $arr[0];
$arr = array_slice($arr, 1);
$arr[] = $start;
echo implode(' ', $arr);
echo "\n";

?>