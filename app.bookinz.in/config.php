<?php 
include "db.php"; ?>
<?php
if (isset($_POST['lead_save'])) {
    $lead_name = $_POST['lead_name'];
    $vid = $_POST['vid'];
    $lead_address = $_POST['lead_address'];
    $contact_no = $_POST['contact_no'];
    $email = $_POST['email'];
    $selectedServices = $_POST['selectedServices'];
    $selected_Date = $_POST['selected_Date'];
    $appointment_time = $_POST['appointment_time'];
    $final_amount = $_POST['final_amount'];
    // Extract only the service names
    $serviceNames = array_map(function ($service) {
        $parts = explode('|', $service);
        return $parts[0]; // Assuming service_name is the first part
    }, $selectedServices);
    $selectedServicesString = implode(',', $serviceNames);
    // Convert the user input date to a DateTime object
    $userDate = DateTime::createFromFormat('d/m/Y', $selected_Date);
    // Format the date to yy-mm-dd format
    $formattedDate = $userDate->format('y-m-d');
    // Check if the database connection is successful
    if ($conn) {
        $query = "INSERT INTO `lead` (lead_name, vid, lead_address, contact_no, email, selectedServices, selected_Date, appointment_time, final_amount) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        if ($stmt) {         
            // Use prepared statements for security
            mysqli_stmt_bind_param($stmt, "sssssssss", $lead_name, $vid, $lead_address, $contact_no, $email, $selectedServicesString, $formattedDate, $appointment_time, $final_amount);
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to success.php upon successful form submission
                header("Location: success.php?status=success");
                exit(); // Stop executing further code
            } else {
                die("Error in SQL query execution: " . mysqli_stmt_error($stmt));
            }
            mysqli_stmt_close($stmt);
        } else {
            die("Error in SQL query preparation: " . mysqli_error($conn));
        }
        // Close the database connection
        mysqli_close($conn);
    } else {
        die("Error: Database connection failed.");
    }
} else {
    die("Error: 'lead_save' key is not set in \$_POST.");
}
?>
