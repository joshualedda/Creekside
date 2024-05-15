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
      <h1>System Backup</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php"><i class="bi bi-house-door"></i></a></li>
          <li class="breadcrumb-item">Settings</li>
          <li class="breadcrumb-item active">System Backup</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Backup Your Database</h5>
              
                  <form action="backup/database_backup.php" method="POST">
                    <div class="col-lg-11">
                      <h5>
                        Backing up your system database is like making a copy of your important files and saving them in a safe place.
                      </h5>
                      <p>
                        It ensures that if something bad happens to your computer, you won't lose all your important information.  It's like having an extra jar of your special ingredient stored away. If anything happens to the original recipe, you can use the backup ingredient to fix it and keep your dish (or in this case, your computer system) running perfectly. Backups keep your data safe and make sure you can quickly get back to normal even if something unexpected happens.
                      </p>
                    </div>
                    <input name="server" type="text" id="server" hidden value="localhost">
                    <input name="username" type="text" id="username" hidden value="root">
                    <input name="password" type="text" id="password" hidden value="">
                    <input name="dbname" type="text" id="dbname" hidden value="creekside">
                    <div class="" style="text-align: center;">
                      <button type="submit" class="btn button" name="backupnow"><b>Create Backup</b></button>
                    </div>
                  </form>

            </div>
          </div>
    </section>

  </main><!-- End #main -->

<?php include 'includes/footer.php'; ?>

</body>

</html>