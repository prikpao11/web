<?php 
session_start();
include("php/config.php");

if (!isset($_SESSION['valid'])) {
    header("Location: index.php");
    exit();
}

$id = $_SESSION['id'];
$query = mysqli_query($con, "SELECT * FROM users WHERE Id=$id");

if ($query) {
    $result = mysqli_fetch_assoc($query);
    $res_Uname = htmlspecialchars($result['Username']);
    $res_Email = htmlspecialchars($result['Email']);
    $res_Age = htmlspecialchars($result['Age']);
    $res_id = htmlspecialchars($result['Id']);
} else {
    echo "Error fetching user data.";
    exit();
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <title>Home</title>
    <style>
        body {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('images/back.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #f0f2f5;
        }
        .nav {
            background-color: #343a40;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
        }
        .logo p a {
            font-size: 24px;
            color: white;
            text-decoration: none;
        }
        .nav-items a {
            color: white;
            margin-left: 15px;
            text-decoration: none;
        }
        .nav-items a:hover {
            text-decoration: underline;
        }
        .container {
            margin-top: 30px;
        }
        .thumbnail {
            border: none;
            border-radius: 10px;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8);
            transition: all 0.3s ease;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .thumbnail:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
        }
        .thumbnail img {
            border-radius: 10px;
            max-height: 200px;
            object-fit: cover;
            width: 100%;
        }
        .caption h4, .caption h5 {
            font-size: 18px;
            font-weight: 600;
            margin-top: 10px;
            color: #343a40;
        }
        .caption p a {
            margin-top: 10px;
        }
        .footer {
            background-color: #343a40;
            color: white;
            text-align: center;
            padding: 20px;
            position: relative;
            margin-top: 20px;
        }
        .search-bar {
            background-color: white;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 30px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .input-group {
            max-width: 1000px;
            margin: auto;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="nav">
        <div class="logo">
            <p><a href="adminpage.php" class="bi bi-phone"> Admin Luxe Studio</a></p>
        </div>
        <div class="nav-items">
            <a href="edit.php?Id=<?php echo $res_id; ?>">Change Profile <i class="bi bi-pencil-fill"></i></a>
            <a href="basket.php?">Cart <i class="bi bi-bag-fill"></i></a>
            <a href="view_order.php?">Orders <i class="bi bi-bag-fill"></i></a>
            <a href="insert.php?">Insert <i class="bi bi-plus-circle-fill"></i></a>
            <a href="display_users.php?">ข้อมูลลูกค้า <i class="bi bi-person-lines-fill"></i></a>
            <a href="php/logout.php?">Log Out <i class="bi bi-box-arrow-right"></i></a>
        </div>
    </div>

    <main>
        <form method="GET" action="" class="search-bar my-3">
            <div class="input-group">
                <div class="input-group-prepend">
                    <button class="btn btn-outline-primary dropdown-toggle" type="button" id="categoryDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        ประเภท
                    </button>
                    <div class="dropdown-menu" aria-labelledby="categoryDropdown">
                        <?php
                        $query_categories = mysqli_query($con, "SELECT * FROM product_type");
                        if ($query_categories) {
                            while ($category = mysqli_fetch_assoc($query_categories)) {
                                $pt_id = htmlspecialchars($category['pt_id']);
                                $pt_name = htmlspecialchars($category['pt_name']);
                                echo "<a class='dropdown-item' href='?pt=$pt_id'>$pt_name</a>";
                            }
                        } else {
                            echo "<a class='dropdown-item' href='#'>Error fetching categories.</a>";
                        }
                        ?>
                    </div>
                </div>
                <input type="text" class="form-control" name="kw" placeholder="Search products..." aria-label="Search products" style="height: 45px;">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">
                        <i class="bi bi-search"></i> Search
                    </button>
                </div>
            </div>
        </form>

        <div class="container">
            <div class="row">
                <?php
                $kw = isset($_GET['kw']) ? mysqli_real_escape_string($con, $_GET['kw']) : '';
                $pt = isset($_GET['pt']) ? mysqli_real_escape_string($con, $_GET['pt']) : '';

                $s = !empty($pt) ? "AND (pt_id = '$pt')" : "";
                $sql = "SELECT * FROM product WHERE (p_name LIKE '%$kw%' OR p_detail LIKE '%$kw%') $s";
                $rs = mysqli_query($con, $sql);

                if ($rs) {
                    while ($data = mysqli_fetch_array($rs, MYSQLI_BOTH)) {
                        ?>
                        <div class="col-md-4 mb-4">
                            <div class="thumbnail text-center">
                                <img src="images/<?php echo htmlspecialchars($data['p_picture']); ?>" class="img-fluid" alt="<?php echo htmlspecialchars($data['p_name']); ?>">
                                <div class="caption">
                                    <h4><?php echo htmlspecialchars($data['p_name']); ?></h4>
                                    <h5><?php echo number_format($data['p_price'], 0); ?> บาท</h5>
                                    <p><a href="update.php?id=<?php echo $data['p_id']; ?>" class="btn btn-primary">อัพเดทสินค้า</a></p>
                                    <a href="delete.php?pid=<?=$data['p_id'];?>&ext=<?=$data['p_picture'];?>" onClick="return confirm('ยืนยันการลบ');" class="btn btn-danger btn-sm">ลบ</a>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo "<p class='text-center'>Error fetching products.</p>";
                }
                ?>
            </div>
        </div>
    </main>

    <div class="footer">
        <p>&copy; 2024 Admin Luxe Studio. All rights reserved.</p>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
