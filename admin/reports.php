<?php 
include("../partials/ad_navbar.php");
?>
    <div class="heading">
        <u><p>PACKAGE BOOKING REPORTS</p></u>
    </div>
    <div class="daterange">
    <form method="post" enctype="multipart/form-data">
        <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" name="start_date">

        <label for="end_date">End Date:</label>
        <input type="date" id="end_date" name="end_date">
        <br>
        <input type="reset" value="Reset" class="reset_btn3">
        <input type="submit" name="submit" value="Submit" class="sub_btn">
    <form>
    </div>
  <div>
    <table class="table">
      <thead>
        <tr>
          <th style="width:50px;">#</th>
          <th>Name</th>
          <th>Phone</th>
          <th>Package</th>
          <th>Booking Date</th>
          <th>Expiry Date</th>
          <th>Price</th>
          <th>Shift</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if (isset($_POST['start_date']) && isset($_POST['end_date'])) {
          // define the date range
          $start_date = $_POST['start_date'];
          $end_date = $_POST['end_date'];
          // prepare the SQL statement
          $stmt = $conn->prepare("SELECT m.m_name, m.m_age, m.m_gender,m.m_phone, p.p_name, b.booking_date, b.expiry_date, b.m_price, m.m_shift
                                  FROM bookings b 
                                  JOIN members m ON b.m_phone = m.m_phone 
                                  JOIN packages p ON b.packID = p.packID 
                                  WHERE b.booking_date BETWEEN ? AND ?
                                  ORDER BY m.m_shift");
          // bind the parameters
          $stmt->bind_param("ss", $start_date, $end_date);
          // execute the statement
          $stmt->execute();
          // retrieve the result set
          $result = $stmt->get_result();
          // check if there are any rows
          if ($result->num_rows > 0) {
              $i = 1;
              $total_price = 0;
              // loop through the rows and output the data
              while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $i . '</td>';
                echo '<td>' . $row['m_name'] . " " . $row['m_age'] . "/" . $row['m_gender'] . '</td>';
                echo '<td>' . $row['m_phone']  . '</td>';
                echo '<td>' . $row['p_name'] . '</td>';
                echo '<td>' . $row['booking_date'] . '</td>';
                echo '<td>' . $row['expiry_date'] . '</td>';
                echo '<td>' . $row['m_price'] . '</td>';
                echo '<td>' . $row['m_shift'] . '</td>';
                echo '</tr>';
                $i++;
                $total_price += $row['m_price'];
              }
              echo '<tr><td colspan="6"></td><td>Rs <b>' . number_format($total_price, 2) . '</b></td><td></td></tr>';
          } 
        } 
        ?>
      </tbody>
    </table>
    <center><button style="padding:3px 10px;border-radius:4px;background-color:rgb(175, 174, 174);" onclick="printTable()"> <i class="fa fa-print" aria-hidden="true"></i> Print </button></center>
        <script>
         function printTable() {
          // create a new window to print
          var printWindow = window.open('', '_blank');

          // get the HTML content of the table
          var tableHtml = document.querySelector('.table').outerHTML;

          // write the table HTML to the new window
          printWindow.document.write('<html><head><title>Table</title></head><body>' + tableHtml + '</body></html>');

          // print the new window
          printWindow.print();
          window.close();
        }
        </script>
      </div>
</div>
</body>
</html>