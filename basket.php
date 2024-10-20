<?php
session_start();
include("php/config.php");

// เพิ่มสินค้าในตะกร้า
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM product WHERE p_id='{$id}'";
    $rs = mysqli_query($con, $sql);
    $data = mysqli_fetch_array($rs);
    
    if ($data) {
        $_SESSION['sid'][$id] = $data['p_id'];
        $_SESSION['sname'][$id] = $data['p_name'];
        $_SESSION['sprice'][$id] = $data['p_price'];
        $_SESSION['spicture'][$id] = $data['p_picture'];
        $_SESSION['sitem'][$id] = isset($_SESSION['sitem'][$id]) ? $_SESSION['sitem'][$id] + 1 : 1;
    }
}

// อัปเดตจำนวนสินค้าจากฟอร์ม
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_SESSION['sid'] as $pid) {
        if (isset($_POST['quantity'][$pid])) {
            $_SESSION['sitem'][$pid] = intval($_POST['quantity'][$pid]);
        }
    }
}
?>

<!doctype html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <title>ตะกร้าสินค้า</title>
    <link href="bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('images/back.jpg') no-repeat center center fixed;
            background-size: cover;
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 50px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            margin-bottom: 30px;
            color: #007bff;
            text-align: center;
        }
        .table {
            margin-top: 20px;
            border-collapse: collapse;
            width: 100%;
        }
        .table th, .table td {
            vertical-align: middle;
            padding: 15px;
            border: 1px solid #dee2e6;
            text-align: center;
        }
        .table th {
            background-color: #007bff;
            color: white;
        }
        .btn {
            margin: 5px;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            transition: background-color 0.3s, transform 0.2s;
        }
        .btn:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }
        .btn:active {
            background-color: #004085;
            transform: scale(0.95);
        }
        .img-fluid {
            max-width: 120px;
            height: auto;
            border-radius: 5px;
        }
        .total {
            font-size: 1.5em;
            font-weight: bold;
            color: #007bff;
        }
    </style>
</head>
<body>
<div class="container">
    <h2 class="text-center">ตะกร้าสินค้า</h2>
    <div class="text-center">
        <button class="btn" onclick="window.location.href='home.php';">กลับไปเลือกสินค้า</button>
        <button class="btn" onclick="window.location.href='cleardel.php';">ลบสินค้าทั้งหมด</button>

        <?php if (empty($_SESSION['sid'])) { ?>
            <button class="btn" onclick="alert('กรุณาเลือกสินค้า');">สินค้า</button>
        <?php } else { ?>
            <button class="btn" onclick="window.location.href='payment.php';">สั่งซื้อสินค้า</button>
        <?php } ?>
    </div>

    <form method="post" action="">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ที่</th>
                    <th>รูปสินค้า</th>
                    <th>ชื่อสินค้า</th>
                    <th>ราคา/ชิ้น</th>
                    <th>จำนวน (ชิ้น)</th>
                    <th>รวม</th>
                    <th>ลบ</th>
                </tr>
            </thead>
            <tbody>
            <?php
            if (!empty($_SESSION['sid'])) {
                $total = 0;
                $i = 0;
                foreach ($_SESSION['sid'] as $pid) {
                    $i++;
                    $sum = $_SESSION['sprice'][$pid] * $_SESSION['sitem'][$pid];
                    $total += $sum;
            ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><img src="images/<?php echo $_SESSION['spicture'][$pid]; ?>" class="img-fluid" alt="Product Image"></td>
                    <td><?php echo $_SESSION['sname'][$pid]; ?></td>
                    <td><?php echo number_format($_SESSION['sprice'][$pid], 0); ?> บาท</td>
                    <td>
                        <input type="number" name="quantity[<?php echo $pid; ?>]" value="<?php echo $_SESSION['sitem'][$pid]; ?>" min="1" style="width: 60px; text-align: center;" onchange="this.form.submit();">
                    </td>
                    <td><?php echo number_format($sum, 0); ?> บาท</td>
                    <td><a href="clear2.php?id=<?php echo $pid; ?>" class="btn btn-danger">ลบ</a></td>
                </tr>
            <?php 
                }
            ?>
                <tr>
                    <td colspan="5" class="text-right total">รวมทั้งสิ้น</td>
                    <td class="total"><?php echo number_format($total, 0); ?> บาท</td>
                    <td></td>
                </tr>
            <?php 
            } else {
            ?>
                <tr>
                    <td colspan="7" height="50" class="text-center">ไม่มีสินค้าในตะกร้า</td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
