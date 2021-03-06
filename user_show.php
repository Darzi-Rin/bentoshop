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
  <title>マイページ</title>
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
          <li class="current"><a href="user_show.php">マイページ</a></li>
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
          <li><a href="user_new.php">会員登録</a></li>
        <?php
        }
        ?>
      </ul>
    </nav>
  </header>
  <div class="content">
    <!-- 個人情報表示 -->
    <h2>個人情報</h2>
    <?php
    // データベース接続
    require '_db_access.php';

    // session(customer)に値が入っているかチェック
    if (!isset($_SESSION['customer'])) {
      echo '個人情報を確認するにはログインしてください。';
    } else {  //正常処理

      // 都道府県なしver
      if ($_SESSION['customer']['prefecture'] == '') {
    ?>
        <p>お名前：<?= $_SESSION['customer']['name'] ?></p>
        <p>メールアドレス：<?= $_SESSION['customer']['email'] ?></p>
        <p><a href="user_show_log.php"><input type="submit" value="購入履歴へ(未完成)"></a></p>
        <p><a href="user_edit.php"><input type="submit" value="登録情報変更"></a></p>
      <?php

        // 市区町村なしver
      } elseif ($_SESSION['customer']['address'] == '') {
      ?>
        <p>お名前：<?= $_SESSION['customer']['name'] ?></p>
        <p>メールアドレス：<?= $_SESSION['customer']['email'] ?></p>
        <p>都道府県：<?= $_SESSION['customer']['prefecture'] ?></p>
        <p><a href="user_show_log.php"><input type="submit" value="購入履歴へ(未完成)"></a></p>
        <p><a href="user_edit.php"><input type="submit" value="登録情報変更"></a></p>
      <?php

        // マンション名なしver
      } elseif ($_SESSION['customer']['addressOther'] == '') {
      ?>
        <p>お名前：<?= $_SESSION['customer']['name'] ?></p>
        <p>メールアドレス：<?= $_SESSION['customer']['email'] ?></p>
        <p>都道府県：<?= $_SESSION['customer']['prefecture'] ?></p>
        <p>市区町村：<?= $_SESSION['customer']['address'] ?></p>
        <p><a href="user_show_log.php"><input type="submit" value="購入履歴へ(未完成)"></a></p>
        <p><a href="user_edit.php"><input type="submit" value="登録情報変更"></a></p>
      <?php
      } else {
      ?>
        <!-- 全表示ver -->
        <p>お名前：<?= $_SESSION['customer']['name'] ?></p>
        <p>メールアドレス：<?= $_SESSION['customer']['email'] ?></p>
        <p>都道府県：<?= $_SESSION['customer']['prefecture'] ?></p>
        <p>市区町村：<?= $_SESSION['customer']['address'] ?></p>
        <p>マンション名：<?= $_SESSION['customer']['addressOther'] ?></p>
        <p><a href="user_show_log.php"><input type="submit" value="購入履歴へ(未完成)"></a></p>
        <p><a href="user_edit.php"><input type="submit" value="登録情報変更"></a></p>
    <?php
      }
    }
    ?>
  </div>
</body>

</html>