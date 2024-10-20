<?php
session_start();
include("php/config.php");

// ตรวจสอบการเชื่อมต่อฐานข้อมูล
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// ตรวจสอบว่ามีสินค้าในตะกร้าหรือไม่
if (empty($_SESSION['sid'])) {
    die("ไม่มีสินค้าในตะกร้า");
}

// ดึง ID ของสินค้าที่อยู่ในตะกร้า
$cart_items = implode(",", array_keys($_SESSION['sid']));

// ดึงรายละเอียดของสินค้า
$sql = "SELECT p.p_id, p.p_name, p.p_price FROM product p WHERE p.p_id IN ($cart_items)";
$result = mysqli_query($con, $sql);

if (!$result) {
    die("Database query failed: " . mysqli_error($con));
}

// ตรวจสอบว่ามีผลลัพธ์จากการดึงข้อมูลหรือไม่
if (mysqli_num_rows($result) == 0) {
    die("ไม่พบสินค้าที่ต้องการในฐานข้อมูล");
}

$total_amount = 0;
?>

<!doctype html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <title>ชำระเงิน</title>
    <link href="bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('images/back.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
        }
        
        .container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
            padding: 20px;
            max-width: 1000px;
            margin: auto;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
            font-size: 24px; /* ปรับขนาดฟอนต์เล็กลง */
            font-weight: bold; /* ทำให้ฟอนต์หนา */
        }

        .product {
            text-align: center;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f9f9f9;
            transition: transform 0.2s; /* เพิ่มการเคลื่อนไหว */
        }

        .product:hover {
            transform: scale(1.02); /* ขยายเมื่อ hover */
        }

        .product-name {
            font-size: 18px; /* ปรับขนาดฟอนต์ให้เล็กลง */
            font-weight: bold;
            margin-top: 10px;
        }

        .product-price {
            color: #007bff;
            font-size: 16px; /* ปรับขนาดฟอนต์ให้เล็กลง */
            margin-top: 5px;
        }

        .total-amount {
            text-align: right;
            font-size: 24px; /* ปรับขนาดฟอนต์ */
            margin-top: 20px;
            font-weight: bold;
            color: #28a745;
        }

        .btn {
            display: block; /* ทำให้ปุ่มอยู่กลาง */
            width: 200px; /* กำหนดความกว้างของปุ่ม */
            margin: 20px auto; /* ตั้งกลางแนวตั้งและแนวนอน */
            padding: 10px;
            font-size: 16px;
            font-weight: bold;
            color: #fff; /* สีตัวอักษร */
            background-color: #007bff; /* สีพื้นหลัง */
            border: none; /* ไม่มีกรอบ */
            border-radius: 5px; /* มุมโค้ง */
            transition: background-color 0.3s, transform 0.2s; /* เพิ่มการเปลี่ยนแปลง */
        }

        .btn:hover {
            background-color: #0056b3; /* สีพื้นหลังเมื่อ hover */
            transform: scale(1.05); /* ขยายปุ่มเมื่อ hover */
        }

        .btn:active {
            background-color: #004085; /* สีพื้นหลังเมื่อกด */
            transform: scale(0.95); /* ลดขนาดเมื่อกด */
        }
    </style>
</head>
<body>
<div class="container">
    <h2>สินค้าในตะกร้าและราคารวมทั้งหมด</h2>
    <img src="images/payment.jpg" alt="Payment Image" class="img-fluid" style="display: block; margin: 0 auto; max-width: 30%; height: auto;">

    <div class="row">
        <?php
        // แสดงสินค้าทั้งหมดในตะกร้า
        while ($product = mysqli_fetch_assoc($result)) {
            $quantity = $_SESSION['sitem'][$product['p_id']]; // ใช้จำนวนสินค้าจาก session
            $subtotal = $product['p_price'] * $quantity; // คำนวณยอดรวม
            $total_amount += $subtotal; // สะสมยอดรวม
            echo "<div class='col-md-3 product'>
                <div class='product-name'>{$product['p_name']}</div>
                <div class='product-price'>" . number_format($product['p_price'], 2) . " บาท (x$quantity)</div>
            </div>";
        }
        ?>
    </div>
    <button class="btn" onclick="window.location.href='record.php';">สั่งซื้อสินค้า</button>
    <div class="total-amount">ราคารวมทั้งหมด: <?= number_format($total_amount, 2); ?> บาท</div>
</div>
</body>
</html>
