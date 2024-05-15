<?php
include '../header.php';
include '../db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming you've already validated and sanitized the input
    $username = $_POST['username'];
    $newPassword = $_POST['new_password']; // The new password to set

    // Hash the new password using MD5 (not recommended for security reasons)
    $newPasswordHash = md5($newPassword);

    // Create a MySQLi connection
    $conn = new mysqli('localhost', 'root', '', 'cms_db');

    // Check connection
    if ($conn->connect_error) {
        die("Could not connect to MySQL: " . $conn->connect_error);
    }

    // Prepare and execute the update query
    $updateQuery = "UPDATE users SET password = ? WHERE username = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param('ss', $newPasswordHash, $username);

    if ($stmt->execute()) {
        echo 'Password reset successfully.';
    } else {
        echo 'Error updating password: ' . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
 

// Get the username from the URL parameter
if (isset($_GET['username'])) {
    $username = $_GET['username'];
} else {
    $username = ''; // Default value or error handling
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>


<style>
    .container {
        background-color: #f5f5f5; /* Background color for the container */
        padding: 20px;
    }

    .card {
        border: none; /* Remove card border */
        border-radius: 10px; /* Add border radius to card */
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Add shadow to card */
    }

    .card-title {
        background-color: #007bff; /* Background color for card title */
        color: white; /* Text color for card title */
        padding: 10px;
        border-top-left-radius: 10px; /* Rounded corners for title */
        border-top-right-radius: 10px;
        margin-bottom: 0;
    }

    .form-group {
        margin-bottom: 20px; /* Space between form groups */
    }

    .btn-success {
        background-color: #28a745; /* Background color for success button */
        border: none;
    }

    .btn-success:hover {
        background-color: #218838; /* Darker color on hover */
    }

    /* You can add more custom styles as needed */
</style>

  <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body">
                        <h5 class="card-title text-center">Password Reset</h5>
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" disabled name="username" class="form-control" value="<?php echo htmlspecialchars($username); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="new_password">New Password</label>
                                <input type="password" name="new_password" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="confirm_password">Confirm Password</label>
                                <input type="password" name="confirm_password" class="form-control" required>
                            </div>
                            <div class="text-center">
                                <button class="btn btn-success" type="submit">Reset Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div> 
   


<?php include '../footer.php' ?>
 
</body>
</html>
</body>
</html>
