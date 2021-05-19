<?php
session_start();
date_default_timezone_set('Asia/Tokyo');

// データベースにアクセス
require_once "_db_access.php";

// おすすめ商品
try {
    $sql = "SELECT * FROM products 
    WHERE stock >= 0 
    AND code like '0001%' 
    ORDER BY stock DESC LIMIT 5";
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

// 混雑度
try {
    $sql = "
    SELECT TIME_FORMAT(will_received_date_time , '%H:%i') AS TIME FROM orders 
    LEFT JOIN purchases
    ON orders.id = purchases.order_id
    WHERE order_date_time > CURDATE()
    AND order_date_time < CURDATE() + 1;";
    $stmt = $pdo->query($sql);
    if ($stmt) {
        for ($i = 5; $i <= 21; $i++) {
            $busyList[sprintf('%02d', $i) . ':00'] = date('h') + 1 > $i ? -1 : 0;
        }
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($busyList[$row['TIME']] >= 0) $busyList[$row['TIME']]++;
        }
    }
} catch (Exception $e) {
    $productListError = "読み込みに失敗しました。";
    echo $e->getMessage();
}

// ログインしていたら注文情報を取得
if (isset($_SESSION['customer'])) {
    try {
        $sql = "
        SELECT id FROM orders 
        WHERE site_user_id = :site_user 
        AND paid_date_time IS NULL
        AND order_date_time < CURDATE() + 1
        AND order_date_time > CURDATE();";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':site_user', $_SESSION['customer']['id'], PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt && $row = $stmt->fetch(PDO::FETCH_ASSOC)) $yetPayMessage = "料金の支払いがお済みでない注文があります。";
    } catch (Exception $e) {
        $yetPayMessageError = "読み込みに失敗しました。";
        echo $e->getMessage();
    }
}

?>

<!-- view -->
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        #contents .ul-list-02 {
            list-style-type: none;
            width: 570px;
            margin: 1em 0;
        }

        #contents .ul-list-02 li {
            float: left;
            width: 185px;
            /* 幅調節 */
            margin-bottom: 4em;
        }

        #contents .ul-list-02 dl {
            height: 300px;
        }

        /* 高さ調節 */

        #contents .ul-list-02 dt {
            margin-bottom: 1em;
        }

        #contents .ul-list-02 dd {
            margin-bottom: 0.5em;
        }

        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .topNav {
            height: 44px;
            text-align: center;
            background-color: #ffffff;
            color: #fff;
        }

        .content {
            flex: 1;
            background-color: #eee;
            text-align: center;
            margin-top: 10px;
            padding-top: 20px;
        }

        table {
            margin-left: auto;
            margin-right: auto;
        }

        h1 {
            border-bottom: 3px solid #000;
        }
    </style>
    <title>トップ</title>
</head>

<body>
    <header class="topNav">
        <?php require_once "_nav.php"; ?>
    </header>
    <div class="content">
        <h1>お弁当屋</h1>
        <h2>お知らせ</h2>
        <h2>現在の混雑度</h2>
        <?php if (isset($busyList)) : ?>
            <table border="1">
                <tr>
                    <?php foreach ($busyList as $key => $item) : ?>
                        <th><?= $key ?></th>
                    <?php endforeach; ?>
                </tr>
                <tr>
                    <?php foreach ($busyList as $key => $item) : ?>
                        <?php if ($item === -1) : ?>
                            <td>受付終了</td>
                        <?php elseif ($item < 3) : ?>
                            <td>平常</td>
                        <?php elseif ($item < 6) : ?>
                            <td>やや混雑</td>
                        <?php else : ?>
                            <td>大変混雑</td>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tr>
            </table>
        <?php endif; ?>
        <h2>おすすめ商品</h2>
        <?php if (isset($productsList)) : ?>
            <table border="1">
                <tr>
                    <?php foreach ($productsList as $key => $item) : ?>
                        <th><a href="./product_show.php?name=<?= $item['name'] ?>"><?= $item['name'] ?></a></th>
                    <?php endforeach; ?>
                </tr>
                <tr>
                    <?php foreach ($productsList as $key => $item) : ?>
                        <td><a href="./product_show.php?name=<?= $item['name'] ?>"><img src="./imgs/<?= $item['code'] ?>.jpg" alt="" style="width:170px;"></a></td>
                    <?php endforeach; ?>
                </tr>
            </table>
        <?php else : ?>
            <p><?php if (isset($productListError)) echo $productListError ?></p>
        <?php endif; ?>
    </div>
</body>

</html>