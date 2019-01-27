<?php

foreach ($_GET as $key => $val) {
	file_put_contents('list.csv', $_GET[$key].';'.$_GET[$key]."\n", FILE_APPEND | LOCK_EX);
}

?>