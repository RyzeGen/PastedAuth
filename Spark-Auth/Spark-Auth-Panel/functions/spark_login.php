<?php

include_once ("spark_settings.php");
include_once ("spark_security.php");
include_once ("spark_response.php");

function spark_login($spark_username, $spark_password) {
    global $conn;

    if (!empty($spark_username)) {
        $spark_user_check = $conn->query("SELECT * FROM spark_data WHERE Spark_username='" . spark_security::anti_sql_string($spark_username) . "'");
        if ($spark_user_check->num_rows != 0) {
            if (!empty($spark_password)) {
                while ($spark_row = $spark_user_check->fetch_assoc()) {
                    if(password_verify($spark_password, $spark_row["Spark_password"])){
                        $conn->query("UPDATE spark_data SET spark_ip='".spark_security::anti_sql_string(spark_security::get_ip())."' WHERE Spark_username='".spark_security::anti_sql_string($spark_username)."'");

                        spark_response::$spark_login = "success";
                        return true;
                    }
                    else{
                        spark_response::$spark_login = "wrong_password";
                        return false;
                    }
                }
            }
            else{
                spark_response::$spark_login = "empty_password";
                return false;
            }
        }
        else{
            spark_response::$spark_login = "invalid_username";
            return false;
        }
    }
    else{
        spark_response::$spark_login = "empty_username";
        return false;
    }
}

function spark_api_login($spark_username, $spark_password, $spark_hwid){
    global $conn;

    if (!empty($spark_username)) {
        $spark_user_check = $conn->query("SELECT * FROM Spark_data WHERE Spark_username='" . spark_security::anti_sql_string($spark_username) . "'");
        if ($spark_user_check->num_rows != 0) {
            if (!empty($spark_password)) {
                while ($spark_row = $spark_user_check->fetch_assoc()) {
                    if(password_verify($spark_password, $spark_row["Spark_password"])){
                        if ($spark_row["Spark_expires"] > time()) {
                            if (strlen($spark_row["Spark_hwid"]) != 0) {
                                if ($spark_row["Spark_hwid"] == $spark_hwid) {
                                    $spark_ip = spark_security::get_ip();
                                    $conn->query("UPDATE Spark_data SET Spark_ip='".spark_security::anti_sql_string($spark_ip)."' WHERE Spark_username='".spark_security::anti_sql_string($spark_username)."'");

                                    $token = spark_security::random_string(43);
                                    $time = time() + 180;

                                    $conn->query("INSERT INTO Spark_tokens (spark_token, spark_expires) VALUES ('".spark_security::anti_sql_string($token)."', '".spark_security::anti_sql_string($time)."')");

                                    $convertedTime = date('m/d/Y', $spark_row["Spark_expires"]);

                                    spark_response::$spark_api_login = "logged_in|" . $token . "|" . $spark_username . "|" . $convertedTime;
                                    return true;
                                } else {
                                    spark_response::$spark_api_login = "wrong_hwid";
                                    return false;
                                }
                            }
                            else{
                                $conn->query("UPDATE Spark_data SET Spark_hwid='".spark_security::anti_sql_string($spark_hwid)."' WHERE Spark_username='".spark_security::anti_sql_string($spark_username)."'");
                                $spark_ip = spark_security::get_ip();
                                $conn->query("UPDATE Spark_data SET Spark_ip='".spark_security::anti_sql_string($spark_ip)."' WHERE Spark_username='".spark_security::anti_sql_string($spark_username)."'");

                                $token = spark_security::random_string(43);
                                $time = time() + 180;

                                $conn->query("INSERT INTO Spark_tokens (Spark_token, Spark_expires) VALUES ('".spark_security::anti_sql_string($token)."', '".spark_security::anti_sql_string($time)."')");

                                spark_response::$spark_api_login = "logged_in|" . $token;
                                return true;
                            }
                        }
                        else{
                            spark_response::$spark_api_login = "no_sub";
                            return false;
                        }
                    }
                    else{
                        spark_response::$spark_api_login = "wrong_password";
                        return false;
                    }
                }
            }
            else{
                spark_response::$spark_api_login = "empty_password";
                return false;
            }
        }
        else{
            spark_response::$spark_api_login = "invalid_username";
            return false;
        }
    }
    else{
        spark_response::$spark_login = "empty_username";
        return false;
    }
}
