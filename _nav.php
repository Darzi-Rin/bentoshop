
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="navi.css">
</head>
<body>
<nav id ="global_navi">
    <!-- <a href="toppage.php">トップ</a> -->
    <a href="product.php">メニュー</a>
    <a href="cart_show.php">カート</a>
<?php //ログイン後は表示されないように処理
if (!(isset($_SESSION['customer']))) {
?>
<a href="sign_in_new.php">ログイン</a>
<?php
}
?>

<?php //ログイン前は表示されないように処理
if (isset($_SESSION['customer'])) {
?>
    <a href="sign_in_destroy.php">ログアウト</a>
<?php
}
?>

<?php //ログイン後は表示されないように処理
if (!(isset($_SESSION['customer']))) {
?>
<a href="user_new.php">会員登録</a>
<?php
}
?>
</nav>
</body>
</html>