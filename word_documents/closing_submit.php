<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IMPORT RECORDS</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="index.css">

    <style>
        body {
      background-color: #05051e;
    }
    </style>

</head>

<body>

<?php
require_once 'vendor/autoload.php';
$phpWord = new \PhpOffice\PhpWord\PhpWord();
use PhpOffice\PhpWord\Shared\Converter;
$phpWord->setDefaultFontName('Times New Roman');
$phpWord->addParagraphStyle('paragraph_default', array('spaceBefore' => 0, 'spaceAfter' => 0));

if (isset($_POST['submit'])) {
    session_start();
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "JIIT";
    $CourseCode = $_SESSION['CourseCode'];

    $Suggestion = $_POST['Suggestion'];
    $RelevancetoCO = $_POST['RelevancetoCO'];
    $RelevancetoPOPSO = $_POST['RelevancetoPO/PSO'];

    // $Target = $_POST['Target'];
    // $Attainments = $_POST['Attainments'];
    $Actions = $_POST['Actions'];
    $Proof = $_POST['Proof'];

    $AcademicYear = $_SESSION['AcademicYear'];
    $parts = explode("-", $AcademicYear);
    $start = (int)$parts[0];
    $end = (int)$parts[1];
    $Semester = $_SESSION['Semester'];
    $Branch = $_SESSION['Branch'];
    $NBACode = $_SESSION['NBACode'];

    $PO = array('PO1','PO2','PO3','PO4','PO5','PO6','PO7','PO8','PO9','PO10','PO11','PO12','PSO1','PSO2');

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    $query3 = "SELECT Course_Name FROM COURSES WHERE Course_Code = '$CourseCode'";
    $CourseName = mysqli_query($conn, $query3);

    if (mysqli_num_rows($CourseName) == 0) {
        echo '<script type="text/javascript">';
        echo 'alert("No Such Course Exist!");';
        echo 'setTimeout(function(){ window.location.href = "../import.course.details.php"; }, 500);';
        echo '</script>';
        exit();
    }

    $CourseName = $CourseName->fetch_assoc()["Course_Name"];

    $query2 = "SELECT Course_Coordinator FROM COURSES WHERE Course_Code = '$CourseCode'";
    $Course_Coordinator = mysqli_query($conn, $query2);
    $Course_Coordinator = $Course_Coordinator->fetch_assoc()["Course_Coordinator"];

    $query4 = "SELECT CO, Description, level FROM COURSE_CO_DESCRIPTION WHERE Course_Code = '$CourseCode'";
    $result = mysqli_query($conn, $query4);

    $COArray = array();
    $DescriptionArray = array();
    $LevelArray = array();

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $COArray[] = $row['CO'];
            $DescriptionArray[] = $row['Description'];
            $LevelArray[] = $row['level'];
        }
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    // echo "<script type='text/javascript'>alert('Something Went Wrong! <br>');</script>";
    // header("Location: import.course.details.php");
    // exit();

    echo '<script type="text/javascript">';
    echo 'alert("Something Went Wrong!");';
    echo 'setTimeout(function(){ window.location.href = "import.course.details.php"; }, 500);'; // Wait for 2 seconds
    echo '</script>';
    exit();
}

$section1 = $phpWord->addSection(array('orientation' => 'landscape'));

$section1->addText("Department of Computer Science and Engineering &amp; Information Technology", array('bold' => true, 'size' => 16), array('align' => 'center', 'spaceBefore' => 0, 'spaceAfter' => 0));

if ($Semester % 2 == 0) {
    $section1->addText("AY: ".$AcademicYear.", (Even Semester)", array('bold' => true, 'size' => 14), array('align' => 'center', 'spaceBefore' => 0, 'spaceAfter' => 0));
} else {
    $section1->addText("AY: ".$AcademicYear.", (Odd Semester)", array('bold' => true, 'size' => 14), array('align' => 'center', 'spaceBefore' => 0, 'spaceAfter' => 0));
}

$section1->addText('Course Closing Report', array('bold' => true, 'underline' => 'single', 'size' => 14), array('align' => 'center', 'spaceBefore' => 0, 'spaceAfter' => 0));

