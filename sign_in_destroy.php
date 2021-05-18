<?php session_start(); ?>

<?php
//customerのセッションの破棄
unset($_SESSION['customer']);
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>ログアウト画面</title>
	<link rel="stylesheet" href="css/topNav.css">
	<link rel="stylesheet" href="css/navi.css">
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
		<?php
		echo 'ログアウトしました。';
		@session_destroy();
		?>
	</div>
</body>

</html>