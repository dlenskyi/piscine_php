<?php
session_start();
if ($_SESSION['logged_on_user'] === "") {
    $_SESSION['logged_on_user'] = "not authorized";
    $_SESSION['in_basket'] = 0;

    $_SESSION['permission'] = 0;
    if (isset($_SESSION['in_basket_items']) === true){
        unset($_SESSION['in_basket_items']);
    }
}

if ($_POST['submit'] == "Add to cart" && $_POST['quantity'] > 0) {
    $_SESSION['in_basket'] += $_POST['quantity'];
    if (isset($_SESSION['in_basket_items'][$_POST['id']]) === true){
        $_SESSION['in_basket_items'][$_POST['id']]['quantity'] += $_POST['quantity'];
        $_SESSION['in_basket_items'][$_POST['id']]['price'] += $_POST['price'];
    }
    else
        $_SESSION['in_basket_items'][$_POST['id']]['quantity'] = $_POST['quantity'];
        $_SESSION['in_basket_items'][$_POST['id']]['price'] = $_POST['price'];
    header('Location: index.php');
}
if ($_POST['Buy'] == "Buy") {
    if ($_SESSION['logged_on_user'] == "not authorized"){
        header('Location: login_page.html');
    }
    else{
        echo '<script type="text/javascript">alert("Order is done!");</script>';
        $_SESSION['in_basket'] = 0;
        if (isset($_SESSION['in_basket_items']) === true){
            unset($_SESSION['in_basket_items']);
        }
    }
}
if ($_POST['cat_color'] == "White" || $_POST['cat_color'] == "Black"
|| $_POST['cat_color'] == "Pink" || $_POST['cat_color'] == "Yellow" || $_POST['cat_color'] == "Gray") {
	$_SESSION['cat_color'] = $_POST['cat_color'];
    header('Location: index.php');
}
if ($_POST['cat_brand'] == "Nike" || $_POST['cat_brand'] == "Adidas") {
	$_SESSION['cat_brand'] = $_POST['cat_brand'];
    header('Location: index.php');
}
if ($_POST['cat_res'] == "Reset") {
	unset($_SESSION['cat_color']);
	unset($_SESSION['cat_brand']);
    header('Location: index.php');
}
if ($_POST['X'] == "X") {
    $var = unserialize(file_get_contents('db/sales.db'));
    $var[] = array();
    file_put_contents('db/sales.db',  serialize($var));
    $_SESSION['in_basket'] -= $_SESSION['in_basket_items'][$_POST['id']]['quantity'];
    unset ($_SESSION['in_basket_items'][$_POST['id']]);
}
if (!file_exists('db/user.db')) {
    include('install.php');
}
?>
<html>
<head>

    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sneakershop</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="index.css" />
</head>
<body>
<div class="general">
    <ul class="topmenu">
        <?php
        if ($_SESSION['logged_on_user'] === "not authorized"){
            echo '<li><a href="login_page.html">Sign in or register</a></li>';
        }
        else
        {
            echo ('<h1>Welcome, '.$_SESSION['logged_on_user'].'</h1>');
                echo ('<li><a href="#">'.$_SESSION['logged_on_user'].'</a>');
                    echo ('<ul class="dropmenu">
							<li>
								<a href="#">Settings</a>
								<ul class="subdrop">
									<li class="change" ><a href="modif.html">Change password</a></li>');
									if (intval($_SESSION['permission']) == 0){
									    echo ('<li class="change" ><a href="delete.html">Delete account</a></li>');
									}
								echo ('</ul>
							</li>
							<li><a href="logout.php">Logout</a></li>');

                            if (intval($_SESSION['permission']) == 1){
							    echo('<li><a href="admin.php">Admin panel</a></li>');
                            }
                     echo('</ul>
					</li>');
        }
        echo ('<li><a href="#"><img class="basket" src="img/basket.png"><span class="in_basket">'.intval($_SESSION['in_basket']).'</span></a>');
        if ($_SESSION['in_basket']) {
            echo('<ul class="dropmenu">');
            foreach ($_SESSION['in_basket_items'] as $key => $item) {
                echo('<li>');
                echo('<span>#' . $key . ', </span>');
                echo('<span>' . $item['quantity'] . ', </span>');
                echo('<span>$'.$item['price'].'</span>');
                echo '<form action="index.php" method="POST">';
                    echo '<input class="invisible" type="text" name="id" value="'.$key.'">';
                    echo '<input type="submit" name="X" value="X">';
                echo "</form>";
                echo('</li>');
            }
            echo '<form action="index.php" method="POST">';
                echo '<input type="submit" name="Buy" value="Buy">';
            echo "</form>";
            echo('</ul>
				</li>');
        }
        ?>
    </ul>
</div>
<hr />
<div class="main">
<div class="sidebar">
	<form action="index.php" method="POST">
		<input type="submit" name="cat_color" value="White">
		<input type="submit" name="cat_color" value="Black">
		<input type="submit" name="cat_color" value="Gray">
		<input type="submit" name="cat_color" value="Pink">
		<input type="submit" name="cat_color" value="Yellow">
		<div></div>
		<input type="submit" name="cat_brand" value="Nike">
		<input type="submit" name="cat_brand" value="Adidas">
		<input type="submit" name="cat_res" value="Reset">
	</form>
</div>
    <?php
    $var = unserialize(file_get_contents('db/item.db'));
    foreach ($var as $item) {
		if ((($item["color_c1"] == $_SESSION['cat_color']) || (!isset($_SESSION['cat_color']))) &&
			(($item["material_c1"] == $_SESSION['cat_brand']) || (!isset($_SESSION['cat_brand']))))
		{
			echo '<div class="container">';
			echo "<img class=\"at\" src=".$item["img_c1"].">";
			echo "<span class=\"descr\">Item ID: ".$item["item_id_c1"]."</span><br />";
			echo "<span class=\"descr\">Model: ".$item["type_c1"]."</span><br />";
			echo "<span class=\"descr\">Material: ".$item["material_c1"]."</span><br />";
			echo "<span class=\"descr\">Color: ".$item["color_c1"]."</span><br />";
			echo "<span class=\"descr\">Price: ".$item["price_c1"]."</span><br />";
			echo '<form action="index.php" method="POST">';
			echo '<input class="invisible" type="text" name="id" value="'.$item["item_id_c1"].'">';
			echo '<input class="invisible" type="text" name="model" value="'.$item["type_c1"].'">';
			echo '<input class="invisible" type="text" name="material" value="'.$item["material_c1"].'">';
			echo '<input class="invisible" type="text" name="color" value="'.$item["color_c1"].'">';
			echo '<input class="invisible" type="text" name="price" value="'.$item["price_c1"].'">';
			echo '<span><input type="number" name="quantity" value="1"></span>';
			echo '<input type="submit" name="submit" value="Add to cart">';
			echo "</form>";
			echo '</div>';
		}
    }
    ?>
</div>
</body>
</html>