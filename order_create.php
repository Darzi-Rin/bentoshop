<?php
session_start();

// ログインのチェック
require "_login_check.php";

// トークンとカートの確認
require_once "_token.php";
if (!isset($_SESSION['order'])) {
    $_SESSION['orderError']['requirement'] = "購入情報がありません。";
}
$postOrderToken = isset($_POST['orderToken']) ? $_POST['orderToken'] : NULL;
if (isset($_POST['orderToken']) && !checkToken('orderToken', $postOrderToken)) {
    $_SESSION['orderError']['orderToken'] = "購入ページからアクセスしてください。\n\r購入ページを複数開いたりログアウトしないよう、お願いいたします。";
}
if (!isset($_SESSION['product'])) {
    $_SESSION['orderError']['noProduct'] = "カートに商品がありません。\n\rカートをご確認ください。";
} else if (count($_SESSION['product']) < 1) {
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
    // $user = 'lunch_site_user_update';
    // $password = '-';
    // // 利用するデータベース
    // $dbName = 'lunch_box_site';
    // // MySQLサーバ
    // $host = 'localhost';
    // // MySQLのDSN文字列
    // $dsn = "mysql:host={$host};dbname={$dbName};charset=utf8";
    // //MySQLデータベースに接続する
    // try {
    //     $pdo = new PDO($dsn, $user, $password);
    //     // プリペアドステートメントのエミュレーションを無効にする
    //     $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    //     // 例外がスローされる設定にする
    //     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // } catch (Exception $e) {
    //     echo $e->getMessage();
    //     exit();
    // }
    ksort($_SESSION['product']);
    try {
        // トランザクションの開始
        if ($pdo->beginTransaction()) {
            try {
                //　他のトランザクションの待機
                $sql = "SET SESSION TRANSACTION ISOLATION LEVEL SERIALIZABLE;";
                $pdo->exec($sql);

                // 在庫のチェックと減少
                foreach ($_SESSION['product'] as $key => $value) {
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
                INSERT INTO orders(id, site_user_id, order_date_time, paid_date_time, receipt_date_time)
                VALUES(NULL, ?, NOW(), NULL, NULL);";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(1, $_SESSION['customer']['id'], PDO::PARAM_INT);
                $stmt->execute();

                // 最大値の取得
                $sql = "SELECT MAX(id) INTO @maxnum FROM orders;";
                $pdo->exec($sql);

                // 購入情報のSQLを作成
                $sql = "
                INSERT INTO purchases(id, product_code, order_id, count)
                VALUES";
                $number = 1;
                foreach ($_SESSION['product'] as $key => $value) {
                    $sql .= "(NULL, ?, @maxnum , ?)";
                    if ($number >= count($_SESSION['product'])) break;
                    $number++;
                    $sql .= ",";
                }
                $sql .= ";";
                $stmt = $pdo->prepare($sql);

                // 値をセット
                $bindNumber = 1;
                foreach ($_SESSION['product'] as $key => $value) {
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
}
?>
<!-- view -->
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>完了しました</title>
</head>

<body>
    <h1>購入が完了しました</h1>
    <p>までにお支払いをお願いいたします</p>
</body>

</html>