<?php
date_default_timezone_set('Asia/Tokyo');
session_start();
// 仮データ
// $_SESSION['customer']['id'] = 1;
// $_SESSION['customer']['name'] = "たまきさま";
// $_SESSION['customer']['prefecture'] = "埼玉県";
// $_SESSION['customer']['address'] = "越谷市";
// $_SESSION['customer']['addressOther'] = "";
// $_SESSION['products']['00010000']['count'] = 3;
// $_SESSION['products']['00010001']['count'] = 3;
// ログインの確認
require_once "_login_check.php";

require_once "_token.php";

// 購入ページの識別
$productToken = issueToken('productToken');


// カートの中身があるか
if (
    !isset($_SESSION['products'])
) {
    header("Location: ./cart_show.php");
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

//　配送日時
$nowHour = date('h');
if ($nowHour > 21) {
    $orderDate = date('Y-m-d', strtotime('1 day'));
    $orderDateMessage = "本日の配達は終了しました。翌日配送となります。";
} else {
    $orderDate = date('Y-m-d');
    $orderDateMessage = "配送は当日配送のみとなります。";
}
?>

<!-- view -->
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>購入手続き</title>
    <style>
        .hidden {
            visibility: hidden;
        }
    </style>
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

        <div id="formNameWrapper" class="hidden">
            <label for="formName">お名前 : <input type="text" name="name" id="formName" value="<?= $name ?>"></label>
            <?php if (isset($_SESSION['orderError']['name'])) echo "<div>" . $_SESSION['orderError']['name'] . "</div>"; ?>
        </div>
        <div id="formPrefectureWrapper" class="hidden">
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
        <div id="formAddressWrapper" class="hidden">
            <label for="formAddress">市町村 : <input type="text" name="address" id="formAddress" value="<?= htmlspecialchars($address)  ?>"></label>
            <?php if (isset($_SESSION['orderError']['address'])) echo "<div>" . $_SESSION['orderError']['address'] . "</div>"; ?>
        </div>
        <div id="formAddressOhterWrapper" class="hidden">
            <label for="formAddressOther">マンション名など : <input type="text" name="addressOther" id="formAddressOther" value="<?= htmlspecialchars($addressOther) ?>"></label>
            <?php if (isset($_SESSION['orderError']['addressOther'])) echo "<div>" . $_SESSION['orderError']['addressOther'] . "</div>"; ?>
        </div>
        <div id="formTimeWrapper" class="hidden">
            <p><?= $orderDateMessage ?></p>
            <label for="formTime"><span id="formTimeText"></span>希望時間:<?= $orderDate ?>
                <select name="datetime" id="formTime">
                    <?php for ($i = $nowHour > 21 || $nowHour < 5 ? 5 : $nowHour + 1; $i <= 21; $i++) :
                        $formHour = sprintf('%02d', $i); ?>
                        <option value="<?= $orderDate ?> <?= $formHour ?>:00"><?= $formHour ?>:00</option>
                    <?php endfor; ?>
                </select>以降
            </label>
            <?php if (isset($_SESSION['orderError']['datetimeOther'])) echo "<div>" . $_SESSION['orderError']['datetimeOther'] . "</div>"; ?>
        </div>
        <input type="hidden" name="productToken" value="<?= $productToken ?>">
        <div id="formSubmit" class="hidden"><input type="submit" value="確認画面へ"></div>
    </form>
</body>
<script>
    let formTypeFalse = document.getElementById('formTypeFalse');
    let formTypeTrue = document.getElementById('formTypeTrue');

    function formTypeFalseShow() {
        document.getElementById('formPrefectureWrapper').classList.add('hidden');
        document.getElementById('formAddressWrapper').classList.add('hidden');
        document.getElementById('formAddressOhterWrapper').classList.add('hidden');
        document.getElementById('formNameWrapper').classList.remove('hidden');
        document.getElementById('formTimeWrapper').classList.remove('hidden');
        document.getElementById('formSubmit').classList.remove('hidden');
        document.getElementById('formTimeText').innerHTML = '受け取り';
    }

    function formTypeTrueShow() {
        document.getElementById('formPrefectureWrapper').classList.remove('hidden');
        document.getElementById('formAddressWrapper').classList.remove('hidden');
        document.getElementById('formAddressOhterWrapper').classList.remove('hidden');
        document.getElementById('formNameWrapper').classList.remove('hidden');
        document.getElementById('formTimeWrapper').classList.remove('hidden');
        document.getElementById('formSubmit').classList.remove('hidden');
        document.getElementById('formTimeText').innerHTML = '配達';
    }
    if (formTypeFalse.checked) {
        formTypeFalseShow();
    }
    if (formTypeTrue.checked) {
        formTypeTrueShow();
    }
    document.getElementById('formTypeFalse').addEventListener('click', e => {
        formTypeFalseShow();
    });
    document.getElementById('formTypeTrue').addEventListener('click', e => {
        formTypeTrueShow();
    });
</script>

</html>
<?php unset($_SESSION['orderError']) ?>