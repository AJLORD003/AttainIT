<?php
    session_start();

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "JIIT";

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    $Course_Key = $_SESSION['Course_Key'];
    $Test = "feedback";

    $Feedback_CO = $_SESSION['Feedback_CO'];
    
    $query13 = "SELECT Course_Code FROM COURSE_DETAILS WHERE Course_Key = '$Course_Key'";
    $Course_Code = mysqli_query($conn, $query13)->fetch_assoc()["Course_Code"];

    $query14 = "SELECT Course_Credits FROM COURSES WHERE Course_Code = '$Course_Code'";
    $Course_Credits = mysqli_query($conn, $query14)->fetch_assoc()["Course_Credits"];

    $query15 = "SELECT NBA_Code FROM COURSE_DETAILS WHERE Course_Key = '$Course_Key'";
    $NBA_Code = mysqli_query($conn, $query15)->fetch_assoc()["NBA_Code"];

    // echo $Course_Code."<br>";
    // echo $Course_Credits."<br>";

    $query7 = "SELECT COUNT(*) AS Total_Students FROM NBA_FEEDBACK_RECORDS WHERE Course_Key = ".$Course_Key;
    // echo $query7."<br>";
    $Total_Students = mysqli_query($conn, $query7)->fetch_assoc()["Total_Students"];
    // echo $Total_Students."<br>";

    $Student_Appeared = $Total_Students;

    foreach ($Feedback_CO as $key => $value) {
        $target = 3;
        $query9 = "SELECT COUNT(*) AS Student_Num FROM NBA_FEEDBACK_RECORDS WHERE Course_Key = ".$Course_Key." AND ".$value." >= ".$target;
        // echo $query9."<br>";
        // echo "Key: $key, Value: $value<br>";
        $Student_Num = mysqli_query($conn, $query9)->fetch_assoc()["Student_Num"];
        $Student_Percent = round(($Student_Num/$Student_Appeared)*100, 2);

        if($Student_Percent >= 80){
            $CO_Level=$Course_Credits;
        }
        elseif($Student_Percent >= 70){
            $CO_Level=$Course_Credits - 1;
        }
        elseif($Student_Percent >= 60){
            $CO_Level=$Course_Credits - 2;
        }
        else{
            $CO_Level=0;
        }
        $CO_number = str_replace("CO", "", $value);

        $query10 = "SELECT Student_Num FROM FINAL_ATTAINMENT WHERE Course_Key = ".$Course_Key." AND Test = '".$Test."' AND CO = '".$NBA_Code.'.'.$CO_number."'";
        $query11 = "INSERT INTO FINAL_ATTAINMENT(Course_Key, Test, CO, Student_Num, Student_Percent, CO_Level, Total_Students, Student_Appeared) VALUES (".$Course_Key.", '".$Test."', '".$NBA_Code.'.'.$CO_number."', ".$Student_Num.", ".$Student_Percent.", ".$CO_Level.", ".$Total_Students.", ".$Student_Appeared.")";
        $query12 = "UPDATE FINAL_ATTAINMENT SET Student_Num = ".$Student_Num.", Student_Percent = ".$Student_Percent.", CO_Level = ".$CO_Level.", Total_Students = ".$Total_Students.", Student_Appeared = ".$Student_Appeared." WHERE Course_Key = ".$Course_Key." AND Test = '".$Test."' AND CO = '".$NBA_Code.'.'.$CO_number."'";

        // echo $query10."<br>";
        // echo $query11."<br>";
        // echo $query12."<br>";

        $result3 = mysqli_query($conn, $query10);
        if(mysqli_num_rows($result3) == 0){
            mysqli_query($conn, $query11);
        }
        else{
            mysqli_query($conn, $query12);
        }
    }
    header("Location: main.php");
    exit();
?>