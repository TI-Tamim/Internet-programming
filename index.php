<?php
// Include the database connection file
include 'config.php';

if (isset($_POST['reg'])) {
    // Retrieve form data
    $fname = mysqli_real_escape_string($con, $_POST['fname']);
    $lname = mysqli_real_escape_string($con, $_POST['lname']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $pn = mysqli_real_escape_string($con, $_POST['pn']);
    $passwordd = $_POST['pass'];
    $confirm_password = $_POST['confirm_password'];
    $gender = mysqli_real_escape_string($con, $_POST['gender']);

    // Check if passwords match
    if ($passwordd === $confirm_password) {
        // Check if email already exists in the user2 table
        $query = "SELECT * FROM user2 WHERE email = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Email already exists
            echo "<script>
                    alert('Email already used'); 
                    window.location.href='index.php';
                  </script>";
        } else {
            // Hash the password before storing it
            $hashed_password = password_hash($passwordd, PASSWORD_BCRYPT);

            // Insert new user into the user2 table
            $insertion = "INSERT INTO user2 (fname, lname, email, pn, passwordd, gender) 
                          VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $con->prepare($insertion);
            $stmt->bind_param("ssssss", $fname, $lname, $email, $pn, $hashed_password, $gender);

            if ($stmt->execute()) {
                echo "<script>
                        alert('You are successfully registered.'); 
                        window.location.href='log.php';
                      </script>";
            } else {
                echo "<script>
                        alert('Registration failed. Please try again.'); 
                        window.location.href='index.php';
                      </script>";
            }
        }
    } else {
        echo "<script>
                alert('Passwords do not match.'); 
                window.location.href='index.php';
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en-us">
<head>
    <meta charset="UTF-8">
    <title>Register page</title>
    <link rel="stylesheet" type="text/css" href="style.css" media="all" />
    <link href="https://fonts.cdnfonts.com/css/night-sky" rel="stylesheet"/>
    <link href="https://fonts.cdnfonts.com/css/airplanes-in-the-night-sky"rel="stylesheet">
</head>
<body>
    <div class="Register-now">
        <form action="index.php" method="post">
         <h1 class="font">Crafty Hands</h1>
            <div class="input-style">
                <label for="a">First Name</label>
                <input type="text" name="fname" placeholder="First Name" required id="a">
                <label for="b">Last Name</label>
                <input type="text" name="lname" placeholder="Last Name" required id="b">
                <label for="c">Email</label>
                <input type="email" name="email" placeholder="Your Email" required id="c">
                <label for="d">Phone Number</label>
                <input type="text" name="pn" placeholder="Enter your mobile number" required id="d">
                <label for="e">Password</label>
                <input type="password" name="pass" placeholder="Enter your Password" required id="e">
                <label for="f">Confirm Password</label>
                <input type="password" name="confirm_password" placeholder="Confirm Password" required>
               <label for="gender">Gender</label>
                <select name="gender" id="gender" required>
                    <option value="" disabled selected>Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                    
                </select>
            </div>
            <div class="register-page">
                <input type="submit" name="reg" value="Registration">
            </div>
            <div class="login">
                <input type="submit" name="reg" value="LOGIN">
            </div>
        </form>
    </div>
</body>
</html>
