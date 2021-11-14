<?php
require_once "config.php";

$username = $password = $confirm_password = $email ="";
$username_err = $password_err = $confirm_password_err = "";

if ($_SERVER['REQUEST_METHOD'] == "POST"){

    // Check if username is empty
    if(empty(trim($_POST["email"]))){
        $username_err = "email cannot be blank";
    }
    else{
        $sql = "SELECT id FROM user_info WHERE email = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if($stmt)
        {
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set the value of param username
            $param_email = trim($_POST['email']);

            // Try to execute this statement
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1)
                {
                    $email_err = "This username is already taken"; 
                }
                else{
                    $email = trim($_POST['email']);
                }
            }
            else{
                echo "Something went wrong";
            }
        }
    }

    mysqli_stmt_close($stmt);


    // Check for password
    if(empty(trim($_POST['password']))){
        $password_err = "Password cannot be blank";
    }
    elseif(strlen(trim($_POST['password'])) < 8){
        $password_err = "Password cannot be less than 8 characters";
    }
    else{
        $password = trim($_POST['password']);
    }

    // Check for confirm password field
    if(trim($_POST['password']) !=  trim($_POST['cpassword'])){
        $password_err = "Passwords should match";
    }

    $username = $_POST['fullname'];
    // If there were no errors, go ahead and insert into the database
    if(empty($email_err) && empty($password_err) && empty($confirm_password_err))
    {
        $sql = "INSERT INTO users (username, password,email) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt)
        {
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password, $param_email);

            // Set these parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            $param_email = $email;
            // Try to execute the query
            if (mysqli_stmt_execute($stmt))
            {
                header("location: login.php");
            }
            else{
                echo "Something went wrong... cannot redirect!";
            }
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sign up on e-learning</title>
    <link rel="stylesheet" href="./css/for_signup_and_login.css">
</head>
<body>
    <nav>
        <h1>E-Learning</h1>
        <div class="items">
            <a href="./index.html" target="_blank">Home</a>
            <a href="./login.html" target="_blank">Login</a>
        </div>
    </nav>
    <form action="" method="get">
        <div class="container signup_form">
            <h1>SignUp</h1>
            <div class="name">
            <input type="text" name="first_name" id="first_name" placeholder="First Name">
            <input type="text" name="last_name" id="last_name" placeholder="Last Name">    
            </div>
            <input type="email" name="username" id="username" placeholder="Email">
            <input type="password" name="password" id="password" placeholder="Password">
            <input type="password" name="cpassword" id="cpassword" placeholder="Confirm Password">
            <input type="submit" value="signup" id="signup">
        </div>
    </form>
</body>
</html>