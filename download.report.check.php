<?php
    session_start();
    $Course_Key = $_SESSION['Course_Key'];
    $Event = $_SESSION["Event"];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "JIIT";

    echo $Event."<br>";
    echo $Course_Key."<br>";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    $Tests = explode(" ", $Event);
    $length = count($Tests);
    $CO_flag = 0;

    foreach($Tests as $Test){
        if($Test == "CO"){
            $query1 = "SELECT * FROM NBA_FEEDBACK_RECORDS WHERE Course_Key = ".$Course_Key;
            echo $query1."<br>";
            $result = mysqli_query($conn, $query1);
            if(mysqli_num_rows($result) == 0){
                header("Location: download.report.details.php");
                exit();
            }
            $CO_flag = 1;
        }
        else{
            $query1 = "SELECT * FROM NBA_RECORDS WHERE Course_Key = ".$Course_Key." AND Test = '".$Test."'";
            echo $query1."<br>";
            $result = mysqli_query($conn, $query1);
            if(mysqli_num_rows($result) == 0){
                header("Location: download.report.details.php");
                exit();
            }
        }
    }

    if($CO_flag == 1){
        header("Location: download.report.comap.php");
    } else{
        header("Location: download.report.php");
    }
    exit(); 
?>