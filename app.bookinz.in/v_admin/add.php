<?php
session_start();
if (!isset($_SESSION["admin_login"]))
    header("location:login.php");
?>

<?php include "header.php"; ?>
<?php include "../db.php"; ?>


<!--------------------------------------------------------------------- add category form----------------------------------------------------------------------------------------- -->


<?php
if (isset($_GET['add_categories'])) {
    ?>
    <div class="main-content">
        <div class="dashboard-breadcrumb mb-25">
            <h2>Add Category</h2>
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
                    <form action="config.php" method="POST" enctype="multipart/form-data">

                        <div class="panel-body">
                            <div class="row g-3">

                            <?php
                        $sql_count = "SELECT COUNT(*) AS count FROM category";
                             $result_count = mysqli_query($conn, $sql_count);

                            if ($result_count) {
                                $count_row = mysqli_fetch_assoc($result_count);
                                $count = $count_row['count'];
                                $add = $count + 1;

                            }
                            ?>

                                <div class="col-xxl-3 col-lg-4 col-sm-6">
                                    <label class="form-label">Category No / ID</label>
                                    <input type="text"  value=<?php echo $add; ?> class="form-control form-control-sm" readonly>
                                </div>

                                <div class="col-xxl-3 col-lg-4 col-sm-6">
                                    <label class="form-label">Category Name</label>
                                    <input type="text" name="category_name" class="form-control form-control-sm" required>
                                </div>
                                <br><br>
                                <div class="col-12 d-flex">
                                    <button class="btn btn-sm btn btn-success" value="submit" name="save_category">Save
                                        Category</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php } ?>

<!------------------------------------------------------------------------------------ Add Services------------------------------------------------------------------------------------------------------------------>

<?php
if (isset($_GET['add_services'])) {
    ?>
    <div class="main-content">
        <div class="dashboard-breadcrumb mb-25">
            <h2>Add Services</h2>
            <div class="btn-box">
                <a href="view.php?view_services=true" class="btn btn-sm btn-primary">Categorywise Services</a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="panel">
                    <div class="panel-header">
                        <h5>Basic Information About Services</h5>
                    </div>
                    <form action="config.php" method="POST" enctype="multipart/form-data">

                        <div class="panel-body">
                            <div class="row g-3">

                            <?php
                        $sql_count = "SELECT COUNT(*) AS count FROM services";
                             $result_count = mysqli_query($conn, $sql_count);

                            if ($result_count) {
                                $count_row = mysqli_fetch_assoc($result_count);
                                $count = $count_row['count'];
                                $add = $count + 1;

                    }
                    ?>

                                <div class="col-xxl-3 col-lg-4 col-sm-6">
                                    <label class="form-label">Service No / ID</label>
                                    <input type="text"  value=<?php echo $add; ?> class="form-control form-control-sm" readonly>
                                </div>


                                <div class="col-xxl-3 col-lg-4 col-sm-6">
                                    <label class="form-label">Service Name</label>
                                    <input type="text" name="service_name" class="form-control form-control-sm" required>
                                </div>


                                
                                <div class="col-xxl-3 col-lg-4 col-sm-6">
                            <label class="form-label">Select a Category</label>
                            <select name="category_id" class="form-control form-control-sm" required>
                                <option value="" disabled selected>Select a category</option>
                                <?php
                                $query = "SELECT category_id, category_name FROM category";
                                $result = mysqli_query($conn, $query);

                                if ($result) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $category_id = $row['category_id']; 
                                        $category_name = $row['category_name'];
                                        echo "<option value='$category_id'>$category_name</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>

                                <br><br>
                                <div class="col-12 d-flex">
                                    <button class="btn btn-sm btn btn-success" value="submit" name="save_services">Save
                                    Service</button> &nbsp; 
                                    <a href="view.php?view_services_all" class="btn btn-warning" value="submit" name="">View All Services
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>  
            </div>
        </div>
    </div>

<?php } ?>



<!------------------------------------------------------------------------------------ Add Packages------------------------------------------------------------------------------------------------------------------>



