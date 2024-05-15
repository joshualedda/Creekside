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
          <a href="settings-account.php">
                <button class="btn2 rounded-pill">Manage Account</button>
          </a>
              </div>
            </div>
    <?php }
  } ?>
        </div>
<hr>

        <div class="col-md-4">
            <div class="card">
              <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                <img src="assets/img/circle-add.png" class="rounded-circle">
                <h2>[Name]</h2>
                <h3>[Role]</h3>
          <a href="settings-users-new.php">
                <button class="btn2 rounded-pill">New User</button>
          </a>
              </div>
            </div>
        </div>  

<?php  
  include 'connection.php';

  $id = $_SESSION['user_id'];
  $query = "SELECT * FROM users WHERE user_id <> '$id' ORDER BY role ASC, lname ASC";
  $result = $con->query($query);

  if ($result) {
    while ($row = $result->fetch_assoc()) { ?>

        <div class="col-md-4">
          <!-- <a href="settings-users-profile?id=<?php echo $row['user_id'] ?>.php"> -->
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
                  <input type="text" name="id" hidden value="<?php echo $row['user_id']; ?>">
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