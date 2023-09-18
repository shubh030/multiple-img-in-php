<?php
// Database connection file
include('dbConn.php');

if(isset($_POST['submit']))
{
    // Counting number of names
    $count = count($_POST["name"]);

    // Getting post values
    $name = $_POST["name"];
    $images = $_FILES["image"];

    if($count > 0)
    {
        for($i = 0; $i < $count; $i++)
        {
            if(trim($name[$i]) != '' && !empty($images["name"][$i]))
            {
                // Get the file extension
                $file_ext = strtolower(pathinfo($images["name"][$i], PATHINFO_EXTENSION));
                
                // Generate a unique name for the image
                $new_filename = uniqid() . '.' . $file_ext;
                
                // Set the file path where the image will be saved
                $target_dir = 'uploads/';
                $target_path = $target_dir . $new_filename;

                // Upload the image file
                if(move_uploaded_file($images["tmp_name"][$i], $target_path)) {
                    // Insert the name and image into the database
                    $sql = mysqli_query($con, "INSERT INTO mulimg (name, img) VALUES ('$name[$i]', '$new_filename')");
                } else {
                    echo "<script>alert('Failed to upload image');</script>";
                }
            }
        }
        echo "<script>alert('Records inserted successfully');</script>";
    }
    else
    {
        echo "<script>alert('Please enter name');</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multiple Img</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<style>
        /* Add your CSS styles here */
        body {
            font-family: Arial, sans-serif;
        }

        .table {
            width: 80%;
            margin: 0 auto;
            border-collapse: collapse;
        }

        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .form-control {
            width: 100%;
            padding: 5px;
            box-sizing: border-box;
        }

        .btn-success {
            background-color: #28a745;
            color: #fff;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }

        .btn-danger {
            background-color: #dc3545;
            color: #fff;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
    </style>
<body>
<form name="add_name" id="add_name" method="post" enctype="multipart/form-data">
<div class="table-responsive">
<table class="table table-bordered" id="dynamic_field">
<tr>
<td><input type="text" name="name[]" placeholder="Enter your Name" class="form-control name_list" /></td>
<td><input type="file" name="image[]" class="form-control" accept="image/*"></td>
<td><button type="button" name="add" id="add" class="btn btn-success">Add More</button></td>
</tr>
</table>

<input type="submit" name="submit" id="submit" class="btn btn-info" value="Submit" />
</div>

</form>
</body>
<script>
$(document).ready(function(){
    var i = 1;
    
    $('#add').click(function(){
        i++;
        $('#dynamic_field').append('<tr id="row'+i+'"><td><input type="text" name="name[]" placeholder="Enter your Name" class="form-control name_list" /></td><td><input type="file" name="image[]" class="form-control" accept="image/*"></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
    });

    $(document).on('click', '.btn_remove', function(){
        var button_id = $(this).attr("id"); 
        $('#row'+button_id+'').remove();
    });
});
</script>
</html>
