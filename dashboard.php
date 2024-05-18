<?php
include "controllers/Index.php";
$db = new db;
$conn = $db->con;
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Monthly
$totalTransactionSales = $db->totalTransactionSales();
$totalGrossSalesThisMonth = $db->totalGrossSalesThisMonth();
$totalDishedSoldMonth = $db->totalDishedSoldMonth();

// Weekly
$totalTransactionSalesWeekly = $db->totalTransactionSalesWeekly();
$totalGrossSalesThisWeek = $db->totalGrossSalesThisWeek();
$totalDishedSoldWeekly = $db->totalDishedSoldWeekly();

// Yearly
$totalTransactionSalesYearly = $db->totalTransactionSalesYearly();
$totalGrossSalesThisYear = $db->totalGrossSalesThisYear();
$totalDishedSoldYearly = $db->totalDishedSoldYearly();
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  include 'includes/links.php';
  include 'includes/header.php';
  include 'includes/sidebar.php';
  ?>
</head>

<body>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php"><i class="bi bi-house-door"></i></a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">


    <div class="col-md-2 my-2">
    <select class="form-select" id="cardSelector" aria-label="Time selection">
        <option value="weekly">Weekly</option>
        <option value="monthly">Monthly</option>
        <option value="yearly">Yearly</option>
    </select>
</div>
      

<div class="row">

        
<div id="weekly">

<div class="row">

<div class="col-xxl-4 col-md-4">
  <div class="card info-card orders-card">
    <div class="card-body">
      <h5 class="card-title">Total Transactions <span>| This Week</span></h5>

      <div class="d-flex align-items-center">
        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
          <i class="bi bi-cart3"></i>
        </div>
        <div class="ps-3" id="transactions">
          <h6><?= $totalTransactionSalesWeekly ?></h6>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Sales Card -->
<div class="col-xxl-4 col-md-4">
  <div class="card info-card revenue-card">
    <div class="card-body">
      <h5 class="card-title">Gross Sales <span>| This Week</span></h5>

      <div class="d-flex align-items-center">
        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
          <i class="bi bi-cash-coin"></i>
        </div>
        <div class="ps-3" id="sales">
          <h6>₱<?= $totalGrossSalesThisWeek ?></h6>

        </div>
      </div>
    </div>
  </div>
</div>

<div class="col-xxl-4 col-md-4">
  <div class="card info-card sales-card">
    <div class="card-body">
      <h5 class="card-title">Dishes Sold <span>| This Week</span></h5>

      <div class="d-flex align-items-center">
        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
          <i class="ri ri-restaurant-2-line"></i>
        </div>
        <div class="ps-3" id="dishes">
          <h6><?= $totalDishedSoldWeekly ?></h6>

        </div>
      </div>
    </div>

  </div>
</div>
</div>


</div>




<div id="monthly" style="display: none;">

<div class="row">

        <div class="col-xxl-4 col-md-4">
          <div class="card info-card orders-card">
            <div class="card-body">
              <h5 class="card-title">Total Transactions <span>| This Month</span></h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-cart3"></i>
                </div>
                <div class="ps-3" id="transactions">
                  <h6><?= $totalTransactionSales ?></h6>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Sales Card -->
        <div class="col-xxl-4 col-md-4">
          <div class="card info-card revenue-card">
            <div class="card-body">
              <h5 class="card-title">Gross Sales <span>| This Month</span></h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-cash-coin"></i>
                </div>
                <div class="ps-3" id="sales">
                  <h6>₱<?= $totalGrossSalesThisMonth ?></h6>

                </div>
              </div>
            </div>
          </div>
        </div><!-- End Sales Card -->

        <!-- Dishes Card -->
        <div class="col-xxl-4 col-md-4">
          <div class="card info-card sales-card">
            <div class="card-body">
              <h5 class="card-title">Dishes Sold <span>| This Month</span></h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="ri ri-restaurant-2-line"></i>
                </div>
                <div class="ps-3" id="dishes">
                  <h6><?=$totalDishedSoldMonth ?></h6>

                </div>
              </div>
            </div>

          </div>
        </div>
        </div>
        
      
      </div>














<div  id="yearly" style="display: none;">
<div class="row">

        <div class="col-xxl-4 col-md-4">
          <div class="card info-card orders-card">
            <div class="card-body">
              <h5 class="card-title">Total Transactions <span>| This Year</span></h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-cart3"></i>
                </div>
                <div class="ps-3" id="transactions">
                  <h6><?= $totalTransactionSalesYearly ?></h6>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Sales Card -->
        <div class="col-xxl-4 col-md-4">
          <div class="card info-card revenue-card">
            <div class="card-body">
              <h5 class="card-title">Gross Sales <span>| This Year</span></h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-cash-coin"></i>
                </div>
                <div class="ps-3" id="sales">
                  <h6>₱<?= $totalGrossSalesThisYear ?></h6>

                </div>
              </div>
            </div>
          </div>
        </div><!-- End Sales Card -->

        <!-- Dishes Card -->
        <div class="col-xxl-4 col-md-4">
          <div class="card info-card sales-card">
            <div class="card-body">
              <h5 class="card-title">Dishes Sold <span>| This Year</span></h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="ri ri-restaurant-2-line"></i>
                </div>
                <div class="ps-3" id="dishes">
                  <h6><?= $totalDishedSoldYearly ?></h6>

                </div>
              </div>
            </div>

          </div>
        </div>
        </div>


        </div>












        <div class="col-lg-6">
          <div class="card ">
            <div class="card-body my-1">


              <div class="row">
                <div class="col-lg-4">
                  <h5 class="card-title">Delivery Method Usage</h5>
                </div>
                <div class="col-lg-8 d-flex align-items-center justify-content-end my-3">
                  <div class="me-3">
                  <select class="form-select" id="yearOffense" aria-label="Year selection" onchange="fetchDataAndUpdateChart()">
    <?php
    $currentYear = date('Y');
    $startYear = 2023;
    $endYear = 2030;

    $years = range($startYear, $endYear);

    foreach ($years as $year) {
        $selected = ($year == $currentYear) ? 'selected' : '';
        echo "<option value=\"$year\" $selected>$year</option>";
    }
    ?>
