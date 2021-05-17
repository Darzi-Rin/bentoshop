<?php
session_start();

require_once "_db_access.php";
try {
    $sql = "SELECT * FROM products WHERE stock >= 0 AND code like '00101%' ORDER BY stock DESC LIMIT 5";
    $stmt = $pdo->query($sql);
    if ($stmt) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $productsList[] = array("code" => $row['code'], "name" => $row['name']);
        }
    }
} catch (Exception $e) {
    $productListError = "読み込みに失敗しました。";
    echo $e->getMessage();
}
// if (isset($_SESSION['customer'])) {
//     try {
// $sql = "
// SELECT OI,  FROM purchases 
// WHERE site_user = :site_user 
// JOIN orders 
// ON orders.id as OI = purchases.order_id as POI
// JOIN products 
// ON products.code as PC = purchases.product_code as PPC";

// $stmt = $pdo->prepare($sql);
// $stmt->bindValue(':site_user', $_SESSION['customer']['id'], PDO::PARAM_INT);
// $stmt->execute();
// if ($stmt) {
//     while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
//         $yetPayList[$row['OI']] = array("id" > $row['OI'], "name" => $row['name']);
//     }
//     if (isset($productsList)) {
//         $messageList = "料金の支払いがお済みでない注文があります。";
//     }
// }
// } catch (Exception $e) {
// }
// }

?>

<!-- view -->
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>トップ</title>
</head>

<body>
    <?php require_once "_nav.php"; ?>
    <h1>お弁当屋</h1>
    <h2>お知らせ</h2>
    <h2>現在の混雑度</h2>
    <table>
        <tr>

        </tr>
        <tr>
            <td></td>
        </tr>
    </table>
    <h2>おすすめ商品</h2>
    <?php if (isset($productsList)) : ?>
        <table border="1">
            <tr>
                <?php foreach ($productsList as $key => $item) : ?>
                    <th><a href=""><?= $item['name'] ?></a></th>
                <?php endforeach; ?>
            </tr>
            <tr>
                <?php foreach ($productsList as $key => $item) : ?>
                    <td><a href=""><img src="./imgs/<?= $item['code'] ?>.jpg" alt=""></a></td>
                <?php endforeach; ?>
            </tr>
        </table>
    <?php else : ?>
        <p><?php if (isset($productListError)) echo $productListError ?></p>
    <?php endif; ?>
    <?php if (isset($_SESSION['customer'])) : ?>
        <h2>あなたのカート</h2>
        <?php if (isset($_SESSION['product'])) : ?>
            <table>
                <?php foreach ($_SESSION['product'] as $key => $item) : ?>
                    <tr>
                        <th><?= $item['name'] ?></th>
                        <td><a href=""><img src=".imgs/<?= $item['code'] ?>.jpg" alt=""></a></td>
                        <td><?= $item['count'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    <?php endif; ?>
</body>

</html>