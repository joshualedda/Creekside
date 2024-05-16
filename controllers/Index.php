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
}
?>
