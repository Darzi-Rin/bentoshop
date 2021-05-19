<?php session_start(); ?>
<!DOCTYPE html>
<html lang='ja'>

<head>
  <meta charset='UTF-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
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

    .Nav ul {
      display: table;
      margin: 0 auto;
      padding: 0;
      width: 80%;
      text-align: center;
    }

    .Nav ul li {
      display: table-cell;
      min-width: 50px;
    }

    .Nav ul li a {
      display: block;
      width: 100%;
      padding: 10px 0;
      text-decoration: none;
      color: rgb(0, 0, 0);
      font-weight: bold;
    }

    .Nav ul li.current {
      background-color: #fcfcfc;
    }

    .Nav ul li.current a {
      color: rgb(255, 0, 0);
    }

    .Nav ul li:hover {
      border-bottom: 5px solid #ff0000;
    }
  </style>
  <title>会員登録ページ</title>
</head>

<body>
  <!-- nav -->
  <header class="topNav">
    <nav class="Nav">
      <ul>
        <li><a href="index.php">トップページ</a></li>
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
          <li class="current"><a href="user_new.php">会員登録</a></li>
        <?php
        }
        ?>
      </ul>
    </nav>
  </header>
  <div class="content">
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
  </div>
</body>

</html>