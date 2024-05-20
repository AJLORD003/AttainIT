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
            
            $testcount = 1;

            if ($testcount != $spreadsheet_num) {
                // header("Location: download.report.feedback.php");
                // exit();
                echo '<script type="text/javascript">';
                echo 'alert("Invalid File!");';
                echo 'setTimeout(function(){ window.location.href = "download.report.feedback.php"; }, 500);'; // Wait for 2 seconds
                echo '</script>';
                exit();
            }

            for($current_spreadsheet_num=0; $current_spreadsheet_num < $spreadsheet_num; $current_spreadsheet_num++){
                $spreadsheet = $reader->getSheet($current_spreadsheet_num);
                $Test = $spreadsheet->getTitle();

                if($Test != "feedback"){
                    // echo "Invalid File";
                    // header("Location: download.report.feedback.php");
                    // exit();

                    echo '<script type="text/javascript">';
                    echo 'alert("Invalid File!");';
                    echo 'setTimeout(function(){ window.location.href = "download.report.feedback.php"; }, 500);'; // Wait for 2 seconds
                    echo '</script>';
                    exit();
                }
                $spreadsheet = $spreadsheet->toArray();
                $header_row = array_shift($spreadsheet);

                $header_row = array_map('trim', $header_row);

                $valid_headers = ["Roll_no", "Student_Name", "Batch", "CO1", "CO2", "CO3", "CO4", "CO5", "CO6", "CO7", "CO8", "CO9", "CO10"];
                $help_headers = ["Roll_no", "Student_Name", "Batch"];
                $Feedback_CO = array();

                $query2_part = "";
                foreach($header_row as $key => $value){
                    if(!in_array($value, $header_row)){
                        // echo "Invalid File";
                        // header("Location: download.report.feedback.php");
                        // exit();
    
                        echo '<script type="text/javascript">';
                        echo 'alert("Invalid File!");';
                        echo 'setTimeout(function(){ window.location.href = "download.report.feedback.php"; }, 500);'; // Wait for 2 seconds
                        echo '</script>';
                        exit();
                    }
                    if(!in_array($value, $help_headers)){
                        $Feedback_CO[] = $value;
                    }
                    $query2_part = $query2_part.$value.", ";
                    //echo $value." ";
                }
                $_SESSION['Feedback_CO'] = $Feedback_CO;
                $query2_part = rtrim($query2_part,", ");
                //echo $query2_part."<br>";

                foreach($spreadsheet as $key => $row){
                    $query1 = "SELECT Student_Name FROM NBA_FEEDBACK_RECORDS WHERE Course_Key =".$Course_Key." AND Roll_no = '";
                    $query2 = "INSERT INTO NBA_FEEDBACK_RECORDS(Course_key, ".$query2_part.") VALUES (".$Course_Key.", ";
                    $counter1 = 0;
                    $counter2 = 1;
                    foreach($row as $key => $cell){
                        if($counter1 == 0){
                            $query1 = $query1.$cell."'";
                            $counter1++;
                        }

                        if($counter2 <= 3){
                            $query2 = $query2."'".$cell."', ";
                            $counter2++;
                        }
                        else{
                            if($cell == NULL){
                                $cell = "NULL";
                            }
                            $query2 = $query2.$cell.", ";
                        }
                        //echo $cell." ";
                    }
                    $query2 = rtrim($query2, ", ").")";
                    // echo $query1."<br>";
                    // echo $query2."<br>";
                    //echo "<br>";
                    $result1 = mysqli_query($conn, $query1);
                    if(mysqli_num_rows($result1) == 0){
                        //echo "Inserted<br>";
                        mysqli_query($conn, $query2);
                          
                    }
                }
            }
            header("Location: download.report.feedback.processing.php");
            exit();
        }
        else{
            // echo "Invalid File";
            // header("Location: download.report.feedback.php");
            // exit();

            echo '<script type="text/javascript">';
            echo 'alert("Invalid File!");';
            echo 'setTimeout(function(){ window.location.href = "download.report.feedback.php"; }, 500);'; // Wait for 2 seconds
            echo '</script>';
            exit();
        }
    }
?>