<?php session_start(); ?>

<!DOCTYPE html>
<html>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
    crossorigin="anonymous"></script>

<?php

require ("nav.php");
$servername = "localhost";
$username = "root";
$password = "123";
$database = "test";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$bestBuy = $conn->query("SELECT * FROM BestBuy WHERE id={$_GET["id"]}");
$eBay = $conn->query("SELECT * FROM eBay WHERE id={$_GET["id"]}");

$b = $bestBuy->fetch_assoc();
$e = $eBay->fetch_assoc();
?>

<head>
    <title>
        great page
    </title>
    <style>
        .half {
            width: 50%;
            float: left;
            display: inline-block;
            box-sizing: border-box;
            padding: 40px;
            text-align: center;
        }

        .item-wrapper {
            padding: 30px;
            background-color: lightgray;
        }

        img {
            padding: 10px;
            height: 350px;
            width: 350px;
            box-sizing: border-box;
            object-fit: contain;
            background-color: white;
            margin: auto;
        }

        .button-like {
            margin: auto;
            background-color: blue;
            width: 200px;
            height: 40px;
        }

        .button-link {
            display: block;
            height: 100%;
            width: 100%;

        }

        a {
            color: white;
            text-decoration: none;
            font-family: sans-serif;
            text-align: auto;
            margin: auto;
        }

        h2 {
            font-weight: normal;
        }
    </style>
</head>

<body>
    <h1>Products</h1>
    <div style="display:block; width:80%; margin:auto">
        <div class="half">
            <div class="item-wrapper" <?php if ($b["price"] < $e["price"])
                echo "style=\"background-color:lightgreen\";" ?>>
                    <div class="item-image">
                        <img src="<?php echo $b["image"] ?>">
                </div>
                <h3 class="item-name">
                    <?php echo $b["name"] ?>
                </h3>
                <h4>
                    <?php echo $b["rating"] ?>
                </h4>
                <h2 class="item-price" <?php if ($b["price"] < $e["price"])
                    echo "style=\"font-weight:bold;\""; ?>>
                    <?php echo "US \$" . round($b["price"] * 1.15, 2) ?>
                </h2>
                <form action="purchase_page.php?item=<?php echo urlencode($b["name"]) ?>" method="POST">
                    <input type="submit" class="mt-3 btn btn-primary" value="Buy it Now" style="width:100%" />
                </form>
                <p style="padding:5px;text-align:left;">
                    <?php echo $b["description"] ?>
                </p>
            </div>
        </div>
        <div class="half">
            <div class="item-wrapper" <?php if ($e["price"] < $b["price"])
                echo "style=\"background-color:lightgreen\";" ?>>
                    <div class="item-image">
                        <img src="<?php echo $e["image"] ?>">
                </div>
                <h3 class="item-name">
                    <?php echo $e["name"] ?>
                </h3>
                <h4>
                    <?php echo $e["rating"] ?>
                </h4>
                <h2 class="item-price" <?php if ($e["price"] < $b["price"])
                    echo "style=\"font-weight:bold;\""; ?>>
                    <?php echo "US \$" . round($e["price"] * 1.15, 2) ?>
                </h2>
                <form action="purchase_page.php?item=<?php echo urlencode($e["name"]) ?>" method="POST">
                    <input type="submit" class="mt-3 btn btn-primary" value="Buy it Now" style="width:100%" />
                </form>
                <p style="padding:5px;text-align:left;">
                    <?php echo 'eBay does descrptions in a weird way, so I couldn\'t get them :(' ?>
                </p>
            </div>
        </div>
    </div>
</body>

</html>