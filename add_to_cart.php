<?php
session_start();
include("php/config.php");

if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $user_id = $_SESSION['user_id']; // สมมติว่าผู้ใช้ล็อกอินและมี user_id ในเซสชัน

    // บันทึกสินค้าในตะกร้า
    $sql = "INSERT INTO cart (user_id, product_id, quantity) VALUES ('$user_id', '$product_id', '$quantity') ON DUPLICATE KEY UPDATE quantity = quantity + $quantity";
    mysqli_query($con, $sql);
    
    header("Location: cart.php"); // เปลี่ยนไปที่หน้าแสดงตะกร้า
}
?>
