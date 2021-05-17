<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <?php require "_nav.php"; ?>
    <br>


    <a href="product.php" style="text-decoration: none;">メニュー一覧</a>
    <a href="product_lunch_box.php" style="text-decoration: none;">お弁当</a>
    <a href="product_side_dishes.php" style="text-decoration: none;">おかず</a>
    <a href="product_side_menu.php" style="text-decoration: none;">サイド</a>
    <a href="product_event_menu.php" style="text-decoration: none;">イベント</a>


    <table>



        <?php

        require "_db_access.php";

        $sql = "select * from products where code like '___1%'";
        $stmt = $pdo->query($sql);
        foreach ($stmt as $row) {
            $name = $row['name'];
            $price = $row['cost'];
            $code = $row['code'];

        ?>
            <tr>
                <th><?= $name; ?></th>
                <td><img src="image/<?= $code ?>.jpg" style="width:170px;"></td>
                <td><?= $price; ?></td>
                <td><a href='product_show.php?name=<?php echo $name; ?>'>詳細</a>
                <td>
                    <form action="cart_create.php" method="post">
                        <input type="submit" value="カートに入れる">
                        <input type="hidden" name="product_code" value="<?= $code ?>">
                    </form>
                </td>
            </tr>
        <?php
        }
        ?>
    </table>
</body>

</html>