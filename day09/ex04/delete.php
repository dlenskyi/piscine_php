<?php

foreach ($_GET as $key => $val) {
	$fd = file_get_contents('list.csv');
	$split = explode("\n", $fd);
	foreach ($split as $elem) {
		$arr = explode(";", $elem);
		if ($arr[1] == $val) {
			$data = $arr[1].';'.$arr[1]."\n";
			$fd = str_replace($data, '', $fd);
			file_put_contents('list.csv', $fd);
		}
	}
}

?>