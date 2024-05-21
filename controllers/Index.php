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

    // Montly
    public function totalTransactionSales()
    {
        $currentMonth = date('m');
        $sql = "SELECT COUNT(*) AS totalSales FROM transactions WHERE (status = 'Paid' OR status = 'Completed') AND MONTH(delivery_date) = $currentMonth";
        $result = mysqli_query($this->con, $sql);
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            return $row['totalSales'];
        } else {
            return false;
        }
    }

    public function totalGrossSalesThisMonth()
    {
        $currentMonth = date('m');
        $sql = "SELECT SUM(total_price) AS totalGrossSales FROM transactions WHERE status = 'Paid' AND MONTH(delivery_date) = $currentMonth";
        $result = mysqli_query($this->con, $sql);
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $totalGrossSales = number_format($row['totalGrossSales'], 2);
            return $totalGrossSales;
        } else {
            return false;
        }
    }

    public function totalDishedSoldMonth()
    {
        $currentMonth = date('m');
        $sql = "SELECT COUNT(*) AS totalDishes FROM dishes_ordered LEFT JOIN transactions ON transactions.trans_id = dishes_ordered.trans_id WHERE (status = 'Paid' OR status = 'Completed') AND MONTH(delivery_date) = $currentMonth";
        $result = mysqli_query($this->con, $sql);
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            return $row['totalDishes'];
        } else {
            return false;
        }
    }

    // Weekly
    public function transactionsThisWeek()
    {
        $startOfWeek = date('Y-m-d', strtotime('monday this week'));
        $endOfWeek = date('Y-m-d', strtotime('sunday this week'));
        $sql = "SELECT * FROM transactions WHERE delivery_date BETWEEN '$startOfWeek' AND '$endOfWeek'";
        $result = mysqli_query($this->con, $sql);
        return $result;
    }

    public function topWeeklySellingDishes($limit = 5)
    {
        $sql = "SELECT dishes.dish_name, SUM(dishes_ordered.quantity) AS total_quantity FROM dishes_ordered JOIN dishes ON dishes_ordered.dish_id = dishes.dish_id JOIN transactions ON dishes_ordered.trans_id = transactions.trans_id WHERE transactions.status = 'Paid' OR transactions.status = 'Completed' GROUP BY WEEK(transactions.delivery_date) ORDER BY total_quantity DESC LIMIT $limit";
        $result = mysqli_query($this->con, $sql);
        if ($result) {
            $topSellingDishes = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $topSellingDishes[] = $row;
            }
            return $topSellingDishes;
        } else {
            return false;
        }
    }

    // Weekly
    public function totalTransactionSalesWeekly()
    {
        $startOfWeek = date('Y-m-d', strtotime('monday this week'));
        $endOfWeek = date('Y-m-d', strtotime('sunday this week'));
        $sql = "SELECT COUNT(*) AS totalSales FROM transactions WHERE (status = 'Paid' OR status = 'Completed') AND delivery_date BETWEEN '$startOfWeek' AND '$endOfWeek'";
        $result = mysqli_query($this->con, $sql);
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            return $row['totalSales'];
        } else {
            return false;
        }
    }

    public function totalGrossSalesThisWeek()
    {
        $startOfWeek = date('Y-m-d', strtotime('monday this week'));
        $endOfWeek = date('Y-m-d', strtotime('sunday this week'));
        $sql = "SELECT SUM(total_price) AS totalGrossSales FROM transactions WHERE status = 'Paid' AND delivery_date BETWEEN '$startOfWeek' AND '$endOfWeek'";
        $result = mysqli_query($this->con, $sql);
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $totalGrossSales = number_format($row['totalGrossSales'], 2);
            return $totalGrossSales;
        } else {
            return false;
        }
    }

    public function totalDishedSoldWeekly()
    {
        $startOfWeek = date('Y-m-d', strtotime('monday this week'));
        $endOfWeek = date('Y-m-d', strtotime('sunday this week'));
        $sql = "SELECT COUNT(*) AS totalDishes FROM dishes_ordered LEFT JOIN transactions ON transactions.trans_id = dishes_ordered.trans_id WHERE (status = 'Paid' OR status = 'Completed') AND delivery_date BETWEEN '$startOfWeek' AND '$endOfWeek'";
        $result = mysqli_query($this->con, $sql);
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            return $row['totalDishes'];
        } else {
            return false;
        }
    }

    // yearly
    public function totalTransactionSalesYearly()
    {
        $currentYear = date('Y');
        $sql = "SELECT COUNT(*) AS totalSales FROM transactions WHERE (status = 'Paid' OR status = 'Completed') AND YEAR(delivery_date) = $currentYear";
        $result = mysqli_query($this->con, $sql);
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            return $row['totalSales'];
        } else {
            return false;
        }
    }

    public function totalGrossSalesThisYear()
    {
        $currentYear = date('Y');
        $sql = "SELECT SUM(total_price) AS totalGrossSales FROM transactions WHERE status = 'Paid' AND YEAR(delivery_date) = $currentYear";
        $result = mysqli_query($this->con, $sql);
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $totalGrossSales = number_format($row['totalGrossSales'], 2);
            return $totalGrossSales;
        } else {
            return false;
        }
    }

    public function totalDishedSoldYearly()
    {
        $currentYear = date('Y');
        $sql = "SELECT COUNT(*) AS totalDishes FROM dishes_ordered LEFT JOIN transactions ON transactions.trans_id = dishes_ordered.trans_id WHERE (status = 'Paid' OR status = 'Completed') AND YEAR(delivery_date) = $currentYear";
        $result = mysqli_query($this->con, $sql);
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            return $row['totalDishes'];
        } else {
            return false;
        }
    }




    //Montly
    public function transactionsThisMonth()
    {
        $currentDate = date('Y-m-d');
        $startOfMonth = date('Y-m-01');
        $endOfMonth = date('Y-m-t');
        $sql = "SELECT * FROM transactions WHERE delivery_date BETWEEN '$startOfMonth' AND '$endOfMonth'";
        $result = mysqli_query($this->con, $sql);
        return $result;
    }

    public function topMonthlySellingDishes($limit = 5)
    {
        $sql = "SELECT dishes.dish_name, SUM(dishes_ordered.subtotal) AS total_sales
            FROM dishes_ordered
            JOIN dishes ON dishes_ordered.dish_id = dishes.dish_id
            JOIN transactions ON dishes_ordered.trans_id = transactions.trans_id
            WHERE transactions.status = 'Paid' OR transactions.status = 'Completed'
            GROUP BY YEAR(transactions.delivery_date), MONTH(transactions.delivery_date)
            ORDER BY total_sales DESC
            LIMIT $limit";
        $result = mysqli_query($this->con, $sql);
        if ($result) {
            $topSellingDishes = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $topSellingDishes[] = $row;
            }
            return $topSellingDishes;
        } else {
            return false;
        }
    }


    // Yearly
    public function transactionsThisYear()
    {
        $currentYear = date('Y');
        $startOfYear = date('Y-01-01');
        $endOfYear = date('Y-12-31');
        $sql = "SELECT * FROM transactions WHERE delivery_date BETWEEN '$startOfYear' AND '$endOfYear'";
        $result = mysqli_query($this->con, $sql);
        return $result;
    }

    public function topYearlySellingDishes($limit = 5)
    {
        $sql = "SELECT dishes.dish_name, SUM(dishes_ordered.quantity) AS total_quantity
            FROM dishes_ordered
            JOIN dishes ON dishes_ordered.dish_id = dishes.dish_id
            JOIN transactions ON dishes_ordered.trans_id = transactions.trans_id
            WHERE transactions.status = 'Paid' OR transactions.status = 'Completed'
            GROUP BY YEAR(transactions.delivery_date)
            ORDER BY total_quantity DESC
            LIMIT $limit";
        $result = mysqli_query($this->con, $sql);
        if ($result) {
            $topSellingDishes = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $topSellingDishes[] = $row;
            }
            return $topSellingDishes;
        } else {
            return false;
        }
    }

    // Delivery after 3 days
    public function forDelivery()
    {
        $today = date('Y-m-d');
        $threeDaysAfterToday = date('Y-m-d', strtotime('+3 days'));

        $sql = "SELECT COUNT(*) AS totalForDelivery FROM transactions
     WHERE status = 'Pending' AND delivery_method = 'For Delivery' AND delivery_date >= '$today' AND delivery_date <= '$threeDaysAfterToday'";
        $result = mysqli_query($this->con, $sql);
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            return $row['totalForDelivery'];
        } else {
            return "Test";
        }
    }




    public function forPickup()
    {
        $today = date('Y-m-d');
        $threeDaysAfterToday = date('Y-m-d', strtotime('+3 days'));

        $sql = "SELECT COUNT(*) AS totalForPickUp FROM transactions
     WHERE status = 'Pending' AND delivery_method = 'For Pickup' AND delivery_date >= '$today' AND delivery_date <= '$threeDaysAfterToday'";
        $result = mysqli_query($this->con, $sql);
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            return $row['totalForPickUp'];
        } else {
            return "Test";
        }
    }


    public function forDeliveryData()
    {
        $today = date('Y-m-d');
        $threeDaysAfterToday = date('Y-m-d', strtotime('+3 days'));

        $sql = "SELECT * FROM transactions 
    WHERE status = 'Pending' AND delivery_method = 'For Delivery' AND delivery_date >= '$today' AND delivery_date <= '$threeDaysAfterToday'
    LIMIT 3";
        $result = mysqli_query($this->con, $sql);
        return $result;
    }


    public function forPickUpData()
    {
        $today = date('Y-m-d');
        $threeDaysAfterToday = date('Y-m-d', strtotime('+3 days'));

        $sql = "SELECT * FROM transactions 
    WHERE status = 'Pending' AND delivery_method = 'For Pickup' AND delivery_date >= '$today' AND delivery_date <= '$threeDaysAfterToday'
    LIMIT 3";
        $result = mysqli_query($this->con, $sql);
        return $result;
    }
}
