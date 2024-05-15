<?php
session_start();

// Include your database connection here
include 'connection.php';

// Check if the reset token and user ID are valid
if (isset($_GET['token']) && isset($_SESSION['email'])) {
    $token = $_GET['token'];
    $email = $_SESSION['email'];

    $sql = "SELECT * FROM password_reset WHERE email = '$email' AND reset_token = '$token'";
    $resultCheckLogin=mysqli_query($con, $sql);

    if (mysqli_num_rows($resultCheckLogin) > 0) {
        // Token is valid, allow the user to reset the password
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["new_password"])) {
            $new_password = $_POST["new_password"];
            
            // Update the user's password in the database
            $sql = "UPDATE users SET password = ? WHERE email = ?";
            $stmt = $con->prepare($sql);
            // Hash the new password before storing it
            $hashed_password = md5($new_password);
            $stmt->bind_param("ss", $hashed_password, $email);

            $select_id = "SELECT * FROM users WHERE email = '$email'";
            $result=mysqli_query($con, $select_id);

            if (mysqli_num_rows($result) > 0) {
                while ($row=mysqli_fetch_assoc($result)) {
                    $user_id = $row['user_id'];
                    $name = $row['fname']." ".$row['lname'];
                //for transation logs
                      date_default_timezone_set('Asia/Manila');
                      $timestamp = date('Y-m-d H:i:s');
                      $query = "INSERT INTO logs (timestamp, user_id, name, action, description) VALUES 
                      ('$timestamp', $user_id, '$name', 'Password Reset', 'Reset their password')";

                      if (mysqli_query($con, $query)) {
                      } else {
                        echo "Error: " . $query . "<br>" . mysqli_error($con); 
                      }
                //end log
                }
            }

            if ($stmt->execute()) {
                // Password reset successful, remove the reset token from the database
                $sql = "DELETE FROM password_reset WHERE email = ?";
                $stmt = $con->prepare($sql);
                $stmt->bind_param("s", $email);
                $stmt->execute();

                // Redirect the user to a password reset confirmation page
                $success_message = "Password set! You may now log in with your new password."; ?>

                <!DOCTYPE html>
                <html lang="en">
                <head>
                  <meta charset="utf-8">
                  <meta content="width=device-width, initial-scale=1.0" name="viewport">
                <?php include 'includes/links.php'; ?>
                </head>
                <body>

                  <main style="background-color: #efd3ab;">

                    <div class="container" >

                      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                        <div class="container">
                          <div class="row justify-content-center">
                            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                              <div class="d-flex justify-content-center py-4">
                                <a class="logo d-flex align-items-center" href="index.php">
                                  <img src="assets/img/creekside.png" style="height: 300px;">
                                  <span class="d-flex d-lg-block">The Creekside Café</span>
                                </a>
                              </div><!-- End Logo -->

                              <div class="card mb-3">

                                <div class="card-body">

                                  <div class="pt-4 pb-2">
                                    <h5 class="card-title text-center pb-0 fs-4">Reset Password</h5>
                                    <p class="text-center small">Enter your new password</p>
                                  </div>

                                  <form class="row g-3 needs-validation" action="" method="POST">

                                    <div class="col-12">
                                      <label for="new_password" class="form-label">New Password</label>
                                      <div class="input-group has-validation">
                                        <input type="password" name="new_password" class="form-control" id="new_password" minlength="8" required>
                                      </div>
                                    </div>

                                    <div class="col-12">
                                      <div class="alert alert-success alert-dismissible fade show" role="alert">
                                          <?php echo $success_message; ?>
                                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                      </div>
                                    </div>

                                    <div class="input-group">
                                      <div type="button" class="input-group-append" id="show-password-btn">
                                        <font class="bi bi-square"> Show Password</font>
                                      </div>
                                    </div>

                                    <div class="col-12">
                                      <button class="btn btn-primary w-100" type="submit">Set Password</button>
                                    </div>
                                  </form>
                                </div>
                              </div>

                              <div class="copyright" style="text-align: center;">
                                Copyright &copy; 2023 <strong><span>The Creekside Café</span></strong>.
                              </div>
                              <div class="copyright" style="text-align: center;">
                                All Rights Reserved
                              </div>

                            </div>
                          </div>
                        </div>

                      </section>

                    </div>
                  </main><!-- End #main -->

                  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

                  <!-- Vendor JS Files -->
                  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
                  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
                  <script src="assets/vendor/chart.js/chart.umd.js"></script>
                  <script src="assets/vendor/echarts/echarts.min.js"></script>
                  <script src="assets/vendor/quill/quill.min.js"></script>
                  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
                  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
                  <script src="assets/vendor/php-email-form/validate.js"></script>
                  <script>
                  const showPasswordBtn = document.getElementById("show-password-btn");
                  const passwordInput = document.getElementById("new_password");

                  showPasswordBtn.addEventListener("click", function () {
                    if (passwordInput.type === "password") {
                      passwordInput.type = "text";
                      showPasswordBtn.innerHTML = '<font class="bi bi-check-square-fill"> Show Password</font>';
                    } else {
                      passwordInput.type = "password";
                      showPasswordBtn.innerHTML = '<font class="bi bi-square"> Show Password</font>';
                    }
                  });
                </script> 

                  <!-- Template Main JS File -->
                  <script src="assets/js/main.js"></script>
                </body>
                </html>


<?php
                exit;
            } else {
                // Handle database error
                echo "Error: " . $stmt->error;
            }
        }
    } else {
        // Invalid token or expired, display an error message
        $error_message = "Invalid or expired reset token.";
    }
} else {
    // Token or user ID not provided, redirect to the password reset request page
    header("Location: password_reset_request.php");
    exit;
}
?>

