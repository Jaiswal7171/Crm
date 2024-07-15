<?php
include "db.php";

// Get the current date in the database format
$currentDate = date("Y-m-d");

// If a date is provided through the input tag, convert it to the database format
if (isset($_POST['selectedDate'])) {
    $selectedDate = DateTime::createFromFormat('d/m/y', $_POST['selectedDate']);
    $searchDate = $selectedDate->format('Y-m-d');
} else {
    $searchDate = $currentDate;
}

$sql = "SELECT vt.time
FROM vendor_choose_time vt
LEFT JOIN holiday h ON vt.vendor_id = h.vendor_id AND vt.time = h.time AND h.date = '$searchDate'
WHERE (h.id IS NULL OR h.status <> 'unavailable') AND vt.vendor_id = '7'
ORDER BY vt.time ASC;";

$user_result = mysqli_query($conn, $sql);
$morningSlots = $afternoonSlots = $eveningSlots = $nightslot = [];
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
    echo '<div>No Morning Slot Available</div>';
    echo '</div></div></div>'; // Close the HTML block for displaying morning slots
}

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
    echo '</div></div></div>'; // Close the HTML block for displaying morning slots
} else {
    echo '<div>No Afternoon slots available</div>';
    echo '</div></div></div>'; // Close the HTML block for displaying morning slots
}


// Display Evening slots
// echo '<div class="row mt-3 time-slots myslots" style="padding-left: 5px !important; padding-right: 0px !important;">
//         <div class="col-lg-12 col-md-12 col-sm-12 myslots" style="padding-right: 0px !important; margin-left:0px">
//             <h3 class="ser_name">Evening Slots</h3>
//             <div class="main row mt-2 text-center">';

// if (!empty($eveningSlots)) {
//     foreach ($eveningSlots as $slot) {
//         echo '<div class="cat action">
//                 <label>
//                 <input type="radio" class="time-radio" name="appointment_time" value="' . $slot . '" onclick="displaySelectedSlot()"><span>' . $slot . '</span>
//                 </label>
//             </div>';
//     }
//     echo '</div></div></div>';

// } else {
//     echo '<div>No Evening Slots Available</div>';
//     echo '</div></div></div>'; 
// }


// echo '<script>
//     function validateTimeSelection() {
//         var selectedTime = document.querySelector(\'input[name="appointment_time"]:checked\');

//         if (!selectedTime) {
//             alert("Please select a time slot.");
//             return false;
//         }

//         // Proceed with other actions if needed
//         return true;
//     }
// </script>';

//     echo '<script>
//     function displaySelectedSlot() {
//         var selectedSlot = document.querySelector(\'input[name="appointment_time"]:checked\');
//         if (selectedSlot) {
//             document.getElementById("selected-slot").innerHTML = "<p> " + selectedSlot.value + "</p>";
//         }
//     }
//   </script>';


echo '<div class="row mt-3 time-slots myslots" style="padding-left: 5px !important; padding-right: 0px !important;">
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
    echo '</div></div></div>'; 
} else {
    echo '<div>No Evening Slots Available</div>';
    echo '</div></div></div>'; 
}

echo '<script>
    function validateTimeSelection() {
        var selectedTime = document.querySelector(\'input[name="appointment_time"]:checked\');

        if (!selectedTime) {
            alert("Please select a time slot.");
            return false;
        }

        // Proceed with other actions if needed
        return true;
    }

    function displaySelectedSlot() {
        var selectedSlot = document.querySelector(\'input[name="appointment_time"]:checked\');
        if (selectedSlot) {
            document.getElementById("selected-slot").innerHTML = "<p> " + selectedSlot.value + "</p>";
        }
    }
</script>';


?>