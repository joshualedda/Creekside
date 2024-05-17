<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

class db
{
    public $con;

    public function __construct()
    {
        $this->con = mysqli_connect('localhost', 'root', '', 'creekside') or die(mysqli_error($this->con));
    }

    public function totalSales()
    {
        // Get the current month
        $currentMonth = date('m');
    
        // Construct the SQL query to count transactions from the current month with status 'Paid' or 'Completed'
        $sql = "SELECT COUNT(*) AS totalSales FROM transactions WHERE
         (status = 'Paid' OR status = 'Completed') AND MONTH(delivery_date) = $currentMonth";
        
        // Execute the query
        $result = mysqli_query($this->con, $sql);
    
        // Check if the query was successful
        if ($result) {
            // Fetch the result as an associative array
            $row = mysqli_fetch_assoc($result);
            // Return the total sales count
            return $row['totalSales'];
        } else {
            // Return false if there was an error executing the query
            return false;
        }
    }
    
    
    public function totalGrossSalesThisMonth()
    {
        // Get the current month
        $currentMonth = date('m');
    
        // Construct the SQL query to sum total_price from transactions for the current month with status 'Paid'
        $sql = "SELECT SUM(total_price) AS totalGrossSales
        FROM transactions WHERE status = 'Paid' AND MONTH(delivery_date) = $currentMonth";
    
        // Execute the query
        $result = mysqli_query($this->con, $sql);
    
        // Check if the query was successful
        if ($result) {
            // Fetch the result as an associative array
            $row = mysqli_fetch_assoc($result);
            // Format the total gross sales to have 2 decimal places
            $totalGrossSales = number_format($row['totalGrossSales'], 2);
            // Return the total gross sales
            return $totalGrossSales;
        } else {
            // Return false if there was an error executing the query
            return false;
        }
    }


    public function totalDishedSold()
    {
        // Get the current month
        $currentMonth = date('m');
    
        // Construct the SQL query to count dishes ordered from the current month with status 'Paid' or 'Completed'
        $sql = "SELECT COUNT(*) AS totalDishes FROM dishes_ordered 
                LEFT JOIN transactions ON transactions.trans_id = dishes_ordered.trans_id
                WHERE (status = 'Paid' OR status = 'Completed') AND MONTH(delivery_date) = $currentMonth";
    
        // Execute the query
        $result = mysqli_query($this->con, $sql);
    
        // Check if the query was successful
        if ($result) {
            // Fetch the result as an associative array
            $row = mysqli_fetch_assoc($result);
            // Return the total dishes count
            return $row['totalDishes'];
        } else {
            // Return false if there was an error executing the query
            return false;
        }
    }
    

    // fethe transations this week
    public function transactionsThisWeek()
{
    // Get the current date
    $currentDate = date('Y-m-d');

    // Calculate the start date of the current week (assuming the week starts on Monday)
    $startOfWeek = date('Y-m-d', strtotime('monday this week'));

    // Calculate the end date of the current week (assuming the week ends on Sunday)
    $endOfWeek = date('Y-m-d', strtotime('sunday this week'));

    // Construct the SQL query to fetch transactions for the current week
    $sql = "SELECT * FROM transactions WHERE delivery_date BETWEEN '$startOfWeek' AND '$endOfWeek'";

    // Execute the query
    $result = mysqli_query($this->con, $sql);

    // Return the result set
    return $result;
}


public function topSellingDishes($limit = 5)
{
    // Construct the SQL query to get the top selling dishes
    $sql = "SELECT dishes.dish_name, SUM(dishes_ordered.quantity) AS total_quantity
            FROM dishes_ordered
            JOIN dishes ON dishes_ordered.dish_id = dishes.dish_id
            JOIN transactions ON dishes_ordered.trans_id = transactions.trans_id
            WHERE transactions.status = 'Paid' OR transactions.status = 'Completed'
            GROUP BY dishes_ordered.dish_id
            ORDER BY total_quantity DESC
            LIMIT $limit";

    // Execute the query
    $result = mysqli_query($this->con, $sql);

    // Check if the query was successful
    if ($result) {
        // Fetch the result as an associative array
        $topSellingDishes = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $topSellingDishes[] = $row;
        }
        // Return the top selling dishes
        return $topSellingDishes;
    } else {
        // Return false if there was an error executing the query
        return false;
    }
}

    
   
}
?>
