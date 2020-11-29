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
?>
<!DOCTYPE html>
<html style="height: 100%;">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <title>Panel | SparkAuth</title>
    <style>
table, th, td {
  border: 2px solid #303841;
  padding: 5px;
  margin-left: 15%;
}
table {
  border-spacing: 15px;
}
</style>
</head>
<body class="text-center" style="height: 100%;">
<div class="login-dark text-center" style="background-color: #303841;height: 100%;font-size: 25px;">
<Form action="" autocomplete="off" method="post" style="max-width: 800px;">

<table class="text-center">
    <thead>
        <tr>
            <th>Key</th>
            <th>Days</th>
            <th>Used</th>
        </tr>
    </thead>
    <tbody>
    <?php
        $result = $conn->query("SELECT * FROM spark_keys");

        while($spark_row = $result->fetch_assoc()){
        ?>
        <tr>
            <form>
                <td><?php echo  $spark_row["spark_key"]?></td>
                <td><?php echo  $spark_row["spark_days"]?></td>
                <td><?php echo  $spark_row["spark_used"]?></td>
            </form>
        </tr>
        <?php
                }
        ?>
    </tbody>
</table>
<div class="form-group text-center">
<a href="index.php" class="btn btn-dark btn-block page-button glow-on-hover" type="submit">Back</a>
</div>
</Form>
</div>
</body>
</html>