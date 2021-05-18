
<?php

$user = 'lunch_site_user_update';
$pass = 'tamakipass@edit';
$dbName = 'lunch_box_site';
$host = 'db-mysql.ctdfirp6fk1i.us-east-1.rds.amazonaws.com';

$dsn = "mysql:host={$host};dbname={$dbName};charset=utf8";

try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // echo "DB({$dbName})〇";
} catch (Exception $e) {
    echo "×";
    echo $e->getMessage();
    exit();
}
