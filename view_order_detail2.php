<?php
session_start();
include("php/config.php");

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    die("กรุณาเข้าสู่ระบบก่อนทำการดูรายละเอียดคำสั่งซื้อ");
}

// Get the order ID from the URL
$od_id = intval($_GET['id']);
$username = $_SESSION['username'];

// Fetch order details
$sql = "SELECT od.item, p.p_name, p.p_price FROM orders_detail od
        JOIN product p ON od.pid = p.p_id
        WHERE od.oid = '$od_id'";
$result = mysqli_query($con, $sql);

if (!$result) {
    die("Database query failed: " . mysqli_error($con));
}

if (mysqli_num_rows($result) == 0) {
    die("ไม่พบเลขที่ใบสั่งซื้อ");
}

// Fetch user address
$address_query = "SELECT user_adr FROM users WHERE username = '$username'";
$address_result = mysqli_query($con, $address_query);
$address = mysqli_fetch_assoc($address_result)['user_adr'] ?? 'ไม่พบที่อยู่';

?>

<!doctype html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <title>รายละเอียดคำสั่งซื้อ</title>
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
            max-width: 800px;
            margin: auto;
        }
        h2, h3 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #dee2e6;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #e9ecef;
        }
        .btn-primary {
            display: inline-block;
            padding: 10px 20px;
            margin: auto;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            transition: background-color 0.3s;
            margin-top: 20px;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>รายละเอียดคำสั่งซื้อ เลขที่ <?= $od_id; ?></h2>
    <h3>ที่อยู่การจัดส่ง: <?= htmlspecialchars($address); ?></h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ชื่อสินค้า</th>
                <th>ราคา/ชิ้น</th>
                <th>จำนวน</th>
                <th>รวม</th>
            </tr>
        </thead>
        <tbody>
        <?php
        // Display order details
        $total_amount = 0;
        while ($detail = mysqli_fetch_assoc($result)) {
            $sum = $detail['p_price'] * $detail['item'];
            $total_amount += $sum;
            echo "<tr>
                <td>{$detail['p_name']}</td>
                <td>" . number_format($detail['p_price'], 2) . "</td>
                <td>{$detail['item']}</td>
                <td>" . number_format($sum, 2) . "</td>
            </tr>";
        }
        ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="text-right">รวมทั้งสิ้น</td>
                <td><?= number_format($total_amount, 2); ?></td>
            </tr>
        </tfoot>
    </table>
    <div class="text-center">
        <a class="btn-primary" href="home.php">กลับไปหน้าแรก</a>
        <a class="btn-primary" href="ord_history.php">กลับไปยังประวัติการสั่งซื้อ</a>
    </div>
</div>
</body>
</html>
