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

    $column_names = ["Course_Code", "CO", "Description", "Level", "indirect"];
    $form_column_names = ["Description", "level"];
    $query3_part1 = "";
    foreach($column_names as $key => $value){
        $query3_part1 = $query3_part1.$value.", ";
    }
    $query3_part1 = rtrim($query3_part1,", ");

    for($counter = 1; $counter <= $totalco; $counter++){
        $query3_part2 = "'";
        foreach($form_column_names as $key => $value){
            $query3_part2 = $query3_part2.$_POST['Map'][$NBACode.'.'.$counter][$value]."', '";
        }
        $query3_part2 = rtrim($query3_part2,", '");
        $query3_part2 = $query3_part2."'";
        $query2 = "SELECT * FROM course_co_description WHERE Course_Code = '" . $Course_Code . "' AND CO = '" . $NBACode.'.'.$counter . "'";
        $query3 = "INSERT INTO course_co_description(".$query3_part1.") VALUES ('".$Course_Code."', '".$NBACode.'.'.$counter."', ".$query3_part2.", 'Course Exit Survey')";
        $query4 = "UPDATE course_co_description SET Description = '".$_POST['Map'][$NBACode.'.'.$counter]["Description"]."', Level = '".$_POST['Map'][$NBACode.'.'.$counter]["level"]."', indirect = 'Course Exit Survey' WHERE Course_Code = '".$Course_Code."' AND CO = '" . $NBACode.'.'.$counter . "'"; 
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
    header("Location: import.course.module.php");
    exit();
?>