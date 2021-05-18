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
    //db接続
    require "_db_access.php";

    //sql作成
    $sql = "select * from products where name = :name";
    //プリペアードステートメントを作る
    $stm = $pdo->prepare($sql);
    //プリペアードステートメントに値をバインドする
    $stm->bindValue(':name', $_REQUEST['name'], PDO::PARAM_STR);
    //SQL文を実行する
    $stm->execute();
    //結果の取得（連想配列で受け取る）
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);


    foreach ($result as $row) {
    ?>
        <?php
        $name = $row['name'];
        $cost = $row['cost'];
        $code = $row['code'];
        $cal = $row['calorie'];
        $foodstuffs = $row['foodstuffs'];
        $description = $row['description'];
        $stock = $row['stock'];
        ?>

        <p><?= $name ?></p>
        <p><img src="image/<?= $code ?>.jpg" style="width:450px;"></p>
        <p>￥<?= $cost ?></p>
        <p><?= $description; ?></p>
        <p>材料：<?= $foodstuffs ?></p>
        <p>カロリー： <?= $cal ?></p>
        <p>残り <?= $stock ?>個</p>
        <form action="cart_create.php" method="post">
            <p>個数: <select name="count">
                    <?php
                    for ($i = 1; $i <= 10; $i++) {
                    ?>
                        <option value="<?= $i ?>"><?= $i ?></option>
                    <?php
                    }
                    ?>
                </select>
            </p>

            <input type="hidden" name="code" value="<?= $row['code'] ?>">
            <input type="hidden" name="name" value="<?= $row['name'] ?>">
            <input type="hidden" name="cost" value="<?= $row['cost'] ?>">

            <input type="submit" value="カートに入れる">

        </form>

    <?php
    }

    ?>


</body>

</html>