<?php
if (isset($_GET['add_packages'])) {
    ?>
    <div class="main-content">
        <div class="dashboard-breadcrumb mb-25">
            <h2>Add Packages</h2>
            <div class="btn-box">
                <a href="view.php?packages" class="btn btn-sm btn-primary">View All Packages</a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="panel">
                    <div class="panel-header">
                        <h5>Basic Information About Package</h5>
                    </div>
                    <form action="config.php" method="POST" enctype="multipart/form-data">

                        <div class="panel-body">
                            <div class="row g-3">

                            
                            <?php
                        $sql_count = "SELECT COUNT(*) AS count FROM packages";
                             $result_count = mysqli_query($conn, $sql_count);

                            if ($result_count) {
                                $count_row = mysqli_fetch_assoc($result_count);
                                $count = $count_row['count'];
                                $add = $count + 1;

                    }
                    ?>

                                <div class="col-xxl-3 col-lg-4 col-sm-6">
                                    <label class="form-label">Package No</label>
                                    <input type="text"   value="<?php echo $add?>"  class="form-control form-control-sm" required readonly>
                                </div>

                                 
                                <div class="col-xxl-3 col-lg-4 col-sm-6">
                                    <label class="form-label">Package Name</label>
                                    <input type="text" name="package_name" class="form-control form-control-sm" required>
                                </div>


                               
                                <div class="col-xxl-3 col-lg-4 col-sm-6">
                                    <label class="form-label">Package Price [ For 1st Year ]</label>
                                    <input type="number" name="package_price_1yr" class="form-control form-control-sm" required>
                                </div>

                                <div class="col-xxl-3 col-lg-4 col-sm-6">
                                    <label class="form-label">Package Duration [ For 1 Year]</label>
                                    <input type="number" name="package_duration_1yr" class="form-control form-control-sm" required>
                                </div>


                                <div class="col-xxl-3 col-lg-4 col-sm-6">
                                <label class="form-label">Package Price [ For 3 Year ]</label>
                                    <input type="number" name="package_price_3yr" class="form-control form-control-sm" required>
                                </div>
                               
                                <div class="col-xxl-3 col-lg-4 col-sm-6">
                                <label class="form-label">Package Duration [ For 3 Year]</label>
                                    <input type="number" name="package_duration_3yr" class="form-control form-control-sm" required>
                                </div>
                                <br><br>

                                <div class="col-12 d-flex">
                                    <button class="btn btn-sm btn btn-success" value="submit" name="save_packages">Save
                                        Package</button>
                                </div>


                            </div>
                        </div>
                    </form>
                </div>
            </div>



        </div>




    </div>

<?php } ?>

<!------------------------------------------------------------------------------------ Add package Features------------------------------------------------------------------------------------------------------------------>


<?php
if (isset($_GET['add_packages_features'])) {
    ?>
    <div class="main-content">
        <div class="dashboard-breadcrumb mb-25">
            <h2>Add Package Features</h2>
            <div class="btn-box">
                <a href="view.php?packages=true" class="btn btn-sm btn-primary">View All Packages</a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="panel">
                    <div class="panel-header">
                        <h5>Add Information About Features</h5>
                    </div>
                    <form action="config.php" method="POST" enctype="multipart/form-data">

                        <div class="panel-body">
                            <div class="row g-3">

                            <?php
                        $sql_count = "SELECT COUNT(*) AS count FROM packages_details";
                             $result_count = mysqli_query($conn, $sql_count);

                            if ($result_count) {
                                $count_row = mysqli_fetch_assoc($result_count);
                                $count = $count_row['count'];
                                $add = $count + 1;

                    }
                    ?>

                                <div class="col-xxl-3 col-lg-4 col-sm-6">
                                    <label class="form-label">Feature No :- </label>
                                    <input type="text"  value=<?php echo $add; ?> class="form-control form-control-sm" readonly>
                                </div>


                                <div class="col-xxl-3 col-lg-4 col-sm-6">
                                    <label class="form-label">Feature Name</label>
                                    <input type="text" name="features" class="form-control form-control-sm" required>
                                </div>


                                
                                <div class="col-xxl-3 col-lg-4 col-sm-6">
                                    <label class="form-label">Select a Package</label>
                                    <select name="package_id" class="form-control form-control-sm">
                                        <?php
                                        $query = "SELECT * FROM packages";
                                        $result = mysqli_query($conn, $query);

                                        if ($result) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $id = $row['pid']; 
                                                $package_type = $row['package_name'];
                                                echo "<option value='$id'>$package_type</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>

                               
                                <br><br>
                                <div class="col-12 d-flex">
                                    <button class="btn btn-sm btn btn-success" value="submit" name="save_feature">Save
                                    Feature</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>  
            </div>
        </div>
    </div>

<?php } ?>





<!---------------------------------------------------------------------Add terms & Condiotion--------------------------------------------------------------------------- -->

