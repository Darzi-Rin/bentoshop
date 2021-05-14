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

    <a href="product.php">メニュー一覧</a>
    <a href="product_lunch_box.php">お弁当</a>
    <a href="product_side_dishes.php">おかず</a>
    <a href="product_side_menu.php">サイド</a>
    <a href="product_event_menu.php">イベント</a>


    <table>

        <!-- ↓ 仮 ↓ -->
        <tr>
            <th>商品名</th>
            <th>価格</th>
            <td></td>
            <th>(商品コード)</th>
        </tr>
        <!-- ↑ 仮 ↑ -->

        <?php

        require "_db_access.php";

        $sql = "select * from products where code=3";
        $stmt = $pdo->query($sql);
        foreach ($stmt as $row) {
            $name = $row['name'];
            $price = $row['cost'];
            // $code = $row['code'];

        ?>
            <tr>
                <th><?= $name; ?></th>
                <td><?= $price; ?></td>
                <td><a href='product_show.php?name=<?php echo $name; ?>'>詳細</a>
                <td>(<?= $code ?>)</td>
                <td>
                    <form action="cart_create.php" method="post">
                        <input type="submit" value="カートに入れる">
                        <input type="hidden" name="product_code" value="<?php $code ?>">
                    </form>
                </td>
            </tr>
        <?php
        }
        ?>
    </table>
</body>

</html>