<!-- Your HTML for resetting the password -->
<?php if (isset($error_message)) : ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
<?php include 'includes/links.php'; ?>
</head>
<body>

  <main style="background-color: #efd3ab;">

    <div class="container" >

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a class="logo d-flex align-items-center" href="index.php">
                  <img src="assets/img/creekside.png" style="height: 300px;">
                  <span class="d-flex d-lg-block">The Creekside Café</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Reset Password</h5>
                    <p class="text-center small">Enter your new password</p>
                  </div>

                  <form class="row g-3 needs-validation" action="" method="POST">

                    <div class="col-12">
                      <label for="new_password" class="form-label">New Password</label>
                      <div class="input-group has-validation">
                        <input type="password" name="new_password" class="form-control" id="new_password" minlength="8" required>
                      </div>
                    </div>

                    <div class="col-12">
                      <div class="alert alert-danger alert-dismissible fade show" role="alert">
                          <?php echo $error_message; ?>
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>
                    </div>

                    <div class="input-group">
                      <div type="button" class="input-group-append" id="show-password-btn">
                        <font class="bi bi-square"> Show Password</font>
                      </div>
                    </div>

                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Set Password</button>
                    </div>
                  </form>
                </div>
              </div>

              <div class="copyright" style="text-align: center;">
                Copyright &copy; 2023 <strong><span>The Creekside Café</span></strong>.
              </div>
              <div class="copyright" style="text-align: center;">
                All Rights Reserved
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script>
  const showPasswordBtn = document.getElementById("show-password-btn");
  const passwordInput = document.getElementById("new_password");

  showPasswordBtn.addEventListener("click", function () {
    if (passwordInput.type === "password") {
      passwordInput.type = "text";
      showPasswordBtn.innerHTML = '<font class="bi bi-check-square-fill"> Show Password</font>';
    } else {
      passwordInput.type = "password";
      showPasswordBtn.innerHTML = '<font class="bi bi-square"> Show Password</font>';
    }
  });
</script> 

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
</body>
</html>

<?php else : ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
<?php include 'includes/links.php'; ?>
</head>
<body>

  <main style="background-color: #efd3ab;">

    <div class="container" >

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a class="logo d-flex align-items-center" href="index.php">
                  <img src="assets/img/creekside.png" style="height: 300px;">
                  <span class="d-flex d-lg-block">The Creekside Café</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Reset Password</h5>
                    <p class="text-center small">Enter your new password</p>
                  </div>

                  <form class="row g-3 needs-validation" action="" method="POST">

                    <div class="col-12">
                      <label for="new_password" class="form-label">New Password</label>
                      <div class="input-group has-validation">
                        <input type="password" name="new_password" class="form-control" id="new_password" minlength="8" required>
                      </div>
                    </div>

                    <div class="input-group">
                      <div type="button" class="input-group-append" id="show-password-btn">
                        <font class="bi bi-square"> Show Password</font>
                      </div>
                    </div>

                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Set Password</button>
                    </div>
                  </form>
                </div>
              </div>

              <div class="copyright" style="text-align: center;">
                Copyright &copy; 2023 <strong><span>The Creekside Café</span></strong>.
              </div>
              <div class="copyright" style="text-align: center;">
                All Rights Reserved
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
  <script>
  const showPasswordBtn = document.getElementById("show-password-btn");
  const passwordInput = document.getElementById("new_password");

  showPasswordBtn.addEventListener("click", function () {
    if (passwordInput.type === "password") {
      passwordInput.type = "text";
      showPasswordBtn.innerHTML = '<font class="bi bi-check-square-fill"> Show Password</font>';
    } else {
      passwordInput.type = "password";
      showPasswordBtn.innerHTML = '<font class="bi bi-square"> Show Password</font>';
    }
  });
</script> 
</body>
</html>
<?php endif; ?>


<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
    <h2>Reset Your Password</h2>
    <?php if (isset($error_message)) : ?>
        <p><?php echo $error_message; ?></p>
    <?php else : ?>
        <p>Enter your new password:</p>
        <form method="POST" action="">
            <input type="password" name="new_password" required>
            <button type="submit">Submit</button>
        </form>
    <?php endif; ?>
</body>
</html>

<script>
  const showPasswordBtn = document.getElementById("show-password-btn");
  const passwordInput = document.getElementById("new_password");

  showPasswordBtn.addEventListener("click", function () {
    if (passwordInput.type === "password") {
      passwordInput.type = "text";
      showPasswordBtn.innerHTML = '<font class="bi bi-check-square-fill"> Show Password</font>';
    } else {
      passwordInput.type = "password";
      showPasswordBtn.innerHTML = '<font class="bi bi-square"> Show Password</font>';
    }
  });
</script> 
