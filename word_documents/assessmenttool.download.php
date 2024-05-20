<?php
    session_start();
    $Semester = $_SESSION['Semester'];
    $Branch = $_SESSION['Branch'];
    $CourseCode = $_SESSION['CourseCode'];
    $AcademicYear = $_SESSION['AcademicYear'];
    $CourseName = $_SESSION["CourseName"];
    $CourseCoordinator = $_SESSION["CourseCoordinator"];
    $Course_Key = $_SESSION["Course_Key"];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "JIIT";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    $query1 = "SELECT CO FROM co_map WHERE Course_Code = '$CourseCode'";
    $result1 =  mysqli_query($conn, $query1);

    while($row1 = $result1->fetch_assoc()){
        $query2 = "SELECT Test, Description FROM question_details Where Test IN ('T1', 'T2', 'T3', 'TA') AND Course_key = ". $Course_Key . " AND Question_CO = '". $row1["CO"]."'";
        $result2 =  mysqli_query($conn, $query2);
        $query3_part1 = "";
        while($row2 = $result2->fetch_assoc()){
            if($row2["Test"] == 'TA'){
                $query3_part1 = $query3_part1.$row2["Description"].", ";
            }
            else{
                $query3_part1 = $query3_part1.$row2["Test"].", ";
            }
        }
        $query3_part1 = rtrim($query3_part1,", ");
        $query3 = "UPDATE course_co_description SET direct = '".$query3_part1."' WHERE CO = '".$row1["CO"]."' AND Course_Code = '".$CourseCode."'";
        // echo $query3;
        mysqli_query($conn, $query3);
    }
    header("Location: assessmenttool.download.file.php");
    exit();
?>