<?php

if (isset($_POST['submit']) && $_POST['submit'] == "OK" && $_POST['login'] &&
    $_POST['oldpw'] && $_POST['newpw'] && file_exists("db/user.db")) {
    $user = unserialize(file_get_contents("db/user.db"));
    foreach ($user as $key => $val) {
        if ($val['login'] == $_POST['login'] &&
            $val['passwd'] == hash("whirlpool", $_POST['oldpw'])) {
            $user[$key]['passwd'] = hash("whirlpool", $_POST['newpw']);
            file_put_contents("db/user.db", serialize($user));
        }
    }
    header('Location: index.php');
} else {
    header('Location: modif.html');
}

?>
