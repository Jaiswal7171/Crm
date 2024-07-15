<?php include "db.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inquiry Form </title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="./responsive.css">
    <script src="./script.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>




<style>

.data div {
    display: inline-block;
  
}
.btn-selected {  
    color: white;
    font-weight: bold;
    border: none;
    z-index: 1;
}
.btn-selected:hover {
    color: white !important; 
}
.category-btn{
    color: black !important;
}
.category-btn.btn-selected {
    color: white !important; /* Set text color of selected button to white */
}

.btn.category-btn::-webkit-scrollbar {
    width: 8px;
    height: 4px;
}
.btn.category-btn::-webkit-scrollbar-thumb {
    background: #ED004E; 
    border-radius: 4px;
}
.btn.category-btn::-webkit-scrollbar-thumb:hover {
    background: #555; 
}
</style>


</head>

<body>
    <form id="multiPageForm" class="myheights form-content" action="config.php" method="POST" onsubmit="return validateCheckbox()" enctype="multipart/form-data">
        <div class="page active" id="page1">
    <?php
         if(isset($_GET['vbiz']) && isset($_GET['vid'])) {    // get the vid from url And vbiz also
        $vbiz = $_GET['vbiz']; 
        $vid = intval($_GET['vid']);
        $sql = "SELECT * FROM vendor_info WHERE vbiz = ? AND vid = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("si", $vbiz, $vid);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $location = $row['location'];
                $city = $row['city'];
                $address = $row['address'];
                $vendor_logo = $row['vendor_logo'];
                $Vendor_cover_image = $row['Vendor_cover_image'];
            } else {
                echo "<script>window.location.href='NotFound.php';</script>"; 
            }
        } else {
            echo "Error: " . $conn->error;
        }
    ?>
        <img src="../gallery/cover_image/<?php echo $Vendor_cover_image; ?>" class="img-fluid banner-img" alt="Cover Image">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-12 col-sm-12 logo">
                        <img src="../gallery/vendor_logo/<?php echo $vendor_logo; ?>" style="border-radius: 50%;" height="130px">
                    </div>
                    <div class="col-lg-8 col-md-12 col-sm-12 toptext">
                        <u>
                            <h4 class="bname">
                                <?php echo $vbiz; ?>
                            </h4>
                        </u>
                        <p class="address myline"><img src="gallery/location.png">
                            <?php echo $location; ?>
                        </p> &nbsp;
                        <p class="address myline"><img src="gallery/buildings.png">
                            <?php echo $city; ?>
                        </p>
                        <p class="address"><img src="gallery/hall.png">
                            <?php echo $address; ?>
                        </p>
                    </div>
                </div>

<!------------------------------------------------------------------------img slider start--------------------------------------------------------------------------------------------------->
   <!------------------------------------------------------------------------img slider start--------------------------------------------------------------------------------------------------->



   <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
   <style>
    body {
        overflow-x: hidden; /* Prevent horizontal scrolling */
    }

    .swiper-container {
        width: 100%; /* Adjust the width as needed */
        max-width: 600px; /* Set maximum width */
        margin: 0 auto;
        margin-bottom: 10px;
        overflow: hidden; /* Hide overflow */
    }

    .swiper-slide {
        background-position: center;
        background-size: cover;
        width: 186px; /* Adjust the width as needed */
        height: 70px; /* Adjust the height as needed */
        -webkit-box-reflect: below 1px linear-gradient(transparent, transparent, #0006);
    }
</style>

</head>
<body>

<div class="swiper-container" id="swiperContainer">
    <div class="swiper-wrapper">
        <?php
        // Assuming you have established a database connection
        $sql = "SELECT image FROM banners"; // Query to fetch image paths from the "banners" table
        $result = mysqli_query($conn, $sql);

        // Check if there are any rows returned
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $imagePath = $row['image'];
                echo '<div class="swiper-slide" style="background-image:url(../gallery/banners/' . $imagePath . ')" onclick="openImage(\'../gallery/banners/' . $imagePath . '\')"></div>';
            }
        } else {
            // If no rows returned, you can handle it accordingly
            echo "No banners found.";
        }
        ?>
    </div>
    <div class="swiper-pagination"></div>
</div>

<div class="lightbox" id="lightbox">
    <span class="close-btn" onclick="closeImage()">&times;</span>
    <img id="lightbox-image" src="" alt="Large Image">
</div>

