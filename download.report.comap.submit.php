<?php
    session_start();

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "JIIT";
    
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    $Course_Key = $_SESSION['Course_Key'];
    
    $query13 = "SELECT Course_Code FROM COURSE_DETAILS WHERE Course_Key = '$Course_Key'";
    $Course_Code = mysqli_query($conn, $query13)->fetch_assoc()["Course_Code"];
    
    $query1 = "SELECT CO FROM final_attainment WHERE Course_Key = " . $Course_Key . " AND Test = 'feedback' ORDER BY CO";
    $result1 = mysqli_query($conn, $query1);

    $column_names = ["Course_Code", "CO", "PO1", "PO2", "PO3", "PO4", "PO5", "PO6", "PO7", "PO8", "PO9", "PO10", "PO11", "PO12", "PSO1", "PSO2"];
    $query3_part1 = "";
    foreach($column_names as $key => $value){
        $query3_part1 = $query3_part1.$value.", ";
    }
    $query3_part1 = rtrim($query3_part1,", ");
    // echo $query3_part1."<br>";

    while ($row = $result1->fetch_assoc()){
        

        $form_column_names = ["PO1", "PO2", "PO3", "PO4", "PO5", "PO6", "PO7", "PO8", "PO9", "PO10", "PO11", "PO12", "PSO1", "PSO2"];
        $query3_part2 = "";
        foreach($form_column_names as $key => $value){
            $query3_part2 = $query3_part2.$_POST['Map'][$row["CO"]][$value].", ";
        }
        $query3_part2 = rtrim($query3_part2,", ");
        // echo $query3_part2."<br>";

        $query2 = "SELECT * FROM co_map WHERE Course_Code = '" . $Course_Code . "' AND CO = '" . $row["CO"] . "'";
        $query3 = "INSERT INTO co_map(".$query3_part1.") VALUES ('".$Course_Code."', '".$row["CO"]."', ".$query3_part2.")";
        $query4 = "UPDATE co_map SET PO1 = ".$_POST['Map'][$row["CO"]]["PO1"].", PO2 = ".$_POST['Map'][$row["CO"]]["PO2"].", PO3 = ".$_POST['Map'][$row["CO"]]["PO3"].", PO4 = ".$_POST['Map'][$row["CO"]]["PO4"].", PO5 = ".$_POST['Map'][$row["CO"]]["PO5"].", PO6 = ".$_POST['Map'][$row["CO"]]["PO6"].", PO7 = ".$_POST['Map'][$row["CO"]]["PO7"].", PO8 = ".$_POST['Map'][$row["CO"]]["PO8"].", PO9 = ".$_POST['Map'][$row["CO"]]["PO9"].", PO10 = ".$_POST['Map'][$row["CO"]]["PO10"].", PO11 = ".$_POST['Map'][$row["CO"]]["PO11"].", PO12 = ".$_POST['Map'][$row["CO"]]["PO12"].", PSO1 = ".$_POST['Map'][$row["CO"]]["PSO1"].", PSO2 = ".$_POST['Map'][$row["CO"]]["PSO2"]." WHERE Course_Code = '".$Course_Code."' AND CO = '" . $row["CO"] . "'"; 
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
    header("Location: download.report.php");
?>