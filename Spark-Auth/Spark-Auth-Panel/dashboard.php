<?php
session_start();
include("functions/spark_main.php");
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(spark_activate($_SESSION["username"], $_POST["key"])){
    }
    elseif(spark_response::$spark_activate != ""){
        echo spark_response::$spark_activate; exit();
    }
    else{
        echo "unknown error"; exit();
    }
}
if(isset($_SESSION["username"]) && isset($_SESSION["access"]) && $_SESSION["access"] == md5(spark_security::openssl_crypto(spark_security::get_ip()))){
    
}
else{
    header("Location: login.php"); exit();
}

?>
<!DOCTYPE html>
<html style="height: 100%;">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Protocol | Dashboard</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body style="height: 100%;">
    <div class="login-dark" style="background-color: #303841;height: 100%;background-repeat: no-repeat;background-position: center;">
        <form method="post" class="home-screen" style="max-width: 50%;">
            <h2 class="sr-only">Login Form</h2>
            <h4 class="text-white text-center" style="margin-bottom: 15px;margin-top: -25px;font-weight: bold;">Protocol Cheats</h4>
            <div class="form-group text-center">
                <a href="discord/" class="btn btn-dark page-button glow-on-hover" type="submit" style="width:40%; margin-left:5%; margin-right:5%;">Discord</a>
            </div>
            <div class="form-group text-center">
            <a href="" class="btn btn-dark page-button glow-on-hover" type="submit" style="width:40%; margin-left:5%; margin-right:5%;">Shop</a>
            </div>
            <div class="form-group text-center">
            <a href="logout.php" class="btn btn-dark page-button glow-on-hover" type="submit" style="width:40%; margin-left:5%; margin-right:5%;">Logout</a>
            </div>
            <div class="form-group text-center">
    <?php
    $query = $conn->query("SELECT * FROM Spark_data WHERE Spark_username='" . spark_security::anti_sql_string(spark_security::openssl_decrypto($_SESSION["username"])) . "'");
    if($query->num_rows != 0){
        while($spark_row = $query->fetch_assoc()){
            if ($spark_row['Spark_admin'] == '1') {
                echo '<a href="admin/index.php" class="btn btn-dark page-button glow-on-hover" type="submit" style="width:40%; margin-left:5%; margin-right:5%;">SparkAuth Panel</a>';
            }
            else{}
        }
    }
    ?>
    </div>
            <div>
                <?php
                $query = $conn->query("SELECT * FROM Spark_data WHERE Spark_username='" . spark_security::anti_sql_string(spark_security::openssl_decrypto($_SESSION["username"])) . "'");
                
                if($query->num_rows != 0)
                {
                    while($spark_row = $query->fetch_assoc()){
                        if ($spark_row["Spark_expires"] > time())
                {
                    echo '<div class="form-group text-center"><a href="renew.php" class="btn btn-dark page-button glow-on-hover" type="submit" style="width:40%; margin-left:5%; margin-right:5%;">Renew Lisense</a></div>';
                    echo '<h4 class="text-white text-center" style="margin-bottom: 15px;font-weight: bold;">Lisense Expires on: '. date('m/d/Y', $spark_row["Spark_expires"]) .'</h4>';
                }
                else
                {
                    echo '<Form method="post"><h4 class="text-center text-white" style="font-weight: bold;">Activate License</h4><div class="form-group text-center"><input autocomplete="off" style="width:60%; margin-left:20%; margin-right:5%;" class="form-control" type="text" name="key" placeholder="License"></div><div class="form-group text-center"><button style="width:40%; margin-left:5%; margin-right:5%;" class="btn btn-dark page-button glow-on-hover" type="submit">Activate</button></div></Form>';
                }
                    }
                }
                ?>
        </form>
        </div>
</body>
</html>