<?php
session_start();
include("functions/spark_main.php"); 

if(isset($_SESSION["username"]) && isset($_SESSION["access"]) && $_SESSION["access"] == md5(spark_security::openssl_crypto(spark_security::get_ip()))){
    header("Location: dashboard.php"); exit();
}
else{
    
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(spark_login($_POST["username"], $_POST["password"])){
        $_SESSION["username"] = spark_security::openssl_crypto(strip_tags($_POST["username"]));
        $_SESSION["access"] = md5(spark_security::openssl_crypto(spark_security::get_ip()));

        header("Location: dashboard.php");
    }
    else{
        echo spark_response::$spark_login;
    }
}
?>

<!DOCTYPE html>
<html style="height: 100%;">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Login | Protocol</title>
</head>
<body style="height: 100%;">
    <div class="login-dark" style="background-color: #303841;height: 100%;font-size: 50px;">
        <form autocomplete="off" method="post" style="max-width: 400px;">
            <h2 class="sr-only">Protocol Login</h2>
            <div class="illustration" style="padding-top: 0px;padding-bottom: 0px;">
            <h4 class="text-center text-white" style="font-weight: bold;">Protocol Login</h4>
            </div>
            <div class="form-group"><input class="form-control" type="text" name="username" placeholder="Username"></div>
            <div class="form-group"><input class="form-control" type="password" name="password" placeholder="Password"></div>
            <div class="form-group"><button class="btn btn-dark btn-block page-button glow-on-hover" type="submit">Login</button>
            </div>
            <a style="color: #FFF;" class="forgot" href="register.php">Don't Have An Account? Register</a>
        </form>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>
