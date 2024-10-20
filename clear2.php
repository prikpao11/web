<?php
session_start();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    unset($_SESSION['sid'][$id]);
    unset($_SESSION['sname'][$id]);
    unset($_SESSION['sprice'][$id]);
    unset($_SESSION['spicture'][$id]);
    unset($_SESSION['sitem'][$id]);
}

header("Location: basket.php"); // กลับไปที่หน้าตะกร้าสินค้า
exit();
?>
