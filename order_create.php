<?php
session_start();

// ログインのチェック
require_once "_login_check.php";

// トークンとカートの確認
require_once "_token.php";
if (!isset($_SESSION['order'])) {
    $_SESSION['orderError']['requirement'] = "購入情報がありません。";
}
$postOrderToken = isset($_POST['orderToken']) ? $_POST['orderToken'] : NULL;
if (isset($_POST['orderToken']) && !checkToken('orderToken', $postOrderToken)) {
    $_SESSION['orderError']['orderToken'] = "購入ページからアクセスしてください。\n\r購入ページを複数開いたりログアウトしないよう、お願いいたします。";
}
if (!isset($_SESSION['products'])) {
    $_SESSION['orderError']['noProduct'] = "カートに商品がありません。\n\rカートをご確認ください。";
} else if (count($_SESSION['products']) < 1) {
    $_SESSION['orderError']['noProduct'] = "カートに商品がありません。\n\rカートをご確認ください。";
}
$postProductToken = isset($_POST['productToken']) ? $_POST['productToken'] : NULL;
if (!checkToken('productToken', $postProductToken)) {
    $_SESSION['orderError']['productToken'] = "カートに変更があった可能性があります。";
}

// データベース処理
if (!isset($_SESSION['orderError'])) {

    // データベース接続
    require_once "_db_access.php";

    // ksort($_SESSION['products']);
    try {
        // トランザクションの開始
        if ($pdo->beginTransaction()) {
            try {
                //　他のトランザクションの待機
                $sql = "SET SESSION TRANSACTION ISOLATION LEVEL SERIALIZABLE;";
                $pdo->exec($sql);

                // 在庫のチェックと減少
                foreach ($_SESSION['products'] as $key => $value) {
                    $sql = "UPDATE products SET stock = stock - :count WHERE code = :code AND stock >= :count2;";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindValue(":code", $key, PDO::PARAM_STR);
                    $stmt->bindValue(":count", $value['count'], PDO::PARAM_INT);
                    $stmt->bindValue(":count2", $value['count'], PDO::PARAM_INT);
                    $stmt->execute();
                    if ($stmt->fetch(PDO::FETCH_ASSOC)) {
                        $_SESSION['orderError']['products'][$key] = "在庫がありません。";
                    }
                }

                // 在庫がない場合ロールバックしてカートへ
                if (isset($_SESSION['orderError'])) {
                    $_SESSION['orderError']['database'] = "購入に問題がありました";
                    $pdo->rollBack();
                    header("Location: ./cart_show.php");
                    exit();
                }

                // 注文の作成
                $sql = "
                INSERT INTO orders(id, site_user_id, order_date_time, paid_date_time, will_received_date_time, received_date_time)
                VALUES(NULL, ?, NOW(), ?, NULL, NULL);";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(1, $_SESSION['customer']['id'], PDO::PARAM_INT);
                $stmt->bindValue(2, $_SESSION['order']['datetime'], PDO::PARAM_STR);
                $stmt->execute();

                // 最大値の取得
                $sql = "SELECT MAX(id) INTO @maxnum FROM orders;";
                $pdo->exec($sql);

                // 購入情報のSQLを作成
                $sql = "
                INSERT INTO purchases(id, product_code, order_id, count)
                VALUES";
                $number = 1;
                foreach ($_SESSION['products'] as $key => $value) {
                    $sql .= "(NULL, ?, @maxnum , ?)";
                    if ($number >= count($_SESSION['products'])) break;
                    $number++;
                    $sql .= ",";
                }
                $sql .= ";";
                $stmt = $pdo->prepare($sql);

                // 値をセット
                $bindNumber = 1;
                foreach ($_SESSION['products'] as $key => $value) {
                    $stmt->bindValue($bindNumber++, $key, PDO::PARAM_STR);
                    $stmt->bindValue($bindNumber++, $value['count'], PDO::PARAM_INT);
                }
                $stmt->execute();
                // 処理の完了
                $pdo->commit();
            } catch (Exception $e) {
                $_SESSION['orderError']['database'] = "データベースに問題がありました";
                echo $e->getMessage();
            }
        }
    } catch (Exception $e) {
        $pdo->rollBack();
        $_SESSION['orderError']['database'] = "データベースに問題がありました";
        echo $e->getMessage();
    }
}

if (isset($_SESSION['orderError'])) {
    header("Location: ./cart_show.php");
    exit();
} else {
    unset($_SESSION['products']);
}
?>
<!-- view -->
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
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
    <title>完了しました</title>
</head>

<body>
    <?php require_once "_nav.php"; ?>
    <h1>購入が完了しました</h1>
    <p>までにお支払いをお願いいたします</p>
</body>

</html>