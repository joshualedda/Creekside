<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  include 'includes/links.php';
  include 'includes/header.php';
  include 'includes/sidebar.php';
  include('connection.php');
  ?>

</head>

<body>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>User Account</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php"><i class="bi bi-house-door"></i></a></li>
          <li class="breadcrumb-item">Settings</li>
          <li class="breadcrumb-item"><a href="settings-users.php">Manage Users</a></li>
          <li class="breadcrumb-item active">User Account</li>
          <li class="breadcrumb-item"><a href="settings-users.php"><i class="ri ri-arrow-go-back-line"></i></a></li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section profile">

      <?php
      include 'connection.php';

      if (isset($_POST['submit'])) {
        $id = $_POST['id'];

        $query = "SELECT * FROM users WHERE user_id = '$id'";
        $result = $con->query($query);
        if ($result) {
          while ($row = $result->fetch_assoc()) {
            $contact_no = $row['contact_no'];
            $email = $row['email'];
            $username = $row['username'];
            $password = $row['password'];
            $status = $row['activity'];
            $id = $row['user_id'];
            $name = $row['fname'] . " " . $row['lname'];
      ?>

            <div class="row">
              <div class="col-xl-4">

                <div class="card">
                  <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                    <?php
                    if ($row['sex'] === 'Male') {
                      echo '<img src="assets/img/Male.png" alt="Profile" class="rounded-circle">';
                    } elseif ($row['sex'] === 'Female') {
                      echo '<img src="assets/img/Female.png" alt="Profile" class="rounded-circle">';
                    }
                    ?>
                    <h2><?php echo $row['fname'] . " " . $row['lname'] ?></h2>
                    <h3><b><?php echo $role ?></b> | <?php echo $status ?></h3>
                  </div>
                </div>

              </div>

              <div class="col-xl-8">

                <div class="card">
                  <div class="card-body pt-3">
                    <!-- Bordered Tabs -->
                    <ul class="nav nav-tabs nav-tabs-bordered">

                      <li class="nav-item">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                      </li>

                      <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                      </li>

                      <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
                      </li>

                      <!-- <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-delete">Delete Account</button>
                      </li> -->

                    </ul>
                    <div class="tab-content pt-2">

                      <div class="tab-pane fade show active profile-overview" id="profile-overview">

                        <h5 class="card-title">Profile Details</h5>

                        <div class="row">
                          <div class="col-lg-3 col-md-4 label ">Full Name</div>
                          <div class="col-lg-9 col-md-8"><?php echo $row['fname'] . " " . $row['mname'] . " " . $row['lname'] ?></div>
                        </div>

                        <div class="row">
                          <div class="col-lg-3 col-md-4 label">Birthdate</div>
                          <div class="col-lg-9 col-md-8"><?php
                                                          $dbDate = $row['bdate'];
                                                          $date = new DateTime($dbDate);
                                                          $formattedDate = $date->format("F j, Y");
                                                          echo $formattedDate;
                                                          ?></div>
                        </div>

                        <div class="row">
                          <div class="col-lg-3 col-md-4 label">Sex</div>
                          <div class="col-lg-9 col-md-8"><?php echo $row['sex'] ?></div>
                        </div>

                        <div class="row">
                          <div class="col-lg-3 col-md-4 label">Address</div>
                          <div class="col-lg-9 col-md-8"><?php echo $row['barangay'] . ", " . $row['municipality'] . ", " . $row['province'] ?></div>
                        </div>

                        <div class="row">
                          <div class="col-lg-3 col-md-4 label">Contact Number</div>
                          <div class="col-lg-9 col-md-8"><?php echo $row['contact_no'] ?></div>
                        </div>

                        <div class="row">
                          <div class="col-lg-3 col-md-4 label">Email Address</div>
                          <div class="col-lg-9 col-md-8"><?php echo $row['email'] ?></div>
                        </div>

                        <div class="row">
                          <div class="col-lg-3 col-md-4 label">Role</div>
                          <div class="col-lg-9 col-md-8"><?php echo $row['role'] ?></div>
                        </div>

                        <div class="row">
                          <div class="col-lg-3 col-md-4 label">Status</div>
                          <div class="col-lg-9 col-md-8"><?php echo $row['activity'] ?></div>
                        </div>

                      </div>

                      <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                        <!-- Profile Edit Form -->
                        <form class="needs-validation" novalidate action="settings-users-profile-update.php" enctype="multipart/form-data" method="POST">
                          <!-- <div class="row mb-3">
                      <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                      <div class="col-md-8 col-lg-9">
                        <img src="assets/img/profile-img.jpg" alt="Profile">
                        <div class="pt-2">
                          <a href="#" class="btn btn-primary btn-sm" title="Upload new profile image"><i class="bi bi-upload"></i></a>
                          <a href="#" class="btn btn-danger btn-sm" title="Remove my profile image"><i class="bi bi-trash"></i></a>
                        </div>
                      </div>
                    </div> -->

                          <div class="row mb-3">
                            <label for="role" class="col-md-4 col-lg-3 col-form-label">Role</label>
                            <div class="col-md-8 col-lg-9">
                              <select class="form-select" aria-label="Default select example" name="role" id="role" required>
                                <option value="Staff" selected>Staff</option>
                                <option value="Admin">Admin</option>
                              </select>
                            </div>
                          </div>

                          <div class="row mb-3">
                            <label for="role" class="col-md-4 col-lg-3 col-form-label">Status</label>
                            <div class="col-md-8 col-lg-9">
                              <select class="form-select" aria-label="Default select example" name="status" id="status" required>
                                <option value="Active" selected>Active</option>
                                <option value="Inactive">Inactive</option>
                              </select>
                            </div>
                          </div>

                          <div class="row mb-3">
                            <label for="fname" class="col-md-4 col-lg-3 col-form-label">First Name</label>
                            <div class="col-md-8 col-lg-9">
                              <input name="fname" type="text" class="form-control" id="fname" value="<?php echo $row['fname'] ?>" required>
                            </div>
                          </div>

                          <div class="row mb-3">
                            <label for="mname" class="col-md-4 col-lg-3 col-form-label">Middle Name</label>
                            <div class="col-md-8 col-lg-9">
                              <input name="mname" type="text" class="form-control" id="mname" value="<?php echo $row['mname'] ?>">
                            </div>
                          </div>

                          <div class="row mb-3">
                            <label for="lname" class="col-md-4 col-lg-3 col-form-label">Last Name</label>
                            <div class="col-md-8 col-lg-9">
                              <input name="lname" type="text" class="form-control" id="lname" value="<?php echo $row['lname'] ?>" required>
                            </div>
                          </div>

                          <div class="row mb-3">
                            <label for="bdate" class="col-md-4 col-lg-3 col-form-label">Birthdate</label>
                            <div class="col-md-8 col-lg-9">
                              <input name="bdate" type="date" class="form-control" id="bdate" value="<?php echo $row['bdate']; ?>" required>
                            </div>
                          </div>

                          <div class="row mb-3">
                            <label for="sex" class="col-md-4 col-lg-3 col-form-label">Sex</label>
                            <div class="col-md-8 col-lg-9">
                              <select class="form-select" aria-label="Default select example" name="sex" id="sex" required>
                                <option value="" selected disabled>Select Sex</option>
                                <option value="Male" <?php if ($sex === "Male") echo 'selected'; ?>>Male</option>
                                <option value="Female <?php if ($sex === "Female") echo 'selected'; ?>">Female</option>
                              </select>
                              <div class="invalid-feedback">Please select sex.</div>
                            </div>
                          </div>

                          <div class="row mb-3">
                            <label class="col-md-4 col-lg-3 col-form-label">Province</label>
                            <div class="col-md-8 col-lg-9">
                              <select class="form-select" aria-label="Default select example" name="province" id="province" required>
                                <option value="" selected disabled>Select Province</option>
                                <?php
                                $sql = "SELECT * FROM province";
                                $result = mysqli_query($con, $sql);
                                while ($row = mysqli_fetch_array($result)) {
                                  echo ucwords('<option value="' . $row['provCode'] . '">' . $row['provDesc'] . '</option>');
                                }
                                ?>
                              </select>
                              <div class="invalid-feedback">Please select a province.</div>
                            </div>
                          </div>

                          <div class="row mb-3">
                            <label class="col-md-4 col-lg-3 col-form-label">City/Municipality</label>
                            <div class="col-md-8 col-lg-9">
                              <select class="form-select" aria-label="Default select example" name="municipality" id="city" required>
                                <option value="" selected disabled>Select City/Municipality</option>
                              </select>
                              <div class="invalid-feedback">Please select a city or municipality.</div>
                            </div>
                          </div>

                          <div class="row mb-3">
                            <label class="col-md-4 col-lg-3 col-form-label">Barangay</label>
                            <div class="col-md-8 col-lg-9">
                              <select class="form-select" aria-label="Default select example" name="barangay" id="barangay" required>
                                <option value="" selected disabled>Select Barangay</option>
                              </select>
                              <div class="invalid-feedback">Please select a barangay.</div>
                            </div>
                          </div>

                          <div class="row mb-3">
                            <label for="contact_no" class="col-md-4 col-lg-3 col-form-label">Contact Number</label>
                            <div class="col-md-8 col-lg-9">
                              <input name="contact_no" type="text" class="form-control" id="contact_no" value="<?php echo $contact_no ?>" minlength="11" required>
                            </div>
                            <div class="invalid-feedback">Please enter 11-digit contact number.</div>
                          </div>

                          <div class="row mb-3">
                            <label for="email" class="col-md-4 col-lg-3 col-form-label">Email Address</label>
                            <div class="col-md-8 col-lg-9">
                              <input name="email" type="email" class="form-control" id="email" value="<?php echo $email ?>" required>
                            </div>
                          </div>

                          <div class="col-md-8 col-lg-9">
                            <input name="id" type="text" class="form-control" id="id" value="<?php echo $id ?>" hidden required>
                          </div>

                          <div class="text-center">
                            <button type="button" class="btn btn-secondary" onclick="location.reload()">Cancel</button>
                            <button type="submit" class="btn button" name="submit">Save</button>
                          </div>
                        </form><!-- End Profile Edit Form -->

                      </div>

                      <div class="tab-pane fade pt-3" id="profile-change-password">
                        <!-- Change Password Form -->
                        <form class="needs-validation" novalidate action="settings-users-profile-password-update.php" method="POST">
                          <input name="name" type="text" class="form-control" id="name" value="<?php echo $name ?>" hidden>
                          <input name="id" type="text" class="form-control" id="id" value="<?php echo $id ?>" hidden>
                          <div class="row mb-3">
                            <label for="username" class="col-md-4 col-lg-3 col-form-label">Username</label>
                            <div class="col-md-8 col-lg-9">
                              <input name="username" type="text" class="form-control" id="username" value="<?php echo $username ?>" required>
                            </div>
                          </div>



                          <div class="row mb-3">
                            <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                            <div class="col-md-8 col-lg-9">
                              <div class="input-group">
                                <div class="input-group-append col">
                                  <input name="newPassword" type="password" class="form-control" id="newPassword" minlength="8" required autofocus>
                                </div>
                                <div id="show-new" style="padding: 0px 5px 0px 10px;">
                                  <font size="5px" color="#6c757d"><i class="bi bi-eye"></i></font>
                                </div class="input-group-append">
                              </div>
                              <div class="invalid-feedback">Please enter an 8-character long password.</div>
                            </div>
                          </div>

                          <div class="row mb-3">
                            <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                            <div class="col-md-8 col-lg-9">
                              <div class="input-group">
                                <div class="input-group-append col">
                                  <input name="renewPassword" type="password" class="form-control" id="renewPassword" minlength="8" required>
                                </div>
                                <div id="show-renew" style="padding: 0px 5px 0px 10px;">
                                  <font size="5px" color="#6c757d"><i class="bi bi-eye"></i></font>
                                </div class="input-group-append">
                              </div>
                              <div class="invalid-feedback">Please re-enter your new password.</div>
                            </div>
                          </div>

                          <div class="text-center">
                            <button type="button" class="btn btn-secondary" onclick="location.reload()">Cancel</button>
                            <button type="submit" class="btn button" name="submit">Confirm</button>
                          </div>
                        </form><!-- End Change Password Form -->

                      </div>

                      <div class="tab-pane fade pt-3" id="profile-delete">
                        <!-- Delete Profile Form -->
                        <form class="needs-validation" novalidate action="settings-users-profile-delete.php" method="POST">

                          <div class="col-sm-10">
                            <h5>You are about to delete this user's account. Are you sure you want to proceed?</h5>
                            <h5></h5>
                          </div>
                          <h5></h5>
                          <input name="id" type="text" id="id" value="<?php echo $id ?>" hidden>
                          <div class="" style="text-align: right;">
                            <button type="button" class="btn btn-secondary" onclick="location.reload()">Cancel</button>
                            <button type="submit" class="btn btn-danger" name="submit">Confirm</button>
                          </div>
                        </form><!-- End Delete Profile Form -->

                      </div>

                    </div><!-- End Bordered Tabs -->

                  </div>
                </div>

              </div>
            </div>
      <?php
          }
        }
      }
      ?>
    </section>

  </main><!-- End #main -->

  <?php include 'includes/footer.php'; ?>

