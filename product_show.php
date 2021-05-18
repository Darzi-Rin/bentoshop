<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/typeLnav.css">
    <link rel="stylesheet" type="text/css" href="css/navi.css">
    <link rel="stylesheet" type="text/css" href="css/product.css">
    <title>メニュー詳細</title>
</head>

<body>

    <header class="grovalNav">
        <nav class="Nav">
            <ul>
                <li><a href="index.php">トップページ</a></li>
                <li class="current"><a href="product.php">メニュー</a></li>
                <li><a href="cart_show.php">カート</a></li>

                <?php //ログイン前は表示されないように処理
                if (isset($_SESSION['customer'])) {
                ?>
                    <li><a href="user_show.php">マイページ</a></li>
                <?php
                }
                ?>

                <?php //ログイン後は表示されないように処理
                if (!(isset($_SESSION['customer']))) {
                ?>
                    <li><a href="sign_in_new.php">ログイン</a></li>
                <?php
                }
                ?>

                <?php //ログイン前は表示されないように処理
                if (isset($_SESSION['customer'])) {
                ?>
                    <li><a href="sign_in_destroy.php">ログアウト</a></li>
                <?php
                }
                ?>


                <?php //ログイン後は表示されないように処理
                if (!(isset($_SESSION['customer']))) {
                ?>
                    <li><a href="user_new.php">会員登録</a></li>
                <?php
                }
                ?>
            </ul>
        </nav>
    </header>
    <br>
    <main>

        <div class="localNav">
            <ul>
                <li class="curren"><a href="product.php" style="text-decoration: none;">メニュー一覧</a></li>
                <li><a href="product_lunch_box.php" style="text-decoration: none;">お弁当</a></li>
                <li><a href="product_side_dishes.php" style="text-decoration: none;">おかず</a></li>
                <li><a href="product_side_menu.php" style="text-decoration: none;">サイド</a></li>
                <li><a href="product_event_menu.php" style="text-decoration: none;">イベント</a></li>
            </ul>
        </div>
        <div class="content">

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

                <p><img src="./imgs/<?= $code ?>.jpg" alt="" style="width:450px;"></p>
                <p><?= $name ?></p>
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

        </div>
</body>

</html>