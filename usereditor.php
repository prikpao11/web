<?php
// Include the database configuration file
include("php/config.php");

// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['valid'])) {
    header("Location: index.php");
    exit();
}

// Fetch user ID from the query parameters
$userId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Initialize user data
$user = [];

// Fetch the user details based on the ID
if ($userId) {
    $query = mysqli_query($con, "SELECT * FROM users WHERE Id = $userId");
    if ($query) {
        $user = mysqli_fetch_assoc($query);
    } else {
        echo "Error fetching user data.";
        exit();
    }
} else {
    echo "Invalid user ID.";
    exit();
}

// Update user if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $age = $_POST['age'];
    $email = $_POST['email'];
    $user_type = $_POST['user_type'];
    $user_adr = $_POST['user_adr']; // New address field

    // Update query
    $updateSql = "UPDATE users SET Username=?, Age=?, Email=?, user_type=?, user_adr=? WHERE Id=?";
    $stmt = $con->prepare($updateSql);
    $stmt->bind_param("sisssi", $username, $age, $email, $user_type, $user_adr, $userId);
    $stmt->execute();
    $stmt->close();

    // Redirect back to this page
    header("Location: edit_user.php?id=$userId");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background: url('images/back.jpg') no-repeat center center fixed; /* Update the image path */
        background-size: cover; /* Ensures the image covers the entire background */
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
        }
        label {
            font-weight: bold;
        }
        .form-control {
            border-radius: 5px;
        }
        .btn {
            width: 100%; /* Makes buttons full width */
            padding: 10px; /* Adds padding for a more spacious look */
        }
        .btn-primary {
            background-color: #007bff; /* Bootstrap primary color */
            border: none;
        }
        .btn-secondary {
            background-color: #6c757d; /* Bootstrap secondary color */
            border: none;
        }
        .btn:hover {
            filter: brightness(0.9); /* Darkens buttons on hover */
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Edit User</h1>
    <form method="POST" action="">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['Id']); ?>">
        
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control" name="username" value="<?php echo htmlspecialchars($user['Username']); ?>" required>
        </div>

        <div class="form-group">
            <label for="age">Age:</label>
            <input type="number" class="form-control" name="age" value="<?php echo htmlspecialchars($user['Age']); ?>" required>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($user['Email']); ?>" required>
        </div>

        <div class="form-group">
            <label for="user_type">User Type:</label>
            <input type="text" class="form-control" name="user_type" value="<?php echo htmlspecialchars($user['user_type']); ?>" required>
        </div>

        <div class="form-group">
            <label for="user_adr">Address:</label> <!-- New Address Field -->
            <input type="text" class="form-control" name="user_adr" value="<?php echo htmlspecialchars($user['user_adr']); ?>" required>
        </div>

        <button type="submit" class="btn btn-primary">Update User</button>
        <a href="adminpage.php" class="btn btn-secondary">Back</a>
    </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
