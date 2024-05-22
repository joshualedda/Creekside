<?php
session_start();

// Include your database connection here
include 'connection.php';

use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Check if the user submitted an email for password reset
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["email"])) {
    $email = $_POST["email"];

    // Check if the email exists in your users table
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // Generate a unique reset token
        $resetToken = bin2hex(random_bytes(16));

        // Calculate the token expiration time (e.g., 1 hour from now)
        // date_default_timezone_set('Asia/Manila');
        // $tokenExpiration = date('Y-m-d H:i:s', strtotime('+1 hour'));

        // Insert the reset token into the password_reset table
        $sql = "INSERT INTO password_reset (email, reset_token) VALUES (?, ?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ss", $email, $resetToken);
        $stmt->execute();
        if ($stmt->execute()) {
            // Send an email to the user with a link to reset their password
            $_SESSION['email'] = $email;
            $resetLink = "http://localhost/creekside/reset_password.php?token=$resetToken";
            
            // Include PHPMailer
            require 'PHPMailer/src/PHPMailer.php';
            require 'PHPMailer/src/SMTP.php';
            require 'PHPMailer/src/Exception.php';

            // Initialize PHPMailer
            $mail = new PHPMailer(true);

            try {
                //Server settings
                $mail->isSMTP(); // Set mailer to use SMTP
                $mail->Host = 'smtp.gmail.com'; // Specify SMTP server
                $mail->SMTPAuth = true; // Enable SMTP authentication
                $mail->Username = 'thecreeksidecafe.balaoan@gmail.com'; // SMTP username
                $mail->Password = 'lwiokvclrmpdygoo'; // SMTP password
                $mail->SMTPSecure = 'tls'; // Enable TLS encryption, 'ssl' also accepted
                $mail->Port = 587; // TCP port to connect to

                //Recipients
                $mail->setFrom('thecreeksidecafe.balaoan@gmail.com', 'The Creekside Cafe');
                $mail->addAddress($email); // Add a recipient

                // Content
                $mail->isHTML(true); // Set email format to HTML
                $mail->Subject = 'Password Reset Link';
                $mail->Body = "You are trying to reset your password. To proceed with the next step, please click <a href='$resetLink'>this link</a>.<br><br>If you did not request for a password reset, please ignore and delete this email.";

                $mail->send();
                
                // Redirect the user to a confirmation page
                $success_message = "The password reset link has been sent to your email.";?>

                <!-- Your HTML form for requesting a password reset -->
                <?php if (isset($success_message)) : ?>
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
                                    <h5 class="card-title text-center pb-0 fs-4">Password Reset Request</h5>
                                    <p class="text-center small">Enter your email address to receive a password reset link</p>
                                  </div>

                                  <form class="row g-3 needs-validation" action="" method="POST">

                                    <div class="col-12">
                                      <label for="email" class="form-label">Email Address</label>
                                      <div class="input-group has-validation">
                                        <input type="email" name="email" class="form-control" id="email" autofocus required>
                                        <div class="invalid-feedback">Please enter your email address.</div>
                                      </div>
                                    </div>

                                    <div class="col-12">
                                      <div class="alert alert-success alert-dismissible fade show" role="alert">
                                          <?php echo $success_message; ?>
                                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                      </div>
                                    </div>

                                    <div class="col-12">
                                      <button class="btn btn-primary w-100" type="submit">Send Link</button>
                                    </div>
                                  </form>
                                </div>
                              </div>

                              <div class="copyright" style="text-align: center;">
                                Copyright &copy; 2024 <strong><span>The Creekside Café</span></strong>.
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
                </body>
                </html>
                <?php endif; ?>
<?php
                exit;
            } catch (Exception $e) {
                        $error_message = $mail->ErrorInfo;
            }
        } else {
            // Handle database error
            echo "Error: " . $stmt->error;
        }
    } else {
        // Email not found in the users table, display an error message
        $error_message = "Your email cannot be found in the database.";
    }
}
?>

<!-- Your HTML form for requesting a password reset -->
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
                    <h5 class="card-title text-center pb-0 fs-4">Password Reset Request</h5>
                    <p class="text-center small">Enter your email address to receive a password reset link</p>
                  </div>

                  <form class="row g-3 needs-validation" action="" method="POST">

                    <div class="col-12">
                      <label for="email" class="form-label">Email Address</label>
                      <div class="input-group has-validation">
                        <input type="email" name="email" class="form-control" id="email" autofocus required>
                        <div class="invalid-feedback">Please enter your email address.</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <div class="alert alert-danger alert-dismissible fade show" role="alert">
                          <?php echo $error_message; ?>
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>
                    </div>

                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Send Link</button>
                    </div>
                  </form>
                </div>
              </div>

              <div class="copyright" style="text-align: center;">
                Copyright &copy; 2024 <strong><span>The Creekside Café</span></strong>.
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
                    <h5 class="card-title text-center pb-0 fs-4">Password Reset Request</h5>
                    <p class="text-center small">Enter your email address to receive a password reset link</p>
                  </div>

                  <form class="row g-3 needs-validation" action="" method="POST">

                    <div class="col-12">
                      <label for="email" class="form-label">Email Address</label>
                      <div class="input-group has-validation">
                        <input type="email" name="email" class="form-control" id="email" autofocus required>
                        <div class="invalid-feedback">Please enter your email address.</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Send Link</button>
                    </div>
                  </form>
                </div>
              </div>

              <div class="copyright" style="text-align: center;">
                Copyright &copy; 2024 <strong><span>The Creekside Café</span></strong>.
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
</body>
</html>
<?php endif; ?>


<!-- 
<!DOCTYPE html>
<html>
<head>
    <title>Password Reset Request</title>
</head>
<body>
    <h2>Reset Your Password</h2>
    <?php if (isset($error_message)) : ?>
        <p><?php echo $error_message; ?></p>
        <p>Enter your email address to reset your password:</p>
        <form method="POST" action="">
            <input type="email" name="email" required>
            <button type="submit">Reset Password</button>
        </form>
    <?php elseif (isset($success_message)) : ?>
        <p><?php echo $success_message; ?></p>
        <p>Enter your email address to reset your password:</p>
        <form method="POST" action="">
            <input type="email" name="email" required>
            <button type="submit">Reset Password</button>
        </form>
    <?php else : ?>
        <p>Enter your email address to reset your password:</p>
        <form method="POST" action="">
            <input type="email" name="email" required>
            <button type="submit">Reset Password</button>
        </form>
    <?php endif; ?>
</body>
</html>
 -->