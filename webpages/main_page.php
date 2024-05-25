<?php session_start(); ?>

<!DOCTYPE html>
<html>
<?php require ("nav.php"); ?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
    crossorigin="anonymous"></script>

<head>
    <title>Wow what a beautiful website</title>
    <style>
        .item-wrapper {
            display: inline-flex;
            align-items: center;
            flex-direction: row;
            padding-left: 30px;
            padding-block-end: 20px;

        }

        .item-image {
            padding-right: 30px;
        }

        .item-content {
            background-color: lightblue;
            box-sizing: border-box;
            width: 400px;
            padding: 10px
        }
    </style>
</head>

<body>
    <h1>
        Incredible Shop
    </h1>

    <?php

    $servername = "localhost";
    $username = "root";
    $password = "123";
    $database = "test";

    $conn = new mysqli($servername, $username, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $bestBuy = $conn->query("SELECT * FROM BestBuy");
    $eBay = $conn->query("SELECT * FROM eBay");

    // item stuff
    $dim = 150;

    if ($bestBuy->num_rows > 0) {
        while ($row = $bestBuy->fetch_assoc()) {
            echo "<div class=\"item-wrapper\">
                    <div class=\"item-image\">
                        <a href=\"product_page.php?id=" . $row["id"] . "\">
                            <img src=\"" . $row["image"] . "\" style=width:" . $dim . "px;height:" . $dim . "px;object-fit:contain;>
                        </a>
                    </div>
                    <div class=\"item-content\">
                        <a href=\"product_page.php?id=" . $row["id"] . "\">" . $row["name"] . "</a>
                        <p>" . $row["rating"] . "</p>       
                        <p style=font-weight:bold;>$" . round($row["price"] * 1.15, 2) . "</p>
                    </div>
                </div>";
        }
    } else {
        echo "Something went wrong.";
    }

    if ($eBay->num_rows > 0) {
        while ($row = $eBay->fetch_assoc()) {
            echo "<div class=\"item-wrapper\">
                    <div class=\"item-image\">
                        <a href=\"product_page.php?id=" . $row["id"] . "\">
                            <img src=\"" . $row["image"] . "\" style=width:" . $dim . "px;height:" . $dim . "px;object-fit:contain;>
                        </a>
                    </div>
                    <div class=\"item-content\">
                        <a href=\"product_page.php?id=" . $row["id"] . "\">" . $row["name"] . "</a>
                        <p>" . $row["rating"] . "</p>
                        <p style=font-weight:bold;>$" . round($row["price"] * 1.15, 2) . "</p>
                    </div>
                </div>";
        }
    } else {
        echo "Something went wrong.";
    }

    $conn->close();
    ?>
</body>

</html>