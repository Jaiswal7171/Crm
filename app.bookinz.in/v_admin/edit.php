<?php
session_start();
if (!isset($_SESSION["admin_login"]))
    header("location:login.php");
?>

<?php include "header.php"; ?>
<?php include "../db.php"; ?>



<?php
if (isset($_GET['edit_category'])) {
    $id = $_GET['category_id'];
    $query = 'SELECT * FROM category WHERE category_id = ' . $id;
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);


    if (isset($_POST['save_category'])) {
        $category_name = $_POST['category_name'];
  
        $update_query = "UPDATE category SET category_name = '$category_name' WHERE category_id = $id";
        if (mysqli_query($conn, $update_query)) {
            echo '<script>';
            echo 'alert("Category Updated Successfully");';
            echo 'window.location.href="view.php?view_categories=true";';
            echo '</script>';
          
        } else {
            echo "Error updating category: " . mysqli_error($conn);
        }
    }
?>
    <div class="main-content">
        <div class="dashboard-breadcrumb mb-25">
            <h2>Edit Category</h2>
            <div class="btn-box">
                <a href="view.php?view_categories" class="btn btn-sm btn-primary">View All Categories</a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="panel">
                    <div class="panel-header">
                        <h5>Basic Information About Category</h5>
                    </div>
                    <form method="post" enctype="multipart/form-data">
                        <div class="panel-body">
                            <div class="row g-3">
                                <div class="col-xxl-3 col-lg-4 col-sm-6">
                                    <label class="form-label">Category Name</label>
                                    <input type="text" name="category_name" value="<?php echo $row['category_name']; ?>" class="form-control form-control-sm" required>
                                </div>
                                <div class="col-12 d-flex">
                                    <button type="submit" class="btn btn-sm btn btn-success" value="submit" name="save_category">Save Category</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php 
} 

?>








<?php
if (isset($_GET['edit_service'])) {
    $id = $_GET['service_id'];
    $query = 'SELECT * FROM services WHERE service_id = ' . $id;
    $result = mysqli_query($conn, $query); 
    $row = mysqli_fetch_assoc($result); 

  
    if (isset($_POST['save_services'])) {
        $service_name = $_POST['service_name'];

        $update_query = "UPDATE services SET service_name = '$service_name' WHERE service_id = $id";
        if (mysqli_query($conn, $update_query)) {
            echo '<script>';
            echo 'alert("Category Updated Successfully");';
            echo 'window.location.href="view.php?view_services=true";';
            echo '</script>';
          
        } else {
            echo "Error updating category: " . mysqli_error($conn);
        }
    }
?>
    <div class="main-content">
        <div class="dashboard-breadcrumb mb-25">
            <h2>Edit Category</h2>
            <div class="btn-box">
                <a href="view.php?view_categories" class="btn btn-sm btn-primary">View All Categories</a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="panel">
                    <div class="panel-header">
                        <h5>Basic Information About Category</h5>
                    </div>
                    <form method="post" enctype="multipart/form-data">
                        <div class="panel-body">
                            <div class="row g-3">
                                <div class="col-xxl-3 col-lg-4 col-sm-6">
                                    <label class="form-label">Category Name</label>
                                    <input type="text" name="service_name" value="<?php echo $row['service_name']; ?>" class="form-control form-control-sm" required>
                                </div>
                                <div class="col-12 d-flex">
                                    <button type="submit" class="btn btn-sm btn btn-success" value="submit" name="save_services">Save services</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php 
} 
?>

<?php


