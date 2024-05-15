  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

<?php 
  include 'connection.php';

  $role = $_SESSION['role'];

  if ($role === 'Admin') { ?>
    <ul class="sidebar-nav" id="sidebar-nav">


      <li class="nav-item">
        <a class="nav-link" href="dashboard.php">
          <i class="bi bi-bar-chart-line"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#trans-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-cart3"></i>
          <span>Transactions</span> 
          <i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="trans-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
          <li>
            <a href="transactions.php">
              <i class="bi bi-circle"></i><span>List All</span>
            </a>
          </li>
          <li>
            <a href="transactions-pending.php">
              <i class="bi bi-circle"></i><span>Pending</span>
            </a>
          </li>
          <li>
            <a href="transactions-completed.php">
              <i class="bi bi-circle"></i><span>Completed</span>
            </a>
          </li>
          <li>
            <a href="transactions-cancelled.php">
              <i class="bi bi-circle"></i><span>Cancelled</span>
            </a>
          </li>
        </ul>
      </li><!-- End Transactions Nav -->

      <li class="nav-item">
        <a class="nav-link" href="reports.php">
          <i class="bi bi-file-earmark-text"></i>
          <span>Reports</span>
        </a>
      </li><!-- End Reports Nav -->

      <li class="nav-heading"><strong><i class="bi bi-gear"></i>Settings</strong></li>

      <li class="nav-item">
        <a class="nav-link collapse" data-bs-target="#menu-nav" data-bs-toggle="collapse" href="#">
          <i class="bx bx-food-menu"></i>
          <span>Food Menu</span>
          <i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="menu-nav" class="nav-content collapse show" data-bs-parent="#sidebar-nav">
          <li>
            <a href="settings-foodmenu.php" class="active">
              <i class="bi bi-circle-fill"></i><span>List All</span>
            </a>
          </li>
          <li>
            <a href="settings-foodmenu-AV.php">
              <i class="bi bi-circle"></i><span>Available</span>
            </a>
          </li>
          <li>
            <a href="settings-foodmenu-UN.php">
              <i class="bi bi-circle"></i><span>Unavailable</span>
            </a>
          </li>
        </ul>
      </li><!-- End Food Menu Nav -->

      <!--       <li class="nav-item">
        <a class="nav-link" href="settings-dishtypes.php">
          <i class="bx bx-restaurant"></i>
          <span>Dish Types</span>
        </a>
      </li> --><!-- End Dish Type Nav -->

      <li class="nav-item">
        <a class="nav-link" href="settings-inventory.php">
          <i class="bi bi-box-seam"></i>
          <span>Inventory</span>
        </a>
      </li><!-- End Inventory Nav -->

      <li class="nav-item">
        <a class="nav-link" href="settings-users.php">
          <i class="bi bi-people"></i>
          <span>Manage Users</span>
        </a>
      </li><!-- End Manage Users Nav -->

      <li class="nav-item">
        <a class="nav-link" href="settings-logs.php">
          <i class="bi bi-file-text"></i>
          <span>Transaction Logs</span>
        </a>
      </li><!-- End Transaction Logs Nav -->

      <li class="nav-item">
        <a class="nav-link" href="settings-backup.php">
          <i class="bi bi-download"></i>
          <span>System Backup</span>
        </a>
      </li><!-- End System Backup Nav -->
      
    </ul>
<?php
  } else { ?>
    <ul class="sidebar-nav" id="sidebar-nav">


      <li class="nav-item">
        <a class="nav-link" href="dashboard.php">
          <i class="bi bi-bar-chart-line"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#trans-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-cart3"></i>
          <span>Transactions</span> 
          <i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="trans-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
          <li>
            <a href="transactions.php">
              <i class="bi bi-circle"></i><span>List All</span>
            </a>
          </li>
          <li>
            <a href="transactions-pending.php">
              <i class="bi bi-circle"></i><span>Pending</span>
            </a>
          </li>
          <li>
            <a href="transactions-completed.php">
              <i class="bi bi-circle"></i><span>Completed</span>
            </a>
          </li>
          <li>
            <a href="transactions-cancelled.php">
              <i class="bi bi-circle"></i><span>Cancelled</span>
            </a>
          </li>
        </ul>
      </li><!-- End Transactions Nav -->

      <li class="nav-item">
        <a class="nav-link" href="reports.php">
          <i class="bi bi-file-earmark-text"></i>
          <span>Reports</span>
        </a>
      </li><!-- End Reports Nav -->

      <li class="nav-heading"><strong><i class="bi bi-gear"></i>Settings</strong></li>

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#menu-nav" data-bs-toggle="collapse" href="#">
          <i class="bx bx-food-menu"></i>
          <span>Food Menu</span>
          <i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="menu-nav" class="nav-content collapse show" data-bs-parent="#sidebar-nav">
          <li>
            <a href="settings-foodmenu.php" class="active">
              <i class="bi bi-circle-fill"></i><span>List All</span>
            </a>
          </li>
          <li>
            <a href="settings-foodmenu-AV.php">
              <i class="bi bi-circle"></i><span>Available</span>
            </a>
          </li>
          <li>
            <a href="settings-foodmenu-UN.php">
              <i class="bi bi-circle"></i><span>Unavailable</span>
            </a>
          </li>
        </ul>
      </li><!-- End Food Menu Nav -->

      <li class="nav-item">
        <a class="nav-link" href="settings-logs.php">
          <i class="bi bi-file-text"></i>
          <span>Transaction Logs</span>
        </a>
      </li><!-- End Transaction Logs Nav -->

      
    </ul>

<?php 
  }

?>


  </aside><!-- End Sidebar-->