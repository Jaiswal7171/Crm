<?php
session_start();
if (!isset($_SESSION["admin_login"]))
    header("location:login.php");
?>

<?php include "header.php"; ?>
<?php include "../db.php"; ?>



<!-------------------------------------------------------- view_categories---------------------------------------------------------------------------------------------------------------- -->


<?php
if (isset($_GET['view_categories'])) {
    $stmt = $conn->prepare("SELECT * FROM category");
    if ($stmt) {
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result) {
?>
            <div class="main-content">
                
                <div class="row">
                    <div class="col-12">
                        <div class="col-xxl-8">
                            <div class="panel">
                                <div class="panel-header">
                                    <h5>All Categories !!!&nbsp;&nbsp;</h5>
                                    <!-- <img src="assets/images/happy.gif" style="height: 52px; width: 63px;"> -->
                                    <div id="tableSearch"></div>
                                </div>
                                <div class="panel-body">
                                    <table class="table table-dashed recent-order-table" id="myTable">
                                        <thead>
                                            <tr>
                                                <th>Sr.no</th>
                                                <th>CategoryName</th>
                                                <th>ServiceCount</th>
                                                <th>Timestamp</th>
                                                <th>Edit</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                       
                                                $i = 1;
                                                while ($row = $result->fetch_assoc()) {
                                                    $category_id = $row['category_id'];
                                                    $sql_count = "SELECT COUNT(*) AS count FROM services WHERE category_id = $category_id";
                                                    $result_count = mysqli_query($conn, $sql_count);

                                                    if ($result_count) {
                                                        $count_row = mysqli_fetch_assoc($result_count);
                                                        $count = $count_row['count'];
                                                    }
                                                ?>
                                                <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <td><?php echo $row['category_name']; ?></td>
                                                    <td><?php echo $count; ?></td>
                                                    <td><?php echo $row['timestamp']; ?></td>
                                                    <td>
                                                    <a href="edit.php?edit_category&category_id=<?php echo $row['category_id'];?>">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    </td>
                                                                                                    
                                                    
                                                </tr>
                                            <?php
                                                $i++; 
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
            </div>
<?php
        }
    }
}
?>


<!--------------------------------------------------------------------------------- view_services---------------------------------------------------------------------------------------------------------------- -->

