<?php

session_start();
if ($_SESSION['loggued_on_user'] && $_SESSION['loggued_on_user'] != "" &&
    file_exists('../private/chat')) {
    $log = unserialize(file_get_contents('../private/chat'));
    foreach ($log as $msg) {
        echo "[".date('H:i', $msg['time'])."] <b>".$msg['login']."</b>: ".$msg['msg']."<br />\n";
    }
}

?>