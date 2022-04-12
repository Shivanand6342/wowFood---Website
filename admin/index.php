<?php include('partials/menu.php'); ?>

    <!-- Main Content -->
    <div class="main-content">
    <div class="wrapper">
            <h1> DASHBOARD </h1>
            <br><br><br>

            <?php 

            if(isset($_SESSION['login']))
            {
                echo $_SESSION['login'];
                unset($_SESSION['login']);
            }

            ?> <br>

            <div class="col-4 text-center">

            <?php
            $sql = "SELECT * FROM tbl_category";

            // execute query
            $res = mysqli_query($conn, $sql);

            // count rows
            $count = mysqli_num_rows($res);
            ?>

                <h1><?php echo $count; ?></h1>
                <br>
                CATEGORIES
            </div>

            <div class="col-4 text-center">

            <?php
            $sql2 = "SELECT * FROM tbl_food";

            // execute query
            $res2 = mysqli_query($conn, $sql2);

            // count rows
            $count2 = mysqli_num_rows($res2);
            ?>

                <h1><?php echo $count2; ?></h1>
                <br>
                FOODS
            </div>

            <div class="col-4 text-center">

            <?php
            $sql3 = "SELECT * FROM tbl_order";

            // execute query
            $res3 = mysqli_query($conn, $sql3);

            // count rows
            $count3 = mysqli_num_rows($res3);
            ?>

                <h1><?php echo $count3; ?></h1>
                <br>
                TOTAL ORDERS
            </div>

            <div class="col-4 text-center">

            <?php
            // Create SQL query to get total revenue generated
            // Aggrefate func in SQL
            $sql4 = "SELECT SUM(total) AS Total FROM tbl_order WHERE status='Delivered'";

            // Execute the query
            $res4 = mysqli_query($conn, $sql4);

            // get the value
            $row4 = mysqli_fetch_assoc($res4);

            // get the Total revenue
            $total_revenue = $row4['Total'];
            ?>

                <h1>$<?php echo $total_revenue; ?></h1>
                <br>
                REVENUE GENERATED
            </div>
            <div class="clearfix"></div>
        </div>
        <br><br><br><br><br><br>
        <br><br><br><br><br><br>
        <br><br><br><br>
    </div>
    <!-- Main Content Ends -->

<?php include('partials/footer.php'); ?>