<?php
    session_start();

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "JIIT";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    require 'vendor/autoload.php';
    use PhpOffice\PhpSpreadsheet\IOFactory;
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    
?>
<?php
    if(isset($_POST['submit'])){
        $allowed_ext = ['xlx', 'csv' ,'xlsx'];
        $filename=$_FILES['excel']['name'];
        $checking=explode(".",$filename);
        $file_ext=end($checking);

        if(in_array($file_ext,$allowed_ext)){
            $targetpath = $_FILES['excel']['tmp_name'];
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::load($targetpath);
            $spreadsheet_num = $reader->getsheetcount();

            $Course_Key = $_SESSION['Course_Key'];
            $Event = $_SESSION["Event"];
            $Tests = explode(" ", $Event);
            $testcount = count($Tests);

            // $sheetCount = $spreadsheet->getSheetCount();

            if ($testcount != $spreadsheet_num) {
                // header("Location: import.file.marks.php");
                // exit();
                echo '<script type="text/javascript">';
                echo 'alert("Invalid File!");';
                echo 'setTimeout(function(){ window.location.href = "import.file.marks.php"; }, 500);'; // Wait for 2 seconds
                echo '</script>';
                exit();
            }

            $Questions = $_SESSION["Questions"];

            for($current_spreadsheet_num=0; $current_spreadsheet_num < $spreadsheet_num; $current_spreadsheet_num++){
                $spreadsheet = $reader->getSheet($current_spreadsheet_num);
                $Test = $spreadsheet->getTitle();
                if(!in_array($Test, $Tests)){
                    // echo "Invalid File";
                    // header("Location: import.file.marks.php");
                    // exit();

                    echo '<script type="text/javascript">';
                    echo 'alert("Invalid File!");';
                    echo 'setTimeout(function(){ window.location.href = "import.file.marks.php"; }, 500);'; // Wait for 2 seconds
                    echo '</script>';
                    exit();
                }
                $spreadsheet = $spreadsheet->toArray();
                array_shift($spreadsheet);

                $total_questions = $Questions[$Test];

                //echo $Test."<br>";
                //echo $total_questions."<br>";

                $query2_part = "";
                for($counter = 1; $counter <= $total_questions; $counter++){
                    $query2_part = $query2_part."Q".$counter.", ";
                }
                $query2_part = rtrim($query2_part,", ");

                $flag = 0;
                foreach($spreadsheet as $key => $row){
                    $query1 = "SELECT Student_Name FROM NBA_RECORDS WHERE Course_Key =".$Course_Key." AND Test = '".$Test."' AND Roll_no = '";
                    $query2 = "INSERT INTO NBA_RECORDS(Course_key, Roll_no, Student_name, Batch, Test, ".$query2_part.") VALUES (".$Course_Key.", ";
                    $counter1 = 0;
                    $counter2 = 1;
                    $counter3 = 0;
                    foreach($row as $key => $cell){
                        if($counter1 == 0){
                            $query1 = $query1.$cell."'";
                            $counter1++;
                        }
                        if($counter2 <= 3){
                            $query2 = $query2."'".$cell."', ";
                            if($counter2 == 3){
                                $query2 = $query2."'".$Test."', ";
                            }
                            $counter2++;
                        }
                        else{
                            if($cell == NULL){
                                $cell = "NULL";
                            }
                            $counter3++;
                            $query2 = $query2.$cell.", ";
                        }
                    }
                    if($counter3 != $total_questions){
                        if($flag == 0){
                            // echo "Please Select Correct File!<br>";
                            echo '<script type="text/javascript">';
                            echo 'alert("Number of questions in spreadsheet is not matching with the questions you gave as input!");'; 
                            echo 'setTimeout(function(){ window.location.href = "import.file.marks.php"; }, 500);';                          
                            echo '</script>';
                            exit();        
                            
                            // Number of questions in spreadsheet is not matching with the questions you gave as input
                        }
                        $flag++;
                    }
                    else{
                        $query2 = rtrim($query2, ", ").")";
                        //echo $query1."<br>";
                        //echo $query2."<br>";
                        $result1 = mysqli_query($conn, $query1);
                        if(mysqli_num_rows($result1) == 0){
                          //echo "Inserted<br>";
                          mysqli_query($conn, $query2);
                          
                        }
                    }
                }
            }
            header("Location: import.processing.php");
            exit();
        }
        else{
            // echo "Invalid File";
            // header("Location: import.file.marks.php");
            // exit();

            echo '<script type="text/javascript">';
            echo 'alert("Invalid File!");';
            echo 'setTimeout(function(){ window.location.href = "import.file.marks.php"; }, 500);'; // Wait for 2 seconds
            echo '</script>';
            exit();
        }
    }
?>