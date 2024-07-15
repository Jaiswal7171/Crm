
<?php include "../db.php"; ?>
<?php
if (isset($_GET['delete_adv'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $sql = "DELETE FROM advertise WHERE id = '$id'";
    if (mysqli_query($conn, $sql)) {
        echo "<script>";
        echo "alert('Deleted...');";
        echo "window.location.href='view.php?Our_advertise=true';";
        echo "</script>";
    } else {
        echo "<script>";
        echo "alert('Error: " . mysqli_error($conn) . "');";
        echo "window.location.href='view.php?Our_advertise=true';";
        echo "</script>";
    }
    mysqli_close($conn);
}
?>


<?php


if (isset($_GET['delete_banners'])) {

    $id = mysqli_real_escape_string($conn, $_GET['id']);

    $sql = "DELETE FROM banners WHERE id = '$id'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>";
        echo "alert('Deleted...');";
        echo "window.location.href='view.php?banners=true';";
        echo "</script>";
    } else {
        echo "<script>";
        echo "alert('Error: " . mysqli_error($conn) . "');";
        echo "window.location.href='view.php?banners=true';";
        echo "</script>";
    }

    mysqli_close($conn);
}
?>






<?php


if (isset($_GET['delete_notification'])) {

    $id = mysqli_real_escape_string($conn, $_GET['id']);

    $sql = "DELETE FROM notification WHERE id = '$id'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>";
        echo "alert('Notifications Deleted...');";
        echo "window.location.href='view.php?notifications=true';";
        echo "</script>";
    } else {
        echo "<script>";
        echo "alert('Error: " . mysqli_error($conn) . "');";
        echo "window.location.href='view.php?notifications=true';";
        echo "</script>";
    }

    mysqli_close($conn);
}
?>



<?php


if (isset($_GET['delete_qa'])) {

    $id = mysqli_real_escape_string($conn, $_GET['id']);

    $sql = "DELETE FROM question_answer WHERE id = '$id'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>";
        echo "alert('Q/A Deleted...');";
        echo "window.location.href='view.php?question_answer=true';";
        echo "</script>";
    } else {
        echo "<script>";
        echo "alert('Error: " . mysqli_error($conn) . "');";
        echo "window.location.href='view.php?question_answer=true';";
        echo "</script>";
    }

    mysqli_close($conn);
}
?>


<?php


if (isset($_GET['delete_terms'])) {

    $id = mysqli_real_escape_string($conn, $_GET['id']);

    $sql = "DELETE FROM terms_conditions WHERE id = '$id'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>";
        echo "alert('Data  Deleted !');";
        echo "window.location.href='add.php?terms_conditions=true';";
        echo "</script>";
    } else {
        echo "<script>";
        echo "alert('Error: " . mysqli_error($conn) . "');";
        echo "window.location.href='add.php?terms_conditions=true';";
        echo "</script>";
    }

    mysqli_close($conn);
}
?>


<?php

if (isset($_GET['delete_refund'])) {

    $id = mysqli_real_escape_string($conn, $_GET['id']);

    $sql = "DELETE FROM refund_policy WHERE id = '$id'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>";
        echo "alert('Data Deleted !');";
        echo "window.location.href='view.php?refund_policy_view=true';";
        echo "</script>";
    } else {
        echo "<script>";
        echo "alert('Error: " . mysqli_error($conn) . "');";
        echo "window.location.href='view.php?refund_policy_view=true';";
        echo "</script>";
    }

    mysqli_close($conn);
}
?>


<?php

if (isset($_GET['delete_privacy'])) {

    $id = mysqli_real_escape_string($conn, $_GET['id']);

    $sql = "DELETE FROM privacy_policy WHERE id = '$id'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>";
        echo "alert('Data Deleted !');";
        echo "window.location.href='add.php?privacy_policy=true';";
        echo "</script>";
    } else {
        echo "<script>";
        echo "alert('Error: " . mysqli_error($conn) . "');";
        echo "window.location.href='add.php?privacy_policy=true';";
        echo "</script>";
    }

    mysqli_close($conn);
}
?>


































<!--------------------------------------------------------- Edit Packages Details---------------------------------------------------------------------------- -->





<?php
if (isset($_GET['package_details_update'])) {
    $id = $_GET['pid']; 
    $query = 'SELECT * FROM packages_details WHERE package_id = ' . $id;
    $result = mysqli_query($conn, $query);
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
                        <?php 
                        while($row = mysqli_fetch_assoc($result)) {
                        ?>
                            <div class="col-xxl-3 col-lg-4 col-sm-6">
                                <label for="package_type" class="form-label">Package Features</label>
                                <input type="text" name="features" id="features" value="<?php echo $row['features']; ?>" class="form-control form-control-sm" required>
                            </div>
                        <?php } ?>
                            <div class="col-12 d-flex">
                                <button type="submit" class="btn btn-sm btn-success" value="submit" name="edit_packages_details">Save Package</button>
                                &nbsp;<a href="" class="btn btn-sm btn-warning">Edit Features Not Available !</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>  
    </div>
</div>
 
<!-- this is the Edit fucntinalty for packages here for tha packages  -->


<?php
    if (isset($_POST['edit_packages_details'])) {
        $features = $_POST['features'];
        $update_query = "UPDATE packages_details SET features = ? WHERE package_id = ?";
        $stmt = mysqli_prepare($conn, $update_query);
        mysqli_stmt_bind_param($stmt, "si", $features, $id);
        if (mysqli_stmt_execute($stmt)) {
            echo '<script>';
            echo 'alert("Package Updated Successfully");';
            echo 'window.location.href="view.php?packages=true";';
            echo '</script>';
        } else {
            echo "Error updating package: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    }
}
?>