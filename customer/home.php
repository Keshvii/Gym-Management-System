<?php
include("../partials/configuration_navbar.php");
?>
        <div id="top" class="content">
            <div class="joinbtn">
                <a href="../login/cust_registration.php" id="loginbtn">+ Join Now</a>
            </div>
        </div>

        <!--Desc and BMI calculation-->
        <p id="bmi"></p><br><br>
        <div class="gym-desc">
            <i><h1 style="color:#370617" id="data">FITNESS CLUB</h1>
            <p>"Fitness Club is a well-known gym and reputed health club in Aligarh with exceptional equipments and professional trainers.
                  The trainers help in transforming your body to your dream body. The gym has a separate space for bodyweight exercises and 
                  aerobics. Stop waiting for Monday, January 1, or anything else. Start now."<br>
            </p></i><br>
            <b><p>Location: SwarnJayanti Nagar, Aligarh</p></b>
            <br>
        </div>
        <div class="bmi">
            <div class="bmi-form">
                <h2>BMI Calculator</h2>
                <p>BMI is an easy screening method for weight category— underweight, healthy weight, overweight, and obesity</p><br>
                <form method="post" action="home.php#data">
                <b>
                <label for="weight">Weight (kg)</label>
                <input type="text" id="weight" name="weight" required><br>

                <label for="height">Height (cm)</label>
                <input type="text" id="height" name="height" required><br><br>
                </b>
                <button type="submit" class="btn1">Calculate BMI</button>
            </div>
            <div class="bmi-result">
              <?php
              if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                
                $weight = $_POST["weight"];
                $height = $_POST["height"] / 100;
                
                $bmi = $weight / ($height * $height);
                $bmi = round($bmi, 1);

                echo "<h1>Your BMI is: $bmi</h1>";

                if ($bmi < 18.5) {
                  echo "<p style='color:orange'>You are underweight</p>";
                } elseif ($bmi >= 18.5 && $bmi <= 24.9) {
                  echo "<p style='color:green'>You are at a healthy weight</p>";
                } elseif ($bmi >= 25 && $bmi <= 29.9) {
                  echo "<p style='color:#da610b'>You are overweight</p>";
                } else {
                  echo "<p style='color:red'>You are obese</p>";
                }
              }
              ?>
            </div>
        </div>
        <!--Equipments-->
        <p id="equipments"></p><br><br><br><br>
        <center><img class="heading" src="../img/equipments.png"  alt="EQUIPMENTS"></center>
        <div class="box equipment-container">
              <?php
              // Select data from the "equip" table
              $stmt = $conn->prepare("SELECT e_img, e_name FROM equipments");
              $stmt->execute();
              $result = $stmt->get_result();
              if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                  echo '<div class="equipment-item">';
                  if($row["e_img"]=="No image"){
                    echo "<div style='padding-top: 40%;color:red;'>Image not available.</div>";
                  }else {
                  ?>
                  <img src="<?php echo SITEURL; ?>img/equipments/<?php echo $row["e_img"];?>" alt="<?php echo $row['e_name']; ?>">
                  <?php }?>
                  <h3><?php echo $row["e_name"];?></h3>
              </div>
              <?php
                }
              } else {
                echo "No equipments found.";
              }
              $stmt->close();
              ?>
        </div>
          
        <!--Packages-->
        <p id="packages"></p><br><br><br><br>
        <center><img class="heading" src="../img/packages.png" alt="PACKAGES"></center>
        <div class="box package-container">
            <?php
            // Select data from the "packages" table
            $stmt = $conn->prepare("SELECT p_name, p_desc, price FROM packages");
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
                echo '<div class="package-item">';
                echo '<h3>' . $row["p_name"] . '</h3>';
                echo '<p>' . $row["p_desc"] . '</p>';
                echo '<p>Price: Rs ' . $row["price"] . '/month</p>'; ?>
                <a id="book" href="../login/mem_login.php">Book Now</a>
                </div>
                <?php
              }
            } else {
              echo "No packages found.";
            }
            $stmt->close();
            ?>
        </div>
          
        <!--Trainers-->
        <p id="trainers"></p><br><br><br><br>
        <center><img class="heading" src="../img/trainers.png" alt="TRAINERS"></center>
        <div class="box trainer-container">
            <?php
              // Select data from the "trainers" table
              $stmt = $conn->prepare("SELECT t_name, t_img, t_desc, t_shift FROM trainers");
              $stmt->execute();
              $result = $stmt->get_result();
              if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                  echo '<div class="trainer">';
                  if($row["t_img"]=="No image"){
                    echo "<div style='padding-top: 40%;color:red;'>Image not available.</div>";
                  }else {
                  ?>
                  <img src="<?php echo SITEURL; ?>img/trainers/<?php echo $row["t_img"];?>" alt="<?php echo $row['t_name']; ?>">
                  <?php }?>
                  <h3><?php echo $row["t_name"];?></h3>
                  <p><?php echo $row["t_desc"];?></p>
                  <b><p>Shift: <?php echo $row["t_shift"];?></p></b>
              </div>
              <?php
                }
              } else {
                echo "No trainer found.";
              }
              $stmt->close();
              ?>
        </div>    
        <b><a href="#bmi" style="margin-left: 10%;color: #06a16a; font-size: 20px;">Back to top</a></b>
        <!--Footer-->
        <?php
          $stmt1 = $conn->prepare("SELECT * FROM contacts");
          $stmt1->execute();
          $result = $stmt1->get_result();
          $row = $result->fetch_assoc();
          $mobile = $row['mobile'];
          $phone = $row['phone'];
          $email = $row['email'];
          $insta = $row['insta'];
          $facebook = $row['facebook'];
          $twitter = $row['twitter'];
          $whatsapp = $row['whatsapp'];
        ?>
        <div id="contact" class="icon footer">     
            <p>Copyright © 2023, FITNESS CLUB</p>
            <div class="left">
                <h2><u> Reach Us!</u></h2>
                <ul>
                    <li><a href="tel:+<?php echo $mobile?>">  <i class="fa fa-phone-square" aria-hidden="true"></i>  +91 <?php echo $mobile?></a></li>
                    <li><a href="tel:+91<?php echo $phone?>">  <i class="fa fa-phone" aria-hidden="true"></i>  +<?php echo $phone?></a></li>
                    <li><a href="mailto:<?php echo $email?>"> <i class="fa fa-envelope" aria-hidden="true"></i> <?php echo $email?></a></li>
                </ul>
            </div>
            <div class="right">
                <h2><u> Connect With Us!</u></h2>
                <a href="<?php echo $insta?>"> <i class="fa fa-instagram"></i></a>
                <a href="<?php echo $facebook?>"> <i class="fa fa-facebook-square "></i></a>
                <a href="<?php echo $twitter?>"> <i class="fa fa-twitter-square"></i></a>
                <a href="https://wa.me/<?php echo $whatsapp?>"> <i class="fa fa-whatsapp" aria-hidden="true"></i></a>
            </div>
        </div>
    </div>
</body>
</html>