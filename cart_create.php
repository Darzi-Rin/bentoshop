<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>買い物かご画面</title>
	<link rel="stylesheet" href="css/topNav.css">
	<link rel="stylesheet" href="css/navi.css">
</head>

<body>
	<header class="topNav">
	<nav class="Nav">
        <ul>
            <li class="current"><a href="index.php">トップページ</a></li>
            <li><a href="product.php">メニュー</a></li>
            <li class="current"><a href="cart_show.php">カート</a></li>

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
                <li><a href="user_new.php">会員登録</a></li>
            <?php
            }
            ?>
        </ul>
    </nav>
	</header>
	<div class="content">
		<?php
		$code = $_REQUEST['code'];
		if (!isset($_SESSION['products'])) {
			$_SESSION['products'] = [];
		}
		$count = 0;
		if (isset($_SESSION['products'][$code])) {
			$count = $_SESSION['products'][$code]['count'];
		}
		$_SESSION['products']["$code"] = [
			'name' => $_REQUEST['name'],
			'cost' => $_REQUEST['cost'],
			'count' => $count + $_REQUEST['count']
		];
		require_once "_token.php";

		$productToken = issueToken('productToken');
		?>

		<a href="cart_show.php"><br><br>
			<input type="submit" value="カートに進む"></a>
		<a href="product.php"><br><br>
			<input type="submit" value="メニュー一覧に戻る"></a>
		<a href="order_new.php"><br><br>
			<input type="submit" value="購入"></a>
	</div>
</body>

</html>