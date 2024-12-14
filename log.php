<?php
// Include the database connection file
include 'config.php';
session_start();

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = $_POST['password'];

    // Check if email exists in the database
    $query = "SELECT * FROM user2 WHERE email = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['passwordd'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];

            echo "<script>
                    alert('Login successful!'); 
                    window.location.href='page.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Incorrect password.'); 
                    window.location.href='log.php';
                  </script>";
        }
    } else {
        echo "<script>
                alert('Email not registered.'); 
                window.location.href='log.php';
              </script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en-us">
<head>
    <meta charset="UTF-8">
    <title>Login Page</title>
    <link rel="stylesheet" href="lgs.css">
</head>
<body>
    <div class="login-form">
        <form action="log.php" method="post">
            <h2>Login</h2>
            <div class="input-style">
                <label for="email">Email</label>
                <input type="email" name="email" placeholder="Enter your email" required>
                
                <label for="password">Password</label>
                <input type="password" name="password" placeholder="Enter your password" required>
            </div>
            <div class="login-button">
                <input type="submit" name="login" value="Login">
            </div>
        </form>
    </div>
</body>
</html>
