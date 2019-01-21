#!/usr/bin/php
<?php

date_default_timezone_set('Europe/Kiev');
if ($fd = fopen("/var/run/utmpx", 'r'))
{
	while ($tmp = fread($fd, 628))
	{
		$res = unpack("a256user/a4id/a32line/ipid/itype/I2time/a256host/@", $tmp);
		if ($res['type'] == 7)
			$arr[trim($res['line'])] = array('user'=>trim($res['user']), 'time'=>$res['time1']);
	}
	ksort($arr);
	foreach ($arr as $line => $d)
	{
		$curr_date = strftime("%b %e %H:%M", $d['time']);
		$p = $d['user'].' '.$line.'  '.$curr_date;
		echo $p."\n";
	}
}

?>