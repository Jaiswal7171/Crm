<?php
include "db.php"; // Assuming this file contains your database connection

if(isset($_POST['selectedDate'])) {
    // Get selected date
    $searchDate = $_POST['selectedDate'];

    // Extract vid from the URL
    $vid = isset($_GET['vid']) ? intval($_GET['vid']) : 0;

    $holidayQuery = "SELECT COUNT(*) AS holiday_count FROM holiday WHERE vid = '$vid' AND DATE(date) = '$searchDate' AND fullday_holiday = 1";
    $holidayResult = mysqli_query($conn, $holidayQuery);
    $holidayData = mysqli_fetch_assoc($holidayResult);
    $isFullDayHoliday = $holidayData['holiday_count'] == 1;

    if ($isFullDayHoliday) {
        // echo "The shop is closed today (Full-day holiday)";
         echo '<div style="height:280px;padding-top:20px">The shop is closed today (Full-day holiday)</div>';
    } else {
        $sql = "SELECT vt.time
        FROM web_vendor_choosetimes vt
        LEFT JOIN holiday h ON vt.vid = h.vid AND vt.time = h.time AND DATE(h.date) = '$searchDate'
        WHERE (h.id IS NULL OR h.status <> 'unavailable') AND vt.vid = '$vid'
        AND (
            '$searchDate' != CURDATE() -- If selected date is not the current date
            OR ( -- If selected date is the current date, filter time slots starting from current time onwards
                '$searchDate' = CURDATE() AND vt.time > CURTIME()
            )
        )
        ORDER BY vt.time ASC;";

        $user_result = mysqli_query($conn, $sql);
        $morningSlots = $afternoonSlots = $eveningSlots = [];

        if (mysqli_num_rows($user_result) > 0) {
            while ($row = mysqli_fetch_assoc($user_result)) {
                $time = strtotime($row['time']);
                $formattedTime = date("h:ia", $time);

                if ($time >= strtotime("09:00:00") && $time < strtotime("12:00:00")) {
                    $morningSlots[] = $formattedTime;
                } elseif ($time >= strtotime("12:00:00") && $time < strtotime("16:00:00")) {
                    $afternoonSlots[] = $formattedTime;
                } elseif ($time >= strtotime("16:00:00") && $time < strtotime("24:30:00")) {
                    $eveningSlots[] = $formattedTime;
                }
            }

            // Display morning slots
            echo '<div class="row mt-3 time-slots1 myslots" style="padding-left: 5px !important; padding-right: 0px !important;">
                    <div class="col-lg-12 col-md-12 col-sm-12 myslots" style="padding-right: 0px !important; margin-left:0px">
                        <h3 class="ser_name">Morning Slots</h3>
                        <div class="main row mt-2 text-center">';

            if (!empty($morningSlots)) {
                foreach ($morningSlots as $slot) {
                    echo '<div class="cat action">
                            <label>
                                <input type="radio" class="time-radio" name="appointment_time" value="' . $slot . '" onclick="displaySelectedSlot()"><span>' . $slot . '</span>
                            </label>
                        </div>';
                }
                echo '</div></div></div>'; // Close the HTML block for displaying morning slots
            } else {
                // echo '<div>No Morning Slot Available</div>';
                // echo '</div></div></div>'; 
                  // Display message when no morning slots are available
    echo '<div class="no-morning-slots" style="height: 80px;">No Morning Slot Available</div>';
    echo '</div></div></div>'; // Close the HTML block for displaying morning slots
            }
            
          echo '  <script>
    // Check if the "No Morning Slots Available" message is displayed
    var noMorningSlots = document.querySelector(".no-morning-slots div:only-child");
    if (noMorningSlots) {
        // Add CSS class to apply styling
        document.querySelector(".no-morning-slots").classList.add("no-slots-available");
    }
</script>';



            // Display Afternoon slots
            echo '<div class="row mt-3 time-slots1 myslots" style="padding-left: 5px !important; padding-right: 0px !important;">
                    <div class="col-lg-12 col-md-12 col-sm-12 myslots" style="padding-right: 0px !important; margin-left:0px">
                        <h3 class="ser_name">Afternoon Slots</h3>
                        <div class="main row mt-2 text-center">';

            if (!empty($afternoonSlots)) {
                foreach ($afternoonSlots as $slot) {
                    echo '<div class="cat action">
                            <label>
                                <input type="radio" class="time-radio" name="appointment_time" value="' . $slot . '" onclick="displaySelectedSlot()"><span>' . $slot . '</span>
                            </label>
                        </div>';
                }
                echo '</div></div></div>'; // Close the HTML block for displaying afternoon slots
            } else {
                // echo '<div>No Afternoon slots available</div>';
                // echo '</div></div></div>'; 
                  echo '<div class="no-afternoon-slots" style="height: 80px;">No Afternoon Slots Available</div>';
                  echo '</div></div></div>'; // Close the HTML block for displaying afternoon slots
            }

            echo '<script>
    // Check if the "No Afternoon Slots Available" message is displayed
    var noAfternoonSlots = document.querySelector(".time-slots2 div:only-child");
    if (noAfternoonSlots) {
        // Add CSS class to apply styling
        document.querySelector(".time-slots2").classList.add("no-slots-available");
    }
</script>';


            // Display Evening slots
            echo '<div class="row mt-3 time-slots1 myslots" style="padding-left: 5px !important; padding-right: 0px !important;">
                    <div class="col-lg-12 col-md-12 col-sm-12 myslots" style="padding-right: 0px !important; margin-left:0px">
                        <h3 class="ser_name">Evening Slots</h3>
                        <div class="main row mt-2 text-center">';

            if (!empty($eveningSlots)) {
                foreach ($eveningSlots as $slot) {
                    echo '<div class="cat action">
                            <label>
                                <input type="radio" class="time-radio" name="appointment_time" value="' . $slot . '" onclick="displaySelectedSlot()"><span>' . $slot . '</span>
                            </label>
                        </div>';
                }
                echo '</div></div></div>'; // Close the HTML block for displaying evening slots
            } else {
                // echo '<div>No Evening Slots Available</div>';
                // echo '</div></div></div>'; 
                 echo '<div class="no-evening-slots" style="height: 100px;">No Evening Slots Available</div>';
                 echo '</div></div></div>'; // Close the HTML block for displaying evening slots
            }
            
            

            // JavaScript function for validating time selection
            echo '<script>
                    function validateTimeSelection() {
                        var selectedTime = document.querySelector(\'input[name="appointment_time"]:checked\');

                        if (!selectedTime) {
                            alert("Please select a time slot.");
                            return false;
                        }

                        nextPage();
                        return true;
                    }

                    // JavaScript function for displaying selected time slot
                     function displaySelectedSlot() {
                        var selectedSlot = document.querySelector(\'input[name="appointment_time"]:checked\');
                        if (selectedSlot) {
                            document.getElementById("selected-slot").innerHTML = "<p> &  " + selectedSlot.value + "</p>";
                        }
                    }
                </script>';
        } else {
            // No time slots available
            echo "<div style=\"padding-top: 30px; padding-left: 65px;\">
            <img src=\"download.png\" alt=\"Image\"><br>
            <span style=\"padding-left: 55px;\">Sorry, Todays Time slot is closed !</span>
      </div>";

           
        }
    }
}
?>




<br>

 
    
      <div class="btn-group" style="position: relative;max-width:500px; width: 100%; left: 50%; padding:5px;  transform: translateX(-50%); display: flex;
      justify-content: space-between;@media screen and (min-width: 768px) {
        .btn-group {  bottom: 50px; }}">
        <button type="button" class="btn btn-prev btn-grad" onclick="prevPage()">Previous</button>
        <button type="button" class="btn btn-grad" onclick="return validateTimeSelection();">Next</button>
    </div>
    
  

    


<style>

.last {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  
}

.btn-group {
    margin-top: auto;
    position: sticky;
} 
@media screen and (min-width: 768px) {
        .btn-group {
            padding: 20px !important; 
            bottom: 40px; 
        }
        
    }
 body {
        height: 100vh; 
    }
    
      @media screen and (min-width: 1000px) {
        .container {
            position: relative;
        }

        .btn-group {
            position: relative;
            max-width: 500px;
            width: 100%; /* Adjust width to fill the available space */
            margin: 0 auto; /* Center horizontally */
            bottom: initial;
            left: initial;
            transform: none;
        }

      
    }
</style>


