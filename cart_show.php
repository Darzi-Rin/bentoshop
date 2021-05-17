<?php session_start(); ?>
<?php require '_login_check.php'?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>買い物かご画面</title>
    <link rel="stylesheet" href="navi.css">

</head>
<br>
<body>
    <sign>
    <?php require '_nav.php'; ?>
<?php
if (!empty($_SESSION['products'])) {
?>
    <table>code
		<th>　　　　</th>
		<th>商品名</th>
		<th>価格</th>
		<th>個数</th>
		<th>小計</th>
		<?php
		$total = 0;
		foreach ($_SESSION['products'] as $code => $product) {
		?>
			<tr>
				<td><?= $id ?></td>
				<td><a href="product_show.php?id=<?= $id ?>"><?= $product['name'] ?></a></td>
				<td><?= $product['cost'] ?></td>
				<td><?= $product['count'] ?></td>
				<?php
				$subtotal = $product['cost'] * $product[''];
				$total += $subtotal;
				?>
				<td><?= $subtotal ?></td>
				<td><a href="cart_destroy.php?id=<?= $id ?>">削除</a></td>
			</tr>
		<?php
		}
		?>
		<tr>
			<td>合計</td>
			<td></td>
			<td></td>
			<td></td>
			<td><?= $total ?></td>
			<td></td>
		</tr>
    </table>
<?php
} else {
?>
    カートに商品がありません。
<?php
}
if(isset($_SESSION['orderError'])) {
foreach($_SESSION['orderError']as $key => $item){
?>
<p><?= $item ?></p>
<?php
}}
?>
    </sign>
</body>

</html>