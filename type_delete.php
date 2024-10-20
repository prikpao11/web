<!doctype html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <title>จัดการประเภทสินค้า</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background: url('images/back.jpg') no-repeat center center fixed; /* Update the image path */
        background-size: cover; /* Ensures the image covers the entire background */
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 50px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #343a40;
        }

        table {
            margin-top: 20px;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        .btn-warning, .btn-danger {
            margin-left: 10px;
        }

        .form-control {
            display: inline-block;
            width: auto;
        }

        /* Responsive design for mobile */
        @media (max-width: 576px) {
            .form-control {
                width: 100%;
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center mb-4">จัดการประเภทสินค้า</h1>

        <?php
        include_once("php/config.php");

        // แสดงประเภทสินค้าทั้งหมด
        $sql = "SELECT * FROM `product_type` ORDER BY pt_name ASC";
        $result = mysqli_query($con, $sql);
        ?>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ชื่อประเภทสินค้า</th>
                    <th>จัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($data = mysqli_fetch_array($result)): ?>
                <tr>
                    <td>
                        <form method="post" action="">
                            <input type="text" class="form-control" name="new_pt_name" value="<?= $data['pt_name'] ?>" required>
                            <input type="hidden" name="pt_id" value="<?= $data['pt_id'] ?>">
                    </td>
                    <td>
                        <button type="submit" name="update" class="btn btn-warning">เปลี่ยนชื่อ</button>
                        <a href="?delete=<?= $data['pt_id'] ?>" class="btn btn-danger" onclick="return confirm('คุณแน่ใจว่าต้องการลบประเภทนี้?');">ลบ</a>
                    </td>
                    </form>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <?php
        // อัปเดตชื่อประเภทสินค้า
        if (isset($_POST['update'])) {
            $new_pt_name = $_POST['new_pt_name'];
            $pt_id = $_POST['pt_id'];

            $update_sql = "UPDATE `product_type` SET `pt_name` = '{$new_pt_name}' WHERE `pt_id` = {$pt_id}";
            mysqli_query($con, $update_sql) or die("อัปเดตชื่อประเภทสินค้าไม่ได้");

            echo "<script>alert('เปลี่ยนชื่อประเภทสินค้าสำเร็จ'); window.location='type_delete.php';</script>";
        }

        // ลบประเภทสินค้า
        if (isset($_GET['delete'])) {
            $pt_id = $_GET['delete'];

            // ตรวจสอบว่าประเภทสินค้านั้นมีอยู่จริงหรือไม่
            $check_sql = "SELECT * FROM `product` WHERE `pt_id` = {$pt_id}";
            $check_result = mysqli_query($con, $check_sql);

            if (mysqli_num_rows($check_result) > 0) {
                echo "<script>alert('ไม่สามารถลบประเภทสินค้านี้ได้ เนื่องจากมีสินค้าที่เกี่ยวข้องอยู่'); window.location='type_delete.php';</script>";
            } else {
                $delete_sql = "DELETE FROM `product_type` WHERE `pt_id` = {$pt_id}";
                mysqli_query($con, $delete_sql) or die("ลบประเภทสินค้าไม่ได้");
                echo "<script>alert('ลบประเภทสินค้าสำเร็จ'); window.location='type_delete.php';</script>";
            }
        }

        mysqli_close($con);
        ?>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
