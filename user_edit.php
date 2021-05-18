<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/topNav.css">
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