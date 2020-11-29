<?php

include_once ("spark_settings.php");
include_once ("spark_security.php");
include_once ("spark_response.php");

function api_keylogin($spark_token, $spark_tokenemail, $spark_hwid) {
    global $conn;

    if (!empty($spark_token)) {
        if (!$conn->query("SELECT * FROM spark_data WHERE spark_username='" . spark_security::anti_sql_string($spark_token) . "'")->num_rows > 0) {
                if (!$conn->query("SELECT * FROM spark_data WHERE spark_email = '" . spark_security::anti_sql_string($spark_tokenemail) . "'")->num_rows > 0) {
                    $key_check = $conn->query("SELECT * FROM spark_keys WHERE spark_key='".spark_security::anti_sql_string($spark_token)."'");
                    if ($key_check->num_rows != 0) {
                        while ($spark_row = $key_check->fetch_assoc()) {
                            if($spark_row["spark_used"] != 1) {
                                $conn->query("INSERT INTO spark_data (spark_username, spark_email, spark_password, spark_ip) 
                                VALUES ('" . spark_security::anti_sql_string($spark_token) . "', '" . spark_security::anti_sql_string($spark_tokenemail) . "', '" . password_hash($spark_token, PASSWORD_BCRYPT) . "', '" . spark_security::anti_sql_string(spark_security::get_ip()) . "')");
                                $spark_user_check = $conn->query("SELECT * FROM Spark_data WHERE Spark_username='" . spark_security::anti_sql_string($spark_token) . "'");
                                if ($spark_user_check->num_rows != 0) {
                                    while ($spark_row2 = $spark_user_check->fetch_assoc()) {
                                        $expires = $spark_row2["Spark_expires"];
                                        $real_days = "+" . $spark_row["spark_days"] . " days";

                                        if (strlen($expires) != 0) {
                                            if (time() > $expires) {
                                                $time_to_update = strtotime($real_days, time());
                                            } else {
                                                $time_to_update = strtotime($real_days, $expires);
                                            }
                                        } else {
                                            $time_to_update = strtotime($real_days, time());
                                        }
                                        $conn->query("UPDATE spark_data SET spark_expires='".spark_security::anti_sql_string($time_to_update)."' WHERE Spark_username='" . spark_security::anti_sql_string($spark_token) . "'");
                                        $conn->query("UPDATE spark_keys SET spark_used='1' WHERE spark_key='".spark_security::anti_sql_string($spark_token)."'");
                                        $spark_user_check = $conn->query("SELECT * FROM Spark_data WHERE Spark_username='" . spark_security::anti_sql_string($spark_token) . "'");
                                        if ($spark_user_check->num_rows != 0) {
                                            if (!empty($spark_token)) {
                                                while ($spark_row1 = $spark_user_check->fetch_assoc()) {
                                                    if(password_verify($spark_token, $spark_row1["Spark_password"])){
                                                        if ($spark_row1["Spark_expires"] > time()) {
                                                            if (strlen($spark_row1["Spark_hwid"]) != 0) {
                                                                if ($spark_row1["Spark_hwid"] == $spark_hwid) {
                                                                    $spark_ip = spark_security::get_ip();
                                                                    $conn->query("UPDATE Spark_data SET Spark_ip='".spark_security::anti_sql_string($spark_ip)."' WHERE Spark_username='".spark_security::anti_sql_string($spark_token)."'");

                                                                    $token = spark_security::random_string(43);
                                                                    $time = time() + 180;

                                                                    $conn->query("INSERT INTO Spark_tokens (spark_token, spark_expires) VALUES ('".spark_security::anti_sql_string($token)."', '".spark_security::anti_sql_string($time)."')");

                                                                    $convertedTime = date('m/d/Y', $spark_row1["Spark_expires"]);

                                                                    spark_response::$spark_api_keylogin = "logged_in|" . $token . "|" . $spark_token . "|" . $convertedTime;
                                                                    return true;
                                                                } else {
                                                                    spark_response::$spark_api_keylogin = "wrong_hwid";
                                                                    return false;
                                                                }
                                                            }
                                                            else{
                                                                $conn->query("UPDATE Spark_data SET Spark_hwid='".spark_security::anti_sql_string($spark_hwid)."' WHERE Spark_username='".spark_security::anti_sql_string($spark_token)."'");
                                                                $spark_ip = spark_security::get_ip();
                                                                $conn->query("UPDATE Spark_data SET Spark_ip='".spark_security::anti_sql_string($spark_ip)."' WHERE Spark_username='".spark_security::anti_sql_string($spark_token)."'");

                                                                $token = spark_security::random_string(43);
                                                                $time = time() + 180;

                                                                $conn->query("INSERT INTO Spark_tokens (Spark_token, Spark_expires) VALUES ('".spark_security::anti_sql_string($token)."', '".spark_security::anti_sql_string($time)."')");

                                                                $convertedTime = date('m/d/Y', $spark_row1["Spark_expires"]);

                                                                spark_response::$spark_api_keylogin = "logged_in|" . $spark_token . "|" . $convertedTime;
                                                                return true;
                                                            }
                                                        }
                                                        else{
                                                            spark_response::$spark_api_keylogin = "no_sub";
                                                            return false;
                                                        }
                                                    }
                                                    else{
                                                        spark_response::$spark_api_keylogin = "wrong_password";
                                                        return false;
                                                    }
                                                }
                                            }
                                            else{
                                                spark_response::$spark_api_keylogin = "empty_password";
                                                return false;
                                            }
                                        }
                                        else{
                                            spark_response::$spark_api_keylogin = "invalid_username";
                                            return false;
                                        }
                                    
                                    }
                                } else {
                                    spark_response::$spark_api_keylogin = "error_creating_user";
                                    return false;
                                }
                            } else {
                                spark_response::$spark_api_keylogin = "already_used_key";
                                return false;
                            }
                        }
                    } else {
                        spark_response::$spark_api_keylogin = "unexistent_key";
                        return false;
                    }   
                } else {
                    spark_response::$spark_api_keylogin = "email_already_taken";
                    return false;
                }
        } else {
            spark_response::$spark_api_keylogin = "username_already_taken";
            return false;
        }
    } else {
        spark_response::$spark_api_keylogin = "empty_data";
        return false;
    }
}