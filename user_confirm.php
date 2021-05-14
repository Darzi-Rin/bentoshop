<?php session_start(); ?>
<!DOCTYPE html>
<html lang='ja'>

<head>
  <meta charset='UTF-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
  <title>確認画面</title>
</head>
<!-- nav -->
<header>
  <?php //require_once '_nav.php'; 
  ?>
</header>

<body>
  <!-- メイン -->
  <?php require '_db_access.php'; ?>
  <!-- セッションを作成 -->
  <?php
  $_SESSION['customer']['name'] = $_POST['name'];
  $_SESSION['customer']['email'] = $_POST['email'];
  $_SESSION['customer']['password'] = $_POST['password'];
  $_SESSION['customer']['prefecture'] = $_POST['prefecture'];
  $_SESSION['customer']['address'] = $_POST['address'];
  $_SESSION['customer']['address_other'] = $_POST['address_other'];
  $_SESSION['csrf_token'] = $_POST["csrf_token"];

  if (isset($_POST["csrf_token"]) && $_POST["csrf_token"] === $_SESSION['csrf_token']) {
    if ($_SESSION['customer']['name'] == '') {
      unset($_SESSION['customer']);
  ?>
      <p>名前を入力してください。</p>
      <p><a href="user_new.php"><input type="submit" value="会員登録画面に戻る"></a></p>
      <?php
    } else {
      if ($_SESSION['customer']['email'] == '') {
        unset($_SESSION['customer']);
      ?>
        <p>メールアドレスを入力してください。</p>
        <p><a href="user_new.php"><input type="submit" value="会員登録画面に戻る"></a></p>
        <?php
      } else {
        if ($_SESSION['customer']['password'] == '') {
          unset($_SESSION['customer']);
        ?>
          <p>パスワードを入力してください。</p>
          <p><a href="user_new.php"><input type="submit" value="会員登録画面に戻る"></a></p>
          <?php
        } else {
          if ($_SESSION['customer']['prefecture'] == '') {
          ?>
            <!-- 表示(都道府県なしver) -->
            <p>お名前：<?= $_SESSION['customer']['name'] ?></p>
            <p>メールアドレス：<?= $_SESSION['customer']['email'] ?></p>
            <p>パスワード：<?= $_SESSION['customer']['password'] ?></p>
            <!-- hiddenで隠してpostする -->
            <form action="user_create.php" method="POST">
              <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
              <p><a href='user_create.php'><input type='submit' value='登録'></a></p>
              <p><input type="hidden" name="name" value="<?= $_SESSION['customer']['name'] ?>"></p>
              <p><input type="hidden" name="email" value="<?= $_SESSION['customer']['email'] ?>"></p>
              <p><input type="hidden" name="password" value="<?= $_SESSION['customer']['password'] ?>"></p>
            </form>
          <?php
          } elseif ($_SESSION['customer']['address'] == '') {
          ?>
            <!-- 表示(市区町村なしver) -->
            <p>お名前：<?= $_SESSION['customer']['name'] ?></p>
            <p>メールアドレス：<?= $_SESSION['customer']['email'] ?></p>
            <p>パスワード：<?= $_SESSION['customer']['password'] ?></p>
            <p>都道府県：<?= $_SESSION['customer']['prefecture'] ?></p>
            <!-- hiddenで隠してpostする -->
            <form action="user_create.php" method="POST">
              <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
              <p><a href='user_create.php'><input type='submit' value='登録'></a></p>
              <p><input type="hidden" name="name" value="<?= $_SESSION['customer']['name'] ?>"></p>
              <p><input type="hidden" name="email" value="<?= $_SESSION['customer']['email'] ?>"></p>
              <p><input type="hidden" name="password" value="<?= $_SESSION['customer']['password'] ?>"></p>
              <p><input type="hidden" name="prefecture" value="<?= $_SESSION['customer']['prefecture'] ?>"></p>
            </form>
          <?php
          } elseif ($_SESSION['customer']['address_other'] == '') {
          ?>
            <!-- 表示(マンション名その他なしver) -->
            <p>お名前：<?= $_SESSION['customer']['name'] ?></p>
            <p>メールアドレス：<?= $_SESSION['customer']['email'] ?></p>
            <p>パスワード：<?= $_SESSION['customer']['password'] ?></p>
            <p>都道府県：<?= $_SESSION['customer']['prefecture'] ?></p>
            <p>市区町村：<?= $_SESSION['customer']['address'] ?></p>
            <!-- hiddenで隠してpostする -->
            <form action="user_create.php" method="POST">
              <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
              <p><a href='user_create.php'><input type='submit' value='登録'></a></p>
              <p><input type="hidden" name="name" value="<?= $_SESSION['customer']['name'] ?>"></p>
              <p><input type="hidden" name="email" value="<?= $_SESSION['customer']['email'] ?>"></p>
              <p><input type="hidden" name="password" value="<?= $_SESSION['customer']['password'] ?>"></p>
              <p><input type="hidden" name="prefecture" value="<?= $_SESSION['customer']['prefecture'] ?>"></p>
              <p><input type="hidden" name="address" value="<?= $_SESSION['customer']['address'] ?>"></p>
            </form>
          <?php
          } else {
          ?>
            <!-- 全表示ver -->
            <p>お名前：<?= $_SESSION['customer']['name'] ?></p>
            <p>メールアドレス：<?= $_SESSION['customer']['email'] ?></p>
            <p>パスワード：<?= $_SESSION['customer']['password'] ?></p>
            <p>都道府県：<?= $_SESSION['customer']['prefecture'] ?></p>
            <p>市区町村：<?= $_SESSION['customer']['address'] ?></p>
            <p>マンション名：<?= $_SESSION['customer']['address_other'] ?></p>
            <!-- hiddenで隠してpostする -->
            <form action="user_create.php" method="POST">
              <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
              <p><a href='user_create.php'><input type='submit' value='登録'></a></p>
              <p><input type="hidden" name="name" value="<?= $_SESSION['customer']['name'] ?>"></p>
              <p><input type="hidden" name="email" value="<?= $_SESSION['customer']['email'] ?>"></p>
              <p><input type="hidden" name="password" value="<?= $_SESSION['customer']['password'] ?>"></p>
              <p><input type="hidden" name="prefecture" value="<?= $_SESSION['customer']['prefecture'] ?>"></p>
              <p><input type="hidden" name="address" value="<?= $_SESSION['customer']['address'] ?>"></p>
              <p><input type="hidden" name="address_other" value="<?= $_SESSION['customer']['address_other'] ?>"></p>
            </form>
    <?php
          }
        }
      }
    }
  } else {
    echo "不正なリクエストです";
    unset($_SESSION['customer']);
    unset($_SESSION['csrf_token']);
    ?>
    <p>もう一度やり直してください。</p>
    <p><a href="user_new.php"><input type="submit" value="会員登録画面に戻る"></a></p>
  <?php
  }
  ?>
</body>

</html>