if (isset($_GET['edit_vendors']) && isset($_GET['vid'])) {

    $result = mysqli_query($conn, "SELECT v.*, 
    c1.category_name AS category_name_1, 
    c2.category_name AS category_name_2,
    c3.category_name AS category_name_3
    FROM vendor_info v
    JOIN category c1 ON v.category_id = c1.category_id
    JOIN category c2 ON v.sec_cat_id = c2.category_id
    JOIN category c3 ON v.ter_cat_id = c3.category_id WHERE vid='" . $_GET['vid'] . "'");
    $row = mysqli_fetch_array($result);

if (isset($_POST['update_vendorinfo'])) {
    // Escape user inputs for security
    $vendor_name = mysqli_real_escape_string($conn, $_POST['vendor_name']);
    $business_name = mysqli_real_escape_string($conn, $_POST['vbiz']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $state = mysqli_real_escape_string($conn, $_POST['state']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $pincode = mysqli_real_escape_string($conn, $_POST['pincode']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $homeService = mysqli_real_escape_string($conn, $_POST['homeService']);
    $whatsapp_number = mysqli_real_escape_string($conn, $_POST['whatsapp_number']);
    $package_id = mysqli_real_escape_string($conn, $_POST['package_id']);
    $package_start_date = mysqli_real_escape_string($conn, $_POST['Package_start_date']);
    $package_end_date = mysqli_real_escape_string($conn, $_POST['Package_end_date']);


    // Check if package_id exists in packages table
    $check_package_query = "SELECT * FROM packages WHERE pid = '$package_id'";
    $check_package_result = mysqli_query($conn, $check_package_query);
    if (mysqli_num_rows($check_package_result) == 0) {
        echo '<script>';
        echo 'alert("Package does not exist. Please select a valid package.");';
        echo 'window.location.href="edit.php?vid=' . $_GET['vid'] . '";'; // Redirect back to edit page
        echo '</script>';
        exit; // Stop further execution
    }



    // Prepare update query
    $update_query = "UPDATE vendor_info SET 
        vendor_name = '$vendor_name', 
        vbiz = '$business_name',
        email = '$email',
        location = '$location',
        city = '$city',
        state = '$state',
        address = '$address',
        pincode = '$pincode',
        phone = '$phone',
        homeService = '$homeService',
        whatsapp_number = '$whatsapp_number',
        package_id = '$package_id',
        Package_start_date = '$package_start_date',
        Package_end_date = '$package_end_date'
        WHERE vid = '" . $_GET['vid'] . "'";

    // Execute update query
    if (mysqli_query($conn, $update_query)) {
        echo '<script>';
        echo 'alert("Vendor Information Updated Successfully");';
        echo 'window.location.href="view.php?view_vendors=true";';
        echo '</script>';
    } else {
        echo "Error updating vendor information: " . mysqli_error($conn);
    }
}
?>
<div class="main-content">
    <div class="dashboard-breadcrumb mb-25">
        <h2>Edit Profile</h2>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="panel">
                <div class="panel-header">
                    <nav>
                        <div class="btn-box d-flex flex-wrap gap-1" id="nav-tab" role="tablist">
                            <a href="view.php?all_vendors=true" class="btn btn-sm btn-outline-primary">View All Vendors</a>
                            <a href="view.php?logoupdate&vid=<?php echo $row['vid']; ?>" class="btn btn-sm btn-outline-primary">Update Logo/Coverimage/qrcode</a>
                        </div>

                        
                    </nav>
                </div>

                <form method="POST" enctype="multipart/form-data">
                        <div class="panel-body">
                            <div class="tab-content profile-edit-tab" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-edit-profile" role="tabpanel" aria-labelledby="nav-edit-profile-tab" tabindex="0">
                                    <div class="profile-edit-tab-title">
                                        <h6>Service Provider Information</h6>
                                    </div>
                                    <div class="public-information mb-25">
                                        <div class="row g-4">
                                            <div class="col-md-3">
                                                <div class="admin-profile">
                                                     <div class="image-wrap">
                                                        <div class="part-img rounded-circle overflow-hidden">
                                                        <img class="img-fluid" src="../../gallery/vendor_logo/<?php echo $row['vendor_logo']; ?>" alt="admin"style="height:100px; padding=60px">
                                                        </div>
                                                    </div>
                                                     <span class="admin-name">VendorLogo</span>

                                               
                                                  
                                                    
                                                  
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="row g-3">
                                                    <div class="col-sm-6">
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i class='fas fa-store-alt'></i></span>
                                                            <input type="text" name="vendor_name" class="form-control" placeholder="Username" title="VendorName"  value="<?php echo $row['vendor_name']; ?>" >
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i class="fa fa-link fa-rotate-45" style="font-size:1.5em"></i></span>
                                                            <input type="text" name="vbiz" class="form-control" placeholder="Username" title="BusinessName"  value="<?php echo $row['vbiz']; ?>" >
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">


                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="far fa-address-card"></i></span>
                                                        <select name="homeService" class="form-control" id="homeService" aria-labelledby="homeServiceLabel" title="Choose ServiceType">
                                                        <option value="0" <?php echo ($row['homeService'] == 0) ? 'selected' : ''; ?>>Only Home</option>
                                                        <option value="1" <?php echo ($row['homeService'] == 2) ? 'selected' : ''; ?>>Onsite</option>
                                                        <option value="2" <?php echo ($row['homeService'] == 1) ? 'selected' : ''; ?>>Both</option>
                                                    </select>
                                                    </div>



                                                </div>

                                                    <div class="col-sm-6">
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i class="far fa-address-card"></i></span>
                                                            <input type="text" name="email" class="form-control" placeholder="Username" title="Email"  value="<?php echo $row['email']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i class="far fa-address-card"></i></span>
                                                            <input type="text" name="phone" class="form-control" placeholder="Contact" title="Contact No"  value="<?php echo $row['phone']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i class="far fa-address-card"></i></span>
                                                            <input type="text" name="whatsapp_number" class="form-control" title="Another Contact No" placeholder="Username" value="<?php echo $row['whatsapp_number']; ?>">                                               </div>
                                                    </div>  
                                                    <div class="col-sm-12">
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i class="far fa-address-card"></i></span>
                                                            <input type="text" name="url" class="form-control" title="url" placeholder="Username" value="<?php echo $row['url']; ?>" readonly>                                               </div>
                                                    </div>  
              

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    
                                    <div class="profile-edit-tab-title">
                            <h6>Private Information</h6>
                        </div><br>
                        <div class="private-information mb-25">
                            <div class="row g-3">
                                <div class="col-xxl-3 col-lg-4 col-sm-6">
                                    <label class="form-label">City</label>
                                    <input type="text" name="city"
                                        value="<?php echo $row['city']; ?> "
                                        class="form-control form-control-sm" >
                                </div>

                                <div class="col-xxl-3 col-lg-4 col-sm-6">
                                    <label class="form-label">state</label>
                                    <input type="text" name="state"
                                        value="<?php echo $row['state']; ?>"
                                        class="form-control form-control-sm" >
                                </div>


                                <div class="col-xxl-3 col-lg-4 col-sm-6">
                                    <label class="form-label">Location</label>
                                    <input type="text" name="location"
                                        value="<?php echo $row['location']; ?>"
                                        class="form-control form-control-sm" >
                                </div>


                                <div class="col-xxl-3 col-lg-4 col-sm-6">
                                    <label class="form-label"> Address</label>
                                    <input type="text" name="address"
                                        value="<?php echo $row['address']; ?>"
                                        class="form-control form-control-sm" >
                                </div>


                                <div class="col-xxl-3 col-lg-4 col-sm-6">
                                    <label class="form-label">pincode</label>
                                    <input type="text" name="pincode" value="<?php echo $row['pincode']; ?>"
                                        class="form-control form-control-sm" >
                                </div>

                                <div class="col-xxl-3 col-lg-4 col-sm-6">
                                    <label class="form-label">Catgory_A</label>
                                    <input type="text" name="category_name_1" value="<?php echo $row['category_name_1']; ?>"
                                        class="form-control form-control-sm" >
                                </div>


                                <div class="col-xxl-3 col-lg-4 col-sm-6">
                                    <label class="form-label">Category_B</label>
                                    <input type="text" name="category_name_2" value="<?php echo $row['category_name_2']; ?>"
                                        class="form-control form-control-sm" readonly>
                                </div>



                                <div class="col-xxl-3 col-lg-4 col-sm-6">
                                    <label class="form-label">Category_C</label>
                                    <input type="text" name="category_name_3" value="<?php echo $row['category_name_3']; ?>"
                                        class="form-control form-control-sm" readonly>
                                </div>
                                
                                
                                <div class="col-xxl-3 col-lg-4 col-sm-6">
                                    <label class="form-label">Package StartDate</label>
                                    <input type="text" name="Package_start_date" value="<?php echo $row['Package_start_date']; ?>"
                                        class="form-control form-control-sm" >
                                </div>
                                
                                
                                <div class="col-xxl-3 col-lg-4 col-sm-6">
                                    <label class="form-label">Package EndDate</label>
                                    <input type="text" name="Package_end_date" value="<?php echo $row['Package_end_date']; ?>"
                                        class="form-control form-control-sm" >
                                </div>

                             


                                    <?php
                    $vid = $_GET['vid']; 
                    $sql = "SELECT packages.package_name
                            FROM vendor_info
                            INNER JOIN packages ON vendor_info.package_id = packages.pid
                            WHERE vendor_info.vid = $vid";

                    $result = mysqli_query($conn, $sql);
                    $package_name = "";
                    if ($result && mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                        $package_name = htmlspecialchars($row['package_name']);
                    }
                    ?>



                    <?php

                    $query = "SELECT pid, package_name FROM packages"; // Retrieve both pid and package_name
                    $result = mysqli_query($conn, $query);

                    if ($result && mysqli_num_rows($result) > 0) {
                        ?>
                        <div class="col-xxl-3 col-lg-4 col-sm-6">
                            <label class="form-label">Package Type</label>
                            <select name="package_id" class="form-control form-control-sm">
                                <?php
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $pid = htmlspecialchars($row['pid']);
                                    $packageName = htmlspecialchars($row['package_name']);
                                    $selected = ($packageName == $package_name) ? 'selected' : ''; // Check against the current package_name
                                    echo "<option value='$pid' $selected>$packageName</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <?php
                    }
                    ?>


                               

                 </div><br><br>
                            <div class="col-12">
                            </div>
                        </div>
                    </div>
                    <button type="submit" name="update_vendorinfo" class="btn btn-primary">Update</button>
                </form>                                  
            </div>
        </div>
    </div>
</div>

<?php
}
?>





<!-----------------------------------------------edit_notification--------------------------------------------------------------------------------------------------------------------->

<?php
if (isset($_GET['edit_notification'])) {
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        echo "Invalid notification ID";
        exit;
    }

    $id = $_GET['id'];
    $query = "SELECT * FROM notification WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (!$result || mysqli_num_rows($result) == 0) {
        echo "Notification not found";
        exit;
    }

    $row = mysqli_fetch_assoc($result);

    if (isset($_POST['save_notification'])) {
        $message = htmlspecialchars($_POST['message']);

        $update_query = "UPDATE notification SET message = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $update_query);
        mysqli_stmt_bind_param($stmt, "si", $message, $id);

        if (mysqli_stmt_execute($stmt)) {
            echo '<script>';
            echo 'alert("Notification Updated Successfully");';
            echo 'window.location.href="view.php?notifications=true";';
            echo '</script>';
            exit;
        } else {
            echo "Error updating notification: " . mysqli_error($conn);
        }
    }
?>
    <div class="main-content">
        <div class="dashboard-breadcrumb mb-25">
            <h2>Edit Notification</h2>  
            <div class="btn-box">
                <a href="add.php?notification" class="btn btn-sm btn-primary">Add Notification</a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="panel">
                    <div class="panel-header">
                        <h5>Customize Your Notifications!</h5>
                    </div>
                    <form method="post" enctype="multipart/form-data">
                        <div class="panel-body">
                            <div class="row g-3">
                                <div class="col-xxl-3 col-lg-4 col-sm-6">
                                    <label class="form-label">Notification Message</label>
                                    <input type="text" name="message" value="<?php echo htmlspecialchars($row['message']); ?>" class="form-control form-control-sm" required>
                                </div>
                                <div class="col-12 d-flex">
                                    <button type="submit" class="btn btn-sm btn btn-success" value="submit" name="save_notification">Save Notification</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php 
} 
?>




<!-----------------------------------------------update_help--------------------------------------------------------------------------------------------------------------------->


<?php

if (isset($_POST['update_help'])) { 
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $status = $_POST['status'];
        $new_status = $status == 0 ? 1 : 0;
        $update_query = "UPDATE help_support SET status = '$new_status' WHERE id = $id";
        if (mysqli_query($conn, $update_query)) {
            echo '<script>';
            echo 'alert("Status Updated Successfully");';
            echo 'window.location.href="view.php?help_support=true";';
            echo '</script>';
        } else {
            echo "Error updating status: " . mysqli_error($conn);
        }
    }
}
?>


<!--------------------------------------------------------- Edit Packages---------------------------------------------------------------------------- -->



<?php
if (isset($_GET['edit_packages'])) {
    $id = $_GET['pid']; 
    $query = 'SELECT * FROM packages WHERE pid = ' . $id;
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    if (isset($_POST['edit_packgaes'])) {
        $package_name = $_POST['package_name'];
        $package_price_1yr = $_POST['package_price_1yr'];
        $package_price_3yr = $_POST['package_price_3yr'];
        $package_duration_3yr = $_POST['package_duration_3yr'];
        $package_duration_1yr = $_POST['package_duration_1yr'];

        $update_query = "UPDATE packages SET package_name = '$package_name', package_price_1yr = '$package_price_1yr', package_price_3yr = '$package_price_3yr', package_duration_3yr = '$package_duration_3yr' , package_duration_1yr = '$package_duration_1yr' WHERE pid = $id";
        if (mysqli_query($conn, $update_query)) {
            echo '<script>';
            echo 'alert("Package Updated Successfully");';
            echo 'window.location.href="view.php?packages=true";';
            echo '</script>';
        } else {
            echo "Error updating package: " . mysqli_error($conn);
        }
    }
?>

<div role="main" class="main-content">
    <div aria-describedby="breadcrumb" class="dashboard-breadcrumb mb-25">
        <h2 id="breadcrumb">Packages</h2>
        <div class="btn-box">
            <a href="view.php?packages=true" class="btn btn-sm btn-primary">View All Packages</a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="panel">
                <div class="panel-header">
                    <h5>Edit Packages</h5>
                </div>
                <form method="post" enctype="multipart/form-data" name="edit_package">
                    <div class="panel-body">
                        <div class="row g-3">
                            <div class="col-xxl-3 col-lg-4 col-sm-6">
                                <label for="package_type" class="form-label">Package Name</label>
                                <input type="text" name="package_name" id="package_type" value="<?php echo $row['package_name']; ?>" class="form-control form-control-sm" required>
                            </div>

                            <div class="col-xxl-3 col-lg-4 col-sm-6">
                                <label for="package_price" class="form-label">Package Price For 1st Year</label>
                                <input type="text" name="package_price_1yr" id="package_price" value="<?php echo $row['package_price_1yr']; ?>" class="form-control form-control-sm" required>
                            </div>

                            <div class="col-xxl-3 col-lg-4 col-sm-6">
                                <label for="package_duration_3yrs" class="form-label">Package Price For 3 Year</label>
                                <input type="text" name="package_price_3yr" id="package_duration_3yrs" value="<?php echo $row['package_price_3yr']; ?>" class="form-control form-control-sm" required>
                            </div>

                         

                            <div class="col-xxl-3 col-lg-4 col-sm-6">
                                <label for="package_duration_3yr" class="form-label">Package Duration 1st Year</label>
                                <input type="text" name="package_duration_3yr" id="package_duration_3yr" value="<?php echo $row['package_duration_3yr']; ?>" class="form-control form-control-sm" required>
                            </div>

                            <div class="col-xxl-3 col-lg-4 col-sm-6">
                                <label for="package_duration_1yr" class="form-label">Package Duration For 3 Year</label>
                                <input type="text" name="package_duration_1yr" id="package_duration_1yr" value="<?php echo $row['package_duration_1yr']; ?>" class="form-control form-control-sm" required>
                            </div>

                            <div class="col-12 d-flex">
                                <button type="submit" class="btn btn-sm btn-success" value="submit" name="edit_packgaes">Save Package</button>
                                &nbsp;<a href="" class="btn btn-sm btn-warning">Edit Features Not Available !</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
}
?>





<!---------------------------------------------------------====================update_status======================================---------------------------------------------------------------------------- -->

<?php
if (isset($_POST['update_status'])) {
    $id = $_POST['id'];
    $stmt = $conn->prepare("UPDATE help_support SET status = 1 WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    echo '<script>';
    echo 'alert("Status Updated Successfully");'; 
    echo 'window.location.href="view.php?help_support=true";'; 
    echo '</script>';
}
?>



<!---------------------------------------------------------====================view_help======================================---------------------------------------------------------------------------- -->


<?php

if (isset($_GET['view_help'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $result = mysqli_query($conn, "SELECT * FROM help_support WHERE id = $id");
    $row = mysqli_fetch_array($result);
    if (isset($_POST['update_message'])) {
     $resolve_answer = mysqli_real_escape_string($conn, $_POST['resolve_answer']);
      $updateQuery = "UPDATE help_support SET resolve_answer = '$resolve_answer', status = 1 WHERE id = $id";
        mysqli_query($conn, $updateQuery);
        if (mysqli_affected_rows($conn) > 0) {
         
            echo "<script>";
            echo "alert('Updated');";
            echo "window.location.href='view.php?help_support=true';";
            echo "</script>";
        } else {
       
            echo "Update failed!";
        }
    }

?>

<div class="main-content">
    <div class="dashboard-breadcrumb mb-25">
        <h2>Help & Support </h2>
        
    </div>
    <div class="row">
        <div class="col-12">
            <div class="panel">
                <div class="panel-header">
                    <h5>*************** </h5>
                </div>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="panel-body">
                        <div class="row g-3">
                            <div class="col-xxl-3">
                                <label class="form-label">Query :-</label>
                                <textarea rows="4" cols="120" name="message" class="form-control form-control-sm" readonly><?php echo $row['message']; ?></textarea>
                            </div>
                            <input  name="id" value="<?php echo $id; ?>">
                            
                            <div class="col-xxl-3">
                                <label class="form-label">Soloution.</label>
                                <textarea rows="4" cols="120" name="resolve_answer" class="form-control form-control-sm"><?php echo $row['resolve_answer']; ?></textarea>
                            </div>
                            <div class="col-12 d-flex">
                                <button type="submit" class="btn btn-sm btn btn-success" name="update_message">Update</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<?php

}
?>


<!-- add  -->
<?php 
if (isset($_GET['edit_qa'])) {
    // Ensure that $id is properly sanitized to prevent SQL injection
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    
    // Fetch the row with the specified id
    $result = mysqli_query($conn, "SELECT * FROM question_answer WHERE id = $id");
    $row = mysqli_fetch_array($result);

    if(isset($_POST['data'])) {
        $question = $_POST['question'];
        $answer = $_POST['answer'];

        // Update query with specific column names
        $updateQuery = "UPDATE question_answer SET question = ?, answer = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $updateQuery);
        
        mysqli_stmt_bind_param($stmt, "ssi", $question, $answer, $id); 
        if(mysqli_stmt_execute($stmt)) {
            echo "<script type='text/javascript'>";
            echo "alert('Message Update Successful');";
            echo "window.location = 'view.php?question_answer=true';";
            echo "</script>";
        } else {
            echo "Update failed: " . mysqli_error($conn);
        }
    }
?>


<div class="main-content">
    <div class="dashboard-breadcrumb mb-25">
        <h2>Question /Answer</h2>
        <div class="btn-box">
            <a href="index.php" class="btn btn-sm btn-primary">Home Page</a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="panel">
                <div class="panel-header">
                    <h5>Update Question /Answer </h5>
                </div>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="panel-body">
                        <div class="row g-3">

                        <div class="col-12">
                    <label for="package_type" class="form-label">Question :</label>
                    <input type="text" name="question" id="features" value="<?php echo $row['question']; ?>" class="form-control form-control-sm" required>
                </div>

                <div class="col-12">
                    <label class="form-label">Answer :</label>
                    <textarea rows="8" cols="150" name="answer" class="form-control form-control-sm"><?php echo $row['answer']; ?></textarea>
                </div>



                            <br><br><br><br><br><br><br><br><br>
                            <div class="col-12 d-flex">
                                <button type="submit" class="btn btn-sm btn btn-success" name="data">Update</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
}


?>

<!--edit terms and conditions -->


<?php
if (isset($_GET['edit_terms'])) {
 $id = mysqli_real_escape_string($conn, $_GET['id']);
$query = "SELECT * FROM terms_conditions WHERE id = $id";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

if (isset($_POST['save_terms'])) {
    $heading = $_POST['heading'];
    $subheading = $_POST['subheading'];
    $description = $_POST['description'];

    // Sanitize input to prevent SQL injection
    $heading = mysqli_real_escape_string($conn, $heading);
    $subheading = mysqli_real_escape_string($conn, $subheading);
    $description = mysqli_real_escape_string($conn, $description);

    $update_query = "UPDATE terms_conditions SET heading = '$heading', subheading = '$subheading', description = '$description' WHERE id = $id";

    if (mysqli_query($conn, $update_query)) {
        echo '<script>';
        echo 'alert("Data Updated Successfully");';
        echo 'window.location.href="add.php?terms_conditions=true";';
        echo '</script>';
    } else {
        echo "Error updating data: " . mysqli_error($conn);
    }
}
?>
<div class="main-content">
    <div class="dashboard-breadcrumb mb-25">
        <h2>Edit Terms/Condition</h2>
        <div class="btn-box">
            <a href="add.php?terms_conditions=true" class="btn btn-sm btn-primary">View All Terms/Condition</a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="panel">
                <div class="panel-header">
                    <h5>Basic Information About Terms/Condition</h5>
                </div>
                <form method="post" enctype="multipart/form-data" action="">
                    <div class="panel-body">
                        <div class="col-xxl-3 col-lg-4 col-sm-6">
                            <label class="form-label">Add Heading</label>
                            <input type="text" name="heading" value="<?php echo $row['heading'];?>" class="form-control form-control-sm">
                        </div>

                        <div class="col-xxl-3 col-lg-4 col-sm-6">
                            <label class="form-label">Add Subheading</label>
                            <input type="text" name="subheading" value="<?php echo $row['subheading'];?>" class="form-control form-control-sm">
                        </div>

                        <div class="col-xxl-3">
                            <label class="form-label">Description</label>
                            <textarea rows="8" cols="150" name="description" class="form-control form-control-sm"><?php echo $row['description'];?></textarea>
                        </div>
                        <div class="col-12 d-flex">
                            <button type="submit" class="btn btn-sm btn btn-success" value="submit" name="save_terms">Save Terms/Condition</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
}
?>



<!------------------------------------------------------------------------------------------------>

<?php
if (isset($_GET['edit_refund'])) {
 $id = mysqli_real_escape_string($conn, $_GET['id']);
 $query = "SELECT * FROM refund_policy WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    if (isset($_POST['save_refund'])) {
        $heading = $_POST['heading'];
        $subheading = $_POST['subheading'];
        $description = $_POST['description'];

        // Sanitize input to prevent SQL injection
        $heading = mysqli_real_escape_string($conn, $heading);
        $subheading = mysqli_real_escape_string($conn, $subheading);
        $description = mysqli_real_escape_string($conn, $description);

        $update_query = "UPDATE refund_policy SET heading = '$heading', subheading = '$subheading', description = '$description' WHERE id = $id";

        if (mysqli_query($conn, $update_query)) {
            echo '<script>';
            echo 'alert("Data Updated Successfully");';
            echo 'window.location.href="view.php?refund_policy_view";';
            echo '</script>';
        } else {
            echo "Error updating data: " . mysqli_error($conn);
        }
}

?>
<div class="main-content">
    <div class="dashboard-breadcrumb mb-25">
        <h2>Edit Refund Policy</h2>
        <div class="btn-box">
            <a href="view.php?refund_policy_view=true" class="btn btn-sm btn-primary">View All Refund Policy</a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="panel">
                <div class="panel-header">
                    <h5>Basic Information About RefundPolicy</h5>
                </div>
                <form method="post" enctype="multipart/form-data" action="">
                    <div class="panel-body">
                        <div class="col-xxl-3 col-lg-4 col-sm-6">
                            <label class="form-label">Add Heading</label>
                            <input type="text" name="heading" value="<?php echo $row['heading'];?>" class="form-control form-control-sm">
                        </div><br>

                        <div class="col-xxl-3 col-lg-4 col-sm-6">
                            <label class="form-label">Add Subheading</label>
                            <input type="text" name="subheading" value="<?php echo $row['subheading'];?>" class="form-control form-control-sm">
                        </div><br>

                        <div class="col-xxl-3">
                            <label class="form-label">Description</label>
                            <textarea rows="8" cols="150" name="description" class="form-control form-control-sm"><?php echo $row['description'];?></textarea>
                        </div><br>
                        <div class="col-12 d-flex">
                            <button type="submit" class="btn btn-sm btn btn-success" value="submit" name="save_refund">Save RefundPolicy</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
}
?>




<?php
if (isset($_GET['edit_privacy'])) {
 $id = mysqli_real_escape_string($conn, $_GET['id']);
$query = "SELECT * FROM privacy_policy WHERE id = $id";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

if (isset($_POST['save_privacy'])) {
    $heading = $_POST['heading'];
    $subheading = $_POST['subheading'];
    $description = $_POST['description'];

    // Sanitize input to prevent SQL injection
    $heading = mysqli_real_escape_string($conn, $heading);
    $subheading = mysqli_real_escape_string($conn, $subheading);
    $description = mysqli_real_escape_string($conn, $description);

    $update_query = "UPDATE privacy_policy SET heading = '$heading', subheading = '$subheading', description = '$description' WHERE id = $id";

    if (mysqli_query($conn, $update_query)) {
        echo '<script>';
        echo 'alert("Data Updated Successfully");';
        echo 'window.location.href="add.php?privacy_policy=true";';
        echo '</script>';
    } else {
        echo "Error updating data: " . mysqli_error($conn);
    }
}


?>
<div class="main-content">
    <div class="dashboard-breadcrumb mb-25">
        <h2>Edit privacy_policy</h2>
        <div class="btn-box">
            <a href="add.php?privacy_policy=true" class="btn btn-sm btn-primary">View All Privacy Policy</a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="panel">
                <div class="panel-header">
                    <h5>Basic Information About Privacy Policy</h5>
                </div>
                <form method="post" enctype="multipart/form-data" action="">
                    <div class="panel-body">
                        <div class="col-xxl-3 col-lg-4 col-sm-6">
                            <label class="form-label">Add Heading</label>
                            <input type="text" name="heading" value="<?php echo $row['heading'];?>" class="form-control form-control-sm">
                        </div><br>

                        <div class="col-xxl-3 col-lg-4 col-sm-6">
                            <label class="form-label">Add Subheading</label>
                            <input type="text" name="subheading" value="<?php echo $row['subheading'];?>" class="form-control form-control-sm">
                        </div><br>

                        <div class="col-xxl-3">
                            <label class="form-label">Description</label>
                            <textarea rows="8" cols="150" name="description" class="form-control form-control-sm"><?php echo $row['description'];?></textarea>
                        </div><br>
                        <div class="col-12 d-flex">
                            <button type="submit" class="btn btn-sm btn btn-success" value="submit" name="save_privacy">Save PrivacyPolicy</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
}
?>



<!-- Edit Admin -->



<?php
if (isset($_GET['edit_admin'])) {
    $id = intval($_GET['id']); // Sanitize input
    $query = 'SELECT * FROM admin WHERE id = ?';
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    if (isset($_POST['update_admin'])) {
        $admin_name = mysqli_real_escape_string($conn, $_POST['admin_name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);

        $update_query = "UPDATE admin SET admin_name = ?, email = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $update_query);
        mysqli_stmt_bind_param($stmt, 'ssi', $admin_name, $email, $id);
        
        if (mysqli_stmt_execute($stmt)) {
            echo '<script>';
            echo 'alert("Admin Updated Successfully");';
            echo 'window.location.href="view.php?all_admins=true";';
            echo '</script>';
        } else {
            echo "Error updating admin: " . mysqli_error($conn);
        }
    }
?>
    <div class="main-content">
        <div class="dashboard-breadcrumb mb-25">
            <h2>Edit Admin</h2>
            <div class="btn-box">
                <a href="view.php?all_admins" class="btn btn-sm btn-primary">View All Admin</a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="panel">
                    <div class="panel-header">
                        <h5>Basic Information About Admin</h5>
                    </div>
                    <form method="post" enctype="multipart/form-data">
                        <div class="panel-body">
                            <div class="row g-3">
                                <div class="col-xxl-3 col-lg-4 col-sm-6">
                                    <label class="form-label">Admin Name</label>
                                    <input type="text" name="admin_name" value="<?php echo htmlspecialchars($row['admin_name']); ?>" class="form-control form-control-sm" required>
                                </div>

                                <div class="col-xxl-3 col-lg-4 col-sm-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" class="form-control form-control-sm" required>
                                </div>

                                <div class="col-xxl-3 col-lg-4 col-sm-6">
                                    <label class="form-label">Passowrd</label>
                                    <input type="text" name="password" value="***" class="form-control form-control-sm" required readonly>
                                </div>


                                <div class="col-xxl-3 col-lg-4 col-sm-6">
                                    <label class="form-label">Token</label>
                                    <input type="text" name="token" value="***" class="form-control form-control-sm" required readonly>
                                </div>
                                
                                <div class="col-12 d-flex">
                                    <button type="submit" class="btn btn-sm btn-success" name="update_admin">Save Admin</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php 
}
?>



<?php
include "footer.php"; 
?>