<script>
    function openImage(src) {
        document.getElementById('lightbox-image').src = src;
        document.getElementById('lightbox').style.display = 'flex';
    }

    function closeImage() {
        document.getElementById('lightbox').style.display = 'none';
    }
</script>



    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        var swiperContainer = document.getElementById('swiperContainer');
        var swiperWrapper = swiperContainer.querySelector('.swiper-wrapper');
        var slides = swiperWrapper.children.length;

        // Function to duplicate slides
        function duplicateSlides() {
            var originalSlides = swiperWrapper.children;
            var originalSlidesCount = originalSlides.length;
            for (var i = 0; i < originalSlidesCount; i++) {
                var clone = originalSlides[i].cloneNode(true);
                swiperWrapper.appendChild(clone);
            }
        }

        var swiperParams = {
            pagination: '.swiper-pagination',
            loop: true,
            autoplay: {
                delay: 5000, // Delay between transitions in milliseconds
                disableOnInteraction: false, // Stop autoplay on user interaction
            }
        };

        if (slides === 1) {
            swiperParams.effect = 'fade';
            swiperParams.fadeEffect = {
                crossFade: true
            };
            swiperParams.centeredSlides = true;
            swiperParams.slidesPerView = 'auto'; // Set to 'auto' for one slide
            document.body.style.overflow = 'hidden'; // Disable body scrolling
        } else if (slides === 2) {
            swiperParams.slidesPerView = 2; // Set to 2 for two slides
            swiperParams.spaceBetween = 10;
        } else if (slides === 3) {
            // Duplicate slides if there are exactly three
            duplicateSlides();
            swiperParams.effect = 'coverflow'; // Use coverflow effect for three slides
            swiperParams.grabCursor = true;
            swiperParams.centeredSlides = true;
            swiperParams.slidesPerView = 'auto';
            swiperParams.coverflow = {
                rotate: 20,
                stretch: 0,
                depth: 200,
                modifier: 1,
                slideShadows: true,
            };
            swiperParams.preventClicks = false; // Allow clicks on slides
        } else if (slides > 3) {
            swiperParams.effect = 'coverflow'; // Use coverflow effect for more than three slides
            swiperParams.grabCursor = true;
            swiperParams.centeredSlides = true;
            swiperParams.slidesPerView = 'auto';
            swiperParams.coverflow = {
                rotate: 20,
                stretch: 0,
                depth: 200,
                modifier: 1,
                slideShadows: true,
            };
            swiperParams.preventClicks = false; // Allow clicks on slides
        }

        var swiper = new Swiper('.swiper-container', swiperParams);
    });
</script>





<!------------------------------------------------------------------------img slider End--------------------------------------------------------------------------------------------------->


<?php
$vid = $conn->real_escape_string($_GET['vid']); 
$vbiz = $conn->real_escape_string($_GET['vbiz']); 
$sql = "SELECT DISTINCT sc.category_id, c.category_name 
        FROM service_charges sc 
        JOIN category c ON sc.category_id = c.category_id 
        WHERE sc.vid = $vid";

$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    // Initialize a counter for the number of buttons
    $buttonCount = 0;
    echo '<div class="btn-container" id="btnContainer">';
    
    // Loop through each row to fetch category names and store them in the array
    while($row = $result->fetch_assoc()) {
        $category_id = $row["category_id"];
        $category_name = $row["category_name"];
        
        // Increment the button count
        $buttonCount++;

    
        $btnClass = "";
        switch($buttonCount) {
            case 1:
                $btnClass = "btn-first";
                break;
            case 2:
                $btnClass = "btn-second";
                break;
            case 3:
                $btnClass = "btn-third";
                break;
            default:
                $btnClass = "btn-default"; // Default style
                break;
        }
    //    button ouiptu here :-   
        echo '<button type="button" class="btn category-btn ' . $btnClass . '" data-category-id="' . $category_id . '" data-category-name="' . $category_name . '" style="width:200px; height:50px; overflow:auto; white-space: nowrap;">' . $category_name . '</button>';// ===================================

    // Add a space between buttons
    echo ' ';
    }
    echo '</div>'; // Close btn-container
    } else {
    echo "No category found for vid = $vid and vbiz = $vbiz";
    }
    ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){
    // Add click event handler to category buttons
    $('.category-btn').click(function(){
        // Remove underline from all buttons
        $('.category-btn').removeClass('btn-selected').css('color', ''); // Remove btn-selected class and reset text color
        // Underline the text of the clicked button and set text color to white
        $(this).addClass('btn-selected').css('color', 'white');

        // Set text color to black for buttons not selected
        $('.category-btn:not(.btn-selected)').css('color', 'black');
    });
});

