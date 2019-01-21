<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sneakershop</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="admin.css" />
</head>
<body>
    <div class="container">
            <div class="row1">
                <h3>PHP CRUD Grid</h3>
                <a href="index.php">Back to main page</a>
            </div>
            <div class="row r1">

                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>item_id</th>
                        <th>Type</th>
                        <th>Price</th>
                        <th>Brand</th>
                        <th>Color</th>
                        <th>Img</th>
                        <th>Delete / Edit</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    session_start();
                    if ($_SESSION['permission'] == 0){
                        header("Location: index.php");
                    }
                    else if(isset($_POST["delete1"]))
                    {
                        $var = unserialize(file_get_contents("db/item.db"));
                        unset ($var[$_POST["delete1"] - 1]);
                        file_put_contents("db/item.db", serialize(array_values($var)));
                        header("Location: admin.php");
                    }
                    else if(isset($_POST["create1"]))
                    {
                        $var = unserialize(file_get_contents("db/item.db"));
                        $arrr[0] = array(
                                "item_id_c1"=>$_POST["item_id_c1"],
                                "type_c1" => $_POST["type_c1"],
                                "price_c1"=>$_POST["price_c1"],
                                "material_c1"=>$_POST["material_c1"],
                                "color_c1"=>$_POST["color_c1"],
                                "img_c1"=>$_POST["img_c1"]);
                        $var[] = $arrr[0];
                        file_put_contents("db/item.db", serialize($var));
                        header("Location: admin.php");
                    }
                    else if(isset($_POST["edit1"]))
                    {
                        $vab = unserialize(file_get_contents("db/item.db"));
                        foreach ($vab[$_POST["edit1"] - 1] as $key => $value) {
                            $vab[$_POST["edit1"] - 1][$key] = $_POST[substr($key,0,-3).$_POST["edit1"]];
                        }
                        file_put_contents("db/item.db", serialize(array_values($vab)));
                        header("Location: admin.php");
                    }
                    else if(isset($_POST["delete"]))
                    {
                        $var = unserialize(file_get_contents("db/user.db"));
                        unset ($var[$_POST["id"] - 1]);
                        file_put_contents("db/user.db", serialize(array_values($var)));
                        header("Location: admin.php");
                    }
                    else if(isset($_POST["edit"]))
                    {
                        $vab = unserialize(file_get_contents("db/user.db"));
                        $vab[$_POST['id'] - 1]['login'] = $_POST['login'];
                        $vab[$_POST['id'] - 1]['permission'] = $_POST['permission'];
                        file_put_contents("db/user.db", serialize(array_values($vab)));
                        header("Location: admin.php");
                    }
                    $i = 0;
                    if (!file_exists("db/item.db"))
                        file_put_contents("db/item.db", "");
                    $var = unserialize(file_get_contents("db/item.db"));
                    foreach ($var as $it)
                    {
                          echo '<tr><form action="admin.php" method="post">';
                          echo '<td>'.++$i.'</td>';
                          echo '<td><input type="text" name="item_id'.$i.'" value="'.$it["item_id_c1"].'"></td>';
                          echo '<td><input type="text" name="type'.$i.'" value="'.$it["type_c1"].'"></td>';
                          echo '<td><input type="text" name="price'.$i.'" value="'.$it["price_c1"].'"></td>';
                          echo '<td><input type="text" name="material'.$i.'" value="'.$it["material_c1"].'"></td>';
                          echo '<td><input type="text" name="color'.$i.'" value="'.$it["color_c1"].'"></td>';
                          echo '<td><input type="text" name="img'.$i.'" value="'.$it["img_c1"].'"></td>';
                          echo '<td><input type="submit" name="delete1" title="del" value="'.$i.'"><input type="submit" name="edit1" title="edit" value="'.$i.'"></td>';
                          echo '</form></tr>';
                    }
                    ?>
                    <tr><form action="admin.php" method="post">
                        <td><?php echo ++$i; ?></td>
                        <td><input type="text" name="item_id_c1"></td>
                        <td><input type="text" name="type_c1"></td>
                        <td><input type="text" name="price_c1"></td>
                        <td><input type="text" name="material_c1"></td>
                        <td><input type="text" name="color_c1"></td>
                        <td><input type="text" name="img_c1"></td>
                        <td><input type="submit" name="create1" value="Create"></td>
                        </form></tr>
                    </tbody>
                </table>
        </div>
        <div class="row r2">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Username</th>
                    <th>Type</th>
                    <th>Delete / Edit</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $var = unserialize(file_get_contents("db/user.db"));
                $i = 0;
                foreach ($var as $it)
                {
                    echo '<tr>';
                    echo '<form action="admin.php" method="post">';
                    echo '<td><input type="text" name="id" value="'.++$i.'"></td>';
                    echo '<td><input type="text" name="login" value="'.$it['login'].'"></td>';
                    echo '<td><input type="text" name="permission" value="'.$it['permission'].'"></td>';
                    echo '<td><input type="submit" name="delete" value="delete">
                            <input type="submit" name="edit" value="edit"></td>';
                    echo '</echo>';
                    echo '</tr>';
                }
                ?>
                </tbody>
            </table>
        </div>
        <div class="row r3">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>item_id</th>
                    <th>Username</th>
                    <th>Price</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $var = unserialize(file_get_contents("sales.db"));
                $i = 0;
                foreach ($var as $it)
                {
                    echo '<tr>';
                    echo '<td>'.++$i.'</td>';
                    echo '<td>'.$it['user'].'</td>';
                    echo '<td>'.$it['id'].'</td>';
                    echo '<td>'.$it['quantity'].'</td>';
                    echo '<td>'.$it['price'].'</td>';
                    echo '</tr>';
                }
                fclose($fd);
                ?>
                </tbody>
            </table>
    </div> <!-- /container -->
  </body>
</html>