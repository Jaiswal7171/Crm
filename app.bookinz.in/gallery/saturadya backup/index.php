<?php include "db.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inquiry Form </title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="responsive.css">
    <script src="script.js"></script>
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
</head>

<body>

    <form id="multiPageForm" class="myheights" action="config.php" method="POST" onsubmit="return validateCheckbox()"
        enctype="multipart/form-data">
        <div class="page active" id="page1">
            <?php
            $sql = "SELECT * FROM vendor_info WHERE vendor_id='7'";
            $result = $conn->query($sql);



            // Check if any rows were returned
            if ($result->num_rows > 0) {
                // Output data of the first row
                $row = $result->fetch_assoc();
                $location = $row['location'];
                $vendor_business_name = $row['vendor_business_name'];
                $city = $row['city'];
                $address = $row['address'];
                $location = $row['location'];
                $vendor_logo = $row['vendor_logo'];
                $Vendor_cover_image = $row['Vendor_cover_image'];
            }
            ?>
            <img src="gallery/<?php echo $Vendor_cover_image; ?>" class="img-fluid banner-img" alt="Cover Image">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-12 col-sm-12 logo">
                        <img src="gallery/<?php echo $vendor_logo; ?>" style="border-radius: 50%;" height="130px">
                    </div>
                    <div class="col-lg-8 col-md-12 col-sm-12 toptext">
                        <u>
                            <h4 class="bname">
                                <?php echo $vendor_business_name; ?>
                            </h4>
                        </u>
                        <p class="address myline"><img src="gallery/location.png">
                            <?php echo $location; ?>
                        </p>
                        <p class="address myline"><img src="gallery/buildings.png">
                            <?php echo $city; ?>
                        </p>
                        <p class="address"><img src="gallery/hall.png">
                            <?php echo $address; ?>
                        </p>
                    </div>
                </div>


                <!---------------------------------- ======================img slider start================================= -->
                <?php
    $sql = "SELECT * FROM banners WHERE vendor_id='7'";
    $result = $conn->query($sql);

    // Check if any rows were returned
    if ($result->num_rows > 0) {
        ?>
        <div class="slider">
            <div class="slides">
                <?php
                while ($row = $result->fetch_assoc()) {
                    // Assuming there is a column in your database table named 'image_path'
                    $imagePath = $row['image'];
                    ?>
                    <div class="slide" onclick="openImage('gallery/<?php echo $imagePath; ?>')">
                        <img src="gallery/<?php echo $imagePath; ?>" alt="Image">
                    </div>
                    <?php
                }
                ?>
            </div>

            <div class="prev" onclick="prevSlide()"><i class="fa fa-chevron-left"></i></div>
            <div class="next" onclick="nextSlide()"><i class="fa fa-chevron-right"></i></div>
        </div>
        <?php
    }
?>
                <!-- Lightbox container -->
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

                    function prevSlide() {
                        // Implement your logic to navigate to the previous slide
                    }

                    function nextSlide() {
                        // Implement your logic to navigate to the next slide
                    }
                </script>
                <!-- ========================end img slider start======================= -->

                <br>
                <div class="row new" style="flex-wrap: nowrap !important;">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <h4 class="cat_name"> Select Services</h4>
                    </div>
                </div>

                <?php

                $sql = "SELECT 
            v.vendor_name,
            s.service_name,
            sc.service_id,
            s.category_id,
            sc.charges2,
            sc.time_taken
        FROM 
            service_charges sc
        JOIN 
            vendor_info v ON sc.vendor_id = v.vendor_id
        JOIN 
            services s ON sc.service_id = s.service_id
        WHERE 
            sc.vendor_id = '7';";
                $result = $conn->query($sql);


                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <div class="row mt-4">
                            <div class="col-lg-12 inone">
                                <div class="left-content">
                                    <h3 class="ser_name">
                                        <?php echo $row['service_name']; ?>
                                    </h3>
                                    <span>
                                        <p class="time"><img src="gallery/clock.png" alt="">
                                            <?php echo $row['time_taken']; ?>
                                        </p>
                                        <span class="upper" style="margin-bottom:-10px"> •</span>
                                        <p>&nbsp;₹
                                            <?php echo $row['charges2']; ?>
                                        </p>
                                    </span>
                                </div>

                                <div class="right-content">
                                    <div class="checkbox-wrapper-29">
                                        <label class="checkbox">
                                            <input type="checkbox" class="checkbox__input" name="selectedServices[]"
                                                value="<?php echo $row['service_name'] . '|' . $row['charges2']; ?>" />
                                            <span class="checkbox__label"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <?php
                    }
                } else {
                    echo "No Services Found !";
                }
                $conn->close();
                ?>


                <div class="row mybtns">
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
                <p class="power">Powered by <a href="https://vyavsaay.co.in/"><img src="gallery/footer.png"
                            class="footerimg" alt=""></a></p>
            </footer>
            <!-- =========footern end ======= -->
        </div>


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





                    <!------------------------------------------------------------ validation  for date 30 days ----------------------------------------------------------------------------------------------------------------------------- -->




                 


                    <hr>
                    <!------------------------------------------------------------***----------------------------------------------------------------------------------------------------------------------------- -->
                    <!------------------------------------------------------------Dynamic Time----------------------------------------------------------------------------------------------------------------------------- -->
                    <div class="row mycalendar mt-4">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="selectdate">
            <?php
            // Get the current date in the desired format
            $currentDate = date("d/m/y");
            ?>
            <input type="text" id="selectedDate" value="<?php echo $currentDate; ?>" onchange="displaySelectedDate()"
                name="selected_Date" class="mydate2" required>
        </div>
    </div>