</script>


<!------------------------------------------------------------------------------- Fetch service here-------------------------------------------------------------------------------------------->
<div id="services-container">
    <!-- fetched services display here  -->
</div>

<!------------------------------------------------------------------------------- Fetch service here-------------------------------------------------------------------------------------------->


<script>
    $(document).ready(function() {
        // Get the default category ID
        var defaultCategoryId = $(".category-btn:first").data("category-id");

        // Function to fetch services for a given category ID
        function fetchServices(categoryId) {
            $.ajax({
                url: "fetch_services.php?vid=<?php echo $vid ?>&vbiz=<?php echo $vbiz ?>",
                type: "POST",
                data: { categoryId: categoryId },
                success: function(response) {
                    $("#services-container").html(response);
                }
            });
        }

        // Fetch default services for the default category on page load
        fetchServices(defaultCategoryId);

        // Event listener for category buttons
        $(".category-btn").click(function() {
            var categoryId = $(this).data("category-id");
            fetchServices(categoryId); // Fetch services for the selected category
        });
    });
</script>

                <div class="row mybtns ">
                    <div class="col text-right">
                        <!-- <button type="button" class="btn btn-next btn-grad" onclick="nextPage()">Next</button> -->
                        <button type="button" id="nextButton" class="btn btn-next btn-grad" onclick="nextPage()" disabled>Next</button>
                    </div>
                </div>

            </div>

        

            <script>
                function handleCheckboxChange() {
                    var nextButton = document.getElementById('nextButton');
                    var atLeastOneChecked = document.querySelector('.checkbox__input:checked');
                    nextButton.disabled = !atLeastOneChecked;
                }
                var checkboxes = document.querySelectorAll('.checkbox__input');
                checkboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', handleCheckboxChange);
                });
            </script>

            <!-- =========footern start ======= -->
            <footer id="footer" style="padding-top: -25px !important;">
                <p class="power">Powered by <a href="https://vyavsaay.co.in/vdpl/Lead_genration/v_admin/login.php"><img src="gallery/footer.png"
                            class="footerimg" alt=""></a></p>
            </footer>
          
        </div>



<!--------------------------------------------------------------------------------------- Page 2 ------------------------------------------------------------------------------------------------------------------>
        <div class="page" id="page2">
            <div class="appointment">
                <div class="container">
                    <div class="row new mt-1">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <img src="gallery/left-arrow.png" onclick="prevPage()" class="arrow" alt="">
                            <h3 class="text-center">Appointment Date</h3>
                            <p class="text-center">Select date and time</p>
                        </div>
                    </div>
                    <div class="row mt-4 " style="margin-left: -10px !important; padding-left: -10px;">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <h3 class="ser_name ">Selected Services</h3>
                        </div>
                    </div>
