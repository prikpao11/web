<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Data Table Example</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.7/css/dataTables.dataTables.css" />

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/2.1.7/js/dataTables.js"></script>

    <script>
        $(document).ready(function () {
            $('#myTable').DataTable();
        });
    </script>
</head>
<body>
    <style>
        body {
            background: url('images/back.jpg') no-repeat center center fixed; /* Update the image path */
        background-size: cover; /* Ensures the image covers the entire background */
            background-color: #f0f2f5;
        }
    </style>
    <div class="container mt-5">
        <h2 class="text-center mb-4">User Data</h2>
        <table id="myTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Age</th>
                    <th>User Address</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Include your database configuration file
                include("php/config.php");

                // Prepare the SQL query to fetch users
                $sql = "SELECT id, username, email, age, user_adr FROM users"; // Adjust as necessary
                $result = mysqli_query($con, $sql);

                // Check if the query was successful and if there are results
                if ($result && mysqli_num_rows($result) > 0) {
                    // Loop through the result set
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['age']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['user_adr']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    // Handle the case where no records were found
                    echo "<tr><td colspan='5' class='text-center'>No records found.</td></tr>";
                }


                // Close the database connection
                mysqli_close($con);
                ?>
                <a href="edit_user.php?">อัพเดทข้อมูลผู้ใช้ <i class="bi bi-bag-fill"></i></a>
                <a href="adminpage.php?">กลับหน้าแรก <i class="bi bi-bag-fill"></i></a>

            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS (Optional, for additional Bootstrap features) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-1g85gqib1ZbEdX2h/RF6Ckp+6qY8UPUKE1dKthxlZ2pHRA2VXe3Zx85Ra14cNBY4" crossorigin="anonymous"></script>
</body>
</html>
