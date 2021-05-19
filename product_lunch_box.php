<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .grovalNav {
            height: 44px;
            text-align: center;
            background-color: #ffffff;
            color: #fff;
        }

        main {
            min-height: 100vh;
            margin-top: 10px;
            text-align: center;
        }

        .content {
            flex: 1;
            text-align: center;
            margin-top: 0px;
            padding-top: 20px;
            background-color: #ece8e8;
        }

        table {
            margin-left: auto;
            margin-right: auto;
        }

        .localNav {
            padding-top: 50px;
            border-bottom: 1px solid #ccc;
        }

        .localNav ul {
            display: table;
            margin: 0 auto;
            padding: 0;
            width: 80%;
            text-align: center;
        }

        .localNav ul li {
            display: table-cell;
            min-width: 50px;
            border-right: 1px solid #ccc;
        }

        .localNav ul li:first-child {
            border-left: 1px solid #ccc;
        }

        .localNav ul li a {
            display: block;
            width: 100%;
            padding: 10px 0;
            text-decoration: none;
            color: rgb(0, 0, 0);
        }

        .localNav ul li a:hover {
            background-color: #eee;
            border-bottom: 5px solid #81817f;
        }

        .localNav ul li.curren {
            font-weight: bold;
        }

        .localNav ul li.curren a {
            border-bottom: 5px solid #2b2929;
        }

        .Nav ul {
            display: table;
            margin: 0 auto;
            padding: 0;
            width: 80%;
            text-align: center;
        }

        .Nav ul li {
            display: table-cell;
            min-width: 50px;
        }

        .Nav ul li a {
            display: block;
            width: 100%;
            padding: 10px 0;
            text-decoration: none;
            color: rgb(0, 0, 0);
            font-weight: bold;
        }

        .Nav ul li.current {
            background-color: #fcfcfc;
        }

        .Nav ul li.current a {
            color: rgb(255, 0, 0);
        }

        .Nav ul li:hover {
            border-bottom: 5px solid #ff0000;
        }
    </style>
    <title>お弁当</title>
</head>

<body>

    <header class="grovalNav">
        <nav class="Nav">
            <ul>
                <li><a href="index.php">トップページ</a></li>
                <li class="current"><a href="product.php">メニュー</a></li>
                <li><a href="cart_show.php">カート</a></li>

                <?php //ログイン前は表示されないように処理
                if (isset($_SESSION['customer'])) {
                ?>
                    <li><a href="user_show.php">マイページ</a></li>
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
    <main>
        <div class="localNav">
            <ul>
                <li><a href="product.php" style="text-decoration: none;">メニュー一覧</a></li>
                <li class="curren"><a href="product_lunch_box.php" style="text-decoration: none;">お弁当</a></li>
                <li><a href="product_side_dishes.php" style="text-decoration: none;">おかず</a></li>
                <li><a href="product_side_menu.php" style="text-decoration: none;">サイド</a></li>
                <li><a href="product_event_menu.php" style="text-decoration: none;">イベント</a></li>
            </ul>
        </div>
        <div class="content">
            <table>



                <?php

                require "_db_access.php";

                $sql = "select * from products where code like '___1%'";
                $stmt = $pdo->query($sql);
                foreach ($stmt as $row) {
                    $name = $row['name'];
                    $cost = $row['cost'];
                    $code = $row['code'];

                ?>
                    <tr>
                        <td><a href='product_show.php?name=<?php echo $name; ?>'><img src="./imgs/<?= $code ?>.jpg" alt="" style="width:170px;"></a></td>
                        <td><a href='product_show.php?name=<?php echo $name; ?>' style="color: black; text-decoration: none;"><?= $name; ?></a>
                            <br>
                            <br>
                            ￥<?= $cost; ?>
                        </td>
                        <!-- <td><a href='product_show.php?name=<?php echo $name; ?>'>詳細</a> -->
                        <td>
                            <form action="cart_create.php" method="post">
                                <input type="hidden" name="count" value="1">
                                <input type="hidden" name="code" value="<?= $row['code'] ?>">
                                <input type="hidden" name="name" value="<?= $row['name'] ?>">
                                <input type="hidden" name="cost" value="<?= $row['cost'] ?>">
                                <input type="submit" value="カートに入れる">
                            </form>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </table>
        </div>
    </main>
</body>

</html>