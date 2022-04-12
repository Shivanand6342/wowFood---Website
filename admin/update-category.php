<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1> Update Catagory </h1>
        <br><br>

        <?php
        
        // check whether id is set or not
        if(isset($_GET['id']))
        {
            // get the id and all other details
            $id = $_GET['id'];

            // create SQL query to get all other details
            $sql = "SELECT * FROM tbl_category WHERE id=$id";

            // Executing Query
            $res = mysqli_query($conn, $sql);

            // Count the rows to check whether the id is valid or not
            $count = mysqli_num_rows(($res));

            if($count == 1)
            {
                $row = mysqli_fetch_assoc($res);
                $title = $row['title'];
                $current_image = $row['image_name'];
                $featured = $row['featured'];
                $active = $row['active'];
            }
            else
            {
                // redirect to manage category with message
                $_SESSION['no-category-found'] = "<div class='error'>Category not Found</div>";
                header('location:'.SITEURL.'admin/manage-category.php');
            }

        }
        else
        {
            // redirect to Manage Category
            header('location:'.SITEURL.'admin/manage-category.php');
        }

        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Current Image:</td>
                    <td>
                        <?php
                        if($current_image != "")
                        {
                            ?>
                            <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?>" width="150px">
                            <?php
                        }
                        else
                        {
                            echo "<div class='error'>Image not Added</div>";
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>New Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Featured:</td>
                    <td>
                        <input <?php if($featured=="Yes"){echo "checked";} ?> type="radio" name="featured" value="Yes">Yes
                        <input <?php if($featured=="No"){echo "checked";} ?> type="radio" name="featured" value="No">No
                    </td>
                </tr>
                <tr>
                    <td>Active:</td>
                    <td>
                        <input <?php if($active=="Yes"){echo "checked";} ?> type="radio" name="active" value="Yes">Yes
                        <input <?php if($active=="No"){echo "checked";} ?> type="radio" name="active" value="No">No
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Category" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php

        if(isset($_POST['submit']))
        {
            // Get all the values from our FORM
            $id = $_POST['id'];
            $title = $_POST['title'];
            $current_image = $_POST['current_image'];
            $featured = $_POST['featured'];
            $active = $_POST['active'];

            // Updating New Image
            // check whether the image is selected or not
            if(isset($_FILES['image']['name']))
            {
                // get the image details
                $image_name = $_FILES['image']['name'];

                // Check whether image is available or not
                if($image_name != "")
                {
                    // upload the new image
                    // auto rename our image
                    // get the extension of the image (.jpg, .png, etc)
                    $ext = end(explode('.', $image_name));

                    // Rename the image
                    $image_name = "Food_Category_" . rand(000, 999) . '.' . $ext;

                    $source_path = $_FILES['image']['tmp_name'];

                    $destination_path = "../images/category/" . $image_name;

                    // Upload the image
                    $upload = move_uploaded_file($source_path, $destination_path);

                    // Check if image is uploaded or not and if not stop it and show error message
                    if ($upload == false) {
                        $_SESSION['upload'] = "<div class='error'>Failed to Upload Image</div>";
                        // Redirect to Add Category Page
                        header('location:'.SITEURL.'admin/manage-category.php');
                        // Stop the Image
                        die();
                    }
                    
                    // remove the current image if available
                    if($current_image != "")
                    {
                        $remove_path = "../images/category/".$current_image;
                        $remove = unlink($remove_path);
    
                        // check whether the image is removed or not, if failed to remove display message and stop
                        if($remove==false)
                        {
                            $_SESSION['failed-remove'] = "<div class='error'>Failed to Remove Current Image</div>";
                            header('location:'.SITEURL.'admin/manage-category.php');
                            die();
                        }
                    }
                }
                else
                {
                    $image_name = $current_image;
                }
            }
            else
            {
                $image_name = $current_image;
            }

            // Update the database
            $sql2 = "UPDATE tbl_category SET
                title = '$title',
                image_name = '$image_name',
                featured = '$featured',
                active = '$active'
                WHERE id=$id
            ";

            // execute the query
            $res2 = mysqli_query($conn, $sql2);

            // Redirect to manage Category with message
            // check whether query executed or not
            if($res2==TRUE)
            {
                $_SESSION['update'] = "<div class='success'>Category Updated Successfully</div>";
                header('location:'.SITEURL.'admin/manage-category.php');
            }
            else
            {
                $_SESSION['update'] = "<div class='error'>Failed to Update Category</div>";
                header('location:'.SITEURL.'admin/manage-category.php');
            }
        }

        ?>

    </div>
</div>


<?php include('partials/footer.php'); ?>