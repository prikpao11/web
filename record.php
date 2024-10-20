<meta charset="utf-8">
<?php
session_start();
include("php/config.php");

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
}

// Calculate the total amount for the order
$total = 0;
$sum = []; // Initialize the array to store the total for each product

foreach ($_SESSION['sid'] as $pid) {
    // Calculate the total for each product
    $sum[$pid] = $_SESSION['sprice'][$pid] * $_SESSION['sitem'][$pid];
    $total += $sum[$pid]; // Add to the overall total
}

// Use the session username directly
$customer_name = $_SESSION['username'];

// Insert the order into the orders table
$sql = "INSERT INTO `orders` (ototal, odate, member_id) VALUES (?, CURRENT_TIMESTAMP, ?)";
$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, 'is', $total, $customer_name);

if (mysqli_stmt_execute($stmt)) {
    // Get the last inserted order ID
    $id = mysqli_insert_id($con);
    
    // Insert each item into the orders_detail table
    $sql2 = "INSERT INTO orders_detail (oid, pid, item) VALUES (?, ?, ?)";
    $stmt2 = mysqli_prepare($con, $sql2);

    foreach ($_SESSION['sid'] as $pid) {
        mysqli_stmt_bind_param($stmt2, 'iis', $id, $pid, $_SESSION['sitem'][$pid]);
        if (!mysqli_stmt_execute($stmt2)) {
            die("Error inserting order detail: " . mysqli_error($con));
        }
    }

    // Redirect to clear.php to clear the cart or show a success message
    header("Location: clear.php");
    exit();
} else {
    die("Error inserting order: " . mysqli_error($con));
}

// Close statements
mysqli_stmt_close($stmt);
mysqli_stmt_close($stmt2);
mysqli_close($con);
?>
