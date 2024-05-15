<?php 
	session_start();
	include 'connection.php';
	if (isset($_POST['submit'])) {
	
		$role = $_POST['role'];
		$fname = $_POST['fname'];
		$mname = $_POST['mname'];
		$lname = $_POST['lname'];
		$bdate = $_POST['bdate'];
		$sex = $_POST['sex'];
	    $query = "SELECT provDesc FROM province WHERE provCode = ".$_POST['province']; 
	    $result = $con->query($query);
	    if ($result) {
		    while ($row = $result->fetch_assoc()) {
		        $province = $row['provDesc'];
		    }
		} else {
		    echo "Error: " . $con->error;
		}
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
		$username = $_POST['username'];
		$password = md5($_POST['password']);

		$sql = "INSERT INTO users (role,
								   fname,
								   mname,
								   lname,
								   bdate,
								   sex,
								   province,
								   municipality,
								   barangay,
								   contact_no,
								   email,
								   username,
								   password)
						   VALUES ('$role',
								   '$fname',
								   '$mname',
								   '$lname',
								   '$bdate',
								   '$sex',
								   '$province',
								   '$municipality',
								   '$barangay',
								   '$contact_no',
								   '$email',
								   '$username',
								   '$password')";
		if (mysqli_query($con, $sql)) {

//for transation logs
          date_default_timezone_set('Asia/Manila');
          $timestamp = date('Y-m-d H:i:s');
          $user_id = $_SESSION['user_id'];
          $name = $_SESSION['name'];
          $query = "INSERT INTO logs (timestamp, user_id, name, action, description) VALUES 
          ('$timestamp', $user_id, '$name', 'Add User', 'Added a new user profile')";

          if (mysqli_query($con, $query)) {
          } else {
            echo "Error: " . $query . "<br>" . mysqli_error($con); 
          }
//end log
?>
<!DOCTYPE html>
<html lang="en">

<head>
<?php
    include 'includes/links.php';
    include 'static/header.php';
    include 'includes/sidebar.php';
    include('connection.php');
 ?>
</head>

<body>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Add New User</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php"><i class="bi bi-house-door"></i></a></li>
          <li class="breadcrumb-item">Settings</li>
          <li class="breadcrumb-item"><a href="settings-users.php">Manage Users</a></li>
          <li class="breadcrumb-item active">Add New User</li>
          <li class="breadcrumb-item"><a href="settings-users.php"><i class="ri ri-arrow-go-back-line"></i></a></li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Enter User Details</h5>

          <form class="needs-validation row g-3" novalidate action="settings-users-new-add.php" enctype="multipart/form-data" method="POST">

            <div class="col-md-12">
              <label for="role" class="col-md-auto col-lg-auto col-form-label">Role</label>
              <div class="col-md col-lg">
                <select class="form-select" aria-label="Default select example" name="role" id="role" required>
                  <option value="Staff" selected>Staff</option>
                  <option value="Admin">Admin</option>
                </select>
              </div>
            </div>

            <div class="col-md-4">
              <label for="fname" class="col-md-auto col-lg-auto col-form-label">First Name</label>
              <div class="col-md col-lg">
                <input name="fname" type="text" class="form-control" id="fname" placeholder="Enter First Name" required autofocus>
                <div class="invalid-feedback">Please enter first name.</div>
              </div>
            </div>

            <div class="col-md-4">
              <label for="mname" class="col-md-auto col-lg-auto col-form-label">Middle Name</label>
              <div class="col-md col-lg">
                <input name="mname" type="text" class="form-control" id="mname" placeholder="Enter Middle Name">
              </div>
            </div>

            <div class="col-md-4">
              <label for="lname" class="col-md-auto col-lg-auto col-form-label">Last Name</label>
              <div class="col-md col-lg">
                <input name="lname" type="text" class="form-control" id="lname" placeholder="Enter Last Name" required>
                <div class="invalid-feedback">Please enter last name.</div>
              </div>
            </div>

            <div class="col-md-4">
              <label class="col-md-auto col-lg-auto col-form-label">Province</label>
              <div class="col-md col-lg">
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

            <div class="col-md-4">
              <label class="col-md-auto col-lg-auto col-form-label">City/Municipality</label>
              <div class="col-md col-lg">
                <select class="form-select" aria-label="Default select example" name = "municipality" id="city" required>
                  <option value="" selected disabled>Select City/Municipality</option>
                </select>
                <div class="invalid-feedback">Please select a city or municipality.</div>
              </div>
            </div>

            <div class="col-md-4">
              <label class="col-md-auto col-lg-auto col-form-label">Barangay</label>
              <div class="col-md col-lg">
                <select class="form-select" aria-label="Default select example" name = "barangay" id="barangay" required>
                  <option value="" selected disabled>Select Barangay</option>
                </select>
                <div class="invalid-feedback">Please select a barangay.</div>
              </div>
            </div>

            <div class="col-md-2">
              <label for="bdate" class="col-md-auto col-lg-auto col-form-label">Birthdate</label>
              <div class="col-md col-lg">
                <input name="bdate" type="date" class="form-control" id="bdate" required>
                <div class="invalid-feedback">Please pick a date.</div>
              </div>
            </div>

            <div class="col-md-2">
              <label for="sex" class="col-md-auto col-lg-auto col-form-label">Sex</label>
              <div class="col-md col-lg">
                <select class="form-select" aria-label="Default select example" name="sex" id="sex" required>
                  <option value="" selected disabled>Select Sex</option>
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                </select>
                <div class="invalid-feedback">Please select sex.</div>
              </div>
            </div>

            <div class="col-md-4">
              <label for="contact_no" class="col-md-auto col-lg-auto col-form-label">Contact Number</label>
              <div class="col-md col-lg">
                <input name="contact_no" type="text" class="form-control" id="contact_no" placeholder="09XXXXXXXXX" minlength="11" required>
                <div class="invalid-feedback">Please enter 11-digit contact number.</div>
              </div>
            </div>

            <div class="col-md-4">
              <label for="email" class="col-md-auto col-lg-auto col-form-label">Email Address</label>
              <div class="col-md col-lg">
                <input name="email" type="email" class="form-control" id="email" placeholder="example@example.com" required>
                <div class="invalid-feedback">Please enter email address.</div>
              </div>
            </div>

            <div class="col-md-6">
              <label for="username" class="col-md-auto col-lg-auto col-form-label">Username</label>
              <div class="col-md col-lg">
                <input name="username" type="text" class="form-control" id="username" placeholder="Enter Username" required>
                <div class="invalid-feedback">Please enter a username.</div>
              </div>
            </div>

            <div class="col-md-6">
              <label for="password" class="col-md-auto col-lg-auto col-form-label">Password</label>
              <div class="col-md col-lg">
                <input name="password" type="password" class="form-control" id="password" placeholder="Enter Password" minlength="8" required>
                <div class="invalid-feedback">Please enter an 8-character long password.</div>
              </div>
            </div>

            <div class="text-center">
              <button type="button" class="btn btn-secondary" onclick="history.back()">Cancel</button>
              <button type="submit" class="button" name="submit">Add User</button>
            </div>
          </form><!-- End Profile Edit Form -->

        </div>
      </div>
    </section>

  </main>
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
					alert('You have successfuly added a new user profile!');
					location.href = 'settings-users.php';
				</script>
				";
		} else {
			echo "
				<script = 'text/javascript>
					alert('Adding new user profile was unsuccessful!');
					location.href = 'settings-users.php';
				</script>
				";
			}

	}
?>