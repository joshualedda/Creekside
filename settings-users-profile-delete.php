<?php 
	session_start();
	include 'connection.php';
	if (isset($_POST['submit'])) {

		$id = $_POST['id'];

		$sql = "DELETE FROM users WHERE user_id = '$id'";

		if (mysqli_query($con, $sql)) {  

//for transation logs
          date_default_timezone_set('Asia/Manila');
          $timestamp = date('Y-m-d H:i:s');
          $user_id = $_SESSION['user_id'];
          $name = $_SESSION['name'];
          $query = "INSERT INTO logs (timestamp, user_id, name, action, description) VALUES 
          ('$timestamp', $user_id, '$name', 'Delete Account', 'Deleted a user account')";

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
      <h1>Manage Users</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php"><i class="bi bi-house-door"></i></a></li>
          <li class="breadcrumb-item">Settings</li>
          <li class="breadcrumb-item active">Manage Users</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section profile error-404">

      <div class="row">
        <div class="">

<?php  
  include 'connection.php';

  $username = $_SESSION['username'];
  $query = "SELECT * FROM users WHERE username = '$username'";
  $result = $con->query($query);

  if ($result) {
    while ($row = $result->fetch_assoc()) { 
            $name = $row['fname']." ".$row['lname'];
    ?>

          <a href="settings-account.php">
            <div class="card">
              <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                <?php  
                  if ($row['sex'] === 'Male') {
                      echo '<img src="assets/img/Male.png" alt="Profile" class="rounded-circle">';
                  } elseif ($row['sex'] === 'Female') {
                      echo '<img src="assets/img/Female.png" alt="Profile" class="rounded-circle">';
                  }
                ?>
                <h2><?php echo $name ?></h2>
                <h3><?php echo $row['role'] ?></h3>
                <button class="btn2 rounded-pill">Manage Profile</button>
              </div>
            </div>
          </a>
    <?php }
  } ?>
        </div>
<hr>

        <div class="col-md-4">
          <a href="settings-users-new.php">
            <div class="card">
              <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                <img src="assets/img/circle-plus.png" class="rounded-circle">
                <h2>[Name]</h2>
                <h3>[Role]</h3>
                <button class="btn2 rounded-pill">New User</button>
              </div>
            </div>
          </a>
        </div>  

<?php  
  include 'connection.php';

  $username = $_SESSION['username'];
  $query = "SELECT * FROM users WHERE username <> '$username' ORDER BY role ASC, lname ASC";
  $result = $con->query($query);

  if ($result) {
    while ($row = $result->fetch_assoc()) { ?>

        <div class="col-md-4">
          <!-- <a href="settings-users-view.php"> -->
            <div class="card">
              <form action="settings-users-profile.php" method="POST">
                <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                  <?php  
                    if ($row['sex'] === 'Male') {
                        echo '<img src="assets/img/Male.png" alt="Profile" class="rounded-circle">';
                    } elseif ($row['sex'] === 'Female') {
                        echo '<img src="assets/img/Female.png" alt="Profile" class="rounded-circle">';
                    }
                  ?>
                  <h2><?php echo $row['lname'].", ".$row['fname']; ?></h2>
                  <h3><?php echo $row['role']; ?></h3>
                  <input type="text" name="username" hidden value="<?php echo $row['username']; ?>">
                  <button type="submit" class="btn2 rounded-pill" name="submit">View User</button>
                </div>
              </form>
            </div>
          <!-- </a> -->
        </div>   
    <?php }
  } ?>


    </section>

  </main><!-- End #main -->

<?php include 'includes/footer.php'; ?>

</body>

</html>

<?php
			echo "
				<script = 'text/javascript>
					alert('You have successfuly deleted this profile!');
					location.href = 'settings-users.php';
				</script>
				";
		} else { 
			echo "
				<script = 'text/javascript>
					alert('Profile update was unsuccessful!');
					location.href = 'settings-users.php';
				</script>
				";
			}
	}

?>