</body>
<script src="assets/js/jquery.min.js"></script>
<script>
  $(document).ready(function() {
    $("#province").on('change', function() {
      var provinceId = $(this).val();
      if (provinceId) {
        $.ajax({
          type: 'POST',
          url: 'ajaxData.php',
          data: 'provinceId=' + provinceId,
          success: function(html) {
            $('#city').html(html);
            $('#barangay').html('<option value="">Select Barangay</option>');
          }
        });
      } else {
        $('#barangay').html('<option value="">Select Barangay</option>');
      }
    });

    $('#city').on('change', function() {
      var cityId = $(this).val();
      if (cityId) {
        $.ajax({
          type: 'POST',
          url: 'ajaxData.php',
          data: 'cityId=' + cityId,
          success: function(html) {
            $('#barangay').html(html);
          }
        });
      }
    });
  });
</script>
<script>
  const showNew = document.getElementById("show-new");
  const passwordNew = document.getElementById("newPassword");

  showNew.addEventListener("click", function newpass() {
    if (passwordNew.type === "password") {
      passwordNew.type = "text";
      showNew.innerHTML = '<font size="5px" color="#6c757d"><i class="bi bi-eye-slash"></i></font>';
    } else {
      passwordNew.type = "password";
      showNew.innerHTML = '<font size="5px" color="#6c757d"><i class="bi bi-eye"></i></font>';
    }
  });

  const showRenew = document.getElementById("show-renew");
  const passwordRenew = document.getElementById("renewPassword");

  showRenew.addEventListener("click", function newpass() {
    if (passwordRenew.type === "password") {
      passwordRenew.type = "text";
      showRenew.innerHTML = '<font size="5px" color="#6c757d"><i class="bi bi-eye-slash"></i></font>';
    } else {
      passwordRenew.type = "password";
      showRenew.innerHTML = '<font size="5px" color="#6c757d"><i class="bi bi-eye"></i></font>';
    }
  });
</script>

</html>