<?php session_start(); ?>

<!DOCTYPE html>
<html>

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
if (isset($_POST['first'])) {
    $name = $_POST['first'] . " " . $_POST['last'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $card = $_POST['card'];
    $expiration = $_POST['expiration'];
    $security = $_POST['security'];

    $sql = "INSERT INTO Purchases (customer_name, customer_address, price, city, state, zip, email, phone, card, expiration, security) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $conn->execute_query($sql, [$name, $address, $_SESSION["price"], $city, $state, $zip, $email, $phone, $card, $expiration, $security]);

    mysqli_close($conn);
}
?>

<head>
    <title>Purchase Confirmed</title>
</head>

<body>
    <div style="text-align:center;">
        <br><br>
        <h1 style="margin:auto;">Thank you for your purchase!</h1>
        <br>
        <h3 style="margin:auto;">I guess you can just go back to the home page now?...</h3>
    </div>
</body>

</html>