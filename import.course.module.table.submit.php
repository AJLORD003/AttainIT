<?php
    session_start();

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "JIIT";

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    $Course_Code = $_SESSION["CourseCode"];
    $NBACode = $_SESSION["NBACode"];
    $total_module = $_SESSION["total_module"];

    $column_names = ["Course_Code", "module_no", "Title", "content", "lectures"];
    $form_column_names = ["Title", "content", "lectures"];
    $query3_part1 = "";
    foreach($column_names as $key => $value){
        $query3_part1 = $query3_part1.$value.", ";
    }
    $query3_part1 = rtrim($query3_part1,", ");

    for($counter = 1; $counter <= $total_module; $counter++){
        $query3_part2 = "'";
        foreach($form_column_names as $key => $value){
            if ($value != "lectures") {
                $query3_part2 = $query3_part2.$_POST['Map'][$counter][$value]."', '";
            }
        }
        $query3_part2 = rtrim($query3_part2,", '");
        $query3_part2 = $query3_part2."', ".$_POST['Map'][$counter]["lectures"];
        $query2 = "SELECT * FROM course_module WHERE Course_Code = '" . $Course_Code . "' AND module_no = " . $counter;
        $query3 = "INSERT INTO course_module(".$query3_part1.") VALUES ('".$Course_Code."', ".$counter.", ".$query3_part2.")";
        $query4 = "UPDATE course_module SET Title = '".$_POST['Map'][$counter]["Title"]."', content = '".$_POST['Map'][$counter]["content"]."', lectures = ".$_POST['Map'][$counter]["lectures"]." WHERE Course_Code = '".$Course_Code."' AND module_no = " . $counter; 
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
    header("Location: import.course.comap.php");
    exit();
?>