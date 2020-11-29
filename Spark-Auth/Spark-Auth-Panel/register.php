<?php 
include("functions/spark_main.php");
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        if ($_POST["password"] == $_POST["repeat_pass"]) {
            if (spark_register($_POST["username"], $_POST["email"], $_POST["password"])) {
                header("Location: login.php");
            } else{
                echo spark_response::$spark_register; exit();
            }
        }
        else{
            echo "repeated password is wrong"; exit();
        }
    }
?>


<!DOCTYPE html>
<html style="height: 100%;">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Register | Protocol</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body style="height: 100%;">
    <div class="login-dark" style="background-color: #303841;height: 100%;font-size: 50px;">
        <form autocomplete="off" method="post" style="max-width: 400px;">
            <h2 class="sr-only">Protocol Register</h2>
            <h4 class="text-center text-white" style="font-weight: bold;">Protocol Register</h4>
            <div class="form-group"><input class="form-control" type="text" name="username" placeholder="Username"></div>
            <div class="form-group"><input class="form-control" type="text" name="email" placeholder="Email"></div>
            <div class="form-group"><input class="form-control" type="password" name="password" placeholder="Password"></div>
            <div class="form-group"><input class="form-control" type="password" name="repeat_pass" placeholder="Repeat password"></div>
            <div class="form-group"><button class="btn btn-dark btn-block page-button glow-on-hover" type="submit">Register</button>
            </div>
            <a style="color: #FFF;" class="forgot" href="login.php">Already have an account? Login</a>
        </form>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>

</html>
