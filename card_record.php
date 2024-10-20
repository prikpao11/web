<?php
session_start();
include("php/config.php");

// Check if the user has items in the cart
if (!empty($_SESSION['sid'])) {
    $user_id = $_SESSION['id'];  // Assuming you have user login functionality
    
    // Loop through the session data to insert each product into the database
    foreach ($_SESSION['sid'] as $pid) {
        $product_name = $_SESSION['sname'][$pid];
        $product_price = $_SESSION['sprice'][$pid];
        $product_quantity = $_SESSION['sitem'][$pid];
        $total_price = $product_price * $product_quantity;
        
        // Prepare SQL query to insert cart data into the database
        $sql = "INSERT INTO cart_record (id, p_id, p_name, p_price, p_qty, total_price)
                VALUES ('$d', '$pid', '$p_name', '$p_price', '$p_qty', '$total_price')";
                
        // Execute the query
        mysqli_query($con, $sql);
    }
    
    // Clear the session after recording the cart
    unset($_SESSION['sid']);
    unset($_SESSION['sname']);
    unset($_SESSION['sprice']);
    unset($_SESSION['spicture']);
    unset($_SESSION['sitem']);
    
    // Redirect to a confirmation page or display a success message
    header("Location: success.php");
} else {
    // No items in the cart
    header("Location: basket.php");
}
?>
