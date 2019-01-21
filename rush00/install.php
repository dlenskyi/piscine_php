<?php

if (!file_exists('db/user.db') && !file_exists('db/item.db')) {
    mkdir('db');
}
if (file_exists('db')) {
    $user = unserialize(file_get_contents('db/user.db'));
    $user[] = array("login" => "admin",
            "passwd" => hash('whirlpool', "admin"), "permission" => 1);
    file_put_contents('db/user.db', serialize($user));
}

?>