#!/usr/bin/php
<?php

function	do_sort($s1, $s2) 
{
	$s1 = strtolower($s1);
	$s2 = strtolower($s2);
	if ($s1 == $s2)
		return (1);
	if ((ctype_alpha($s1) && !(ctype_alpha($s2))) ||
		(is_numeric($s1) && !(is_numeric($s2)) && !(ctype_alpha($s2))))
		return (-1);
    else if ((ctype_alpha($s2) && !(ctype_alpha($s1))) ||
			(is_numeric($s2) && !(is_numeric($s1)) && !(ctype_alpha($s1))))
    	return (1);
	if ($s1 < $s2)
		return (-1);
	return (1);
}
function    manage_usort($s1, $s2)
{
	$i = 0;
	while (!$res = do_sort($s1[$i], $s2[$i]))
		$i++;
	return ($res);
}

if ($argc > 1) 
{
    $i = 0;
    while ($i < $argc) 
	{
        $line .= trim(preg_replace('/\s\s+/', ' ', $argv[$i + 1])) . " ";
        $i++;
	}
}
$split = explode(' ', preg_replace('/ +/', ' ', trim($line)));
usort($split, "manage_usort");
foreach ($split as $out)
	echo $out."\n";

?>