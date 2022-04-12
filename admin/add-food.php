<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1> Add Food </h1>
        <br><br>

        <?php 
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']); 
            }
        ?>


        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" placeholder="Title of the food">
                    </td>
                </tr>
                <tr>
                    <td>Description:</td>
                    <td>
                        <textarea name="description" cols="30" rows="5" placeholder="Enter Description of the food"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price:</td>
                    <td>
                        <input type="number" name="price">
                    </td>
                </tr>
                <tr>
                    <td>Select Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Category:</td>
                    <td>
                        <select name="category">

                            <?php
                            // create sql to get all categories
                            $sql = "SELECT * FROM tbl_category WHERE active='Yes'";

                            // executing queries
                            $res = mysqli_query($conn, $sql);

                            // count rows to check whether we have categories
                            $count = mysqli_num_rows($res);

                            if($count>0)
                            {
                                while($row=mysqli_fetch_assoc($res))
                                {
                                    // get details of category
                                    $id = $row['id'];
                                    $title = $row['title'];
                                    ?>
                                    <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
                                    <?php
                                }
                            }
                            else
                            {
                                // No category message
                                ?>
                                <option value="0">No Category Found</option>
                                <?php
                            }

                            // display the dropdown
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Featured:</td>
                    <td>
                        <input type="radio" name="featured" value="Yes">Yes
                        <input type="radio" name="featured" value="No">No
                    </td>
                </tr>
                <tr>
                    <td>Active:</td>
                    <td>
                        <input type="radio" name="active" value="Yes">Yes
                        <input type="radio" name="active" value="No">No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php 

        // check whether the button is clicked or not
        if(isset($_POST['submit']))
        {
            // Get the data from FORM
            $title = $_POST['title'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category = $_POST['category'];

            // check whether radio button is clicked or not
            if(isset($_POST['featured']))
            {
                $featured = $_POST['featured'];
            }
            else
            {
                $featured = "No"; // Setting default
            }

            if(isset($_POST['active']))
            {
                $active = $_POST['active'];
            }
            else
            {
                $active = "No"; // Setting default
            }

            // Upload the image if selected
            // Check whether the select image is select or not
            if(isset($_FILES['image']['name']))
            {
                // get details of selected image
                $image_name = $_FILES['image']['name'];

                // check whether image is selected or not and upload only if selected
                if($image_name != "")
                {
                    // rename the image
                    $ext = end(explode('.', $image_name));

                    // create new name for image
                    $image_name = "Food-Name-".rand(0000, 9999).".".$ext;

                    // upload the image
                    // Get the source and destination path

                    $src = $_FILES['image']['tmp_name'];
                    $dst = "../images/food/".$image_name;

                    // finally upload image
                    $upload = move_uploaded_file($src, $dst);

                    // check whether image uploaded or not
                    if($upload == false)
                    {
                        // Redirect with Message and Stop the Process
                        $_SESSION['upload'] = "<div class='error'>Failed to Upload Image</div>";
                        header('location:'.SITEURL.'admin/add-food.php');
                        die();
                    }
                }
            }
            else
            {
                $image_name = ""; // Setting Deafult
            }

            // Insert into Database
            // Create a SQL query to add food
            $sql2 = "INSERT INTO tbl_food SET
                title = '$title',
                description = '$description',
                price = $price,
                image_name = '$image_name',
                category_id = '$category',
                featured = '$featured',
                active = '$active'
            ";

            // execute the query
            $res2 = mysqli_query($conn, $sql2);

            // Check whether data inserted or not
            if($res2 == TRUE)
            {
                $_SESSION['add'] = "<div class = 'success'>Food Added Successfully</div>";
                header('location:'.SITEURL.'admin/manage-food.php');
            }
            else
            {
                $_SESSION['add'] = "<div class = 'error'>Failed to Add Food</div>";
                header('location:'.SITEURL.'admin/manage-food.php');
            }

            // Redirect with message
        }
        else
        {

        }

        ?>


    </div>
    <br><br><br><br><br><br><br><br>
</div>

<?php include('partials/footer.php'); ?>