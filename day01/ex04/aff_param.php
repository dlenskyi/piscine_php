#!/usr/bin/php
<?php

$res = array_slice($argv, 1);
foreach($res as $elem)
    echo $elem."\n";

?>