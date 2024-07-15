<?php
session_start();
if (!isset($_SESSION["admin_login"]))
    header("location:login.php");
?>


<?php include 'header.php'; ?>
<?php include "../db.php"; ?>


    <!-- main content start -->
    <div class="main-content">
        <div class="dashboard-breadcrumb mb-25">
            <h2>Dashboard</h2>
        </div>
                 <?php
                $sql = "SELECT COUNT(*) as count FROM vendor_info";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                $count = $row['count'];
                ?>


    <div class="row mb-25">
            <div class="col-lg-3 col-6 col-xs-12">
                <div class="dashboard-top-box rounded-bottom panel-bg">
                    <div class="left">
                    <h3><?php echo $count; ?></h3>
                        <p>Total Vendors</p>
                        <a href="view.php?categorywise_vendors=true">View All Vendors</a>
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
            $sql = "SELECT COUNT(*) as count FROM services";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $count = $row['count'];
            ?>


            <div class="col-lg-3 col-6 col-xs-12">
                <div class="dashboard-top-box rounded-bottom panel-bg">
                    <div class="left">
                    <h3><?php echo $count; ?></h3>
                        <p>Total Services </p>
                        <a href="view.php?view_services=true">Virw All Details</a>
                    </div>
                    <div class="right">
                        <span class="text-primary">+</span>
                        <div class="part-icon rounded">
                            <span><i class="fa-light fa-bag-shopping"></i></span>
                        </div>
                    </div>
                </div>
            </div>



            <?php
     
            $sql = "SELECT COUNT(*) as count FROM packages";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $count = $row['count'];
            ?>



            <div class="col-lg-3 col-6 col-xs-12">
                <div class="dashboard-top-box rounded-bottom panel-bg">
                    <div class="left">
                    <h3><?php echo $count; ?></h3>
                        <p>Total Packages</p>
                        <a href="view.php?packages=true">See details</a>
                    </div>
                    <div class="right">
                        <span class="text-primary">+</span>
                        <div class="part-icon rounded">
                            <span><i class="fa-light fa-user"></i></span>
                        </div>
                    </div>
                </div>
            </div>



         <?php
           
                $sql = "SELECT COUNT(*) as count FROM `lead`";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                $count = $row['count'];
                ?>


            <div class="col-lg-3 col-6 col-xs-12">
                <div class="dashboard-top-box rounded-bottom panel-bg">
                    <div class="left">
                    <h3><?php echo $count; ?></h3>
                        <p>Total Leads</p>
                        <a href="view.php?leads_count=true">Leads Count</a>
                    </div>
                    <div class="right">
                        <span class="text-primary">+</span>

                         <img src="assets/gif/rocket-unscreen.gif" style="height: 65px; width: 95px;">

                    </div>
                </div>
            </div>
     </div>




<?php

$sql = "SELECT image FROM advertise";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $imageUrls[] = $row['image'];
    }
}
?>





<link rel="stylesheet" href="assets/vendor/css/swiper-bundle.min.css">
<style>
    .swiper-slide {
        width: 300px; /* Set the desired width */
        height: 200px; /* Set the desired height */
    }
    .swiper-slide img {
        width: 100%;
        height: 100%;
        object-fit: cover; /* Ensure the image covers the container */
    }
</style>

<div class="col-12">
    <div class="panel">
        <div class="panel-header">
            <h5>Our Advertise</h5>
        </div>
        <div class="panel-body">
            <div class="swiper effect-coverflow-swiper">
                <div class="swiper-wrapper">
                    <?php foreach ($imageUrls as $imageUrl): ?>
                        <div class="swiper-slide">
                         
                            <img src="../..<?php echo $imageUrl; ?>" alt="image">
                            
                          
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </div>
</div>
<script src="assets/vendor/js/swiper-bundle.min.js"></script>
<script>
    var swiper = new Swiper('.swiper', {
        effect: 'flip',
        pagination: {
            el: '.swiper-pagination',
        },
    });
</script>
<hr>
<div class="row">
    <div class="col-xxl-8">
        <div class="panel">
            <div class="panel-header">
                <h5>Recently Added 10 Vendors &nbsp;<img src="assets/gif/status2.gif" style="height: 30px; width: 35px;"></h5>
                <div id="tableSearch"></div>
            </div>
            <div class="panel-body">
                <table class="table table-dashed recent-order-table" id="myTable">
                    <thead>
                        <tr>
                            <th>Sr.no</th>
                            <th>View Detail</th>
                            <th>ContactNo.</th>
                            <th>whatsappNo.</th>
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
                            $stmt = $conn->prepare("SELECT v.*,
                            c1.category_name AS category_name_1,
                            c2.category_name AS category_name_2,
                            c3.category_name AS category_name_3
                            FROM vendor_info v
                            JOIN category c1 ON v.category_id = c1.category_id
                            JOIN category c2 ON v.sec_cat_id = c2.category_id
                            JOIN category c3 ON v.ter_cat_id = c3.category_id
                            ORDER BY v.vid DESC
                            LIMIT 10");


                            if ($stmt) {
                                $stmt->execute();
                                $result = $stmt->get_result();
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
                                        <td><?php echo $row['phone']; ?></td>
                                        <td><?php echo $row['whatsapp_number']; ?></td>
                                        <td><a href="<?php echo $row['url']; ?>"><span class="badge bg-warning">Link</span></a></td>
                                        <td class="text-primary"><?php echo $row['vbiz']; ?></td>
                                        <td><?php echo $row['city']; ?></td>
                                        <td><?php echo $row['category_name_1']; ?></td>
                                        <td><?php echo $row['category_name_2']; ?></td>
                                        <td><?php echo $row['category_name_3']; ?></td>
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




<?php include 'footer.php'; ?>