<!-------------------------------------------------------------------------------- Selected Servicce Show Javascript------------------------------------------------------------------------------------------------------------------>

                    <script>
                        function updateSelectedServices() {
                            var selectedServicesContainer = document.getElementById('selectedServicesContainer');
                            var totalChargesContainer = document.getElementById('totalChargesContainer');
                            var checkboxes = document.querySelectorAll('input[name="selectedServices[]"]:checked');
                            var selectedservicename = document.getElementById('selectedservicename');

                            // Clear existing content
                            selectedServicesContainer.innerHTML = '';

                            // Initialize total charges
                            var totalCharges = 0;

                            // Initialize service names array
                            var selectedServiceNames = [];

                            // Iterate through selected checkboxes and update the UI
                            checkboxes.forEach(function (checkbox) {
                                var [serviceName, charge] = checkbox.value.split('|');
                                var html = `
                                <div class="col-lg-4 col-md-4 col-sm-6">
                                    <h3 class="ser_name">${serviceName}</h3>
                                    <p>₹${charge}</p>
                                </div>
                            `;
                                selectedServicesContainer.innerHTML += html;

                                selectedServiceNames.push(serviceName);


                                totalCharges += parseFloat(charge);
                            });

                            // Display total charges
                            totalChargesContainer.innerHTML = `Total Charges: ₹${totalCharges.toFixed(2)}`;

                            // Display selected service names in the additional format
                            var serviceNamesContainer = document.getElementById('serviceNamesContainer');
                            serviceNamesContainer.innerHTML = selectedServiceNames.map(function (serviceName) {
                                return `
                            <div class="col-lg-4 col-md-4 col-sm-6">
                                <h3 class="ser_name">${serviceName}</h3>
                            </div>
                        `;
                            }).join('');
                        }

                        // Attach event listener to checkboxes
                        var checkboxes = document.querySelectorAll('input[name="selectedServices[]"]');
                        checkboxes.forEach(function (checkbox) {
                            checkbox.addEventListener('change', updateSelectedServices);
                        });
                    </script>
                    <div class="container">
                        <div id="selectedServicesContainer" class="row mt-3"></div>
                    </div>

                    <hr>
 <!---------------------------------------------------------------------------------------Dynamic Time----------------------------------------------------------------------------------------------------------------------------- -->
                    
                    <div class="row mycalendar mt-4">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="selectdate">
                <?php
                // Get the current date in the desired format
                $currentDate = date("d/m/y");
                ?>
                <div class="mydate-container">
                    
                    <input type="text" id="selectedDate" name="selected_Date"  value="<?php echo $currentDate; ?>" onchange="fetchData()" class="mydate2" required>
                </div>
            </div>
        </div>
    </div>

<div id="userData">
   <?php include "fetch_data2.php";?>
</div>

<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
    $(function () {
        $(".mydate2").datepicker({
            dateFormat: "dd/mm/y",
            minDate: 0, // Set minimum date to today
            maxDate: "+30d", // Allow selection up to 30 days in the future
            onSelect: function (dateText) {
                fetchData(dateText);
                displaySelectedDate(dateText);
            }
        });

        // Fetch data based on the initial selected date and vendor ID from the URL
        fetchData($("#selectedDate").val());
        displaySelectedDate($("#selectedDate").val());
    });

    function fetchData(dateText) {
        // Convert the selected date format to 'Y-m-d'
        // var formattedDate = dateText.split('/').reverse().join('-');
        var formattedDate = dateText.split('/').reverse().join('-');

        

        // Get vendor ID from the URL
        var vid = new URLSearchParams(window.location.search).get('vid');

        // Send AJAX request
        $.ajax({
            type: 'POST',
            url: 'fetch_data2.php?vid=' + vid,
            data: { selectedDate: formattedDate }, // Send the formatted date
            success: function (data) {
                $('#userData').html(data);
            },
            error: function () {
                alert('Error fetching data.');
            }
        });
    }

    function displaySelectedDate(dateText) {
    if (!dateText) {
        // If no date is selected, display the current date
        dateText = $.datepicker.formatDate("dd/mm/y", new Date());
    }
    $("#selectedDateInfo").html("<p>" + dateText + "</p>");
}

</script>

</div>
</div>




<footer  style=";width: 100%;   text-align: center;">
 
   <p class="power">Powered by <a href="https://vyavsaay.co.in/vdpl/Lead_genration/v_admin/login.php"><img src="gallery/footer.png"
                    class="footerimg" alt=""></a></p>
 </footer>
 


</div>
</div>



