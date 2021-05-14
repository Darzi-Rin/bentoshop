<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>メニュー詳細</title>
</head>

<body>

    <?php require "_nav.php"; ?>
    <br>


    <?php
    require "_db_access.php";

    $name = $_GET['name'];
    $sql = "select * from aiueoa where name = '$name'";
    $stmt = $pdo->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($result as $row) {
        $name = $row['name'];
        $price = $row['stock']; //仮
        $cal = $row['calorie'];
        $stock = $row['stock'];
    ?>
        <p>商品名：<?= $name ?></p>
        <p>￥<?= $price ?></p>
        <p>カロリー：<?= $cal ?></p>
        <p>在庫：<?= $stock ?></p>
        <form action="cart_create.php" method="post">
            <input type="submit" value="カートに入れる">
            <input type="hidden" name="product_code" value="<?php $code ?>">
        </form>


    <?php
    }

    ?>


</body>

</html>