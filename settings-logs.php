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
      <h1>Transaction Logs</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php"><i class="bi bi-house-door"></i></a></li>
          <li class="breadcrumb-item">Settings</li>
          <li class="breadcrumb-item active">Transaction Logs</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">


          <div class="card">
            <div class="card-body">
              <br>
              <!-- <button class="button" data-bs-toggle="modal" data-bs-target="#addDish"><i class="bi bi-printer"></i> Print</button> -->


              <table class="table table-hover datatable">
                <thead>
                  <tr>
                    <!-- <th scope="col">ID</th> -->
                    <th scope="col">Timestamp</th>
                    <!-- <th scope="col">User ID</th> -->
                    <th scope="col">User</th>
                    <th scope="col">Action</th>
                    <th scope="col">Description</th>
                  </tr>
                </thead>
                <tbody>
<?php

$role = $_SESSION['role'];

if ($role === 'Admin') {
    $sql = "SELECT * FROM logs ORDER BY timestamp DESC";
    $result = $con->query($sql);

    while ($row = $result->fetch_assoc()) {
          // $id = $row['id'];
          $timestamp = $row['timestamp'];
          // $user_id = $row['user_id'];
          $name = $row['name'];
          $action = $row['action'];
          $description = $row['description'];?>

                      <tr>
                        <!-- <td><?php echo $id ?></td> -->
                        <td><?php echo $timestamp ?></td>
                        <!-- <td><?php echo $user_id ?></td> -->
                        <td><?php echo $name ?></td>
                        <td><?php echo $action ?></td>
                        <td><?php echo $description ?></td>
                      </tr>
    <?php 
    }
    echo '</tbody>';
    echo '</table>';
} else {
  $user_id = $_SESSION['user_id'];
  $sql = "SELECT * FROM logs WHERE user_id = $user_id ORDER BY timestamp DESC";
    $result = $con->query($sql);

    while ($row = $result->fetch_assoc()) {
          $timestamp = $row['timestamp'];
          $name = $row['name'];
          $action = $row['action'];
          $description = $row['description'];?>

                      <tr>
                        <td><?php 
                              $dbDate = $timestamp;
                              $date = new DateTime($dbDate);
                              $formattedDate = $date->format("m/d/Y, H:i:s");
                              echo $formattedDate;
                            ?></td>
                        <td><?php echo $name ?></td>
                        <td><?php echo $action ?></td>
                        <td><?php echo $description ?></td>
                      </tr>
    <?php 
    }
    echo '</tbody>';
    echo '</table>';
}
?>
            </div>
          </div>  
    </section>
  </main><!-- End #main -->

<?php include 'includes/footer.php'; ?>

</body>

</html>