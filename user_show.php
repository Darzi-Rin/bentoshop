<?php session_start(); ?>
<!DOCTYPE html>
<html lang='ja'>

<head>
  <meta charset='UTF-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
  <title>マイページ</title>
</head>
<!-- header -->

<!-- 個人情報表示 -->
<body>
  <div class='personal_infomation'>
    <h2>個人情報</h2>
    <?php
    // データベース接続
    require '_db_access.php';

    // session(customer)に値が入っているかチェック
    if (!isset($_SESSION['customer'])) {
      echo '個人情報を確認するにはログインしてください。';
    } else {  //正常処理

      // 都道府県なしver
      if (!isset($_SESSION['customer']['prefecture'])) {
    ?>
      <p>お名前：<?= $_SESSION['customer']['name'] ?></p>
      <p>メールアドレス：<?= $_SESSION['customer']['email'] ?></p>
      <p><a href="user_show_log.php"><input type="submit" value="購入履歴へ"></a></p>
      <p><a href="user_edit.php"><input type="submit" value="登録情報変更"></a></p>
    <?php

      // 市区町村なしver
      } elseif (!isset($_SESSION['customer']['address'])) {
    ?>
      <p>お名前：<?= $_SESSION['customer']['name'] ?></p>
      <p>メールアドレス：<?= $_SESSION['customer']['email'] ?></p>
      <p>都道府県：<?= $_SESSION['customer']['prefecture'] ?></p>
      <p><a href="user_show_log.php"><input type="submit" value="購入履歴へ"></a></p>
      <p><a href="user_edit.php"><input type="submit" value="登録情報変更"></a></p>
    <?php

      // マンション名なしver
      } elseif (!isset($_SESSION['customer']['address_other'])) {
    ?>
      <p>お名前：<?= $_SESSION['customer']['name'] ?></p>
      <p>メールアドレス：<?= $_SESSION['customer']['email'] ?></p>
      <p>都道府県：<?= $_SESSION['customer']['prefecture'] ?></p>
      <p>市区町村：<?= $_SESSION['customer']['address'] ?></p>
      <p><a href="user_show_log.php"><input type="submit" value="購入履歴へ"></a></p>
      <p><a href="user_edit.php"><input type="submit" value="登録情報変更"></a></p>
    <?php
      } else {
    ?>
      <!-- 全表示ver -->
      <p>お名前：<?= $_SESSION['customer']['name'] ?></p>
      <p>メールアドレス：<?= $_SESSION['customer']['email'] ?></p>
      <p>都道府県：<?= $_SESSION['customer']['prefecture'] ?></p>
      <p>市区町村：<?= $_SESSION['customer']['address'] ?></p>
      <p>マンション名：<?= $_SESSION['customer']['address_other'] ?></p>
      <p><a href="user_show_log.php"><input type="submit" value="購入履歴へ"></a></p>
      <p><a href="user_edit.php"><input type="submit" value="登録情報変更"></a></p>
    <?php
      }
    }
    ?>
  </div>
</body>
</html>
