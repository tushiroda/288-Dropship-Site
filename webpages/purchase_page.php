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

$itemName = urldecode($_GET["item"]);
$query = $conn->query("SELECT * FROM BestBuy WHERE name='{$itemName}'");
if (mysqli_num_rows($query) == 0) {
    $query = $conn->query("SELECT * FROM eBay WHERE name='{$itemName}'");
}

$item = $query->fetch_assoc();
?>

<head>
    <title>
        Checkout
    </title>
    <style>
        div {
            font-family: sans-serif;
        }

        .content {
            width: 80%;
            margin: auto;
            border: 1px solid black;
            box-sizing: border-box;
            padding: 1%;
        }

        .left {
            width: 65%;
            float: left;
            margin-right: 1%;
        }

        .right {
            width: 32%;
            float: left;
            margin-left: 1%;
        }

        .clearfix {
            clear: both;
        }

        .item-list {
            background-color: lightgray;
        }

        .item-wrapper {
            display: inline-flex;
            align-items: center;
            flex-direction: row;

        }

        .item-image {
            padding: 2%;
            background-color: white;
        }

        .item-content {
            box-sizing: border-box;
            margin: 3%;
        }

        .mb-3 {
            float: left;
        }

        .amount {
            float: right;
        }
    </style>
</head>

<body>
    <div class="content">
        <h1>Checkout</h1>
        Review Items
        <br>

        <div class="left">
            <div class="item-list">
                <!-- for each element in cart? -->
                <div class="item">
                    <?php echo "<div class=\"item-wrapper\">
                        <div class=\"item-image\">
                            <img src=\"" . $item["image"] . "\" style=width:100px;height:100px;object-fit:contain;>
                        </div>
                        <div class=\"item-content\">
                            {$item["name"]}
                            <p style=font-weight:bold;>$" . round($item["price"] * 1.15, 2) . "</p>
                        </div>
                    </div>"; ?>
                </div>
            </div>

            <br> <br>

            <div class="customer-info">
                <form id="info" action="purchased.php" onsubmit="return" method="POST">
                    <h3>Shipping Information (there's zero validation, so just input whatever)</h3>
                    <div class="mb-3" style="width:48%;">
                        <label class="form-label" for="first">First Name</label>
                        <input class="form-control" type="text" id="first" name="first" required />
                    </div>
                    <div class="mb-3" style="width:48%;margin-left:4%;">
                        <label class="form-label" for="last">Last Name</label>
                        <input class="form-control" type="text" id="last" name="last" required />
                    </div>
                    <div class="mb-3" style="width:100%;">
                        <label class="form-label" for="address">Shipping Address</label>
                        <input class="form-control" type="text" id="address" name="address" required />
                    </div>
                    <div class="mb-3" style="width:30%;">
                        <label class="form-label" for="city">City</label>
                        <input class="form-control" type="text" id="city" name="city" required />
                    </div>
                    <div class="mb-3" style="width:30%;margin-left:5%;">
                        <label class="form-label" for="state">State</label>
                        <input class="form-control" type="text" id="state" name="state" required />
                    </div>
                    <div class="mb-3" style="width:30%;margin-left:5%;">
                        <label class="form-label" for="zip">Zip Code</label>
                        <input class="form-control" type="text" id="zip" name="zip" required />
                    </div>
                    <div class="mb-3" style="width:100%;">
                        <label class="form-label" for="email">Email</label>
                        <input class="form-control" type="text" id="email" name="email" required />
                    </div>
                    <div class="mb-3" style="width:100%;">
                        <label class="form-label" for="phone">Phone Number</label>
                        <input class="form-control" type="text" id="phone" name="phone" required />
                    </div>

                    <h3>Payment Information</h3>
                    <div class="mb-3" style="width:48%;margin-right:52%;">
                        <label class="form-label" for="card">Card Number</label>
                        <input class="form-control" type="text" id="card" name="card" required />
                    </div>
                    <div class="mb-3" style="width:48%;">
                        <label class="form-label" for="expiration">Expiration Date</label>
                        <input class="form-control" type="text" id="expiration" name="expiration" required />
                    </div>
                    <div class="mb-3" style="width:48%; margin-left:4%;">
                        <label class="form-label" for="security">Security Code</label>
                        <input class="form-control" type="text" id="security" name="security" required />
                    </div>
                </form>
            </div>
        </div>

        <div class="right">

            <ul style="list-style:none;padding-left:0;">
                <li>
                    <span class="label">Items</span>
                    <span class="amount">$<?php echo round($item["price"] * 1.15, 2) ?></span>
                </li>
                <li>
                    <span class="label">Shipping (free!)</span>
                    <span class="amount">$0.00</span>
                </li>
                <li>
                    <span class="label">Tax (free!!!)</span>
                    <span class="amount">$0.00</span>
                </li>
                <br>
                <li>
                    <h2 style="display:inline;">Order Total</h2>
                    <h2 class="amount">$<?php echo round($item["price"] * 1.15, 2) ?></span>
                </li>
            </ul>

            <!-- wow, this is really lazy -->
            <?php $_SESSION["price"] = round($item["price"] * 1.15, 2)?>
            <input type="submit" form="info" class="mt-3 btn btn-primary" value="Confirm and Pay" style="width:100%;" />
        </div>

        <div class="clearfix"></div>
    </div>
</body>

</html>