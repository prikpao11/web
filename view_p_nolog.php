<?php
session_start();
include("php/config.php");

// Fetch product ID from URL
if (isset($_GET['id'])) {
    $p_id = mysqli_real_escape_string($con, $_GET['id']);

    // Fetch product details from the database
    $query = mysqli_query($con, "SELECT * FROM product WHERE p_id = '$p_id'");
    $product = mysqli_fetch_assoc($query);

    // Check if product exists
    if (!$product) {
        echo "<p class='text-danger'>ไม่พบข้อมูลสินค้า</p>";
        exit;
    }

    // Extract product details
    $p_name = htmlspecialchars($product['p_name']);
    $p_detail = htmlspecialchars($product['p_detail']);
    $p_price = htmlspecialchars($product['p_price']);
    $p_picture = htmlspecialchars($product['p_picture']);
} else {
    echo "<p class='text-danger'>ไม่มีสินค้าให้แสดง</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title><?php echo $p_name; ?></title>
    <style>
        body {
            background: url('images/back.jpg') no-repeat center center fixed; /* Update the image path */
        background-size: cover; /* Ensures the image covers the entire background */
            background-color: #f0f2f5;
        }
        .product-details {
            padding: 40px;
        }
        /* Navbar Styling */
        .navbar {
            background-color: #2b3e50;
            padding: 15px 20px;
            border-bottom: 3px solid #007bff;
        }
        .navbar-brand {
            font-size: 28px;
            color: #fff;
            font-weight: bold;
        }
        .navbar-nav .nav-link {
            color: #ddd;
            margin-right: 20px;
            transition: color 0.3s ease;
        }
        .nav-link:hover {
            color: #fff;
        }
        .product-image {
            max-width: 100%;
            height: auto;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
        }
        .btn-add-cart {
            background-color: #007bff;
            color: white;
            font-weight: bold;
            border-radius: 8px;
        }
        .btn-add-cart:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #2b3e50;">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Luxe Shop</a>
    </div>
    <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="register.php">สมัครสมาชิก</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="login.php">เข้าสู่ระบบ</a>
            </li>
        </ul>
</nav>

<div class="container product-details">
    <div class="row">
        <div class="col-md-6">
            <img src="images/<?php echo $p_picture; ?>" alt="<?php echo $p_name; ?>" class="product-image">
        </div>
        <div class="col-md-6">
            <h1><?php echo $p_name; ?></h1>
            <p class="price">฿<?php echo $p_price; ?></p>
            <p><?php echo $p_detail; ?></p>
            <a href="login.php?id=<?php echo $p_id; ?>" class="btn btn-add-cart">Add to Cart</a>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
