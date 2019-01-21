#!/usr/bin/php
<?php

$res = array_slice($argv, 1);
if ($argc > 1)
{
    $out = preg_replace('/ +/', ' ', trim($res[0]));
    echo $out."\n";
}

?>