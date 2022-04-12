<?php include('partials/menu.php');?>

<?php 
// check whether id is set or not
if(isset($_GET['id']))
{
    // get all the details
    $id = $_GET['id'];

    // sql query to get the selected food
    $sql2 = "SELECT * FROM tbl_food WHERE id=$id";

    // execute the query
    $res2 = mysqli_query($conn, $sql2);

    // get the value based on query executed
    $row2 = mysqli_fetch_assoc($res2);

    // get the individual value of selected food
    $title = $row2['title'];
    $description = $row2['description'];
    $price = $row2['price'];
    $current_image = $row2['image_name'];
    $current_category = $row2['category_id'];
    $featured = $row2['featured'];
    $active = $row2['active'];
}
else
{
    header('location:'.SITEURL.'admin/manage-food.php');
}
?>

<div class="main-content">
    <div class="wrapper">
        <h1> Update Food </h1>
        <br><br>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Description:</td>
                    <td>
                        <textarea name="description" cols="30" rows="5"><?php echo $description; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price:</td>
                    <td>
                        <input type="number" name="price" value="<?php echo $price; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Current Image:</td>
                    <td>
                        <!-- Display image if available -->
                        <?php 
                        if($current_image == "")
                        {
                            echo "<div class='error'>Image not Available</div>";
                        }
                        else
                        {
                            ?>
                            <img src="<?php echo SITEURL; ?>/images/food/<?php echo $current_image; ?>" width="150px">
                            <?php
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
                    <td>Category:</td>
                    <td>
                        <select name="category">

                        <?php
                        
                        // query to get active categories
                        $sql = "SELECT * FROM tbl_category WHERE active='Yes'";

                        // execute the queries
                        $res = mysqli_query($conn, $sql);

                        // count rows
                        $count = mysqli_num_rows($res);

                        // check whether category available or not
                        if($count>0)
                        {
                            while($row=mysqli_fetch_assoc($res)) 
                            {
                                $category_title = $row['title'];
                                $category_id = $row['id'];
                                ?>
                                
                                <option <?php if($current_category == $category_id) {echo "selected";} ?> value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>

                                <?php
                            }
                        }
                        else
                        {
                            echo "<option value='0'>Category Not Available</option>";
                        }

                        ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Featured:</td>
                    <td>
                        <input <?php if($featured=="Yes") {echo "checked";} ?> type="radio" name="featured" value="Yes">Yes
                        <input <?php if($featured=="No") {echo "checked";} ?> type="radio" name="featured" value="No">No
                    </td>
                </tr>
                <tr>
                    <td>Active:</td>
                    <td>
                        <input <?php if($active=="Yes") {echo "checked";} ?> type="radio" name="active" value="Yes">Yes
                        <input <?php if($active=="No") {echo "checked";} ?> type="radio" name="active" value="No">No
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php 
        
        if(isset($_POST['submit']))
        {
            // Get all the details from FORM
            $id = $_POST['id'];
            $title = $_POST['title'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $current_image = $_POST['current_image'];
            $category = $_POST['category'];
            $featured = $_POST['$featured'];
            $active = $_POST['active'];

            // Upload the image if selected
            // check whether upload button is clicked or not
            if(isset($_FILES['image']['name']))
            {
                $image_name = $_FILES['image']['name'];

                // check whether files is available or not
                if($image_name != "")
                {
                    // rename the image
                    $ext = end(explode('.', $image_name));
                    $image_name = "Food-Name-".rand(0000, 9999).'.'.$ext;

                    // get the source path and des path
                    $src_path = $_FILES['image']['tmp_name'];
                    $dest_path = "../images/food/".$image_name;

                    // upload the image
                    $upload = move_uploaded_file($src_path, $dest_path);

                    // check whether image uploaded or not
                    if($upload==false)
                    {
                        $_SESSION['upload'] = "<div class='error'>Failed to Upload New Image</div>";
                        header('location:'.SITEURL.'admin/manage-food.php');
                        die();
                    }

                    // Remove current image if available
                    if($current_image != "")
                    {
                        // remove the image
                        $remove_path = "../images/food/".$current_image;

                        $remove = unlink($remove_path);

                        // check whether image is removed or not
                        if($remove==false)
                        {
                            // $_SESSION['remove-failed'] = "<div class='error'>Failed to Remove Current Image</div>";
                            header('location:'.SITEURL.'admin/manage-food.php');
                            die();
                        }

                    }
                }
                else
                {
                    $image_name = $current_image; //Deafult image when image is not selected
                }
            }
            else
            {
                $image_name = $current_image; //Deafult image when button is not clicked
            }

            // Update the Food in database
            $sql3 = "UPDATE tbl_food SET 
                title = '$title',
                description = '$description',
                price = $price,
                image_name = '$image_name',
                category_id = '$category',
                featured = '$featured',
                active = '$active'
                WHERE id=$id
            ";

        // execute the SQL query
        $res3 = mysqli_query($conn, $sql3);

        // Check whether query executed or not
        if($res3==true)
        {
            // Query executed and food updated
            $_SESSION['update'] = "<div class='success'>Food Updated Successfully</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }
        else
        {
            $_SESSION['update'] = "<div class='error'>Failed to Update Food</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }
        }

        ?>


    </div>
</div>

<?php include('partials/footer.php');?>