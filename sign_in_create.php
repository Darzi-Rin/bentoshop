<?php session_start(); ?>

<?php
//customerセッション変数を破棄
unset($_SESSION['customer']);
//MySQLデータベースに接続する
require '_db_access.php';
//SQL文を作る（プレースホルダを使った式）
$sql = "select * from site_users where email = :email and password = :password";
//プリペアードステートメントを作る
$stm = $pdo->prepare($sql);
//プリペアードステートメントに値をバインドする
$stm->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
$stm->bindValue(':password', $_POST['password'], PDO::PARAM_STR);
//SQL文を実行する
$stm->execute();
//結果の取得（連想配列で受け取る）
$result = $stm->fetchAll(PDO::FETCH_ASSOC);
//customerセッションの設定
foreach ($result as $row) {
	$_SESSION['customer'] = [
		'id' => $row['id'],
		'name' => $row['name'],
		'email' => $row['email'],
		'password' => $row['password'],
		'prefecture' => $row['prefecture'],
		'address' => $row['address'],
		'addressOther' => $row['address_other']
	];
}
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="css/topNav.css">
	<link rel="stylesheet" href="css/navi.css">
	<title>ログイン画面</title>
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
  </header>	<div class="content">
	<?php require '_db_access.php'; ?>
	<?php
	if (isset($_SESSION['customer'])) {
		echo 'いらっしゃいませ、', $_SESSION['customer']['name'], 'さん。';
	} else {
		echo 'ログイン名またはパスワードが違います。';
	}
	?>
	<a href="index.php"><br><br>
		<input type="submit" value="トップ画面に戻る"></a>
	</div>
</body>

</html>