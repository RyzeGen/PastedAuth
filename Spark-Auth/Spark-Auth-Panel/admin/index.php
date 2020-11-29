<?php
session_start();
include("../functions/spark_main.php");

if(isset($_SESSION["username"]) && isset($_SESSION["access"]) && $_SESSION["access"] == md5(spark_security::openssl_crypto(spark_security::get_ip()))){
$query = $conn->query("SELECT * FROM Spark_data WHERE Spark_username='" . spark_security::anti_sql_string(spark_security::openssl_decrypto($_SESSION["username"])) . "'");
if($query->num_rows != 0){
while($spark_row = $query->fetch_assoc()){
if ($spark_row['Spark_admin'] == '1') {}
else{
header("Location: ..\login.php"); exit();
}
}
}
else{
echo "invalid user"; exit();
}
}
else{
header("Location: ..\login.php"); exit();
}
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["tokens"])) {
for ($value = 0; $value < $_POST["tokensammount"]; $value++) {
$conn->query("INSERT INTO spark_keys(spark_key, spark_days, spark_used) VALUES ('".strtoupper(spark_security::random_string(22))."', '".spark_security::anti_sql_string($_POST["daysammount"])."', '0')");
header("Refresh:0");
}
}
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["hwidreset"])){
$conn->query("UPDATE spark_data SET spark_hwid=NULL WHERE spark_username='".spark_security::anti_sql_string($_POST["resetuser"])."'");
header("Refresh:0");
}
?>
<!DOCTYPE html>
<html style="height: 100%;">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
<link rel="stylesheet" href="../css/style.css">
<title>Panel | SparkAuth</title>
</head>

<body style="height: 100%;">
<div class="login-dark" style="background-color: #303841;height: 100%;font-size: 50px;">
<Form action="" autocomplete="off" method="post" style="max-width: 400px;">
<div class="form-group text-center">
<h4 class="text-center text-white" style="font-weight: bold;">Panel Gen Keys</h4>
</div>
<div class="form-group text-center">
<div class="form-group"><input class="form-control" type="text" name="tokensammount" placeholder="How Many Keys"></div>
<div class="form-group"><input class="form-control" type="text" name="daysammount" placeholder="How Many Days"></div>
<div class="form-group"><button name="tokens" class="btn btn-dark btn-block page-button glow-on-hover" type="submit">Generate</button>
</div>
<div class="form-group text-center">
<h4 class="text-center text-white" style="font-weight: bold;">Panel Reset HWID</h4>
</div>
<div class="form-group text-center">
<div class="form-group"><input class="form-control" type="text" name="resetuser" placeholder="Username"></div>
<div class="form-group"><button name="hwidreset" class="btn btn-dark btn-block page-button glow-on-hover" type="submit">Reset HWID</button>
</div>
<div class="form-group text-center">
<h4 class="text-center text-white" style="font-weight: bold;">All Keys</h4>
</div>
<div class="form-group text-center">
<a href="keys.php" class="btn btn-dark btn-block page-button glow-on-hover" type="submit">Keys</a>
</div>
<div class="form-group text-center">
<a href="../dashboard.php" class="btn btn-dark btn-block page-button glow-on-hover" type="submit">Back</a>
</div>
</Form>
</div>
</body>
</html>