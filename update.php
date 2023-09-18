<?php
// Database connection file
include('dbConn.php');

// Check if ID parameter is set in the POST data
if(isset($_POST['id'])) {
    $id = $_POST['id'];
    
    // Fetch record from mulimg table based on ID
    $query = mysqli_query($con, "SELECT * FROM mulimg WHERE id = '$id'");
    
    // Check if record exists
    if(mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_assoc($query);
        
        // Get the values from the form inputs
        $name = $_POST['name'];
        $image = $_FILES['image'];

        // Check if a new image was uploaded
        if ($image['error'] === UPLOAD_ERR_OK) {
            $tmp_name = $image['tmp_name'];
            $new_filename = $image['name'];

            // Move the uploaded file to a desired location
            move_uploaded_file($tmp_name, "uploads/" . $new_filename);

            // Update the record in the database with the new image filename
            $update_query = mysqli_query($con, "UPDATE mulimg SET name = '$name', img = '$new_filename' WHERE id = '$id'");
        } else {
            // Update the record in the database without changing the image
            $update_query = mysqli_query($con, "UPDATE mulimg SET name = '$name' WHERE id = '$id'");
        }

        // Redirect back to the main page
        header("Location: view.php");
        exit;
    }
}

// If record doesn't exist or ID parameter is not set, redirect back to the main page
header("Location: view.php");
exit;
?>
