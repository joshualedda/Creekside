<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  include 'includes/links.php';
  include 'includes/header.php';
  include 'includes/sidebar.php';
  include ('connection.php');
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
      <div class="row">

        <!-- Transactions Card -->
        <div class="col-xxl-4 col-md-4">

          <div class="card info-card orders-card">

            <div class="filter" id="filterTransactions">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>

                <li><a class="dropdown-item" href="#">Today</a></li>
                <li><a class="dropdown-item" href="#">This Month</a></li>
                <li><a class="dropdown-item" href="#">This Year</a></li>
              </ul>
            </div>

            <div class="card-body">
              <h5 class="card-title">Total Transactions <span>| This Year</span></h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-cart3"></i>
                </div>
                <div class="ps-3" id="transactions">
                  <h6>1244</h6>

                </div>
              </div>

            </div>
          </div>
        </div><!-- End Transactions  Card -->

        <!-- Sales Card -->
        <div class="col-xxl-4 col-md-4">
          <div class="card info-card revenue-card">

            <div class="filter" id="filterSales">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>

                <li><a class="dropdown-item" href="#">Today</a></li>
                <li><a class="dropdown-item" href="#">This Month</a></li>
                <li><a class="dropdown-item" href="#">This Year</a></li>
              </ul>
            </div>

            <div class="card-body">
              <h5 class="card-title">Gross Sales <span>| This Month</span></h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-cash-coin"></i>
                </div>
                <div class="ps-3" id="sales">
                  <h6>₱3,264</h6>

                </div>
              </div>
            </div>

          </div>
        </div><!-- End Sales Card -->

        <!-- Dishes Card -->
        <div class="col-xxl-4 col-md-4">
          <div class="card info-card sales-card">

            <div class="filter" id="filterDishes">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>

                <li><a class="dropdown-item" href="#">Today</a></li>
                <li><a class="dropdown-item" href="#">This Month</a></li>
                <li><a class="dropdown-item" href="#">This Year</a></li>
              </ul>
            </div>

            <div class="card-body">
              <h5 class="card-title">Dishes Sold <span>| Today</span></h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="ri ri-restaurant-2-line"></i>
                </div>
                <div class="ps-3" id="dishes">
                  <h6>145</h6>

                </div>
              </div>
            </div>

          </div>
        </div><!-- End Dishes Card -->



        <div class="col-lg-6">
          <div class="card">
            <div class="card-body">


              <div class="row">
                <div class="col-lg-4">
                  <h5 class="card-title">Delivery Method Usage</h5>
                </div>
                <div class="col-lg-8 d-flex align-items-center justify-content-end my-3">
                  <div class="me-3">
                    <select class="form-select" id="yearOffense" aria-label="Year selection"
                      onchange="fetchDataAndUpdateChart()">
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
                  <div>
                    <select class="form-select monthly-select" id="monthlyTransaction" aria-label="Month selection"
                      onchange="fetchDataAndUpdateChart()">
                      <?php
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
                        echo "<option value=\"$value\">$month</option>";
                      }
                      ?>
                    </select>



                  </div>
                </div>
              </div>

              <canvas id="pieChartOffense" style="max-height: 400px;"></canvas>


            </div>
          </div>
        </div>


