<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1> Add category </h1>
        <br><br>

        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add']; //Displaying Message
            unset($_SESSION['add']); //Removing Message
        }
        ?>

        <?php
        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload']; //Displaying Message
            unset($_SESSION['upload']); //Removing Message
        }
        ?>

        <br><br>

        <!-- Add Category -->

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td> Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Enter Category Title">
                    </td>
                </tr>
                <tr>
                    <td> Select Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td> Featured: </td>
                    <td>
                        <input type="radio" name="featured" value="Yes">Yes
                        <input type="radio" name="featured" value="No">No
                    </td>
                </tr>
                <tr>
                    <td> Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes">Yes
                        <input type="radio" name="active" value="No">No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <!-- Add Category Ends -->

        <?php

        // Check whether submit button is clicked or not
        if (isset($_POST['submit'])) {
            // Get the value from FORM
            $title = $_POST['title'];

            // For radio input type, we will check button is checked or not
            if (isset($_POST['featured'])) {
                $featured = $_POST['featured'];
            } else {
                // Default Value
                $featured = "No";
            }

            if (isset($_POST['active'])) {
                $active = $_POST['active'];
            } else {
                // Default Value
                $active = "No";
            }

            // Check whether image is selected or not
            // print_r($_FILES['image']);
            // die();

            if (isset($_FILES['image']['name'])) {
                // To upload image, we need source path and dest path
                $image_name = $_FILES['image']['name'];

                // Upload the image only if image is selected
                if ($image_name != "") 
                {
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
                        header('location:' . SITEURL . 'admin/add-category.php');
                        // Stop the Image
                        die();
                    }
                }
            } else {
                $image_name = "";
            }

            // Create SQL query to insert category into database
            $sql = "INSERT INTO tbl_category SET
                title='$title',
                image_name='$image_name',
                featured='$featured',
                active='$active'
            ";

            // Execute the query and save in database
            $res = mysqli_query($conn, $sql);

            // Check whether query executed or not
            if ($res == TRUE) {
                $_SESSION['add'] = "<div class='success'>Category Added Successfully</div>";
                // Redirect to Manage Category Page
                header('location:' . SITEURL . 'admin/manage-category.php');
            } else {
                $_SESSION['add'] = "<div class='error'>Failed to Add Category</div>";
                // Redirect to Manage Category Page
                header('location:' . SITEURL . 'admin/add-category.php');
            }
        }

        ?>



    </div>
    <br><br><br><br><br>
    <br><br><br><br><br>
    <br><br><br><br><br>
    <br>
</div>


<?php include('partials/footer.php'); ?>