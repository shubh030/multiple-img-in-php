<?php
// Database connection file
include('dbConn.php');

// Fetch data from mulimg table
$query = mysqli_query($con, "SELECT * FROM mulimg");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Fetch Data and Image from Table</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }
        
        th, td {
            text-align: left;
            padding: 10px;
        }
        
        th {
            background-color: #f2f2f2;
        }
        
        tr:nth-child(even) {
            background-color: #f7f7f7;
        }

        td img {
            max-width: 100px;
            height: auto;
            border-radius: 5px;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .deleteBtn {
            background-color: #ff5454;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .deleteBtn:hover {
            background-color: #ff0000;
        }
        .editBtn {
        /* Add your desired styles for the edit button here */
        color: blue;
        font-size: 16px;
        padding: 5px 10px;
        background-color: #f0f0f0;
        border: none;
        cursor: pointer;
    }

        /* Animation for row deletion */
        @keyframes fadeOut {
            0% {
                opacity: 1;
            }
            100% {
                opacity: 0;
                display: none;
            }
        }

        .deleted-row {
            animation: fadeOut 0.5s ease;
        }
    </style>
</head>
<body>
    <h2>Data and Image from mulimg Table</h2>

    <?php if(mysqli_num_rows($query) > 0) { ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
            
            <?php while($row = mysqli_fetch_assoc($query)) { ?>
            <tr id="row_<?php echo $row['id']; ?>">
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><img src="uploads/<?php echo $row['img']; ?>" width="100" height="100"></td>
                <td>
                   <button class="editBtn"> <a href="edit.php?id=<?php echo $row['id']; ?>">Edit</a></button>
                    <button class="deleteBtn" data-id="<?php echo $row['id']; ?>">Delete</button>
                </td>
            </tr>
            <?php } ?>
        </table>
    <?php } else { ?>
        <p>No records found.</p>
    <?php } ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
    $(document).ready(function() {
        // Add event listener for delete buttons
        $('.deleteBtn').click(function() {
            if(confirm('Are you sure you want to delete this record?')) {
                var id = $(this).data('id'); // Get the ID of the record to delete
                
                // Send Ajax request to delete.php
                $.ajax({
                    url: 'delete.php',
                    method: 'POST',
                    data: {id: id},
                    success: function(response) {
                        // Handle the response from the server
                        if(response.success) {
                            alert('Row deleted successfully');
                            $('#row_' + id).fadeOut(500, function() {
                                $(this).remove();
                               // Reload the page after deletion
                            });
                        } else {
                            alert('Failed to delete row');
                        }
                    },
                    error: function() {
                        alert('An error occurred');
                    }
                });
            }
        });
    });
</script>

</body>
</html>
