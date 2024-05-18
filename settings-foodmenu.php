<!DOCTYPE html>
<html lang="en">

<head>
<?php
    include 'includes/links.php';
    include 'includes/header.php';
    include 'includes/sidebar-FM.php';
    include('connection.php');
    $role = $_SESSION['role'];

 ?>
</head>

<body>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Food Menu</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php"><i class="bi bi-house-door"></i></a></li>
          <li class="breadcrumb-item">Settings</li>
          <li class="breadcrumb-item active">Food Menu</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dish">

          <div class="card">
            <div class="card-body">
              <br>
              <?php if ($role === 'Admin') { ?>
              <button class="btn btn2 btn-sm" data-bs-toggle="modal" data-bs-target="#addDish"><i class="bi bi-plus-circle"></i> New dish</button> <?php
              } ?>

              <!-- Add new dish Modal -->
              <div class="modal fade" id="addDish" tabindex="-1">
                <div class="modal-dialog modal-sm modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Enter Details</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form class="needs-validation" novalidate action="settings-foodmenu-add.php" method="POST">
                      <div class="modal-body">

                        <div class="form-floating mb-3">
                          <input name="dish_name" type="text" class="form-control" id="dish_name" placeholder="Dish Name" required autofocus>
                          <label for="dish_name">Name of Dish</label>
                        </div>

                        <div class="form-floating mb-3">
                          <select name="main_" class="form-select" id="main_" aria-label="Floating label select example" required>
                            <option value="(No main)" selected disabled>(No main)</option>
                            <?php
                              $sql = "SELECT * FROM inventory_perishable ORDER BY item_name ASC";
                              $result=mysqli_query($con, $sql);
                              while($row=mysqli_fetch_array($result)){ ?>
                                <option value="<?php echo $row['item_name'] ?>"><?php echo $row['item_name'] ?></option>
                              <?php }
                            ?>                          
                          </select>
                          <label for="main_">Main Ingredient</label>
                        </div>

                        <div class="form-floating mb-3">
                          <input name="weight" type="number" step="1" min="0" class="form-control" id="weight" placeholder="Weight" required>
                          <label for="weight">Weight (in grams)</label>
                        </div>

                        <div class="form-floating mb-3">
                          <input name="price" type="number" step="1" min="0" class="form-control" id="price" placeholder="Price" required>
                          <label for="price">Price (₱)</label>
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
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn button" name="submit">Save</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div><!-- End Vertically centered Modal-->
              <table class="table table-hover datatable">
        <?php if ($role === 'Admin') { ?>
                <thead>
                  <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Main Ingredient</th>
                    <th scope="col">Weight (g)</th>
                    <th scope="col">Price (₱)</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead> <?php
        } else { ?>
                <thead>
                  <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Main Ingredient</th>
                    <th scope="col">Weight (g)</th>
                    <th scope="col">Price (₱)</th>
                    <th scope="col">Status</th>
                  </tr>
                </thead> <?php
        }?>
                <tbody>

  <?php  
    include 'connection.php';

    $username = $_SESSION['username'];
    $query = "SELECT * FROM dishes ORDER BY dish_name ASC";
    $result = $con->query($query);

    if ($result) {
      while ($row = $result->fetch_assoc()) { 
        $id = $row['dish_id'];
        $name = $row['dish_name'];
        $main_ = $row['main_'];
        $weight = $row['weight'];
        $price = $row['price'];
        $status = $row['status'];?>

                  <tr>
                    <td><a style="text-transform: capitalize;"><?php echo $name ?></a></td>
                    <td><?php echo $main_ ?></td>
                    <td><?php echo $weight ?></td>
                    <td>₱ <?php echo number_format($price) ?></td>
            <?php if ($status === 'Available') { ?>
                    <td><font class="badge bg-success rounded-pill"><b><?php echo $status ?></b></font></td> <?php
            } elseif ($status === 'Unavailable') { ?>
                    <td><font class="badge bg-danger rounded-pill"><b><?php echo $status ?></b></font></td> <?php
            } ?>
<!--             <?php if ($status === 'Available') { ?>
                    <td><font color="#8a6734" size="5px"><i class="bi bi-toggle-on"></i></td> <?php
            } elseif ($status === 'Unavailable') { ?>
                    <td><font color="#8a6734" size="5px"><i class="bi bi-toggle-off"></i></td> <?php
            } ?> -->
        <?php if ($role === 'Admin') { ?>
                    <td>
                      <button class="btn btn2 btn-sm" data-bs-toggle="modal" data-bs-target="#updateDish-<?php echo $id ?>"><i class="bi bi-pencil-square"></i> Update</button>
                      <!-- <button class="btn3 badge rounded-pill" data-bs-toggle="modal" data-bs-target="#deleteDish-<?php echo $id ?>"><i class="bx bxs-trash"></i> Remove</button> -->
                        <!-- Add new dish Modal -->
                        <div class="modal fade" id="updateDish-<?php echo $id ?>" tabindex="-1">
                          <div class="modal-dialog modal-sm modal-dialog-centered">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title">Update Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <form class="needs-validation" novalidate action="settings-foodmenu-update.php" method="POST">
                                <div class="modal-body">

                                  <div>
                                    <input name="id" type="text" class="form-control" id="id" value="<?php echo $id; ?>" placeholder="ID" required hidden>
                                  </div>

                                  <div class="form-floating mb-3">
                                    <input name="dish_name" type="text" class="form-control" id="dish_name" value="<?php echo $name; ?>" placeholder="Dish Name" readonly>
                                    <label for="dish_name">Name of Dish</label>
                                  </div>

                                  <div class="form-floating mb-3">
                                    <input name="main_" type="text" class="form-control" id="main_" value="<?php echo $main_; ?>" placeholder="Main Ingredient" readonly>
                                    <label for="main_">Main Ingredient</label>
                                  </div>

                                  <div class="form-floating mb-3">
                                    <input name="weight" type="number" step="1" min="0" class="form-control" id="weight" placeholder="Weight" value="<?php echo $weight ?>" required>
                                    <label for="weight">Weight (in grams)</label>
                                  </div>

                                  <div class="form-floating mb-3">
                                    <input name="price" type="number" step="1" min="0" class="form-control" id="price" placeholder="Price" value="<?php echo $price ?>">
                                    <label for="price">Price (₱)</label>
                                  </div>

                                  <div class="form-floating mb-3">
                                    <select name="status" class="form-select" id="status" aria-label="Floating label select example">
                                      <option value="Available" selected>Available</option>
                                      <option value="Unavailable">Unavailable</option>
                                    </select>
                                    <label for="status">Status</label>
                                  </div>

                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                  <button type="submit" class="btn button" name="submit">Save</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div><!-- End Vertically centered Modal-->
                        <!-- Delete perishable Modal -->
                        <div class="modal fade" id="deleteDish-<?php echo $id ?>" tabindex="-1">
                          <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title">Remove Item</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <form class="needs-validation" novalidate action="settings-foodmenu-delete.php" method="POST">
                                <div class="modal-body">

                                  <div>
                                    <input name="id" type="text" class="form-control" id="id" value="<?php echo $id ?>" placeholder="ID" required autofocus hidden>
                                  </div>

                                  <div>
                                    <input name="dish_name" type="text" class="form-control" id="dish_name" value="<?php echo $name ?>" placeholder="ID" required autofocus hidden>
                                  </div>

                                  Are you sure you want to remove <a style="text-transform: capitalize;"><b><?php echo $name ?></b></a> from your food menu?

                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                  <button type="submit" class="btn btn-danger" name="submit">Confirm</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div><!-- End Vertically centered Modal-->
                    </td> <?php
        } ?>

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