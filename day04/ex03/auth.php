<?php

function    auth($login, $passwd) {
    if (!$login || !$passwd) {
        return (FALSE);
    }
    $user = unserialize(file_get_contents("../private/passwd"));
    foreach ($user as $key => $val) {
        if ($val['login'] == $login && $val['passwd'] == hash('whirlpool', $passwd)) {
            return (TRUE);
        }
    }
return (FALSE);
}

?>