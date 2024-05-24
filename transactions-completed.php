<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  include 'includes/links.php';
  include 'includes/header.php';
  include 'includes/sidebarComplete.php';
  include('connection.php');
  ?>
</head>

<body>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Transactions</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php"><i class="bi bi-house-door"></i></a></li>
          <li class="breadcrumb-item active">Transactions (Completed)</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">


      <div class="card">
        <div class="card-body">
          <br>
          <button class="btn btn2 btn-sm" data-bs-toggle="modal" data-bs-target="#newTransaction"><i class="bi bi-plus-circle"></i> New Transaction</button>

          <!-- Add new order Modal -->
          <div class="modal fade" id="newTransaction" tabindex="-1">
            <div class="modal-dialog modal-sm modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">New Transaction</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="needs-validation" novalidate action="transactions-add.php" method="POST">
                  <div class="modal-body">

                    <div>
                      <label for="customer">Customer Name</label>
                      <input name="customer" type="text" class="form-control" id="customer" placeholder="Enter Customer Name" required autofocus>
                    </div>

                    <div>
                      <input name="id" type="text" class="form-control" id="id" value="<?php echo $_SESSION['user_id'] ?>" hidden>
                    </div>

                    <div>
                      <input name="status" type="text" class="form-control" id="status" value="Pending" hidden>
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

          <!-- Table with hoverable rows -->
          <table class="table table-hover datatable">
            <thead>
              <tr>
                <!-- <th scope="col">#</th> -->
                <th scope="col">Date & Time</th>
                <th scope="col">Customer Name</th>
                <th scope="col">Transaction Attendant</th>
                <th scope="col">Total Price</th>
                <!-- <th scope="col">Delivery Method</th> -->
                <th scope="col">Date Delivered</th>
                <th scope="col">Status</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php
              include 'connection.php';

              $username = $_SESSION['username'];
              $query = "SELECT transactions.*, concat(users.fname,' ',users.lname) as attendant FROM `transactions` LEFT JOIN `users` ON transactions.user_id = users.user_id WHERE status = 'Completed' ORDER BY date_delivered DESC";
              $result = $con->query($query);
              // $x = 1;

              if ($result) {
                while ($row = $result->fetch_assoc()) {
                  $trans_id = $row['trans_id'];
                  $customer = $row['customer'];
                  $total_price = $row['total_price'];
                  $attendant = $row['attendant'];
                  $date = $row['date'];
                  $delivery_method = $row['delivery_method'];
                  $delivery_date = $row['delivery_date'];
                  $date_delivered = $row['date_delivered'];
                  $status = $row['status']; ?>
                  <tr>
                    <!-- <td><?php echo $x++ ?></td> -->
                    <td><?php echo $date; ?></td>


                    <td><?php echo $customer ?></td>
                    <td><?php echo $attendant ?></td>
                    <td>₱ <?php echo number_format($total_price, 2); ?></td>

                    <!-- <td><b><?php echo $delivery_method ?></b> on <?php echo $delivery_date ?></td> -->
                    <td><?php echo $date_delivered ?></td>
                    <td>
                      <font class="badge bg-success rounded-pill"><b><?php echo $status ?></b></font>
                    </td>
                    <td>
                      <button class="btn btn2 btn-sm " data-bs-toggle="modal" data-bs-target="#addDishes-<?php echo $trans_id ?>"><i class="ri ri-restaurant-fill"></i> </button>

                      <!-- Add orders Modal -->
                      <div class="modal fade" id="addDishes-<?php echo $trans_id ?>" tabindex="-1">
                        <div class="modal-dialog ">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title">Transaction Details</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form class="needs-validation" novalidate action="transactions-dishes-add.php" method="POST" id="orderForm">
                              <div class="modal-body">

                                <!-- <h5>Customer Name: <b><?php echo $customer ?></b></h5> -->
                                <table class="table table-hover" id="orderTable">
                                  <thead>
                                    <tr>
                                      <th hidden>Dish ID</th>
                                      <th>Dish Name</th>
                                      <th style="text-align: right;">Price (₱)</th>
                                      <th style="text-align: right;">Quantity</th>
                                      <th style="text-align: right;">Subtotal (₱)</th>
                                    </tr>
                                  </thead>
                                  <tbody id="orderTableBody">
                                    <?php
                                    $queryDishes = "SELECT transactions.*, dishes_ordered.*,  dishes.dish_name 
                                                      FROM transactions LEFT JOIN dishes_ordered 
                                                                            ON dishes_ordered.trans_id = transactions.trans_id
                                                                        LEFT JOIN dishes 
                                                                            ON dishes.dish_id = dishes_ordered.dish_id WHERE dishes_ordered.trans_id = $trans_id;";
                                    $resultQuery = $con->query($queryDishes);

                                    if ($resultQuery) {
                                      while ($row = $resultQuery->fetch_assoc()) {
                                        $dish_id = $row['dish_id'];
                                        $dish_name = $row['dish_name'];
                                        $quantity = $row['quantity'];
                                        $price = $row['price'];
                                        $subtotal = $row['subtotal'];
                                        $total_price = $row['total_price'];
                                        $delivery_method = $row['delivery_method'];
                                        $delivery_date = $row['delivery_date']; ?>

                                        <tr data-dish-id="<?php echo $dish_id ?>">
                                          <td hidden> <?php echo $dish_id ?></td>
                                          <td><?php echo $dish_name ?></td>
                                          <td class="price" style="text-align: right;"><?php echo $price ?></td>
                                          <td class="col-3" style="text-align: right;"><?php echo $quantity ?></td>
                                          <td class="subtotal" style="text-align: right;"><?php echo $subtotal ?></td>
                                        </tr>

                                    <?php
                                      }
                                    }
                                    ?>
                                    <tr>
                                      <td><b>Total Price (₱):</b></td>
                                      <td></td>
                                      <td></td>
                                      <td style="text-align: right;"><?php echo $total_price ?></td>
                                    </tr>
                                  </tbody>
                                </table>
                                <!--                                 <div class="row">
                                  <div class="col"></div>
                                  <div class="col-auto">
                                    <label class="col-form-label"><b>Total Price (₱):</b></label>
                                  </div>
                                  <div class="col-auto">
                                    <label class="col-form-label"><?php echo $total_price ?></label>
                                  </div>
                                  <div class="col-auto"></div>
                                </div> -->
                                <!--                                 <hr>
                                <div>
                                                      <?php
                                                      $dbDate = $delivery_date;
                                                      $date = new DateTime($dbDate);
                                                      $formattedDate = $date->format("F j, Y");
                                                      ?>
                                  <b><?php echo $delivery_method ?></b> on <b><?php echo $formattedDate ?></b>
                                </div>
 -->

                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div><!-- End Vertically centered Modal-->

                      <!-- Add complete order Modal -->
                      <div class="modal fade" id="completeOrder-<?php echo $trans_id ?>" tabindex="-1">
                        <div class="modal-dialog modal-sm">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title">Complete Transaction</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form class="needs-validation" novalidate action="transactions-complete.php" method="POST">
                              <div class="modal-body">

                                Are you sure the transaction with <b><?php echo $customer ?></b> is complete?
                                <div>
                                  <input name="trans_id" type="text" class="form-control" id="trans_id" value="<?php echo $trans_id ?>" hidden>
                                </div>

                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-success" name="submit">Confirm</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div><!-- End Vertically centered Modal-->

                      <!-- Add cancel order Modal -->
                      <div class="modal fade" id="cancelOrder-<?php echo $trans_id ?>" tabindex="-1">
                        <div class="modal-dialog modal-sm">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title">Cancel Transaction</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form class="needs-validation" novalidate action="transactions-cancel.php" method="POST">
                              <div class="modal-body">

                                Are you sure you want to cancel the transaction with <b><?php echo $customer ?></b>?

                                <div>
                                  <input name="trans_id" type="text" class="form-control" id="trans_id" value="<?php echo $trans_id ?>" hidden>
                                </div>

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
          <!-- End Table with hoverable rows -->

        </div>
      </div>

    </section>
  </main><!-- End #main -->

  <?php include 'includes/footer.php'; ?>

</body>

</html>