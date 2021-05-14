
<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>ログイン画面</title>
    <link rel="stylesheet" href="navi.css">
    <?php require '_navi.php'; ?>
</head>

<body>
<sign>
    <br>
    <form action="sign_in_create.php" method="post">
        メールアドレス<input type="email" name="email"><br>
        <br>
        　　パスワード<input type="password" name="password"><br>
        <br>
        <input type="submit" value="送信">
    </form>
</sign>
</body>

</html>
