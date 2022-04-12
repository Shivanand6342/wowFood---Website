<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1> Add Admin </h1>
        <br><br>

        <?php
            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add']; //Displaying Session Message
                unset($_SESSION['add']); //Removing Session Message
            }
        ?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name: </td>
                    <td>
                        <input type="text" name="full_name" placeholder="Enter your Full Name">
                    </td>
                </tr>
                <tr>
                    <td>Username: </td>
                    <td>
                        <input type="text" name="username" placeholder="Enter your Userame">
                    </td>
                </tr>
                <tr>
                    <td>Password: </td>
                    <td>
                        <input type="password" name="password" placeholder="Enter your Password">
                    </td>
                </tr>
                <tr><td></td></tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <br><br><br><br><br>
    <br><br><br><br><br>
    <br><br><br><br><br>
    <br><br><br><br>
</div>

<?php include('partials/footer.php'); ?>

<?php

// Process the value from FORM and Save it in Database
// Check whether the button is clicked or not
if(isset($_POST['submit']))
{
    // Get data from FORM
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Password Encryption using md5 function

    // SQL query to save data in database
    $sql = "INSERT INTO tbl_admin SET
        full_name='$full_name',
        username='$username',
        password='$password'
    ";

    // Executing Query and saving data into database
    $res = mysqli_query($conn, $sql) or die(mysqli_error());

    // Check whether query is executed/data is inserted or not and display message
    if($res==TRUE)
    {
        // create a session variable to display Message
        $_SESSION['add'] = "<div class='success'> Admin Added Successfully </div>";
        // Redirection to Page Admin
        header("location:".SITEURL.'admin/manage-admin.php');
    }
    else
    {
        // create a session variable to display Message
        $_SESSION['add'] = "<div class='error'> Failed to Add Admin </div>";
        // Redirection to Page Admin
        header("location:".SITEURL.'admin/add-admin.php');
    }
}
?>