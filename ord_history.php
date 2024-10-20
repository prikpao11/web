<?php
session_start();
include("php/config.php");

// ตรวจสอบว่าผู้ใช้ล็อกอินอยู่หรือไม่
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// ดึงข้อมูลคำสั่งซื้อของผู้ใช้จากฐานข้อมูล
$username = $_SESSION['username'];
$sql = "SELECT oid, odate FROM orders WHERE member_id = '$username' ORDER BY odate DESC"; // ปรับตามโครงสร้างฐานข้อมูล
$result = mysqli_query($con, $sql);

if (!$result) {
    die("Database query failed: " . mysqli_error($con));
}
?>

<!doctype html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <title>ประวัติการสั่งซื้อ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('images/back.jpg') no-repeat center center fixed; /* Update the image path */
        background-size: cover; /* Ensures the image covers the entire background */
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        h2 {
            margin-bottom: 20px;
        }
        table {
            border-collapse: collapse;
        }
        th, td {
            text-align: center;
            vertical-align: middle;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>ประวัติการสั่งซื้อ</h2>
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>เลขที่คำสั่งซื้อ</th>
                <th>วันที่</th>
                <th>รายละเอียด</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($order = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= htmlspecialchars($order['oid']); ?></td>
                <td><?= htmlspecialchars($order['odate']); ?></td>
                <td><a class="btn btn-primary" href="view_order_detail2.php?id=<?= htmlspecialchars($order['oid']); ?>">ดูรายละเอียด</a></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    <a class="btn-primary" href="home.php">กลับไปหน้าแรก</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
