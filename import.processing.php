<?php
    session_start();

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "JIIT";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    $Course_Key = $_SESSION['Course_Key'];
    $Event = $_SESSION["Event"];
    $Tests = explode(" ", $Event);
    $Questions = $_SESSION["Questions"];
    $Feedback = $_SESSION["Feedback"];

    $query13 = "SELECT Course_Code FROM COURSE_DETAILS WHERE Course_Key = '$Course_Key'";
    $Course_Code = mysqli_query($conn, $query13)->fetch_assoc()["Course_Code"];

    $query14 = "SELECT Course_Credits FROM COURSES WHERE Course_Code = '$Course_Code'";
    $Course_Credits = mysqli_query($conn, $query14)->fetch_assoc()["Course_Credits"];

    //echo $Course_Code."<br>";
    //echo $Course_Credits."<br>";

    foreach($Tests as $Test){
        $total_questions = $Questions[$Test];

        $query1 = "SELECT Question_CO, SUM(Question_Marks) FROM Question_Details WHERE Course_Key = ".$Course_Key." AND Test = '".$Test."' GROUP BY QUESTION_CO";
        //echo $query1."<br>";

        $result1 = mysqli_query($conn, $query1);
        $QuestionCO = array();
        while($row = $result1->fetch_assoc()){
            $Initial_CO = $row["Question_CO"];
            $CO_Parts = explode(".",$Initial_CO);
            $CO_Num = end($CO_Parts);
            $QuestionCO[] = "CO".$CO_Num;

            $query2 = "UPDATE NBA_RECORDS SET CO".$CO_Num."_Max = ".$row["SUM(Question_Marks)"]." WHERE Course_Key = ".$Course_Key." AND Test = '".$Test."'";
            //echo $query2."<br>";

            mysqli_query($conn, $query2);
            $query3 = "SELECT Question FROM QUESTION_DETAILS WHERE Course_Key = ".$Course_Key." AND Test = '".$Test."' AND Question_CO = '".$row["Question_CO"]."'";
            //echo $query3."<br>";

            $result2 = mysqli_query($conn, $query3);
            $query4 = "UPDATE NBA_RECORDS SET CO".$CO_Num." = ";
            while($row2 = $result2->fetch_assoc()){
                $query4 = $query4.$row2["Question"]." + ";
            }
            $query4 = rtrim($query4, " + ")." WHERE Course_Key = ".$Course_Key." AND Test = '".$Test."'";
            //echo $query4."<br>";

            mysqli_query($conn, $query4);
        }
        foreach($QuestionCO as $CO){
            $query5 = "UPDATE NBA_RECORDS SET ".$CO."_Percent = ROUND((".$CO."/".$CO."_Max)*100, 2) WHERE Course_Key = ".$Course_Key." AND Test = '".$Test."'";
            //echo $query5."<br>";
            mysqli_query($conn, $query5);
        }
        $query6 = "UPDATE NBA_RECORDS SET Total = ";
        for($i = 1; $i <= $total_questions; $i++){
            $query6 = $query6."Q".$i." + ";
        }
        $query6 = rtrim($query6, " + ")." WHERE Course_Key = ".$Course_Key." AND Test = '".$Test."'";
        //echo $query6."<br>";
        mysqli_query($conn, $query6);

        $query7 = "SELECT COUNT(*) AS Total_Students FROM NBA_RECORDS WHERE Course_Key = ".$Course_Key." AND Test = '".$Test."'";
        //echo $query7."<br>";
        $Total_Students = mysqli_query($conn, $query7)->fetch_assoc()["Total_Students"];
        //echo $Total_Students."<br>";

        $query8 = "SELECT COUNT(*) AS Student_Appeared FROM NBA_RECORDS WHERE Course_Key = ".$Course_Key." AND Test = '".$Test."' AND Total IS NOT NULL";
        //echo $query8."<br>";
        $Student_Appeared = mysqli_query($conn, $query8)->fetch_assoc()["Student_Appeared"];
        //echo $Student_Appeared."<br>";

        $result1 = mysqli_query($conn, $query1);
        while($row = $result1->fetch_assoc()){
            $Initial_CO = $row["Question_CO"];
            $CO_Parts = explode(".",$Initial_CO);
            $CO_Num = end($CO_Parts);
            $target = 50;
            $query9 = "SELECT COUNT(*) AS Student_Num FROM NBA_RECORDS WHERE Course_Key = ".$Course_Key." AND Test = '".$Test."' AND CO".$CO_Num."_Percent >= ".$target;
            //echo $query9."<br>";
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

            $query10 = "SELECT Student_Num FROM FINAL_ATTAINMENT WHERE Course_Key = ".$Course_Key." AND Test = '".$Test."' AND CO = '".$row["Question_CO"]."'";
            $query11 = "INSERT INTO FINAL_ATTAINMENT(Course_Key, Test, CO, Student_Num, Student_Percent, CO_Level, Total_Students, Student_Appeared) VALUES (".$Course_Key.", '".$Test."', '".$row["Question_CO"]."', ".$Student_Num.", ".$Student_Percent.", ".$CO_Level.", ".$Total_Students.", ".$Student_Appeared.")";
            $query12 = "UPDATE FINAL_ATTAINMENT SET Student_Num = ".$Student_Num.", Student_Percent = ".$Student_Percent.", CO_Level = ".$CO_Level.", Total_Students = ".$Total_Students.", Student_Appeared = ".$Student_Appeared." WHERE Course_Key = ".$Course_Key." AND Test = '".$Test."' AND CO = '".$row["Question_CO"]."'";

            //echo $query10."<br>";
            //echo $query11."<br>";
            //echo $query12."<br>";
            $result3 = mysqli_query($conn, $query10);
            if(mysqli_num_rows($result3) == 0){
                mysqli_query($conn, $query11);
            }
            else{
                mysqli_query($conn, $query12);
            }
        }
    }
    if($Feedback == 1){
        header("Location: download.report.feedback.php");
    }
    else{
        header("Location: main.php");
    }
    exit();
?>