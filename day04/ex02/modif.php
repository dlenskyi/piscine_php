<?php

if ($_POST['submit'] && $_POST['submit'] == "OK" && $_POST['login'] &&
    $_POST['oldpw'] && $_POST['newpw'] && file_exists("../private/passwd")) {
    $user = unserialize(file_get_contents("../private/passwd"));
    foreach ($user as $key => $val) {
        if ($val['login'] == $_POST['login'] &&
            $val['passwd'] == hash("whirlpool", $_POST['oldpw'])) {
            $user[$key]['passwd'] = hash("whirlpool", $_POST['newpw']);
            file_put_contents("../private/passwd", serialize($user));
            exit("OK\n");
        }
    }
}
exit("ERROR\n");

?>
