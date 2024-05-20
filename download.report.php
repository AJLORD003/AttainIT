<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Options</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <style>
         body {
      background-color: #05051e;
    }
    </style>

</head>

<body>

    <?php
    function numeric_to_alphabetic_column_label($numeric_value)
    {
        $result_label = '';

        for ($power = 1; $numeric_value >= 0 && $power < 10; $power++) {
            $remainder = $numeric_value % pow(26, $power);
            $current_char_code = 0x41 + ($remainder / pow(26, $power - 1));
            $current_character = chr($current_char_code);
            $result_label = $current_character . $result_label;

            $numeric_value -= pow(26, $power);
        }

        return $result_label;
    }
    ?>

    <?php
    session_start();

    $Course_Key = $_SESSION['Course_Key'];
    $Event = $_SESSION["Event"];
    $Tests = explode(" ", $Event);
    $length = count($Tests);

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "JIIT";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    require 'vendor/autoload.php';

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\IOFactory;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    $info = array();

    $query1 = "SELECT * FROM COURSE_DETAILS WHERE Course_Key = " . $Course_Key;
    //echo $query1 . "<br>";
    $result1 = mysqli_query($conn, $query1);

    $Semester = ['O', 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X'];

    $result1 = $result1->fetch_assoc();
    $info[] = $result1["Institute"];
    $info[] = "Academic Year : " . $result1["Academic_Year"];
    $academicYear = trim(substr($result1["Academic_Year"], 0, strpos($result1["Academic_Year"], '(')));
    $info[] = "Semester/Branch : " . $Semester[$result1["Semester"]] . ', ' . $result1["Branch"];
    $info[] = "NBA Code : " . $result1["NBA_Code"];
    $info[] = "Course Name and Code : " . $result1["Course_Name"] . "; " . $result1["Course_Code"];
    $info[] = "Course_Coordinator : " . $result1["Course_Coordinator"];

    $NBA_Code = $result1["NBA_Code"];
    $Course_Code = $result1["Course_Code"];

    $spreadsheet = new Spreadsheet();

    $sheet_counter = 0;

    foreach ($Tests as $Test) {

        if ($sheet_counter + 1 != $length) {
            $spreadsheet->createSheet();
        }

        $spreadsheet->setActiveSheetIndex($sheet_counter);

        if ($Test == "T3") {
            $Test_Use = "End Term";
        }
        elseif ($Test == "CO"){
            $Test_Use = "Final CO-Attainment";
        } else {
            $Test_Use = $Test;
        }

        $spreadsheet->getActiveSheet()->setTitle($Test_Use);

        $row = 1;
        foreach ($info as $data) {
            $spreadsheet->getActiveSheet()->setCellValue([1, $row], $data);
            $row++;
        }

        if ($Test == "CO"){
            $spreadsheet->getActiveSheet()->mergeCells('A7:N7');
            $spreadsheet->getActiveSheet()->setCellValue('A7', 'Average CO-Attainment');

            $query6 = "SELECT Description FROM Question_Details Where Course_Key = " . $Course_Key . " AND Test = 'TA' ORDER BY Question";
            //echo $query6."<br>";

            $average_co_attainment_1 = array();
            $average_co_attainment_1[] = "COs";
            $average_co_attainment_1[] = "T1";
            $average_co_attainment_1[] = "T2";
            $average_co_attainment_1[] = "End Term";
            $average_co_attainment_1[] = "T-AVG(Avg. of T1, T2 & End Term)";

            $result6 = mysqli_query($conn, $query6);

            while ($row = $result6->fetch_assoc()){
                $average_co_attainment_1[] = $row["Description"];
            }
            $spreadsheet->getActiveSheet()->fromArray($average_co_attainment_1, NULL, 'A8');

            $average_co_attainment_2 = array();
            $average_co_attainment_2[] = "Assgn-AVG";
            $average_co_attainment_2[] = "Direct Attainment (60% T-AVG + 20% Assgn-AVG OR 80% T-AVG OR 0.8* Assgn-AVG)";
            $average_co_attainment_2[] = "Student Feedback (Indirect Assessment)";
            $average_co_attainment_2[] = "Final (Direct + 20% Indirect)";

            $spreadsheet->getActiveSheet()->fromArray($average_co_attainment_2, NULL, numeric_to_alphabetic_column_label(count($average_co_attainment_1)).'8');

            $query7 = "SELECT DISTINCT(Question_CO) FROM Question_Details WHERE Course_Key = " . $Course_Key . " ORDER BY Question_CO";
            $result7 = mysqli_query($conn, $query7);

            $distinct_co = array();

            while ($row = $result7->fetch_assoc()){
                $distinct_co[] = $row["Question_CO"];
            }

            $row = 9;
            foreach ($distinct_co as $co) {
                $spreadsheet->getActiveSheet()->setCellValue([1, $row], $co);
                $row++;
            }

            $temp_events = ["T1", "T2", "T3", "TA"];
            $column_no = 2;
            $row_no = 9;
            $Assgn_avg = array();
            foreach($temp_events as $event){
                $query8 = "SELECT CO, CO_Level FROM final_attainment Where Course_Key = " . $Course_Key . " AND Test = '" . $event . "' ORDER BY CO";
                $result8 = mysqli_query($conn, $query8);
                while ($row = $result8->fetch_assoc()){
                    $index = array_search($row["CO"], $distinct_co);
                    if($event != "TA"){
                        $spreadsheet->getActiveSheet()->setCellValue([$column_no, ($row_no + $index)], $row["CO_Level"]);
                        if($event == "T3"){
                            $spreadsheet->getActiveSheet()->setCellValue([count($average_co_attainment_1) + count($average_co_attainment_2) + 1 + 2, ($row_no + $index)], $row["CO_Level"]);
                        }
                    }
                    else{
                        $Assgn_avg[$row["CO"]] = $row["CO_Level"];
                        $spreadsheet->getActiveSheet()->setCellValue([count($average_co_attainment_1) + 1, ($row_no + $index)], $row["CO_Level"]);
                    }
                }
                $column_no++;
            }

            $query9 = "SELECT CO, SUM(CO_Level), COUNT(CO) FROM final_attainment WHERE Course_Key = " . $Course_Key . " AND Test in ('T1', 'T2', 'T3') GROUP BY CO ORDER BY CO";
            $result9 = mysqli_query($conn, $query9);
            $T_avg = array();
            while ($row = $result9->fetch_assoc()){
                $T_avg[$row["CO"]] = $row["SUM(CO_Level)"]/$row["COUNT(CO)"];
                $index = array_search($row["CO"], $distinct_co);
                $spreadsheet->getActiveSheet()->setCellValue([5, (9 + $index)], $row["SUM(CO_Level)"] / $row["COUNT(CO)"]);
            }

            $direct = array();
            foreach($distinct_co as $co){
                $index = array_search($co, $distinct_co);
                if (array_key_exists($co, $T_avg) && array_key_exists($co, $Assgn_avg)){
                    $direct[$co] = 0.6*$T_avg[$co] + 0.2*$Assgn_avg[$co];
                }
                elseif(array_key_exists($co, $T_avg)){
                    $direct[$co] = 0.8*$T_avg[$co];
                }
                elseif(array_key_exists($co, $Assgn_avg)){
                    $direct[$co] = 0.8*$Assgn_avg[$co];
                }
                else{
                    $direct[$co] = 0;
                }
                $spreadsheet->getActiveSheet()->setCellValue([count($average_co_attainment_1) + 2, (9 + $index)], $direct[$co]);
            }

            $query10 = "SELECT CO, CO_Level FROM final_attainment WHERE Course_Key = ".$Course_Key." AND Test = 'feedback' ORDER BY CO";
            $result10 = mysqli_query($conn, $query10);
            $indirect = array();
            while ($row = $result10->fetch_assoc()){
                $indirect[$row["CO"]] = $row["CO_Level"];
                $index = array_search($row["CO"], $distinct_co);
                $spreadsheet->getActiveSheet()->setCellValue([count($average_co_attainment_1) + 3, (9 + $index)], $row["CO_Level"]);
            }

            $final = array();
            foreach($distinct_co as $co){
                $final[$co] = round($direct[$co] + 0.2*$indirect[$co], 1);
                $index = array_search($co, $distinct_co);
                //select, update, insert
                $query200 = "SELECT * FROM course_co_attainment WHERE Course_Code = '$Course_Code' AND CO = '$co' AND Academic_Year = '$academicYear'";
                $query201 = "INSERT INTO course_co_attainment(Course_Code, CO, Attainment, Academic_Year) VALUES('$Course_Code', '$co', ".$final[$co].", '".$academicYear."')";
                $query202 = "UPDATE course_co_attainment SET Attainment = ".$final[$co]." WHERE Course_Code = '$Course_Code' AND CO = '$co' AND Academic_Year = '$academicYear'";
                // echo $query200."<br>";
                // echo $query201."<br>";
                // echo $query202."<br>";
                $result200 = mysqli_query($conn, $query200);
                if (mysqli_num_rows($result200) == 0){
                    mysqli_query($conn, $query201);
                    // echo "1<br>";
                }
                else{
                    mysqli_query($conn, $query202);
                    // echo "2<br>";
                }
                $spreadsheet->getActiveSheet()->setCellValue([count($average_co_attainment_1) + 4, (9 + $index)], $final[$co]);
                $spreadsheet->getActiveSheet()->setCellValue([2, (9 + count($distinct_co) + 3 + $index)], $final[$co]);
            }

            $spreadsheet->getActiveSheet()->setCellValue(numeric_to_alphabetic_column_label(count($average_co_attainment_1) + count($average_co_attainment_2) + 1).'8', 'CIE');
            $spreadsheet->getActiveSheet()->setCellValue(numeric_to_alphabetic_column_label(count($average_co_attainment_1) + count($average_co_attainment_2) + 1 + 1).'8', 'SEE');

            $query11 = "SELECT CO, AVG(CO_Level) FROM final_attainment WHERE Course_Key = ".$Course_Key." AND Test in ('T1', 'T2', 'TA') GROUP BY CO ORDER BY CO";
            $result11 = mysqli_query($conn, $query11);
            while ($row = $result11->fetch_assoc()){
                $index = array_search($row["CO"], $distinct_co);
                $spreadsheet->getActiveSheet()->setCellValue([count($average_co_attainment_1) + count($average_co_attainment_2) + 1 + 1, (9 + $index)], $row["AVG(CO_Level)"]);
            }

            $spreadsheet->getActiveSheet()->mergeCells('A'.(9+sizeof($distinct_co)+1).':P'.(9+sizeof($distinct_co)+1));
            $spreadsheet->getActiveSheet()->setCellValue('A'.(9+sizeof($distinct_co)+1), 'CO-PO-PSO Mapping');

            $mapping_column_names = ["CO", "CO Attainments", "PO1", "PO2", "PO3", "PO4", "PO5", "PO6", "PO7", "PO8", "PO9", "PO10", "PO11", "PO12", "PSO1", "PSO2"];
            $spreadsheet->getActiveSheet()->fromArray($mapping_column_names, NULL, 'A'.(9+sizeof($distinct_co)+1+1));

            $row = 9+sizeof($distinct_co)+2+1;
            foreach ($distinct_co as $co) {
                $spreadsheet->getActiveSheet()->setCellValue([1, $row], $co);
                $row++;
            }

            $po_pso_column_names = ["PO1", "PO2", "PO3", "PO4", "PO5", "PO6", "PO7", "PO8", "PO9", "PO10", "PO11", "PO12", "PSO1", "PSO2"];
            $query20 = "SELECT CO FROM final_attainment WHERE Course_Key = " . $Course_Key . " AND Test = 'feedback' ORDER BY CO";
            $result20 = mysqli_query($conn, $query20);
            $co_map = "";
            while ($row3 = $result20->fetch_assoc()) {
                $co_map = $co_map."'".$row3["CO"]."', ";
            }
            $co_map = rtrim($co_map,", ");
            // echo $co_map;
            $query12 = "SELECT * FROM co_map WHERE Course_Code = '".$Course_Code."' AND CO IN (".$co_map.") GROUP BY CO ORDER BY CO";
            // echo $query21;
            // $query12 = "SELECT * FROM co_map WHERE Course_Code = '".$Course_Code."' GROUP BY CO ORDER BY CO";
            $column = 9+sizeof($distinct_co)+2+1;
            $mapping = array();
            $result12 = mysqli_query($conn, $query12);
            while ($row = $result12->fetch_assoc()){
                $temporary = array();
                foreach($po_pso_column_names as $po){
                    $temporary["$po"] = $row["$po"];
                }
                $mapping[$row["CO"]] = $temporary;
                $spreadsheet->getActiveSheet()->fromArray($temporary, NULL, 'C'.$column);
                $column++;
            }

            $spreadsheet->getActiveSheet()->mergeCells('A'.(9+(2*sizeof($distinct_co))+2+1).':B'.(9+(2*sizeof($distinct_co))+2+1));
            $spreadsheet->getActiveSheet()->setCellValue('A'.(9+(2*sizeof($distinct_co))+2+1), 'NBA Code:'.$NBA_Code);

            $row = (9+(2*sizeof($distinct_co))+2+1);
            $col = 3;
            foreach($po_pso_column_names as $po){
                $temp_sum = 0;
                $temp_count = 0;
                foreach($distinct_co as $co){
                    $temp_sum += $mapping[$co][$po];
                    if($mapping[$co][$po] != 0){
                        $temp_count++;
                    }
                }
                if ($temp_count != 0) {
                    $spreadsheet->getActiveSheet()->setCellValue([$col, $row], round($temp_sum / $temp_count));
                } else {
                    $spreadsheet->getActiveSheet()->setCellValue([$col, $row], 0);
                }
                $col++;
            }

            $spreadsheet->getActiveSheet()->mergeCells('A'.(9+(2*sizeof($distinct_co))+2+1+2).':P'.(9+(2*sizeof($distinct_co))+2+1+2));
            $spreadsheet->getActiveSheet()->setCellValue('A'.(9+(2*sizeof($distinct_co))+2+1+2), 'PO-PSO-Attainmnet');

            $spreadsheet->getActiveSheet()->mergeCells('A'.(9+(2*sizeof($distinct_co))+2+1+3).':B'.(9+(2*sizeof($distinct_co))+2+1+3));
            $spreadsheet->getActiveSheet()->setCellValue('A'.(9+(2*sizeof($distinct_co))+2+1+3), 'Course');
            $spreadsheet->getActiveSheet()->mergeCells('A'.(9+(2*sizeof($distinct_co))+2+1+4).':B'.(9+(2*sizeof($distinct_co))+2+1+4));
            $spreadsheet->getActiveSheet()->setCellValue('A'.(9+(2*sizeof($distinct_co))+2+1+4), 'NBA Code:'.$NBA_Code);
            $spreadsheet->getActiveSheet()->fromArray($po_pso_column_names, NULL, 'C'.(9+(2*sizeof($distinct_co))+2+1+3));

            $row = (9+(2*sizeof($distinct_co))+2+1+4);
            $col = 3;
            $po_array = array();
            foreach($po_pso_column_names as $po){
                $temp_sum = 0;
                $temp_mult = 0;
                foreach($distinct_co as $co){
                    $temp_sum += $mapping[$co][$po];
                    $temp_mult += $final[$co]*$mapping[$co][$po];
                }
                if($temp_sum != 0){
                    $spreadsheet->getActiveSheet()->setCellValue([$col, $row], round($temp_mult / $temp_sum, 1));
                    $po_array[$po] = round($temp_mult/$temp_sum,1);
                } else{
                    $spreadsheet->getActiveSheet()->setCellValue([$col, $row], 0);
                    $po_array[$po] = 0;
                }
                $col++;
            }
            // select, update, insert

            $query200 = "SELECT * FROM course_po_attainment WHERE Course_Code = '$Course_Code' AND Academic_Year = '$academicYear'";
            $query201 = "INSERT INTO course_po_attainment(Course_Code, PO1, PO2, PO3, PO4, PO5, PO6, PO7, PO8, PO9, PO10, PO11, PO12, PSO1, PSO2, Academic_Year) VALUES('".$Course_Code."', ".$po_array["PO1"].", ".$po_array["PO2"].", ".$po_array["PO3"].", ".$po_array["PO4"].", ".$po_array["PO5"].", ".$po_array["PO6"].", ".$po_array["PO7"].", ".$po_array["PO8"].", ".$po_array["PO9"].", ".$po_array["PO10"].", ".$po_array["PO11"].", ".$po_array["PO12"].", ".$po_array["PSO1"].", ".$po_array["PSO2"].", '".$academicYear."')";
            $query202 = "UPDATE course_po_attainment SET PO1 = ".$po_array["PO1"].", PO2 = ".$po_array["PO2"].", PO3 = ".$po_array["PO3"].", PO4 = ".$po_array["PO4"].", PO5 = ".$po_array["PO5"].", PO6 = ".$po_array["PO6"].", PO7 = ".$po_array["PO7"].", PO8 = ".$po_array["PO8"].", PO9 = ".$po_array["PO9"].", PO10 = ".$po_array["PO10"].", PO11 = ".$po_array["PO11"].", PO12 = ".$po_array["PO12"].", PSO1 = ".$po_array["PSO1"].", PSO2 = ".$po_array["PSO2"]." WHERE Course_Code = '$Course_Code' AND Academic_Year = '$academicYear'";
            // echo $query200."<br>";
            // echo $query201."<br>";
            // echo $query202."<br>";
            $result200 = mysqli_query($conn, $query200);
            if (mysqli_num_rows($result200) == 0){
                mysqli_query($conn, $query201);
                // echo "1<br>";
            }
            else{
                mysqli_query($conn, $query202);
                // echo "2<br>";
            }

            $query16 = "SELECT DISTINCT(DESCRIPTION) From Question_Details Where Course_key = ".$Course_Key." AND Test = 'TA' ORDER BY Question";
            $result16 = mysqli_query($conn, $query16);
            $column_index = 6;
            while ($row = $result16->fetch_assoc()){
                $query17 = "SELECT Question, Question_CO, Question_Marks FROM Question_Details Where Course_Key = ".$Course_Key." AND Test = 'TA' AND DESCRIPTION = '".$row["DESCRIPTION"]."'";
                $result17 = mysqli_query($conn, $query17);
                while($row2 = $result17->fetch_assoc()){
                    $query18 = "SELECT COUNT(*) AS Student_Appeared FROM NBA_RECORDS WHERE Course_Key = ".$Course_Key." AND Test = 'TA' AND ".$row2["Question"]." IS NOT NULL";
                    $Student_Appeared = mysqli_query($conn, $query18)->fetch_assoc()["Student_Appeared"];

                    $query19 = "SELECT COUNT(*) AS Student_Num FROM NBA_RECORDS WHERE Course_Key = ".$Course_Key." AND Test = 'TA' AND ".$row2["Question"]." >= ".(0.5*$row2["Question_Marks"]);
                    $Student_Num = mysqli_query($conn, $query19)->fetch_assoc()["Student_Num"];

                    $Student_Percent = ($Student_Num/$Student_Appeared)*100;
                    if($Student_Percent >= 80){
                        $CO_Level=3;
                    }
                    elseif($Student_Percent >= 70){
                        $CO_Level=2;
                    }
                    elseif($Student_Percent >= 60){
                        $CO_Level=1;
                    }
                    else{
                        $CO_Level=0;
                    }
                    $index = array_search($row2["Question_CO"], $distinct_co);
                    $spreadsheet->getActiveSheet()->setCellValue([$column_index, (9 + $index)], $CO_Level);
                }
                $column_index++;
            }

        }
        else{
            $spreadsheet->getActiveSheet()->setCellValue([4, 3], "Examination: " . $Test_Use);

            if ($Test != "TA") {
                $query2 = "SELECT Question, Question_CO, Question_Marks FROM Question_Details Where Course_Key = " . $Course_Key . " AND Test = '" . $Test . "' ORDER BY Question";
            } else {
                $query2 = "SELECT Question, Question_CO, Question_Marks, Description FROM Question_Details Where Course_Key = " . $Course_Key . " AND Test = '" . $Test . "' ORDER BY Question";
            }
            // echo $query2."<br>";

            $result2 = mysqli_query($conn, $query2);

            $question = array();
            $question_co = array();
            $question_co_nba_code = array();
            $question_marks = array();
            $question_desciption = array();

            $question_number_marks = array();

            $question_number_marks[] = "SN.";
            $question_number_marks[] = "Roll No.";
            $question_number_marks[] = "Student Name";

            while ($row = $result2->fetch_assoc()) {
                $question[] = $row["Question"];

                $question_co_nba_code[] = $row["Question_CO"];
                $temp = explode(".", $row["Question_CO"]);
                $question_co[] = "CO" . end($temp);

                $question_marks[] = $row["Question_Marks"];

                if ($Test == "TA") {
                    $question_desciption[] = $row["Description"];
                    $question_number_marks[] = $row["Description"] . "(" . $row["Question_Marks"] . "M)";
                    // echo $row["Description"] . "<br>";
                } else {
                    $question_number_marks[] = $row["Question"] . "(" . $row["Question_Marks"] . "M)";
                }

                // echo $row["Question"] . "<br>";
                // echo $row["Question_Marks"] . "<br>";
                // echo "CO".end($temp) . "<br>";
            }


            $spreadsheet->getActiveSheet()->mergeCells('A8:C8');
            $spreadsheet->getActiveSheet()->setCellValue('A8', 'Course Outcome: ');

            $spreadsheet->getActiveSheet()->fromArray($question_co_nba_code, NULL, 'D8');

            $start = numeric_to_alphabetic_column_label(count($question_co_nba_code) + 3) . "8";
            $end = numeric_to_alphabetic_column_label(count($question_co_nba_code) + 3) . "9";

            $spreadsheet->getActiveSheet()->mergeCells("$start:$end");
            $spreadsheet->getActiveSheet()->setCellValue("$start", 'Total');

            $unique_question_co_nba_code = array_values(array_unique($question_co_nba_code));

            $start = numeric_to_alphabetic_column_label(count($question_co_nba_code) + 4) . "8";
            $end = numeric_to_alphabetic_column_label(count($question_co_nba_code) + 4 + count($unique_question_co_nba_code) - 1) . "8";

            $spreadsheet->getActiveSheet()->mergeCells("$start:$end");
            $spreadsheet->getActiveSheet()->setCellValue("$start", 'Attainment %');

            $spreadsheet->getActiveSheet()->fromArray($question_number_marks, NULL, 'A9');

            $start = numeric_to_alphabetic_column_label(count($question_number_marks) + 1) . "9";

            $spreadsheet->getActiveSheet()->fromArray($question_co_nba_code, NULL, "$start");



            $unique_question_co = array_values(array_unique($question_co));

            $query3 = "SELECT Roll_no, Student_name, ";

            foreach ($question as $q) {
                $query3 = $query3 . $q . ", ";
            }
            $query3 = $query3 . "Total, ";
            foreach ($unique_question_co as $unique_ques_co) {
                $query3 = $query3 . $unique_ques_co . "_Percent, ";
            }
            $query3 = rtrim($query3, ', ');
            $query3 = $query3 . " FROM NBA_Records Where Course_key = " . $Course_Key . " AND Test = '" . $Test . "'";
            // echo $query3 . "<br>";

            $result3 = mysqli_query($conn, $query3);


            $record_counter = 1;
            while ($row = $result3->fetch_assoc()) {
                $record = array();
                $record[] = $record_counter;
                $record[] = $row["Roll_no"];
                $record[] = $row["Student_name"];
                foreach ($question as $q) {
                    $record[] = $row["$q"];
                }
                $record[] = $row["Total"];
                foreach ($unique_question_co as $unique_ques_co) {
                    $record[] = $row["$unique_ques_co" . '_Percent'];
                }
                $temp = 9 + $record_counter;
                $start = "A" . "$temp";
                $spreadsheet->getActiveSheet()->fromArray($record, NULL, "$start");
                $record_counter++;
            }

            $final_attainment = array("No. of Students Scored > = Target %", "% of Students Scored > = Target % ", "CO Attainment Level", "Total Students", "No. of Students Appeared");

            $column_index = numeric_to_alphabetic_column_label(count($question) + 3);
            $row_index = $record_counter + 9;

            foreach ($final_attainment as $data) {
                $spreadsheet->getActiveSheet()->setCellValue($column_index . $row_index, $data);
                $row_index++;
            }

            $column_counter = 1;
            foreach ($unique_question_co_nba_code as $unique_ques_co_nba_code) {
                $query4 = "SELECT Student_Num, Student_Percent, CO_Level, Total_Students, Student_Appeared FROM FINAL_ATTAINMENT WHERE Course_Key = " . $Course_Key . " AND TEST = '" . $Test . "' AND CO = '" . $unique_ques_co_nba_code . "'";
                // echo $query4."<br>";

                $result4 = mysqli_query($conn, $query4);
                $result4 = $result4->fetch_assoc();

                $column_index = numeric_to_alphabetic_column_label(count($question) + 3 + $column_counter);
                $row_index = $record_counter + 9;

                foreach ($result4 as $data) {
                    $spreadsheet->getActiveSheet()->setCellValue($column_index . $row_index, $data);
                    $row_index++;
                }

                $column_counter++;
            }

            $target = array("NOTE:", "Target % is 50%");
            $record_counter = $row_index;

            $spreadsheet->getActiveSheet()->fromArray($target, NULL, "B" . $record_counter);
            $record_counter++;

            $target_table_headings = array("% of Students Scored >= Target %", "Levels");

            $spreadsheet->getActiveSheet()->mergeCells("B$record_counter:C$record_counter");

            $spreadsheet->getActiveSheet()->setCellValue("B$record_counter", $target_table_headings[0]);
            $spreadsheet->getActiveSheet()->setCellValue("D$record_counter", $target_table_headings[1]);
            $record_counter++;

            $target_details = array(">= 80%", "< 80% and >= 70%", "<70% and >= 60%", "<60%");

            $query5 = "SELECT Course_Credits FROM COURSES WHERE Course_Code = '" . $Course_Code . "'";

            $Course_Credits = mysqli_query($conn, $query5)->fetch_assoc()["Course_Credits"];

            foreach ($target_details as $detail) {
                $spreadsheet->getActiveSheet()->mergeCells("B$record_counter:C$record_counter");

                $spreadsheet->getActiveSheet()->setCellValue("B$record_counter", $detail);
                $spreadsheet->getActiveSheet()->setCellValue("D$record_counter", $Course_Credits);
                $Course_Credits--;
                $record_counter++;
            }



            
        }
        $sheet_counter++;
        
    }
    if(in_array("CO", $Tests)){
        $spreadsheet->createSheet();
        $spreadsheet->setActiveSheetIndex($sheet_counter);

        $spreadsheet->getActiveSheet()->setTitle("COURSE_EXIT_SURVEY");
        $query13 = "SELECT CO FROM final_attainment WHERE Course_Key = ".$Course_Key." AND Test = 'feedback' ORDER BY CO";
        $result13 = mysqli_query($conn, $query13);
        $feedback_co_2 = array();
        $feedback_co = array();
        while ($row = $result13->fetch_assoc()){
            $query100 = "SELECT Description FROM course_co_description WHERE Course_Code = '$Course_Code' AND CO = '".$row['CO']."'";
            $result100 = mysqli_query($conn, $query100)->fetch_assoc()["Description"];
            $feedback_co_2[] = " Fill the grid   5 represents 'to a great extent', 4 - 'to moderate extent', 3 -  'to some extent', 2-  'to less extent', 1- 'Not at all' [".$row["CO"]." ".$result100." ]";
            $feedback_co[] = $row["CO"];
        }

        $spreadsheet->getActiveSheet()->setCellValue('A1', 'S.No.');
        $spreadsheet->getActiveSheet()->setCellValue('B1', 'Enrolment Number');
        $spreadsheet->getActiveSheet()->setCellValue('C1', 'Student Name');
        $spreadsheet->getActiveSheet()->setCellValue('D1', 'Batch');
        $spreadsheet->getActiveSheet()->fromArray($feedback_co_2, NULL, 'E1');

        $query14 = "SELECT * FROM NBA_FEEDBACK_RECORDS WHERE Course_Key = ".$Course_Key;
        $result14 = mysqli_query($conn, $query14);
        $record_counter = 1;
        while ($row = $result14->fetch_assoc()){
            $record = array();
            $record[] = $record_counter;
            $record[] = $row["Roll_no"];
            $record[] = $row["Student_Name"];
            $record[] = $row["Batch"];
            foreach($feedback_co as $co){
                $Initial_CO = $co;
                $CO_Parts = explode(".",$Initial_CO);
                $CO_Num = end($CO_Parts);
                $record[] = $row["CO".$CO_Num];
            }
            $temp = 1 + $record_counter;
            $start = "A"."$temp";
            $spreadsheet->getActiveSheet()->fromArray($record, NULL, "$start");
            $record_counter++;
        }

        $final_attainment = array("No. of Students Scored > = Target %", "% of Students Scored > = Target % ", "CO Attainment Level", "Total Students", "No. of Students Appeared");

        $column_index = numeric_to_alphabetic_column_label(3);
        $row_index = $record_counter + 1;

        foreach ($final_attainment as $data) {
            $spreadsheet->getActiveSheet()->setCellValue($column_index . $row_index, $data);
            $row_index++;
        }

        $column_counter = 1;
        foreach ($feedback_co as $co) {
            $query15 = "SELECT Student_Num, Student_Percent, CO_Level, Total_Students, Student_Appeared FROM FINAL_ATTAINMENT WHERE Course_Key = " . $Course_Key . " AND TEST = 'feedback' AND CO = '" . $co . "'";
            // echo $query15."<br>";

            $result15 = mysqli_query($conn, $query15);
            $result15 = $result15->fetch_assoc();

            $column_index = numeric_to_alphabetic_column_label(3 + $column_counter);
            $row_index = $record_counter + 1;

            foreach ($result15 as $data) {
                $spreadsheet->getActiveSheet()->setCellValue($column_index . $row_index, $data);
                $row_index++;
            }

            $column_counter++;
        }
    }

    $outputFile = "report.xlsx";
    $writer = new Xlsx($spreadsheet);
    $writer->save($outputFile);
    ?>

<?php
    echo "<section class='h-screen w-full'>

    <a href='main.php' class='text-xs underline font-semibold absolute ml-4 mt-[4rem] text-[#CCCDDE]'>
    <i class='bi bi-arrow-left mr-1 text-[#CCCDDE]'></i>OPTIONS
</a>

        <div class='flex justify-center font-bold text-2xl pt-16 text-[#CCCDDE]'>
            CLICK BELOW TO DOWNLOAD
        </div>

        <div class='flex mt-12 justify-center gap-x-10 items-center'>                    
                  
            <a href='$outputFile' class='w-[15rem] h-[15rem] cursor-pointer border border-text-[#CCCDDE] rounded-md flex flex-col justify-center items-center hover:border-r-0 hover:border-b-0 hover:border-l-4 hover:border-t-4 hover:border-t-green-700 hover:bg-green-500 hover:text-white hover:border-l-green-700 transition-all duration-300 hover:shadow-lg text-[#CCCDDE]'>
                <div>
                    <svg xmlns='http://www.w3.org/2000/svg' width='50' height='50' fill='currentColor' class='bi bi-file-earmark-spreadsheet-fill text-[#CCCDDE]' viewBox='0 0 16 16'>
                        <path d='M6 12v-2h3v2z' />
                        <path d='M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0M9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1M3 9h10v1h-3v2h3v1h-3v2H9v-2H6v2H5v-2H3v-1h2v-2H3z' />
                    </svg>
                </div>

                <div class='mt-5 font-semibold text-xl text-[#CCCDDE]'>
                    Download
                </div>

                <div class='font-semibold text-xl text-[#CCCDDE]'>
                    Excel
                </div>
            </a>
        </div>
    </section>"

    ?> 

</body>

</html>