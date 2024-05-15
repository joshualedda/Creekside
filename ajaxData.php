<?php 
// Include the database config file 
include_once 'connection.php';

 if(isset($_POST['provinceId']) && !empty($_POST["provinceId"])){ 
    // Fetch city data based on the specific state 
    $query = "SELECT * FROM municipality WHERE provCode = ".$_POST['provinceId']; 
    $result = $con->query($query); 
     
    // Generate HTML of city options list 
    if($result->num_rows > 0){ 
        echo '<option value="" selected disabled>Select City/Municipality</option>'; 
        while($row = $result->fetch_assoc()){  
            echo '<option value="'.$row['citymunCode'].'">'.$row['citymunDesc'].'</option>'; 
        } 
    }else{ 
        echo '<option value="" selected disabled>Select City/municipality</option>';
        echo '<option value="allLGU">ALL CITY/MUNICIPALITY</option>'; 
    } 
}else if(isset($_POST['cityId']) && !empty($_POST["cityId"])){ 
    // Fetch city data based on the specific state 
    $query = "SELECT * FROM barangay WHERE citymunCode = ".$_POST['cityId']; 
    $result = $con->query($query); 
     
    // Generate HTML of city options list 
    if($result->num_rows > 0){ 
        echo '<option value="" selected disabled>Select Barangay</option>'; 
        while($row = $result->fetch_assoc()){  
            echo '<option value="'.$row['brgyDesc'].'">'.$row['brgyDesc'].'</option>'; 
        } 
    }else{ 
        echo '<option value="">Barangay not available</option>'; 
    }
}
?>