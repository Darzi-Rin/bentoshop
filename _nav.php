<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/navi.css">
    <title>Document</title>
    <!-- <link rel="stylesheet" href="navi.css"> -->
</head>

<body>
    <nav class="Nav">
        <ul>
            <li class="current"><a href="index.php">トップページ</a></li>
            <li><a href="product.php">メニュー</a></li>
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
</body>

</html>