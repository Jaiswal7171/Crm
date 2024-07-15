<?php session_start(); ?>
<?php include "../db.php"; ?>


<!-------------------------------------------------------------- admin Login---------------------------------------------------------------------------------------------------->

<?php
    if (isset($_POST['login_admin'])) {
    
        $email = $_POST['email'];
        $password = $_POST['password'];

        $query = "SELECT * FROM admin WHERE email=?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $admin = mysqli_fetch_assoc($result);
            $hashed_password = $admin['password']; // Assuming password is hashed

            if (password_verify($password, $hashed_password)) { // Use password_verify to check hashed password
                
                $_SESSION["admin_login"] = $email;
                $_SESSION["admin_details"] = $admin;

                echo '<script>';
                echo 'window.location.href="index.php";';
                echo '</script>';
          
                exit();
            } else {
                echo "<script>";
                echo "alert('Sorry, the entered password is wrong!');";
                echo "window.location.href = 'login.php';";
                echo "</script>";
            }
        } else {
            echo "<script>";
            echo "alert('Sorry, the entered password is wrong!');";
            echo "window.location.href = 'login.php';";
            echo "</script>";
        }
        mysqli_stmt_close($stmt);
    }
?>



<!-------------------------------------------------------------- Save Category---------------------------------------------------------------------------------------------------->

<?php

if (isset($_POST['save_category'])) {
    $category_name = $_POST['category_name'];
    $query = "INSERT INTO category (category_name) VALUES (?)";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
       
        mysqli_stmt_bind_param($stmt, "s", $category_name);
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>";
            echo "alert('Category Added Successfully');";
            echo "window.location.href='view.php?view_categories=true';";
            echo "</script>";
        } else {
            echo "<script>";
            echo "alert('Failed...');";
            echo "window.location.href='add.php?add_admin=true';";
            echo "</script>";
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "<script>";
        echo "alert('Database Query Error...');";
        echo "window.location.href='add.php?add_admin=true';";
        echo "</script>";
    }
} 
?>


<!-------------------------------------------------------------- Save Services---------------------------------------------------------------------------------------------------->

    <?php
    if (isset($_POST['save_services'])) {
        $service_name = $_POST['service_name'];
        $category_id = $_POST['category_id'];
        $query = "INSERT INTO services  (service_name, category_id) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $query);

        if ($stmt) {
            // Bind parameters properly
            mysqli_stmt_bind_param($stmt, "si", $service_name, $category_id);
            if (mysqli_stmt_execute($stmt)) {
                echo "<script>";
                echo "alert('Services Added Successfully');";
                echo "window.location.href='add.php?add_services=true';";
                echo "</script>";
            } else {
                echo "<script>";
                echo "alert('Failed...');";
                echo "window.location.href='add.php?add_services=true';";
                echo "</script>";
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "<script>";
            echo "alert('Database Query Error...');";
            echo "window.location.href='view.php?view_services=true';";
            echo "</script>";
        }
    } 
    ?>








<!---------------------------------------------------------------------- Save Packages----------------------------------------------------------------------------------------------- -->

<?php
if (isset($_POST['save_packages'])) {
    $package_name = $_POST['package_name'];
    $package_price_1yr = $_POST['package_price_1yr'];
    $package_price_3yr = $_POST['package_price_3yr'];
    $package_duration_3yr = $_POST['package_duration_3yr'];
    $package_duration_1yr = $_POST['package_duration_1yr'];

    $query = "INSERT INTO packages (package_name, package_price_1yr, package_price_3yr, package_duration_3yr, package_duration_1yr) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sssss", $package_name, $package_price_1yr, $package_price_3yr, $package_duration_3yr, $package_duration_1yr);
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>";
            echo "alert('Package added successfully!');"; 
            echo "window.location.href='view.php?packages=true';";
            echo "</script>";
        } else {
            echo "<script>";
            echo "alert('Failed to add package. Please try again.');";
            echo "window.location.href='add.php?add_admin=true';";
            echo "</script>";
        }
    } else {
        echo "Unable to prepare the query.";
    }
}
?>
<!------------------------------------------------------------------------- add_categories--------------------------------------------------------------------------------------------------- -->
<?php
if (isset($_POST['save_advertise'])) {
    if (isset($_FILES['image'])) {
        $allowedFormats = array('png', 'jpg', 'jpeg', 'webp', 'jfif');
        $maxFileSize = 7 * 1024 * 1024;
        $uploadDir = "../../gallery/advertise"; 

        $heading = $_POST['heading'];
        $image = $_FILES['image']['name'];
        $targetPath = $uploadDir . $image;
        $ext = pathinfo($image, PATHINFO_EXTENSION);

        if ($_FILES["image"]["size"] > $maxFileSize || !in_array(strtolower($ext), $allowedFormats)) {
            echo "<script>alert('Please upload an image in PNG, JPEG, JPG, WebP, or JFIF format and less than 7MB in size.');</script>";
        } else {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                $imagePathForDB = $uploadDir . $image;
                // Establish database connection ($conn) before this point

                $query = "INSERT INTO advertise (image, heading) VALUES (?, ?)";
                $stmt = mysqli_prepare($conn, $query);

                if ($stmt) {
                    mysqli_stmt_bind_param($stmt, "ss", $imagePathForDB, $heading);
                    if (mysqli_stmt_execute($stmt)) {
                        echo "<script>alert('Advertise Successfully'); window.location.href='view.php?Our_advertise=true';</script>";
                    } else {
                        echo "<script>alert('Error inserting image into database.');</script>";
                    }
                } else {
                    echo "<script>alert('Error preparing statement.');</script>";
                }
            } else {
                echo "<script>alert('Error moving uploaded file.');</script>";
            }
        }
    } else {
        echo "<script>alert('No file uploaded.');</script>";
    }
}
?>



