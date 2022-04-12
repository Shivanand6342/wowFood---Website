<?php
// Include Constants Files
include('../config/constants.php');

// check whether the id and image_name value is set or not
if(isset($_GET['id']) AND isset($_GET['image_name']))
{
    // get the calue and delete it
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];

    // remove the physical image file is available
    if($image_name != "")
    {
        $path = "../images/category/".$image_name;
        // to remove the image
        $remove = unlink($path);

        // if failed to remove then error message and stop the process
        if($remove==false)
        {
            // Set the session Manage
            $_SESSION['remove'] = "<div class='error'>Failed to Remove Category Image </div>";
            // Redirect to Manage Category Page
            header('location:'.SITEURL.'admin/manage-category.php');
            // Stop the Process
            die();
        }
    }
    // Delete data from database
    $sql = "DELETE FROM tbl_category WHERE id=$id";

    // Execute the Query
    $res = mysqli_query($conn, $sql);

    // Check whether the data is deleted from database or not
    if($res==TRUE)
    {
        $_SESSION['delete'] = "<div class='success'> Category Deleted Successfully </div>";
        // Redirect to Manage Category
        header('location:'.SITEURL.'admin/manage-category.php'); 
    }
    else
    {
        $_SESSION['delete'] = "<div class='error'>Failed to Delete Category</div>";
        // Redirect to Manage Category
        header('location:'.SITEURL.'admin/manage-category.php'); 
    }
}
else
{
    // Redirect to Manage Category Page
    header('location:'.SITEURL.'admin/manage-category.php');
}


?>