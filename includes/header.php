<?php
  session_start();

  if (!isset($_SESSION['username'])) {
    header ('Location: index.php');
  }
?>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">
    <title>The Creekside Cafè</title>
    <div class="d-flex align-items-center justify-content-between">
      <a href="dashboard.php" class="logo d-flex align-items-center">
        <img src="assets/img/creekside.png" alt="">
        <span class="d-none d-lg-block">The Creekside Café</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

<!--     <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="POST" action="#">
        <input type="text" name="query" placeholder="Search" title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form>
    </div> --> <!-- End Search Bar -->

    <nav class="header-nav ms-auto">

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
            ?>

      <ul class="d-flex align-items-center">

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <?php  
              if ($sex === 'Male') {
                  echo '<img src="assets/img/Male.png" alt="Profile" class="rounded-circle">';
              } elseif ($sex === 'Female') {
                  echo '<img src="assets/img/Female.png" alt="Profile" class="rounded-circle">';
              }
            ?>
          </a><!-- End Profile Image Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <div>
                <?php  
                  if ($sex === 'Male') {
                      echo '<img src="assets/img/Male.png" alt="Profile" class="rounded-circle" style="height: 100px;">';
                  } elseif ($sex === 'Female') {
                      echo '<img src="assets/img/Female.png" alt="Profile" class="rounded-circle" style="height: 100px;">';
                  }
                ?>
              <div>
                <h6><?php echo $name ?></h6>
                <span><?php echo $role ?></span>
              </div>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
    <?php
          } 
        }         
    ?>

<?php 
  include 'connection.php';

  $role = $_SESSION['role'];

  if ($role === 'Admin') { ?>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="settings-account.php">
                <i class="bi bi-person"></i>
                <span>Manage Account</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="settings-users.php">
                <i class="bi bi-people"></i>
                <span>Manage Users</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
<?php
  } else { ?>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="settings-account.php">
                <i class="bi bi-person"></i>
                <span>Manage Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
<?php 
  }

?>   
            <li>
              <a class="dropdown-item d-flex align-items-center" href="logout.php">
                <i class="bi bi-box-arrow-right"></i>
                <span>Log Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>

    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->