<?php
session_start();
// 仮データ
// $_SESSION['customer']['id'] = 1;
// $_SESSION['customer']['name'] = "たまきさま";
// $_SESSION['customer']['prefecture'] = "埼玉県";
// $_SESSION['customer']['address'] = "越谷市";
// $_SESSION['customer']['addressOther'] = "";
// $_SESSION['product']['00010000']['count'] = 3;
// $_SESSION['product']['00010001']['count'] = 3;
// ログインの確認
require "_login_check.php";

require "_token.php";
$productToken = issueToken('productToken');


// カートの中身があるか
if (
    !isset($_SESSION['product'])
) {
    header("Location: ./index.php");
    exit();
}

// 都道府県データ
$prefectures = [
    "茨城県", "栃木県", "群馬県", "埼玉県", "千葉県", "東京都", "神奈川県"
];

// 初回は会員データを使用、エラーなどで再入力の際は過去の入力を使用
$type = isset($_SESSION['order']['type']) ? $_SESSION['order']['type'] : "";
$name = isset($_SESSION['order']['name']) ? $_SESSION['order']['name'] : $_SESSION['customer']['name'];
$prefecture = isset($_SESSION['order']['prefecture']) ? $_SESSION['order']['prefecture'] : $_SESSION['customer']['prefecture'];
$address = isset($_SESSION['order']['address']) ? $_SESSION['order']['address'] : $_SESSION['customer']['address'];
$addressOther = isset($_SESSION['order']['addressOther']) ? $_SESSION['order']['addressOther'] : $_SESSION['customer']['addressOther'];
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
    <h1>仮フォーム</h1>
    <form action="./order_confirm.php" method="POST">
        <div>受け取り方法 :
            <div>
                <label for="formTypeFalse">店頭受け取り<input type="radio" name="type" id="formTypeFalse" value="0" <?php if ($type === "0") echo "checked"; ?>></label>
                <label for="formTypeTrue">宅配サービス<input type="radio" name="type" id="formTypeTrue" value="1" <?php if ($type === "1") echo "checked"; ?>></label>
                <?php if (isset($_SESSION['orderError']['type'])) echo "<div>" . $_SESSION['orderError']['type'] . "</div>"; ?>
            </div>
        </div>
        <div>
            <label for="formName">お名前 : <input type="text" name="name" id="formName" value="<?= $name ?>"></label>
            <?php if (isset($_SESSION['orderError']['name'])) echo "<div>" . $_SESSION['orderError']['name'] . "</div>"; ?>
        </div>
        <div>
            <label for="formPrefecture">住所 :
                <select name="prefecture" id="formPrefecture">
                    <option value="" <?php if ($prefecture === "") echo "selected"; ?>>県をお選びください</option>
                    <?php foreach ($prefectures as $item) : ?>
                        <option value="<?= $item ?>" <?php if ($item === $prefecture) "selected"; ?>><?= $item ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
            <?php if (isset($_SESSION['orderError']['prefecture'])) echo "<div>" . $_SESSION['orderError']['prefecture'] . "</div>"; ?>
        </div>
        <div>
            <label for="formAddress">市町村 : <input type="text" name="address" id="formAddress" value="<?= htmlspecialchars($address)  ?>"></label>
            <?php if (isset($_SESSION['orderError']['address'])) echo "<div>" . $_SESSION['orderError']['address'] . "</div>"; ?>
        </div>
        <div>
            <label for="formAddressOther">マンション名など : <input type="text" name="addressOther" id="formAddressOther" value="<?= htmlspecialchars($addressOther) ?>"></label>
            <?php if (isset($_SESSION['orderError']['addressOther'])) echo "<div>" . $_SESSION['orderError']['addressOther'] . "</div>"; ?>
        </div>
        <div>お届け時間<input type="text" name="datetime" id=""></div>
        <input type="hidden" name="productToken" value="<?= $productToken ?>">
        <div><input type="submit" value="確認画面へ"></div>
    </form>
</body>

</html>
<?php unset($_SESSION['orderError']) ?>