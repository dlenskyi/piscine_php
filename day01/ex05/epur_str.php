#!/usr/bin/php
<?php

$res = array_slice($argv, 1);
foreach($res as $elem)
{
    $out = preg_replace('/ +/', ' ', trim($elem));
    echo $out."\n";
}

?>