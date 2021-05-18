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

        $sql = "select * from products where code like '___4%'";
        $stmt = $pdo->query($sql);
        foreach ($stmt as $row) {
            $name = $row['name'];
            $cost = $row['cost'];
            $code = $row['code'];

        ?>

            <tr>
                <th><a href='product_show.php?name=<?php echo $name; ?>' style="color: black; text-decoration: none;"><?= $name; ?></a></th>
                <td><a href='product_show.php?name=<?php echo $name; ?>'><img src="image/<?= $code ?>.jpg" style="width:170px;"></a></td>
                <td>￥<?= $cost; ?></td>
                <!-- <td><a href='product_show.php?name=<?php echo $name; ?>'>詳細</a> -->
                <td>
                    <form action="cart_create.php" method="post">
                        <input type="hidden" name="count" value="1">
                        <input type="hidden" name="id" value="<?= $row['code'] ?>">
                        <input type="hidden" name="name" value="<?= $row['name'] ?>">
                        <input type="hidden" name="price" value="<?= $row['cost'] ?>">
                        <input type="submit" value="カートに入れる">
                    </form>
                </td>
            </tr>
        <?php
        }
        ?>
    </table>
</body>

</html>