<?php 
include("../partials/ad_navbar.php");
session_start();
?>
    <div class="heading">
    <?php
    if(isset($_SESSION['success_delete'])) {
        echo "<div style='text-align:center;background-color:#dff0d8;color:#3c763d;
            border:1px solid #3c763d;border-radius:25px;font-size:20px; padding:5px;margin:20px 0px;'>
            {$_SESSION['success_delete']}</div>";
        unset($_SESSION['success_delete']);
    }

    if(isset($_SESSION['error_delete'])) {
        echo "<div style='text-align:center;background-color: #f2dede;color: #a94442;
        border:1px solid #3c763d;border-radius:25px;font-size:20px; padding:5px;margin:20px 0px;'>{$_SESSION['error_delete']}</div>";
        unset($_SESSION['error_delete']);
    }
    ?>
        <u><p>PACKAGES</p></u>
        <br>
        <a class="btn1" href="actions/add_packages.php">+ Add New</a>
    </div>

    <div >
    <?php
    $sql = "SELECT * FROM packages";

    // Execute query
    $result = $conn->query($sql);
    
    // Display results in HTML table
    if ($result->num_rows > 0) {
        // start building HTML table
        echo "<table class='table'>";
        echo "<tr><th style='width:50px;'>#</th><th>Name</th><th>Price</th><th style='width:350px;'>Desc</th><th style='width:210px;'>Actions</th></tr>";

        // loop through query results and add rows to table
        $i = 1;
        while($row = $result->fetch_assoc()) {?>
            <tr>
            <td><?php echo $i ?></td>
            <td><?php echo $row["p_name"] ?></td>
            <td><?php echo $row["price"] ?></td>
            <td><?php echo $row["p_desc"] ?></td>
            <td>
            <a href="<?php echo SITEURL; ?>/admin/actions/update_packages.php?packID=<?php echo $row["packID"] ?>" class="btn2">Update</a>
            <a href="<?php echo SITEURL;?>/admin/actions/delete_packages.php?packID=<?php echo $row["packID"] ?>" class="btn3">Delete</a>
            </td>
            </tr>
            
        <?php
        $i++;
        }

        // finish building HTML table
        echo "</table>";
    }
        // close statement and database connection
         ?>
    </div>
</div>
</body>
</html>