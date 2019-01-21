<?php

if ($_POST['submit'] && $_POST['submit'] == "OK" && $_POST['login'] && $_POST['passwd'] &&
    file_exists('db')) {
    $user = unserialize(file_get_contents('db/user.db'));

    foreach($user as $key => $val) {
        if ($val['login'] == $_POST['login']) {
            header('Location: create.html');
        }
    }
    $user[] = array("login" => $_POST['login'],
                    "passwd" => hash('whirlpool', $_POST['passwd']),
                    "permission" => 0);
    file_put_contents('db/user.db', serialize($user));
    header('Location: login_page.html');
}
else {
    header('Location: create.html');
}

?>
