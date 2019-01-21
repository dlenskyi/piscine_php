<?php

session_start();
if ($_SESSION['loggued_on_user'] && $_SESSION['loggued_on_user'] != "") {
    if ($_POST['msg']) {
        if (!file_exists('../private/chat')) {
            mkdir('../private');
        }
        $data = unserialize(file_get_contents('../private/chat'));
        $fd = fopen('../private/chat', 'w');
        flock($fd, LOCK_EX);
        $data[] = array("login" => $_SESSION['loggued_on_user'], "time" => time(),
                        "msg" => $_POST['msg']);
        file_put_contents('../private/chat', serialize($data));
    }

?>
<html><head>
    <style>
        input[type="text"] {
            margin-top: 5px;
            width: 400px;
            height: 20px;
            font-size: 13px;
        }
    </style>
    <script langage="javascript">top.frames['chat'].location = 'chat.php';</script>
</head><body>
    <form action="speak.php" method="POST">
        <input type="text" placeholder="Enter your message" name="msg" value="" />
        <input type="submit" name="submit" value="Send"  />
    </form>
</body></html>
<?php

} else {
    echo "ERROR\n";
}

?>