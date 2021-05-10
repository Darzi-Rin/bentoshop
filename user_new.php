<?php session_start(); ?>
<!DOCTYPE html>
<html lang='ja'>

<head>
  <meta charset='UTF-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
  <title>会員登録ページ</title>
</head>
<!-- nav -->
<header>
  <?php require_once '_nav.php'; ?>
</header>

<body>
  <!-- メイン -->
  <form action="user_confirm.php" method="post">
    <h2>会員登録</h2>
    <p>氏名<br><input type="text" name="name"></p>
    <p>メールアドレス（半角英数字）<br><input type="email" name="email"></p>
    <p>パスワード<br><input type="password" name="password"></p>
    <p>住所<br><input type="text" name="street_address"></p>
    <p><a href='user_confirm.php'><input type='submit' value='確認画面'></a></p>
  </form>
</body>
</html>