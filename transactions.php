<!DOCTYPE html>
<html lang="en">

<head>
<?php
    include 'includes/links.php';
    include 'includes/header.php';
    include 'includes/sidebarAll.php';
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
          <li class="breadcrumb-item active">Transactions</li>
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
                    <th scope="col">Total Price (₱)</th>
                    <th scope="col">Status</th>
                    <!-- <th scope="col">Actions</th> -->
                  </tr>
                </thead>
                <tbody>
  <?php  
    include 'connection.php';

    $username = $_SESSION['username'];
    $user_id = $_SESSION['user_id'];
    $query = "SELECT transactions.*, concat(users.fname,' ',users.lname) as attendant FROM `transactions` LEFT JOIN `users` ON transactions.user_id = users.user_id ORDER BY date DESC";
    $result = $con->query($query);
    // $x = 1;

    if ($result) {
      while ($row = $result->fetch_assoc()) { 
        $trans_id = $row['trans_id'];
        $customer = $row['customer'];
        $total_price = $row['total_price'];
        $attendant = $row['attendant'];
        $date = $row['date'];
        $status = $row['status'];?>
                  <tr>
                    <!-- <td><?php echo $x++ ?></td> -->
                    <td><?php echo $date ?></td>
                    <td><?php echo $customer ?></td>
                    <td><?php echo $attendant ?></td>
                    <td style="text-align: right;"><?php echo $total_price ?></td>
            <?php if ($status === 'Completed') { ?>
                    <td><font class="badge bg-success rounded-pill"><b><?php echo $status ?></b></font></td>
            <?php
            } elseif ($status === 'Cancelled') { ?>
                    <td><font class="badge bg-danger rounded-pill"><b><?php echo $status ?></b></font></td>
            <?php
            } elseif ($status === 'Pending') { ?>
                    <td><font class="badge bg-warning rounded-pill"><b><?php echo $status ?></b></font></td> 
            <?php
            } elseif ($status === 'Paid') { ?>
                    <td><font class="badge bg-info rounded-pill"><b><?php echo $status ?></b></font></td> 
            <?php
            } ?>
                      <!-- Add add orders Modal -->
                      <div class="modal fade" id="addDishes-<?php echo $trans_id ?>" tabindex="-1">
                        <div class="modal-dialog modal-xl modal-dialog-centered">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title">Customer Name: <b><?php echo $customer ?></b></h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form class="needs-validation" novalidate action="orders-dishes-add.php" method="POST">
                              <div class="modal-body">

                                <div>
                                  <input name="trans_id" type="text" class="form-control" id="trans_id" value="<?php echo $trans_id ?>" hidden>
                                </div>

                              </div>
                          <?php if ($status === 'Pending') { ?>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="button" name="submit">Confirm</button>
                              </div> <?php
                          } else { ?>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              </div> <?php
                          } ?>
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