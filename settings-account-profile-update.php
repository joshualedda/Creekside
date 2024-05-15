<!DOCTYPE html>
<html lang="en">

<head>
	<?php
	    include 'includes/links.php';
	    include 'includes/header.php';
	    include 'includes/sidebar.php';
      include 'connection.php';
      if (isset($_POST['submit'])) {

        $id = $_SESSION['user_id'];
        $fname = $_POST['fname'];
        $mname = $_POST['mname'];
        $lname = $_POST['lname'];
        $bdate = $_POST['bdate'];
        $sex = $_POST['sex'];

    //For fetching provDesc:    
          $query = "SELECT provDesc FROM province WHERE provCode = ".$_POST['province']; 
          $result = $con->query($query);
          if ($result) {
            while ($row = $result->fetch_assoc()) {
                $province = $row['provDesc'];
            }
        } else {
            echo "Error: " . $con->error;
        }

    //For fetching citymunDesc:    
          $query = "SELECT citymunDesc FROM municipality WHERE citymunCode = ".$_POST['municipality']; 
          $result = $con->query($query);
          if ($result) {
            while ($row = $result->fetch_assoc()) {
                $municipality = $row['citymunDesc'];
            }
        } else {
            echo "Error: " . $con->error;
        }

        $barangay = $_POST['barangay'];
        $contact_no = $_POST['contact_no'];
        $email = $_POST['email'];

        $sql = "UPDATE users
            SET fname = '$fname',
              mname = '$mname',
              lname = '$lname',
              bdate = '$bdate',
              sex = '$sex',
              province = '$province',
              municipality = '$municipality',
              barangay = '$barangay',
              contact_no = '$contact_no',
              email = '$email'
            WHERE user_id = '$id'";

        if (mysqli_query($con, $sql)) {

    //for transation logs
              date_default_timezone_set('Asia/Manila');
              $timestamp = date('Y-m-d H:i:s');
              $user_id = $_SESSION['user_id'];
              $name = $_SESSION['name'];
              $query = "INSERT INTO logs (timestamp, user_id, name, action, description) VALUES 
              ('$timestamp', $user_id, '$name', 'Edit Profile', 'Edited their profile')";

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
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
                </li>

              </ul>
              <div class="tab-content pt-2">

	<!-- Profile Edit Form -->
                <div class="tab-pane fade show active profile-edit pt-3" id="profile-edit">

                  <form class="needs-validation" novalidate action="settings-account-profile-update.php" enctype="multipart/form-data" method="POST">
		<!--                     <div class="row mb-3">
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
                      <label for="fname" class="col-md-4 col-lg-3 col-form-label">First Name</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="fname" type="text" class="form-control" id="fname" value="<?php echo $fname ?>" required>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="mname" class="col-md-4 col-lg-3 col-form-label">Middle Name</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="mname" type="text" class="form-control" id="mname" value="<?php echo $mname ?>">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="lname" class="col-md-4 col-lg-3 col-form-label">Last Name</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="lname" type="text" class="form-control" id="lname" value="<?php echo $lname ?>" required>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="bdate" class="col-md-4 col-lg-3 col-form-label">Birthdate</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="bdate" type="date" class="form-control" id="bdate" value="<?php echo $bdate; ?>" required>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="sex" class="col-md-4 col-lg-3 col-form-label">Sex</label>
                      <div class="col-md-8 col-lg-9">
                        <select class="form-select" aria-label="Default select example" name="sex" id="sex" required>
                          <option value="" selected disabled>Select Sex</option>
                          <option value="Male">Male</option>
                          <option value="Female">Female</option>
                        </select>
                        <div class="invalid-feedback">Please select sex.</div>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label class="col-md-4 col-lg-3 col-form-label">Province</label>
                      <div class="col-md-8 col-lg-9">
                        <select class="form-select" aria-label="Default select example" name = "province" id="province" required>
                          <option value="" selected disabled>Select Province</option>
                          <?php
                            $sql = "SELECT * FROM province";
                            $result=mysqli_query($con, $sql);
                            while($row=mysqli_fetch_array($result)){
                              echo ucwords('<option value="'.$row['provCode'].'">' . $row['provDesc'] . '</option>');
                            }
                          ?>
                        </select>
                        <div class="invalid-feedback">Please select a province.</div>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label class="col-md-4 col-lg-3 col-form-label">City/Municipality</label>
                      <div class="col-md-8 col-lg-9">
                        <select class="form-select" aria-label="Default select example" name = "municipality" id="city" required>
                          <option value="" selected disabled>Select City/Municipality</option>
                        </select>
                        <div class="invalid-feedback">Please select a city or municipality.</div>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label class="col-md-4 col-lg-3 col-form-label">Barangay</label>
                      <div class="col-md-8 col-lg-9">
                        <select class="form-select" aria-label="Default select example" name = "barangay" id="barangay" required>
                          <option value="" selected disabled>Select Barangay</option>
                        </select>
                        <div class="invalid-feedback">Please select a barangay.</div>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="email" class="col-md-4 col-lg-3 col-form-label">Email Address</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="email" type="email" class="form-control" id="email" value="<?php echo $email ?>" required>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="contact_no" class="col-md-4 col-lg-3 col-form-label">Contact Number</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="contact_no" type="text" class="form-control" id="contact_no" value="<?php echo $contact_no ?>" required>
                      </div>
                    </div>

                    <div class="text-center">
                      <button type="button" class="btn btn-secondary" onclick="location.reload()">Cancel</button>
                      <button type="submit" class="button" name="submit">Save Changes</button>
                    </div>
                  </form><!-- End Profile Edit Form -->

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
<script src="assets/js/jquery.min.js"></script>
<script>
	$(document).ready(function(){
	  $("#province").on('change', function(){
	        var provinceId = $(this).val();
	        if(provinceId){
	            $.ajax({
	                type:'POST',
	                url:'ajaxData.php',
	                data:'provinceId='+provinceId,
	                success:function(html){
	                    $('#city').html(html);
	                    $('#barangay').html('<option value="">Select Barangay</option>');
	                }
	            }); 
	        }else{
	            $('#barangay').html('<option value="">Select Barangay</option>'); 
	        }
	    });

	  $('#city').on('change', function(){
	        var cityId = $(this).val();
	        if(cityId){
	            $.ajax({
	                type:'POST',
	                url:'ajaxData.php',
	                data:'cityId='+cityId,
	                success:function(html){
	                    $('#barangay').html(html);
	                }
	            }); 
	        }
	    });
	});
</script>
</html>


<?php
			echo "
				<script = 'text/javascript>
					alert('You have successfuly updated your profile!');
					location.href = 'settings-account.php';
				</script>
				";
		} else {
			echo "
				<script = 'text/javascript>
					alert('Profile update was unsuccessful!');
					location.href = 'settings-account.php';
				</script>
				";
			}
	}

?>