<?php
// Include your database connection file or establish a connection here

if (isset($_GET['terms_conditions'])) {
?>
<div class="main-content">
    <div class="dashboard-breadcrumb mb-25">
        <h2>Terms / Conditions</h2>
        <div class="btn-box">
            <a href="index.php" class="btn btn-sm btn-primary">Home Page</a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="panel">
                <div class="panel-header">
                   
                </div>
                <form action="config.php" method="POST" enctype="multipart/form-data">
                    <div class="panel-body">
                        <div class="row g-3">
                            <?php
                            // Assuming $conn is your database connection object
                            $sql_count = "SELECT COUNT(*) AS count FROM terms_conditions";
                            $result_count = mysqli_query($conn, $sql_count);

                            if ($result_count) {
                                $count_row = mysqli_fetch_assoc($result_count);
                                $count = $count_row['count'];
                                $add = $count + 1;
                            }
                            ?>

                            <div class="col-xxl-3 col-lg-4 col-sm-6">
                                <label class="form-label">No :</label>
                                <input type="text" value="<?php echo $add; ?>" class="form-control form-control-sm" required>
                            </div>

                            <div class="col-xxl-3 col-lg-4 col-sm-6">
                                <label class="form-label">Add Heading</label>
                                <input type="text" name="heading" class="form-control form-control-sm" required>
                            </div>

                            <div class="col-xxl-3 col-lg-4 col-sm-6">
                                <label class="form-label">Add Subheading</label>
                                <input type="text" name="subheading" class="form-control form-control-sm" required>
                            </div>

                            <div class="col-xxl-3">
                                <label class="form-label">Description</label>
                                <textarea rows="8" cols="150" name="description" class="form-control form-control-sm" required></textarea>
                            </div>

                            <div class="col-12 d-flex">
                                <button type="submit" class="btn btn-sm btn btn-success" name="save_terms">save_terms</button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="panel-body">

                <style>
                                .message-scroll {
                                    width: 200px;
                                    overflow-x: auto;
                                    white-space: nowrap;
                                }
                            </style>

                <table class="table table-dashed recent-order-table" id="myTable">
        <thead>
            <tr>
                <th>Sr.no</th>
                <th>Heading</th>
                <th>Subheading</th>
                <th>Description</th>
                <th>Timestamp</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $stmt = $conn->prepare("SELECT * FROM terms_conditions");
            if ($stmt) {
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result) {
                    $i = 1;
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td>
                                <div class="message-scroll">
                                    <?php echo $row['heading']; ?>
                                </div>
                            </td>
                            <td>
                                <div class="message-scroll">
                                    <?php echo $row['subheading']; ?>
                                </div>
                            </td>
                            <td>
                                <div class="message-scroll">
                                    <?php echo $row['description']; ?>
                                </div>
                            </td>
                            <td><?php echo $row['timestamp']; ?></td>
                            <td>
                            <a href="edit.php?edit_terms&id=<?php echo $row['id'];?>">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>

                            <td>
                            <a href="delete.php?delete_terms&id=<?php echo $row['id'];?>">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>

                        </tr>
                        <?php
                        $i++;
                    }
                }
            }
            ?>
        </tbody>
    </table>
                    <div class="table-bottom-control"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
}
?>


<!---------------------------------------------------------------------privacy policy--------------------------------------------------------------------------- -->

<?php
// Include your database connection file or establish a connection here

