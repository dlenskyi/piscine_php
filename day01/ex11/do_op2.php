#!/usr/bin/php
<?php

if ($argc == 2)
{
	$line = trim($argv[1]);
	$line = str_replace("+", " + ", $line);
	$line = str_replace("-", " - ", $line);
	$line = str_replace("*", " * ", $line);
	$line = str_replace("/", " / ", $line);
	$line = str_replace("%", " % ", $line);

	$split = explode(' ', preg_replace('/ +/', ' ', trim($line)));

	$sym = $split[1];
	$nb1 = $split[0];
	$nb2 = $split[2];

	if (($sym === '-' || $sym === '+' || $sym === '*' ||
		$sym === '/' || $sym === '%') && is_numeric($nb1) &&
		is_numeric($nb2))
	{
		if (($sym === '/' || $sym === '%') && $nb2 == 0)
			exit ;
		else if ($sym === '+')
			echo $nb1 + $nb2."\n";
		else if ($sym === '-')
			echo $nb1 - $nb2."\n";
		else if ($sym === '*')
			echo $nb1 * $nb2."\n";
		else if ($sym === '/')
			echo $nb1 / $nb2."\n";
		else if ($sym === '%')
			echo $nb1 % $nb2."\n";
	}
	else
		echo "Syntax Error\n";
}
else
	echo "Incorrect Parameters\n";

?>