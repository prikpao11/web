<?php 
session_start();
include("php/config.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <title>Home</title>
    <style>
        body {
            background: url('images/back.jpg') no-repeat center center fixed; /* Update the image path */
        background-size: cover; /* Ensures the image covers the entire background */
            background-color: #f0f2f5;
            font-family: 'Arial', sans-serif;
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

        /* Sidebar Styling */
        .sidebar {
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            position: sticky;
            top: 20px;
        }
        .sidebar h4 {
            font-size: 20px;
            margin-bottom: 15px;
            font-weight: bold;
            color: #2b3e50;
        }
        .sidebar .form-check-label {
            font-size: 16px;
            color: #555;
        }
        .sidebar .form-check {
            margin-bottom: 10px; /* Spacing between checkboxes */
        }
        .sidebar .btn {
            margin-top: 20px;
            width: 100%;
            background-color: #007bff;
            color: white;
            font-weight: bold;
            border-radius: 8px;
        }
        .sidebar .btn:hover {
            background-color: #0056b3;
        }

        /* Product Grid Styling */
        .product-card {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            background-color: #fff;
        }
        .product-card:hover {
            transform: scale(1.03);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }
        .product-card img {
            width: 100%;
            height: 220px;
            object-fit: cover;
        }
        .product-card .card-body {
            padding: 15px;
        }
        .product-card .card-title {
            font-size: 14px;
            font-weight: bold;
            color: #333;
            margin-bottom: 8px;
        }
        .product-card .price {
            font-size: 18px;
            color: #28a745;
            margin-bottom: 10px;
        }
        .product-card .btn {
            background-color: #007bff;
            color: white;
            font-weight: bold;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }
        .product-card .btn:hover {
            background-color: #0056b3;
        }

        /* Responsive Grid */
        @media (max-width: 767.98px) {
            .product-card img {
                height: 160px;
            }
        }

        /* Form Styling */
        .form-control {
            border-radius: 30px;
            padding: 14px 22px;
            border: 1px solid #ced4da;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
            font-size: 18px;
        }
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 6px rgba(0, 123, 255, 0.25);
        }

        /* Search Bar Styling */
        .search-bar {
            width: 50%;
        }

        /* Dropdown Styling */
        .dropdown-menu {
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }
        .swiper {
            width: 100%;
            height: 500px; /* Adjust height as needed */
        }
        .swiper-slide img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: contain; /* Ensures images cover the entire slide */
        }
        .swiper-pagination-bullet {
            background: rgba(255, 255, 255, 0.7);
            width: 12px; /* Bullet width */
            height: 12px; /* Bullet height */
        }
        .swiper-pagination-bullet-active {
            background: #007bff; /* Active bullet color */
        }
        .swiper-button-next,
        .swiper-button-prev {
            color: #fff; /* Arrow color */
        }

        /* Main Content Padding */
        main {
            padding-bottom: 40px;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Luxe Shop</a>
        <div class="collapse navbar-collapse">
            <div class="search-bar d-flex mx-auto">
                <form method="GET" action="" class="input-group">
                    <input type="text" class="form-control" name="kw" placeholder="Search products..." aria-label="Search products" oninput="this.form.submit()">
                </form>
            </div>
        </div>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="register.php">สมัครสมาชิก</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="login.php">เข้าสู่ระบบ</a>
            </li>
        </ul>
    </div>
</nav>

<!-- Swiper Carousel -->


<main class="mt-5">
    <div class="container">
        <div class="row">
            <!-- Sidebar with checkboxes -->
            <div class="col-md-3">
                <div class="sidebar">
                    <form method="GET" action="">
                        <h4>ประเภทสินค้า</h4>
                        <?php
                        // Fetch categories
                        $query_categories = mysqli_query($con, "SELECT * FROM product_type");
                        if ($query_categories) {
                            while ($category = mysqli_fetch_assoc($query_categories)) {
                                $pt_id = htmlspecialchars($category['pt_id']);
                                $pt_name = htmlspecialchars($category['pt_name']);
                                // Initialize $pt as an array if it's not set
                                $pt = isset($_GET['pt']) ? $_GET['pt'] : [];
                                $checked = in_array($pt_id, $pt) ? "checked" : "";
                                echo "<div class='form-check'>
                                        <input class='form-check-input' type='checkbox' name='pt[]' value='$pt_id' id='pt_$pt_id' $checked>
                                        <label class='form-check-label' for='pt_$pt_id'>$pt_name</label>
                                      </div>";
                            }
                        }
                        ?>
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </form>
                </div>
            </div>

            <!-- Product Grid -->
            <div class="col-md-9">
                <div class="row">
                    <?php
                    $kw = isset($_GET['kw']) ? mysqli_real_escape_string($con, $_GET['kw']) : '';
                    $pt = isset($_GET['pt']) ? $_GET['pt'] : [];

                    $s = !empty($pt) ? "AND (pt_id IN (" . implode(',', array_map('intval', $pt)) . "))" : "";
                    $query = mysqli_query($con, "SELECT * FROM product WHERE p_name LIKE '%$kw%' $s");
                    
                    if ($query) {
                        while ($row = mysqli_fetch_assoc($query)) {
                            $p_id = htmlspecialchars($row['p_id']);
                            $p_name = htmlspecialchars($row['p_name']);
                            $p_price = htmlspecialchars($row['p_price']);
                            $p_picture = htmlspecialchars($row['p_picture']);
                            echo "<div class='col-md-3 mb-3'>
                                    <div class='product-card card'>
                                        <img src='images/$p_picture' class='card-img-top' alt='$p_name'>
                                        <div class='card-body'>
                                            <h5 class='card-title'>$p_name</h5>
                                            <p class='price'>฿$p_price</p>
                                            <a href='view_p_nolog.php?id=$p_id' class='btn'>ดูรายละเอียด</a>
                                        </div>
                                    </div>
                                  </div>";
                        }
                    } else {
                        echo "<p class='text-danger'>ไม่พบข้อมูลสินค้า</p>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    var swiper = new Swiper('.swiper', {
        slidesPerView: 1,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });
</script>

</body>
</html>