if (isset($_GET['privacy_policy'])) {
?>
<div class="main-content">
    <div class="dashboard-breadcrumb mb-25">
        <h2>Privacy Policy</h2>
        <div class="btn-box">
            <a href="index.php" class="btn btn-sm btn-primary">Home Page</a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="panel">
                <div class="panel-header">
                    <h5>Update Privacy Policy</h5>
                </div>
                <form action="config.php" method="POST" enctype="multipart/form-data">
                    <div class="panel-body">
                        <div class="row g-3">
                            <?php
                            // Assuming $conn is your database connection object
                            $sql_count = "SELECT COUNT(*) AS count FROM privacy_policy";
                            $result_count = mysqli_query($conn, $sql_count);

                            if ($result_count) {
                                $count_row = mysqli_fetch_assoc($result_count);
                                $count = $count_row['count'];
                                $add = $count + 1;
                            }
                            ?>

                            <div class="col-xxl-3 col-lg-4 col-sm-6">
                                <label class="form-label">No :</label>
                                <input type="text" value="<?php echo $add; ?>" class="form-control form-control-sm" required >
                            </div>

                            <div class="col-xxl-3 col-lg-4 col-sm-6">
                                <label class="form-label">Add Heading</label>
                                <input type="text" name="heading" class="form-control form-control-sm" required >
                            </div>

                            <div class="col-xxl-3 col-lg-4 col-sm-6">
                                <label class="form-label">Add Subheading</label>
                                <input type="text" name="subheading" class="form-control form-control-sm" required >
                            </div>

                            <div class="col-xxl-3">
                                <label class="form-label">Description</label>
                                <textarea rows="8" cols="150" name="description" class="form-control form-control-sm" required></textarea>
                            </div>

                            <div class="col-12 d-flex">
                                <button type="submit" class="btn btn-sm btn btn-success" name="save_privacy">Save Privacy Policy</button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="panel-body">

                <style>
                                .message-scroll {
                                    width: 200px;
                                    overflow-x: auto;
                                    white-space: nowrap;
                                }
                            </style>

                <table class="table table-dashed recent-order-table" id="myTable">
        <thead>
            <tr>
                <th>Sr.no</th>
                <th>Heading</th>
                <th>Subheading</th>
                <th>Description</th>
                <th>Timestamp</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $stmt = $conn->prepare("SELECT * FROM privacy_policy");
            if ($stmt) {
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result) {
                    $i = 1;
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td>
                                <div class="message-scroll">
                                    <?php echo $row['heading']; ?>
                                </div>
                            </td>
                            <td>
                                <div class="message-scroll">
                                    <?php echo $row['subheading']; ?>
                                </div>
                            </td>
                            <td>
                                <div class="message-scroll">
                                    <?php echo $row['description']; ?>
                                </div>
                            </td>
                            <td><?php echo $row['timestamp']; ?></td>
                            <td>
                            <a href="edit.php?edit_privacy&id=<?php echo $row['id'];?>">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>

                            <td>
                            <a href="delete.php?delete_privacy&id=<?php echo $row['id'];?>">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>

                        </tr>
                        <?php
                        $i++;
                    }
                }
            }
            ?>
        </tbody>
    </table>
                    <div class="table-bottom-control"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
}
?>




<!---------------------------------------------------------------------Add Notification--------------------------------------------------------------------------- -->


<?php
if (isset($_GET['notification'])) {
    ?>
    <div class="main-content">
        <div class="dashboard-breadcrumb mb-25">
            <h2>Add Notification</h2>
            <div class="btn-box">
                <a href="view.php?notifications=true" class="btn btn-sm btn-primary">View All Notification</a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="panel">
                    <div class="panel-header">
                        <h5>Customize Your Notifications! </h5>
                    </div>
                    <form action="config.php" method="POST" enctype="multipart/form-data">

                        <div class="panel-body">
                            <div class="row g-3">

                            <?php
                        $sql_count = "SELECT COUNT(*) AS count FROM notification";
                             $result_count = mysqli_query($conn, $sql_count);

                            if ($result_count) {
                                $count_row = mysqli_fetch_assoc($result_count);
                                $count = $count_row['count'];
                                $add = $count + 1;

                    }
                    ?>


                                <div class="col-xxl-3 col-lg-4 col-sm-6">
                                    <label class="form-label">Notification No / ID</label>
                                    <input type="text"  value=<?php echo $add; ?> class="form-control form-control-sm" readonly>
                                </div>




                                
                                <div class="col-xxl-3 col-lg-4 col-sm-6">
                                <label class="form-label">Select a Category</label>
                                <select name="category_name" class="form-control form-control-sm">
                                        <?php
                                        $query = "SELECT category_name FROM category";
                                        $result = mysqli_query($conn, $query);
                                        echo "<option value='none' selected>Not For Category</option>";
                                        if ($result) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                             
                                                $category_name = $row['category_name'];
                                                echo "<option value='$category_name'>$category_name</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                            </div>


                            <div class="col-xxl-3 col-lg-4 col-sm-6">
                                <label class="form-label">Select a Package Type</label>
                                <select name="forPackageOwner" class="form-control form-control-sm">
                                        <?php
                                        $query = "SELECT package_name FROM packages";
                                        $result = mysqli_query($conn, $query);
                                        echo "<option value='none' selected>Not For Package Owner</option>"; 
                                        if ($result) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $package_type = $row['package_name'];
                                                echo "<option value='$package_type'>$package_type</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                            </div>

                                <div class="col-xxl-3 col-lg-4 col-sm-6">
                                <label class="form-label">Choose</label>
                                <select class="form-control form-control-sm" name="notification_all" data-placeholder="Select Country">
                                     <option value="notforall">Not For  All Vendors</option>
                                    <option value="allvendors">Notification For All Vendors</option>
                                </select>
                            </div>

                                                        
                           <div class="col-xxl-3 col-lg-4 col-sm-6">
                            <label class="form-label">Add Notification</label>
                            <textarea name="message" class="form-control form-control-sm" required></textarea>
                        </div>
                        
                                <br><br>
                                <div class="col-12 d-flex">
                                    <button class="btn btn-sm btn btn-success" value="submit" name="save_notification">Add Notification
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>  
            </div>
        </div>
    </div>

<?php } ?>

