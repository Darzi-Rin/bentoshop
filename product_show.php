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
    <title>??????????????????</title>
</head>

<body>

    <header class="grovalNav">
        <nav class="Nav">
            <ul>
                <li><a href="index.php">??????????????????</a></li>
                <li class="current"><a href="product.php">????????????</a></li>
                <li><a href="cart_show.php">?????????</a></li>

                <?php //???????????????????????????????????????????????????
                if (isset($_SESSION['customer'])) {
                ?>
                    <li><a href="user_show.php">???????????????</a></li>
                <?php
                }
                ?>

                <?php //???????????????????????????????????????????????????
                if (!(isset($_SESSION['customer']))) {
                ?>
                    <li><a href="sign_in_new.php">????????????</a></li>
                <?php
                }
                ?>

                <?php //???????????????????????????????????????????????????
                if (isset($_SESSION['customer'])) {
                ?>
                    <li><a href="sign_in_destroy.php">???????????????</a></li>
                <?php
                }
                ?>


                <?php //???????????????????????????????????????????????????
                if (!(isset($_SESSION['customer']))) {
                ?>
                    <li><a href="user_new.php">????????????</a></li>
                <?php
                }
                ?>
            </ul>
        </nav>
    </header>
    <br>
    <main>

        <div class="localNav">
            <ul>
                <li class="curren"><a href="product.php" style="text-decoration: none;">??????????????????</a></li>
                <li><a href="product_lunch_box.php" style="text-decoration: none;">?????????</a></li>
                <li><a href="product_side_dishes.php" style="text-decoration: none;">?????????</a></li>
                <li><a href="product_side_menu.php" style="text-decoration: none;">?????????</a></li>
                <li><a href="product_event_menu.php" style="text-decoration: none;">????????????</a></li>
            </ul>
        </div>
        <div class="content">

            <?php
            //db??????
            require "_db_access.php";

            //sql??????
            $sql = "select * from products where name = :name";
            //????????????????????????????????????????????????
            $stm = $pdo->prepare($sql);
            //??????????????????????????????????????????????????????????????????
            $stm->bindValue(':name', $_REQUEST['name'], PDO::PARAM_STR);
            //SQL??????????????????
            $stm->execute();
            //????????????????????????????????????????????????
            $result = $stm->fetchAll(PDO::FETCH_ASSOC);


            foreach ($result as $row) {
            ?>
                <?php
                $name = $row['name'];
                $cost = $row['cost'];
                $code = $row['code'];
                $cal = $row['calorie'];
                $foodstuffs = $row['foodstuffs'];
                $description = $row['description'];
                $stock = $row['stock'];
                ?>

                <p><img src="./imgs/<?= $code ?>.jpg" alt="" style="width:450px;"></p>
                <p><?= $name ?></p>
                <p>???<?= $cost ?></p>
                <p><?= $description; ?></p>
                <p>?????????<?= $foodstuffs ?></p>
                <p>??????????????? <?= $cal ?></p>
                <p>?????? <?= $stock ?>???</p>
                <form action="cart_create.php" method="post">
                    <p>??????: <select name="count">
                            <?php
                            for ($i = 1; $i <= 10; $i++) {
                            ?>
                                <option value="<?= $i ?>"><?= $i ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </p>

                    <input type="hidden" name="code" value="<?= $row['code'] ?>">
                    <input type="hidden" name="name" value="<?= $row['name'] ?>">
                    <input type="hidden" name="cost" value="<?= $row['cost'] ?>">

                    <input type="submit" value="?????????????????????">

                </form>

            <?php
            }

            ?>

        </div>
</body>

</html>