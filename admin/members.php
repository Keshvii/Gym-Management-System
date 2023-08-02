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
        <u><p>REGISTERED MEMBERS</p></u>
        <br>
        <a class="btn1" href="register.php">+ Add New</a>
    </div>
    <div class="search-bar">
    <form action="" method="post">
        <center><input style="padding:3px 10px;width:20vw;margin-bottom:10px; border-radius:4px;" type="text" name="m_phone" placeholder="Search member by phone number..." pattern="[0-9]{10}">
        <button type="submit" name="search" style="padding:3px 10px;border-radius:4px;background-color:rgb(175, 174, 174);">Search</button></center>
    </form>
    </div>
    <div style="margin-bottom:25px;">
    <?php
    if(isset($_POST['search'])) {
        $search_phone = $_POST['m_phone'];
        $stmt = $conn->prepare("SELECT * FROM members WHERE m_phone=?");
        $stmt->bind_param("s", $search_phone);
        $stmt->execute();
        $result = $stmt->get_result();

        // Display results in HTML table
        if ($result->num_rows > 0) {
            // start building HTML table
            echo "<table class='table'>";
            echo "<tr><th>Name</th><th>Age/Gender</th><th>Phone</th><th>Shift</th><th style='width:350px;'>Actions</th></tr>";

            while($row = $result->fetch_assoc()) {?>
                <tr>
                <td><?php echo $row["m_name"] ?></td>
                <td>
                    <?php
                    echo $row["m_age"]."/".$row["m_gender"] ;
                    ?>
                </td>
                <td><?php echo $row["m_phone"] ?></td>
                <td><?php echo $row["m_shift"] ?></td>
                <td>
                <a href="<?php echo SITEURL;?>/admin/actions/member_details.php?m_phone=<?php echo $row["m_phone"] ?>" class="btn4">More Info</a>
                <a href="<?php echo SITEURL; ?>/admin/actions/update_member.php?m_phone=<?php echo $row["m_phone"] ?>" class="btn2">Update</a>
                <a href="<?php echo SITEURL;?>/admin/actions/delete_member.php?m_phone=<?php echo $row["m_phone"] ?>" class="btn3">Delete</a>
                </td>
                </tr>
            <?php
            }

            // finish building HTML table
            echo "</table>";
        }
        else {
            echo "<center><span style='color:red;'>No member</span></center>";
        }
    }
    ?>
    </div>
  
    </div>
    <div >
    <?php
    $sql = "SELECT * FROM members ORDER BY m_shift DESC";
    // Execute query
    $result = $conn->query($sql);
    
    // Display results in HTML table
    if ($result->num_rows > 0) {
        // start building HTML table
        echo "<table class='table'>";
        echo "<tr><th style='width:70px;'>#</th><th>Name</th><th>Age/Gender</th><th>Phone</th><th>Shift</th><th style='width:350px'>Actions</th></tr>";

        // loop through query results and add rows to table
        $i = 1;
        while($row = $result->fetch_assoc()) {?>
            <tr>
            <td><?php echo $i ?></td>
            <td><?php echo $row["m_name"] ?></td>
            <td>
                <?php
                echo $row["m_age"]."/".$row["m_gender"] ;
                ?>
            </td>
            <td><?php echo $row["m_phone"] ?></td>
            <td><?php echo $row["m_shift"] ?></td>
            <td>
            <a href="<?php echo SITEURL;?>/admin/actions/member_details.php?m_phone=<?php echo $row["m_phone"] ?>" class="btn4">More Info</a>
            <a href="<?php echo SITEURL; ?>/admin/actions/update_member.php?m_phone=<?php echo $row["m_phone"] ?>" class="btn2">Update</a>
            <a href="<?php echo SITEURL;?>/admin/actions/delete_member.php?m_phone=<?php echo $row["m_phone"] ?>" class="btn3">Delete</a>
            </td>
            </tr>
        <?php
        $i++;
        }

        // finish building HTML table
        echo "</table>";
    }
         ?>
    </div>
</div>
</body>
</html>