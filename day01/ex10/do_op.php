#!/usr/bin/php
<?php

if ($argc == 4)
{
	$sym = trim($argv[2]);
	$nb1 = trim($argv[1]);
	$nb2 = trim($argv[3]);

	if ($sym === '-' || $sym === '+' || $sym === '*' ||
    	$sym === '/' || $sym === '%')
	{
		if (($sym === '%' || $sym === '/') && $nb2 == 0)
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
}
else
echo "Incorrect Parameters\n";

?>