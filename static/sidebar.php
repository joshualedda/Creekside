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
        <a class="nav-link" href="error404.php">
          <i class="bi bi-cart3"></i>
          <span>Orders</span> 
        </a>
      </li><!-- End Orders Nav -->

      <li class="nav-item">
        <a class="nav-link" href="error404.php">
          <i class="bi bi-file-earmark-text"></i>
          <span>Reports</span>
        </a>
      </li><!-- End Reports Nav -->

      <li class="nav-heading"><strong><i class="bi bi-gear"></i>Settings</strong></li>

      <li class="nav-item">
        <a class="nav-link" href="settings-foodmenu.php">
          <i class="bx bx-food-menu"></i>
          <span>Food Menu</span>
        </a>
      </li><!-- End Food Menu Nav -->

      <li class="nav-item">
        <a class="nav-link" href="settings-dishtypes.php">
          <i class="bx bx-restaurant"></i>
          <span>Dish Types</span>
        </a>
      </li><!-- End Dish Type Nav -->

      <li class="nav-item">
        <a class="nav-link" href="error404.php">
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
        <a class="nav-link" href="error404.php">
          <i class="bi bi-cart3"></i>
          <span>Orders</span> 
        </a>
      </li><!-- End Orders Nav -->

      <li class="nav-item">
        <a class="nav-link" href="error404.php">
          <i class="bi bi-file-earmark-text"></i>
          <span>Reports</span>
        </a>
      </li><!-- End Reports Nav -->

      <li class="nav-heading"><strong><i class="bi bi-gear"></i>Settings</strong></li>

      <li class="nav-item">
        <a class="nav-link" href="error404.php">
          <i class="bx bx-food-menu"></i>
          <span>Food Menu</span>
        </a>
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