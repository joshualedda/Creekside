<?php
include "controllers/Index.php";
$db = new db;
$conn = $db->con;
error_reporting(E_ALL);
ini_set('display_errors', 1);

$con = $db->con;

if (isset($_POST['backup'])) {
    $tables = array();
    $sql = "SHOW TABLES";
    $result = mysqli_query($con, $sql);
    while ($row = mysqli_fetch_row($result)) {
        $tables[] = $row[0];
    }
    $sqlScript = "";
    foreach ($tables as $table) {
        $query = "SHOW CREATE TABLE $table";
        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_row($result);
        $sqlScript .= "\n\n" . $row[1] . ";\n\n";
        $query = "SELECT * FROM $table";
        $result = mysqli_query($con, $query);
        $columnCount = mysqli_num_fields($result);
        for ($i = 0; $i < $columnCount; $i++) {
            while ($row = mysqli_fetch_row($result)) {
                $sqlScript .= "INSERT INTO $table VALUES(";
                for ($j = 0; $j < $columnCount; $j++) {
                    $row[$j] = $row[$j];
                    if (isset($row[$j])) {
                        $sqlScript .= '"' . mysqli_real_escape_string($con, $row[$j]) . '"';
                    } else {
                        $sqlScript .= '""';
                    }
                    if ($j < ($columnCount - 1)) {
                        $sqlScript .= ',';
                    }
                }
                $sqlScript .= ");\n";
            }
        }
        $sqlScript .= "\n";
    }
    if (!empty($sqlScript)) {
        $backup_file_name = __DIR__ . '/backup/file/_backup_.sql'; 
        $fileHandler = fopen($backup_file_name, 'w+');
        $number_of_lines = fwrite($fileHandler, $sqlScript);
        fclose($fileHandler);
        $message = "Backup Created Successfully";
    }
}

if (isset($_POST['restore'])) {
    $sql = '';
    $error = '';
    if (file_exists(__DIR__ . '/backup/file/_backup_.sql')) { // Updated path
        // Deleting starts here
        $query_disable_checks = 'SET foreign_key_checks = 0';
        mysqli_query($con, $query_disable_checks);
        $show_query = 'Show tables';
        $query_result = mysqli_query($con, $show_query);
        $row = mysqli_fetch_array($query_result);
        while ($row) {
            $query = 'DROP TABLE IF EXISTS ' . $row[0];
            $query_result = mysqli_query($con, $query);
            $show_query = 'Show tables';
            $query_result = mysqli_query($con, $show_query);
            $row = mysqli_fetch_array($query_result);
        }
        $query_enable_checks = 'SET foreign_key_checks = 1';
        mysqli_query($con, $query_enable_checks);
        // Deleting ends here
        $lines = file(__DIR__ . '/backup/file/_backup_.sql'); // Updated path
        foreach ($lines as $line) {
            if (substr($line, 0, 2) == '--' || $line == '') {
                continue;
            }
            $sql .= $line;
            if (substr(trim($line), -1, 1) == ';') {
                $result = mysqli_query($con, $sql);
                if (!$result) {
                    $error .= mysqli_error($con) . "\n";
                }
                $sql = '';
            }
        }
        if ($error) {
            $message1 = $error;
        } else {
            $message1 = "Database restored successfully";
        }
    } else {
        $messageRed = "No backup file found from the backup.";
    }
}
?>


<?php
  include 'includes/links.php';
  include 'includes/header.php';
  include 'includes/sidebar.php';
  ?>
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Back Up</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../admin/dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item">Back Up</li>
            </ol>
        </nav>
    </div>

    <div class="row">

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Back Up Database</h5>

                    <?php if (@$message) : ?>
                        <div class="alert alert-success" id="alert1">

                            <?php echo $message; ?>
                        </div>
                    <?php endif; ?>
                    <form method="POST" class="blogdesire-form">

                        <p>
                            Creating regular backups of your database is crucial for data integrity and system recovery.
                            In case of unexpected events or data loss, having a recent backup ensures that you can
                            restore your system to a known, stable state. Please follow the steps below to perform a
                            system backup:
                        </p>
                        <p>

                            <li>Click the "Perform System Backup" button below.</li>
                            <li>Wait for the backup process to complete.</li>
                            <li>A notification will be show once complete.</li>
                        </p>


                        <div class="d-flex justify-content-end mx-2 ">

                            <button name="backup" class="btn2 btn-md mx-2">
                                Backup
                            </button>

                        </div>


                    </form>

                </div>
            </div>
        </div>


        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Restore Database</h5>

                    <?php if (@$message1) : ?>
                        <div class="alert alert-success" id="alert4">

                            <?php echo $message1; ?>
                        </div>
                    <?php endif; ?>
                    <?php if (@$messageRed) : ?>
                        <div class="alert alert-warning" id="alert4">

                            <?php echo $messageRed; ?>
                        </div>
                    <?php endif; ?>
                    <form method="POST" class="blogdesire-form">

                        <p>
                            Restoring your database is essential for system recovery and maintaining data integrity.
                            In the event of unexpected issues or data loss, a recent backup allows you to restore your system to a known,
                            stable state. Follow the steps below to perform a database restore:
                        </p>

                        <ul>
                            <li>Restore the database to a previous state.</li>
                            <li>Undo any changes made after the backup date.</li>
                            <li>Data added or modified after the backup will be lost.</li>
                        </ul>




                        <div class="d-flex justify-content-end mx-2 ">
                            <button type="button" class="btn2 btn-md mx-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                Restore
                            </button>

                        </div>


                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Restore Data</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want restore?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn2 btn-md mx-2" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" name="restore" class="btn2 btn-md mx-2">Confirm</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>



</main>

<script>
    // Add this script to automatically remove the alert after 4 seconds
    $(document).ready(function() {
        setTimeout(function() {
            $("#alert4").alert('close');
        }, 4000);
    });
</script>
<?php include 'includes/footer.php'; ?>
