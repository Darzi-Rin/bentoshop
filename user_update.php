<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登録情報変更ページ</title>
</head>

<!-- nav -->
<header>
  <?php require_once '_nav.php'; ?>
</header>

<body>
    <?php
    require_once '_db_access.php';
    // セッションidとsite_users(id)を比較する

    if ($_SESSION['customer']['prefecture'] == '') {
        // UPDATE文を変数に格納
        $sql = "UPDATE site_users SET email = :email, password = :password, name = :name, prefecture = :prefecture, address = :address, address_other = :address_other WHERE id = :id";

        // 更新する値と該当のIDは空のまま、SQL実行の準備をする
        $stm = $pdo->prepare($sql);

        // 挿入する値が複数の場合はカンマ区切りで追加する
        $stm->bindValue(':id', $_SESSION['customer']['id'], PDO::PARAM_INT);
        $stm->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
        $stm->bindValue(':password', $_POST['password'], PDO::PARAM_STR);
        $stm->bindValue(':name', $_POST['name'], PDO::PARAM_STR);
        $stm->bindValue(':prefecture', '', PDO::PARAM_STR);
        $stm->bindValue(':address', '', PDO::PARAM_STR);
        $stm->bindValue(':addressOther', '', PDO::PARAM_STR);
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
                'addressOther' => $row['addressOther'], 'password' => $row['password']
            ];
        }
    } elseif ($_SESSION['customer']['address'] == '') {
        // UPDATE文を変数に格納
        $sql = "UPDATE site_users SET email = :email, password = :password, name = :name, prefecture = :prefecture, address = :address, addressOther = :addressOther WHERE id = :id";

        // 更新する値と該当のIDは空のまま、SQL実行の準備をする
        $stm = $pdo->prepare($sql);

        // 挿入する値が複数の場合はカンマ区切りで追加する
        $stm->bindValue(':id', $_SESSION['customer']['id'], PDO::PARAM_INT);
        $stm->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
        $stm->bindValue(':password', $_POST['password'], PDO::PARAM_STR);
        $stm->bindValue(':name', $_POST['name'], PDO::PARAM_STR);
        $stm->bindValue(':prefecture', $_POST['prefecture'], PDO::PARAM_STR);
        $stm->bindValue(':address', '', PDO::PARAM_STR);
        $stm->bindValue(':addressOther', '', PDO::PARAM_STR);
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
                'addressOther' => $row['addressOther'], 'password' => $row['password']
            ];
        }
    } elseif ($_SESSION['customer']['addressOther'] == '') {
        // UPDATE文を変数に格納
        $sql = "UPDATE site_users SET email = :email, password = :password, name = :name, prefecture = :prefecture, address = :address, addressOther = :addressOther WHERE id = :id";

        // 更新する値と該当のIDは空のまま、SQL実行の準備をする
        $stm = $pdo->prepare($sql);

        // 挿入する値が複数の場合はカンマ区切りで追加する
        $stm->bindValue(':id', $_SESSION['customer']['id'], PDO::PARAM_INT);
        $stm->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
        $stm->bindValue(':password', $_POST['password'], PDO::PARAM_STR);
        $stm->bindValue(':name', $_POST['name'], PDO::PARAM_STR);
        $stm->bindValue(':prefecture', $_POST['prefecture'], PDO::PARAM_STR);
        $stm->bindValue(':address', $_POST['address'], PDO::PARAM_STR);
        $stm->bindValue(':addressOther', '', PDO::PARAM_STR);
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
                'addressOther' => $row['addressOther'], 'password' => $row['password']
            ];
        }
    } else {
        // UPDATE文を変数に格納
        $sql = "UPDATE site_users SET email = :email, password = :password, name = :name, prefecture = :prefecture, address = :address, addressOther = :addressOther WHERE id = :id";

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
                'addressOther' => $row['addressOther'], 'password' => $row['password']
            ];
        }
    }
    ?>
    <a href="index.php"><input type="submit" value="トップ"></a>
</body>

</html>