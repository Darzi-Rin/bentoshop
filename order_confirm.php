<?php
session_start();
// ログインのチェック
require "_login_check.php";

require_once "_token.php";

// カートの確認
if (!isset($_SESSION['product'])) {
    $_SESSION['orderError']['orderNoProduct'] = "カートに商品がありません。\n\rカートをご確認ください。";
} else if (count($_SESSION['product']) < 1) {
    $_SESSION['orderError']['orderNoProduct'] = "カートに商品がありません。\n\rカートをご確認ください。";
}
$postProductToken = isset($_POST['productToken']) ? $_POST['productToken'] : NULL;
if (!checkToken('productToken', $postProductToken)) {
    $_SESSION['orderError']['productToken'] = "カートに変更があった可能性があります。";
}
if (isset($_SESSION['orderError'])) {
    header("Location: ./cart_show.php");
    exit();
}
$productToken = issueToken('productToken');

// 受け取りtypeのチェック
if (!isset($_POST['type'])) {
    $_SESSION['orderError']['type'] = "お受け取り方法が選択されていません。";
} else {
    switch ($_POST['type']) {
        case "0":
            $_SESSION['order']['type'] = "0";
            break;
        case "1":
            $_SESSION['order']['type'] = "1";
            break;
        default:
            $_SESSION['order']['type'] = $_POST['type'];
            $_SESSION['orderError']['type'] = "お受け取り方法の値が不正です。";
            break;
    }
}

// 名前のチェック四文字以上20文字以下
if (!isset($_POST['name'])) {
    $_SESSION['orderError']["name"] = "お名前が入力されていません。";
} else {
    $errorCheckNameStr = mb_strlen($_POST['name']);
    if ($errorCheckNameStr < 1 || $errorCheckNameStr > 20) {
        $_SESSION['orderError']["name"] = "お名前は１文字以上２０文字以内でご入力ください。";
    }
    $_SESSION['order']['name'] = $_POST['name'];
}

// 配送希望は住所のチェック、それ以外は住所の削除
if ($_SESSION['order']['type'] === "1") {
    // 都道府県のチェック関東圏のみ
    if (!isset($_POST['prefecture'])) {
        $_SESSION['orderError']["prefecture"] = "都道府県が入力されていません。";
    } else {
        $prefectures = [
            "茨城県", "栃木県", "群馬県", "埼玉県", "千葉県", "東京都", "神奈川県"
        ];
        $prefectureSearchKey = array_search($_POST['prefecture'], $prefectures);
        // 一致しなかったらエラーメッセージ格納それ以外はマッチされた値を代入、
        if ($prefectureSearchKey === false) {
            $_SESSION['order']['prefecture'] = $_POST['prefecture'];
            $_SESSION['orderError']["prefecture"] = "都道府県は関東圏のみ入力可能です。";
        } else {
            $_SESSION['order']['prefecture'] = $prefectures[$prefectureSearchKey];
        }
    }

    // 住所詳細チェック
    if (!isset($_POST['address'])) {
        $_SESSION['orderError']['address'] = "住所が入力されていません";
    } else {
        if (mb_strlen($_POST['address']) > 255) $_SESSION['orderError']['address'] = "住所は２５５文字以内でご入力ください。";
        $_SESSION['order']['address'] = $_POST['address'];
    }
    if (!isset($_POST['addressOther'])) {
        $_SESSION['orderError']['addressOther'] = "住所が入力されていません";
    } else {
        if (mb_strlen($_POST['addressOther']) > 255)  $_SESSION['orderError']['addressOther'] = "住所は２５５文字以内でご入力ください。";
        $_SESSION['order']['addressOther'] = $_POST['addressOther'];
    }
} else {
    $_SESSION['order']['prefecture'] = "";
    $_SESSION['order']['prefecture'] = "";
    $_SESSION['order']['addressOther'] = "";
}
if (isset($_SESSION['orderError'])) {
    header("Location: ./order_new.php");
    exit();
}
$orderToken = issueToken('orderToken');
?>

<!-- view -->
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>購入手続き</title>
</head>

<body>
    <h1>確認画面</h1>
    <table>
        <?php if ($_SESSION['order']['type'] === "0") : ?>
            <tr>
                <th>お受け取り方法</th>
                <td>店頭受け取り</td>
            </tr>
            <tr>
                <th>お名前</th>
                <td><?= $_SESSION['order']['name'] ?></td>
            </tr>
            <tr>
                <th>お受け取り日時</th>
                <td></td>
            </tr>
        <?php else :  ?>
            <tr>
                <th>お受け取り方法</th>
                <td>宅配サービス</td>
            </tr>
            <tr>
                <th>お名前</th>
                <td><?= $_SESSION['order']['name'] ?></td>
            </tr>
            <tr>
                <th>都道府県</th>
                <td><?= $_SESSION['order']['prefecture'] ?></td>
            </tr>
            <tr>
                <th>市町村</th>
                <td><?= $_SESSION['order']['address'] ?></td>
            </tr>
            <tr>
                <th>マンション名</th>
                <td><?= $_SESSION['order']['addressOther'] ?></td>
            </tr>
            <tr>
                <th>お受け取り日時</th>
                <td></td>
            </tr>
        <?php endif; ?>
        <tr>
            <td><input type="submit" value="戻る"></td>
            <td>
                <form action="./order_create.php" method="POST">
                    <input type="hidden" name="orderToken" value="<?= $orderToken ?>">
                    <input type="hidden" name="productToken" value="<?= $productToken ?>">
                    <input type="submit" value="購入する">
                </form>
            </td>
        </tr>
    </table>
</body>

</html>
<?php unset($_SESSION['orderError']); ?>