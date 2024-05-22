<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  include 'includes/links.php';
  include 'includes/header.php';
  include 'includes/sidebarPending.php';
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
          <li class="breadcrumb-item active">Transactions (Pending)</li>
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
          <table class="table table-hover datatable" id="transactions_table">
            <thead>
              <tr style="white-space: nowrap;">
                <!-- <th scope="col">#</th> -->
                <th scope="col">Date & Time</th>
                <th scope="col">Customer</th>
                <th scope="col">Attendant</th>
                <th scope="col">Total Price (₱)</th>
                <th scope="col">Delivery Method</th>
                <!-- <th scope="col">Delivery Address</th> -->

                <th scope="col">Status</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php
              include 'connection.php';

              $username = $_SESSION['username'];
              $query = "SELECT transactions.*, concat(users.fname,' ',users.lname) as attendant FROM `transactions` LEFT JOIN `users` ON transactions.user_id = users.user_id WHERE status = 'Pending' || status = 'Paid' ORDER BY date DESC";
              $result = $con->query($query);
              // $x = 1;

              if ($result) {
                while ($row = $result->fetch_assoc()) {
                  $trans_id = $row['trans_id'];
                  $customer = $row['customer'];
                  $total_price = $row['total_price'];
                  $attendant = $row['attendant'];
                  $date = $row['date'];
                  $delivery_date = $row['delivery_date'];
                  $delivery_method = $row['delivery_method'];

                  $address = $row['address'];
                  $status = $row['status']; ?>

                  <?php
                  $dbDate = $delivery_date;
                  $newDate = new DateTime($dbDate);
                  $formattedDate = $newDate->format("M. j, Y");
                  ?>
                  <tr>
                    <!-- <td><?php echo $x++ ?></td> -->
                    <td><?php echo date('F j, Y', strtotime($date)); ?></td>


                    <td><?php echo $customer ?></td>
                    <td><?php echo $attendant ?></td>



                    <?php if ($total_price == '0.00') { ?>
                      <td></td>
                    <?php } else { ?>
                      <td>₱ <?php echo $total_price ?></td>
                    <?php } ?>


                    <?php if ($delivery_date == '0000-00-00' || $delivery_date == NULL) { ?>
                      <td></td>
                    <?php } else { ?>
                      <td><?php echo $delivery_method;
                          echo ' on ';
                          echo $formattedDate ?></td>
                    <?php } ?>

                    <!-- <td><?= $address  ?></td> -->
                    <?php if ($status == 'Pending') { ?>
                      <td>
                        <font class="badge bg-warning rounded-pill"><b><?php echo $status ?></b></font>
                      </td>
                    <?php
                    } elseif ($status == 'Paid') { ?>
                      <td>
                        <font class="badge bg-info rounded-pill"><b><?php echo $status ?></b></font>
                      </td>
                    <?php } ?>
                    <td>
                      <button class="btn btn-secondary btn-sm " data-bs-toggle="modal" data-bs-target="#editCustomer-<?php echo $trans_id ?>" <?php echo ($status == 'Paid') ? 'disabled' : '' ?>><i class="bi bi-pencil-square" data-bs-toggle="tooltip" title="Edit name"></i> </button>
                      <button class="btn btn2 btn-sm" data-bs-toggle="modal" data-bs-target="#<?php echo ($status === 'Paid') ? 'viewDishes' : 'addDishes'; ?>-<?php echo $trans_id ?>">
                        <i class="ri ri-restaurant-fill" data-bs-toggle="tooltip" title="<?php echo ($status === 'Paid') ? 'View dishes' : 'Order dishes'; ?>"></i>
                      </button>
                      <button class="btn btn-primary btn-sm paid-btn" data-bs-toggle="modal" data-bs-target="#paid-<?php echo $trans_id ?>" <?php echo ($total_price == 0.00) ? 'disabled' : '' ?> <?php echo ($status == 'Paid') ? 'hidden' : '' ?>>
                        <font style="padding: 2px;" data-bs-toggle="tooltip" title="Confirm payment">₱</font>
                      </button>
                      <button class="btn btn-success btn-sm complete-btn" data-bs-toggle="modal" data-bs-target="#completeOrder-<?php echo $trans_id ?>" <?php echo ($status == 'Pending') ? 'hidden' : '' ?>><i class="bi bi-check-circle" data-bs-toggle="tooltip" title="Complete transaction"></i></button>
                      <button class="btn btn-danger btn-sm " data-bs-toggle="modal" data-bs-target="#cancelOrder-<?php echo $trans_id ?>" <?php echo ($status == 'Paid') ? 'disabled' : '' ?>><i class="bi bi-x-circle" data-bs-toggle="tooltip" title="Cancel transaction"></i></button>

                      <!-- Edit customer Modal -->
                      <div class="modal fade" id="editCustomer-<?php echo $trans_id ?>" tabindex="-1">
                        <div class="modal-dialog modal-sm modal-dialog-centered">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title">Edit Customer Name</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form class="needs-validation" novalidate action="transactions-edit.php" method="POST">
                              <div class="modal-body">

                                <div>
                                  <label for="customer">Customer Name</label>
                                  <input name="customer" type="text" class="form-control" id="customer" placeholder="Enter Customer Name" value="<?php echo $customer ?>" required autofocus>
                                </div>

                                <div>
                                  <input name="trans_id" type="text" class="form-control" id="trans_id" value="<?php echo $trans_id ?>" hidden>
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

                      <!-- Add orders Modal -->
                      <div class="modal fade" id="addDishes-<?php echo $trans_id ?>" tabindex="-1">
                        <div class="modal-dialog modal-xl">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title">Customer Name: <b><?php echo $customer ?></b></h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form class="needs-validation" novalidate action="transactions-dishes-add.php" method="POST" id="orderForm">
                              <div class="modal-body">

                                <div>
                                  <input name="trans_id" type="text" class="form-control" id="trans_id" value="<?php echo $trans_id ?>" hidden>
                                  <input type="hidden" name="order_details" id="order_details" value="" required>
                                </div>

                                <div class="row">
                                  <div class="col-auto">
                                    <div class="card">
                                      <div class="card-body">
                                        <!-- <h5 class="card-title">Food Menu:</h5> -->

                                        <div class="mb-3">
                                          <label for="searchDish" class="form-label">
                                            <h5 class="card-title">Food Menu:</h5>
                                          </label>
                                          <input type="text" class="form-control" id="searchDish" placeholder="Search dish name" autofocus>
                                        </div>

                                        <table class="table table-hover">
                                          <thead>
                                            <tr>
                                              <th hidden>Dish ID</th>
                                              <th>Dish Name</th>
                                              <th hidden>Main</th>
                                              <th hidden>Weight</th>
                                              <th>Price (₱)</th>
                                              <th>Action</th>
                                            </tr>
                                          </thead>
                                          <tbody id="dishTableBody">
                                            <tr>
                                              <td colspan="3" align="center">
                                                <font color="#6c757d">--Search to display dish details--</font>
                                              </td>
                                            </tr>
                                          </tbody>
                                        </table>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col">
                                    <div class="card">
                                      <div class="card-body">
                                        <h5 class="card-title">Transaction Details:</h5>
                                        <table class="table table-hover" id="orderTable">
                                          <thead>
                                            <tr>
                                              <th>Action</th>
                                              <th hidden>Dish ID</th>
                                              <th>Dish Name</th>
                                              <th>Price (₱)</th>
                                              <th>Quantity</th>
                                              <th>Subtotal (₱)</th>
                                            </tr>
                                          </thead>
                                          <tbody id="orderTableBody">
                                            <?php
                                            $queryDishes = "SELECT transactions.*, dishes_ordered.*,  dishes.dish_name, dishes.price 
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
                                                $delivery_date = $row['delivery_date'];
                                                $address = $row['address']; ?>

                                                <tr data-dish-id="<?php echo $dish_id ?>">
                                                  <td><button class="badge btn btn-danger removeRow"><i class="bi bi-x-square"></i></button></td>
                                                  <td hidden> <?php echo $dish_id ?></td>
                                                  <td><?php echo $dish_name ?></td>
                                                  <td class="price"><?php echo $price ?></td>
                                                  <td class="col-3"><input type="number" class="form-control quantity-input" value="<?php echo $quantity ?>" min="1"></td>
                                                  <td class="subtotal" style="text-align: right;"><?php echo $subtotal ?></td>
                                                </tr>

                                            <?php
                                              }
                                            }
                                            ?>
                                          </tbody>
                                        </table>
                                        <div class="row">
                                          <div class="col">
                                            <button type="button" class="btn btn-sm btn-danger" id="clearAllRows">Clear All</button>
                                          </div>
                                          <div class="col-auto">
                                            <label for="total_price" class="col-form-label"><b>Total Price (₱):</b></label>
                                          </div>
                                          <div class="col-3">
                                            <input type="text" class="form-control" name="total_price" id="total_price" placeholder="0.00" style="text-align: right;" value="<?php echo $total_price ?>">
                                          </div>
                                        </div>
                                        <hr>



                                        <div class="row">
                                          <div class="col">
                                            <label for="delivery_method">Delivery Method</label>
                                            <select name="delivery_method" id="delivery_method" class="form-select" required>
                                              <option value="" <?php if (empty($delivery_method)) echo 'selected disabled'; ?>>Select method</option>
                                              <option value="For Pickup" <?php if ($delivery_method === "For Pickup") echo 'selected'; ?>>For Pickup</option>
                                              <option value="For Delivery" <?php if ($delivery_method === "For Delivery") echo 'selected'; ?>>For Delivery</option>
                                            </select>
                                          </div>
                                        </div>



                                        <div class="col" id="address" style="display: none;">
                                          <label for="">Address</label>
                                          <input type="text" class="form-control" name="address" value="<?= $address ?>" />
                                        </div>













                                        <div class="col"></div>
                                        <div class="col-auto">
                                          <label class="col-form-label">Pickup/Delivery Date:</label>
                                        </div>
                                        <div class="col-3">
                                          <input name="delivery_date" type="date" class="form-control" value="<?php echo $delivery_date ?>" min="<?php echo date('Y-m-d'); ?>" required>

                                        </div>
                                      </div>
                                    </div>





                                  </div>
                                </div>

                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn button" name="submitOrder">Confirm</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div><!-- End Vertically centered Modal-->

                      <!-- View orders Modal -->
                      <div class="modal fade" id="viewDishes-<?php echo $trans_id ?>" tabindex="-1">
                        <div class="modal-dialog">
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
                                  </tbody>
                                </table>
                                <div class="row">
                                  <div class="col"></div>
                                  <div class="col-auto">
                                    <label class="col-form-label"><b>Total Price (₱):</b></label>
                                  </div>
                                  <div class-auto">
                                    <label class="col-form-label"><?php echo $total_price ?></label>
                                  </div>
                                  <div class="col-auto"></div>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div><!-- End Vertically centered Modal-->

                      <!-- Complete transaction Modal -->
                      <div class="modal fade" id="completeOrder-<?php echo $trans_id ?>" tabindex="-1">
                        <div class="modal-dialog modal-sm">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title">Complete Transaction</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form class="needs-validation" novalidate action="transactions-complete.php" method="POST">
                              <div class="modal-body">

                                Are you sure the transaction with <b><?php echo $customer ?></b> has been completed?
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

                      <!-- Paid transaction Modal -->
                      <div class="modal fade" id="paid-<?php echo $trans_id ?>" tabindex="-1">
                        <div class="modal-dialog modal-sm">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title">Confirm Payment</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form class="needs-validation" novalidate action="transactions-paid.php" method="POST">
                              <div class="modal-body">

                                Are you sure <b><?php echo $customer ?></b> has given payment?
                                <div>
                                  <input name="trans_id" type="text" class="form-control" id="trans_id" value="<?php echo $trans_id ?>" hidden>
                                </div>

                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary" name="submit">Confirm</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div><!-- End Vertically centered Modal-->

                      <!-- Cancel transaction Modal -->
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







  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const deliveryMethodSelect = document.getElementById('delivery_method');
      const addressInputDiv = document.getElementById('address');

      // Function to show or hide the address input based on the selected delivery method
      function toggleAddressInput() {
        if (deliveryMethodSelect.value === 'For Delivery') {
          addressInputDiv.style.display = 'block';
        } else {
          addressInputDiv.style.display = 'none';
        }
      }

      // Execute the function on page load
      toggleAddressInput();

      // Event listener for the change event on the delivery method select
      deliveryMethodSelect.addEventListener('change', toggleAddressInput);
    });
  </script>







  <!-- <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script> -->
  <script src="assets/js/jquery.min.js"></script>
  <script>
    $(document).ready(function() {
      var orderDetailsArray = []; // Array to store order details

      // Listen for changes in the search bar within each modal
      $('[id^="searchDish"]').on('input', function() {
        var searchQuery = $(this).val();
        var currentModalId = $(this).closest('.modal').attr('id');

        $.ajax({
          type: 'POST',
          url: 'search_dishes.php',
          data: {
            searchQuery: searchQuery
          },
          success: function(data) {
            $('#' + currentModalId + ' #dishTableBody').html(data);
          }
        });
      });

      // Handle "Clear All" button visibility
      function updateClearButtonVisibility(modalId) {
        var orderTableBody = $('#' + modalId + ' #orderTableBody');
        var clearButton = $('#' + modalId + ' #clearAllRows');

        if (orderTableBody.find('tr').length >= 2) {
          clearButton.show();
        } else {
          clearButton.hide();
        }
      }

      // Show/hide "Clear All" button when the modal is opened
      $('[id^="addDishes"]').on('show.bs.modal', function() {
        var currentModalId = $(this).attr('id');
        updateClearButtonVisibility(currentModalId);
      });

      // Handle "Add to List" button clicks
      $(document).on('click', '[id^="dishTableBody"] button.addToList', function() {
        var currentModalId = $(this).closest('.modal').attr('id');
        var dishId = $(this).data('dish-id');
        var dishName = $(this).data('dish-name');
        var dishPrice = parseFloat($(this).data('dish-price'));

        var existingRow = $('#' + currentModalId + ' #orderTableBody tr[data-dish-id="' + dishId + '"]');
        if (existingRow.length > 0) {
          var currentQuantity = parseInt(existingRow.find('input.quantity-input').val());
          existingRow.find('input.quantity-input').val(currentQuantity + 1);
        } else {
          var newRow = '<tr data-dish-id="' + dishId + '">' +
            '<td><button class="badge btn btn-danger removeRow"><i class="bi bi-x-square"></i></button></td>' +
            '<td hidden>' + dishId + '</td>' +
            '<td>' + dishName + '</td>' +
            '<td class="price">' + dishPrice.toFixed(2) + '</td>' +
            '<td class="col-3"><input type="number" class="form-control quantity-input" value="1" min="1"></td>' +
            '<td class="subtotal" style="text-align: right;">' + dishPrice.toFixed(2) + '</td>' +
            '</tr>';

          $('#' + currentModalId + ' #orderTableBody').append(newRow);
        }

        updateOrderDetailsArray(currentModalId);
        updateOrderTable(currentModalId);
        updateClearButtonVisibility(currentModalId);
      });

      // Handle changes in the quantity input fields in the order table
      $(document).on('input', '[id^="orderTableBody"] input.quantity-input', function() {
        var currentModalId = $(this).closest('.modal').attr('id');
        updateOrderDetailsArray(currentModalId);
        updateOrderTable(currentModalId);
      });

      // Update order details array based on the content of the order table
      function updateOrderDetailsArray(modalId) {
        orderDetailsArray = []; // Clear the array
        $('#' + modalId + ' #orderTableBody tr').each(function() {
          var dishId = $(this).data('dish-id');
          var dishName = $(this).find('td:eq(2)').text();
          var quantity = parseInt($(this).find('input.quantity-input').val());
          var price = parseFloat($(this).find('td.price').text());
          var subtotal = quantity * price;

          var orderDetails = {
            dishId: dishId,
            dishName: dishName,
            quantity: quantity,
            price: price.toFixed(2),
            subtotal: subtotal.toFixed(2)
          };

          orderDetailsArray.push(orderDetails);
        });

        // Convert the array to a JSON string
        var orderDetailsString = JSON.stringify(orderDetailsArray);

        // Put the JSON string in the order_details input
        $('#' + modalId + ' #order_details').val(orderDetailsString);
      }

      // Function to update the order table
      function updateOrderTable(modalId) {
        var orderTableBody = $('#' + modalId + ' #orderTableBody');
        var total_price_input = $('#' + modalId + ' #total_price');
        var total_price = 0;

        orderTableBody.find('tr').each(function() {
          var quantity = parseInt($(this).find('input.quantity-input').val());
          var price = parseFloat($(this).find('td.price').text());
          var subtotal = quantity * price;

          $(this).find('td.subtotal').text(subtotal.toFixed(2));

          total_price += subtotal;
        });

        total_price_input.val(total_price.toFixed(2));
      }

      // Handle "Remove" button clicks
      $(document).on('click', '[id^="orderTableBody"] button.removeRow', function() {
        var currentModalId = $(this).closest('.modal').attr('id');
        $(this).closest('tr').remove();

        updateOrderDetailsArray(currentModalId);
        updateOrderTable(currentModalId);
        updateClearButtonVisibility(currentModalId);
      });

      // Handle "Clear All" button click
      $(document).on('click', '[id^="addDishes"] #clearAllRows', function() {
        var currentModalId = $(this).closest('.modal').attr('id');
        $('#' + currentModalId + ' #orderTableBody').empty();

        updateOrderDetailsArray(currentModalId);
        updateClearButtonVisibility(currentModalId);
        updateOrderTable(currentModalId);
      });

      // Handle form submission
      $('form.needs-validation').submit(function() {
        $('#order_details').val(JSON.stringify(orderDetailsArray));
        return true;
      });
    });
  </script>


</body>


</html>