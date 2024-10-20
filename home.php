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
            background-color: #f8f9fa; /* เปลี่ยนสีพื้นหลังให้เป็นสีที่นุ่มนวลกว่า */
            font-family: 'Arial', sans-serif;
        }

        /* Navbar Styling */
        .navbar {
            background-color: #343a40; /* เปลี่ยนสี Navbar */
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
            color: #343a40; /* เปลี่ยนสีตัวหนังสือ */
        }

        .sidebar .form-check-label {
            font-size: 16px;
            color: #555;
        }

        .sidebar .btn {
            margin-top: 20px;
            width: 100%;
            background-color: #007bff;
            color: white;
            font-weight: bold;
            border-radius: 8px;
            transition: background-color 0.3s;
        }

        .sidebar .btn:hover {
            background-color: #0056b3;
        }

        /* Product Grid Styling */
        .product-card {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            background-color: #ffffff;
        }

        .product-card:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .product-card img {
            width: 100%;
            height: 200px; /* ปรับความสูงให้เหมาะสม */
            object-fit: cover;
        }

        .product-card .card-body {
            padding: 15px;
        }

        .product-card .card-title {
            font-size: 18px; /* ปรับขนาดตัวอักษร */
            font-weight: bold;
            color: #333;
            margin-bottom: 8px;
        }

        .product-card .price {
            font-size: 16px; /* ปรับขนาดตัวอักษร */
            color: #28a745; /* เปลี่ยนสีให้สดใส */
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

        /* Main Content Padding */
        main {
            padding-bottom: 40px;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="home.php">Luxe Shop</a>

        <div class="collapse navbar-collapse">
            <div class="search-bar d-flex mx-auto">
                <form method="GET" action="" class="input-group ml-3">
                    <input type="text" class="form-control form-control-lg" name="kw" placeholder="Search products..." aria-label="Search products">
                </form>
            </div>
        </div>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    เมนูผู้ใช้
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="edit.php">แก้ไขข้อมูลส่วนตัว</a>
                    <a class="dropdown-item" href="basket.php">ตะกร้าสินค้า</a>
                    <a class="dropdown-item" href="ord_history.php">ประวัติการสั่งซื้อ</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="php/logout.php">ออกจากระบบ</a>
                </div>
            </li>
        </ul>

    </div>
</nav>

<main class="mt-2">
    <div class="container">
        <div class="row">
            <!-- Sidebar with checkboxes -->
            <div class="col-md-3">
                <div class="sidebar">
                    <h4>ประเภทสินค้า</h4>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#filterModal">
                        Filter
                    </button>
                </div>
            </div>

            <!-- Main content for products -->
            <div class="col-md-9">
                <div class="row">
                    <?php
                    $kw = isset($_GET['kw']) ? mysqli_real_escape_string($con, $_GET['kw']) : '';
                    $pt = isset($_GET['pt']) ? $_GET['pt'] : [];  // Ensure $pt is initialized as an array

                    $category_filter = '';
                    if (!empty($pt)) {
                        $pt_ids = implode("','", array_map(function($pt_id) use ($con) {
                            return mysqli_real_escape_string($con, $pt_id);
                        }, $pt));
                        $category_filter = "AND pt_id IN ('$pt_ids')";
                    }

                    // Fetch products based on search and selected categories
                    $sql = "SELECT * FROM product WHERE (p_name LIKE '%$kw%' OR p_detail LIKE '%$kw%') $category_filter";
                    $rs = mysqli_query($con, $sql);

                    if (mysqli_num_rows($rs) > 0) {
                        // Display products in a 4x4 grid
                        while ($data = mysqli_fetch_array($rs, MYSQLI_BOTH)) {
                            ?>
                            <div class="col-md-3 col-sm-6 mb-4">
                                <div class="product-card">
                                    <img src="images/<?php echo htmlspecialchars($data['p_picture']); ?>" alt="<?php echo htmlspecialchars($data['p_name']); ?>">
                                    <div class="card-body text-center">
                                        <h5 class="card-title"><?php echo htmlspecialchars($data['p_name']); ?></h5>
                                        <p class="price"><?php echo number_format($data['p_price'], 0); ?> บาท</p>
                                        <a href="basket.php?id=<?php echo $data['p_id']; ?>" class="btn btn-primary">หยิบลงตะกร้า</a>
                                        <a href="view_product.php?id=<?php echo $data['p_id']; ?>" class="btn btn-primary">ดูรายละเอียด</a>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        echo "<div class='col-12'><h4>ไม่พบสินค้าที่ค้นหา</h4></div>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Modal -->
    <div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="filterModalLabel">ประเภทสินค้า</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="GET" action="">
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                </div>
                </form>
            </div>
        </div>
    </div>

</main>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
