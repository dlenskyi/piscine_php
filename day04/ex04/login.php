<?php

include('auth.php');
session_start();
if (auth($_POST['login'], $_POST['passwd']) && $_POST['login'] && $_POST['passwd']) {
    $_SESSION['loggued_on_user'] = $_POST['login'];

?>
<html><head>
    <style>
        body {
            background-color: #F5C2B3;
        }
        .gen {
            text-align: center;
            width: 100%;
            margin-top: 10%;
            border-width: 4px solid black;
            padding: 10px;
        }
        .chat {
            width: 500px;
            display: block;
            margin: 0 auto;
        }
        .copyright {
            position: absolute;
            bottom: 30px;
            right: 30px;
		    font-family: monospace;
		    font-style: italic;
	    }
        .speak {
            width: 500px;
            display: block;
            margin: 0 auto;
        }
        h1 {
            position: relative;
            text-align: left;
            top: 8%;
            left: 30%;
        }
    </style>
</head><body>
<div class="gen">
	<h1>Welcome, <?php echo $_SESSION['loggued_on_user']; ?></h1>
	<iframe class="chat" name="chat" src="chat.php" width="100%" height="550px"></iframe>
	<iframe class="speak" name="speak" src="speak.php" width="100%" height="50px"></iframe>
	<form action="logout.php">
    	<input type="submit" name="submit" value="Logout" action="logout.php" />
	</form>
</div>
<div class="copyright">
    <p>&#x24B8 dlenskyi 2019</p>
</div>
</body></html>
<?php

} else {
    $_SESSION['loggued_on_user'] = "";
    header('Location: index.html');
    echo "ERROR\n";
}

?>