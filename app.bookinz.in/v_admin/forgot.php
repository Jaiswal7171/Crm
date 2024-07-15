<?php include "../db.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | Digiboard</title>
    
    <link rel="shortcut icon" href="fa*vicon.png">
    <link rel="stylesheet" href="assets/vendor/css/all.min.css">
    <link rel="stylesheet" href="assets/vendor/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="assets/vendor/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" id="primaryColor" href="assets/css/blue-color.css">
    <link rel="stylesheet" id="rtlStyle" href="#">
</head>
<body class="light-theme">
    <!-- preloader start -->
    <div class="preloader d-none">
        <div class="loader">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <!-- preloader end -->

    <!-- main content start -->
    <div class="main-content login-panel">
        <div class="login-body">
            <div class="top d-flex justify-content-between align-items-center">
                <!-- <div class="logo">
                    <img src="assets/images/logo-black.png" alt="Logo">
                </div> -->
                <a href="http://localhost/15_May_2024/app.bookinz.in/v_admin/login.php"><i class="fa-duotone fa-house-chimney"></i></a>
            </div>
            <div class="bottom">
                <h3 class="panel-title">Reset Password</h3>
                <form method="POST" action="">
                    <div class="input-group mb-25">
                        <span class="input-group-text"><i class="fa-regular fa-envelope"></i></span>
                        <input type="email" class="form-control" name="email" placeholder="Email address" required>
                    </div>

                    <div class="input-group mb-25">
                        <span class="input-group-text"><i class="fa-regular fa-lock"></i></span>
                        <input type="password" class="form-control" name="password" placeholder="New password" required>
                    </div>

                    <div class="input-group mb-25">
                        <span class="input-group-text"><i class="fa-regular fa-key"></i></span>
                        <input type="number" class="form-control" name="token" placeholder="Enter Your token" required>
                    </div>
                    
                    <button class="btn btn-primary w-100 login-btn" value="submit" name="update_password">Reset Password</button>
                </form>
              
            </div>
        </div>

        <!-- footer start -->
        <div class="footer">
            <p>Copyright© <script>document.write(new Date().getFullYear())</script> All Rights Reserved By <span class="text-primary"><a href="">Vyavsaay Digiworld Private Limited</a></span></p>
        </div>
        <!-- footer end -->
    </div>
    <!-- main content end -->
    
    <script src="assets/vendor/js/jquery-3.6.0.min.js"></script>
    <script src="assets/vendor/js/jquery.overlayScrollbars.min.js"></script>
    <script src="assets/vendor/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main.js"></script>
    <!-- for demo purpose -->
    <script>
        var rtlReady = $('html').attr('dir', 'ltr');
        if (rtlReady !== undefined) {
            localStorage.setItem('layoutDirection', 'ltr');
        }
    </script>
    <!-- for demo purpose -->
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_password'])) {
    $email = $_POST['email'];
    $new_password = $_POST['password'];
    $token = $_POST['token'];

    // Sanitize inputs
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $new_password = filter_var($new_password, FILTER_SANITIZE_STRING);
    $token = filter_var($token, FILTER_SANITIZE_STRING);

    // Validate email
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Check if the email exists in the database
        $check_sql = "SELECT token FROM admin WHERE email = ?";
        $stmt_check = $conn->prepare($check_sql);
        $stmt_check->bind_param("s", $email);
        $stmt_check->execute();
        $stmt_check->store_result();

        if ($stmt_check->num_rows > 0) {
            $stmt_check->bind_result($stored_token);
            $stmt_check->fetch();

            // Verify token
            if (password_verify($token, $stored_token)) {
                // Token matched, proceed with password update
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

                // Prepare the SQL statement for password update
                $update_sql = "UPDATE admin SET password = ? WHERE email = ?";
                $stmt_update = $conn->prepare($update_sql);
                $stmt_update->bind_param("ss", $hashed_password, $email);

                // Execute the update statement
                if ($stmt_update->execute()) {
                    echo '<script>
                        alert("Password updated successfully!");
                        window.location.href = "login.php";
                    </script>';
                } else {
                    echo "Error updating password: " . $stmt_update->error;
                }

                // Close the statement
                $stmt_update->close();
            } else {
                echo '<script>
                    alert("Token is not correct!");
                    window.location.href = "forgot.php";
                </script>';
            }
        } else {
            echo '<script>
                alert("Email not found!");
                window.location.href = "forgot.php";
            </script>';
        }

        // Close the statement
        $stmt_check->close();
    } else {
        echo '<script>
            alert("Invalid email format!");
            window.location.href = "forgot.php";
        </script>';
    }

    // Close the database connection
    $conn->close();
}
?>

