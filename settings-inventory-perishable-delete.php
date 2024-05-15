<?php 
	session_start();
	include 'connection.php';
	if (isset($_POST['submit'])) {
	
		$id = $_POST['id'];
    $item_name = $_POST['item_name'];

		$sql = "DELETE FROM inventory_perishable WHERE id = $id";
		if (mysqli_query($con, $sql)) { 
//for transation logs
          date_default_timezone_set('Asia/Manila');
          $timestamp = date('Y-m-d H:i:s');
          $user_id = $_SESSION['user_id'];
          $name = $_SESSION['name'];
          $query = "INSERT INTO logs (timestamp, user_id, name, action, description) VALUES 
          ('$timestamp', $user_id, '$name', 'Remove Item', 'Removed $item_name from inventory of perishables')";

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
      <h1>Inventory</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php"><i class="bi bi-house-door"></i></a></li>
          <li class="breadcrumb-item">Settings</li>
          <li class="breadcrumb-item active">Inventory</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dish">

          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col"> <!--Perishable-->
                  <h5 class="card-title">Perishable</h5>
                  
                  <button class="btn btn2 btn-sm" data-bs-toggle="modal" data-bs-target="#addPerishable"><i class="bx bx-plus-circle"></i> New item</button>
                  
                  <!-- Add new perishable Modal -->
                  <div class="modal fade" id="addPerishable" tabindex="-1">
                    <div class="modal-dialog modal-sm modal-dialog-centered">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Enter Item Details</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form class="needs-validation" novalidate action="settings-inventory-perishable-add.php" method="POST">
                          <div class="modal-body">

                            <div class="form-floating mb-3">
                              <input name="item_name" type="text" class="form-control" id="item_name" placeholder="Item Name" required autofocus>
                              <label for="item_name">Item Name</label>
                            </div>

                            <div class="form-floating mb-3">
                              <input name="quantity" type="number" step="1" min="0" class="form-control" id="quantity" placeholder="Quantity" required>
                              <label for="quantity">Quantity (kg)</label>
                            </div>

                            <!-- <div class="form-floating mb-3">
                              <input name="unit" type="text" class="form-control" id="unit" placeholder="Unit">
                              <label for="unit">Unit</label>
                            </div> -->

                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="button" name="submit">Save</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div><!-- End Vertically centered Modal-->

                  <table class="table table-hover datatable">
                    <thead>
                      <tr>
                        <th scope="col">Item Name</th>
                        <th scope="col">Quantity (kg)</th>
                        <!-- <th scope="col">Unit</th> -->
                        <th scope="col">Actions</th>
                      </tr>
                    </thead>
                    <tbody>

                    <?php  
                      include 'connection.php';

                      $username = $_SESSION['username'];
                      $query = "SELECT * FROM inventory_perishable ORDER BY item_name ASC";
                      $result = $con->query($query);

                      if ($result) {
                        while ($row = $result->fetch_assoc()) { 
                          $id = $row['id'];
                          $name = $row['item_name'];
                          $quantity = $row['quantity'];
                          $unit = $row['unit'];?>

                            <tr>
                              <td><a style="text-transform: capitalize;"><?php echo $name ?></a></td>
                              <td><?php echo $quantity ?></td>
                              <!-- <td><?php echo $unit ?></td> -->
                              <td>
                                <button class="btn2 badge rounded-pill" data-bs-toggle="modal" data-bs-target="#updatePerishable-<?php echo $id ?>"><i class="bx bxs-edit"></i></button>
                                <button class="btn3 badge rounded-pill" data-bs-toggle="modal" data-bs-target="#deletePerishable-<?php echo $id ?>"><i class="bx bxs-trash"></i></button>
                                <!-- Update perishable Modal -->
                                <div class="modal fade" id="updatePerishable-<?php echo $id ?>" tabindex="-1">
                                  <div class="modal-dialog modal-sm modal-dialog-centered">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title">Update Item</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      <form class="needs-validation" novalidate action="settings-inventory-perishable-update.php" method="POST">
                                        <div class="modal-body">

                                          <div>
                                            <input name="id" type="text" class="form-control" id="id" value="<?php echo $id ?>" placeholder="ID" required autofocus hidden>
                                          </div>

                                          <div class="form-floating mb-3">
                                            <input name="item_name" type="text" class="form-control" id="item_name" value="<?php echo $name ?>" placeholder="Item Name" required autofocus>
                                            <label for="item_name">Item Name</label>
                                          </div>

                                          <div class="form-floating mb-3">
                                            <input name="quantity" type="number" step="1" min="0" value="<?php echo $quantity ?>" class="form-control" id="quantity" placeholder="Quantity" required>
                                            <label for="quantity">Quantity (kg)</label>
                                          </div>

                                          <!-- <div class="form-floating mb-3">
                                            <input name="unit" type="text" class="form-control" id="unit" placeholder="Unit">
                                            <label for="unit">Unit</label>
                                          </div> -->

                                        </div>
                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                          <button type="submit" class="button" name="submit">Save</button>
                                        </div>
                                      </form>
                                    </div>
                                  </div>
                                </div><!-- End Vertically centered Modal-->
                                <!-- Delete perishable Modal -->
                                <div class="modal fade" id="deletePerishable-<?php echo $id ?>" tabindex="-1">
                                  <div class="modal-dialog modal-sm modal-dialog-centered">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title">Remove Item</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      <form class="needs-validation" novalidate action="settings-inventory-perishable-delete.php" method="POST">
                                        <div class="modal-body">

                                          <div>
                                            <input name="id" type="text" class="form-control" id="id" value="<?php echo $id ?>" placeholder="ID" required autofocus hidden>
                                          </div>

                                          Are you sure you want to remove <b><?php echo $name ?></b> from your inventory?

                                        </div>
                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                          <button type="submit" class="btn btn-danger" name="submit">Remove</button>
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

                <div class="col"> <!--Condiments-->
                  <h5 class="card-title">Condiments</h5>

                  <button class="btn btn2 btn-sm" data-bs-toggle="modal" data-bs-target="#addCondiments"><i class="bx bx-plus-circle"></i> New item</button>
                  
                  <!-- Add new condiment Modal -->
                  <div class="modal fade" id="addCondiments" tabindex="-1">
                    <div class="modal-dialog modal-sm modal-dialog-centered">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Enter Item Details</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form class="needs-validation" novalidate action="settings-inventory-condiments-add.php" method="POST">
                          <div class="modal-body">

                            <div class="form-floating mb-3">
                              <input name="item_name" type="text" class="form-control" id="item_name" placeholder="Item Name" required autofocus>
                              <label for="item_name">Item Name</label>
                            </div>

                            <div class="form-floating mb-3">
                              <input name="quantity" type="number" step="1" min="0" class="form-control" id="quantity" placeholder="Quantity" required>
                              <label for="quantity">Quantity</label>
                            </div>

                            <div class="form-floating mb-3">
                              <input name="unit" type="text" class="form-control" id="unit" placeholder="Unit" required>
                              <label for="unit">Unit</label>
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
                        <th scope="col">Item Name</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Unit</th>
                        <th scope="col">Actions</th>
                      </tr>
                    </thead>
                    <tbody>

                    <?php  
                      include 'connection.php';

                      $username = $_SESSION['username'];
                      $query = "SELECT * FROM inventory_condiments ORDER BY item_name ASC";
                      $result = $con->query($query);

                      if ($result) {
                        while ($row = $result->fetch_assoc()) { 
                          $id = $row['id'];
                          $name = $row['item_name'];
                          $quantity = $row['quantity'];
                          $unit = $row['unit'];?>

                            <tr>
                              <td><a style="text-transform: capitalize;"><?php echo $name ?></a></td>
                              <td><?php echo $quantity ?></td>
                              <td><?php echo $unit ?></td>
                              <td>
                                <button class="btn2 badge rounded-pill" data-bs-toggle="modal" data-bs-target="#updateCondiment-<?php echo $id ?>"><i class="bx bxs-edit"></i></button>
                                <button class="btn3 badge rounded-pill" data-bs-toggle="modal" data-bs-target="#deleteCondiment-<?php echo $id ?>"><i class="bx bxs-trash"></i></button>
                                <!-- Update perishable Modal -->
                                <div class="modal fade" id="updateCondiment-<?php echo $id ?>" tabindex="-1">
                                  <div class="modal-dialog modal-sm modal-dialog-centered">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title">Update Item</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      <form class="needs-validation" novalidate action="settings-inventory-condiments-update.php" method="POST">
                                        <div class="modal-body">

                                          <div>
                                            <input name="id" type="text" class="form-control" id="id" value="<?php echo $id ?>" placeholder="ID" required autofocus hidden>
                                          </div>

                                          <div class="form-floating mb-3">
                                            <input name="item_name" type="text" class="form-control" id="item_name" value="<?php echo $name ?>" placeholder="Item Name" required autofocus>
                                            <label for="item_name">Item Name</label>
                                          </div>

                                          <div class="form-floating mb-3">
                                            <input name="quantity" type="number" step="1" min="0" value="<?php echo $quantity ?>" class="form-control" id="quantity" placeholder="Quantity" required>
                                            <label for="quantity">Quantity (kg)</label>
                                          </div>

                                          <div class="form-floating mb-3">
                                            <input name="unit" type="text" class="form-control" id="unit" value="<?php echo $unit ?>" placeholder="Unit">
                                            <label for="unit">Unit</label>
                                          </div>

                                        </div>
                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                          <button type="submit" class="button" name="submit">Save</button>
                                        </div>
                                      </form>
                                    </div>
                                  </div>
                                </div><!-- End Vertically centered Modal-->
                                <!-- Delete perishable Modal -->
                                <div class="modal fade" id="deleteCondiment-<?php echo $id ?>" tabindex="-1">
                                  <div class="modal-dialog modal-sm modal-dialog-centered">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title">Remove Item</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      <form class="needs-validation" novalidate action="settings-inventory-perishable-delete.php" method="POST">
                                        <div class="modal-body">

                                          <div>
                                            <input name="id" type="text" class="form-control" id="id" value="<?php echo $id ?>" placeholder="ID" required autofocus hidden>
                                          </div>

                                          Are you sure you want to remove <b><?php echo $name ?></b> from your inventory?

                                        </div>
                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                          <button type="submit" class="btn btn-danger" name="submit">Remove</button>
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
            </div>
          </div>





    </section>

  </main><!-- End #main -->

<?php include 'includes/footer.php'; ?>

</body>

</html>

<?php			echo "
				<script = 'text/javascript>
					alert('You have successfuly removed an item!');
					location.href = 'settings-inventory.php';
				</script>
				";
		} else { echo "Error: " . $sql . "<br>" . mysqli_error($con);
			// echo "
			// 	<script = 'text/javascript>
			// 		alert('Adding new user profile was unsuccessful!');
			// 		location.href = 'settings-account.php';
			// 	</script>
			// 	";
			}

	}
?>