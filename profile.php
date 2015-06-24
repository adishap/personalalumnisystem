<?php
require 'db_connect.php';
session_start();
ob_start();

echo $_SESSION['user_email'];

?>