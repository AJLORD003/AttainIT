<?php
session_start();
if (isset($_POST['submit'])) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "JIIT";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    $CourseCode = $_POST['CourseCode'];
    $CourseName = $_POST['CourseName'];
    $CourseCoordinator = $_POST['CourseCoordinator'];
    $ModuleCoordinator = $_POST['ModuleCoordinator'];
    $Credits = $_POST['Credits'];
    $contacthours = $_POST['contacthours'];
    $CourseTeacher = $_POST['CourseTeacher'];
    $NBACode = $_POST['NBACode'];
    $_SESSION["NBACode"] = $NBACode;
    $_SESSION["CourseCode"] = $CourseCode;
    $Course_Credits = 3;

    $query1 = "SELECT Course_Code FROM COURSES WHERE Course_Code = '" . $CourseCode . "'";
    $query2 = "INSERT INTO COURSES(Course_Code, Course_Name, Course_Coordinator, Course_Credits, Credits, contact_hours, Course_Teacher, module_coordinator) VALUES ('" . $CourseCode . "', '" . $CourseName . "', '" . $CourseCoordinator . "', " . $Course_Credits . ", " . $Credits . ", '" . $contacthours . "', '" . $CourseTeacher . "', '".$ModuleCoordinator."')";
    $query3 = "UPDATE COURSES SET Course_Name = '" . $CourseName . "', Course_Coordinator = '" . $CourseCoordinator . "', Credits = ".$Credits.", contact_hours = '".$contacthours."', Course_Teacher = '".$CourseTeacher."', module_coordinator = '" . $ModuleCoordinator . "' WHERE Course_Code = '" . $CourseCode . "'";
    
    $result1 = mysqli_query($conn, $query1);
    echo $query2;
    echo $query3;
    if (mysqli_num_rows($result1) == 0) {
        mysqli_query($conn, $query2);
        // echo "<script>alert('Course Added Successfully')</script>";
        // header("Location: main.php");
        // exit();
    } else {
        mysqli_query($conn, $query3);
        // echo "<script>alert('Course Updated Successfully')</script>";
    }
    header("Location: import.course.co_description.php");
    exit();
}
?>