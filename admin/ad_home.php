<?php 
session_start();
include("../partials/ad_navbar.php");
?>
    <div class="heading">
    <?php
    if(isset($_SESSION['ad_login'])) {
        echo "<div style='text-align:center;background-color:#dff0d8;color:#3c763d;
            border:1px solid #3c763d;border-radius:25px;font-size:20px; padding:5px;margin:20px 0px;'>
            {$_SESSION['ad_login']}</div>";
        unset($_SESSION['ad_login']);
    }
    ?>
        <div style="font-size:18px;color:#132a13;">
            <br>
            <a href="actions/change_admin_logincredentials.php"><i class="fa fa-user"></i><br>
            Admin</a> <br><br>
        </div>
        <u><p>DASHBOARD</p></u>
    </div>
    
    <div class="box package-container">
        
        <div class="package-item" style="background-color:#AE2012;">
        <p>Available Equipments</p>
        <?php
        $stmt = $conn->prepare("SELECT * FROM equipments");
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            echo '<h3>' . $result->num_rows . '</h3>'; 
        } else {
            echo "<h3>No equipments.</h3>";
        }
        $stmt->close();
        ?>
        <a id="book" href="equipments.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> View Details</a>
        </div>

        <div class="package-item" style="background-color: #AE2012;">
        <p>Available Packages</p>
        <?php
        // Select data from the "packages" table
        $stmt = $conn->prepare("SELECT * FROM packages");
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            echo '<h3>' . $result->num_rows . '</h3>'; 
        } else {
            echo "<h3>No packages.</h3>";
        }
        $stmt->close();
        ?>
        <a id="book" href="packages.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> View Details</a>
        </div>

        <div class="package-item" style="background-color:#AE2012;">
        <p>Available Trainers</p>
        <?php
        $stmt = $conn->prepare("SELECT * FROM trainers");
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            echo '<h3>' . $result->num_rows . '</h3>'; 
        } else {
            echo "<h3>No trainers.</h3>";
        }
        $stmt->close();
        ?>
        <a id="book" href="trainers.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> View Details</a>
        </div>

        <div class="package-item" style="background-color:#EE9B00;">
        <p>Total Registered Members</p>
        <?php
        $stmt = $conn->prepare("SELECT * FROM members");
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            echo '<h3>' . $result->num_rows . '</h3>'; 
        } else {
            echo "<h3>0</h3>";
        }
        $stmt->close();
        ?>
        <a id="book" href="members.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> View Details</a>
        </div>

        <div class="package-item" style="background-color:#EE9B00;">
        <p>Members(never booked)</p>
        <?php
        $stmt = $conn->prepare("SELECT COUNT(*) as member_count FROM members LEFT JOIN bookings ON members.m_phone = bookings.m_phone WHERE bookings.m_phone IS NULL;");
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        echo '<h3>' .  $row['member_count'] . '</h3>';
        $stmt->close();
        ?>
        <a id="book" href="#notbook"><i class="fa fa-angle-double-right" aria-hidden="true"></i> View Details</a>
      
        </div>
        <div class="package-item" style="background-color:#EE9B00;">
        <p>Total Expense</p>
        <?php
        $stmt = $conn->prepare("SELECT SUM(m_price) AS total_expense FROM bookings");
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo '<h3> Rs ' . $row['total_expense'] . '</h3>'; 
        } else {
            echo "<h3>Rs 0</h3>";
        }
        $stmt->close();
        ?>
        <a id="book" href="#bookingtbl"><i class="fa fa-angle-double-right" aria-hidden="true"></i> View Details</a>
      
        </div>

        <div class="package-item" style="background-color:#15616d;;">
        <p>Members(have booked)</p>
        <?php
        $stmt = $conn->prepare("SELECT COUNT(DISTINCT m_phone) as phone_count FROM bookings;");
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        echo'<h3>' . $row['phone_count'] . '</h3>';
        $stmt->close()
        ?>
        <a id="book" href="#active"><i class="fa fa-angle-double-right" aria-hidden="true"></i> View Details</a>
        </div>

        <div class="package-item" style="background-color: #15616d;">
            <p>Active Members</p>
            <?php
            // Prepare the SQL statement to select the number of inactive members
            $stmt = $conn->prepare("SELECT COUNT(DISTINCT IF(expiry_date <= NOW(), m_phone, NULL)) AS expired_bookings, 
            COUNT(DISTINCT IF(expiry_date > NOW(), m_phone, NULL)) AS active_bookings 
            FROM bookings;");
            $stmt->execute();
            $result = $stmt->get_result();
            
            // Display the number of inactive members
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo '<h3>' . $row['active_bookings'] . '</h3>'; 
            } else {
                echo "<h3>No members.</h3>";
            }
            
            $stmt->close();
            ?>
            <a id="book" href="#active"><i class="fa fa-angle-double-right" aria-hidden="true"></i> View Details</a>
        </div>

        <div class="package-item" style="background-color:#15616d;">
            <p>Inactive Members</p>
            <?php
            // Prepare the SQL statement to select the number of inactive members
            $stmt = $conn->prepare("SELECT COUNT(DISTINCT m_phone) AS total_phone_numbers, 
            COUNT(DISTINCT IF(expiry_date > NOW(), m_phone, NULL)) AS active_bookings 
             FROM bookings;");
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $inactive_members = $row['total_phone_numbers']-$row['active_bookings'];
            
            // Display the number of inactive members
            if ($result->num_rows > 0) {
                echo '<h3>' . $inactive_members . '</h3>';
            } else {
                echo "<h3>No members.</h3>";
            }
            
            $stmt->close();
            ?>
            <a id="book" href="#inactive"><i class="fa fa-angle-double-right" aria-hidden="true"></i> View Details</a>
        </div>
    </div>
    <br><br><br><br><br><br><br>
    <div class="search-bar">
    <form action="" method="post">
        <center>
        <select name="shift" style="text-align:center;padding:3px 10px;width:20vw;margin-bottom:10px; border-radius:4px;">
            <option value="6AM-8AM">6AM-8AM</option>
            <option value="8AM-10AM">8AM-10AM</option>
            <option value="10AM-12PM">10AM-12PM</option>
            <option value="3PM-5PM">3PM-5PM</option>
            <option value="5PM-7PM">5PM-7PM</option>
            <option value="7PM-9PM">7PM-9PM</option>
        </select>    
        <button type="submit" name="search" style="padding:3px 10px;border-radius:4px;background-color:rgb(175, 174, 174);">Search</button></center>
    </form>
    </div>
    <div style="margin-bottom:25px;">
    <?php
    if(isset($_POST['search'])) {
        $shift = $_POST['shift'];
        $stmt = $conn->prepare("SELECT * FROM members WHERE m_shift=?");
        $stmt->bind_param("s", $shift);
        $stmt->execute();
        $result = $stmt->get_result();

        $stmt2 = $conn->prepare("SELECT t_name FROM trainers WHERE t_shift=?");
        $stmt2->bind_param("s", $shift);
        $stmt2->execute();
        $result2 = $stmt2->get_result();

        // Display results in HTML table
        if ($result->num_rows > 0) {
            // start building HTML table
            echo "<table class='table'>";
            ?>
            <tr>
                <td colspan=5 style="text-align:center;">Trainer: 
                <?php
                if($result2->num_rows>0){
                    while($row2 = $result2->fetch_assoc()) {
                        echo $row2["t_name"].", ";
                    }
                }
                ?>
                </td>
            </tr>
            <?php
            echo "<tr><th>#</th><th>Name</th><th>Age/Gender</th><th>Phone</th><th style='width:400px;'>Actions</th></tr>";
            $i=1;
            while($row = $result->fetch_assoc()) {?>
                <tr>
                <td><?php echo $i?></td>
                <td><?php echo $row["m_name"] ?></td>
                <td>
                    <?php
                    echo $row["m_age"]."/".$row["m_gender"] ;
                    ?>
                </td>
                <td><?php echo $row["m_phone"] ?></td>
                <td>
                <a href="<?php echo SITEURL;?>/admin/actions/member_details.php?m_phone=<?php echo $row["m_phone"] ?>" class="btn4">More Info</a>
                <a href="<?php echo SITEURL;?>/admin/actions/delete_member.php?m_phone=<?php echo $row["m_phone"] ?>" class="btn3">Delete</a>
                </td>
                </tr>
            <?php
            $i++;
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
    <p id="notbook"></p>
    <div class="heading">
        <h1 style="margin-top:10px;padding-top: 10px;"> << REGISTERED MEMBERS (NO PACKAGE BOOKED YET) >> </h1>
    </div>
    <div>
    <?php
    $stmt = $conn->prepare("SELECT members.m_name, members.m_age, members.m_gender, members.m_address, members.m_email, members.m_phone FROM members LEFT JOIN bookings ON members.m_phone = bookings.m_phone WHERE bookings.m_phone IS NULL;");
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        // start building HTML table
        echo "<table class='table'><tr><th style='width:50px;'>#</th><th>Name</th><th>Address</th><th>Phone</th><th>Actions</th></tr>";
        // loop through query results and add rows to table
        $i = 1;
        while($row = $result->fetch_assoc()) {?>
        <tr>
            <td><?php echo $i ?></td>
            <td><?php echo $row['m_name']." ".$row['m_age'].'/'.$row['m_gender'] ?></td>
            <td><?php echo $row['m_address']?></td>
            <td><?php echo $row['m_phone']?></td>
            <td>
            <a href="<?php echo SITEURL; ?>/admin/actions/member_details.php?m_phone=<?php echo $row["m_phone"] ?>" class="btn4">View Details</a>
            <a class="btn3" href="mailto:<?php echo $row['m_email']?>"><i class="fa fa-envelope" aria-hidden="true"></i> Email</a>
            </td>
        </tr>
        <?php
        $i++;
        }
        echo "</table>";
    } else {
        echo "<center>No members found.</center>";
    }
    ?>
    </div>


    <p id="bookingtbl"></p>
    <div class="heading">
        <h1 style="margin-top:10px;padding-top: 10px;"> << TOTAL BOOKINGS >> </h1>
    </div>
    <div >
    <?php
    $sql = "SELECT * FROM bookings";
    // Execute query
    $result = $conn->query($sql);
    
    // Display results in HTML table
    if ($result->num_rows > 0) {
        // start building HTML table
        echo "<table class='table'>";
        echo "<tr><th style='width:50px;'>#</th><th>Name</th><th>PhoneNo</th><th>Package</th><th>Booking Date</th><th>Expiry Date</th><th>Fee Submitted</th><th>Actions</th></tr>";

        // loop through query results and add rows to table
        $i = 1;
        while($row = $result->fetch_assoc()) {?>
            <tr>
            <td><?php echo $i ?></td>
            <td>
                <?php 
                $m_phone=$row["m_phone"];
                $stmt7 = $conn->prepare("SELECT m_name FROM members WHERE m_phone = ?");
                $stmt7->bind_param("s", $m_phone);
                $stmt7->execute();
                $result7 = $stmt7->get_result();
                if ($result7->num_rows > 0) {
                    $row7 = $result7->fetch_assoc();
                    echo $row7['m_name'];
                }
                $stmt7->close();
                ?>
            </td>
            <td><?php echo $row["m_phone"] ?></td>
            <td>
                <?php 
                $packID = $row["packID"];
                $stmt6 = $conn->prepare("SELECT p_name FROM packages WHERE packID = ?");
                $stmt6->bind_param("i", $packID);
                $stmt6->execute();
                $result6 = $stmt6->get_result();
                if ($result6->num_rows > 0) {
                    $row6 = $result6->fetch_assoc();
                    echo $row6['p_name'];
                }
                $stmt6->close();
                ?>
            </td>
            <td>
                <?php 
                $booking_date = date('Y-m-d', strtotime($row['booking_date']));
                echo $booking_date ?>
            </td>
            <td>
                <?php 
                $expiry_date = date('Y-m-d', strtotime($row['expiry_date']));
                echo $expiry_date ?>
            </td>
            <td><?php echo $row["m_price"] ?></td>
            <td>
            <a href="<?php echo SITEURL; ?>/admin/actions/member_details.php?m_phone=<?php echo $row["m_phone"] ?>" class="btn4">View Details</a>
            </td>
            </tr>
        <?php
        $i++;
        }
        ?>
        
        <tr>
            <td colspan=6></td>
            
            <?php
                $stmt = $conn->prepare("SELECT SUM(m_price) AS total_expense FROM bookings");
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    echo '<td> Rs ' . $row['total_expense'] . '</td>'; 
                } else {
                    echo "<td> Rs 0 </td>";
                }
                $stmt->close();
            ?>
            
            <td></td>
        </tr>
        
        <?php
        echo "</table>";
    }else {
        echo "<center>No members found.</center>";
    }
    ?>
    </div>

    <p id="active"></p>
    <div class="heading">
        <h1 style="margin-top:10px;padding-top: 10px;"> << ACTIVE MEMBERS (ACTIVE PACKAGE BOOKING) >> </h1>
    </div>
    <div>
    <?php
    $stmt = $conn->prepare("SELECT DISTINCT b.m_phone, b.expiry_date, m.m_name, m.m_email, m.m_address, p.p_name 
    FROM bookings b 
    JOIN members m ON b.m_phone = m.m_phone 
    JOIN packages p ON b.packID = p.packID 
    WHERE b.expiry_date >= NOW()");
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        echo '<table class="table">';
        echo '<tr><th style="width:50px;">#</th><th>Name</th><th>Phone</th><th>Expiry Date</th><th>Latest Package</th><th>Actions</th></tr>';
        $i = 1;
        while ($row = $result->fetch_assoc()) {?>
        <tr>
            <td><?php echo $i ?></td>
            <td><?php echo $row['m_name']  ?></td>
            <td><?php echo  $row['m_phone'] ?></td>
            <td><?php
                $expiry_date = date('Y-m-d', strtotime($row['expiry_date']));
                echo $expiry_date 
            ?></td>
            <td><?php echo  $row['p_name']  ?></td>
            <td>
            <a href="<?php echo SITEURL; ?>/admin/actions/member_details.php?m_phone=<?php echo $row["m_phone"] ?>" class="btn4">View Details</a>
            </td>
        </tr>
    <?php
            $i++;
        }
    }else {
        echo "<center>No active members found.</center>";
    }
    ?>
    </table>
    </div>

    <p id="inactive"></p>
    <div class="heading">
        <h1 style="margin-top:10px;padding-top: 10px;"> << INACTIVE MEMBERS (EXPIRED PACKAGE BOOKING) >> </h1>
    </div>
    <div>
    <?php
    $stmt = $conn->prepare("SELECT DISTINCT b.m_phone, b.expiry_date, m.m_name, m.m_email, m.m_address, p.p_name 
    FROM bookings b 
    JOIN members m ON b.m_phone = m.m_phone 
    JOIN packages p ON b.packID = p.packID 
    JOIN (SELECT m_phone, MAX(expiry_date) AS max_expiry_date FROM bookings GROUP BY m_phone) latest_bookings 
    ON b.m_phone = latest_bookings.m_phone AND b.expiry_date = latest_bookings.max_expiry_date 
    WHERE b.expiry_date < NOW()");
  
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        echo '<table class="table">';
        echo '<tr><th style="width:50px;">#</th><th>Name</th><th>Phone</th><th>Expiry Date</th><th>Latest Package</th><th style="width:280px;">Actions</th></tr>';
        $i = 1;
        while ($row = $result->fetch_assoc()) {?>
        <tr>
            <td><?php echo $i ?></td>
            <td><?php echo $row['m_name']  ?></td>
            <td><?php echo  $row['m_phone'] ?></td>
            <td><?php
                $expiry_date = date('Y-m-d', strtotime($row['expiry_date']));
                echo $expiry_date 
            ?></td>
            <td><?php echo  $row['p_name']  ?></td>
            <td>
            <a href="<?php echo SITEURL; ?>/admin/actions/member_details.php?m_phone=<?php echo $row["m_phone"] ?>" class="btn4">View Details</a>
            <a class="btn3" href="mailto:<?php echo $row['m_email']?>"><i class="fa fa-envelope" aria-hidden="true"></i> Email</a>
            </td>
        </tr>
    <?php
            $i++;
        }
    }else {
        echo "<center>No inactive members found.</center>";
    }
    ?>
    </table>
    </div>
</div>
</body>
</html>