$section1->addText('Programme Name: B.Tech ('.$Branch.')', array('bold' => true, 'size' => 12));
$section1->addText('Semester: '.$Semester, array('bold' => true, 'size' => 12));
$section1->addText('Course Name &amp; Code: '.$CourseName." (".$CourseCode.")", array('bold' => true, 'size' => 12));
$section1->addText('NBA Code: '.$NBACode, array('bold' => true, 'size' => 12));
$section1->addText('Name of Course Coordinator(s): '.$Course_Coordinator, array('bold' => true, 'size' => 12));

$section1->addText("\n");
$section1->addText('1. Course Outcomes:', array('bold' => true, 'size' => 12));
$section1->addText("\n");
$section1->addText('At the completion of the course, students will be able to', array('size' => 12));

$table3 = $section1->addTable();

$row5 = $table3->addRow();
$cell1 = $row5->addCell(14000,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50]);
$cell1->getStyle()->setGridSpan(2);
$cell1->addText('COURSE OUTCOMES',['bold' => true]);
// $row5->addCell(6000, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText('COURSE OUTCOMES', ['bold' => true]);
$row5->addCell(3000,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText('COGNITIVE LEVELS',['bold' => true]);

for ($i = 0; $i < count($COArray); $i++) {
    $row = $table3->addRow();
    // Add CO cell
    $row->addCell(1500, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($i < count($COArray) ? $COArray[$i] : '');
    // Add Description cell
    $row->addCell(12500, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($i < count($DescriptionArray) ? $DescriptionArray[$i] : '');
    // Add Level cell
    $row->addCell(3000, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($i < count($LevelArray) ? $LevelArray[$i] : '');
}

$section1->addText("\n");

$section1->addText('2. CO-PO and CO-PSO Mapping:', array('bold' => true, 'size' => 12));

$table4 = $section1->addTable();

$column_names = ["CO", "PO1", "PO2", "PO3", "PO4", "PO5", "PO6", "PO7", "PO8", "PO9", "PO10", "PO11", "PO12", "PSO1", "PSO2"];
$row5 = $table4->addRow();
foreach ($column_names as $value) {
    $row5->addCell(1133,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($value,['bold' => true]);
}

$query5 = "SELECT CO, PO1, PO2, PO3, PO4, PO5, PO6, PO7, PO8, PO9, PO10, PO11, PO12, PSO1, PSO2 FROM co_map WHERE Course_Code = '$CourseCode'";
$result = mysqli_query($conn, $query5);

while($row = $result->fetch_assoc()){
    $row5 = $table4->addRow();
    $row5->addCell(1133,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($row["CO"],['bold' => true]);
    $row5->addCell(1133,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($row["PO1"],['bold' => true]);
    $row5->addCell(1133,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($row["PO2"],['bold' => true]);
    $row5->addCell(1133,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($row["PO3"],['bold' => true]);
    $row5->addCell(1133,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($row["PO4"],['bold' => true]);
    $row5->addCell(1133,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($row["PO5"],['bold' => true]);
    $row5->addCell(1133,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($row["PO6"],['bold' => true]);
    $row5->addCell(1133,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($row["PO7"],['bold' => true]);
    $row5->addCell(1133,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($row["PO8"],['bold' => true]);
    $row5->addCell(1133,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($row["PO9"],['bold' => true]);
    $row5->addCell(1133,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($row["PO10"],['bold' => true]);
    $row5->addCell(1133,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($row["PO11"],['bold' => true]);
    $row5->addCell(1133,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($row["PO12"],['bold' => true]);
    $row5->addCell(1133,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($row["PSO1"],['bold' => true]);
    $row5->addCell(1133,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($row["PSO2"],['bold' => true]);
}

$section1->addText("\n");

$section1->addText('3. CO Attainments in '.$AcademicYear.':', array('bold' => true, 'size' => 12));

$table4 = $section1->addTable();
$row5 = $table4->addRow();
$row5->addCell(2000,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText("Course",['bold' => true]);

$query6 = "SELECT CO FROM course_co_attainment WHERE Course_Code = '$CourseCode' ORDER BY CO";
$result6 = mysqli_query($conn, $query6);

while($row = $result6->fetch_assoc()){
    $row5->addCell(2000,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($row["CO"],['bold' => true]);
}

$row5 = $table4->addRow();
$row5->addCell(2000,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($NBACode,['bold' => true]);

$query6 = "SELECT Attainment FROM course_co_attainment WHERE Course_Code = '$CourseCode' AND Academic_Year = '$AcademicYear' ORDER BY CO";
$result6 = mysqli_query($conn, $query6);

while($row = $result6->fetch_assoc()){
    $row5->addCell(2000,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($row["Attainment"],['bold' => false]);
}

if(mysqli_num_rows($result6) == 0){
    $query6 = "SELECT CO FROM course_co_attainment WHERE Course_Code = '$CourseCode' ORDER BY CO";
    $result6 = mysqli_query($conn, $query6);
    while($row = $result6->fetch_assoc()){
        $row5->addCell(2000,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText(" ",['bold' => true]);
    }
}

$section1->addText("\n");

$section1->addText('4. PO-PSO Attainments in '.$AcademicYear.':', array('bold' => true, 'size' => 12));

$table4 = $section1->addTable();
// $row5 = $table4->addRow();

$column_names_2 = ["Course", "PO1", "PO2", "PO3", "PO4", "PO5", "PO6", "PO7", "PO8", "PO9", "PO10", "PO11", "PO12", "PSO1", "PSO2"];
$row5 = $table4->addRow();
foreach ($column_names_2 as $value) {
    $row5->addCell(2000,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($value,['bold' => true]);
}

$query6 = "SELECT * FROM course_po_attainment WHERE Course_Code = '$CourseCode' AND Academic_Year = '$AcademicYear'";
$result61 = mysqli_query($conn, $query6);
$result6 = mysqli_query($conn, $query6)->fetch_assoc();

$row5 = $table4->addRow();
$row5->addCell(2000,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($NBACode,['bold' => true]);
if(mysqli_num_rows($result61) > 0){
    $row5->addCell(2000,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($result6["PO1"],['bold' => false]);
    $row5->addCell(2000,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($result6["PO2"],['bold' => false]);
    $row5->addCell(2000,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($result6["PO3"],['bold' => false]);
    $row5->addCell(2000,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($result6["PO4"],['bold' => false]);
    $row5->addCell(2000,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($result6["PO5"],['bold' => false]);
    $row5->addCell(2000,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($result6["PO6"],['bold' => false]);
    $row5->addCell(2000,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($result6["PO7"],['bold' => false]);
    $row5->addCell(2000,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($result6["PO8"],['bold' => false]);
    $row5->addCell(2000,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($result6["PO9"],['bold' => false]);
    $row5->addCell(2000,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($result6["PO10"],['bold' => false]);
    $row5->addCell(2000,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($result6["PO11"],['bold' => false]);
    $row5->addCell(2000,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($result6["PO12"],['bold' => false]);
    $row5->addCell(2000,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($result6["PSO1"],['bold' => false]);
    $row5->addCell(2000,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($result6["PSO2"],['bold' => false]);
}
else{
    $column_names_2 = ["PO1", "PO2", "PO3", "PO4", "PO5", "PO6", "PO7", "PO8", "PO9", "PO10", "PO11", "PO12", "PSO1", "PSO2"];
    foreach ($column_names_2 as $value) {
        $row5->addCell(2000,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText(" ",['bold' => true]);
    }
}


$section1->addText("\n");
$section1->addText('5. Summary of Result Analysis:', array('bold' => true, 'size' => 12));

$table4 = $section1->addTable();
$row5 = $table4->addRow();
$row5->addCell(2000,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText("Grade",['bold' => true]);
$row5->addCell(2000,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText("Grade A+",['bold' => true]);
$row5->addCell(2000,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText("Grade A",['bold' => true]);
$row5->addCell(2000,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText("Grade B+",['bold' => true]);
$row5->addCell(2000,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText("Grade B",['bold' => true]);
$row5->addCell(2000,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText("Grade C+",['bold' => true]);
$row5->addCell(2000,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText("Grade C",['bold' => true]);
$row5->addCell(2000,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText("Grade D",['bold' => true]);
$row5->addCell(2000,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText("Grade F",['bold' => true]);

$gradeap = $_POST["gradeap"];
$gradea = $_POST["gradea"];
$gradebp = $_POST["gradebp"];
$gradeb = $_POST["gradeb"];
$gradecp = $_POST["gradecp"];
$gradec = $_POST["gradec"];
$graded = $_POST["graded"];
$gradef = $_POST["gradef"];

$dataSeries = array();
$dataSeries[] = $gradef;
$dataSeries[] = $graded;
$dataSeries[] = $gradec;
$dataSeries[] = $gradecp;
$dataSeries[] = $gradeb;
$dataSeries[] = $gradebp;
$dataSeries[] = $gradea;
$dataSeries[] = $gradeap;



$row5 = $table4->addRow();
$row5->addCell(2000,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText("% age of Students",['bold' => true]);
$row5->addCell(2000,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($gradeap,['bold' => false]);
$row5->addCell(2000,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($gradea,['bold' => false]);
$row5->addCell(2000,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($gradebp,['bold' => false]);
$row5->addCell(2000,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($gradeb,['bold' => false]);
$row5->addCell(2000,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($gradecp,['bold' => false]);
$row5->addCell(2000,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($gradec,['bold' => false]);
$row5->addCell(2000,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($graded,['bold' => false]);
$row5->addCell(2000,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($gradef,['bold' => false]);


$section1->addText("\n");

$categories = array('F', 'D', 'C', 'C+', 'B', 'B+', 'A', 'A+');

$chart = $section1->addChart('column', $categories, $dataSeries, ['categoryLabelPosition' => 'low', 'valueLabelPosition' => 'low', 'showAxisLabels' => true]);
$chart->getStyle()->setWidth(Converter::inchToEmu(4.5))->setHeight(Converter::inchToEmu(3.5));

$section1->addText("\n");

$section1->addText('6. Innovative Teaching and Learning Method used (if any):', array('bold' => true, 'size' => 12));

$Innovative_Teaching = $_POST["Innovative_Teaching"];
$Innovative_Teaching = explode("$$", $Innovative_Teaching);

$index = 0;
while ($index < count($Innovative_Teaching)) {
    $section1->addListItem($Innovative_Teaching[$index], 0, array('size' => 12));
    $index++;
}

// $section1->addListItem('To increase interaction and easy dissemination of resources, a google classroom has been created.', 0, array('size' => 12));
// $section1->addListItem("Creates students What’s Up group to increase the student’s interaction.", 0, array('size' => 12));
// $section1->addListItem('References using animations and videos to be used for a better understanding of basic topics.', 0, array('size' => 12));
// $section1->addListItem('Scenario-based questions introduced in tutorials in order to achieve the required OBE Level.', 0, array('size' => 12));
// $section1->addListItem("Gave weightage to important topics like process management, inter-process communication, etc. by increasing allotted lectures", 0, array('size' => 12));
// $section1->addListItem('Motivate faculty to teach important concepts related to campus placement through animation and AR material.', 0, array('size' => 12));
// $section1->addListItem('Updated and modified tutorial assignments to cater to the need for new technology.', 0, array('size' => 12));
// $section1->addListItem('More Questions/numerical with different scenarios will be discussed in lecture and tutorial classes for a deeper understanding of process management concepts and threads in OS', 0, array('size' => 12));
// $section1->addListItem('Introduce the concept of Active learning activities like think pair share kind of activity during the lectures', 0, array('size' => 12));

// $section1->addText('• To increase interaction and easy dissemination of resources, a google classroom has been created. ');
// $section1->addText("• Creates students What’s Up group to increase the student’s interaction.");
// $section1->addText('• References using animations and videos to be used for a better understanding of basic topics.');
// $section1->addText('• Scenario-based questions introduced in tutorials in order to achieve the required OBE Level. ');
// $section1->addText('• Gave weightage to important topics like process management, inter-process communication, etc. by increasing allotted lectures');
// $section1->addText('• Motivate faculty to teach important concepts related to campus placement through animation and AR material.');
// $section1->addText('• Updated and modified tutorial assignments to cater to the need for new technology. ');
// $section1->addText('• More Questions/numerical with different scenarios were discussed in lecture and tutorial classes for a deeper understanding of process management concepts and threads in OS');
// $section1->addText('• Introduce the concept of Active learning activities like think pair share kind of activity during the lectures');

$section1->addText("\n");

$section1->addText('7. Innovative Evaluation Strategy used (If any):', array('bold' => true, 'size' => 12));

$Innovative_Evaluation = $_POST["Innovative_Evaluation"];
$Innovative_Evaluation = explode("$$", $Innovative_Evaluation);

$index = 0;
while ($index < count($Innovative_Evaluation)) {
    $section1->addListItem($Innovative_Evaluation[$index], 0, array('size' => 12));
    $index++;
}

// $section1->addListItem("Project demonstration by students’ group and evaluation by faculty.", 0, array('size' => 12));
// $section1->addListItem("Interactive Oral viva to assess the project ", 0, array('size' => 12));
// $section1->addListItem("Innovative technique introduced among faculties to prepare an interactive presentation.", 0, array('size' => 12));
// $section1->addListItem("Indirect questions with multiple concepts were used to test the learning aptitude in lecture as well as tutorial class.", 0, array('size' => 12));
// $section1->addListItem("Evaluation questions were targeted to judge the individual outcome set for each topic.  ", 0, array('size' => 12));

// $section1->addText('• Project demonstration by students’ group and evaluation by faculty. ');
// $section1->addText('• Interactive Oral viva to assess the project  ');
// $section1->addText('• Innovative technique introduced among faculties to prepare an interactive presentation.  ');

// $section1->addText('• Indirect questions with multiple concepts were used to test the learning aptitude in lecture as well as tutorial class. ');
// $section1->addText('• Evaluation questions were targeted to judge the individual outcome set for each topic. ');

$section1->addText("\n");

$section1->addText('8. Actions Taken for Improvement in CO Attainments:', array('bold' => true, 'size' => 12));

$table5 = $section1->addTable();

$row7 = $table5->addRow();
$row7->addCell(1500, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50, 'vMerge' => 'restart'])->addText('COs', ['bold' => true]);
$row7->addCell(1500, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50, 'vMerge' => 'restart'])->addText('Attainments in '.($start-3).'-'.($end-3), ['bold' => true, 'size' => 8]);
$row7->addCell(1500, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50, 'vMerge' => 'restart'])->addText('Attainments in '.($start-2).'-'.($end-2), ['bold' => true, 'size' => 8]);
$row7->addCell(1500, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50, 'vMerge' => 'restart'])->addText('Attainments in '.($start-1).'-'.($end-1), ['bold' => true, 'size' => 8]);
$row7->addCell(1500, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50, 'vMerge' => 'restart'])->addText('Target Attainment of CO for '.$AcademicYear, ['bold' => true, 'size' => 8]);
$row7->addCell(1500, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50, 'vMerge' => 'restart'])->addText('Attainments in '.$AcademicYear, ['bold' => true, 'size' => 8]);
$row7->addCell(1500, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50, 'vMerge' => 'restart'])->addText('Action(s) taken in '.($start-1).'-'.($end-1).' to improve CO attainment', ['bold' => true, 'size' => 8]);
$row7->addCell(1500, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50, 'vMerge' => 'restart'])->addText('Proof Document(s) attached in Course File', ['bold' => true, 'size' => 8]);
$cell1 = $row7->addCell(8000,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50]);
$cell1->getStyle()->setGridSpan(5);
$cell1->addText('Strengthens POs/PSOs',['bold' => true, 'size' => 8]);

$row7 = $table5->addRow();
$row7->addCell( null , ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50, 'vMerge' => 'continue' ]);
$row7->addCell( null , ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50, 'vMerge' => 'continue' ]);
$row7->addCell( null , ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50, 'vMerge' => 'continue' ]);
$row7->addCell( null , ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50, 'vMerge' => 'continue' ]);
$row7->addCell( null , ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50, 'vMerge' => 'continue' ]);
$row7->addCell( null , ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50, 'vMerge' => 'continue' ]);
$row7->addCell( null , ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50, 'vMerge' => 'continue' ]);
$row7->addCell( null , ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50, 'vMerge' => 'continue' ]);
$row7->addCell(1500,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText('PO1',['bold' => true, 'size' => 8]);
$row7->addCell(1500,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText('PO2',['bold' => true, 'size' => 8]);
$row7->addCell(1500,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText('PO3',['bold' => true, 'size' => 8]);
$row7->addCell(1500,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText('PSO1',['bold' => true, 'size' => 8]);
$row7->addCell(1500,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText('PSO1',['bold' => true, 'size' => 8]);

$query200 = "SELECT CO FROM course_co_description WHERE Course_Code = '$CourseCode'";
$query201 = "SELECT Attainment FROM course_co_attainment WHERE Course_Code = '$CourseCode' AND Academic_Year = '".($start-3).'-'.($end-3)."' ORDER BY CO";
$query202 = "SELECT Attainment FROM course_co_attainment WHERE Course_Code = '$CourseCode' AND Academic_Year = '".($start-2).'-'.($end-2)."' ORDER BY CO";
$query203 = "SELECT Attainment FROM course_co_attainment WHERE Course_Code = '$CourseCode' AND Academic_Year = '".($start-1).'-'.($end-1)."' ORDER BY CO";
$query204 = "SELECT Attainment FROM course_co_attainment WHERE Course_Code = '$CourseCode' AND Academic_Year = '$AcademicYear' ORDER BY CO";
$result200 = mysqli_query($conn, $query200);
$result201 = mysqli_query($conn, $query201);
$result202 = mysqli_query($conn, $query202);
$result203 = mysqli_query($conn, $query203);
$result204 = mysqli_query($conn, $query204);
$flag1=0;
$flag2=0;
$flag3=0;
$flag4=0;
if(mysqli_num_rows($result201) == 0){
    $flag1=1;
}
if(mysqli_num_rows($result202) == 0){
    $flag2=1;
}
if(mysqli_num_rows($result203) == 0){
    $flag3=1;
}
if(mysqli_num_rows($result204) == 0){
    $flag4=1;
}

while($row = $result200->fetch_assoc()){
    $row7 = $table5->addRow();
    $row7->addCell(1500,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($row["CO"],['bold' => true, 'size' => 8]);
    $previou3 = -1;
    $previou2 = -1;
    $previou1 = -1;
    if($flag1 == 1){
        $row7->addCell(1500,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText(" ",['bold' => false, 'size' => 8]);
    }
    else{
        $previou3 = $result201->fetch_assoc()["Attainment"];
        $row7->addCell(1500,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($previou3,['bold' => false, 'size' => 8]);
    }
    if($flag2 == 1){
        $row7->addCell(1500,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText(" ",['bold' => false, 'size' => 8]);
    }
    else{
        $previou2 = $result202->fetch_assoc()["Attainment"];
        $row7->addCell(1500,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($previou2,['bold' => false, 'size' => 8]);
    }
    if($flag3 == 1){
        $row7->addCell(1500,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText(" ",['bold' => false, 'size' => 8]);
    }
    else{
        $previou1 = $result203->fetch_assoc()["Attainment"];
        $row7->addCell(1500,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($previou1,['bold' => false, 'size' => 8]);
    }
    if($previou3 == -1 || $previou2 == -1 || $previou1 == -1){
        $row7->addCell(1500,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText(1.8,['bold' => false, 'size' => 8]);
    }
    else{
        $target = round(($previou3+$previou2+$previou1)/3,1);
        $row7->addCell(1500,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($target,['bold' => false, 'size' => 8]);
    }
    if($flag4 == 1){
        $row7->addCell(1500,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText(" ",['bold' => false, 'size' => 8]);
    }
    else{
        $row7->addCell(1500,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($result204->fetch_assoc()["Attainment"],['bold' => false, 'size' => 8]);
    }
    $row7->addCell(1500,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText(" ",['bold' => false, 'size' => 8]);
    $row7->addCell(1500,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText(" ",['bold' => false, 'size' => 8]);
    $row7->addCell(1500,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText(" ",['bold' => false, 'size' => 8]);
    $row7->addCell(1500,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText(" ",['bold' => false, 'size' => 8]);
    $row7->addCell(1500,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText(" ",['bold' => false, 'size' => 8]);
    $row7->addCell(1500,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText(" ",['bold' => false, 'size' => 8]);
    $row7->addCell(1500,['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText(" ",['bold' => false, 'size' => 8]);
}

$section1->addText("\n");

$section1->addText('NOTE:',['bold' => true, 'size' => 12]);
$numberingStyle = array(
    'listType' => \PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER_NESTED,
    'numberingColor' => '999999', // Gray color
    'nestingLevel' => 0, // Outer level
);
$section1->addListItem("If COs were not revised this semester, Target Attainment of a CO for current AY = Average of Attainments in previous 3 AY's", 0, null, $numberingStyle);
$section1->addListItem("If the CO attainments are not available (due to new course/ revision of COs) for previous three consecutive years, then the target is 1.8 for this year.", 0, null, $numberingStyle);
// $numberStyleList = array('listType' => \PHPWord_Style_ListItem::TYPE_NUMBER);
// $section->addListItem("If CO's were not revised this semester, Target Attainment of a CO for current AY = Average of Attainments in previous 3 AY's", 0, null, $numberStyleList);
// $section->addListItem('If the CO attainments are not available(due to new course/ revision of COs) for previous three consecutive years, then the target is 1.8 for this year.', 0, null, $numberStyleList);

$section1->addText("\n");
$section1->addText('9. Actions Taken for Improvement in PO-PSO Attainments:', array('bold' => true, 'size' => 12));

$table5 = $section1->addTable();

$row7 = $table5->addRow();
$row7->addCell(1500, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText('PO-PSOs', ['bold' => true]);
$row7->addCell(1500, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText('Target Attainments', ['bold' => true]);
$row7->addCell(1500, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText('Attainments in '.($start-1).'-'.($end-1), ['bold' => true]);
$row7->addCell(8000, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText('Action(s) taken in '.$AcademicYear.' to improve the attainment', ['bold' => true]);
$row7->addCell(4500, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText('Proof Document(s) attached in Course File', ['bold' => true]);

$query203 = "SELECT * FROM course_po_attainment WHERE Course_Code = '$CourseCode' AND Academic_Year = '".($start-1).'-'.($end-1)."'";
$result203 = mysqli_query($conn, $query203);
$flag=0;
if(mysqli_num_rows($result203) == 0){
    $flag=1;
}
$result203 = $result203->fetch_assoc();
for ($i = 0; $i < count($PO); $i++) {
    $row = $table5->addRow();
    // Add CO cell
    $row->addCell(1500, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($PO[$i]);
    // Add Description cell
    $row->addCell(1500, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText('1.8');
    // Add Level cell
    if($flag==1){
        $row->addCell(1500, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText("No data");
    }
    else{
        $row->addCell(1500, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($result203[$PO[$i]]);
    }
       
    $row->addCell(8000, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($i < count($Actions) ? $Actions[$i] : '');   
    $row->addCell(4500, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($i < count($Proof) ? $Proof[$i] : '');   
}

$section1->addText("\n");
$section1->addText('10.	Suggestions for Improvement:', array('bold' => true, 'size' => 12));

$table4 = $section1->addTable();

$row6 = $table4->addRow();
$row6->addCell(1000, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText('SN', ['bold' => true]);
$row6->addCell(8000, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText('Suggestion', ['bold' => true]);
$row6->addCell(2500, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText('Relevance to CO', ['bold' => true]);
$row6->addCell(5500, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText('Relevance to PO/PSO', ['bold' => true]);

for ($i = 0; $i < count($Suggestion); $i++) {
    $row = $table4->addRow();
    // Add CO cell
    $row->addCell(1000, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($i+1);
    // Add Description cell
    $row->addCell(8000, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($i < count($Suggestion) ? $Suggestion[$i] : '');
    // Add Level cell
    $row->addCell(2500, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($i < count($RelevancetoCO) ? $RelevancetoCO[$i] : '');   
    $row->addCell(5500, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($i < count($RelevancetoPOPSO) ? $RelevancetoPOPSO[$i] : '');   
}

$section1->addText("\n");
$section1->addText('11.	Action taken for weak students:', array('bold' => true, 'size' => 12));

$table5 = $section1->addTable();

$row7 = $table5->addRow();
$row7->addCell(9000, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText('Action taken for weak students  ', ['bold' => true]);
$row7->addCell(8000, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText('Proof Document(s) attached in Course File', ['bold' => true]);

$Weak_Learner_Action = $_POST["Weak_Learner_Action"];
$Weak_Learner_Action = explode("$$", $Weak_Learner_Action);

$Weak_Learner_Proof = $_POST["Weak_Learner_Proof"];
$Weak_Learner_Proof = explode("$$", $Weak_Learner_Proof);

$index = 0;
while ($index < count($Weak_Learner_Action)) {
    $row7 = $table5->addRow();
    $row7->addCell(9000, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($Weak_Learner_Action[$index], ['bold' => false]);
    $row7->addCell(8000, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($Weak_Learner_Proof[$index], ['bold' => false]);
    $index++;
}



$section1->addText("\n");
$section1->addText('12.	Action taken for bright students:', array('bold' => true, 'size' => 12));

$table5 = $section1->addTable();

$row7 = $table5->addRow();
$row7->addCell(9000, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText('Action taken for bright students', ['bold' => true]);
$row7->addCell(8000, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText('Proof Document(s) attached in Course File', ['bold' => true]);

$Bright_Students_Action = $_POST["Bright_Students_Action"];
$Bright_Students_Action = explode("$$", $Bright_Students_Action);

$Bright_Students_Proof = $_POST["Bright_Students_Proof"];
$Bright_Students_Proof = explode("$$", $Bright_Students_Proof);

$index = 0;
while ($index < count($Bright_Students_Action)) {
    $row7 = $table5->addRow();
    $row7->addCell(9000, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($Bright_Students_Action[$index], ['bold' => false]);
    $row7->addCell(8000, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($Bright_Students_Proof[$index], ['bold' => false]);
    $index++;
}

// $row7 = $table5->addRow();
// $row7->addCell(9000, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText("Students are associated to help weak learner.", ['bold' => false]);
// $row7->addCell(8000, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText('-', ['bold' => false]);


$query4 = "SELECT Course_Coordinator FROM COURSES WHERE Course_Code = '$CourseCode'";
$CourseCoordinator = mysqli_query($conn, $query4)->fetch_assoc()["Course_Coordinator"];

$query5 = "SELECT module_coordinator FROM COURSES WHERE Course_Code = '$CourseCode'";
$module_coordinator = mysqli_query($conn, $query5)->fetch_assoc()["module_coordinator"];

$section1->addText("\n");
$section1->addText("Signature:									Signature:", array('bold' => true, 'size' => 12));
$section1->addText("Module Coordinator:							         Course Coordinator: ", array('bold' => true, 'size' => 12));
$section1->addText(str_replace("&", "&amp;", $module_coordinator)."							".str_replace("&", "&amp;", $CourseCoordinator), array('bold' => true, 'size' => 12));

// $phpWord->save('closing_report.docx');

$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
$outputFile = 'closing_report.docx';
$objWriter->save($outputFile);

    echo "<section class='h-screen w-full'>

    <a href='..\main.php' class='text-xs underline font-semibold absolute ml-4 mt-[4rem] text-[#CCCDDE]' >
    <i class='bi bi-arrow-left mr-1 text-[#CCCDDE]'></i>BACK TO OPTIONS
</a>

        <div class='flex justify-center font-bold text-2xl pt-16 text-[#CCCDDE]'>
            CLICK BELOW TO DOWNLOAD
        </div>

        <div class='flex mt-12 justify-center gap-x-10 items-center'>                    
                  
            <a href='$outputFile' class='w-[15rem] h-[15rem] cursor-pointer border border-text-[#CCCDDE] rounded-md flex flex-col justify-center items-center hover:border-r-0 hover:border-b-0 hover:border-l-4 hover:border-t-4 hover:border-t-green-700 text-[#CCCDDE] hover:bg-green-500 hover:text-white hover:border-l-green-700 transition-all duration-300 hover:shadow-lg'>
                <div>
                <svg xmlns='http://www.w3.org/2000/svg' width='50' height='50' fill='currentColor' class='bi bi-file-earmark-word-fill' viewBox='0 0 16 16'>
                <path d='M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0M9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1M5.485 6.879l1.036 4.144.997-3.655a.5.5 0 0 1 .964 0l.997 3.655 1.036-4.144a.5.5 0 0 1 .97.242l-1.5 6a.5.5 0 0 1-.967.01L8 9.402l-1.018 3.73a.5.5 0 0 1-.967-.01l-1.5-6a.5.5 0 1 1 .97-.242z'/>
              </svg>
                </div>

                <div class='mt-5 font-semibold text-xl'>
                    Download
                </div>

                <div class='font-semibold text-xl'>
                    Word
                </div>
            </a>
        </div>
    </section>"

    ?> 

</body>
</html>