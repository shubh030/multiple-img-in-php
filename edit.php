<?php
// Database connection file
include('dbConn.php');

// Check if ID parameter is set in the URL
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Fetch record from mulimg table based on ID
    $query = mysqli_query($con, "SELECT * FROM mulimg WHERE id = '$id'");
    
    // Check if record exists
    if(mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_assoc($query);
        
        // Display the form to edit the record
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Edit Record</title>
        </head>
        <body>
            <h2>Edit Record</h2>

            <form method="post" action="update.php" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <label>Name:</label>
                <input type="text" name="name" value="<?php echo $row['name']; ?>"><br><br>
                <label>Image:</label>
                <input type="file" name="image"><br><br>
                <button type="submit">Update</button>
            </form>
        </body>
        </html>
        <?php
        
        // Close the database connection
        mysqli_close($con);
        exit;
    }
}

// If record doesn't exist or ID parameter is not set, redirect back to the main page
header("Location: view.php");
exit;
?>
