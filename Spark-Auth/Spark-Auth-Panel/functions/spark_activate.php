<?php
include_once ("spark_settings.php");
include_once ("spark_security.php");
include_once ("spark_response.php");

function spark_activate($spark_username, $spark_key) {
    global $conn;

    $key_check = $conn->query("SELECT * FROM spark_keys WHERE spark_key='".spark_security::anti_sql_string($spark_key)."'");
    if ($key_check->num_rows != 0) {
        while ($spark_row = $key_check->fetch_assoc()) {
            if($spark_row["spark_used"] != 1) {
                $user_check = $conn->query("SELECT * FROM Spark_data WHERE Spark_username='".spark_security::anti_sql_string(spark_security::openssl_decrypto($_SESSION["username"])) . "'");
                if ($user_check->num_rows != 0) {
                    while ($spark_row2 = $user_check->fetch_assoc()) {
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

                        $conn->query("UPDATE spark_data SET spark_expires='".spark_security::anti_sql_string($time_to_update)."' WHERE spark_username='".spark_security::anti_sql_string(spark_security::openssl_decrypto($_SESSION["username"]))."'");
                        $conn->query("UPDATE spark_keys SET spark_used='1' WHERE spark_key='".spark_security::anti_sql_string($spark_key)."'");
                        spark_response::$spark_activate = "success";
                        return true;
                    }
                }
                else{
                    spark_response::$spark_activate = "unexistent_user";
                    return false;
                }
            }
            else {
                spark_response::$spark_activate = "already_used_key";
                return false;
            }
        }
    }
    else{
        spark_response::$spark_activate = "unexistent_key";
        return false;
    }
}

function api_activate($spark_username, $spark_key) {
    global $conn;

    $key_check = $conn->query("SELECT * FROM spark_keys WHERE spark_key='".spark_security::anti_sql_string($spark_key)."'");
    if ($key_check->num_rows != 0) {
        while ($spark_row = $key_check->fetch_assoc()) {
            if($spark_row["spark_used"] != 1) {
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
                        $conn->query("UPDATE spark_keys SET spark_used='1' WHERE spark_key='".spark_security::anti_sql_string($spark_key)."'");
                        spark_response::$spark_api_activate = "success";
                        return true;
                    }
                }
                else{
                    spark_response::$spark_api_activate = "unexistent_user";
                    return false;
                }
            }
            else {
                spark_response::$spark_api_activate = "already_used_key";
                return false;
            }
        }
    }
    else{
        spark_response::$spark_api_activate = "unexistent_key";
        return false;
    }
}

