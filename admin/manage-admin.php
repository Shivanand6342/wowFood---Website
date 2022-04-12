<?php include('partials/menu.php'); ?>

    <!-- Main Content -->
    <div class="main-content">
    <div class="wrapper">
            <h1> Manage Admin </h1>
            <br><br>

            <?php
                if(isset($_SESSION['add']))
                {
                    echo $_SESSION['add']; //Displaying Session Message
                    unset($_SESSION['add']); //Removing Session Message
                }

                if(isset($_SESSION['delete']))
                {
                    echo $_SESSION['delete']; //Displaying Session Message
                    unset($_SESSION['delete']); //Removing Session Message
                }

                if(isset($_SESSION['update']))
                {
                    echo $_SESSION['update']; //Displaying Session Message
                    unset ($_SESSION['update']); //Removing Session Message
                }

                if(isset($_SESSION['user-not-found']))
                {
                    echo $_SESSION['user-not-found']; //Displaying Session Message
                    unset ($_SESSION['user-not-found']); //Removing Session Message
                }

                if(isset($_SESSION['pwd-not-match']))
                {
                    echo $_SESSION['pwd-not-match']; //Displaying Session Message
                    unset ($_SESSION['pwd-not-match']); //Removing Session Message
                }

                if(isset($_SESSION['change-pwd']))
                {
                    echo $_SESSION['change-pwd']; //Displaying Session Message
                    unset ($_SESSION['change-pwd']); //Removing Session Message
                }
            ?>
            <br>
            <br>

            <a href="add-admin.php" class="btn-primary"> Add Admin</a>
            <br>
            <br>
            <br>
            
            <table class="tbl-full">
                <tr>
                    <th> S.No. </th>
                    <th> Full Name </th>
                    <th> Username </th>
                    <th> Actions </th>
                </tr>

                <?php
                    // Query to get all admin
                    $sql = "SELECT * FROM tbl_admin";

                    // Executing the query
                    $res = mysqli_query($conn, $sql);

                    // Check whether the query executed or not
                    if($res==TRUE)
                    {
                        // Count rows to check whether we have database or not
                        $count = mysqli_num_rows($res); //Function to get all rows of databse
                        
                        $sn=1; //Create a variable 

                        if($count>0)
                        {
                            while($rows=mysqli_fetch_assoc($res))
                            {
                                // using while loop to get all data
                                $id=$rows['id'];
                                $full_name=$rows['full_name'];
                                $username=$rows['username'];

                                //Displaying data in Table
                                ?>
                                
                                <tr>
                                    <td> <?php echo $sn++; ?> </td>
                                    <td> <?php echo $full_name; ?> </td>
                                    <td> <?php echo $username; ?> </td>
                                    <td>
                                        <a href="<?php echo SITEURL; ?>admin/update-password.php?id=<?php echo $id; ?>" class="btn-primary">Change Password</a>
                                        <a href="<?php echo SITEURL; ?>admin/update-admin.php?id=<?php echo $id; ?>" class="btn-secondary"> Update Admin </a>
                                        <a href="<?php echo SITEURL; ?>admin/delete-admin.php?id=<?php echo $id; ?>" class="btn-danger"> Delete Admin </a>
                                    </td>
                                </tr>

                                <?php 

                            }
                        }
                        else
                        {
                            //  
                        }
                    }
                ?>
            </table>
        </div>
        <br><br><br><br><br><br>
        <br><br><br><br><br><br>
        <br><br><br><br>
    </div>
    <!-- Main Content Ends -->

<?php include('partials/footer.php'); ?>
