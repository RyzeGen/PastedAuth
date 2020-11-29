<?php

include_once ("spark_settings.php");
include_once ("spark_security.php");
include_once ("spark_response.php");

function spark_register($spark_username, $spark_email, $spark_password) {
    global $conn;

    if (!empty($spark_username) && !empty($spark_password) && !empty($spark_email)) {
        if (!$conn->query("SELECT * FROM spark_data WHERE spark_username='" . spark_security::anti_sql_string($spark_username) . "'")->num_rows > 0) {
            if(filter_var($spark_email, FILTER_VALIDATE_EMAIL)) {
                if (!$conn->query("SELECT * FROM spark_data WHERE spark_email = '" . spark_security::anti_sql_string($spark_email) . "'")->num_rows > 0) {
                    $conn->query("INSERT INTO spark_data (spark_username, spark_email, spark_password, spark_ip) 
  			  VALUES ('" . spark_security::anti_sql_string($spark_username) . "', '" . spark_security::anti_sql_string($spark_email) . "', '" . password_hash($spark_password, PASSWORD_BCRYPT) . "', '" . spark_security::anti_sql_string(spark_security::get_ip()) . "')");

                    spark_response::$spark_register = "success";
                    return true;
                } else {
                    spark_response::$spark_register = "email_already_taken";
                    return false;
                }
            }
            else{
                spark_response::$spark_register = "invalid_email";
                return false;
            }
        } else {
            spark_response::$spark_register = "username_already_taken";
            return false;
        }
    } else {
        spark_response::$spark_register = "empty_data";
        return false;
    }
}

function api_register($spark_username, $spark_email, $spark_password, $spark_token) {
    global $conn;

    if (!empty($spark_username) && !empty($spark_password) && !empty($spark_email)) {
        if (!$conn->query("SELECT * FROM spark_data WHERE spark_username='" . spark_security::anti_sql_string($spark_username) . "'")->num_rows > 0) {
            if(filter_var($spark_email, FILTER_VALIDATE_EMAIL)) {         
                if (!$conn->query("SELECT * FROM spark_data WHERE spark_email = '" . spark_security::anti_sql_string($spark_email) . "'")->num_rows > 0) {
                    $key_check = $conn->query("SELECT * FROM spark_keys WHERE spark_key='".spark_security::anti_sql_string($spark_token)."'");
                    if ($key_check->num_rows != 0) {
                        while ($spark_row = $key_check->fetch_assoc()) {
                            if($spark_row["spark_used"] != 1) {
                                $conn->query("INSERT INTO spark_data (spark_username, spark_email, spark_password, spark_ip) 
                                VALUES ('" . spark_security::anti_sql_string($spark_username) . "', '" . spark_security::anti_sql_string($spark_email) . "', '" . password_hash($spark_password, PASSWORD_BCRYPT) . "', '" . spark_security::anti_sql_string(spark_security::get_ip()) . "')");
                                $spark_user_check = $conn->query("SELECT * FROM Spark_data WHERE Spark_username='" . spark_security::anti_sql_string($spark_username) . "'");
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

                                        $conn->query("UPDATE spark_data SET spark_expires='".spark_security::anti_sql_string($time_to_update)."' WHERE Spark_username='" . spark_security::anti_sql_string($spark_username) . "'");
                                        $conn->query("UPDATE spark_keys SET spark_used='1' WHERE spark_key='".spark_security::anti_sql_string($spark_token)."'");
                                        spark_response::$spark_api_register = "success";
                                        return true;
                                    }
                                } else {
                                    spark_response::$spark_api_register = "error_creating_user";
                                    return false;
                                }
                            } else {
                                spark_response::$spark_api_register = "already_used_key";
                                return false;
                            }
                        }
                    } else {
                        spark_response::$spark_api_register = "unexistent_key";
                        return false;
                    }   
            } else {
                    spark_response::$spark_api_register = "email_already_taken";
                    return false;
                }
            }
            else{
                spark_response::$spark_api_register = "invalid_email";
                return false;
            }
        } else {
            spark_response::$spark_api_register = "username_already_taken";
            return false;
        }
    } else {
        spark_response::$spark_api_register = "empty_data";
        return false;
    }
}
