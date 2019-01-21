<?php

if (isset($_POST['submit']) && $_POST['submit'] == "OK" && $_POST['login'] &&
    $_POST['remove'] == "REMOVE" && $_POST['passwd'] && file_exists("db/user.db")) {
    $user = unserialize(file_get_contents("db/user.db"));
    print_r($user);
    foreach ($user as $key => $val) {
        if ($val['login'] == $_POST['login'] &&
            $val['passwd'] == hash("whirlpool", $_POST['passwd'])) {
            $user[$key]['passwd'] = "";
            $user[$key]['login'] = "";
            file_put_contents("db/user.db", serialize($user));
        }
    }
    header('Location: index.php');
} else {
    header('Location: delete.html');
}

?>
