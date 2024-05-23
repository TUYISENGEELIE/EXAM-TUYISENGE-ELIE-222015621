<?php
include('enock.php');

// Check if username is set
if(isset($_REQUEST['id'])) {
    $username = $_REQUEST['id'];
    
    $stmt = $connection->prepare("SELECT * FROM work WHERE id=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $username = $row['username'];
        $password = $row['password'];
        // You may fetch other columns if needed
    } else {
        echo "Username not found.";
    }
    // Close statement after fetching data
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Record in Authors Table</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <center>
        <!-- Update User form -->
        <h2><u>Update Form of User</u></h2>
        <form method="POST" onsubmit="return confirmUpdate();">

        <label for="password">Username:</label>
            <input type="username" name="username" value="<?php echo isset($username) ? $password : ''; ?>">
            <br><br>

            <label for="password">Password:</label>
            <input type="password" name="password" value="<?php echo isset($password) ? $password : ''; ?>">
            <br><br>

            <input type="submit" name="up" value="Update">
            
        </form>
    </center>
</body>
</html>

<?php
if(isset($_POST['up'])) {
    // Retrieve updated values from form
    $password = $_POST['password'];
    
    // Update the user in the database
    $stmt = $connection->prepare("UPDATE work SET password=? WHERE id=?");
    $stmt->bind_param("ss", $password, $username);
    if ($stmt->execute()) {
        echo "User updated successfully! <br><br>
             <a href='view_users.php'>OK</a>";
        // Consider redirecting to a success page or displaying confirmation
    } else {
        echo "Error updating record: " . $stmt->error;
    }

    $stmt->close();
}

?>;