<!------------------------------------------------------------Page 3----------------------------------------------------------------------------------------------------------------------------- -->
<div class="page" id="page3">
    <div class="container  third-page" id="ment">
        <div class="row new head mt-1">
            <div class="col-lg-12">
                <img src="gallery/left-arrow.png" onclick="prevPage()" class="arrow" alt="">
                <h3 class="text-center">Your Appointment</h3>
                <p class="text-center">
                    <?php echo $vbiz; ?>
                </p>
            </div>
        </div>
        <div class="row" style="margin-top: -10px;">
        <div class="col-lg-12">
                <img src="gallery/mylist.png" class="selected_ser" alt="" style="margin-top:17px;">

                <div id="serviceNamesContainer" class="row mt-3"></div>
            </div>
                <div class="col-lg-12 mt-3">
                <img src="gallery/calendar.png" class="selected_ser" alt="">

                <div class="data">
                    <h3 class="mt-1">Selected Date &  Time</h3>
                    <div id="selectedDateInfo"></div>
                    <div id="selected-slot"></div>
                </div>

            </div>

            <div class="col-lg-12 ">
                <h3 class="mt-1">Pricing Info</h3>
                <p class="myspace ">
                  <div class="container ">
                    <div id="totalChargesContainer" class="row mt-2"></div>
                  </div>
                  <p class="shiftleft">Pay-in-person</p>
                </p>
            </div>
        </div> 

        <div class="row topp coninfo">
    <div class="col-lg-12">
        <h3 class="pen">Contact Info</h3>
        <div class="shiftleft">
            
            <div class="user-box">
                <input type="text" name="lead_name" placeholder="Enter Your Full Name" required>
            </div>

            <div class="user-box">
                <input type="text" name="contact_no" placeholder="Enter Your Mobile Number" pattern="[6789][0-9]{9}" maxlength="10" required>
            </div>

            <div class="user-box">
                <input type="email" id="email" placeholder="Enter Your Email" name="email" required pattern="[^\s@]+@[^\s@]+\.[^\s@]+" title="Please enter a valid email address" >
            </div>
          <div class="user-box">
                 <input type="hidden" name="vid" value="<?php echo isset($_GET['vid']) ? htmlspecialchars($_GET['vid']) : ''; ?>" style="display: none;">
             </div>



          <?php
                $sql = "SELECT * FROM vendor_info WHERE vid = $vid";
                $result = $conn->query($sql);
                
                if ($result && $result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    if ($row['homeService'] == 2) {
                ?>
                        <h3 class="preference">Choose Your Preference</h3>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                            <label class="form-check-label pen" for="inlineRadio1">On-site</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2" checked>
                            <label class="form-check-label pen" for="inlineRadio2">Home Service</label>
                        </div>
                        <div class="user-box" id="remoteLocation">
                            <input type="text" name="lead_address" placeholder="Enter Your Remote Location" required>
                        </div>
                <?php
                    } elseif ($row['homeService'] == 1) {
                        echo 'Soory No home service Avialble';
                    } elseif ($row['homeService'] == 0) {
                        echo '<div class="user-box" id="remoteLocation">
                            <input type="text" name="lead_address" placeholder="Enter Your Remote Location" required>
                        </div>';
                    }
                } 
                ?>

        </div>
    </div>
</div>



<?php
    }

?>


        <div class="row mt-2 topp">
            <div class="col-lg-12">
                <h3>Cancellation Policy</h3>
                <img src="gallery/cancle.png" class="selected_ser data1" alt="">
                <div class="data">
                    <p>If you made a booking & cannot attend, please cancel your booking in advance.</p>
                </div>
            </div>
        </div>

        <!-- new row -->
        <div class="row topp">
            <div class="col-lg-12">
                <div class="checkbox-wrapper-29"
                    style="float: left !important; margin-top: 20px !important;margin-left: 4px;">
                    <label class="checkbox">
                        <input type="checkbox" name="condition[]" class="checkbox__input" />
                        <span class="checkbox__label"></span>
                    </label>

                </div>

                <div class="data">
                    <p>If you made a booking & cannot attend, please cancel your booking in advance.</p>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="final_amount" id="totalChargesInput">

    <script>
        document.getElementById('multiPageForm').addEventListener('submit', function () {
            var totalChargesString = document.getElementById('totalChargesContainer').innerHTML;
            var numericValue = parseFloat(totalChargesString.replace(/[^\d.]/g, ''));
            document.getElementById('totalChargesInput').value = numericValue;
        });
    </script>


    <div class="btn-group mt-4 lastbtn mybtns bottombtn" id="twobtns" style="margin-top: 0px;">
        <button type="button" class="btn btn-prev btn-grad" onclick="prevPage()">Previous</button>
        <button type="submit" name="lead_save" class="btn btn-grad">Submit</button>
    </div>

    <?php include "footer.php";?>
</div>
</form>


<!----------------------------------------------------------Radio Button Start ------------------------------------------------------------------------------------------------------------------------->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var remoteRadio = document.getElementById('inlineRadio2');
        var remoteLocation = document.getElementById('remoteLocation');
        function handleRadioChange() {
            if (remoteRadio.checked) {
                remoteLocation.style.display = 'block';
                remoteLocation.querySelector('input').setAttribute('required', 'required');
            } else {
                remoteLocation.style.display = 'none';
                remoteLocation.querySelector('input').removeAttribute('required');
            }
        }
        handleRadioChange();
        remoteRadio.addEventListener('change', handleRadioChange);
        document.getElementById('inlineRadio1').addEventListener('change', handleRadioChange);
    });
