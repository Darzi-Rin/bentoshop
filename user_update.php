<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/topNav.css">
    <link rel="stylesheet" type="text/css" href="css/navi.css">
    <title>登録情報変更完了ページ</title>
</head>


<body>
    <!-- nav -->
    <header class="topNav">
        <nav class="Nav">
            <ul>
                <li><a href="index.php">トップページ</a></li>
                <li><a href="product.php">メニュー</a></li>
                <li><a href="cart_show.php">カート</a></li>

                <?php //ログイン前は表示されないように処理
                if (isset($_SESSION['customer'])) {
                ?>
                    <li class="current"><a href="user_show.php">マイページ</a></li>
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
        require_once '_db_access.php';
        // UPDATE文を変数に格納
        $sql = "UPDATE site_users SET email = :email, password = :password, name = :name, prefecture = :prefecture, address = :address, address_other = :addressOther WHERE id = :id";

        // 更新する値と該当のIDは空のまま、SQL実行の準備をする
        $stm = $pdo->prepare($sql);

        // 挿入する値が複数の場合はカンマ区切りで追加する
        $stm->bindValue(':id', $_SESSION['customer']['id'], PDO::PARAM_INT);
        $stm->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
        $stm->bindValue(':password', $_POST['password'], PDO::PARAM_STR);
        $stm->bindValue(':name', $_POST['name'], PDO::PARAM_STR);
        $stm->bindValue(':prefecture', $_POST['prefecture'], PDO::PARAM_STR);
        $stm->bindValue(':address', $_POST['address'], PDO::PARAM_STR);
        $stm->bindValue(':addressOther', $_POST['addressOther'], PDO::PARAM_STR);
        $stm->execute();
        // 更新完了のメッセージ
        echo '更新完了しました';
        //customerのセッションの破棄
        unset($_SESSION['customer']);
        // //SQL文を作る（プレースホルダを使った式）
        $sql = "select * from site_users where name = :name and password = :password";
        //プリペアードステートメントを作る
        $stm = $pdo->prepare($sql);
        //プリペアードステートメントに値をバインドする
        $stm->bindValue(':name', $_POST['name'], PDO::PARAM_STR);
        $stm->bindValue(':password', $_POST['password'], PDO::PARAM_STR);
        //SQL文を実行する
        $stm->execute();
        //結果の取得（連想配列で受け取る）
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);
        //customerセッションの設定
        foreach ($result as $row) {
            $_SESSION['customer'] = [
                'id' => $row['id'], 'name' => $row['name'], 'email' => $row['email'],
                'prefecture' => $row['prefecture'], 'address' => $row['address'],
                'addressOther' => $row['address_other'], 'password' => $row['password']
            ];
        }

        ?>
        <a href="index.php"><input type="submit" value="トップ"></a>
    </div>
</body>

</html>