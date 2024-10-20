<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>เพิ่มสินค้า</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>body{
        background: url('images/back.jpg') no-repeat center center fixed; /* Update the image path */
        background-size: cover; /* Ensures the image covers the entire background */
    }
        .thumbnail {
            padding: 15px;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 10px;
        }

        .thumbnail img {
            width: 100%;
            height: auto;
            max-height: 250px; /* Set a max height to maintain the aspect ratio */
            object-fit: cover; /* Ensures images are cropped to fill the container */
            border-radius: 10px;
        }

        .caption {
            margin-top: 15px;
        }

        .fixed-size {
            width: 100%; /* Full width of the container */
            max-height: 250px; /* Define a consistent height */
            overflow: hidden; /* Hide overflow to ensure all images fit */
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">เพิ่มสินค้าใหม่</h1>

        <form method="post" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="pname">ชื่อสินค้า</label>
                <input type="text" class="form-control" name="pname" id="pname" placeholder="กรอกชื่อสินค้า" required autofocus>
            </div>

            <div class="form-group">
                <label for="pdetail">รายละเอียดสินค้า</label>
                <textarea class="form-control" name="pdetail" id="pdetail" rows="5" placeholder="กรอกรายละเอียดสินค้า"></textarea>
            </div>

            <div class="form-group">
                <label for="pprice">ราคา (บาท)</label>
                <input type="number" class="form-control" name="pprice" id="pprice" placeholder="กรอกราคา" required>
            </div>

            <div class="form-group">
                <label for="pimg">รูปภาพสินค้า</label>
                <input type="file" class="form-control-file" name="pimg" id="pimg" required>
            </div>

            <div class="form-group">
                <label for="pcat">ประเภทสินค้า (ถ้าต้องการเลือก)</label>
                <select class="form-control" name="pcat" id="pcat">
                    <option value="">เลือกประเภทสินค้า (ไม่บังคับ)</option>

                    <?php    
                    include_once("php/config.php");
                    $sql2 = "SELECT * FROM `product_type` ORDER BY pt_name ASC";
                    $rs2 = mysqli_query($con, $sql2);
                    while ($data2 = mysqli_fetch_array($rs2)){
                    ?>
                        <option value="<?=$data2['pt_id'];?>"><?=$data2['pt_name'];?></option>
                    <?php } ?>
                </select>
            </div>
            <a href="type_delete.php?">แก้ไขข้อมูลประเภทสินค้า<i class="bi bi-box-arrow-right"></i></a>
            <div class="form-group">
                <label for="new_pcat">หรือเพิ่มประเภทสินค้าใหม่</label>
                <input type="text" class="form-control" name="new_pcat" id="new_pcat" placeholder="กรอกประเภทสินค้าใหม่ (ถ้ามี)">
            </div>

            <button type="submit" name="Submit" class="btn btn-primary btn-block">เพิ่มสินค้า</button>
        </form>

        <hr>

        <?php
        if (isset($_POST['Submit'])) {
            // Get the original file name
            $file_name = $_FILES['pimg']['name'];
            $file_tmp_name = $_FILES['pimg']['tmp_name'];

            // Initialize the pt_id
            $pt_id = null;

            // If a new category is provided, insert it
            if (!empty($_POST['new_pcat'])) {
                $new_pcat = $_POST['new_pcat'];
                $sql_new_cat = "INSERT INTO `product_type` (`pt_id`, `pt_name`) VALUES (NULL, '{$new_pcat}')";
                mysqli_query($con, $sql_new_cat) or die("เพิ่มประเภทสินค้าใหม่ไม่ได้");

                // Get the id of the new category
                $pt_id = mysqli_insert_id($con); // Get the last inserted id
            } else {
                // If no new category, use the selected category if provided
                if (!empty($_POST['pcat'])) {
                    $pt_id = $_POST['pcat'];
                }
            }

            // Prepare the insert SQL statement
            if ($pt_id !== null) {
                $sql = "INSERT INTO `product` (`p_id`, `p_name`, `p_detail`, `p_price`, `p_picture`, `pt_id`) 
                        VALUES (NULL, '{$_POST['pname']}', '{$_POST['pdetail']}', '{$_POST['pprice']}', '{$file_name}', '{$pt_id}')";
            } else {
                $sql = "INSERT INTO `product` (`p_id`, `p_name`, `p_detail`, `p_price`, `p_picture`) 
                        VALUES (NULL, '{$_POST['pname']}', '{$_POST['pdetail']}', '{$_POST['pprice']}', '{$file_name}')";
            }

            // Run the query
            mysqli_query($con, $sql) or die("เพิ่มข้อมูลสินค้าไม่ได้");

            // Copy the uploaded file to the images folder with its original name
            copy($file_tmp_name, "images/".$file_name);

            // Show a success message and redirect
            echo "<script>";
            echo "alert('เพิ่มข้อมูลสินค้าสำเร็จ');";
            echo "window.location='adminpage.php';";
            echo "</script>";
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
