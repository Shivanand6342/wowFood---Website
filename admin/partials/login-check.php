<?php 

// Authorization - Access Control
// Check whether user is logged in or not

if(!isset($_SESSION['user'])) // if user session is not set
{
    // User is not logged in so redirect it to login page
    $_SESSION['no-login-message'] = "<div class='error text-center'> Please Login to Access Admin Panel </div>";
    header('location:'.SITEURL.'admin/login.php');
}

?>