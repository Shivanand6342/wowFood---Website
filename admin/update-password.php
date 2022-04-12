<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1> Change Password </h1>
        <br><br>
        
        <?php 
        
        if(isset($_GET['id']))
        {
            $id=$_GET['id'];
        }

        ?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td> Curernt Password: </td>
                    <td>
                        <input type="password" name="current_password" placeholder="Current Password"> 
                    </td>
                </tr>
                <tr>
                    <td> New Password: </td>
                    <td>
                        <input type="password" name="new_password" placeholder="New Password">
                    </td>
                </tr>
                <tr>
                    <td> Confirm Password: </td>
                    <td>
                        <input type="password" name="confirm_password" placeholder="Confirm Password">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Change Password" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php 

// Check whether the submit button is clicked or not
if(isset($_POST['submit']))
{
    // Get the data from FORM
    $id=$_POST['id'];
    $current_password = md5($_POST['current_password']);
    $new_password = md5($_POST['new_password']);
    $confirm_password = md5($_POST['confirm_password']);

    // Check whether the user with current id and password exists or not
    $sql = "SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";

    // Execute the query
    $res = mysqli_query($conn, $sql);

    if($res==TRUE)
    {
        // Check whether data is available or not
        $count=mysqli_num_rows($res);
        if($count==1)
        {   
            // check whether the new password and confirm password matches or not
            if($new_password == $confirm_password)
            {
                // Update the password
                // $current_password = $new_password
                $sql2 = "UPDATE tbl_admin SET
                    password='$new_password'
                    WHERE id=$id;
                ";

                // Execute the query
                $res2 = mysqli_query($conn, $sql2);

                // Check whether the query executed or not
                if($res==TRUE)
                {
                    // Redirect to manage admin with error message
                    $_SESSION['change-pwd'] = "<div class='success'> Password Changed Successfully </div>";

                    // Redirecting to manage admin
                    header('location:'.SITEURL.'admin/manage-admin.php');
                }
                else
                {
                    // Redirect to manage admin with error message
                    $_SESSION['change-pwd'] = "<div class='error'> Failed to Change Password </div>";

                    // Redirecting to manage admin
                    header('location:'.SITEURL.'admin/manage-admin.php');
                }
            }
            else
            {
                // Redirect to manage admin with error message
                $_SESSION['pwd-not-match'] = "<div class='error'> Password Not Matched </div>";

                // Redirecting to manage admin
                header('location:'.SITEURL.'admin/manage-admin.php');
            }
        }
        else
        {
            // if user does not exist
            $_SESSION['user-not-found'] = "<div class='error'> User Not Found </div>";

            // Redirecting to manage admin
            header('location:'.SITEURL.'admin/manage-admin.php');
        }
    }
}

?>

<?php include('partials/footer.php'); ?>