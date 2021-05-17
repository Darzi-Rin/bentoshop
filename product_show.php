<?php session_start(); ?>
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

    <a href="product.php" style="text-decoration: none;">メニュー一覧</a>
    <a href="product_lunch_box.php" style="text-decoration: none;">お弁当</a>
    <a href="product_side_dishes.php" style="text-decoration: none;">おかず</a>
    <a href="product_side_menu.php" style="text-decoration: none;">サイド</a>
    <a href="product_event_menu.php" style="text-decoration: none;">イベント</a>


    <?php
    require "_db_access.php";

    $name = $_GET['name'];
    $sql = "select * from products where name = '$name'";
    $stmt = $pdo->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($result as $row) {
        $name = $row['name'];
        $cost = $row['cost'];
        $cal = $row['calorie'];
        $foodstuffs = $row['foodstuffs'];
        $description = $row['description'];
        $stock = $row['stock'];
        $code = $row['code'];
    ?>
        <p><?= $name ?></p>
        <p><img src="image/<?= $code ?>.jpg" style="width:450px;"></p>
        <p>￥<?= $cost ?></p>
        <p><?= $description; ?></p>
        <p><?= $foodstuffs ?></p>
        <p>カロリー：<?= $cal ?></p>
        <p>在庫：<?= $stock ?></p>
        <form action="cart_create.php" method="post">
            <input type="submit" value="カートに入れる">
            <input type="hidden" name="product_code" value="<?= $code ?>">
        </form>


    <?php
    }

    ?>


</body>

</html>