<!-------------------------------------------------------------- Save features---------------------------------------------------------------------------------------------------->

<?php
    if (isset($_POST['save_feature'])) {
        $features = $_POST['features'];
        $package_id = $_POST['package_id'];
        $query = "INSERT INTO packages_details  (features, package_id) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "si", $features, $package_id);
            if (mysqli_stmt_execute($stmt)) {
                echo "<script>";
                echo "alert('Feature Added Successfully');";
                echo "window.location.href='add.php?add_packages_features=true';";
                echo "</script>";
            } else {
                echo "<script>";
                echo "alert('Failed...');";
                echo "window.location.href='add.php?add_packages_features=true;";
                echo "</script>";
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "<script>";
            echo "alert('Database Query Error...');";
            echo "window.location.href='view.php?view_services=true';";
            echo "</script>";
        }
    } 
    ?>


<!-------------------------------------------------------------- Save notifications---------------------------------------------------------------------------------------------------->


<?php

if (isset($_POST['save_notification'])) {
 
    $category_name = mysqli_real_escape_string($conn, $_POST['category_name']);
    $forPackageOwner = mysqli_real_escape_string($conn, $_POST['forPackageOwner']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    $notification_all = mysqli_real_escape_string($conn, $_POST['notification_all']);
    

    $query = "INSERT INTO notification (category_name,forPackageOwner, message, notification_all) VALUES (?, ?, ? , ?)";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
  
        mysqli_stmt_bind_param($stmt, "ssss", $category_name, $forPackageOwner, $message, $notification_all); 
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>";
            echo "alert('Notification Added Successfully');";
            echo "window.location.href='add.php?notification=true';";
            echo "</script>";
        } else {
            echo "<script>";
            echo "alert('Failed to add notification...');";
            echo "window.location.href='add.php?notification=true';";
            echo "</script>";
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "<script>";
        echo "alert('Database Query Error...');";
        echo "window.location.href='view.php?view_services=true';";
        echo "</script>";
    }
} 
?> 



<!-------------------------------------------------------------- Save Category---------------------------------------------------------------------------------------------------->



<?php
if (isset($_POST['reply_message'])) {
    $category_name = $_POST['category_name'];
    $query = "INSERT INTO category (category_name) VALUES (?)";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
       
        mysqli_stmt_bind_param($stmt, "s", $category_name);
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>";
            echo "alert('Category Added Successfully');";
            echo "window.location.href='view.php?view_categories=true';";
            echo "</script>";
        } else {
            echo "<script>";
            echo "alert('Failed...');";
            echo "window.location.href='add.php?add_admin=true';";
            echo "</script>";
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "<script>";
        echo "alert('Database Query Error...');";
        echo "window.location.href='add.php?add_admin=true';";
        echo "</script>";
    }
} 
?>



<!-------------------------------------------------------------- Save f and q ---------------------------------------------------------------------------------------------------->

<?php

