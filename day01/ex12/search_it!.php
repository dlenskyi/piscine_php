#!/usr/bin/php
<?php
if ($argc > 2) 
{
	$i = 2;

	while ($i < $argc)
	{
		$split = explode(':', preg_replace('/ +/', ' ', trim($argv[$i])));
		$key = $split[0];
		$val = $split[1];
		if (!$key && $val)
			$key = "0";
		$arr[$key] = $val;
		$i++;
	}
	foreach ($arr as $key => $val)
	{
		if ($argv[1] == "0" && $key == "0")
			echo $val."\n";
		else if ($key == $argv[1] && $key != "0")
			echo $val."\n";
	}
}
?>