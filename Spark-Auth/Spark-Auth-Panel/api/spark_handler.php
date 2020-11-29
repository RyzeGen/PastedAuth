<?php
include ("../functions/spark_main.php");

if(isset($_GET["login"])) {
    if (spark_api_login(spark_security::decrypt($_POST["username"]), spark_security::decrypt($_POST["password"]), spark_security::decrypt($_POST["hwid"]))) {
        echo spark_security::encrypt(spark_response::$spark_api_login);
        exit();
    } else {
        echo spark_security::encrypt(spark_response::$spark_api_login);
        exit();
    }
} else if(isset($_GET["register"])){
    if (api_register(spark_security::decrypt($_POST["username"]), spark_security::decrypt($_POST["email"]), spark_security::decrypt($_POST["password"]), spark_security::decrypt($_POST["token"]))) {
        echo spark_security::encrypt(spark_response::$spark_api_register);
        exit();
    } else {
        echo spark_security::encrypt(spark_response::$spark_api_register);
        exit();
    }
} else if(isset($_GET["activate"])){
    if(api_activate(spark_security::decrypt($_POST["username"]), spark_security::decrypt($_POST["token"]))){
        echo spark_security::encrypt(spark_response::$spark_api_activate);
        exit();
    } else {
        echo spark_security::encrypt(spark_response::$spark_api_activate);
        exit();
    }
} else if(isset($_GET["keylogin"])){
    if(api_keylogin(spark_security::decrypt($_POST["token"]), spark_security::decrypt($_POST["tokenemail"]), spark_security::decrypt($_POST["hwid"]))){
        echo spark_security::encrypt(spark_response::$spark_api_keylogin);
        exit();
    } else {
        echo spark_security::encrypt(spark_response::$spark_api_keylogin);
        exit();
    }
} else if(isset($_GET["init"])){
    if(api_init(spark_security::decrypt($_POST["name"]), spark_security::decrypt($_POST["version"]), spark_security::decrypt($_POST["key"]))){
        echo spark_security::encrypt(spark_response::$spark_api_init);
        exit();
    } else {
        echo spark_security::encrypt(spark_response::$spark_api_init);
        exit();
    }
}