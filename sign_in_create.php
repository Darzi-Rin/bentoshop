
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
	$stm->bindValue(':email',$_POST['email'],PDO::PARAM_STR);
	$stm->bindValue(':password',$_POST['password'],PDO::PARAM_STR);
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
			'prefecture' => $row['prefecture'],
			'address' => $row['address'], 
			'address_other' => $row['address_other']
		];
	}
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>ログイン画面</title>
	<link rel="stylesheet" href="navi.css">
</head>
<body>
	<?php
	if (isset($_SESSION['customer'])) {
		echo 'いらっしゃいませ、', $_SESSION['customer']['name'], 'さん。';
	} else {
		echo 'ログイン名またはパスワードが違います。';
	}
	?>
	<a href="index.php">トップ</a>
</body>

</html>