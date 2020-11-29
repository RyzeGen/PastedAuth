<?php
session_start();
include("functions/spark_main.php"); 
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(spark_activate($_SESSION["username"], $_POST["key"])){
        header("Location: dashboard.php");
        exit();
    }
    elseif(spark_response::$spark_activate != ""){
        echo spark_response::$spark_activate; exit();
    }
    else{
        echo "unknown error"; exit();
    }
}
?>


<!DOCTYPE html>
<html style="height: 100%;">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Protocol | Renew</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body style="height: 100%;">
    <div class="login-dark" style="background-color: #303841;height: 100%;font-size: 50px;">
        <form method="post" style="max-width: 400px;">
            <h2 class="sr-only">Prodigal | Log-In</h2>
            <h4 class="text-center text-white" style="font-weight: bold;">Renew License</h4>
            <div class="form-group text-center">
            <div class="form-group"><input autocomplete="off"  class="form-control" type="text" name="key" placeholder="License"></div>
            <button style="width:35%; margin-left:5%; margin-right:5%;" class="btn btn-dark page-button glow-on-hover" type="submit">Renew</button>
            <a href="dashboard.php" style="width:35%; margin-left:5%; margin-right:5%;" class="btn btn-dark page-button glow-on-hover" type="submit">Back</a>
            <div class="form-group"> 
            </div>
            </div>
        </form>
    </div>
</body>

</html>