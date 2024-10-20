<?php 
session_start();
include("php/config.php");

if (!isset($_SESSION['valid'])) {
    header("Location: index.php");
    exit();
}

// Fetch all users from the database
$query = mysqli_query($con, "SELECT * FROM users");
if (!$query) {
    echo "Error fetching user data: " . mysqli_error($con);
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
    <title>User Management</title>
    <style>
        body {
            background: url('images/back.jpg') no-repeat center center fixed; /* Update the image path */
        background-size: cover; /* Ensures the image covers the entire background */
            background-color: #f8f9fa;
            color: #343a40;
        }
        .nav {
            background-color: #343a40;
            padding: 10px;
            color: white;
        }
        .nav .logo p {
            font-size: 24px;
            margin: 0;
            color: #ffffff;
        }
        .nav .dropdown-toggle {
            color: white;
            background-color: #343a40;
            border: none;
        }
        .nav .dropdown-toggle:hover {
            background-color: #495057;
        }
        .dropdown-menu a {
            padding: 10px 20px;
        }
        .card {
            margin-top: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            margin-top: 20px;
            margin-bottom: 20px;
            text-align: center;
        }
        table {
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            vertical-align: middle;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }
        .btn-primary:hover, .btn-danger:hover {
            filter: brightness(90%);
        }
    </style>
</head>
<body>
    <div class="nav">
        <div class="logo">
            <p><a href="adminpage.php" class="bi bi-phone"> Admin Luxe Studio</a></p>
        </div>
        <div class="right-links dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Menu
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href='edit.php?Id=<?php echo $res_id; ?>'>
                    Change Profile <i class="bi bi-pencil-fill"></i>
                </a>
                <a class="dropdown-item" href='basket.php?'>
                    Cart <i class="bi bi-bag-fill"></i>
                </a>
                <a class="dropdown-item" href='view_order.php?'>
                    Order <i class="bi bi-bag-fill"></i>
                </a>
                <a class="dropdown-item" href="php/logout.php?">
                    Log Out <i class="bi bi-box-arrow-right"></i>
                </a>
                <a class="dropdown-item" href="insert.php?">
                    Insert <i class="bi bi-plus-circle-fill"></i>
                </a>
                <a class="dropdown-item" href="edit_user.php?">
                    ข้อมูลลูกค้า <i class="bi bi-plus-circle-fill"></i>
                </a>
            </div>
        </div>
    </div>

    <main>
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <h2>User Management</h2>
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>User Type</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Loop through each user and display them
                            while ($user = mysqli_fetch_assoc($query)) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($user['Username']) . "</td>";
                                echo "<td>" . htmlspecialchars($user['user_type']) . "</td>";
                                echo "<td>
                                    <a href='usereditor.php?id=" . $user['Id'] . "' class='btn btn-primary'>Edit</a>
                                    <a href='user_del.php?id=" . $user['Id'] . "' class='btn btn-danger' onClick=\"return confirm('Are you sure you want to delete this user?');\">Delete</a>
                                </td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
