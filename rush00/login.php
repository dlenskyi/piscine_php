<?php

include('auth.php');
session_start();

if (auth($_POST['login'], $_POST['passwd'])) {
	if (!isset($_SESSION['in_basket'])) {
		$_SESSION['in_basket'] = 0;
	}
	$_SESSION['logged_on_user'] = $_POST['login'];
    $user = unserialize(file_get_contents('db/user.db'));
    foreach ($user as $item)
        if ($item['login'] == $_POST['login']) {
            $_SESSION['permission'] = $item['permission'];
        }
	header('Location: index.php');
}
else if (!auth($_POST['login'], $_POST['passwd']) || !$_POST['login'] || !$_POST['passwd']){
    $_SESSION['logged_on_user'] = "";
    header('Location: login_page.html');
}
?>
