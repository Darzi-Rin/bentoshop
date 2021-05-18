<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/typeLnav.css">
    <link rel="stylesheet" href="css/navi.css">
    <link rel="stylesheet" href="css/product.css">
    <!-- <link rel="stylesheet" href="css/localNav.css"> -->
    <title>メニュー一覧</title>
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
            <table>

                <?php

                require "_db_access.php";

                $sql = "select * from products";
                $stmt = $pdo->query($sql);
                foreach ($stmt as $row) {
                    $name = $row['name'];
                    $cost = $row['cost'];
                    $code = $row['code'];

                ?>

                    <tr>
                        <td><a href='product_show.php?name=<?php echo $name; ?>'><img src="./imgs/<?= $code ?>.jpg" alt="" style="width:170px;"></a></td>
                        <td><a href='product_show.php?name=<?php echo $name; ?>' style="color: black; text-decoration: none;"><?= $name; ?></a>
                        <br>
                        <br>
                        ￥<?= $cost; ?></td>
                        <!-- <td><a href='product_show.php?name=<?php echo $name; ?>'>詳細</a> -->
                        <td>
                            <form action="cart_create.php" method="post">
                                <input type="hidden" name="count" value="1">
                                <input type="hidden" name="code" value="<?= $row['code'] ?>">
                                <input type="hidden" name="name" value="<?= $row['name'] ?>">
                                <input type="hidden" name="cost" value="<?= $row['cost'] ?>">
                                <input type="submit" value="カートに入れる">
                            </form>
                        </td>
                    </tr>
                <?php
                }
                ?>

            </table>
        </div>
    </main>
</body>

</html>