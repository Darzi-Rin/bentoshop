
<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>買い物かご画面</title>
    <link rel="stylesheet" href="navi.css">
</head>
<br>
<br>
<body>
    <?php require '_nav.php'; ?>
    <?php
    unset($_SESSION['products'][$_REQUEST['id']]);
    ?>
    カートから商品を削除しました。
    <hr>
    <?php
    require 'cart_show.php';
    ?>
</body>

</html>