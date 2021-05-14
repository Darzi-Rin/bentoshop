
<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>買い物かご画面</title>
    <link rel="stylesheet" href="navi.css">
    <?php
    require '_navi.php'; 
    ?>

</head>
<br>
<body>
    <sign>
<?php
if (!empty($_SESSION['products'])) {
?>
    <table>
		<th>商品番号</th>
		<th>商品名</th>
		<th>価格</th>
		<th>個数</th>
		<th>小計</th>
		<?php
		$total = 0;
		foreach ($_SESSION['products'] as $id => $product) {
		?>
			<tr>
				<td><?= $id ?></td>
				<td><a href="product_show.php?id=<?= $id ?>"><?= $product['name'] ?></a></td>
				<td><?= $product['price'] ?></td>
				<td><?= $product['count'] ?></td>
				<?php
				$subtotal = $product['price'] * $product['count'];
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
    <form action="cart_destroy.php">
    カートに商品がありません。
    <input type="submit" value="研究">
    </form>
<?php
}
?>
    </sign>
</body>

</html>

