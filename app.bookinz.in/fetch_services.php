<?php
include "db.php";

// Check if category ID is received via POST
if(isset($_POST['categoryId'])) {
    // Sanitize the received category ID
    $categoryId = $conn->real_escape_string($_POST['categoryId']);
    
    // Step 1: Get vid from URL
    $vid = $conn->real_escape_string($_GET['vid']); // Assuming vid is passed in the URL

    // Prepare and execute SQL query to fetch services based on the selected category ID
    $sql = "SELECT 
                v.vendor_name,
                s.service_name,
                sc.service_id,
                s.category_id,
                sc.charges2,
                   sc.time_taken,
                v.show_time_rate
            FROM 
                service_charges sc
            JOIN 
                vendor_info v ON sc.vid = v.vid
            JOIN 
                services s ON sc.service_id = s.service_id
            WHERE 
                sc.vid = '$vid' AND
                s.category_id = '$categoryId'";
    $result = $conn->query($sql);

    // Check if there are services available for the selected category
    if ($result && $result->num_rows > 0) {
        // Initialize a variable to store HTML markup for services
        $servicesHTML = '';

        // Loop through the result set and generate HTML for each service
        while ($row = $result->fetch_assoc()) {
            // Generate HTML markup for each service
            $servicesHTML .= '<div class="row mt-4">';
            $servicesHTML .= '<div class="col-lg-12 inone">';
            $servicesHTML .= '<div class="left-content">';
            $servicesHTML .= '<h3 class="ser_name">' . $row['service_name'] . '</h3>';
            $servicesHTML .= '<span>';
       if ($row['show_time_rate'] == 1) {
    $servicesHTML .= '<p class="time"><img src="gallery/clock.png" alt="">' . $row['time_taken'] . '</p>';
    $servicesHTML .= '<span class="upper" style="margin-bottom:-10px"> •</span>';
}
            $servicesHTML .= '<p>&nbsp;₹' . $row['charges2'] . '</p>';
            $servicesHTML .= '</span>';
            $servicesHTML .= '</div>';
            $servicesHTML .= '<div class="right-content">';
            $servicesHTML .= '<div class="checkbox-wrapper-29">';
            $servicesHTML .= '<label class="checkbox">';
            $servicesHTML .= '<input type="checkbox" class="checkbox__input" name="selectedServices[]" value="' . $row['service_name'] . '|' . $row['charges2'] . '" />';
            $servicesHTML .= '<span class="checkbox__label"></span>';
            $servicesHTML .= '</label>';
            $servicesHTML .= '</div>';
            $servicesHTML .= '</div>';
            $servicesHTML .= '</div>';
            $servicesHTML .= '</div>';
            $servicesHTML .= '<hr>';
        }

        // Return the generated HTML markup for services
        echo $servicesHTML;
    } else {
        // If no services are found for the selected category, return a message
        echo 'No services found for the selected category.';
    }
} else {
    // If category ID is not received via POST, return an error message
    echo 'Category ID is not provided.';
}
?>


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
                 