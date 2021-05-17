<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登録情報変更ページ</title>
</head>

<!-- nav -->
<header>
  <?php require_once '_nav.php'; ?>
</header>

<body>
    <?php
    require_once '_db_access.php';
    if ($_SESSION['customer']['prefecture'] == '') {
    ?>
        <form action="user_update.php" method="post">
            <input type="hidden" name="id" value="<?= $_SESSION['cutomer']['id'] ?>">
            <p>お名前：<input type="text" name="name" value="<?= $_SESSION['customer']['name'] ?>"></p>
            <p>メールアドレス：<input type="text" name="email" value="<?= $_SESSION['customer']['email'] ?>"></p>
            <p>パスワード：<input type="text" name="password" value="<?= $_SESSION['customer']['password'] ?>"></p>
            <p>都道府県：<input type="hidden" name="prefecture" value="<?= $_SESSION['customer']['prefecture'] ?>"></p>
            <input type="hidden" name="address" value="<?= $_SESSION['customer']['address'] ?>">
            <input type="hidden" name="address_other" value="<?= $_SESSION['customer']['address_other'] ?>">
            <p><a href="user_update.php"><input type="submit" value="変更する"></a></p>
        </form>
    <?php

        // 市区町村なしver
    } elseif ($_SESSION['customer']['address'] == '') {
    ?>
        <form action="user_update.php" method="post">
            <input type="hidden" name="id" value="<?= $_SESSION['cutomer']['id'] ?>">
            <p>お名前：<input type="text" name="name" value="<?= $_SESSION['customer']['name'] ?>"></p>
            <p>メールアドレス：<input type="text" name="email" value="<?= $_SESSION['customer']['email'] ?>"></p>
            <p>パスワード：<input type="text" name="password" value="<?= $_SESSION['customer']['password'] ?>"></p>
            <p>都道府県：<input type="text" name="prefecture" value="<?= $_SESSION['customer']['prefecture'] ?>"></p>
            <input type="hidden" name="address" value="<?= $_SESSION['customer']['address'] ?>">
            <input type="hidden" name="address_other" value="<?= $_SESSION['customer']['address_other'] ?>">
            <p><a href="user_update.php"><input type="submit" value="変更する"></a></p>
        </form>
    <?php

        // マンション名なしver
    } elseif ($_SESSION['customer']['address_other'] == '') {
    ?>
        <form action="user_update.php" method="post">
            <input type="hidden" name="id" value="<?= $_SESSION['cutomer']['id'] ?>">
            <p>お名前：<input type="text" name="name" value="<?= $_SESSION['customer']['name'] ?>"></p>
            <p>メールアドレス：<input type="text" name="email" value="<?= $_SESSION['customer']['email'] ?>"></p>
            <p>パスワード：<input type="text" name="password" value="<?= $_SESSION['customer']['password'] ?>"></p>
            <p>都道府県：<input type="text" name="prefecture" value="<?= $_SESSION['customer']['prefecture'] ?>"></p>
            <p>市区町村：<input type="text" name="address" value="<?= $_SESSION['customer']['address'] ?>"></p>
            <input type="hidden" name="address_other" value="<?= $_SESSION['customer']['address_other'] ?>">
            <p><a href="user_update.php"><input type="submit" value="変更する"></a></p>
        </form>
    <?php
    } else {
    ?>
        <form action="user_update.php" method="post">
            <input type="hidden" name="id" value="<?= $_SESSION['cutomer']['id'] ?>">
            <p>お名前：<input type="text" name="name" value="<?= $_SESSION['customer']['name'] ?>"></p>
            <p>メールアドレス：<input type="text" name="email" value="<?= $_SESSION['customer']['email'] ?>"></p>
            <p>パスワード：<input type="text" name="password" value="<?= $_SESSION['customer']['password'] ?>"></p>
            <p>都道府県：<input type="text" name="prefecture" value="<?= $_SESSION['customer']['prefecture'] ?>"></p>
            <p>市区町村：<input type="text" name="address" value="<?= $_SESSION['customer']['address'] ?>"></p>
            <p>マンション名：<input type="text" name="address_other" value="<?= $_SESSION['customer']['address_other'] ?>"></p>
            <p><a href="user_update.php"><input type="submit" value="変更する"></a></p>
        </form>
    <?php
    }
    ?>
</body>

</html>