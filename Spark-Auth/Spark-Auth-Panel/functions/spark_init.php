<?php

include_once ("spark_settings.php");
include_once ("spark_security.php");
include_once ("spark_response.php");

function api_init($name, $version, $key){
    global $conn;

    $key_check = $conn->query("SELECT * FROM client_data WHERE client_name='".spark_security::anti_sql_string($name)."'");
    if ($key_check->num_rows != 0) {
        while ($spark_row = $key_check->fetch_assoc()) {
            if($spark_row["client_key"] == $key){
                if($spark_row["client_version"] == $version){
                    if($spark_row["client_status"] == "0"){
                        spark_response::$spark_api_init = "success";
                        return true;
                    } else {
                        spark_response::$spark_api_init = "loader_disabled";
                        return false;
                    }
                } else {
                    spark_response::$spark_api_init = "invaild_version";
                    return false;
                }
            } else {
                spark_response::$spark_api_init = "invaild_key";
                return false;
            }
        }
    } else {
        spark_response::$spark_api_init = "no_client";
        return false;
    }
}