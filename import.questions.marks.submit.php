<?php
session_start();
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "JIIT";

        $conn = mysqli_connect($servername, $username, $password, $dbname);

        $Questions = $_SESSION["Questions"];
        $Course_Key = $_SESSION['Course_Key'];
        $Event = $_SESSION["Event"];
        $Tests = explode(" ", $Event);

        $query1 = "SELECT NBA_Code FROM COURSE_DETAILS WHERE Course_Key = '$Course_Key'";
        $result1 = mysqli_query($conn, $query1);
        $result1 = $result1->fetch_assoc()['NBA_Code'];

        $TA_flag = 0;
        foreach($Tests as $Test){
            $total_questions = $Questions[$Test];
            if($Test != "TA"){
                for($counter = 1; $counter <= $total_questions; $counter++){
                    $query2 = "SELECT Question_Marks FROM QUESTION_DETAILS WHERE ";
                    $query3 = "INSERT INTO QUESTION_DETAILS(Course_key, Test, Question, Question_CO, Question_Marks) VALUES ";
    
                    $question_co = $_POST['Marks'][$Test][$counter]["CO"];
                    $question_marks = $_POST['Marks'][$Test][$counter]["MM"];
    
                    $query2 = $query2."Course_Key = ".$Course_Key." AND Test = '".$Test."' AND Question = 'Q".$counter."'";
                    $query3 = $query3."(".$Course_Key.", '".$Test."', 'Q".$counter."', '".$result1.".".$question_co."', ".$question_marks.")";
    
                    $result2 = mysqli_query($conn, $query2);
                    if(mysqli_num_rows($result2) == 0){
                    mysqli_query($conn, $query3);
                    //echo "Inserted<br>";
                    }
                    //echo $query2."<br>";
                    //echo $query3."<br>";
    
                }
            }
            else{
                $TA_flag = 1;
            }
        }
        if($TA_flag == 1){
            header("Location: import.TA.marks.php");
            exit();
        }
        else{
            header("Location: import.file.marks.php");
            exit();
        }
    }
?>