<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>買い物かご画面</title>
    <link rel="stylesheet" type="text/css" href="css/topNav.css">
    <link rel="stylesheet" type="text/css" href="css/navi.css">
</head>
<br>
<br>

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
        unset($_SESSION['products'][$_REQUEST['code']]);
        require_once "_token.php";

        $productToken = issueToken('productToken');
        ?>
        カートから商品を削除しました。
        <?php
		if (!empty($_SESSION['products'])) {
		?>
			<table>
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
						<td><?= $code ?></td>
						<td><a href="product_show.php?name=<?= $product['name'] ?>"><?= $product['name'] ?></a></td>
						<td><?= $product['cost'] ?></td>
						<td><?= $product['count'] ?></td>
						<?php
						$subtotal = $product['cost'] * $product['count'];
						$total += $subtotal;
						?>
						<td><?= $subtotal ?></td>
						<td><a href="cart_destroy.php?code=<?= $code ?>">削除</a></td>
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
				<tr>
					<td>
						<a href="order_new.php"><input type="submit" value="購入"></a>
					</td>
				</tr>
			</table>
		<?php
		} else {
		?>
			<p>カートに商品がありません。</p>
			<?php
		}
		if (isset($_SESSION['orderError'])) {
			foreach ($_SESSION['orderError'] as $key => $item) {
			?>
				<p><?= $item ?></p>
		<?php
			}
		}
		?>
    </div>
</body>

</html>