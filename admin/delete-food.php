<?php

include('../config/constants.php');

// check whether value is passed or not
if(isset($_GET['id']) AND isset($_GET['image_name']))
{
    // get id and image name
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];

    // remove the image if available
    if($image_name != "")
    {
        // get image path
        $path = "../images/food/".$image_name;

        // remove image file from folder
        $remove = unlink($path);

        // check whether the image is removed or not
        if($remove==FALSE)
        {
            $_SESSION['upload'] = "<div class='error'>Failed to Remove Image File</div>";
            // redirecting to manage food
            header('location:'.SITEURL.'admin/manage-food.php');
            // stop the process of deleting food
            die();
        }
    }

    // delete food from database
    $sql = "DELETE FROM tbl_food WHERE id=$id";

    // execute the query
    $res = mysqli_query($conn, $sql);

    // check whether query executed or not and 
    // redirect to manage food with message
    if($res==TRUE)
    {
        $_SESSION['delete'] = "<div class='success'>Food Deleted Successfully</div>";
        header('location:'.SITEURL.'admin/manage-food.php');
    }
    else
    {
        $_SESSION['delete'] = "<div class='error'>Failed to Delete Food</div>";
        header('location:'.SITEURL.'admin/manage-food.php');
    }
}
else
{
    // redirect to manage food with message
    $_SESSION['unauthorize'] = "<div class='error'>Unauthorized Access</div>";
    header('location:'.SITEURL.'admin/manage-food.php');
}


?>