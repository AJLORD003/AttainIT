<?php
    session_start();
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "JIIT";

        $conn = mysqli_connect($servername, $username, $password, $dbname);

        $Course_Key = $_SESSION['Course_Key'];
        $query1 = "SELECT NBA_Code FROM COURSE_DETAILS WHERE Course_Key = '$Course_Key'";
        $result1 = mysqli_query($conn, $query1);
        $result1 = $result1->fetch_assoc()['NBA_Code'];

        $total_events = $_SESSION["Questions"]["TA"];
        $question_counter = 1;
        $event_type = ['quiz' => 0,'assignment' => 0,'project' => 0];
        for($counter = 1; $counter <= $total_events; $counter++){
            $Type = $_POST["Marks_TA"][$counter]["Type"];
            $event_type[$Type] += 1;
            $Total_marks = $_POST["Marks_TA"][$counter]["TT"];

            $co_array = [];
            for($co_counter = 1; $co_counter <= 10; $co_counter++){
                $co_number = $co_counter;
                $co_marks = $_POST["Marks_TA"][$counter]["CO"][$co_counter];
                if($co_marks != 0){
                    $co_array[$co_number] = $co_marks;
                }
            }
            foreach ($co_array as $key => $value) {
                //echo "Key: $key, Value: $value<br>";
                $query2 = "SELECT Question_Marks FROM QUESTION_DETAILS WHERE ";
                $query3 = "INSERT INTO QUESTION_DETAILS(Course_key, Test, Question, Question_CO, Question_Marks, Description) VALUES ";

                $query2 = $query2."Course_Key = ".$Course_Key." AND Test = 'TA' AND Question = 'Q".$question_counter."'";
                $query3 = $query3."(".$Course_Key.", 'TA', 'Q".$question_counter."', '".$result1.".".$key."', ".$value.", '".$Type."-".$event_type[$Type]."')";
                $result2 = mysqli_query($conn, $query2);
                if(mysqli_num_rows($result2) == 0){
                    mysqli_query($conn, $query3);
                    //echo "Inserted<br>";
                }
                //echo $query2."<br>";
                //echo $query3."<br>";
                $question_counter++;
            }
        }
        header("Location: import.file.marks.php");
        exit();
    }
?>