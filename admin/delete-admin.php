<?php 

    include('../config/constants.php');

    // Get the id of admin to be deleted
    $id = $_GET['id'];

    // Create SQL query to delete admin
    $sql = "DELETE FROM tbl_admin WHERE id=$id";

    //Execute the query
    $res = mysqli_query($conn, $sql);

    //Check whether query executed or not
    if($res==true)
    {
        // echo "Admin Deleted";
        // Create session variable to display message
        $_SESSION['delete'] = " <div class='success'> Admin Deleted Successfully. </div>";

        //Redirecting to Manage Admin Page
        header('location:'.SITEURL.'admin/manage-admin.php');
    }
    else
    {
        //Failed to Delete Admin
        $_SESSION['delete'] = "<div class='error'> Failed to Delete Admin. </div>";
        header('location:'.SITEURL.'admin/manage-admin.php');
    }
    // Redirection to manage admin with message

?>