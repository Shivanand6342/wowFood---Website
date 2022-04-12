<?php include('../config/constants.php'); ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title> Login - Food Order System </title>
    <link rel="stylesheet" href="css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="wrapper">
        <div class="title-text">
            <div class="title login">
                Login
            </div>
        </div><br>
        <?php 

        if(isset($_SESSION['login']))
        {
            echo $_SESSION['login'];
            unset($_SESSION['login']);
        }

        if(isset($_SESSION['no-login-message']))
        {
            echo $_SESSION['no-login-message'];
            unset($_SESSION['no-login-message']);
        }

        ?> <br>
        <div class="form-container">
            <div class="form-inner">
                <form action="" method="POST" class="login">
                    <div class="field">
                        <input name="username" type="text" placeholder="Username" required>
                    </div>
                    <div class="field">
                        <input name="password" type="password" placeholder="Password" required>
                    </div>
                    <div class="field btn">
                        <div class="btn-layer"></div>
                        <input type="submit" name="submit" value="Login">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        const loginText = document.querySelector(".title-text .login");
        const loginForm = document.querySelector("form.login");
        const loginBtn = document.querySelector("label.login");
        const signupBtn = document.querySelector("label.signup");
        const signupLink = document.querySelector("form .signup-link a");
        signupBtn.onclick = (() => {
            loginForm.style.marginLeft = "-50%";
            loginText.style.marginLeft = "-50%";
        });
        loginBtn.onclick = (() => {
            loginForm.style.marginLeft = "0%";
            loginText.style.marginLeft = "0%";
        });
        signupLink.onclick = (() => {
            signupBtn.click();
            return false;
        });
    </script>
</body>
</html>

<?php 

// Check whether submit button clicked or not
if(isset($_POST['submit']))
{
    // Get the data from FORM
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, md5($_POST['password']));

    // SQL query to check whether the username and password exist or not
    $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";

    // Execute the query
    $res = mysqli_query($conn, $sql);

    // count rows to Check whether the user exists
    $count = mysqli_num_rows($res);

    if($count == 1)
    {
        // Login Success
        $_SESSION['login'] = "<div class='success'> Login Successfull </div>";
        $_SESSION['user'] = $username; //To check whether user is loggin in or logged out or not


        // Redirect to Home Page or Dashboard
        header('location:'.SITEURL.'admin/');
    }
    else
    {
        // Login Failed
        $_SESSION['login'] = "<div class='error text-center'> Invalid Username or Password </div>";

        // Redirect to Home Page or Dashboard
        header('location:'.SITEURL.'admin/login.php');
    }
}

?>