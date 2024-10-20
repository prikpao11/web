<?php
include_once("php/config.php");

// Check if the product ID (id) is set and is a valid number
if (!isset($_GET['id']) || !is_numeric($_GET['id']) || empty($_GET['id'])) {
    die("Product ID is missing or invalid. id: " . htmlspecialchars($_GET['id'] ?? 'not set'));
}

// Prepare and execute the query to fetch the product details
$productId = intval($_GET['id']); // Convert id to an integer for safety
$sql1 = "SELECT * FROM product WHERE p_id='{$productId}'";
$rs1 = mysqli_query($con, $sql1);

// Check if the query was successful
if ($rs1 === false) {
    die("Query failed: " . mysqli_error($con));
}

// Fetch the product data
if (mysqli_num_rows($rs1) > 0) {
    $data1 = mysqli_fetch_array($rs1);
} else {
    die("Product not found.");
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>แก้ไขสินค้า</title>
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
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">แก้ไขสินค้า</h1>

        <form method="post" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="pname">ชื่อสินค้า</label>
                <input type="text" class="form-control" name="pname" id="pname" placeholder="กรอกชื่อสินค้า" required autofocus value="<?= htmlspecialchars($data1['p_name']); ?>">
            </div>

            <div class="form-group">
                <label for="pdetail">รายละเอียดสินค้า</label>
                <textarea class="form-control" name="pdetail" id="pdetail" rows="5" placeholder="กรอกรายละเอียดสินค้า"><?= htmlspecialchars($data1['p_detail']); ?></textarea>
            </div>

            <div class="form-group">
                <label for="pprice">ราคา (บาท)</label>
                <input type="number" class="form-control" name="pprice" id="pprice" placeholder="กรอกราคา" required value="<?= htmlspecialchars($data1['p_price']); ?>">
            </div>

            <div class="form-group">
                <label for="pimg">รูปภาพสินค้า</label>
                <input type="file" class="form-control-file" name="pimg" id="pimg">
                <small> 
                    <img src="images/<?= htmlspecialchars($data1['p_picture']); ?>" alt="Current Image" class="thumbnail" style="max-width: 200px; max-height: 200px;" />
                </small>
            </div>

            <div class="form-group">
                <label for="pcat">ประเภทสินค้า</label>
                <select class="form-control" name="pcat" id="pcat" required>
                    <option value="">เลือกประเภทสินค้า</option>
                    <?php    
                    $sql2 = "SELECT * FROM `product_type` ORDER BY pt_name ASC";
                    $rs2 = mysqli_query($con, $sql2);
                    while ($data2 = mysqli_fetch_array($rs2)){
                    ?>
                        <option value="<?= htmlspecialchars($data2['pt_id']); ?>" <?= ($data1['pt_id'] == $data2['pt_id']) ? "selected" : ""; ?>><?= htmlspecialchars($data2['pt_name']); ?></option>
                    <?php } ?>
                </select>
            </div>

            <button type="submit" name="Submit" class="btn btn-primary btn-block">บันทึก</button>
        </form>

        <hr>

        <?php
        if (isset($_POST['Submit'])) {
            // Prepare an update SQL statement
            if (empty($_FILES['pimg']['name'])) {
                // Update without changing the image
                $sql = "UPDATE `product` SET `p_name` = '{$_POST['pname']}', `p_detail` = '{$_POST['pdetail']}', `p_price` = '{$_POST['pprice']}', `pt_id` = '{$_POST['pcat']}' WHERE `product`.`p_id` = '{$productId}'";
            } else {
                // Update with new image
                $file_name = $_FILES['pimg']['name'];
                $upload_dir = "images/";
                $upload_path = $upload_dir . basename($file_name);
                
                // Move the uploaded file to the designated directory
                if (move_uploaded_file($_FILES['pimg']['tmp_name'], $upload_path)) {
                    // Resize the image after uploading
                    list($width, $height, $type) = getimagesize($upload_path);
                    $maxWidth = 800;
                    $maxHeight = 800;

                    // Calculate new dimensions while preserving the aspect ratio
                    if ($width > $maxWidth || $height > $maxHeight) {
                        $aspectRatio = $width / $height;

                        if ($width > $height) {
                            $newWidth = $maxWidth;
                            $newHeight = $maxWidth / $aspectRatio;
                        } else {
                            $newHeight = $maxHeight;
                            $newWidth = $maxHeight * $aspectRatio;
                        }

                        // Create a new true color image
                        $src = imagecreatefromstring(file_get_contents($upload_path));
                        $dst = imagecreatetruecolor($newWidth, $newHeight);
                        
                        // Preserve transparency for PNGs
                        if ($type == IMAGETYPE_PNG) {
                            imagealphablending($dst, false);
                            imagesavealpha($dst, true);
                            $transparent = imagecolorallocatealpha($dst, 255, 255, 255, 127);
                            imagefilledrectangle($dst, 0, 0, $newWidth, $newHeight, $transparent);
                        }

                        // Resize the image
                        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
                        
                        // Save the resized image back to the original path
                        if ($type == IMAGETYPE_JPEG) {
                            imagejpeg($dst, $upload_path, 75); // 75 is the quality setting for JPEG
                        } elseif ($type == IMAGETYPE_PNG) {
                            imagepng($dst, $upload_path, 6); // 6 is the compression level for PNG
                        }
                        
                        imagedestroy($src);
                        imagedestroy($dst);
                    }

                    $sql = "UPDATE `product` SET `p_name` = '{$_POST['pname']}', `p_detail` = '{$_POST['pdetail']}', `p_price` = '{$_POST['pprice']}', `pt_id` = '{$_POST['pcat']}', `p_picture` = '{$file_name}' WHERE `product`.`p_id` = '{$productId}'";
                } else {
                    die("Failed to upload image.");
                }
            }

            // Execute the update query
            if (mysqli_query($con, $sql)) {
                echo "<script>alert('แก้ไขข้อมูลสินค้าสำเร็จ'); window.location='adminpage.php';</script>";
            } else {
                die("แก้ไขข้อมูลสินค้าไม่ได้: " . mysqli_error($con));
            }
        }

        // Close the database connection
        mysqli_close($con);
        ?>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
