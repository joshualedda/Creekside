<?php
  if (isset($_POST['submit'])) {
  session_start();
  include 'connection.php';

      $username = $_POST['username'];
      $password = md5($_POST['password']);

      $sql = "SELECT * FROM users
          WHERE username = '$username' 
          AND password = '$password'";
      
      $resultCheckLogin=mysqli_query($con, $sql);

      if (mysqli_num_rows($resultCheckLogin) > 0) {
        while ($row=mysqli_fetch_array($resultCheckLogin)) {
          $_SESSION['name'] = $row['fname']." ".$row['lname'];
          $_SESSION['user_id'] = $row['user_id'];
          $_SESSION['username'] = $row['username'];
          $_SESSION['password'] = $row['password'];
          $_SESSION['role'] = $row['role'];
          }

//for transation logs
          date_default_timezone_set('Asia/Manila');
          $timestamp = date('Y-m-d H:i:s');
          $user_id = $_SESSION['user_id'];
          $name = $_SESSION['name'];
          $query = "INSERT INTO logs (timestamp, user_id, name, action, description) VALUES 
          ('$timestamp', $user_id, '$name', 'Log In', 'Logged into their account')";

          if (mysqli_query($con, $query)) {
          } else {
            echo "Error: " . $query . "<br>" . mysqli_error($con); 
          }
//end log

          header("Location: dashboard.php");
      } else{ 

        $error_message = "You have entered an incorrect username or password!";
        ?>

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
                <a class="logo d-flex align-items-center">
                  <img src="assets/img/creekside.png" style="height: 300px;">
                  <span class="d-flex d-lg-block">The Creekside Café</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                    <p class="text-center small">Enter your username & password to login</p>
                  </div>

                  <form class="row g-3 needs-validation" novalidate action="index.php" method="POST">

                    <div class="col-12">
                      <label for="username" class="form-label">Username</label>
                      <div class="input-group has-validation">
                        <input type="text" name="username" class="form-control" id="username" autofocus required>
                        <div class="invalid-feedback">Please enter your username.</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="password" class="form-label">Password</label>
                      <input type="password" name="password" class="form-control" id="password" minlength="8" required>
                      <div class="invalid-feedback">Please enter your password! (at least  8 characters long)</div>
                    </div>

                    <div class="input-group col-12">
                      <div type="button" class="input-group-append" id="show-password-btn">
                        <font color="#6c757d" class="bi bi-square"> Show Password</font>
                      </div>
                    </div>

<!--                     <div class="col-12">
                      <label for="password" class="form-label">Password</label>
                      <div class="input-group">
                        <div class="input-group-append col">
                          <input type="password" name="password" class="form-control" id="password" minlength="8" required>
                          <div class="invalid-feedback">Please enter your password! (at least  8 characters long)</div>
                        </div>
                        <div id="show-password-btn" style="padding: 0px 5px 0px 10px;">
                          <font size="5px" color="#6c757d"><i class="bi bi-eye"></i></font>
                        </div class="input-group-append">
                      </div>
                    </div> -->

                    <div class="col-12">
                      <div class="alert alert-danger alert-dismissible fade show" role="alert">
                          <?php echo $error_message; ?>
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>
                    </div>

  <!--                     <div class="col-12">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">Remember me</label>
                      </div>
                    </div> -->

                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit" name="submit">Login</button>
                    </div>

                    <div>
                      <a href="password_reset_request.php">Forgot Password?</a>
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
  <script>
    const showPasswordBtn = document.getElementById("show-password-btn");
    const passwordInput = document.getElementById("password");

    showPasswordBtn.addEventListener("click", function () {
      if (passwordInput.type === "password") {
        passwordInput.type = "text";
        showPasswordBtn.innerHTML = '<font color="#6c757d" class="bi bi-check-square-fill"> Show Password</font>';
      } else {
        passwordInput.type = "password";
        showPasswordBtn.innerHTML = '<font color="#6c757d" class="bi bi-square"> Show Password</font>';
      }
    });
  </script>

<!--   <script>
    const showPasswordBtn = document.getElementById("show-password-btn");
    const passwordInput = document.getElementById("password");

    showPasswordBtn.addEventListener("click", function () {
      if (passwordInput.type === "password") {
        passwordInput.type = "text";
        showPasswordBtn.innerHTML = '<font size="5px" color="#6c757d"><i class="bi bi-eye-slash"></i></font>';
      } else {
        passwordInput.type = "password";
        showPasswordBtn.innerHTML = '<font size="5px" color="#6c757d"><i class="bi bi-eye"></i></font>';
      }
    });
  </script> --> 

</body>

</html>


        <?php
      }
  } else { ?>
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
                <a class="logo d-flex align-items-center">
                  <img src="assets/img/creekside.png" style="height: 300px;">
                  <span class="d-flex d-lg-block">The Creekside Café</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                    <p class="text-center small">Enter your username & password to login</p>
                  </div>

                  <form class="row g-3 needs-validation" novalidate action="index.php" method="POST">

                    <div class="col-12">
                      <label for="username" class="form-label">Username</label>
                      <div class="input-group has-validation">
                        <input type="text" name="username" class="form-control" id="username" autofocus required>
                        <div class="invalid-feedback">Please enter your username.</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="password" class="form-label">Password</label>
                      <input type="password" name="password" class="form-control" id="password" minlength="8" required>
                      <div class="invalid-feedback">Please enter your password! (at least  8 characters long)</div>
                    </div>

                    <div class="input-group">
                      <div type="button" class="input-group-append" id="show-password-btn">
                        <font color="#6c757d" class="bi bi-square"> Show Password</font>
                      </div>
                    </div>

<!--                     <div class="col-12">
                      <label for="password" class="form-label">Password</label>
                      <div class="input-group">
                        <div class="input-group-append col">
                          <input type="password" name="password" class="form-control" id="password" minlength="8" required>
                          <div class="invalid-feedback">Please enter your password! (at least  8 characters long)</div>
                        </div>
                        <div id="show-password-btn" style="padding: 0px 5px 0px 10px;">
                          <font size="5px" color="#6c757d"><i class="bi bi-eye"></i></font>
                        </div class="input-group-append">
                      </div>
                    </div> -->

  <!--                     <div class="col-12">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">Remember me</label>
                      </div>
                    </div> -->

                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit" name="submit">Login</button>
                    </div>

                    <div>
                      <a href="password_reset_request.php">Forgot Password?</a>
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

<script>
  const showPasswordBtn = document.getElementById("show-password-btn");
  const passwordInput = document.getElementById("password");

  showPasswordBtn.addEventListener("click", function () {
    if (passwordInput.type === "password") {
      passwordInput.type = "text";
      showPasswordBtn.innerHTML = '<font color="#6c757d" class="bi bi-check-square-fill"> Show Password</font>';
    } else {
      passwordInput.type = "password";
      showPasswordBtn.innerHTML = '<font color="#6c757d" class="bi bi-square"> Show Password</font>';
    }
  });
</script>

<!-- <script>
  const showPasswordBtn = document.getElementById("show-password-btn");
  const passwordInput = document.getElementById("password");

  showPasswordBtn.addEventListener("click", function () {
    if (passwordInput.type === "password") {
      passwordInput.type = "text";
      showPasswordBtn.innerHTML = '<font size="5px" color="#6c757d"><i class="bi bi-eye-slash"></i></font>';
    } else {
      passwordInput.type = "password";
      showPasswordBtn.innerHTML = '<font size="5px" color="#6c757d"><i class="bi bi-eye"></i></font>';
    }
  });
</script> -->  
<?php }
?>