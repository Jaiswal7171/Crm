<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
        
    <link rel="shortcut icon" href="favicon.png">
    <link rel="stylesheet" href="assets/vendor/css/all.min.css">
    <link rel="stylesheet" href="assets/vendor/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="assets/vendor/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="assets/vendor/css/daterangepicker.css">
    <link rel="stylesheet" href="assets/vendor/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" id="primaryColor" href="assets/css/blue-color.css">
    <link rel="stylesheet" id="rtlStyle" href="#">
    <script src="assets/vendor/js/jquery-3.6.0.min.js"></script>
    <script src="assets/vendor/js/jquery.overlayScrollbars.min.js"></script>
    <script src="assets/vendor/js/apexcharts.js"></script>
    <script src="assets/vendor/js/jquery.dataTables.min.js"></script>
    <script src="assets/vendor/js/moment.min.js"></script>
    <script src="assets/vendor/js/daterangepicker.js"></script>
    <script src="assets/vendor/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/dashboard.js"></script>
    <script src="assets/js/main.js"></script>
    <!-- for demo purpose -->
    <script>
        var rtlReady = $('html').attr('dir', 'ltr');
        if (rtlReady !== undefined) {
            localStorage.setItem('layoutDirection', 'ltr');
        }
    </script>
</head>
<body>
<?php include "db.php"; ?>


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
    
</body>
</html>