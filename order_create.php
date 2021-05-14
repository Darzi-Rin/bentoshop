<?php
session_start();
require "_login_check.php";
require_once "_token.php";
if (!isset($_SESSION['order'])) {
    $_SESSION['error'][] = "購入情報がありません。";
}
$postOrderToken = isset($_POST['orderToken']) ? $_POST['orderToken'] : NULL;
if (isset($_POST['orderToken']) && !checkToken('orderToken', $postOrderToken)) {
    $_SESSION['error'][] = "購入ページからアクセスしてください。\n\r購入ページを複数開いたりログアウトしないよう、お願いいたします。";
}
if (!isset($_SESSION['product'])) {
    $_SESSION['error'][] = "カートに商品がありません。\n\rカートをご確認ください。";
} else if (count($_SESSION['product']) < 1) {
    $_SESSION['error'][] = "カートに商品がありません。\n\rカートをご確認ください。";
}
$postProductToken = isset($_POST['productToken']) ? $_POST['productToken'] : NULL;
if (!checkToken('productToken', $postProductToken)) {
    $_SESSION['error'][] = "カートに変更があった可能性があります。";
}
if (!isset($_SESSION['error'])) {
    try {
        // require_once "db_access";
        // $sql = "";
        // $stmt = $pdo->prepare($sql);
        // $stmt->bindValue(':', '', PDO::PARAM_INT);
        // $stmt->execute();
        // $resullt = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // START TRANSACTION
        // INSERT INTO orders(id, paid, order_date_time, paid_date_time) 
        // VALUES(NULL, 0, NOW(), NULL);
        // SELECT MAX(id) INTO @numb FROM orders;
        // INSERT INTO purchases(id, site_user_id, product_code, order_id, count)
        // VALUES(NULL, 1, '00010000', @numb , 10);
        // COMMIT

        require_once "_db_access.php";
        // $user = 'lunch_site_user_update';
        // $password = 'tamakipass@edit';
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
        //     echo '<span class="error">エラーがありました。</span><br>';
        //     echo $e->getMessage();
        //     exit();
        // }
        $pdo->beginTransaction();
        $sql = "
        INSERT INTO orders(id, site_user_id, order_date_time, paid_date_time, receipt_date_time)
        VALUES(NULL, ?, NOW(), NULL, NULL);";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(1, $_SESSION['customer']['id'], PDO::PARAM_INT);
        $stmt->execute();
        $sql = "SELECT MAX(id) INTO @maxnum FROM orders;";
        $pdo->exec($sql);
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
        $bindNumber = 1;
        foreach ($_SESSION['product'] as $key => $value) {
            $stmt->bindValue($bindNumber++, $key, PDO::PARAM_STR);
            $stmt->bindValue($bindNumber++, $value['count'], PDO::PARAM_INT);
        }
        $stmt->execute();
        $pdo->commit();
    } catch (Exception $e) {
        $pdo->rollBack();
        $_SESSION['error'] = "データベースに問題がありました";
        echo $e->getMessage();
    }
}


?>
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
<?php unset($_SESSION['error']) ?>