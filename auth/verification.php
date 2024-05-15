<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
<?php include '../includes/links.php'; ?>
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
                  <img src="../assets/img/creekside.png" style="height: 300px;">
                  <span class="d-flex d-lg-block">The Creekside Café</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Password Reset Request</h5>
                    <p class="text-center small">Enter your email address to receive a password reset link</p>
                  </div>

                  <form class="row g-3 needs-validation" action="ResetController.php" method="POST">

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
                &copy; Copyright <strong><span>The Creekside Café</span></strong>.
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