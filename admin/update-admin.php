<?php include('partials/menu.php'); ?>


<div class="main-content">
    <div class="wrapper">
        <h1> Update Admin </h1>
        <br><br>

        <?php 

            // Get the id of selected admin
            $id=$_GET['id'];

            // Create Sql query
            $sql="SELECT * FROM tbl_admin WHERE id=$id";

            // Execute the Query
            $res=mysqli_query($conn, $sql);

            // Check whether the query execute or not
            if($res==TRUE)
            {
                // Check whether data is available or not
                $count = mysqli_num_rows($res);

                // Check whether we have admin data or not
                if($count==1)
                {
                    // Get the details
                    $row=mysqli_fetch_assoc($res);

                    $full_name = $row['full_name'];
                    $username = $row['username'];
                }
                else
                {   
                    header('location:'.SITEURL.'admin/manage-admin.php');
                }

            }
            

        ?>  

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td> Full Name: </td>
                    <td>
                        <input type="text" name="full_name" value="<?php echo $full_name; ?>">
                    </td>
                </tr>
                <tr>
                    <td> Username: </td>
                    <td>
                        <input type="text" name="username" value="<?php echo $username; ?>">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Admin" class="btn-secondary">    
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php 

// Check whether the button is clicked or not
if(isset($_POST['submit']))
{
    // Get all the values from FORM to update
    $id = $_POST['id'];
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];

    // create a SQL query to update admin
    $sql = "UPDATE tbl_admin SET
    full_name = '$full_name',
    username = '$username'
    WHERE id = '$id'
    ";

    // Execute the Query
    $res = mysqli_query($conn, $sql);

    // Check whether query executed or not
    if($res==TRUE)
    {
        // Query Executed and Admin Update
        $_SESSION['update'] = "<div class='success'>Admin Update Successfully </div>";
        
        // Redirecting to Manage Admin Page
        header('location:'.SITEURL.'admin/manage-admin.php');
    }
    else
    {
        // Query Executed and Admin Update
        $_SESSION['update'] = "<div class='error'>Failed to Update Admin </div>";
        
        // Redirecting to Manage Admin Page
        header('location:'.SITEURL.'admin/manage-admin.php');
    }
}

?>

<?php include('partials/footer.php'); ?>