if (isset($_POST['save_q_a'])) {
    $question = $_POST['question'];
    $answer = $_POST['answer'];
    
    $query = "INSERT INTO question_answer (question , answer) VALUES (? , ?)";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
       
        mysqli_stmt_bind_param($stmt, "ss", $question , $answer );
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>";
            echo "alert('Q/A Added Successfully');";
            echo "window.location.href='add.php?Q_A=true';";
            echo "</script>";
        } else {
            echo "<script>";
            echo "alert('Failed...');";
            echo "window.location.href='add.php?Q_A=truee';";
            echo "</script>";
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "<script>";
        echo "alert('Database Query Error...');";
        echo "window.location.href='v_admin/add.php?Q_A=true';";
        echo "</script>";
    }
} 
?>


<!----------------------------------------------------------------------terms and condition------------------------------------------------------------------->




<?php
if (isset($_POST['save_terms'])) {
    // Escape special characters from input values
 $heading = $_POST['heading'];
$subheading = $_POST['subheading'];
$description = $_POST['description'];

$query = "INSERT INTO terms_conditions (heading, subheading, description) VALUES (?, ?, ?)";
$stmt = mysqli_prepare($conn, $query);

if ($stmt) {
    // Bind parameters to the prepared statement
    mysqli_stmt_bind_param($stmt, "sss", $heading, $subheading, $description);
    
    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        echo "<script>";
        echo "alert('Terms/Condition Added Successfully');";
        echo "window.location.href='add.php?terms_conditions=true';";
        echo "</script>";
    } else {
        echo "<script>";
        echo "alert('Failed...');";
        echo "window.location.href='view.php?terms_conditions=truee';";
        echo "</script>";
    }
    
    // Close the prepared statement
    mysqli_stmt_close($stmt);
} else {
    echo "<script>";
    echo "alert('Database Query Error...');";
    echo "window.location.href='v_admin/add.php?Q_A=true';";
    echo "</script>";
}

}
?>


<!----------------------------------------------------------------------Refund Policy------------------------------------------------------------------->

<?php
if (isset($_POST['save_refund'])) {
    $heading = $_POST['heading'];
$subheading = $_POST['subheading'];
$description = $_POST['description'];

$query = "INSERT INTO refund_policy (heading, subheading, description) VALUES (?, ?, ?)";
$stmt = mysqli_prepare($conn, $query);

if ($stmt) {
    // Bind parameters to the prepared statement
    mysqli_stmt_bind_param($stmt, "sss", $heading, $subheading, $description);
    
    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        echo "<script>";
        echo "alert('Refund Policy Added Successfully');";
        echo "window.location.href='view.php?refund_policy_view=true';";
        echo "</script>";
    } else {
        echo "<script>";
        echo "alert('Failed...');";
        echo "window.location.href='view.php?refund_policy_view=truee';";
        echo "</script>";
    }
    
    // Close the prepared statement
    mysqli_stmt_close($stmt);
} else {
    echo "<script>";
    echo "alert('Database Query Error...');";
    echo "window.location.href='v_admin/add.php?Q_A=true';";
    echo "</script>";
}

}
?>


<!----------------------------------------------------------------------Refund Policy------------------------------------------------------------------->

<?php
if (isset($_POST['save_privacy'])) {
$heading = $_POST['heading'];
$subheading = $_POST['subheading'];
$description = $_POST['description'];

$query = "INSERT INTO privacy_policy (heading, subheading, description) VALUES (?, ?, ?)";
$stmt = mysqli_prepare($conn, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "sss", $heading, $subheading, $description);
    if (mysqli_stmt_execute($stmt)) {
        echo "<script>";
        echo "alert('Privacy Policy Added Successfully');";
        echo "window.location.href='add.php?privacy_policy=true';";
        echo "</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);
} else {
    echo "<script>";
    echo "alert('Database Query Error...');";
    echo "window.location.href='v_admin/add.php?Q_A=true';";
    echo "</script>";
}

}
?>

<!---------------------------------------------------------------------- Save Admin----------------------------------------------------------------------------------------------- -->

<?php
if (isset($_POST['savw_Admin'])) {
    $admin_name = $_POST['admin_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $admin_type = $_POST['admin_type'];


    $query = "INSERT INTO admin (admin_name, email, password , admin_type) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssss", $admin_name, $email, $password , $admin_type);
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>";
            echo "alert('Admin added successfully!');"; 
            echo "window.location.href='view.php?all_admins=true';";
            echo "</script>";
        } else {
            echo "<script>";
            echo "alert('Failed to add package. Please try again.');";
            echo "window.location.href='add.php?add_admin=true';";
            echo "</script>";
        }
    } else {
        echo "Unable to prepare the query.";
    }
}
?>