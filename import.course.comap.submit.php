<?php
    session_start();

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "JIIT";

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    $Course_Code = $_SESSION["CourseCode"];
    $NBACode = $_SESSION["NBACode"];
    $totalco = $_SESSION["totalco"];

    $column_names = ["Course_Code", "CO", "PO1", "PO2", "PO3", "PO4", "PO5", "PO6", "PO7", "PO8", "PO9", "PO10", "PO11", "PO12", "PSO1", "PSO2"];
    $form_column_names = ["PO1", "PO2", "PO3", "PO4", "PO5", "PO6", "PO7", "PO8", "PO9", "PO10", "PO11", "PO12", "PSO1", "PSO2"];
    $average = array();
    foreach($form_column_names as $key => $value){
        $average[$value] = 0;
        $average[$value."_div"] = 0;
    }

    $query3_part1 = "";
    foreach($column_names as $key => $value){
        $query3_part1 = $query3_part1.$value.", ";
    }
    $query3_part1 = rtrim($query3_part1,", ");
    
    for($counter = 1; $counter <= $totalco; $counter++){
        // $form_column_names = ["PO1", "PO2", "PO3", "PO4", "PO5", "PO6", "PO7", "PO8", "PO9", "PO10", "PO11", "PO12", "PSO1", "PSO2"];
        $query3_part2 = "";
        foreach($form_column_names as $key => $value){
            $query3_part2 = $query3_part2.$_POST['Map'][$NBACode.'.'.$counter][$value].", ";
            $average[$value] += $_POST['Map'][$NBACode.'.'.$counter][$value];
            if($_POST['Map'][$NBACode.'.'.$counter][$value] != 0){
                $average[$value."_div"] += 1;
            }
        }
        $query3_part2 = rtrim($query3_part2,", ");
        $query2 = "SELECT * FROM co_map WHERE Course_Code = '" . $Course_Code . "' AND CO = '" . $NBACode.'.'.$counter . "'";
        $query3 = "INSERT INTO co_map(".$query3_part1.") VALUES ('".$Course_Code."', '".$NBACode.'.'.$counter."', ".$query3_part2.")";
        $query4 = "UPDATE co_map SET PO1 = ".$_POST['Map'][$NBACode.'.'.$counter]["PO1"].", PO2 = ".$_POST['Map'][$NBACode.'.'.$counter]["PO2"].", PO3 = ".$_POST['Map'][$NBACode.'.'.$counter]["PO3"].", PO4 = ".$_POST['Map'][$NBACode.'.'.$counter]["PO4"].", PO5 = ".$_POST['Map'][$NBACode.'.'.$counter]["PO5"].", PO6 = ".$_POST['Map'][$NBACode.'.'.$counter]["PO6"].", PO7 = ".$_POST['Map'][$NBACode.'.'.$counter]["PO7"].", PO8 = ".$_POST['Map'][$NBACode.'.'.$counter]["PO8"].", PO9 = ".$_POST['Map'][$NBACode.'.'.$counter]["PO9"].", PO10 = ".$_POST['Map'][$NBACode.'.'.$counter]["PO10"].", PO11 = ".$_POST['Map'][$NBACode.'.'.$counter]["PO11"].", PO12 = ".$_POST['Map'][$NBACode.'.'.$counter]["PO12"].", PSO1 = ".$_POST['Map'][$NBACode.'.'.$counter]["PSO1"].", PSO2 = ".$_POST['Map'][$NBACode.'.'.$counter]["PSO2"]." WHERE Course_Code = '".$Course_Code."' AND CO = '" . $NBACode.'.'.$counter . "'"; 
        // echo $query2."<br>";
        // echo $query3."<br>";
        // echo $query4."<br>";
        $result2 = mysqli_query($conn, $query2);
        if (mysqli_num_rows($result2) == 0){
            mysqli_query($conn, $query3);
        }
        else{
            mysqli_query($conn, $query4);
        }
    }
    $query3_part2 = "";
    foreach($form_column_names as $key => $value){
        if($average[$value."_div"] == 0){
            $average[$value."_div"] = 1;
        }
        $query3_part2 = $query3_part2.round(($average[$value]/$average[$value."_div"])).", ";
    }
    $query3_part2 = rtrim($query3_part2,", ");
        $query2 = "SELECT * FROM co_map WHERE Course_Code = '" . $Course_Code . "' AND CO = 'Avg'";
        $query3 = "INSERT INTO co_map(".$query3_part1.") VALUES ('".$Course_Code."', 'Avg', ".$query3_part2.")";
        $query4 = "UPDATE co_map SET PO1 = ".round(($average["PO1"]/$average["PO1"."_div"])).", PO2 = ".round(($average["PO2"]/$average["PO2"."_div"])).", PO3 = ".round(($average["PO3"]/$average["PO3"."_div"])).", PO4 = ".round(($average["PO4"]/$average["PO4"."_div"])).", PO5 = ".round(($average["PO5"]/$average["PO5"."_div"])).", PO6 = ".round(($average["PO6"]/$average["PO6"."_div"])).", PO7 = ".round(($average["PO7"]/$average["PO7"."_div"])).", PO8 = ".round(($average["PO8"]/$average["PO8"."_div"])).", PO9 = ".round(($average["PO9"]/$average["PO9"."_div"])).", PO10 = ".round(($average["PO10"]/$average["PO10"."_div"])).", PO11 = ".round(($average["PO11"]/$average["PO11"."_div"])).", PO12 = ".round(($average["PO12"]/$average["PO12"."_div"])).", PSO1 = ".round(($average["PSO1"]/$average["PSO1"."_div"])).", PSO2 = ".round(($average["PSO2"]/$average["PSO2"."_div"]))." WHERE Course_Code = '".$Course_Code."' AND CO = 'Avg'";
        // echo $query2."<br>";
        // echo $query3."<br>";
        // echo $query4."<br>";
        $result2 = mysqli_query($conn, $query2);
        if (mysqli_num_rows($result2) == 0){
            mysqli_query($conn, $query3);
        }
        else{
            mysqli_query($conn, $query4);
        }
    header("Location: import.course.recommendedbooks.php");
    exit();
?>