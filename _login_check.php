<?php
$includeState = get_included_files();
// 直アクセスの禁止
if (array_shift($includeState) === __FILE__) {
    header("Location: ./index.php");
    exit();
}
if (!isset($_SESSION)) session_start();
// 時間があれば使う
// $_SESSION['remember'] = htmlspecialchars($_SERVER["REQUEST_URI"], ENT_QUOTES, 'UTF-8');
if (!isset($_SESSION['customer'])) {
    header("Location: ./sign_in_new.php");
    exit();
}
