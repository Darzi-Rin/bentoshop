<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>ログイン画面</title>
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
</head>

<body>
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
          <li class="current"><a href="sign_in_new.php">ログイン</a></li>
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
    <h2>ログイン画面</h2>
    <form action="sign_in_create.php" method="post">
      メールアドレス<input type="email" name="email"><br>
      <br>
      パスワード　　<input type="password" name="password"><br>
      <br>
      　　　　<input type="submit" value="送信">
    </form>
  </div>
</body>

</html>