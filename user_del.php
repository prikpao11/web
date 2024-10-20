<?php
if (isset($_GET['id'])) {
    include("php/config.php");

    // Prepare the DELETE statement to prevent SQL injection
    $id = mysqli_real_escape_string($con, $_GET['id']);
    
    // Fetch the picture name before deletion
    $result = mysqli_query($con, "SELECT username FROM users WHERE id = '$id'");
    
    if ($result) {
        $row = mysqli_fetch_assoc($result);

            // Delete the product record
            $sql = "DELETE FROM users WHERE id = '$id'";
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

?>