<!-- barchart -->
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
              <canvas id="barChart" style="max-height: 400px;"></canvas>
            </div>
          </div>
        </div>



        <!-- Left side columns -->
        <div class="col-lg-7">
          <div class="row">

            <!-- Recent Sales -->
            <div class="col-12">
              <div class="card recent-sales overflow-auto">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Recent Sales <span>| Today</span></h5>

                  <table class="table table-borderless datatable">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Customer</th>
                        <th scope="col">Product</th>
                        <th scope="col">Price</th>
                        <th scope="col">Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th scope="row"><a href="#">#2457</a></th>
                        <td>Brandon Jacob</td>
                        <td><a href="#" class="text-primary">At praesentium minu</a></td>
                        <td>$64</td>
                        <td><span class="badge bg-success">Approved</span></td>
                      </tr>
                      <tr>
                        <th scope="row"><a href="#">#2147</a></th>
                        <td>Bridie Kessler</td>
                        <td><a href="#" class="text-primary">Blanditiis dolor omnis similique</a></td>
                        <td>$47</td>
                        <td><span class="badge bg-warning">Pending</span></td>
                      </tr>
                      <tr>
                        <th scope="row"><a href="#">#2049</a></th>
                        <td>Ashleigh Langosh</td>
                        <td><a href="#" class="text-primary">At recusandae consectetur</a></td>
                        <td>$147</td>
                        <td><span class="badge bg-success">Approved</span></td>
                      </tr>
                      <tr>
                        <th scope="row"><a href="#">#2644</a></th>
                        <td>Angus Grady</td>
                        <td><a href="#" class="text-primar">Ut voluptatem id earum et</a></td>
                        <td>$67</td>
                        <td><span class="badge bg-danger">Rejected</span></td>
                      </tr>
                      <tr>
                        <th scope="row"><a href="#">#2644</a></th>
                        <td>Raheem Lehner</td>
                        <td><a href="#" class="text-primary">Sunt similique distinctio</a></td>
                        <td>$165</td>
                        <td><span class="badge bg-success">Approved</span></td>
                      </tr>
                    </tbody>
                  </table>

                </div>

              </div>
            </div><!-- End Recent Sales -->



          </div>
        </div><!-- End Left side columns -->

        <!-- Right side columns -->
        <div class="col-lg-5">

          <!-- Top Selling -->
          <div class="col-12">
            <div class="card top-selling overflow-auto">

              <div class="filter">
                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                  <li class="dropdown-header text-start">
                    <h6>Filter</h6>
                  </li>

                  <li><a class="dropdown-item" href="#">Today</a></li>
                  <li><a class="dropdown-item" href="#">This Month</a></li>
                  <li><a class="dropdown-item" href="#">This Year</a></li>
                </ul>
              </div>

              <div class="card-body pb-0">
                <h5 class="card-title">Top Selling <span>| This Month</span></h5>

                <table class="table table-borderless">
                  <thead>
                    <tr>
                      <th scope="col">Preview</th>
                      <th scope="col">Product</th>
                      <th scope="col">Price</th>
                      <th scope="col">Sold</th>
                      <th scope="col">Revenue</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <th scope="row"><a href="#"><img src="assets/img/adobo.jpg" alt="" style="height: 70px;"></a></th>
                      <td><a href="#" class="text-primary fw-bold">Adobo</a></td>
                      <td>₱255</td>
                      <td class="fw-bold">124</td>
                      <td>₱31,620</td>
                    </tr>
                    <tr>
                      <th scope="row"><a href="#"><img src="assets/img/sinigang.png" alt="" style="height: 70px;"></a>
                      </th>
                      <td><a href="#" class="text-primary fw-bold">Sinigang Bangus</a></td>
                      <td>₱285</td>
                      <td class="fw-bold">98</td>
                      <td>₱27,930</td>
                    </tr>
                    <tr>
                      <th scope="row"><a href="#"><img src="assets/img/tinola.jpg" alt="" style="height: 70px;"></a>
                      </th>
                      <td><a href="#" class="text-primary fw-bold">Tinola</a></td>
                      <td>₱265</td>
                      <td class="fw-bold">74</td>
                      <td>₱19,610</td>
                    </tr>
                    <tr>
                      <th scope="row"><a href="#"><img src="assets/img/curry.jpg" alt="" style="height: 70px;"></a></th>
                      <td><a href="#" class="text-primary fw-bold">Chicken Curry</a></td>
                      <td>₱275</td>
                      <td class="fw-bold">63</td>
                      <td>₱17,325</td>
                    </tr>
                    <tr>
                      <th scope="row"><a href="#"><img src="assets/img/fried.webp" alt="" style="height: 70px;"></a>
                      </th>
                      <td><a href="#" class="text-primary fw-bold">Fried Chicken (Half)</a></td>
                      <td>₱240</td>
                      <td class="fw-bold">41</td>
                      <td>₱9,840</td>
                    </tr>
                  </tbody>
                </table>

              </div>

            </div>
          </div><!-- End Top Selling -->

        </div><!-- End Right side columns -->

      </div>
    </section>

  </main><!-- End #main -->


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Initialize empty arrays for all months
            const highestData = Array(12).fill(0);
            const lowestData = Array(12).fill(0);

            // Create the Chart instance
            const barChart = new Chart(document.querySelector('#barChart'), {
                type: 'bar',
                data: {
                    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    datasets: [
                        {
                            label: 'Highest',
                            data: highestData, // Use the highestData array
                            backgroundColor: 'rgba(54, 162, 235, 0.2)', 
                            borderColor: 'rgb(54, 162, 235)', 
                            borderWidth: 1
                        },
                        {
                            label: 'Lowest',
                            data: lowestData, // Use the lowestData array
                            backgroundColor: 'rgba(255, 159, 64, 0.2)', 
                            borderColor: 'rgb(255, 159, 64)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Function to fetch highest and lowest quantities from backend and update chart
            function fetchDataAndUpdateChart() {
                $.ajax({
                    url: 'charts/barchart.php', // The path to your PHP script
                    method: 'GET',
                    dataType: 'json', // Ensure we expect JSON
                    success: function(response) {
                        if(response.success) {
                            const data = response.data;

                            for (let i = 0; i < 12; i++) {
                                const monthIndex = i + 1;
                                if(data[monthIndex]) {
                                    highestData[i] = data[monthIndex].max_quantity;
                                    lowestData[i] = data[monthIndex].min_quantity;
                                } else {
                                    highestData[i] = 0;
                                    lowestData[i] = 0;
                                }
                            }

                            barChart.update(); // Update the chart with new data
                        } else {
                            console.error('Error in response:', response.message);

                            
                        }
                    },
                    error: function(error) {
                        console.error('Error fetching data:', error);
                    }
                });
            }

            // Fetch data and update chart on page load
            fetchDataAndUpdateChart();
        });
    </script>






  <script src="assets/js/piechart.js"></script>
  <?php include 'includes/footer.php'; ?>

</body>

</html>