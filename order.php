<?php include('partials-front/menu.php'); ?>

<?php

// check whether food id is set or not
if(isset($_GET['food_id']))
{
    // get the food id and details of the selected food
    $food_id = $_GET['food_id'];

    // get the details of the selected food
    $sql = "SELECT * FROM tbl_food WHERE id=$food_id";

    // execute the query
    $res = mysqli_query($conn, $sql);

    // count rows
    $count = mysqli_num_rows($res);

    // check whether the data is available or not
    if($count==1)
    {
        // get data from database
        $row = mysqli_fetch_assoc($res);
        $title = $row['title'];
        $price = $row['price'];
        $image_name = $row['image_name'];
    }
    else
    {
        header('location:'.SITEURL);
    }
}
else
{
    header('location:'.SITEURL);
}

?>
<!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search">
        <div class="container">
            
            <h2 class="text-center text-white">Fill this form to confirm your order</h2>

            <form action="" method="POST" class="order">
                <fieldset>
                    <legend>Selected Food</legend>

                    <div class="food-menu-img">

                    <?php  
                    // check whether the image is available or not
                    if($image_name == "")
                    {
                        echo "<div class='error'>Image not Available</div>";
                    }
                    else
                    {
                        ?>
                        <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" class="img-responsive img-curve">
                        <?php
                    }
                    ?>

                    </div>
    
                    <div class="food-menu-desc">
                        <h3><?php echo $title; ?></h3>
                        <input type="hidden" name="food" value="<?php echo $title; ?>">

                        <p class="food-price">$<?php echo $price; ?></p>
                        <input type="hidden" name="price" value="<?php echo $price; ?>">
                        
                        <div class="order-label">Quantity</div>
                        <input type="number" name="qty" class="input-responsive" value="1" required>
                        
                    </div>

                </fieldset>
                
                <fieldset>
                    <legend>Delivery Details</legend>
                    <div class="order-label">Full Name</div>
                    <input type="text" name="full-name" placeholder="Enter your full name" class="input-responsive" required>

                    <div class="order-label">Phone Number</div>
                    <input type="tel" name="contact" placeholder="Enter your phone number" class="input-responsive" required>

                    <div class="order-label">Email</div>
                    <input type="email" name="email" placeholder="Enter your email" class="input-responsive" required>

                    <div class="order-label">Address</div>
                    <textarea name="address" rows="10" placeholder="Enter your address e.g. Street, City" class="input-responsive" required></textarea>

                    <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
                </fieldset>

            </form>

            <?php 
            if(isset($_POST['submit']))
            {
                // get all the details from FORM
                $food = $_POST['food'];
                $price = $_POST['price'];
                $qty = $_POST['qty'];

                $total = $price * $qty;

                $order_date = date("Y-m-d h:i:sa"); // order date

                $status = "Ordered"; // Ordered, Delivery, Delivered or Cancel
            
                $customer_name = $_POST['full-name'];
                $customer_contact = $_POST['contact'];
                $customer_email = $_POST['email'];
                $customer_address = $_POST['address'];

                // save the data in database 
                // create sql to save data
                $sql2 = "INSERT INTO tbl_order SET
                    food = '$food',
                    price = $price,
                    qty = $qty,
                    total = $total,
                    order_date = '$order_date',
                    status = '$status',
                    customer_name = '$customer_name',
                    customer_contact = '$customer_contact',
                    customer_email = '$customer_email',
                    customer_address = '$customer_address'
                ";

                // execute the query
                $res2 = mysqli_query($conn, $sql2);

                // check whether query executed successfully or not
                if($res2 == TRUE)
                {
                    $_SESSION['order'] = "<div class='success text-center'>Order Placed</div>";
                    header('location:'.SITEURL);
                }
                else
                {
                    $_SESSION['order'] = "<div class='error text-center'>Order Not Placed</div>";
                    header('location:'.SITEURL);
                }
            }

            ?>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->

<?php include('partials-front/footer.php'); ?>