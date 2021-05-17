
<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>買い物かご画面</title>
	<link rel="stylesheet" href="navi.css">
</head>

<body>

	<?php require '_nav.php'; ?>
	<?php
	$id = $_REQUEST['id'];
	if (!isset($_SESSION['products'])) {
		$_SESSION['products'] = [];
	}
	$count = 0;
	if (isset($_SESSION['products'][$id])) {
		$count = $_SESSION['products'][$id]['count'];
	}
	$_SESSION['products'][$id] = [
		'name' => $_REQUEST['name'],
		'price' => $_REQUEST['price'],
		'count' => $count + $_REQUEST['count']
	];
	?>

</body>
<a href="cart_show.php"><br><br>
	<input type="submit" value="カートに進む"></a>
<a href="product.php"><br><br>
	<input type="submit" value="メニュー一覧に戻る"></a>
</html>