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
  <?php
  if (!isset($_SESSION['customer'])) {

    // ランダムな文字列を生成
    $randamStr = chr(mt_rand(97, 122)) . chr(mt_rand(97, 122)) . chr(mt_rand(97, 122)) . chr(mt_rand(97, 122)) . chr(mt_rand(97, 122)) . chr(mt_rand(97, 122)) . chr(mt_rand(97, 122)) . chr(mt_rand(97, 122)) . chr(mt_rand(97, 122));
    // $csrfに値を入れる
    $csrf_token = $randamStr;
    $_SESSION['csrf_token'] = $csrf_token;
  ?>
    <!-- メイン -->
    <h2>会員登録</h2>
    <!-- 確認画面へポスト -->
    <form action="user_confirm.php" method="POST">
      <!-- 入力欄 -->
      <!-- csrf対策 -->
      <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
      <p>氏名<br><input type="text" name="name"></p>
      <p>メールアドレス（半角英数字）<br><input type="email" name="email"></p>
      <p>パスワード<br><input type="password" name="password"></p>
      <p>都道府県（任意）<br><input type="prefecture" name="prefecture"></p>
      <p>市区町村（任意）<br><input type="text" name="address"></p>
      <p>マンション名その他（任意）<br><input type="text" name="addressOther"></p>
      <!-- 確認画面へ遷移 -->
      <p><a href='user_confirm.php'><input type='submit' value='確認画面'></a></p>
    </form>
  <?php
  } else {
  ?>
    <p>不正な操作が行われたためトップへ戻ります。</p>
    <META http-equiv="Refresh" content="3;URL=index.php">
  <?php
  }
  ?>
</body>

</html>