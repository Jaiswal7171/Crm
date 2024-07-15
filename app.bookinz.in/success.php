<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">

 <style>
         .swal2-popup .swal2-content {
            padding-bottom: 24px; /* Adjust as needed */
        }
</style>
   
</head>
<body>

<?php
if (isset($_GET['status']) && $_GET['status'] === 'success') {
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>';
    echo '<script>
        Swal.fire({
            title: "Thank You!",
            text: "Your form has been submitted successfully.",
            icon: "success",
            showConfirmButton: false
        });
        
   
    </script>';
    
 
}
?>



</body>
</html>
