
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
	<link rel="stylesheet" href="navi.css">
</head>

<body>
	<br>
	<?php
		require '_nav.php';
		echo 'ログアウトしました。';
	@session_destroy();
	?>
</body>

</html>

