<?php
if (isset($_POST['submit'])) {
    session_start();
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "JIIT";

    $Institute = $_POST['Institute'];
    $AcademicYear = $_POST['AcademicYear'];
    $_SESSION["AcademicYear"] = $AcademicYear;
    $Semester = $_POST['Semester'];
    $_SESSION["Semester"] = $Semester;
    if ($Semester % 2 == 0) {
        $AcademicYear = $AcademicYear . " (Even Semester)";
    } else {
        $AcademicYear = $AcademicYear . " (Odd Semester)";
    }
    $Branch = $_POST['Branch'];
    $_SESSION["Branch"] = $Branch;
    $NBACode = $_POST['NBACode'];


    $CourseCode = $_POST['CourseCode'];
    $_SESSION["CourseCode"] = $CourseCode;

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    $query3 = "SELECT Course_Name FROM COURSES WHERE Course_Code = '$CourseCode'";

    $CourseName = mysqli_query($conn, $query3);

    if (mysqli_num_rows($CourseName) == 0) {
        // echo "<script type='text/javascript'>alert('No Such Course Exist!');</script>";
        // header("Location: download.report.details.php");
        // exit();
        echo '<script type="text/javascript">';
        echo 'alert("No Such Course Exist!");';
        echo 'setTimeout(function(){ window.location.href = "../download.report.details.php"; }, 500);'; // Wait for 2 seconds
        echo '</script>';
        exit();
    }

    $CourseName = $CourseName->fetch_assoc()["Course_Name"];
    $_SESSION["CourseName"] = $CourseName;

    $query4 = "SELECT Course_Coordinator FROM COURSES WHERE Course_Code = '$CourseCode'";
    $CourseCoordinator = mysqli_query($conn, $query4)->fetch_assoc()["Course_Coordinator"];
    $_SESSION["CourseCoordinator"] = $CourseCoordinator;

    $query5 = "SELECT module_coordinator FROM COURSES WHERE Course_Code = '$CourseCode'";
    $module_coordinator = mysqli_query($conn, $query5)->fetch_assoc()["module_coordinator"];
    $_SESSION["module_coordinator"] = $module_coordinator;

    //echo $CourseName."<br>";
    //echo $CourseCoordinator."<br>";

    // $Event = $_POST["Event"];
    // $_SESSION["Event"] = $Event;

    $emp_id = $_SESSION["emp_id"];

    if ($conn) {
        $query1 = "SELECT Course_Key FROM COURSE_DETAILS WHERE Institute = '$Institute' AND Academic_Year = '$AcademicYear' AND Semester = '$Semester' AND Branch = '$Branch' AND NBA_Code = '$NBACode' AND Course_Name = '$CourseName' AND Course_Code = '$CourseCode' AND Course_Coordinator = '$CourseCoordinator' AND emp_id = '$emp_id'";
        // echo $query1."<br>";
        $result1 = mysqli_query($conn, $query1);
        if (mysqli_num_rows($result1) == 0) {
            // echo '<script type="text/javascript">';
            // echo 'alert("Data For No Such Event Present");';
            // echo '</script>';
            // header("Location: download.report.details.php");
            // exit();
            // $result1 = mysqli_query($conn, $query1);
            // if (mysqli_num_rows($result1) == 0) {
                echo '<script type="text/javascript">';
                echo 'alert("Data For No Such Event Present");';
                echo 'setTimeout(function(){ window.location.href = "assessmenttool.php"; }, 500);'; // Wait for 2 seconds
                echo '</script>';
                exit(); // You can remove the exit if needed
            // }
        }
        $_SESSION['Course_Key'] = $result1->fetch_assoc()['Course_Key'];
        header("Location: assessmenttool.download.php");
        exit();
    } else {
        // echo "<script type='text/javascript'>alert('Database Connection Error!');</script>";
        // header("Location: download.report.details.php");
        // exit();

        echo '<script type="text/javascript">';
        echo 'alert("Database Connection Error");';
        echo 'setTimeout(function(){ window.location.href = "assessmenttool.php"; }, 500);'; // Wait for 2 seconds
        echo '</script>';
        exit();
    }
} else {
    // echo "<script type='text/javascript'>alert('Something Went Wrong! <br>');</script>";
    // header("Location: download.report.details.php");
    // exit();

    echo '<script type="text/javascript">';
    echo 'alert("Something Went Wrong");';
    echo 'setTimeout(function(){ window.location.href = "assessmenttool.php"; }, 500);'; // Wait for 2 seconds
    echo '</script>';
    exit();
}
