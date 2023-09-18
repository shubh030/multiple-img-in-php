<?php
// Database connection file
include('dbConn.php');

if(isset($_POST['id'])) {
    $id = $_POST['id']; // Get the ID from the Ajax request

    // Delete record from mulimg table based on ID
    $query = mysqli_query($con, "DELETE FROM mulimg WHERE id = '$id'");

    if($query) {
        $response = array('success' => true);
        echo json_encode($response);
    } else {
        $response = array('success' => false);
        echo json_encode($response);
    }
}
?>
