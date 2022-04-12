<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1> Manage Order </h1>
            <br><br><br>

            <?php
            if(isset($_SESSION['update']))
            {
                echo $_SESSION['update'];
                unset($_SESSION['update']);
            }
            ?>
            <br><br>
            <table class="tbl-full text-center">
                <tr>
                    <th class="text-center"> S.No. </th>
                    <th class="text-center"> Food </th>
                    <th class="text-center"> Price </th>
                    <th class="text-center"> Quantity </th>
                    <th class="text-center"> Total </th>
                    <th class="text-center"> Order Date </th>
                    <th class="text-center"> Status </th>
                    <th class="text-center"> Name </th>
                    <th class="text-center"> Contact </th>
                    <th class="text-center"> Email </th>
                    <th class="text-center"> Address </th>
                    <th class="text-center"> Actions </th>
                </tr>

                <?php
                // get all the orders from database
                $sql = "SELECT * FROM tbl_order ORDER BY id DESC"; // DESC so that latest order show at top

                // execute query
                $res = mysqli_query($conn, $sql);

                // count rows
                $count = mysqli_num_rows($res);

                // create a s.no variable
                $sn=1;

                if($count>0)
                {
                while($row=mysqli_fetch_assoc($res))
                {
                    // get all the order details
                    $id = $row['id'];
                    $food = $row['food'];
                    $price = $row['price'];
                    $qty = $row['qty'];
                    $total = $row['total'];
                    $order_date = $row['order_date'];
                    $status = $row['status'];
                    $customer_name = $row['customer_name'];
                    $customer_contact = $row['customer_contact'];
                    $customer_email = $row['customer_email'];
                    $customer_address = $row['customer_address'];
                    ?>
                    
                    <tr style="font-size: 0.85em;">
                        <td> <?php echo $sn++; ?> </td>
                        <td> <?php echo $food; ?> </td>
                        <td> $<?php echo $price; ?> </td>
                        <td> <?php echo $qty; ?> </td>
                        <td> <?php echo $total; ?> </td>
                        <td> <?php echo $order_date; ?> </td>
                        
                        <td>
                            <?php
                            if($status=="Ordered")
                            {
                                echo "<label>$status</label>";
                            }
                            else if($status=="on Delivery")
                            {
                                echo "<label style='color: blue;'>$status</label>";
                            }
                            else if($status=="Delivered")
                            {
                                echo "<label style='color: green;'>$status</label>";
                            }
                            else if($status=="Cancelled")
                            {
                                echo "<label style='color: red;'>$status</label>";
                            }
                            ?>
                        </td>

                        <td> <?php echo $customer_name; ?> </td>
                        <td> <?php echo $customer_contact; ?> </td>
                        <td> <?php echo $customer_email; ?> </td>
                        <td> <?php echo $customer_address; ?> </td>
                        <td> 
                            <a href="<?php echo SITEURL; ?>admin/update-order.php?id=<?php echo $id; ?>" class="btn-secondary">Update</a>
                        </td>
                    </tr>

                    <?php
                }
                }
                else
                {
                    echo "<tr><td colspan='12' class='error'>Orders Not Available</td></tr>";
                }
                ?>

            </table>
    </div>
    <br><br><br><br><br><br>
    <br><br><br><br><br>
</div>

<?php include('partials/footer.php'); ?>