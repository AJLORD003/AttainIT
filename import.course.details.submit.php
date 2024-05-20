<?php
    if(isset($_POST['submit'])){
        session_start();
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "JIIT";

        $Institute = $_POST['Institute'];
        $AcademicYear = $_POST['AcademicYear'];
        $Semester = $_POST['Semester'];
        if($Semester % 2 == 0){
            $AcademicYear = $AcademicYear." (Even Semester)";
        }
        else{
            $AcademicYear = $AcademicYear." (Odd Semester)";
        }
        $Branch = $_POST['Branch'];
        $NBACode = $_POST['NBACode'];

        
        $CourseCode = $_POST['CourseCode'];

        $conn = mysqli_connect($servername, $username, $password, $dbname);

        $query3 = "SELECT Course_Name FROM COURSES WHERE Course_Code = '$CourseCode'";
        $CourseName = mysqli_query($conn, $query3);

        if(mysqli_num_rows($CourseName) == 0){
            // echo "<script type='text/javascript'>alert('No Such Course Exist!');</script>";
            // header("Location: import.course.details.php");
            // exit();

            echo '<script type="text/javascript">';
            echo 'alert("No Such Course Exist!");';
            echo 'setTimeout(function(){ window.location.href = "import.course.details.php"; }, 500);'; // Wait for 2 seconds
            echo '</script>';
            exit();
        }

        $CourseName = $CourseName->fetch_assoc()["Course_Name"];
        
        $query4 = "SELECT Course_Coordinator FROM COURSES WHERE Course_Code = '$CourseCode'";
        $CourseCoordinator = mysqli_query($conn, $query4)->fetch_assoc()["Course_Coordinator"];       

        $Event = $_POST["Event"];
        if($Event == "T1 T2 T3 TA CO"){
            $Event = "T1 T2 T3 TA";
            $_SESSION["Feedback"] = 1;
        }
        $_SESSION["Event"] = $Event;

        $emp_id = $_SESSION["emp_id"];

        
        if($conn){
            $query1 = "SELECT Course_Key FROM COURSE_DETAILS WHERE Institute = '$Institute' AND Academic_Year = '$AcademicYear' AND Semester = '$Semester' AND Branch = '$Branch' AND NBA_Code = '$NBACode' AND Course_Name = '$CourseName' AND Course_Code = '$CourseCode' AND Course_Coordinator = '$CourseCoordinator' AND emp_id = '$emp_id'";         
            $result1 = mysqli_query($conn, $query1);
            if(mysqli_num_rows($result1) == 0){
                $query2 = "INSERT INTO COURSE_DETAILS(Institute, Academic_Year, Semester, Branch, NBA_Code, Course_Name, Course_Code, Course_Coordinator, emp_id) VALUES ('$Institute', '$AcademicYear', '$Semester', '$Branch', '$NBACode', '$CourseName', '$CourseCode', '$CourseCoordinator', '$emp_id')";
                mysqli_query($conn, $query2);
                $result1 = mysqli_query($conn, $query1);
            }
            $_SESSION['Course_Key'] = $result1->fetch_assoc()['Course_Key'];
            header("Location: import.questions.php");
            exit();
        }
        else {
            // echo "<script type='text/javascript'>alert('Database Connection Error!');</script>";
            // header("Location: import.course.details.php");
            // exit();
            echo '<script type="text/javascript">';
            echo 'alert("Database Connection Error!");';
            echo 'setTimeout(function(){ window.location.href = "import.course.details.php"; }, 500);'; // Wait for 2 seconds
            echo '</script>';
            exit();
        }
    }
    else {
        // echo "<script type='text/javascript'>alert('Something Went Wrong! <br>');</script>";
        // header("Location: import.course.details.php");
        // exit();

        echo '<script type="text/javascript">';
        echo 'alert("Something Went Wrong!");';
        echo 'setTimeout(function(){ window.location.href = "import.course.details.php"; }, 500);'; // Wait for 2 seconds
        echo '</script>';
        exit();
      }
?>