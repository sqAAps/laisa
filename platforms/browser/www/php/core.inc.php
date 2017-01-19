<?php
session_start();
ob_start();
$current_file = $_SERVER['SCRIPT_NAME'];


if (isset($_SERVER['HTTP_REFERER'])&&!empty($_SERVER['HTTP_REFERER'])) {
    $http_referer = $_SERVER['HTTP_REFERER'];
}


function loggedin() {
    if (isset($_SESSION['user_id'])&&!empty($_SESSION['user_id'])) {
        return true;
    } else {
        return false;
    }
}

function getuserfield($field) {
    $query = "SELECT `$field` FROM `users` WHERE `id`='".$_SESSION['user_id']."'";
    global $connection;
    if ($query_run = mysqli_query($connection, $query)) {
        //In $query_run, Row 0,column $field
        $query_num_rows = mysqli_num_rows($query_run);
        if ($query_num_rows==1) {
            while ($rows = mysqli_fetch_array($query_run)) {
                $query_result = $rows[$field];
                return $query_result;
            }
        }
    }
}

function echousername($id) {
    global $connection;
    $query = "SELECT `firstName` FROM `users` WHERE `id`='".mysqli_real_escape_string($connection, $id)."'";
    if ($query_run = mysqli_query($connection, $query)) {
        //In $query_run, Row 0,column $field
        $query_num_rows = mysqli_num_rows($query_run);
        if ($query_num_rows==1){
            while ($rows = mysqli_fetch_array($query_run)) {
                $firstName = $rows['firstName'];
                echo $firstName;
            }
        }
    }
}

function echo_session_user_gender() {
    global $connection;
    $query = "SELECT `gender` FROM `users` WHERE `id`='".mysqli_real_escape_string($connection, $_SESSION['user_id'])."'";
    if ($query_run = mysqli_query($connection, $query)) {
        //In $query_run, Row 0,column $field
        $query_num_rows = mysqli_num_rows($query_run);
        if ($query_num_rows==1){
            while ($rows = mysqli_fetch_array($query_run)) {
                $gender = $rows['gender'];
                return $gender;
            }
        }
    }
}

function getusername($id) {
    global $connection;
    $query = "SELECT `firstName` FROM `users` WHERE `id`='".mysqli_real_escape_string($connection, $id)."'";
    if ($query_run = mysqli_query($connection, $query)) {
        //In $query_run, Row 0,column $field
        $query_num_rows = mysqli_num_rows($query_run);
        if ($query_num_rows==1) {
            while ($rows = mysqli_fetch_array($query_run)) {
                $query_result = $rows['firstName'];
                return $query_result;
            }
        }
    }
}

function getusersurname($id) {
    global $connection;
    $query = "SELECT `surname` FROM `users` WHERE `id`='".mysqli_real_escape_string($connection, $id)."'";
    if ($query_run = mysqli_query($connection, $query)) {
        //In $query_run, Row 0,column $field
        $query_num_rows = mysqli_num_rows($query_run);
        if ($query_num_rows==1) {
            while ($rows = mysqli_fetch_array($query_run)) {
                $query_result = $rows['surname'];
                return $query_result;
            }
        }
    }
}

function get_ad_user_id(){
    $link =  "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    
    $parse_url = parse_url($link, PHP_URL_PATH);
    $explode_url = explode('/', $parse_url); 

    $name_surname = $explode_url[5];
    $explode_name_surname = explode('.', $name_surname);

    $ad_user_name = $explode_name_surname[0];
    $ad_user_surname = $explode_name_surname[1];
    
    global $connection;
    $query = "SELECT `id` FROM `users` WHERE `firstName`='".$ad_user_name."' AND `surname`='".$ad_user_surname."'";
    if ($query_run = mysqli_query($connection, $query)) {
        $query_num_rows = mysqli_num_rows($query_run);
        if($query_num_rows == 1){
            while ($rows = mysqli_fetch_array($query_run)) {
              $id = $rows['id'];
            }
            return $id;
        }
    }
}
?>