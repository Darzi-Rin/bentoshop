<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/topNav.css">
    <title>購入履歴画面</title>
</head>

<body>
    <div class="content">
        <?php
        require '_nav.php';
        if (isset($_SESSION['customer'])) { ?>
            <!-- ログイン後の場合 -->
            <!-- purchase、purchase_detail、productテーブルからすべて表示する -->
            <?php
            //MySQLデータベースに接続する
            require '_db_access.php';

            //SQL文を作る（プレースホルダを使った式）
            $sql = "select * from purchases where order_id = :customer_id";
            //プリペアードステートメントを作る
            $stm = $pdo->prepare($sql);
            //プリペアードステートメントに値をバインドする
            $stm->bindValue(':customer_id', $_SESSION['customer']['id'], PDO::PARAM_STR);
            //SQL文を実行する
            $stm->execute();
            //結果の取得（連想配列で受け取る）
            $result1 = $stm->fetchAll(PDO::FETCH_ASSOC);

            foreach ($result1 as $r) {
                $total = 0;
                $sql = "select site_user_id from orders where site_user_id = :purchases_id";
                $stm = $pdo->prepare($sql);
                $stm->bindValue(':purchases_id', $r['order_id'], PDO::PARAM_STR);
                $stm->execute();
                $result2 = $stm->fetchAll(PDO::FETCH_ASSOC);
            ?>
                <table>
                    <th>商品番号</th>
                    <th>商品名</th>
                    <th>価格</th>
                    <th>個数</th>
                    <th>小計</th>
                    <?php
                    foreach ($result2 as $products) {
                        $sql = "select * from products where code = :purchases_id";
                        $stm = $pdo->prepare($sql);
                        $stm->bindValue(':purchases_id', $r['product_code'], PDO::PARAM_STR);
                        $stm->execute();
                        $result3 = $stm->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($result3 as $p_key) {
                    ?>
                            <tr>
                                <td><?= $p_key['code'] ?></td>
                                <td><?= $p_key['name'] ?></a></td>
                                <td><?= $p_key['cost'] ?></td>
                                <td><?= $r['count'] ?></td>
                                <?php
                                $subtotal = $p_key['cost'] * $r['count'];
                                $total += $subtotal;
                                ?>
                                <td><?= $subtotal ?></td>
                            </tr>
                    <?php
                        }
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
                <hr>
            <?php
            }
            ?>

        <?php } else { ?>
            <p>購入履歴を表示するには、ログインしてください。</p>
        <?php } ?>
    </div>
</body>

</html>