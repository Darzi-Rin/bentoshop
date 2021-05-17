
<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>ログイン画面</title>
    <link rel="stylesheet" href="navi.css">
</head>

<body>
<h2>ログイン画面</h2>
    <?php require '_nav.php'; ?>
    <br>
    <form action="sign_in_create.php" method="post">
        メールアドレス<input type="email" name="email"><br>
        <br>
        パスワード　　<input type="password" name="password"><br>
        <br>
    　　　　<input type="submit" value="送信">
    </form>
</body>

</html>