</div>





<div id="userData">
    <?php include 'fetch_data2.php'; ?>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>






<script>
    $(function () {
        $(".mydate2").datepicker({
            dateFormat: "dd/mm/y",
            minDate: 0, // Set minimum date to today
            maxDate: "+30d", // Allow selection up to 30 days in the future
            onSelect: function (dateText) {
                displaySelectedDate(dateText);
                fetchData(dateText);
            }
        });

        // Initialize with the current date
        displaySelectedDate($(".mydate2").val());
    });

    function displaySelectedDate(dateText) {
        if (dateText) {
            $("#selectedDateInfo").text("Selected date: " + dateText);
        } else {
            // If no date is selected, display the current date
            var currentDate = $.datepicker.formatDate("dd/mm/y", new Date());
            $("#selectedDateInfo").text("Selected date: " + currentDate);
        }
    }

    function fetchData(selectedDate) {
        $.ajax({
            type: 'POST',
            url: 'fetch_data2.php',
            data: { selectedDate: selectedDate },
            success: function (data) {
                $('#userData').html(data);
            },
            error: function () {
                alert('Error fetching data.');
            }
        });
    }
</script>

</body>

</html>

<!------------------------------------------------------------------******---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->




<div class="btn-group data3 mt-4 mybtns">
    <button type="button" class="btn btn-prev btn-grad" onclick="prevPage()">Previous</button>
    <button type="button" class="btn btn-grad" onclick="nextPage()">Next</button>
</div>

</div>
</div>

<!-- =========footern start ======= -->
<footer id="footer" style="padding-top: -25px !important;">
    <p class="power">Powered by <a href="https://vyavsaay.co.in/"><img src="gallery/footer.png" class="footerimg"
                alt=""></a></p>
</footer>
<!-- =========footern end ======= -->

</div>
</div>

<!------------------------------------------------------------Page 3----------------------------------------------------------------------------------------------------------------------------- -->
<div class="page" id="page3">

    <!-- container start -->
    <div class="container  third-page" id="ment">

        <div class="row new head mt-1">
            <div class="col-lg-12">
                <img src="gallery/left-arrow.png" onclick="prevPage()" class="arrow" alt="">
                <h3 class="text-center">Your Appointment</h3>
                <p class="text-center">
                    <?php echo $vendor_business_name; ?>
                </p>
            </div>
        </div>

        <div class="row" style="margin-top: -10px;">

        
            <div class="col-lg-12 mt-3">
    <img src="gallery/calendar.png" class="selected_ser" alt="">
    <div class="data">
        <h3 id="selectedDateInfo"></h3>
        <div id="selected-slot"></div>
    </div>