</select>



                  </div>
                  <div>
                  <select class="form-select monthly-select" id="monthlyTransaction" aria-label="Month selection" onchange="fetchDataAndUpdateChart()">
    <?php
    $currentMonth = date('m');
    $months = [
        'January' => '01',
        'February' => '02',
        'March' => '03',
        'April' => '04',
        'May' => '05',
        'June' => '06',
        'July' => '07',
        'August' => '08',
        'September' => '09',
        'October' => '10',
        'November' => '11',
        'December' => '12'
    ];

    foreach ($months as $month => $value) {
        $selected = ($value === $currentMonth) ? 'selected' : '';
        echo "<option value=\"$value\" $selected>$month</option>";
    }
    ?>
</select>


                  </div>
                </div>
              </div>

              <canvas id="pieChartOffense" style="max-height: 350px;"></canvas>


            </div>
          </div>
        </div>


        <div class="col-lg-6">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-lg-4">
                  <h5 class="card-title">Dished Ordered</h5>
                </div>
                <div class="col-lg-3 ms-auto my-3">

                  <select class="form-select" id="year" aria-label="Default select example">
                    <?php
                    $currentYear = date('Y');
                    $startYear = 2023;
                    $endYear = 2030;

                    $years = range($startYear, $endYear);

                    foreach ($years as $year) {
                      $selected = ($year === $currentYear) ? 'selected' : '';
                      echo "<option value=\"$year\" $selected>$year</option>";
                    }
                    ?>
                  </select>
                </div>
              </div>
              <canvas id="barChart"></canvas>
            </div>
          </div>
        </div>


        <!-- Left side columns -->
        <div class="col-lg-6">
          <div class="row">

            <!-- Recent Sales -->
            <div class="col-12">
              <div class="card recent-sales overflow-auto">


                <div class="card-body">
                  <h5 class="card-title">Recent Sales <span>| This Week</span></h5>

                  <table class="table table-borderless datatable">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Customer</th>
                        <th scope="col">Total Price</th>
                        <th scope="col">Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $result = $db->transactionsThisWeek();
                      if ($result) {
                        $counter = 1;
                        while ($row = mysqli_fetch_array($result)) {
                          echo '<tr>';
                          echo '<td>' . $counter++ . '</td>';
                          echo '<td>' . $row['customer'] . '</td>';
                          echo '<td>' . $row['total_price'] . '</td>';
                          echo '<td>' . $row['status'] . '</td>';
                          echo '</tr>';
                        }
                      } else {
                        echo '<tr><td colspan="4">No transactions found for this week.</td></tr>';
                      }
                      ?>
                    </tbody>
                  </table>

                </div>

              </div>
            </div><!-- End Recent Sales -->



          </div>
        </div><!-- End Left side columns -->

        <!-- Right side columns -->
        <div class="col-lg-6">
          <div class="row">

            <!-- Recent Sales -->
            <div class="col-12">
              <div class="card recent-sales overflow-auto">

       

                <div class="card-body">
                  <h5 class="card-title">Top Selling <span>| This Week</span></h5>

                  <table class="table table-borderless datatable">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Dish Name</th>
                        <th scope="col">Total Quantity</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $result = $db->topSellingDishes();
                      if ($result) {
                        $counter = 1;
                        foreach ($result as $row) {
                          echo '<tr>';
                          echo '<td>' . $counter++ . '</td>';
                          echo '<td>' . $row['dish_name'] . '</td>';
                          echo '<td>' . $row['total_quantity'] . '</td>';
                          echo '</tr>';
                        }
                      } else {
                        echo '<tr><td colspan="3">No data found.</td></tr>';
                      }
                      ?>
                    </tbody>

                  </table>

                </div>

              </div>
            </div><!-- End Recent Sales -->



          </div>
        </div><!-- End Left side columns -->

      </div>



















    </section>

  </main><!-- End #main -->

  <script>
    // Function to hide all cards
    function hideAllCards() {
        document.getElementById('monthly').style.display = 'none';
        document.getElementById('weekly').style.display = 'none';
        document.getElementById('yearly').style.display = 'none';
    }

    // Show weekly by default when the page loads
    document.addEventListener('DOMContentLoaded', function() {
        hideAllCards(); // Hide all cards first
        document.getElementById('weekly').style.display = 'block'; // Show the weekly card by default

        // Add event listener for the select change
        document.getElementById('cardSelector').addEventListener('change', function() {
            var selectedCard = this.value;

            hideAllCards(); // Hide all cards

            // Show the selected card
            document.getElementById(selectedCard).style.display = 'block';
        });
    });
</script>







  <script src="assets/js/piechart.js"></script>
  <script src="assets/js/barchart.js"></script>
  <?php include 'includes/footer.php'; ?>

</body>

</html>