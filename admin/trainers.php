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
        <u><p>TRAINERS</p></u>
        <br>
        <a class="btn1" href="actions/add_trainers.php">+ Add New</a>
    </div>

    <div >
    <?php
    $sql = "SELECT * FROM trainers";

    // Execute query
    $result = $conn->query($sql);
    
    // Display results in HTML table
    if ($result->num_rows > 0) {
        // start building HTML table
        echo "<table class='table'>";
        echo "<tr><th style='width:50px;'>#</th><th>Name</th><th>Image</th><th style='width:300px;'>Desc</th><th>Shift</th><th style='width:210px;'>Actions</th></tr>";

        // loop through query results and add rows to table
        $i = 1;
        while($row = $result->fetch_assoc()) {?>
            <tr>
            <td><?php echo $i ?></td>
            <td><?php echo $row["t_name"] ?></td>
            <td>
                <?php
                    if($row["t_img"]!="No image")
                    {
                        ?>
                        <img src="<?php echo SITEURL; ?>/img/trainers/<?php echo $row["t_img"]; ?>" width="90px">
                        <?php
                    }else{
                        echo "<div>Image not added</div>";
                    }
                ?>
            </td>
            <td><?php echo $row["t_desc"] ?></td>
            <td><?php echo $row["t_shift"] ?></td>
            <td>
            <a href="<?php echo SITEURL; ?>/admin/actions/update_trainers.php?trainerID=<?php echo $row["trainerID"] ?>" class="btn2">Update</a>
            <a href="<?php echo SITEURL;?>/admin/actions/delete_trainers.php?trainerID=<?php echo $row["trainerID"] ?>" class="btn3">Delete</a>
            </td>
            <?php
            echo "</tr>";
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