<?php
if (isset($_GET['view_services'])) {

?>
            <div class="main-content">  
                <div class="row">
                    <div class="col-12">
                        <div class="col-xxl-8">
                            <div class="panel">
                                <div class="panel-header">
                                    <h5>Services!!!&nbsp;&nbsp;</h5>
                                    <div id="tableSearch"></div>
                                </div>
                                <div class="panel-body">
                                    <form method="post" action="">
                                        <select name="category" required>
                                            <?php  
                                      
                                            $data = "SELECT * FROM category";
                                            $result = $conn->query($data);
                                            
                                            if ($result->num_rows > 0) {
                                                echo '<option>Choose A Category</option>';
                                                while($row = $result->fetch_assoc()) {
                                     
                                                    echo "<option value='" . $row["category_id"] . "'>" . $row["category_name"] . "</option>";
                                                }
                                            } else {
                                                echo "<option>No categories found</option>";
                                            }
                                            ?>
                                        </select>
                                        <button type="submit" class="btn btn-sm btn btn-success" name="submit">Fetch Services</button>
                                    </form>
                                    <br>
                                    <table class="table table-dashed recent-order-table" id="myTable">
                                        <thead>
                                            <tr>
                                                <th>Sr.no</th>
                                                <th>Service Name</th>
                                                <th>Category Name</th>
                                                <th>Timestamp</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            if(isset($_POST['submit'])){
                                                $selected_category = $_POST['category'];
                                                $stmt = $conn->prepare("SELECT services.*, category.category_name 
                                                FROM services 
                                                INNER JOIN category ON services.category_id = category.category_id 
                                                WHERE category.category_id = ?");
                                                $stmt->bind_param("s", $selected_category);
                                                $stmt->execute();
                                                $service_result = $stmt->get_result();
                                                $i = 1;
                                                while ($row = $service_result->fetch_assoc()) {
                                        ?>
                                                <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <td><?php echo $row['service_name']; ?></td>
                                                    <td><?php echo $row['category_name']; ?></td>
                                                    <td><?php echo $row['timestamp']; ?></td>
                                                    <td>
                                                    <a href="edit.php?edit_service&service_id=<?php echo $row['service_id'];?>">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                        <?php
                                                    $i++; 
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
            </div>
<?php
        }

?>





<!------------------------------------------------------------------- all_vendors------------------------------------------------------------------------------------------- -->

<?php
if (isset($_GET['all_vendors'])) {
    $stmt = $conn->prepare("SELECT v.*, 
        c1.category_name AS category_name_1, 
        c2.category_name AS category_name_2,
        c3.category_name AS category_name_3
        FROM vendor_info v
        JOIN category c1 ON v.category_id = c1.category_id
        JOIN category c2 ON v.sec_cat_id = c2.category_id
        JOIN category c3 ON v.ter_cat_id = c3.category_id;");

    if ($stmt) {
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result) {
?>

            <div class="main-content">
                <div class="row">
                    <div class="col-12">
                        <div class="col-xxl-8">
                            <div class="panel">
                                <div class="panel-header">
                                    <h5>All Vendors<img src="assets/gif/gif2-unscreen.gif" style="height: 67px; width: 90px;"></h5>
                                    <div id="tableSearch"></div>
                                </div>
                                <div class="panel-body">
                                    <table class="table table-dashed recent-order-table" id="myTable">
                                        <thead>
                                            <tr>
                                                <th>Sr.no</th>
                                                <th>View Detail</th>
                                                <th>WhatsappNo.</th>
                                                <th>ContactNo.</th>
                                                <th>url</th>
                                                <th>BusinessName</th>
                                                <th>City</th>
                                                <th>Category_A</th>
                                                <th>Category_B</th>
                                                <th>Category_C</th>
                                                <th>Logo</th>
                                                <th>CoverImage</th>
                                                <th>Timestamp</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            while ($row = $result->fetch_assoc()) {
                                            ?>
                                                <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <td>
                                                        <a href="edit.php?edit_vendors&vid=<?php echo $row['vid'];?>">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    </td>
                                                    <td><?php echo $row['whatsapp_number']; ?></td>
                                                    <td><?php echo $row['phone']; ?></td>
                                                    <td><a href="<?php echo $row['url']; ?>" target="_blank"><span class="badge bg-warning">Link</span></a></td>
                                                    <td class="text-primary"><?php echo $row['vbiz']; ?>
                                                    <td><?php echo $row['city']; ?></td>
                                                    <td><?php echo $row['category_name_1']; ?></td>
                                                    <td><?php echo $row['category_name_2']; ?></td>
                                                    <td><?php echo $row['category_name_3']; ?></td>
                                               
                                                    <td><img src="<?php echo $row['vendor_logo']; ?>" style="border-radius: 50%; height: 40px; width: 40px;"></td>
                                                    <td><img src="../..<?php echo $row['Vendor_cover_image']; ?>" style="border-radius: 50%; height: 40px; width: 40px;"></td>
                                                    <td><?php echo $row['timestamp']; ?></td>
                                                </tr>
                                            <?php
                                                $i++; 
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
            </div>
<?php
        }
    }
}
?>


<!------------------------------------------------------------------- categorywise_vendors------------------------------------------------------------------------------------------- -->

<?php
if (isset($_GET['categorywise_vendors'])) {
   
?>
            <div class="main-content">
                <div class="row">
                    <div class="col-12">
                        <div class="col-xxl-8">
                            <div class="panel">
                                <div class="panel-header">
                                    <h5>CategoryWise Vendors !!!</h5>
                                    <div id="tableSearch"></div>
                                </div>
                                <div class="panel-body">
                                    <form method="post" action="">
                                        <select name="category">
                                            <?php  
                            
                                            $data = "SELECT * FROM category";
                                            $result = $conn->query($data);
                                            
                                            if ($result->num_rows > 0) {
                                                while($row = $result->fetch_assoc()) {
                                                    echo "<option value='" . $row["category_id"] . "'>" . $row["category_name"] . "</option>";
                                                }
                                            } else {
                                                echo "<option>No categories found</option>";
                                            }
                                            ?>
                                        </select>
                                        <button type="submit" class="btn btn-sm btn btn-success"  name="submit">Submit</button>
                                   

                                    </form>
                                    <br>
                                    <?php
                            if(isset($_POST['submit'])) {
                                $selected_category_id = $_POST['category'];
                                $query = "SELECT * FROM category WHERE category_id = $selected_category_id";
                                $result = $conn->query($query);
                                if ($result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                    echo "<i> Category / Category_Id : <span class='text-primary'>" . $row['category_name'] . " - " . $row['category_id'] . "</span></i>";
                                } else {
                                    echo "Selected category not found";
                                }
                            }
                        ?><br><br>
                                        <table class="table table-dashed recent-order-table" id="myTable">
                                            <thead>
                                                <tr>
                                                <th>Sr.no</th>
                                                <th>View Detail</th>
                                                <th>WhatsappNo.</th>
                                                <th>ContactNo.</th>
                                                <th>url</th>
                                                <th>BusinessName</th>
                                                <th>City</th>
                                                <th>Category_A</th>
                                                <th>Category_B</th>
                                                <th>Category_C</th>
                                                <th>Logo</th>
                                                <th>CoverImage</th>
                                                <th>Timestamp</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                                if(isset($_POST['submit'])){
                                                    $selected_category = $_POST['category'];
                                                    $stmt = $conn->prepare("SELECT v.*, c1.category_name AS category_name, c2.category_name AS sec_category_name, c3.category_name AS ter_category_name 
                                                                            FROM vendor_info v 
                                                                            LEFT JOIN category c1 ON v.category_id = c1.category_id 
                                                                            LEFT JOIN category c2 ON v.sec_cat_id = c2.category_id 
                                                                            LEFT JOIN category c3 ON v.ter_cat_id = c3.category_id 
                                                                            WHERE v.category_id = ? OR v.sec_cat_id = ? OR v.ter_cat_id = ?");
                                                    
                                       
                                                    $stmt->bind_param("iii", $selected_category, $selected_category, $selected_category);
                                                    $stmt->execute();
                                                    $service_result = $stmt->get_result();
                                                    $i = 1; 
                                                    while ($row = $service_result->fetch_assoc()) {
                                                ?>
                                                        <tr>
                                                            <td><?php echo $i; ?></td>
                                                            <td>
                                                                <a href="edit.php?edit_vendors&vid=<?php echo $row['vid'];?>">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                            </td>
                                                            <td><?php echo $row['whatsapp_number']; ?></td>
                                                            <td><?php echo $row['phone']; ?></td>
                                                            <td><a href="<?php echo $row['url']; ?>" target="_blank"><span class="badge bg-warning">Link</span></a></td>
                                                            <td class="text-primary"><?php echo $row['vbiz']; ?></td>
                                                            <td><?php echo $row['city']; ?></td>
                                                            <td><?php echo $row['category_name']; ?></td>
                                                            <td><?php echo $row['sec_category_name']; ?></td>
                                                            <td><?php echo $row['ter_category_name']; ?></td>
                                                            <td><img src="../..<?php echo $row['vendor_logo']; ?>" style="border-radius: 50%; height: 40px; width: 40px;"></td>
                                                            <td><img src="../..<?php echo $row['Vendor_cover_image']; ?>" style="border-radius: 50%; height: 40px; width: 40px;"></td>
                                                            <td><?php echo $row['timestamp']; ?></td>
                                                        </tr>
                                                <?php
                                                        $i++;
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
            </div>
<?php
        }

?>

<!------------------------------------------------------------------- packages fetch from databse------------------------------------------------------------------------------------------- -->
<style>
.demo10{background:'';padding:30px 0}
.pricingTable10{text-align:center}
.pricingTable10 .pricingTable-header{padding:30px 0;background:#4d4d4d;position:relative;transition:all .3s ease 0s}
.pricingTable10:hover .pricingTable-header{background:#09b2c6}
.pricingTable10 .pricingTable-header:after,.pricingTable10 .pricingTable-header:before{content:"";width:16px;height:16px;border-radius:50%;border:1px solid #d9d9d8;position:absolute;bottom:12px}
.pricingTable10 .pricingTable-header:before{left:40px}
.pricingTable10 .pricingTable-header:after{right:40px}
.pricingTable10 .heading{font-size:20px;color:#fff;text-transform:uppercase;letter-spacing:2px;margin-top:0}
.pricingTable10 .price-value{display:inline-block;position:relative;font-size:55px;font-weight:700;color:#09b1c5;transition:all .3s ease 0s}
.pricingTable10:hover .price-value{color:#fff}
.pricingTable10 .currency{font-size:30px;font-weight:700;position:absolute;top:6px;left:-19px}
.pricingTable10 .month{font-size:16px;color:#fff;position:absolute;bottom:15px;right:-30px;text-transform:uppercase}
.pricingTable10 .pricing-content{padding-top:50px;background:#fff;position:relative}
.pricingTable10 .pricing-content:after,.pricingTable10 .pricing-content:before{content:"";width:16px;height:16px;border-radius:50%;border:1px solid #7c7c7c;position:absolute;top:12px}
.pricingTable10 .pricing-content:before{left:40px}
.pricingTable10 .pricing-content:after{right:40px}
.pricingTable10 .pricing-content ul{padding:0 20px;margin:0;list-style:none}
.pricingTable10 .pricing-content ul:after,.pricingTable10 .pricing-content ul:before{content:"";width:8px;height:46px;border-radius:3px;background:linear-gradient(to bottom,#818282 50%,#727373 50%);position:absolute;top:-22px;z-index:1;box-shadow:0 0 5px #707070;transition:all .3s ease 0s}
.pricingTable10:hover .pricing-content ul:after,.pricingTable10:hover .pricing-content ul:before{background:linear-gradient(to bottom,#40c4db 50%,#34bacc 50%)}
.pricingTable10 .pricing-content ul:before{left:44px}
.pricingTable10 .pricing-content ul:after{right:44px}
.pricingTable10 .pricing-content ul li{font-size:15px;font-weight:700;color:#777473;padding:10px 0;border-bottom:1px solid #d9d9d8}
.pricingTable10 .pricing-content ul li:last-child{border-bottom:none}
.pricingTable10 .read{display:inline-block;font-size:16px;color:#fff;text-transform:uppercase;background:#d9d9d8;padding:8px 25px;margin:30px 0;transition:all .3s ease 0s}
.pricingTable10 .read:hover{text-decoration:none}
.pricingTable10:hover .read{background:#09b1c5}
@media screen and (max-width:990px){.pricingTable10{margin-bottom:25px}
}

</style>


<?php
if (isset($_GET['packages'])) {
    $query = "SELECT * FROM packages";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
?>
        <div class="main-content">
            <div class="dashboard-breadcrumb mb-25">
                <h2>View Packages<img src="assets/images/money.gif" style="height: 52px; width: 68px;"></h2>
                <div class="btn-box">
                    <a href="add.php?add_packages=true" class="btn btn-sm btn-primary">Add Packages</a>
                    <a href="add.php?add_packages_features=true" class="btn btn-sm btn-warning">Add Features</a>
                </div>
            </div>

            <div class="row">
    <div class="demo10">
        <div class="container">
            <div class="row">
                <?php
                while ($row = $result->fetch_assoc()) {
                ?>
                    <div class="col-md-3 col-sm-6">
                        <div class="pricingTable10">
                            <div class="pricingTable-header">
                                <h3 class="heading"><?php echo $row['package_name']; ?></h3>
                                <span class="price-value">
                                    <span class="currency">₹</span> <?php echo $row['package_price_1yr']; ?><br>
                                </span>
                             

                            </div>
                            <div class="pricing-content">
                                <ul>
                                    <li>₹ <?php echo $row['package_price_3yr']; ?> [ For 3rd year ]</li>
                                    <li>Duration: <?php echo $row['package_duration_3yr']; ?> [ For 3 years ]</li>
                                    <li>₹ <?php echo $row['package_duration_1yr']; ?> [ Duration 1st year ]</li>
                    
                                    <a href="edit.php?edit_packages&pid=<?php echo $row['pid']; ?>" class="read">Package Update</a><br>
                            <hr>
                                  <i>- : PACKAGE DETAILS : -</i>
                                  <hr>
                                    <?php   
                                    $p_id = $row['pid'];
                                    $query2 = "SELECT * FROM packages_details WHERE package_id=$p_id";
                                    $result2 = $conn->query($query2);
                                    while ($item = $result2->fetch_assoc()) {
                                        echo '<li>' . $item['features'] . '</li>';
                                    }
                                    ?>
                                </ul>
                                <a href="delete.php?package_details_update&pid=<?php echo $row['pid']; ?>" class="read">Details Update</a><br>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>
        </div>
<?php
    } else {
        echo "No packages found.";
    }
}
?>




<!------------------------------------------------------------------------------------------------------- view all admins------------------------------------------------------------------------------------------------------ -->


<style>

.our-team {
padding: 30px 0 40px;
margin-bottom: 30px;
background-color: #f7f5ec;
text-align: center;
overflow: hidden;
position: relative;
}

.our-team .picture {
display: inline-block;
height: 130px;
width: 130px;
margin-bottom: 50px;
z-index: 1;
position: relative;
}

.our-team .picture::before {
content: "";
width: 100%;
height: 0;
border-radius: 50%;
background-color: #1369ce;
position: absolute;
bottom: 135%;
right: 0;
left: 0;
opacity: 0.9;
transform: scale(3);
transition: all 0.3s linear 0s;
}

.our-team:hover .picture::before {
height: 100%;
}

.our-team .picture::after {
content: "";
width: 100%;
height: 100%;
border-radius: 50%;
background-color: #1369ce;
position: absolute;
top: 0;
left: 0;
z-index: -1;
}

.our-team .picture img {
width: 100%;
height: auto;
border-radius: 50%;
transform: scale(1);
transition: all 0.9s ease 0s;
}

.our-team:hover .picture img {
box-shadow: 0 0 0 14px #f7f5ec;
transform: scale(0.7);
}

.our-team .title {
display: block;
font-size: 15px;
color: #4e5052;
text-transform: capitalize;
}

.our-team .social {
width: 100%;
padding: 0;
margin: 0;
background-color: #1369ce;
position: absolute;
bottom: -100px;
left: 0;
transition: all 0.5s ease 0s;
}

.our-team:hover .social {
bottom: 0;
}

.our-team .social li {
display: inline-block;
}

.our-team .social li a {
display: block;
padding: 10px;
font-size: 17px;
color: white;
transition: all 0.3s ease 0s;
text-decoration: none;
}

.our-team .social li a:hover {
color: #1369ce;
background-color: #f7f5ec;
}

</style>

<?php
if (isset($_GET['all_admins'])) {
    $query = "SELECT * FROM  admin;";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
?>
        <div class="main-content">
            <div class="dashboard-breadcrumb mb-25">
                <h2>Admins</h2>
                <div class="btn-box">
                    <!--<a href="add.php?add_admin=true" class="btn btn-sm btn-primary">Add Admin</a>-->
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="panel">
                        <!-- <div class="panel-header">
                            <h5>Add Service Providers Basic Information </h5>
                        </div> -->
                        <div class="container">
                            <div class="row">
                                <?php
                                while ($row = $result->fetch_assoc()) {
                                ?>
                                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                        <div class="our-team">
                                            <div class="picture">
                                                <img class="img-fluid" src="assets/images/admin.png" style="width: 320px; height: 130px;">
                                            </div>
                                            <div class="team-content">
                                                <h4 class="name"><?php echo $row['admin_name']; ?></h4>
                                                <h6 class="title"><?php echo $row['admin_type']; ?></h6>
                                            </div>
                                            <ul class="social">
                                            
                                                <li><a href="edit.php?edit_admin&id=<?php echo $row['id']; ?>"><i class="fa fa-eye"></i></a></li>
                                            
                                            </ul>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php
    } else {
        echo "Sorry, no administrators found.";
    }
}
?>


<!----------------------------------------------------------------------------------- leads------------------------------------------------------------------------------------------------------------- -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>
</head>
<body>
    <?php
    if (isset($_GET['leads'])) {
    ?><div class="main-content">  
    <div class="row">
        <div class="col-12">
            <div class="col-xxl-8">
                <div class="panel">
                    <div class="panel-header">
                        <h5>All Total Leads From Databse !&nbsp;&nbsp;</h5>
                        <div id="tableSearch"></div>
                    </div>
                    <div class="panel-body">
                    <div class="table-filter-option">
                    <div class="col-xl-10 col-md-10 col-9 col-xs-12">
                    <form method="POST" class="d-flex align-items-center">
                <input type="date" class="date-picker" name="selected_Date">&nbsp;&nbsp;
                
                <select id="searchsp" name="vbiz" data-placeholder="Select Shift" required>
                    <option value="">Choose</option>
                    <?php
                
                    $sql = "SELECT * FROM vendor_info";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['vid'] . "'>" . $row['vbiz'] . "</option>";
                        }
                    }
                    ?>
                </select> &nbsp;&nbsp;
                <button type="submit" name="submit_leads" class="btn btn-primary btn-sm">Submit</button>
            </form><br>

                <?php
                    if(isset($_POST['submit_leads'])) {
                        $vid = $_POST['vbiz'];
                        $selected_Date = $_POST['selected_Date'];
                        $query = "SELECT * FROM vendor_info WHERE vid = '$vid'";

                        $result = $conn->query($query);
                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            echo "<i> BusinessName / Lead_Date : <span class='text-warning'>" . $row['vbiz'] . " - " . $selected_Date . "</span></i>";
                        } else {
                            echo "Selected category not found";
                        }
                    }
                    ?>

                        </div>
                       <br>
                        <table class="table table-dashed recent-order-table" id="myTable">
                            <thead>
                                <tr>
                                    <th>Sr.no</th>
                                    <th>Lead Name</th>
                                    <th>Lead Address</th>
                                    <th>Email</th>
                                    <th>ContactNo</th>
                                    <th>S_Services</th>
                                    <th>F_Amount</th>
                                    <th>AppoinmentDate</th>
                                    <th>AppoinmentTime</th>
                                    <th>TimeStamp</th>
                                   
                                </tr>
                            </thead>
                            <tbody> 

                            <?php
if(isset($_POST['submit_leads'])){
    $vid = $_POST['vbiz']; 
    $date = $_POST['selected_Date'];
    $stmt = $conn->prepare("SELECT * FROM `lead` WHERE vid = ? AND DATE(selected_Date) = ?");
    $stmt->bind_param("ss", $vid, $date);
    $stmt->execute();
    $service_result = $stmt->get_result();
    $i = 1;
    while ($row = $service_result->fetch_assoc()) {
                                ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                        
                                            <td><?php echo $row['lead_name']; ?></td>
                                            <td><?php echo $row['lead_address']; ?></td>
                                            <td><?php echo $row['email']; ?></td>
                                            <td><?php echo $row['contact_no']; ?></td>
                                            <td><?php echo $row['selectedServices']; ?></td>
                                            <td><?php echo $row['final_amount']; ?></td>
                                            <td><?php echo $row['selected_Date']; ?></td>
                                            <td><?php echo $row['appointment_time']; ?></td>
                                            <td><?php echo $row['timestamp']; ?></td>
                                           
                                        </tr>
                                <?php
                                        $i++; 
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
    </div>
</div>

<script>
    $("#searchsp").chosen();
</script>
<?php
}
?>



<!------------------------------------------------------------------- leads_count------------------------------------------------------------------------------------------- -->


<?php
if (isset($_GET['leads_count'])) {
    $query = "SELECT v.*, 
    (SELECT COUNT(*) FROM `lead` l WHERE l.vid = v.vid) AS total_lead_count 
  FROM vendor_info v";

  
    $result = mysqli_query($conn, $query);
    
    ?>

    <div class="main-content">
        <div class="row">
            <div class="col-12">
                <div class="panel">
                    <div class="panel-header">
                        <h5>Total Lead Count</h5>
                        <div id="tableSearch"></div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                        <table class="table table-dashed recent-order-table" id="myTable">
                            <thead>
                                <tr>
                                    <th>Vendor ID</th>
                                    <th>View Profile</th>
                                    <th>Business Name</th>
                                    <th>LeadCount</th>
                                    <th>Vendor URL</th>
                                    <th>City</th>
                                    <th>Location</th>
                                    <th>ContactNo</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                    <tr>
                                        <td><?php echo $row['vid']; ?></td>
                                    <td>
                                        <a href="edit.php?edit_vendors&vid=<?php echo $row['vid'];?>">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                        <td><?php echo $row['vbiz']; ?></td>
                                        <td><span class="badge bg-black"><?php echo $row['total_lead_count']; ?></td>
                                        <td><a href="<?php echo $row['url']; ?>"><span class="badge bg-warning">Link</span> </a></td>
                                        <td><?php echo $row['city']; ?></td>
                                        <td><?php echo $row['location']; ?></td>
                                        <td><?php echo $row['phone']; ?></td>
                                        <td><?php echo $row['email']; ?></td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>


<!----------------------------------------------------------------------------------- DayeWiseleads------------------------------------------------------------------------------------------------------------- -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>
</head>
<body>


<?php
if (isset($_GET['datewise_count'])) {

?>

<div class="main-content">  
    <div class="row">
        <div class="col-12">
            <div class="col-xxl-8">
                <div class="panel">
                    <div class="panel-header">
                        <h5>Datewise All Leads !&nbsp;&nbsp;</h5>
                        <div id="tableSearch"></div>
                    </div>
                    <div class="panel-body">
                        <div class="table-filter-option">
                            <div class="col-xl-10 col-md-10 col-9 col-xs-12">
                                <form method="POST" class="d-flex align-items-center">
                                    <select id="searchsp" name="vbiz" data-placeholder="Select Shift" required>
                                        <option value="">Choose</option>
                                        <?php
                                        $sql = "SELECT * FROM vendor_info";
                                        $result = $conn->query($sql);

                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<option value='" . $row['vid'] . "'>" . $row['vbiz'] . "</option>";
                                            }
                                        }
                                        ?>
                                    </select> &nbsp;&nbsp;
                                    <button type="submit" name="submit_d" class="btn btn-primary btn-sm">Submit</button>
                                </form><br><?php
                            if(isset($_POST['submit_d'])) {
                                $vid = $_POST['vbiz'];
                                
                             
                                $query = "SELECT * FROM vendor_info WHERE vid = '$vid'";

                                $result = $conn->query($query);
                                if ($result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                    echo "<i> BusinessName  : <span class='text-warning'>" . $row['vbiz'] . "</span></i>";
                                } else {
                                    echo "Selected category not found";
                                }
                            }
                            ?>
                            </div>
                            <br>
                            <table class="table table-dashed recent-order-table" id="myTable">
                                <thead>
                                    <tr>
                                        <th>Sr.no</th>
                                        <th>Date</th>   
                                        <th>Count</th>
                                      
                             
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    if(isset($_POST['submit_d'])){
                                        $vid = $_POST['vbiz']; 
                                        $basicDate = "2024-03-01";
                                        $stmt = $conn->prepare("SELECT DATE(l.selected_Date) AS selected_Date, 
                                            v.vid, v.vbiz, COUNT(*) AS lead_count
                                            FROM `lead` l
                                            INNER JOIN vendor_info v ON l.vid = v.vid
                                            WHERE l.vid = ? AND l.selected_Date >= ?
                                            GROUP BY DATE(l.selected_Date)
                                            ORDER BY l.selected_Date");

                                        $stmt->bind_param("ss", $vid, $basicDate);
                                        $stmt->execute();

                                        $service_result = $stmt->get_result();
                                        $i = 1;
                                        while ($max = $service_result->fetch_assoc()) {
                                            ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $max['selected_Date']; ?></td>
                                          
                                                <td><span class="badge bg-black"><?php echo $max['lead_count']; ?></td>
                                              
                                            </tr>
                                            <?php
                                            $i++; 
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
    </div>
</div>

<script>
    $("#searchsp").chosen();
</script>

<?php
}
?>
</body>
</html>

 

<!------------------------------------------------------------------- vendor_banner------------------------------------------------------------------------------------------- -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>
</head>
<body><?php
if (isset($_GET['banners'])) {
?>
<div class="main-content">  
    <div class="row">
        <div class="col-12">
            <div class="col-xxl-8">
                <div class="panel">
                    <div class="panel-header">
                        <h5>Banners Management !!!&nbsp;&nbsp;</h5>
                        <div id="tableSearch"></div>
                    </div>
                    <div class="panel-body">
                        <div class="table-filter-option">
                            <div class="col-xl-10 col-md-10 col-9 col-xs-12">
                                <form method="POST" class="d-flex align-items-center">
                                    <select id="searchsp" name="vid" data-placeholder="Select Vendor" required>
                                        <option value="">Choose</option>
                                        <?php
                                        $sql = "SELECT * FROM vendor_info";
                                        $result = $conn->query($sql);

                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<option value='" . $row['vid'] . "'>" . $row['vbiz'] . "</option>";
                                            }
                                        }
                                        ?>
                                    </select> &nbsp;&nbsp;
                                    <button type="submit" name="submit" class="btn btn-primary btn-sm">Submit</button>
                                </form>
                            </div>    <br>
                            <?php
                            if(isset($_POST['submit'])){
                                $vid = $_POST['vid']; 
                                $query_vbiz = "SELECT vendor_info.*, category.category_name 
                                FROM vendor_info 
                                INNER JOIN category ON vendor_info.category_id = category.category_id 
                                WHERE vendor_info.vid = $vid";
                                $result_vbiz = $conn->query($query_vbiz);
                                $row_vbiz = $result_vbiz->fetch_assoc();
                                echo '#' . ' ' . $row_vbiz['vbiz'] . ' | ' . $row_vbiz['category_name'] . ' | ' . '<a href="' . $row_vbiz['url'] . '"><span class="badge bg-warning">Link</span></a>' . ' | ' . 'From : ' . $row_vbiz['city'];
                                echo '<hr>';
                            }
                            ?>

                            <br>

                            <table class="table table-dashed recent-order-table" id="myTable">
                                <thead>
                                    <tr>
                                        <th>Sr.no</th>
                                        <th>Banners</th>
                                        <th>timestamp</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($_POST['submit'])) {
                                        $selected_vbiz = $_POST['vid'];
                                        $query = "SELECT * FROM banners WHERE vid = '$selected_vbiz'";
                                        $service_result = $conn->query($query);

                                        if ($service_result->num_rows > 0) {
                                            $i = 1;
                                            while ($row = $service_result->fetch_assoc()) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <td>
                                                        <img src="../..<?php echo $row['image']; ?>" style="border-radius: 50%; height: 40px; width: 40px;">
                                                    </td>
                                                    <td><?php echo $row['timestamp']; ?></td>
                                                    <td><a href="delete.php?delete_banners=true&id=<?php echo $row["id"]; ?>"> <i class="fa fa-trash"></i>  </a></td>

                                                </tr>
                                                <?php
                                                $i++;
                                            }
                                        } else {
                                            echo "<tr><td colspan='5'>No results found.</td></tr>";
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
    </div>
</div>

<script>
    $("#searchsp").chosen();
</script>
<?php
}
?>

</body>
</html>

<!--------------------------------------------------------------------------- Advertise----------------------------------------------------------------------------------------------- -->

<?php
if (isset($_GET['Our_advertise']) && isset($conn)) {
    $sql = "SELECT * FROM advertise";
    $result = $conn->query($sql);
?>

<div class="main-content">
    <div class="dashboard-breadcrumb mb-25">
        <h2>Our Advertise :-</h2>
        <div class="btn-box">
            <a href="index.php" class="btn btn-sm btn-primary">Home</a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="panel">
                <div class="panel-header">
                    <h5>Add Advertise Heading & Choose Image</h5>
                </div>

                <form action="config.php" method="POST" enctype="multipart/form-data">
                    <div class="panel-body">
                        <div class="row g-3">
                            <div class="col-xxl-3 col-lg-4 col-sm-6">
                                <label class="form-label">Heading</label>
                                <input type="text" name="heading" class="form-control form-control-sm" value="Advertise" required readonly>
                            </div>

                            <div class="col-xxl-3 col-lg-4 col-sm-6">
                                <label class="form-label">Choose Image [Allowed Only jpg, jpeg, png Format ]</label>
                                <input type="file" name="image" class="form-control form-control-sm" accept=".jpg, .jpeg, .png" required>
                            </div>

                            <div class="col-12 d-flex">
                                <button class="btn btn-sm btn-success" value="submit" name="save_advertise">Save Advertise</button>
                            </div>
                        </div>
                    </div>
                </form>

                <hr>

                <table class="table table-dashed recent-order-table" id="myTable">
                    <thead>
                        <tr>
                            <th>Sr.no</th>
                            <th>Heading</th>
                            <th>Advertise</th>
                            <th>CreateDate</th>
                          
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        while ($row = $result->fetch_assoc()) {
                        ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $row['heading']; ?></td>
                                <td><img src="../gallery/advertise/<?php echo $row['image']; ?>" style="border-radius: 50%; height: 40px; width: 40px;"></td>
                                <td><?php echo $row['createdAt']; ?></td>

                                <td>
                                    <a href="delete.php?delete_adv&id=<?php echo $row['id']; ?>">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php
                            $i++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php 
}
?>


<!------------------------------------------------------------- view admin profile=--------------------------------------------------------------------------- -->
<?php
if (isset($_GET['view_profile'])) {
    $adminDetails = $_SESSION["admin_details"];
    ?>

            <div class="main-content">
                                <div class="dashboard-breadcrumb mb-25">
                                    <h2>View Profile</h2>
                                </div>

                                <div class="row g-4">
                                    <div class="col-md-4">
                                        <div class="panel">
                                            <div class="panel-body">
                                                <div class="profile-sidebar">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <h5 class="profile-sidebar-title">Admin Basic Information</h5>
                                                        <!-- <div class="dropdown">
                                                            <button class="btn btn-sm btn-icon btn-outline-primary" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="fa-solid fa-ellipsis"></i>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-sm dropdown-menu-sm-end">
                                                                <li><a class="dropdown-item" href="view.php?view_admins"><i class="fa-regular fa-pen-to-square"></i>&nbspWant to View All Admins</a></li>
                                                            </ul>
                                                        </div> -->
                                                    </div>
                                                    <div class="top">
                                                        <div class="image-wrap">
                                                        
                                                            <div class="part-img rounded-circle overflow-hidden">
                                                            <img src="../gallery/download.png ?>" alt="admin">

                                                            </div>
                                               
                                                        </div>
                                                        <div class="part-txt">
                                                        <h4 class="admin-name"><?php echo $adminDetails['admin_name']; ?></h4>
                                                            <span class="admin-role"><?php echo $adminDetails['email']; ?></span>
                                                            <div class="admin-social">
                                                                <a href="https://www.facebook.com/"><i class="fa-brands fa-facebook-f"></i></a>
                                                                <a href="https://twitter.com/"><i class="fa-brands fa-twitter"></i></a>
                                                                <a href="https://www.instagram.com/?hl=en"><i class="fa-brands fa-instagram"></i></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="bottom">
                                                        <h6 class="profile-sidebar-subtitle">Personal Info</h6>
                                                        <ul>
                                                            <li><span>Full Name:</span><?php echo $adminDetails['admin_name']; ?></li>
                                                            <li><span>Mobile:</span>*********</li>
                                                            <li><span>Mail:</span><?php echo $adminDetails['email']; ?></li>
                                                            <li><span>Password:</span>******</li>
                                                            <li><span>Mail:</span><?php echo $adminDetails['email']; ?></li>
                                                      
                                 
                                                        </ul>
                                                        <h6 class="profile-sidebar-subtitle">About Me</h6>
                                                        <p> In publishing and graphic design, Lorem ipsum is a placeholder text commonly 
                                                            used to demonstrate the visual form of a document or a typeface without relying
                                                             on meaningful content. Lorem ipsum may be used as a placeholder before the final 
                                                             copy is available.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                                        <?php
                                                        $sql = "SELECT COUNT(*) as count FROM admin";
                                                        $result = $conn->query($sql);
                                                        $row = $result->fetch_assoc();
                                                        $count = $row['count'];
                                                        ?>
                                    <div class="col-md-8">
                                        <div class="row mb-25">
                                            <div class="col-lg-4">
                                                <div class="dashboard-top-box rounded-bottom panel-bg">
                                                    <div class="left">
                                                        <h3><?php echo $count; ?>&nbsp administrators </h3>
                                                        <p>can handle this portal</p>
                                                        <a href="view.php?all_admins=true">View All administrators</a>
                                                    </div>
                                                   
                                                </div>
                                            </div>
                                           
                   
                                        </div>
                                        <div class="panel">
                                            <div class="panel-header">
                                                <h5>Account Details</h5>
                                            </div>
                                            <div class="panel-body">
                                                <div class="user-activity">
                                                    <ul>
                                                        <li>
                                                            <div class="left">
                                                                <span class="user-activity-title">Your Account Registered on </span>
                                                                <span class="user-activity-details"><?php echo $adminDetails['timestamp']; ?></span><br>
                                                               


                                                                <div class="dropdown">
                                                    <a href="adminlogout.php" class="btn btn-sm btn-primary">Log Out</a>
                                                </div>
                                        
                                                            </div>
                                                            <div class="right">
                                                                <span class="user-activity-time">***</span>
                                        
                                                            </div>
                                                        </li>
                                                       
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
<?php
}
?>





<!----------------------------------------------------------------------------------- View Help |support-------------------------------------------------------------------------------------------->
<?php
if (isset($_GET['help_support'])) {
?>
<div class="main-content">
    <div class="row">
        <div class="col-12">
            <div class="col-xxl-8">
                <div class="panel">
                    <div class="panel-header">
                        <h5>Help & Support</h5>
                        <div id="tableSearch"></div>
                    </div>
                    <div class="panel-body">
                        <div class="table-filter-option">
                            <div class="col-xl-10 col-md-10 col-9 col-xs-12">
                                <form method="POST" class="d-flex align-items-center">
                                    <input type="date" name="inquiry_date"> &nbsp;&nbsp;
                                    <button type="submit" name="submit" class="btn btn-primary btn-sm">Submit</button>&nbsp;
                                    <button type="submit" name="submit_all" class="btn btn-warning btn-sm">Fetch All</button>
                                </form>
                            </div>
                            <br>
                            <style>
                                .message-scroll {
                                    width: 200px;
                                    overflow-x: auto;
                                    white-space: nowrap;
                                }
                            </style>
                            <form method="POST" action="edit.php">
                                <table class="table table-dashed recent-order-table" id="myTable">
                                    <thead>
                                        <tr>
                                            <th>Sr.no</th>
                                            <th>Date</th>
                                            <th>Business Name</th>
                                            <th>Message</th>
                                            <th>Status</th>
                                            <th>Whatsapp Message</th>
                                            <th>Reply [Mail]</th>
                                            <th>Detail</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($_POST['submit_all'])) {
                                            $stmt = $conn->prepare("SELECT hs.*, vi.* FROM help_support hs JOIN vendor_info vi ON hs.vid = vi.vid");
                                        } elseif (isset($_POST['submit']) && isset($_POST['inquiry_date'])) {
                                            $inquiry_date = $_POST['inquiry_date'];
                                            $stmt = $conn->prepare("SELECT hs.*, vi.* FROM help_support hs JOIN vendor_info vi ON hs.vid = vi.vid WHERE hs.inquiry_date = ?");
                                            $stmt->bind_param("s", $inquiry_date);
                                        }
                                        if (isset($stmt)) {
                                            $stmt->execute();
                                            $service_result = $stmt->get_result();
                                            $i = 1;

                                            while ($max = $service_result->fetch_assoc()) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <td><?php echo $max['inquiry_date']; ?></td>
                                                    <td><?php echo $max['vbiz']; ?></td>
                                                    <td>
                                                        <div class="message-scroll">
                                                            <?php echo $max['message']; ?>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        if ($max['status'] == 1) {
                                                            echo '<span class="badge bg-primary">Solve</span>';
                                                        } else {
                                                            echo '<span class="badge bg-success">Pending</span>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <a target="_blank" href="https://api.whatsapp.com/send?phone=<?php echo $max['whatsapp_number']; ?>&text=Hi%20there!%20I%20have%20a%20question%20">
                                                            <i style="background-color: #25d366; height: 20px; width: 20px; color: white;" class="fab fa-whatsapp"></i>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a target="_blank" href="mailto:<?php echo $max['email']; ?>"><i class="fa fa-envelope" style="font-size:21px;color:red"></i></a>
                                                    </td>
                                                    <td>
                                                        <a href="edit.php?view_help&id=<?php echo $max['id']; ?>">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                        <?php
                                                $i++;
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </form>
                            <div class="table-bottom-control"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
}
?>


<!-------------------------------------------------------------------------categodrywise_vendors_count------------------------------------------------------------------------------------------------------->


<?php

if (isset($_GET['categodrywise_vendors_count'])) {
    ?>

    <div class="main-content">
        <div class="row">
            <div class="col-12">
                <div class="panel">
                    <div class="panel-header">
                        <h5>CategoryWise Vendor Count   </h5>
                    </div>
                    <div class="panel-body">
                        <div class="icon-row">

                        <?php
                                    $sql = "SELECT v.category_id, c.category_name, COUNT(*) AS category_count
                                    FROM vendor_info v
                                    INNER JOIN category c ON v.category_id = c.category_id 
                                                           OR v.sec_cat_id = c.category_id
                                                           OR v.ter_cat_id = c.category_id
                                    GROUP BY v.category_id, c.category_name";
                            
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                    ?>
                                            <div class="icon-col">
                                                <div class="icon-box">
                                                    <button class="btn-flush copy-icon"><i class="fa-light fa-clone"></i></button>
                                                <h6><?php echo $row["category_name"]; ?></h6> <!-- Display category name -->
                                            
                                                    <span class="icon-name"><?php echo $row["category_count"]; ?></span> <!-- Display category count -->
                                                </div>
                                            </div>
                                    <?php
                                        }
                                    } else {
                                        echo "0 results";
                                    }
                                    ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
}

?>





<!----------------------------------------------------------------------------------- date_collection count------------------------------------------------------------------------------------------------------------- -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>
</head>
<body>

<?php
if (isset($_GET['date_collection'])) {
 
?>

<div class="main-content">  
    <div class="row">
        <div class="col-12">
            <div class="col-xxl-8">
                <div class="panel">
                    <div class="panel-header">
                        <h5>Total Collection [Vendors] DateWise!!!&nbsp;&nbsp;</h5>
                        <div id="tableSearch"></div>
                    </div>
                    <div class="panel-body">
                        <div class="table-filter-option">
                            <div class="col-xl-10 col-md-10 col-9 col-xs-12">
                                <form method="POST" class="d-flex align-items-center">
                                    <select id="searchsp" name="vbiz" data-placeholder="Select Shift" required>
                                        <option value="">Choose</option>
                                        <?php
                                        $sql = "SELECT * FROM vendor_info";
                                        $result = $conn->query($sql);

                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<option value='" . $row['vid'] . "'>" . $row['vbiz'] . "</option>";
                                            }
                                        }
                                        ?>
                                    </select> &nbsp;&nbsp;
                                    <button type="submit" name="submit" class="btn btn-primary btn-sm">Submit</button>
                                </form>
                            </div><br>
                            <?php
                            if(isset($_POST['submit'])) {
                                $vid = $_POST['vbiz'];
                                $query = "SELECT * FROM vendor_info WHERE vid = '$vid'";

                                $result = $conn->query($query);
                                if ($result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                    echo "<i> VendorBusiness Name  / Vid : <span class='text-warning'>" . $row['vbiz'] . " - " . $row['vid'] . "</span></i>";
                                } else {
                                    echo "Selected category not found";
                                }
                            }
                            ?><br>
                            <br>
                             <div class="row">
                                <div class="col-md-6">
                                <table class="table table-dashed recent-order-table" id="myTable" >
                                <thead>
                                    <tr>
                                        <th>Sr.no</th>
                                        <th>Date</th>   
                                        <th>Count</th>
                                      
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    if(isset($_POST['submit'])){
                                        $vid = $_POST['vbiz']; 
                                        
                                        $query = "SELECT selected_date AS date, SUM(final_amount) AS total_count 
                                                FROM `lead` 
                                                WHERE vid = ? 
                                                GROUP BY selected_date 
                                                ORDER BY selected_date ASC";
                                        
                                        $stmt = $conn->prepare($query);
                                        $stmt->bind_param("i", $vid);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        
                                        if ($result->num_rows > 0) {
                                            $i = 1;
                                            while ($max = $result->fetch_assoc()) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <td><?php echo $max['date']; ?></td>
                                                    <td><u><?php echo $max['total_count']; ?></u></td>
                                                </tr>
                                                <?php
                                                $i++;
                                            }
                                        } else {
                                            echo "No results found.";
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
            </div>
        </div>
    </div>
</div>

<script>
    $("#searchsp").chosen();
</script>

<?php
}
?>
</body>
</html>



<!-- ---------------------------------------------------------------------------suggestion -------------------------------------------------------------------------------------------------- -->
<?php
if (isset($_GET['suggestions'])) {
    ?>
    <div class="main-content">
        <div class="dashboard-breadcrumb mb-25">
            <h2>Vendor Suggestion Topics</h2>
        </div>
        <div class="row mb-25"> <!-- Start row outside the loop -->
        <?php
        $query = "SELECT * FROM suggestion_topics";
        $result = mysqli_query($conn, $query);

  
        if (mysqli_num_rows($result) > 0) {
            $count = 0; 
        
            while ($row = mysqli_fetch_assoc($result)) {
                if ($count % 4 == 0 && $count != 0) { 
                }
                ?>
                <div class="col-lg-3 col-6 col-xs-12">
                    <div class="dashboard-top-box rounded-bottom panel-bg">
                        <div class="left">
                            <h3><?php echo $row['topic']; ?></h3>
                            <?php
                            $topic_id = $row['id'];
                            $count_query = "SELECT COUNT(*) AS countdetail FROM suggestion WHERE topic_id = $topic_id";
                            $count_result = mysqli_query($conn, $count_query);
                            if ($count_result) {
                                $count_row = mysqli_fetch_assoc($count_result);
                                $countdetail = $count_row['countdetail'];
                            } else {
                                $countdetail = 0;
                            }
                            ?>
                            <p><?php echo $countdetail; ?></p>
                            <a href="view.php?view_suiggestion=true">View Detail Suggestion</a>
                        </div>
                        <div class="right">
                            <span class="text-primary">+</span>
                            <div class="part-icon rounded">
                                <span><i class="fa-light fa-dollar-sign"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                $count++;
            }
            ?>
        </div>
    <?php
    } else {
        echo "<p>No suggestions found.</p>";
    }
}
?>





<!------------------------------------------------------------------- Detail View OF suggestion ------------------------------------------------------------------------------------------- -->

<?php
if (isset($_GET['view_suiggestion'])) {
    ?>
    <div class="main-content">
        <div class="row">
            <div class="col-12">
                <div class="col-xxl-8">
                    <div class="panel">
                        <div class="panel-header">
                            <h5>View suggestion TopicWise !!!&nbsp;&nbsp;<img src="assets/gif/tenor-unscreen.gif" style="height: 50px; width: 70px;"></h5>
                            <div id="tableSearch"></div>
                        </div>
                        <div class="panel-body">
                            <form method="post" action="">
                            <select name="topic_id">
                            <?php  
                            $data = "SELECT * FROM suggestion_topics";
                            $result = $conn->query($data);

                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row["id"] . "'>" . $row["topic"] . "</option>";
                                }
                            } else {
                                echo "<option>No categories found</option>";
                            }
                            ?>
                        </select>
                                <button type="submit" class="btn btn-sm btn btn-success" name="submit">Fetch Services</button>
                            </form>
                            <br>

                            <style>
                                .message-scroll {
                                    width: 200px; /* Adjust the width as needed */
                                    overflow-x: auto;
                                    white-space: nowrap; /* Ensures the text doesn't wrap */
                                }
                            </style>

<?php
                            if(isset($_POST['submit'])) {
                                $topic_id = $_POST['topic_id'];
                                $query = "SELECT * FROM suggestion_topics WHERE id = $topic_id";
                                $result = $conn->query($query);
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo "<i> SuggestionTopic / Id : <span class='text-primary'>" . $row['topic'] . " - " . $row['id'] . "</span></i><br>";
                                    }
                                } else {
                                    echo "No suggestions found for the selected category";
                                }
                            }
                            ?><br>


                            <table class="table table-dashed recent-order-table" id="myTable">
                                <thead>
                                    <tr>
                                        <th>Sr.no</th>
                                        <th>Vendor BusinessName</th>
                                   
                                        <th>Message</th>
                                        <th>City</th>
                                        <th>Location</th>
                                        <th>Timestamp</th>
                                      
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
            if(isset($_POST['submit'])){
                $topic_id = $_POST['topic_id'];  
                $stmt = $conn->prepare("SELECT s.id, v.vbiz, v.location, v.city, s.createdAt, s.message
                                       FROM suggestion s
                                       JOIN vendor_info v ON s.vid = v.vid
                                       WHERE s.topic_id = ?");
                $stmt->bind_param("i", $topic_id);
                $stmt->execute();
                $service_result = $stmt->get_result();
                $i = 1;
                while ($row = $service_result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td class="text-primary"><?php echo $row['vbiz']; ?></td>
                        <td>
                        <div class="message-scroll">
                            <?php echo $row['message']; ?>
                        </div>
                         </td>
                        <td><?php echo $row['city']; ?></td>
                        <td><?php echo $row['location']; ?></td>
                        <td><?php echo $row['createdAt']; ?></td>
            
                       
                    </tr>
                    <?php
                    $i++; 
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
    </div>
    <?php
}
?>


<!---------------------------------------------------------------------Refund Policy--------------------------------------------------------------------------- -->

<?php
// Include your database connection file or establish a connection here

if (isset($_GET['refund_policy_view'])) {
?>
<div class="main-content">
    <div class="dashboard-breadcrumb mb-25">
        <h2>Refund Policy</h2>
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
                            $sql_count = "SELECT COUNT(*) AS count FROM refund_policy";
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
                                <button type="submit" class="btn btn-sm btn btn-success" name="save_refund">Save RefundPolicy</button>
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
            $stmt = $conn->prepare("SELECT * FROM refund_policy");
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
                            <a href="edit.php?edit_refund&id=<?php echo $row['id'];?>">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>

                            <td>
                            <a href="delete.php?delete_refund&id=<?php echo $row['id'];?>">
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



<!------------------------------------------------------------------- total revenue------------------------------------------------------------------------------------------- -->

<?php
if (isset($_GET['total_collection'])) {

    $query = "SELECT v.vid, v.vbiz, v.url,  v.email, v.phone , v.vendor_name, COUNT(l.vid) AS total_count, SUM(l.final_amount) AS total_final_amount
    FROM vendor_info v
    LEFT JOIN `lead` l ON v.vid = l.vid
    GROUP BY v.vid, v.vendor_name";


    $result = mysqli_query($conn, $query);
    if ($result) {
?>

    <div class="main-content">
        <div class="row">
            <div class="col-12">
                <div class="panel">
                    <div class="panel-header">
                        <h5>Total collections</h5>
                        <div id="tableSearch"></div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-dashed recent-order-table" id="myTable">
                                <thead>
                                    <tr>
                                         <th>Sr.No</th>
                                        <th>Vendor ID</th>
                                        <th>BusinessName</th>
                                        <th>Total Count</th>
                                        <th>Url</th>
                                        <th>Email</th>
                                        <th>PrimaryContactNo.</th>
                                        <th>ViewProfile</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                        <tr>
                                        <td><?php echo $i; ?></td>
                                            <td><?php echo $row['vid']; ?></td>
                                            <td><?php echo $row['vbiz']; ?></td>
                                            <td><span class="badge bg-dark"><?php echo $row['total_final_amount']; ?></span></td>
                                            <td><a href="<?php echo $row['url']; ?>"><span class="badge bg-warning">Link</span> </a></td>
                                        
                                            <td><?php echo $row['email']; ?></td>
                                            <td><?php echo $row['phone']; ?></td>
                                            <td>
                                                    <a href="edit.php?edit_vendors&vid=<?php echo $row['vid'];?>">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                            </td>
                                        </tr>
                                    <?php
                                      $i++; 
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
    } else {
      
        echo "Error executing query: " . mysqli_error($conn);
    }
}
?>



<!-------------------------------------------------------- notifications---------------------------------------------------------------------------------------------------------------- -->


<?php
if (isset($_GET['notifications'])) {
    $stmt = $conn->prepare("SELECT * FROM notification");
    if ($stmt) {
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result) {
?>
            <div class="main-content">
                
                <div class="row">
                    <div class="col-12">
                        <div class="col-xxl-8">
                            <div class="panel">
                                <div class="panel-header">
                                    <h5>All Notification !!!&nbsp;&nbsp;</h5>
                                    <!-- <img src="assets/images/happy.gif" style="height: 52px; width: 63px;"> -->
                                    <div id="tableSearch"></div>
                                </div>
                                <div class="panel-body">
                                    <table class="table table-dashed recent-order-table" id="myTable">
                                        <thead>
                                            <tr>
                                                <th>Sr.no</th>
                                               
                                                <th>ForCategory</th>
                                                <th>ForPackage</th>
                                                <th>All/None</th>
                                                <th>Notification</th>
                                                <th>Timestamp</th>
                                                <th>Edit</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                           
                                            $i = 1;
                                            while ($row = mysqli_fetch_assoc($result)) {
                                        ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $row['category_name']; ?></td>
                                                <td><?php echo $row['forPackageOwner']; ?></td>
                                                <td><?php echo $row['notification_all']; ?></td>
                                                <td class="text-warning"><?php echo $row['message']; ?></td>
                                                <td><?php echo $row['timestamp']; ?></td>
                                                <td>
                                                    <a href="edit.php?edit_notification&id=<?php echo $row['id'];?>">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </td>           
                                                <td>
                                                    <a href="delete.php?delete_notification&id=<?php echo $row['id'];?>">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </td>                                                        
                                            </tr>
                                        <?php
                                            $i++; 
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
            </div>
<?php
        }
    }
}

?>

<!------------------------------------------------------------------------- Edit Features--------------------------------->



<?php
if (isset($_GET['edit_features'])) {
    $id = $_GET['id'];  
    $query = 'SELECT * FROM package_details WHERE package_id = ' . $id;
    $result = mysqli_query($conn, $query); 
    $row = mysqli_fetch_assoc($result); 
    
    if (isset($_POST['save_features'])) {
        $id = $_GET['id'];
        $features = $_POST['feature_name'];
        foreach ($features as $feature) {
            $update_query = "UPDATE package_details SET feature_name = '$feature' WHERE package_id = $id";
            mysqli_query($conn, $update_query);
        }

        echo '<script>';
        echo 'alert("Package Updated Successfully");';
        echo 'window.location.href="view.php?packages=true";';
        echo '</script>';   
        exit();
    }

?>

<div class="main-content">
    <div class="dashboard-breadcrumb mb-25">
        <h2>Packages</h2>
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
                <form method="post" enctype="multipart/form-data">
                    <div class="panel-body">
                        <div class="row g-3">
                         
                            <?php
                            $features_query = "SELECT * FROM package_details WHERE package_id = $id";
                            $features_result = mysqli_query($conn, $features_query);

                            while ($feature_row = mysqli_fetch_assoc($features_result)) {
                                echo '<div class="col-xxl-3 col-lg-4 col-sm-6">';
                                echo '<label class="form-label">Feature</label>';
                                echo '<input type="text" name="feature_name[]" value="' . $feature_row['feature_name'] . '" class="form-control form-control-sm">';
                                echo '</div>';
                            }
                            ?>
                      

                            <div class="col-12 d-flex">
                                <button type="submit" class="btn btn-sm btn-success" value="submit" name="save_features">Save Features</button>&nbsp;
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<?php } ?>


<!------------------------------------------------------------------- all_vendors------------------------------------------------------------------------------------------- -->
<?php
if (isset($_GET['count'])) {

    $stmt = $conn->prepare("SELECT c1.category_name AS category_name_1, 
                                   c2.category_name AS category_name_2,
                                   c3.category_name AS category_name_3,
                                   COUNT(*) as count 
                            FROM vendor_info v
                            LEFT JOIN category c1 ON v.category_id = c1.category_id
                            LEFT JOIN category c2 ON v.sec_cat_id = c2.category_id
                            LEFT JOIN category c3 ON v.ter_cat_id = c3.category_id
                            GROUP BY category_name_1, category_name_2, category_name_3");

    if ($stmt) {
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result) {
?>
            <div class="main-content">
                <div class="row">
                    <div class="col-12">
                        <div class="col-xxl-8">
                            <div class="panel">
                                <div class="panel-header">
                                    <h5>All Vendors<img src="assets/gif/gif2-unscreen.gif" style="height: 67px; width: 90px;"></h5>
                                    <div id="tableSearch"></div>
                                </div>
                                <div class="panel-body">
                                    <table class="table table-dashed recent-order-table" id="myTable">
                                        <thead>
                                            <tr>
                                                <th>Category One</th>
                                                <th>Category Two</th>
                                                <th>Category Three</th>
                                                <th>Total Count</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            while ($row = $result->fetch_assoc()) {
                                            ?>
                                                <tr>
                                                    <td><?php echo $row['category_name_1']; ?></td>
                                                    <td><?php echo $row['category_name_2']; ?></td>
                                                    <td><?php echo $row['category_name_3']; ?></td>
                                                    <td><?php echo $row['count']; ?></td>
                                                </tr>
                                            <?php
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
            </div>
<?php
        }
    }
}
?>



<!------------------------------------------------------------------------------- categories Wise Vendor Count -------------------------------------------------------------------------------------------------------------------->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>
</head>
<body>
    <?php
    if (isset($_GET['categorywise_vendors_count'])) {
      
        ?>
        <div class="main-content">  
            <div class="row">
                <div class="col-12">
                    <div class="col-xxl-8">
                        <div class="panel">
                            <div class="panel-header">
                                <h5>CategoryWise Vendor Count</h5>
                                <div id="tableSearch"></div>
                            </div>
                            <div class="panel-body">
    <div class="table-filter-option">
        <div class="col-xl-10 col-md-10 col-9 col-xs-12">
            <form method="POST" class="d-flex align-items-center">
                <select id="searchsp" name="category_id" data-placeholder="Select Category" required>
                    <option value="">Choose</option>
                    <?php
                    $sql = "SELECT * FROM category";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['category_id'] . "'>" . $row['category_name'] . "</option>";
                        }
                    }
                    ?>
                </select> &nbsp;&nbsp;
                <button type="submit" name="submit_category" class="btn btn-primary btn-sm">Submit</button>
            </form>
            <br>
            <?php
            if(isset($_POST['submit_category'])) {
                $vid = $_POST['category_id'];
                $query = "SELECT * FROM category WHERE category_id = '$vid'";

                $result = $conn->query($query);
                if ($result && $result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    echo "<i>Category Name / Category Id: <span class='text-warning'>" . $row['category_name'] . " / " . $row['category_id'] . "</span></i>";
                } else {
                    echo "Selected category not found";
                }
            }
            ?>
        </div>
        <br>
        <table class="table table-dashed recent-order-table" id="myTable">
            <thead>
                <tr>
                    <th>Sr.no</th>
                    <th>Primary Category</th>
                    <th>Secondary Category</th>
                    <th>Third Category</th>
                    <th>TotalCount</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if(isset($_POST['submit_category'])){
                    $category_id = $_POST['category_id'];
                    $stmt = $conn->prepare("SELECT 
                        SUM(category_id = ?) AS category_count,
                        SUM(sec_cat_id = ?) AS sec_cat_count,
                        SUM(ter_cat_id = ?) AS ter_cat_count
                    FROM vendor_info");
                    $stmt->bind_param("iii", $category_id, $category_id, $category_id);
                    $stmt->execute();
                    $count_result = $stmt->get_result();

                    if ($count_result && $count_result->num_rows > 0) {
                        $count_row = $count_result->fetch_assoc();
                        ?>
                        <tr>
                            <td>1</td>
                            <td><?php echo $count_row['category_count']; ?></td>
                            <td><?php echo $count_row['sec_cat_count']; ?></td>
                            <td><?php echo $count_row['ter_cat_count']; ?></td>
                            <?php
                            $add = $count_row['category_count'] + $count_row['sec_cat_count'] + $count_row['ter_cat_count'];
                            ?>
                            <td ><span class="badge bg-black"><?php echo $add; ?></td>
                        </tr>
                        <?php
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
            </div>
        </div>

        <script>
            $("#searchsp").chosen();
        </script>
        <?php
    }
    ?>
</body>
</html>


<!-----------------------------------------------------------------------package_features------------------------------------------------------------------->
    
    <?php
    if (isset($_GET['package_features'])) {
        $id = $_GET['id'];
        $query = "SELECT * FROM package_details WHERE package_id = $id";
        $result = mysqli_query($conn, $query); 

        if (isset($_POST['update_features'])) {
            $feature_name = $_POST['feature_name'];

            $update_query = "UPDATE package_details SET feature_name = '$feature_name' WHERE package_id = $id";
            if (mysqli_query($conn, $update_query)) {
                echo '<script>';
                echo 'alert("Feature Name Updated Successfully");';
                echo 'window.location.href="view.php?packages=true";';
                echo '</script>';
            } else {
                echo "Error updating feature name: " . mysqli_error($conn);
            }
        }
        ?>

        
        <div class="main-content">
            <div class="dashboard-breadcrumb mb-25">
                <h2>Edit Feature Name</h2>
                <div class="btn-box">
                    <a href="view.php?packages" class="btn btn-sm btn-primary">View All Packages</a>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="panel">
                        <div class="panel-header">
                            <h5>Basic Information About Feature</h5>
                        </div>
                        <form method="post" enctype="multipart/form-data">
                            <div class="panel-body">
                                <div class="row g-3">
                                    <?php while ($row_feature = mysqli_fetch_assoc($result)) { ?>
                                        <div class="col-xxl-3 col-lg-4 col-sm-6">
                                            <label class="form-label">Feature Name</label>
                                            <input type="text" name="feature_name" value="<?php echo $row_feature['feature_name']; ?>" class="form-control form-control-sm" required>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-12 d-flex">
                                <button type="submit" class="btn btn-sm btn-success" value="submit" name="update_features">Save Feature Name</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
    } 
    ?>




<!-------------------------------------------------------- view_services_all---------------------------------------------------------------------------------------------------------------- -->
<?php
if (isset($_GET['view_services_all'])) {
    $stmt = $conn->prepare("SELECT s.service_id, s.service_name, c.category_name FROM services s INNER JOIN category c ON s.category_id = c.category_id");
    if ($stmt) {
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
?>
            <div class="main-content">
                <div class="row">
                    <div class="col-12">
                        <div class="col-xxl-8">
                            <div class="panel">
                                <div class="panel-header">
                                    <h5>All Services&nbsp;&nbsp;</h5>
                                    <!-- <img src="assets/images/happy.gif" style="height: 52px; width: 63px;"> -->
                                    <div id="tableSearch"></div>
                                </div>
                                <div class="panel-body">
                                    <table class="table table-dashed recent-order-table" id="myTable">
                                        <thead>
                                            <tr>
                                                <th>Service ID</th>
                                                <th>Service Name</th>
                                                <th>Category Name</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            while ($row = $result->fetch_assoc()) {
                                            ?>
                                                <tr>
                                                    <td><?php echo $row['service_id']; ?></td>
                                                    <td><?php echo $row['service_name']; ?></td>
                                                    <td><?php echo $row['category_name']; ?></td>
                                                </tr>
                                            <?php
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
            </div>
<?php
        } else {
            echo "No billing details found.";
        }
    }
}
?>



<!----------------------------------------------------------------------------------- question_answer -------------------------------------------------------------------------------------------->
<?php
if (isset($_GET['question_answer'])) {
    ?>
    <div class="main-content">
        <div class="row">
            <div class="col-12">
                <div class="col-xxl-12">
                    <div class="panel">
                        <div class="panel-header">
                            <h5>Question & Answer : -</h5>
                            <div id="tableSearch"></div>
                        </div>
                        <div class="panel-body">
                            <div class="table-filter-option">
                                <br>    
                                <style>
                                    .message-scroll {
                                        width: 200px;
                                        overflow-x: auto;
                                        white-space: nowrap;
                                    }
                                </style>
                                <form method="POST" action="edit.php">
                                    <table class="table table-dashed recent-order-table" id="myTable">
                                        <thead>
                                            <tr>
                                                <th>Sr.no</th>
                                                <th>Question</th>
                                                <th>Answer</th>
                                                <th>Update</th>
                                                <th>Delete</th>
                                                <th>Timestamp</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // Assuming $conn is your database connection object
                                            $stmt = $conn->prepare("SELECT * from question_answer");

                                            if ($stmt) {
                                                $stmt->execute();
                                                $service_result = $stmt->get_result();
                                                $i = 1;

                                                while ($max = $service_result->fetch_assoc()) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $i; ?></td>
                                                        <td>
                                                            <div class="message-scroll">
                                                                <?php echo $max['question']; ?>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="message-scroll">
                                                                <?php echo $max['answer']; ?>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <a href="edit.php?edit_qa&id=<?php echo $max['id']; ?>">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <a href="delete.php?delete_qa&id=<?php echo $max['id']; ?>">
                                                                <i class="fas fa-trash"></i>
                                                            </a>
                                                        </td>
                                                        <td><?php echo $max['timestamp']; ?></td>
                                                    </tr>
                                                    <?php
                                                    $i++;
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </form>
                                <div class="table-bottom-control"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>


<!-- qr logo cover update -->

<?php
if (isset($_GET['logoupdate'])) {
    $vid = $_GET['vid'];
    $sql_images = "SELECT * FROM vendor_info WHERE vid = $vid";
    $result_images = mysqli_query($conn, $sql_images);
    $row_images = mysqli_fetch_assoc($result_images);
   
    if ($row_images) {
        // Display the images
?>
        <div class="main-content">
            <div class="dashboard-breadcrumb mb-25">
                <h2>Existing Images</h2>
            </div>
            <form method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-12">
                        <div class="panel">
                            <div class="panel-body">
                                <div class="row g-3">
                                    <div class="col-xxl-3 col-lg-4 col-sm-6">
                                        <label class="form-label">Current Logo</label>
                                        <img class="img-fluid" src="../../gallery/vendor_logo/<?php echo $row_images['vendor_logo']; ?>" alt="Current Logo" style="border-radius: 100px; height:50px; width:100px">
                                        <input type="file" name="vendor_logo">
                                    </div>
                                    <div class="col-xxl-3 col-lg-4 col-sm-6">
                                        <label class="form-label">Current Cover Image</label>
                                        <img class="img-fluid" src="../../gallery/cover_image/<?php echo $row_images['Vendor_cover_image']; ?>" alt="Current Cover Image" style="border-radius: 100px; height:50px; width:100px">
                                        <input type="file" name="vendor_cover_image">
                                    </div>
                                    <div class="col-xxl-3 col-lg-4 col-sm-6">
                                        <label class="form-label">Current QR Code</label>
                                        <img class="img-fluid" src="../../gallery/qr_code/<?php echo $row_images['qr_code']; ?>" alt="Current QR Code" style="border-radius: 100px; height:50px; width:100px">
                                        <input type="file" name="qr_code">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" name="update_image" class="btn btn-primary">Update Images</button>
            </form>
        </div>
<?php
    }
}
?>

<?php
if (isset($_POST['update_image'])) {
    $vid = $_GET['vid'];

    // Handle logo upload
    if ($_FILES['vendor_logo']['tmp_name']) {
        $logo_path = '../../gallery/vendor_logo/' . time() . $_FILES['vendor_logo']['name'];
        move_uploaded_file($_FILES['vendor_logo']['tmp_name'], $logo_path);
        // Update database with $logo_path
        mysqli_query($conn, "UPDATE vendor_info SET vendor_logo = '$logo_path' WHERE vid = $vid");
    }

    // Handle cover image upload
    if ($_FILES['vendor_cover_image']['tmp_name']) {
        $cover_image_path = '../../gallery/cover_image/' . time() . $_FILES['vendor_cover_image']['name'];
        move_uploaded_file($_FILES['vendor_cover_image']['tmp_name'], $cover_image_path);
        // Update database with $cover_image_path
        mysqli_query($conn, "UPDATE vendor_info SET Vendor_cover_image = '$cover_image_path' WHERE vid = $vid");
    }

    // Handle QR code upload
    if ($_FILES['qr_code']['tmp_name']) {
        $qr_code_path = '../../gallery/qr_code/' . time() . $_FILES['qr_code']['name'];
        move_uploaded_file($_FILES['qr_code']['tmp_name'], $qr_code_path);
        // Update database with $qr_code_path
        mysqli_query($conn, "UPDATE vendor_info SET qr_code = '$qr_code_path' WHERE vid = $vid");
    }

    // Display alert message after update
    echo '<script>alert("Images updated successfully!");</script>';
}
?>



<?php include "footer.php"; ?>


















