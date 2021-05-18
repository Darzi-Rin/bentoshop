<?php session_start(); ?>
<!DOCTYPE html>
<html lang='ja'>

<head>
  <meta charset='UTF-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
  <link rel="stylesheet" href="css/topNav.css">
  <link rel="stylesheet" href="css/navi.css">
  <title>登録完了画面</title>
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
        if (!(isset($_SESSION['customer']))) {
        ?>
          <li><a href="user_show.php">マイページ</a></li>
        <?php
        }
        ?>

        <?php //ログイン後は表示されないように処理
        if (isset($_SESSION['customer'])) {
        ?>
          <li><a href="sign_in_new.php">ログイン</a></li>
        <?php
        }
        ?>

        <?php //ログイン前は表示されないように処理
        if (!(isset($_SESSION['customer']))) {
        ?>
          <li><a href="sign_in_destroy.php">ログアウト</a></li>
        <?php
        }
        ?>


        <?php //ログイン後は表示されないように処理
        if (isset($_SESSION['customer'])) {
        ?>
          <li class="current"><a href="user_new.php">会員登録</a></li>
        <?php
        }
        ?>
      </ul>
    </nav>
  </header>
  <div class="content">
    <!-- メイン -->
    <?php
    // csrf対策

    //MySQLデータベースに接続する
    require '_db_access.php';

    if (isset($_POST["csrf_token"]) && $_POST["csrf_token"] === $_SESSION['csrf_token']) {
      // if分岐して住所アリverとなしverを作る
      if ($_SESSION['customer']['prefecture'] == '') {
        //SQL文を作成

        // nullで送るか、空の状態で送るか用相談
        $sql = "INSERT INTO site_users VALUES(null , :email  , :password , :name , :prefecture , :address , :addressOther)";
        //プリペアードステートメントを作成
        $stm = $pdo->prepare($sql);
        $stm->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
        $stm->bindValue(':password', $_POST['password'], PDO::PARAM_STR);
        $stm->bindValue(':name', $_POST['name'], PDO::PARAM_STR);
        $stm->bindValue(':prefecture', '', PDO::PARAM_STR);
        $stm->bindValue(':address', '', PDO::PARAM_STR);
        $stm->bindValue(':addressOther', '', PDO::PARAM_STR);
        //SQLを実行
        $stm->execute();
        echo "お客様情報を登録しました。";
      } elseif ($_SESSION['customer']['address'] == '') {
        //SQL文を作成
        $sql = "INSERT INTO site_users VALUES(null , :email  , :password , :name , :prefecture , :address , :addressOther)";
        //プリペアードステートメントを作成
        $stm = $pdo->prepare($sql);
        $stm->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
        $stm->bindValue(':password', $_POST['password'], PDO::PARAM_STR);
        $stm->bindValue(':name', $_POST['name'], PDO::PARAM_STR);
        $stm->bindValue(':prefecture', $_POST['prefecture'], PDO::PARAM_STR);
        $stm->bindValue(':address', '', PDO::PARAM_STR);
        $stm->bindValue(':addressOther', '', PDO::PARAM_STR);
        //SQLを実行
        $stm->execute();
        echo "お客様情報を登録しました。";
      } elseif ($_SESSION['customer']['addressOther'] == '') {
        //SQL文を作成
        $sql = "INSERT INTO site_users VALUES(null , :email  , :password , :name , :prefecture , :address , :addressOther)";
        //プリペアードステートメントを作成
        $stm = $pdo->prepare($sql);
        $stm->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
        $stm->bindValue(':password', $_POST['password'], PDO::PARAM_STR);
        $stm->bindValue(':name', $_POST['name'], PDO::PARAM_STR);
        $stm->bindValue(':prefecture', $_POST['prefecture'], PDO::PARAM_STR);
        $stm->bindValue(':address', $_POST['address'], PDO::PARAM_STR);
        $stm->bindValue(':addressOther', '', PDO::PARAM_STR);
        //SQLを実行
        $stm->execute();
        echo "お客様情報を登録しました。";
      } else {
        //SQL文を作成
        $sql = "INSERT INTO site_users VALUES(null , :email  , :password , :name , :prefecture , :address , :addressOther)";
        //プリペアードステートメントを作成
        $stm = $pdo->prepare($sql);
        $stm->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
        $stm->bindValue(':password', $_POST['password'], PDO::PARAM_STR);
        $stm->bindValue(':name', $_POST['name'], PDO::PARAM_STR);
        $stm->bindValue(':prefecture', $_POST['prefecture'], PDO::PARAM_STR);
        $stm->bindValue(':address', $_POST['address'], PDO::PARAM_STR);
        $stm->bindValue(':addressOther', $_POST['addressOther'], PDO::PARAM_STR);
        //SQLを実行
        $stm->execute();
        echo "お客様情報を登録しました。";
      }
    } else {
      echo "不正なリクエストです";
    ?>
      <?php unset($_SESSION['csrf_token']) ?>
      <p><a href="user_new.php"><input type="submit" value="会員登録画面に戻る"></a></p>
    <?php
    }
    ?>
    <?php unset($_SESSION['customer']); ?>
    <!-- トップページへ戻る -->
    <p><a href='index.php'><input type="button" value="トップページへ戻る"></a></p>
  </div>
</body>

</html>