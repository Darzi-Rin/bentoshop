<?php
$includeState = get_included_files();
// 直アクセスの禁止
if (array_shift($includeState) === __FILE__) {
    header("Location: ./index.php");
    exit();
}
// トークンの作成
function issueToken($sessionName)
{
    $byte = openssl_random_pseudo_bytes(16);
    $token = bin2hex($byte);
    $_SESSION[$sessionName] = $token;
    return $token;
}
// トークンの確認
function checkToken($sessionName, $token)
{
    if (!isset($token) && !isset($_SESSION[$sessionName])) return false;
    if ($token !== $_SESSION[$sessionName]) return false;
    $_SESSION[$sessionName] = NULL;
    return true;
}
