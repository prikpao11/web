<?php
if (isset($_GET['pid'])) {
    include("php/config.php");

    // Prepare the DELETE statement to prevent SQL injection
    $pid = mysqli_real_escape_string($con, $_GET['pid']);
    
    // Fetch the picture name before deletion
    $result = mysqli_query($con, "SELECT p_picture FROM product WHERE p_id = '$pid'");
    
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        
        if ($row) {
            // Get the picture name
            $pictureName = $row['p_picture'];
            $filePath = "images/" . $pictureName; // Full path to the picture file

            // Delete the product record
            $sql = "DELETE FROM product WHERE p_id = '$pid'";
            if (mysqli_query($con, $sql)) {
                // Check if the file exists before attempting to delete
                if (file_exists($filePath)) {
                    unlink($filePath);
                } else {
                    echo "File does not exist.";
                }

                // Redirect to index page
                echo "<script>";
                echo "window.location='adminpage.php';";
                echo "</script>";
            } else {
                echo "Error deleting record: " . mysqli_error($con);
            }
        } else {
            echo "No product found with this ID.";
        }
    } else {
        echo "Error fetching product: " . mysqli_error($con);
    }
}
?>
