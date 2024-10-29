<!DOCTYPE html>
<form action="login.php" method="POST">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
</form>
</html>

<?php
include 'db.php';   // Include the database connection

// Start a session to store user information upon successful login
session_start();

// Check if the request is POST (indicating a form submission)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the username and password from the form submission
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare an SQL statement to retrieve the user record by username
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);  // Execute the SQL query

    // Check if the query returned exactly one row
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();  // Fetch the user data as an associative array

        // Verify the input password with the stored hashed password
        if (password_verify($password, $user['password'])) {
            // If the password is correct, store user information in the session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            // Redirect the user to the dashboard page
            header("Location: dashboard.php");
            exit();  // Stop further script execution after the redirect
        } else {
            echo "Invalid password.";  // Output message if the password is incorrect
        }
    } else {
        echo "User not found.";  // Output message if the username is not found
    }
}
?>