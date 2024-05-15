<!DOCTYPE html>
<html lang="en">

<head>
	<?php
	    include 'includes/links.php';
	    include 'includes/header.php';
	    include 'includes/sidebar.php';
      include 'connection.php';
      if (isset($_POST['submit'])) {

        $currentUsername = $_SESSION['username'];
        $newUsername = $_POST['username'];
        $currentPassword = md5($_POST['currentPassword']);
        $myPassword = $_SESSION['password'];
        $newPassword = md5($_POST['newPassword']);
        $renewPassword = md5($_POST['renewPassword']);

        if ($currentPassword === $myPassword && $newPassword === $renewPassword) {
          
          $sql = "UPDATE users
              SET username = '$newUsername',
                password = '$newPassword'
              WHERE username = '$currentUsername'";
          if (mysqli_query($con, $sql)) {

    //for transation logs
              date_default_timezone_set('Asia/Manila');
              $timestamp = date('Y-m-d H:i:s');
              $user_id = $_SESSION['user_id'];
              $name = $_SESSION['name'];
              $query = "INSERT INTO logs (timestamp, user_id, name, action, description) VALUES 
              ('$timestamp', $user_id, '$name', 'Change Password', 'Changed their username or password')";

              if (mysqli_query($con, $query)) {
              } else {
                echo "Error: " . $query . "<br>" . mysqli_error($con); 
              }
    //end log
	 ?>
</head>

<body>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Manage Profile</h1>
      <nav>
	<?php 
  include 'connection.php';

  $role = $_SESSION['role'];

  if ($role === 'Admin') { ?>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php"><i class="bi bi-house-door"></i></a></li>
          <li class="breadcrumb-item">Settings</li>
          <li class="breadcrumb-item"><a href="settings-users.php">Manage Users</a></li>
          <li class="breadcrumb-item active">Manage Profile</li>
          <li class="breadcrumb-item"><a href="settings-users.php"><i class="ri ri-arrow-go-back-line"></i></a></li>
        </ol>
	<?php
  } else { ?>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item">Settings</li>
          <li class="breadcrumb-item active">Manage Profile</li>
        </ol>
	<?php 
  }

	?>
      </nav>
    </div><!-- End Page Title -->

    <section class="section profile">

    <?php
        include 'connection.php';

        $username = $_SESSION['username'];

        $query = "SELECT * FROM users WHERE username = '$username'"; 
        $result = $con->query($query);
        if ($result) {
          while ($row = $result->fetch_assoc()) { 
            $sex = $row['sex'];
            $name = $row['fname']." ".$row['lname'];
            $role = $row['role'];
            $fullname = $row['fname']." ".$row['mname']." ".$row['lname'];
            $bdate = $row['bdate'];
            $address = $row['barangay'].", ".$row['municipality'].", ".$row['province'];
            $contact_no = $row['contact_no'];
            $email = $row['email'];
            $username = $row['username'];
            $fname = $row['fname'];
            $mname = $row['mname'];
            $lname = $row['lname'];
            ?>

      <div class="row">
        <div class="col-xl-4">

          <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
              <?php  
                if ($sex === 'Male') {
                    echo '<img src="assets/img/Male.png" alt="Profile" class="rounded-circle">';
                } elseif ($sex === 'Female') {
                    echo '<img src="assets/img/Female.png" alt="Profile" class="rounded-circle">';
                }
              ?>
              <h2><?php echo $name ?></h2>
              <h3><?php echo $role ?></h3>
            </div>
          </div>

        </div>

        <div class="col-xl-8">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
                </li>

              </ul>
              <div class="tab-content pt-2">


	<!-- Change Password Form -->
                <div class="tab-pane fade show active pt-3" id="profile-change-password">
                  <form class="needs-validation" novalidate action="settings-account-password-update.php" method="POST">

                    <div class="row mb-3">
                      <label for="username" class="col-md-4 col-lg-3 col-form-label">Username</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="username" type="text" class="form-control" id="username" value="<?php echo $username ?>" required>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                      <div class="col-md-8 col-lg-9">
                        <div class="input-group">
                          <div class="input-group-append col">
                            <input name="currentPassword" type="password" class="form-control" id="currentPassword" required>
                          </div>
                          <div id="show-current" style="padding: 0px 5px 0px 10px;">
                            <font size="5px" color="#6c757d"><i class="bi bi-eye"></i></font>
                          </div class="input-group-append">
                        </div>
                        <div class="invalid-feedback">Please enter your current password.</div>
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
                      <button class="button" type="submit" name="submit">Save Changes</button>
                    </div>
                  </form><!-- End Change Password Form -->

                </div>

              </div><!-- End Bordered Tabs -->

            </div>
          </div>

        </div>
      </div>

    <?php
          } 
        }         
    ?>
    </section>

  </main><!-- End #main -->

	<?php include 'includes/footer.php'; ?>

</body>

</html>


<?php
				echo "
					<script = 'text/javascript>
						alert('You have successfuly updated your username and password!');
						location.href = 'settings-account.php';
					</script>
					";
			} else {
				echo "Error: " . $sql . "<br>" . mysqli_error($con); 
			}
		} else {

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php
      include 'includes/links.php';
      include 'static/header.php';
      include 'includes/sidebar.php';
   ?>
</head>

<body>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Manage Profile</h1>
      <nav>
  <?php 
  include 'connection.php';

  $role = $_SESSION['role'];

  if ($role === 'Admin') { ?>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php"><i class="bi bi-house-door"></i></a></li>
          <li class="breadcrumb-item">Settings</li>
          <li class="breadcrumb-item"><a href="settings-users.php">Manage Users</a></li>
          <li class="breadcrumb-item active">Manage Profile</li>
          <li class="breadcrumb-item"><a href="settings-users.php"><i class="ri ri-arrow-go-back-line"></i></a></li>
        </ol>
  <?php
  } else { ?>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item">Settings</li>
          <li class="breadcrumb-item active">Manage Profile</li>
        </ol>
  <?php 
  }

  ?>
      </nav>
    </div><!-- End Page Title -->

    <section class="section profile">

    <?php
        include 'connection.php';

        $username = $_SESSION['username'];

        $query = "SELECT * FROM users WHERE username = '$username'"; 
        $result = $con->query($query);
        if ($result) {
          while ($row = $result->fetch_assoc()) { 
            $sex = $row['sex'];
            $name = $row['fname']." ".$row['lname'];
            $role = $row['role'];
            $fullname = $row['fname']." ".$row['mname']." ".$row['lname'];
            $bdate = $row['bdate'];
            $address = $row['barangay'].", ".$row['municipality'].", ".$row['province'];
            $contact_no = $row['contact_no'];
            $email = $row['email'];
            $username = $row['username'];
            $fname = $row['fname'];
            $mname = $row['mname'];
            $lname = $row['lname'];
            ?>

      <div class="row">
        <div class="col-xl-4">

          <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
              <?php  
                if ($sex === 'Male') {
                    echo '<img src="assets/img/Male.png" alt="Profile" class="rounded-circle">';
                } elseif ($sex === 'Female') {
                    echo '<img src="assets/img/Female.png" alt="Profile" class="rounded-circle">';
                }
              ?>
              <h2><?php echo $name ?></h2>
              <h3><?php echo $role ?></h3>
            </div>
          </div>

        </div>

        <div class="col-xl-8">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
                </li>

              </ul>
              <div class="tab-content pt-2">


  <!-- Change Password Form -->
                <div class="tab-pane fade show active pt-3" id="profile-change-password">
                  <form class="needs-validation" novalidate action="settings-account-password-update.php" method="POST">

                    <div class="row mb-3">
                      <label for="username" class="col-md-4 col-lg-3 col-form-label">Username</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="username" type="text" class="form-control" id="username" value="<?php echo $username ?>" required>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                      <div class="col-md-8 col-lg-9">
                        <div class="input-group">
                          <div class="input-group-append col">
                            <input name="currentPassword" type="password" class="form-control" id="currentPassword" required>
                          </div>
                          <div id="show-current" style="padding: 0px 5px 0px 10px;">
                            <font size="5px" color="#6c757d"><i class="bi bi-eye"></i></font>
                          </div class="input-group-append">
                        </div>
                        <div class="invalid-feedback">Please enter your current password.</div>
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
                      <button class="button" type="submit" name="submit">Save Changes</button>
                    </div>
                  </form><!-- End Change Password Form -->

                </div>

              </div><!-- End Bordered Tabs -->

            </div>
          </div>

        </div>
      </div>

    <?php
          } 
        }         
    ?>
    </section>

  </main><!-- End #main -->

  <?php include 'includes/footer.php'; ?>

</body>

</html>


<?php
				echo "
					<script = 'text/javascript>
						alert('Your passwords do not match!');
						location.href = 'settings-account.php';
					</script>
					";

		}
	}
?>