</script>

<!----------------------------------------------------------Radio Button End ------------------------------------------------------------------------------------------------------------------------->





<script>
    function validateCheckbox() {
        var checkbox = document.querySelector('input[name="selectedServices[]"]:checked');
        var checkbox_t = document.querySelector('input[name="condition[]"]:checked');
        if (!checkbox || !checkbox_t) {
            alert('All Fields Are Mandatory');
            return false;
        }
        return true; // Allow form submission
    }
</script>

<script>
    let currentPage = 1;
    const form = document.getElementById('multiPageForm');

    function nextPage() {
        if (currentPage < 3) {
            currentPage++;
            scrollToTop();
            updatePageVisibility();
        }
    }

    function prevPage() {
        if (currentPage > 1) {
            currentPage--;
            scrollToTop();
            updatePageVisibility();
        }
    }

    function updatePageVisibility() {
        const pages = document.querySelectorAll('.page');
        pages.forEach((page, index) => {
            if (index + 1 === currentPage) {
                page.classList.add('active');
            } else {
                page.classList.remove('active');
            }
        });
    }

    function scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: "smooth" // Optional: Adds smooth scrolling effect
        });
    }
</script>



<!------------------------------------------------------------------------Next nad privious Buuton ------------------------------------------------------------------------------------------------------------------------->


<script>
    let slideIndex = 0;
    const slides = document.querySelectorAll('.slide');
    const numSlides = slides.length;

    function showSlides() {
        slides.forEach((slide, index) => {
            if (index >= slideIndex && index < slideIndex + 3) {
                slide.style.display = 'block';
                if (index === slideIndex + 1) {
                    slide.classList.add('middle');
                } else {
                    slide.classList.remove('middle');
                }
            } else {
                slide.style.display = 'none';
            }
        });
    }

    function nextSlide() {
        slideIndex++;
        if (slideIndex >= numSlides - 2) {
            slideIndex = 0;
        }
        showSlides();
        document.querySelector('.slider').classList.add('slide-left');
        setTimeout(() => {
            document.querySelector('.slider').classList.remove('slide-left');
        }, 500); // Adjust the duration of animation as needed
    }

    function prevSlide() {
        slideIndex--;
        if (slideIndex < 0) {
            slideIndex = numSlides - 3;
        }
        showSlides();
        document.querySelector('.slider').classList.add('slide-right');
        setTimeout(() => {
            document.querySelector('.slider').classList.remove('slide-right');
        }, 500); // Adjust the duration of animation as needed
    }



    // Function to display large image
    function showLargeImage(slide) {
        var imgSrc = slide.querySelector('img').src;
        document.getElementById('largeImage').src = imgSrc;
        document.getElementById('largeImageContainer').style.display = 'block';
    }

    // Function to hide large image
    function hideLargeImage() {
        document.getElementById('largeImageContainer').style.display = 'none';
    }

    let touchStartX, touchEndX;

    // Function to handle touch start event
    function handleTouchStart(event) {
        touchStartX = event.touches[0].clientX;
    }

    // Function to handle touch move event
    function handleTouchMove(event) {
        touchEndX = event.touches[0].clientX;
    }

    // Function to handle touch end event and determine swipe direction
    function handleTouchEnd() {
        if (Math.abs(touchStartX - touchEndX) > 50) { // Ensure a minimum swipe distance
            if (touchStartX - touchEndX > 50) { // Swipe left
                nextSlide();
            } else if (touchEndX - touchStartX > 50) { // Swipe right
                prevSlide();
            }
        }
    }

    // Add event listeners for touch events on the slider only
    document.querySelector('.slider').addEventListener('touchstart', handleTouchStart, false);
    document.querySelector('.slider').addEventListener('touchmove', handleTouchMove, false);
    document.querySelector('.slider').addEventListener('touchend', handleTouchEnd, false);

    // Call showSlides initially to display the first set of slides
    showSlides();
    
    //==========Automatic Slider code ==========
       // Automatic slide functionality
    let autoSlideInterval;

function startAutoSlide() {
    autoSlideInterval = setInterval(nextSlide, 4000); // Adjust slide interval as needed (3000 milliseconds = 3 seconds)
}

function stopAutoSlide() {
    clearInterval(autoSlideInterval);
}


showSlides();

startAutoSlide();

</script>


</body>

</html>