</div>    
         
    
            <div class="col-lg-12 ">
                <h3 class="mt-1">Pricing Info</h3>
                <p class="myspace">
                <div class="container">
                    <div id="totalChargesContainer" class="row mt-2"></div>
                </div>
                <p>Pay in person</p>
                </p>
            </div>

        </div> <!-- end row -->

        <!-- new row -->
        <div class="row topp coninfo">
            <div class="col-lg-12">
                <h3 class="pen">Contact Info</h3>
                <div class="">

                    <div class="user-box">
                        <input type="text" name="lead_name" placeholder="Enter Your Full Name" required>
                    </div>

                    <div class="user-box">
                        <input type="text" name="contact_no" placeholder="Enter Your Mobile Number"
                            pattern="[6789][0-9]{9}" maxlength="10" required>
                    </div>

                    <div class="user-box">
                    <input type="email" placeholder="Enter Your Email" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" name="email" required>

                    </div>

                    <?php
    $sql = "SELECT * FROM vendor_info WHERE vendor_id='7'";
    $result = $conn->query($sql);

    // Check if any rows were returned
    if ($result->num_rows > 0) {
        // Output data of the first row
        $row = $result->fetch_assoc();

        if ($row['homeService'] == 1) {
            ?>
            <p class="preference">Choose your preference </p>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                <label class="form-check-label pen" for="inlineRadio1">On-site</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
                <label class="form-check-label pen" for="inlineRadio2">Home Service</label>
            </div>
        <?php
        }
}
?>



                    <div class="user-box" id="remoteLocation" style="display: none;">
                        <input type="text" name="lead_address" placeholder="Enter Your Remote Location" required>
                    </div>

                </div>
            </div>
        </div>

        <!-- new row -->
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
    <!-- close container -->

    <input type="hidden" name="final_amount" id="totalChargesInput">

    <script>
        document.getElementById('multiPageForm').addEventListener('submit', function () {
            // Extract numeric value from the totalChargesContainer HTML content
            var totalChargesString = document.getElementById('totalChargesContainer').innerHTML;
            var numericValue = parseFloat(totalChargesString.replace(/[^\d.]/g, ''));

            // Set the extracted numeric value to the hidden input field
            document.getElementById('totalChargesInput').value = numericValue;
        });
    </script>











    <div class="btn-group mt-4 lastbtn mybtns" style="margin-top: 0px;">
        <button type="button" class="btn btn-prev btn-grad" onclick="prevPage()">Previous</button>

        <button type="submit" name="lead_save" class="btn btn-grad"
            onclick="return validateTimeSelection();">Submit</button>

    </div>

    <!-- =========footern start ======= -->
    <footer id="footer" style="padding-top: -25px !important;">
        <p class="power">Powered by <a href="https://vyavsaay.co.in/"><img src="gallery/footer.png" class="footerimg"
                    alt=""></a></p>
    </footer>
    <!-- =========footern end ======= -->
</div>
</form>


<!--=============== Radio btn start ===================-->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var remoteRadio = document.getElementById('inlineRadio2');
        var remoteLocation = document.getElementById('remoteLocation');

        // Function to handle radio button changes
        function handleRadioChange() {
            if (remoteRadio.checked) {
                remoteLocation.style.display = 'block';
                remoteLocation.querySelector('input').setAttribute('required', 'required');
            } else {
                remoteLocation.style.display = 'none';
                remoteLocation.querySelector('input').removeAttribute('required');
            }
        }

        // Initially handle radio button state
        handleRadioChange();

        // Adding event listener for radio button changes
        remoteRadio.addEventListener('change', handleRadioChange);
        document.getElementById('inlineRadio1').addEventListener('change', handleRadioChange);
    });
</script>

<!--============ radio btn end ================ -->





<script>
    function validateCheckbox() {
        // Get the checkbox with the name 'selectedServices[]'
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



<!--===================img slider================================== -->


<!--============= img slider========================== -->

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

    // =======================================================================

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

</script>
<!-- ==================end img slider=============================== -->

<!-- ===========start form from top================ -->

<!-- <script>
   var currentPage = 1;

function prevPage(page) {
    if (page > 1) {
        document.getElementById('page' + page).classList.remove('active');
        currentPage--;
        document.getElementById('page' + currentPage).classList.add('active');
        window.scrollTo(0, 0);
    }
}

function nextPage(page) {
    if (page < 3) {
        document.getElementById('page' + page).classList.remove('active');
        currentPage++;
        document.getElementById('page' + currentPage).classList.add('active');
        window.scrollTo(0, 0);
    }
}

</script> -->






<!-- ===========start form from top================ -->

</body>

</html>