<!--------------------------------------------------------------------------Edit Packages----------------------------------------------------------------------------->

<?php
if (isset($_GET['edit_packages'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM package_details WHERE package_id = $id";
    $result = mysqli_query($conn, $query); 
    $row = mysqli_fetch_assoc($result); 
    if (isset($_POST['save_features'])) {
        $feature_name = $_POST['feature_name'];
        $updateQuery = "UPDATE package_details SET feature_name = '$feature_name' WHERE package_id = $id";
        mysqli_query($conn, $updateQuery);
        if (mysqli_affected_rows($conn) > 0) {
            echo "<script>";
            echo "alert('Updated');";
            echo "window.location.href='view.php?packages=true';";
            echo "</script>";
        } else {
            echo "Update failed!";
        }
    }
?><div class="main-content">
<div class="dashboard-breadcrumb mb-25">
    <h2>Edit Package Features</h2>
    <div class="btn-box">
        <a href="view.php?view_categories" class="btn btn-sm btn-primary">View All Categories</a>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="panel">
            <div class="panel-header">
                <h5>Basic Information About Package</h5>
            </div>
            <form method="post" enctype="multipart/form-data">
                <div class="panel-body">
                    <div class="row g-3">
                        <div class="col-xxl-3 col-lg-4 col-sm-6">
                            <label class="form-label">Feature Name</label>
                            <input type="text" name="feature_name" value="<?php echo $row['feature_name']; ?>" class="form-control form-control-sm" required>
                            <input type="hidden" name="package_id" value="<?php echo $row['package_id']; ?>">
                        </div>
                    </div><br>
                    <div class="col-12 d-flex">
                        <button type="submit" class="btn btn-sm btn btn-success" value="submit" name="save_features">Save Category</button>
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



<!---------------------------------------------------------------------------------- Help support------------------------------------------------------------->


<?php
if (isset($_GET['view_help_Support'])) {
    $id = $_GET['id'];
    $result = mysqli_query($conn, "SELECT * FROM help_support WHERE id = $id");
    $row = mysqli_fetch_array($result);

    if (isset($_POST['update_message'])) {
        $reply_message = $_POST['reply_message'];

 
        $update_query = "UPDATE help_support SET reply_message = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $update_query);
        mysqli_stmt_bind_param($stmt, 'si', $reply_message, $id);
        
        if (mysqli_stmt_execute($stmt)) {
            echo '<script>';
            echo 'alert("Message Updated Successfully");';
            echo 'window.location.href="view.php?view_categories=true";';
            echo '</script>';
        } else {
            echo "Error updating message: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    }

?>

<div class="main-content">
    <div class="dashboard-breadcrumb mb-25">
        <h2>Help & Support </h2>
        <div class="btn-box">
            <a href="view.php?view_packages" class="btn btn-sm btn-primary">View All Admin</a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="panel">
                <div class="panel-header">
                    <h5>*************** </h5>
                </div>
                <div class="panel-body">
                    <div class="row g-3">
                        <div class="col-xxl-3">
                            <label class="form-label">Query :-</label>
                            <textarea rows="4" cols="120" name="message" class="form-control form-control-sm"><?php echo $row['message']; ?></textarea>
                        </div>
                    </div>
                </div>
                <form action="config.php" method="POST" enctype="multipart/form-data">
                    <div class="panel-body">
                        <div class="row g-3">
                            <div class="col-xxl-3 col-lg-4 col-sm-6">
                                <label class="form-label">Heading</label>
                                <input type="text" name="heading"  value="<?php echo $data; ?>" class="form-control form-control-sm" required>
                            </div>
                            <div class="col-xxl-3">
                                <label class="form-label">Solution</label>
                                <textarea rows="4" cols="120" name="reply_message" class="form-control form-control-sm"></textarea>
                            </div>
                            <br><br><br><br>
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

<?php } ?>




<!------------------------------------------------------------------------------------ Add Q & a------------------------------------------------------------------------------------------------------------------>

<?php
if (isset($_GET['Q_A'])) {
    ?>
    <div class="main-content">
        <div class="dashboard-breadcrumb mb-25">
            <h2>Add Question And Answer</h2>
            <div class="btn-box">
                <a href="view.php?question_answer=true" class="btn btn-sm btn-primary">View Q / A</a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="panel">
                    <div class="panel-header">
                        <!-- <h5>Basic Information About Services</h5> -->
                    </div>
                    <form action="config.php" method="POST" enctype="multipart/form-data">

                        <div class="panel-body">
                            <div class="row g-3">
                                <?php
                            $sql_count = "SELECT COUNT(*) AS count FROM question_answer";
                                $result_count = mysqli_query($conn, $sql_count);

                                if ($result_count) {
                                    $count_row = mysqli_fetch_assoc($result_count);
                                    $count = $count_row['count'];
                                    $add = $count + 1;

                                }
                                ?>
                            <div class="col-xxl-4 col-lg-6 col-sm-12">
                                <label class="form-label">QuestionNo</label>
                                <input type="text" value="<?php echo $add; ?>" class="form-control form-control-sm" readonly>
                            </div>

                            <div class="col-xxl-6 col-lg-6 col-sm-12">
                                <label class="form-label">Question</label>
                                <input type="text" name="question"   class="form-control form-control-sm" required>
                            </div>

                        
                            <div class="col-xxl-6">
                                <label class="form-label">Answer Description</label>
                                <textarea rows="4" cols="120" name="answer" class="form-control form-control-sm" required></textarea>
                            </div>
                              
                                <br><br>
                                <div class="col-12 d-flex">
                                    <button class="btn btn-sm btn btn-success" value="submit" name="save_q_a">Save Q/A</button> &nbsp; 
                                </div>
                            </div>
                        </div>
                    </form>
                </div>  
            </div>
        </div>
    </div>

<?php } ?>


<!---------------------------------------------------------------------- Add multiple admins ---------------------------------------------------------------------------------->

<?php
if (isset($_GET['add_admins'])) {
    ?>
    <div class="main-content">
        <div class="dashboard-breadcrumb mb-25">
            <h2>Add Admin</h2>
            <div class="btn-box">
                <a href="view.php?view_categories" class="btn btn-sm btn-primary">View All Admins</a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="panel">
                    <div class="panel-header">
                        <h5>Basic Information About Admin</h5>
                    </div>
                    <form action="config.php" method="POST" enctype="multipart/form-data">

                        <div class="panel-body">
                            <div class="row g-3">

                            <?php
                        $sql_count = "SELECT COUNT(*) AS count FROM admin";
                             $result_count = mysqli_query($conn, $sql_count);

                            if ($result_count) {
                                $count_row = mysqli_fetch_assoc($result_count);
                                $count = $count_row['count'];
                                $add = $count + 1;

                            }
                            ?>

                                <div class="col-xxl-3 col-lg-4 col-sm-6">
                                    <label class="form-label">Admin No / ID</label>
                                    <input type="text"  value=<?php echo $add; ?> class="form-control form-control-sm" readonly>
                                </div>

                                <div class="col-xxl-3 col-lg-4 col-sm-6">
                                    <label class="form-label">Admin Name</label>
                                    <input type="text" name="admin_name" class="form-control form-control-sm" required>
                                </div>

                                <div class="col-xxl-3 col-lg-4 col-sm-6">
                                    <label class="form-label">Admin Email</label>
                                    <input type="email" name="email" class="form-control form-control-sm" required>
                                </div>

                                <div class="col-xxl-3 col-lg-4 col-sm-6">
                                    <label class="form-label">Password</label>
                                    <input type="text" name="password" class="form-control form-control-sm" required>
                                </div>

                                <div class="col-xxl-3 col-lg-4 col-sm-6">
                                    <label class="form-label">Admin Type</label>
                                    <input type="text" name="admin_type" class="form-control form-control-sm" value="Admin" required readonly>
                                </div>



                                <br><br>
                                <div class="col-12 d-flex">
                                    <button class="btn btn-sm btn btn-success" value="submit" name="savw_Admin">Save
                                        Admin</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php } ?>
<?php include "footer.php"; ?>

