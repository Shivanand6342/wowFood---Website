<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1> Manage Category </h1>
        <br> <br>

        <?php 
            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add']; //Displaying Message
                unset($_SESSION['add']); //Removing Message
            }
            if(isset($_SESSION['remove']))
            {
                echo $_SESSION['remove']; //Displaying Message
                unset($_SESSION['remove']); //Removing Message
            }
            if(isset($_SESSION['delete']))
            {
                echo $_SESSION['delete']; //Displaying Message
                unset($_SESSION['delete']); //Removing Message
            }
            if(isset($_SESSION['no-category-found']))
            {
                echo $_SESSION['no-category-found']; //Displaying Message
                unset($_SESSION['no-category-found']); //Removing Message
            }
            if(isset($_SESSION['update']))
            {
                echo $_SESSION['update']; //Displaying Message
                unset($_SESSION['update']); //Removing Message
            }
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload']; //Displaying Message
                unset($_SESSION['upload']); //Removing Message
            }
            if(isset($_SESSION['failed-remove']))
            {
                echo $_SESSION['failed-remove']; //Displaying Message
                unset($_SESSION['failed-remove']); //Removing Message
            }
        ?>
        <br><br>


            <a href="<?php echo SITEURL; ?>admin/add-category.php" class="btn-primary"> Add Category</a>
            <br>
            <br>
            <br>
            
            <table class="tbl-full">
                <tr>
                    <th> S.No. </th>
                    <th> Title </th>
                    <th> Image </th>
                    <th> Featured </th>
                    <th> Active </th>
                    <th> Actions </th>
                </tr>

                <?php 

                // Query to get all categoies from database
                $sql = "SELECT * FROM tbl_category";
                
                // Execute Queries
                $res = mysqli_query($conn, $sql);

                // Count Rows
                $count = mysqli_num_rows($res);

                // create s.no. variable
                $sn=1;

                // Check whether we have data in database or not
                if($count>0)
                {
                    // Get data and display
                    while($row=mysqli_fetch_assoc($res))
                    {
                        $id = $row['id'];
                        $title = $row['title'];
                        $image_name = $row['image_name'];
                        $featured = $row['featured'];
                        $active = $row['active'];

                        ?>
                        <tr>
                            <td> <?php echo $sn++; ?>. </td>
                            <td> <?php echo $title; ?></td>

                            <td> 
                                <?php

                                // Check whether image_name is available or not
                                if($image_name!="")
                                {
                                    ?>
                                    <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" width="100px">
                                    <?php
                                }
                                else
                                {
                                    echo "<div class='error'>Image Not Added</div>";
                                }

                                ?>
                            </td>

                            <td> <?php echo $featured; ?></td>
                            <td> <?php echo $active; ?></td>
                            <td> 
                                <a href="<?php echo SITEURL; ?>admin/update-category.php?id=<?php echo $id; ?>" class="btn-secondary"> Update Category </a>
                                <a href="<?php echo SITEURL; ?>admin/delete-category.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger"> Delete Category </a>
                            </td>
                        </tr>
                        <?php
                    }
                }
                else
                {
                    // We'll display the message inside table
                    ?>
                    <tr>
                        <td colspan="6"><div class="error">No Category Added</div></td>
                    </tr>
                    <?php
                }


                ?>
            </table>
    </div>
</div>

<?php include('partials/footer.php'); ?>