<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .topNav {
            height: 44px;
            text-align: center;
            background-color: #ffffff;
            color: #fff;
        }

        .content {
            flex: 1;
            background-color: #eee;
            text-align: center;
            margin-top: 10px;
            padding-top: 20px;
        }

        table {
            margin-left: auto;
            margin-right: auto;
        }

        h1 {
            border-bottom: 3px solid #000;
        }
    </style>
    <title>登録情報変更ページ</title>
</head>

<body>
    <div class="content">
        <?php
        require_once '_db_access.php';
        ?>
        <form action="user_update.php" method="post">
            <input type="hidden" name="id" value="<?= $_SESSION['cutomer']['id'] ?>">
            <p>お名前：<input type="text" name="name" value="<?= $_SESSION['customer']['name'] ?>"></p>
            <p>メールアドレス:<input type="text" name="email" value="<?= $_SESSION['customer']['email'] ?>"></p>
            <p>パスワード:<input type="password" id="password" name="password" value="<?= $_SESSION['customer']['password'] ?>"></p>
            <p>都道府県：<input type="text" name="prefecture" value="<?= $_SESSION['customer']['prefecture'] ?>"></p>
            <p>市区町村：<input type="text" name="address" value="<?= $_SESSION['customer']['address'] ?>"></p>
            <p>マンション名：<input type="text" name="addressOther" value="<?= $_SESSION['customer']['addressOther'] ?>"></p>
            <p><a href="user_update.php"><input type="submit" value="変更する"></a></p>
        </form>
        <?php

        ?>
    </div>
</body>

</html>