<?php

include_once ("spark_settings.php");
include_once ("spark_security.php");
include_once ("spark_response.php");

class auth
{
    function Login($username, $password, $hwid){
        global $conn;
    
        if (!empty($username)) {
            $spark_user_check = $conn->query("SELECT * FROM Spark_data WHERE username='" . spark_security::anti_sql_string($username) . "'");
            if ($spark_user_check->num_rows != 0) {
                if (!empty($password)) {
                    while ($spark_row = $spark_user_check->fetch_assoc()) {
                        if(password_verify($password, $spark_row["password"])){
                            if ($spark_row["Spark_expires"] > time()) {
                                if (strlen($spark_row["hwid"]) != 0) {
                                    if ($spark_row["hwid"] == $hwid) {
                                        $spark_ip = spark_security::get_ip();
                                        $conn->query("UPDATE Spark_data SET Spark_ip='".spark_security::anti_sql_string($spark_ip)."' WHERE username='".spark_security::anti_sql_string($username)."'");
    
                                        $token = spark_security::random_string(43);
                                        $time = time() + 180;
    
                                        $conn->query("INSERT INTO Spark_tokens (spark_token, spark_expires) VALUES ('".spark_security::anti_sql_string($token)."', '".spark_security::anti_sql_string($time)."')");
    
                                        spark_response::$spark_api_login = "logged_in|";
                                        return true;
                                    } else {
                                        spark_response::$spark_api_login = "wrong_hwid";
                                        return false;
                                    }
                                }
                                else{
                                    $conn->query("UPDATE Spark_data SET hwid='".spark_security::anti_sql_string($hwid)."' WHERE username='".spark_security::anti_sql_string($username)."'");
                                    $spark_ip = spark_security::get_ip();
                                    $conn->query("UPDATE Spark_data SET Spark_ip='".spark_security::anti_sql_string($spark_ip)."' WHERE username='".spark_security::anti_sql_string($username)."'");
    
                                    $token = spark_security::random_string(43);
                                    $time = time() + 180;
    
                                    $conn->query("INSERT INTO Spark_tokens (Spark_token, Spark_expires) VALUES ('".spark_security::anti_sql_string($token)."', '".spark_security::anti_sql_string($time)."')");
    
                                    spark_response::$spark_api_login = "logged_in|";
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
    
    function Register($username,$password,$email,$token,$hwid)
    {
    
    }
}
