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
      <h1>Dish Types</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php"><i class="bi bi-house-door"></i></a></li>
          <li class="breadcrumb-item">Settings</li>
          <li class="breadcrumb-item active">Dish Types</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dish">

          <div class="card">
            <div class="card-body">
              <br>
              <button class="btn btn2 btn-sm" data-bs-toggle="modal" data-bs-target="#addDish"><i class="bx bx-plus-circle"></i> New dish type</button>

<!-- Add new dish Modal -->
              <div class="modal fade" id="addDish" tabindex="-1">
                <div class="modal-dialog modal-sm modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Enter Dish Type Details</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form class="needs-validation" novalidate action="settings-dishtypes-add.php" method="POST">
                      <div class="modal-body">

                        <div class="form-floating mb-3">
                          <input name="name" type="text" class="form-control" id="name" placeholder="Name" required autofocus>
                          <label for="Name">Name</label>
                        </div>

                        <div class="form-floating mb-3">
                          <input name="main_" type="text" class="form-control" id="main_" placeholder="Main Ingredient" >
                          <label for="main_">Main Ingredient</label>
                        </div>

                        <div class="form-floating mb-3">
                          <input name="weight" type="text" class="form-control" id="weight" placeholder="Weight">
                          <label for="weight">Weight (in grams)</label>
                        </div>

                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="button" name="submit">Save</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div><!-- End Vertically centered Modal-->

              <table class="table table-hover datatable">
                <thead>
                  <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Main Ingredient</th>
                    <th scope="col">Weight</th>
                    <!-- <th scope="col">Action</th> -->
                  </tr>
                </thead>
                <tbody>

<?php  
  include 'connection.php';

  $username = $_SESSION['username'];
  $query = "SELECT * FROM dish_type ORDER BY name ASC";
  $result = $con->query($query);

  if ($result) {
    while ($row = $result->fetch_assoc()) { 
      $id = $row['type_id'];
      $name = $row['name'];
      $main_ = $row['main_'];
      $weight = $row['weight'];?>

                  <tr>
                    <td><?php echo $name ?></td>
                    <td><?php echo $main_ ?></td>
                    <td><?php echo $weight ?>g</td>
<!--                     <td>
                      <button class="button rounded-pill" data-bs-toggle="modal" data-bs-target="#updateDish">Update</button>
                    </td> -->
<!-- Add new dish Modal -->
              <div class="modal fade" id="updateDish" tabindex="-1">
                <div class="modal-dialog modal-sm modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Update Details</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form class="needs-validation" novalidate action="settings-foodmenu-add.php" method="POST">
                      <div class="modal-body">

                        <div class="form-floating mb-3">
                          <input name="dish_name" type="text" class="form-control" id="dish_name" value="<?php echo $name; ?>" placeholder="Dish Name" required>
                          <label for="dish_name">Name of Dish</label>
                        </div>

                        <div class="form-floating mb-3">
                          <select name="type" class="form-select" id="type" aria-label="Floating label select example" required>
                            <option selected>Choose type</option>
                            <option value="Solo">Solo</option>
                            <option value="Platter">Platter</option>
                            <option value="Catering">Catering</option>
                          </select>
                          <label for="type">Type</label>
                        </div>

                        <div class="form-floating mb-3">
                          <input name="weight" type="text" class="form-control" id="weight" placeholder="Weight" required>
                          <label for="weight">Weight (in grams)</label>
                        </div>

                        <div class="form-floating mb-3">
                          <input name="price" type="text" class="form-control" id="price" placeholder="Price">
                          <label for="price" required>Price (₱)</label>
                        </div>

                        <div class="form-floating mb-3">
                          <select name="status" class="form-select" id="status" aria-label="Floating label select example" hidden>
                            <option value="Available" selected>Available</option>
                            <option value="Unavailable">Unavailable</option>
                          </select>
                          <label for="status" hidden>Status</label>
                        </div>

                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="button" name="submit">Save changes</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div><!-- End Vertically centered Modal-->
                    </td>
                  </tr>
  
    <?php }
  } ?>
                </tbody>
              </table>
            </div>
          </div>





    </section>

  </main><!-- End #main -->

<?php include 'includes/footer.php'; ?>

</body>

</html>