<?php

$fd = file_get_contents('list.csv');
$split = explode("\n", $fd);
echo json_encode($split);

?>