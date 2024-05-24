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

      <div class="row">
        <div class="col-md-6">


          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col"> <!--Perishables-->
                  <h5 class="card-title">Perishables</h5>

                  <button class="btn btn2 btn-sm" data-bs-toggle="modal" data-bs-target="#addPerishable"><i class="bi bi-plus-circle"></i> New item</button>

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
                              <input name="quantity" type="number" step="1" min="1" class="form-control" id="quantity" placeholder="Quantity" required>
                              <label for="quantity">Quantity (in kilograms)</label>
                            </div>

                            <!-- <div class="form-floating mb-3">
                              <input name="unit" type="text" class="form-control" id="unit" placeholder="Unit">
                              <label for="unit">Unit</label>
                            </div> -->

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
                          $unit = $row['unit']; ?>

                          <tr>
                            <td><a style="text-transform: capitalize;"><?php echo $name ?></a></td>
                            <td><?php echo $quantity ?></td>
                            <!-- <td><?php echo $unit ?></td> -->
                            <td>
                              <button class="btn btn-secondary btn-sm " data-bs-toggle="modal" data-bs-target="#updatePerishable-<?php echo $id ?>"><i class="bi bi-pencil-square"></i></button>
                              <button class="btn btn-danger btn-sm " data-bs-toggle="modal" data-bs-target="#deletePerishable-<?php echo $id ?>"><i class="bi bi-trash"></i> </button>
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
                                        <button type="submit" class="btn button" name="submit">Save</button>
                                      </div>
                                    </form>
                                  </div>
                                </div>
                              </div><!-- End Vertically centered Modal-->
                              <!-- Delete perishable Modal -->
                              <div class="modal fade" id="deletePerishable-<?php echo $id ?>" tabindex="-1">
                                <div class="modal-dialog modal-sm">
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

                                        <div>
                                          <input name="item_name" type="text" class="form-control" id="item_name" value="<?php echo $name ?>" placeholder="ID" required autofocus hidden>
                                        </div>

                                        Are you sure you want to remove <a style="text-transform: capitalize;"><b><?php echo $name ?></b></a> from your inventory?

                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-danger" name="submit">Confirm</button>
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
        </div>










        <div class="col-md-6">
          <div class="card">
            <div class="card-body">

              <div class="col"> <!--Condiments-->
                <h5 class="card-title">Condiments</h5>

                <button class="btn btn2 btn-sm" data-bs-toggle="modal" data-bs-target="#addCondiments"><i class="bi bi-plus-circle"></i> New item</button>

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
                            <input name="quantity" type="number" step="1" min="1" class="form-control" id="quantity" placeholder="Quantity" required>
                            <label for="quantity">Quantity</label>
                          </div>

                          <div class="form-floating mb-3">
                            <select name="unit" type="text" class="form-select" id="unit" aria-label="" required>
                              <option value="" selected disabled>select unit</option>
                              <option value="bag">bag</option>
                              <option value="bottle">bottle</option>
                              <option value="piece">piece</option>
                              <option value="sachet">sachet</option>
                            </select>
                            <label for="unit">Unit</label>
                          </div>

                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                          <button type="submit" class="btn button" name="submit">Save</button>
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
                        $unit = $row['unit']; ?>

                        <tr>
                          <td><a style="text-transform: capitalize;"><?php echo $name ?></a></td>
                          <td><?php echo $quantity ?></td>
                          <td><?php echo $unit ?></td>
                          <td>
                            <button class="btn btn-secondary btn-sm " data-bs-toggle="modal" data-bs-target="#updateCondiment-<?php echo $id ?>"><i class="bi bi-pencil-square"></i></button>
                            <button class="btn btn-danger btn-sm " data-bs-toggle="modal" data-bs-target="#deleteCondiment-<?php echo $id ?>"><i class="bi bi-trash"></i> </button>
                            <!-- Update condiment Modal -->
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
                                        <input name="id" type="text" class="form-control" id="id" value="<?php echo $id ?>" placeholder="ID" hidden>
                                      </div>

                                      <div class="form-floating mb-3">
                                        <input name="item_name" type="text" class="form-control" id="item_name" value="<?php echo $name ?>" placeholder="Item Name" readonly>
                                        <label for="item_name">Item Name</label>
                                      </div>

                                      <div class="form-floating mb-3">
                                        <input name="quantity" type="number" step="1" min="0" value="<?php echo $quantity ?>" class="form-control" id="quantity" placeholder="Quantity" required>
                                        <label for="quantity">Quantity (kg)</label>
                                      </div>

                                      <div class="form-floating mb-3">
                                        <input name="unit" type="text" class="form-control" id="unit" value="<?php echo $unit ?>" placeholder="Unit" required>
                                        <label for="unit">Unit</label>
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
                            <!-- Delete condiment Modal -->
                            <div class="modal fade" id="deleteCondiment-<?php echo $id ?>" tabindex="-1">
                              <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title">Remove Item</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <form class="needs-validation" novalidate action="settings-inventory-condiments-delete.php" method="POST">
                                    <div class="modal-body">

                                      <div>
                                        <input name="id" type="text" class="form-control" id="id" value="<?php echo $id ?>" placeholder="ID" required autofocus hidden>
                                      </div>

                                      <div>
                                        <input name="item_name" type="text" class="form-control" id="item_name" value="<?php echo $name ?>" placeholder="ID" required autofocus hidden>
                                      </div>

                                      Are you sure you want to remove <a style="text-transform: capitalize;"><b><?php echo $name ?></b></a> from your inventory?

                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                      <button type="submit" class="btn btn-danger" name="submit">Confirm</button>
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

      </div>
      </div>

      <!-- for col-6 -->
      </div>





    </section>

  </main><!-- End #main -->

  <?php include 'includes/footer.php'; ?>

</body>

</html>