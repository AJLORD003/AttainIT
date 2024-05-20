<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
require_once 'vendor/autoload.php';
$phpWord = new \PhpOffice\PhpWord\PhpWord();
$phpWord->setDefaultFontName('Times New Roman');
$phpWord->addParagraphStyle('paragraph_default', array('spaceBefore' => 0, 'spaceAfter' => 0));

if (isset($_POST['submit'])) {
    session_start();
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "JIIT";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    $TopicsToBeIntroduced = $_POST['TopicsToBeIntroduced'];
    $StrengthensCO = $_POST['StrengthensCO'];
    $StrengthensPOPSO = $_POST['StrengthensPOPSO'];
    $MethodofIdentification = $_POST['MethodofIdentification'];

    $Actiontobetaken = $_POST['Actiontobetaken'];
    $StrengthensPOs2 = $_POST['StrengthensPOs2'];
    // $Attainments = $_POST['Attainments'];

    $CourseCode = $_SESSION['CourseCode'];
    $AcademicYear = $_SESSION['AcademicYear'];

    $parts = explode("-", $AcademicYear);
    $start = (int)$parts[0]-1;
    $end = (int)$parts[1]-1;

    $Semester = $_SESSION['Semester'];
    $Branch = $_SESSION['Branch'];
    $NBACode = $_SESSION['NBACode'];
    // echo $AcademicYear;
    // echo $Semester;

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

    $DetailsofModification = $_POST['DetailsofModification'];
    $Justification = $_POST['Justification'];
    $StrengthensPOs = $_POST['StrengthensPOs'];


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

$section1->addText('Course Opening Report', array('bold' => true, 'underline' => 'single', 'size' => 14), array('align' => 'center', 'spaceBefore' => 0, 'spaceAfter' => 0));

$section1->addText('Programme Name: B.Tech ('.$Branch.')', array('bold' => true, 'size' => 12));
$section1->addText('Semester: '.$Semester, array('bold' => true, 'size' => 12));
$section1->addText('Course Name &amp; Code: '.$CourseName." (".$CourseCode.")", array('bold' => true, 'size' => 12));
$section1->addText('NBA Code: '.$NBACode, array('bold' => true, 'size' => 12));
$section1->addText('Name of Course Coordinator(s): '.$Course_Coordinator, array('bold' => true, 'size' => 12));

$section1->addText("\n");
$section1->addText('1. Course Outcomes:', array('bold' => true, 'underline' => 'single', 'size' => 12));
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

$section1->addText('2. CO-PO and CO-PSO Mapping:', array('bold' => true, 'underline' => 'single', 'size' => 12));

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

$section1->addText('3. Identified gaps in Syllabus/ Course Description (If Any):', array('bold' => true, 'underline' => 'single', 'size' => 12));

$table4 = $section1->addTable();

$row6 = $table4->addRow();
$row6->addCell(3000, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText('Topic to be introduced',  array('bold' => true, 'size' => 12));
$row6->addCell(2000, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText('Strengthens CO', array('bold' => true, 'size' => 12));
$row6->addCell(3000, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText('Strengthens PO,PSO', array('bold' => true, 'size' => 12));
$row6->addCell(7000, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText('Method of Identification', array('bold' => true, 'size' => 12));

for ($i = 0; $i < count($TopicsToBeIntroduced); $i++) {
    $row = $table4->addRow();
    // Add CO cell
    $row->addCell(3000, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($i < count($TopicsToBeIntroduced) ? $TopicsToBeIntroduced[$i] : '', array('size' => 12));
    // Add Description cell
    $row->addCell(2000, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($i < count($StrengthensCO) ? $StrengthensCO[$i] : '', array('size' => 12));
    // Add Level cell
    $row->addCell(3000, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($i < count($StrengthensPOPSO) ? $StrengthensPOPSO[$i] : '', array('size' => 12));
    $row->addCell(7000, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($i < count($MethodofIdentification) ? $MethodofIdentification[$i] : '', array('size' => 12));
}

$section1->addText("\n");

$section1->addText('4. Modifications in Syllabus/ Course Description (If Any):', array('bold' => true, 'underline' => 'single', 'size' => 12));

$table5 = $section1->addTable();

$row8 = $table5->addRow();
$row8->addCell(5000, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText('Details of Modification (Addition/ Removal)', array('bold' => true, 'size' => 12));
$row8->addCell(9000, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText('Justification', array('bold' => true, 'size' => 12));
$row8->addCell(3000, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText('Strengthens POs/PSOs ', array('bold' => true, 'size' => 12));

for ($i = 0; $i < count($DetailsofModification); $i++) {
    $row = $table5->addRow();
    // Add CO cell
    $row->addCell(5000, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($i < count($DetailsofModification) ? $DetailsofModification[$i] : '', array('size' => 12));
    // Add Description cell
    $row->addCell(9000, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($i < count($Justification) ? $Justification[$i] : '', array('size' => 12));
    // Add Level cell
    $row->addCell(3000, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($i < count($StrengthensPOs) ? $StrengthensPOs[$i] : '', array('size' => 12));   
}

$section1->addText("\n");

$section1->addText('5. Actions for Improving CO Attainments:', array('bold' => true, 'underline' => 'single', 'size' => 12));

$table6 = $section1->addTable();

$row10 = $table6->addRow();
$row10->addCell(2000, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText('COs', array('bold' => true, 'size' => 12));
$row10->addCell(2000, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText('Attainments in '.$start.'-'.$end, array('bold' => true, 'size' => 12));
$row10->addCell(8000, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText('Action to be taken in '.$start.'-'.$end.' to improve CO attainment', array('bold' => true, 'size' => 12));
$row10->addCell(5000, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText('Strengthens POs/PSOs', array('bold' => true, 'size' => 12));

$query5 = "SELECT Attainment FROM course_co_attainment WHERE Course_Code = '$CourseCode' AND Academic_Year = '".$start."-".$end."' ORDER BY CO";
// echo $query5;
$result2 = mysqli_query($conn, $query5);
$flag = 0;
if(mysqli_num_rows($result2) == 0){
    $flag = 1;
}
// echo $flag;

for ($i = 0; $i < count($COArray); $i++) {
    $row = $table6->addRow();
    // Add CO cell
    $row->addCell(2000, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($COArray[$i], array('bold' => true, 'size' => 12));
    // // Add Description cell
    if($flag == 1){
        $row->addCell(2000, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText("No Data", array('bold' => true, 'size' => 12));
        // echo "<td>No Data</td>";
    }
    else{
        $row->addCell(2000, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($result2->fetch_assoc()["Attainment"], array('bold' => true, 'size' => 12));
    }
    // // Add Level cell
    $row->addCell(8000, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($Actiontobetaken[$i], array('bold' => true, 'size' => 12));   
    $row->addCell(5000, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($StrengthensPOs2[$i], array('bold' => true, 'size' => 12));   
}

// $row9 = $table5->addRow();
// $row9->addCell(6000, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText('Details of Modification (Addition/ Removal)', ['bold' => true]);
// $row9->addCell(6000, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText('Justification', ['bold' => true]);
// $row9->addCell(6000, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText('Strengthens POs/PSOs ', ['bold' => true]);
if($flag == 1){
    $section1->addText("\n");

    $section1->addText('** Since the COs are revised in AY '.$AcademicYear.', the actions to be taken mentioned here are for achieving better attainments in each CO. These actions are derived from the suggestions provided in previous years closing report after discussion with faculty members teaching the course.', array('bold' => true, 'size' => 12));
}
$section1->addText("\n");

$section1->addText('6. Innovative Teaching and Learning Method to be used:', array('bold' => true, 'underline' => 'single', 'size' => 12));

$Innovative_Teaching = $_POST["Innovative_Teaching"];
$Innovative_Teaching = explode("$$", $Innovative_Teaching);

$index = 0;
while ($index < count($Innovative_Teaching)) {
    $section1->addListItem($Innovative_Teaching[$index], 0, array('size' => 12));
    $index++;
}

// $section1->addListItem('Case studies of Modern Operating systems discussed', 0, array('size' => 12));
// $section1->addListItem('Topic-based hands-on programming sessions introduced during tutorial hours', 0, array('size' => 12));
// $section1->addListItem('Discussion on recent trends and industry innovations during lecture hours along with the regular syllabus', 0, array('size' => 12));
// $section1->addListItem('References using animations and videos to be used for a better understanding of basic topics.', 0, array('size' => 12));
// $section1->addListItem('More Questions/numerical with different scenarios will be discussed in lecture and tutorial classes for a deeper understanding of process management concepts and threads in OS', 0, array('size' => 12));
// $section1->addText('• Case studies of Modern Operating systems discussed');
// $section1->addText('• Topic-based hands-on programming sessions introduced during tutorial hours');
// $section1->addText('• Discussion on recent trends and industry innovations during lecture hours along with the regular syllabus');
// $section1->addText('• References using animations and videos to be used for a better understanding of basic topics.');
// $section1->addText('• More Questions/numerical with different scenarios will be discussed in lecture and tutorial classes for a deeper understanding of process management concepts and threads in OS');

$section1->addText("\n");

$section1->addText('7. Strategies for:', array('bold' => true, 'underline' => 'single', 'size' => 12));

$section1->addListItem('Weak Learners: ', 0, array('bold' => true, 'size' => 12));

$Weak_Learners = $_POST["Weak_Learners"];
$Weak_Learners = explode("$$", $Weak_Learners);

$index = 0;
while ($index < count($Weak_Learners)) {
    $section1->addListItem($Weak_Learners[$index], 1, array('size' => 12));
    $index++;
}

// $section1->addListItem('Identification of Weak learners on the basis of marks scored in T1. Remedial Classes will be organized to improve the conceptual level of the weak learner.', 1, array('size' => 12));
// $section1->addListItem('After the identification of weak learners, more focus will be given in the lecture to help them clear their queries and understand the concepts of the subject easily.', 1, array('size' => 12));

$section1->addListItem('Bright Students: ', 0, array('bold' => true, 'size' => 12));

$Bright_Students = $_POST["Bright_Students"];
$Bright_Students = explode("$$", $Bright_Students);

$index = 0;
while ($index < count($Bright_Students)) {
    $section1->addListItem($Bright_Students[$index], 1, array('size' => 12));
    $index++;
}

// $section1->addListItem('Open-source code of kernel and shell to be used for teaching students to design the basic operating system', 1, array('bold' => false, 'size' => 12));


// $section1->addText('• Weak Learners: ', ['bold' => true]);
// $section1->addText('• Identification of Weak learners on the basis of marks scored in T1. Remedial Classes will be organized to improve the conceptual level of the weak learner. ');
// $section1->addText('• After the identification of weak learners, more focus will be given in the lecture to help them clear their queries and understand the concepts of the subject easily. ');

// $section1->addText('• Bright Students: Open-source code of kernel and shell to be used for teaching students to design the basic operating system');

$section1->addText("\n");

$section1->addText('8. Innovative Evaluation Strategy to be used (If any):', array('bold' => true, 'underline' => 'single', 'size' => 12));

$Innovative_Evaluation = $_POST["Innovative_Evaluation"];
$Innovative_Evaluation = explode("$$", $Innovative_Evaluation);

$index = 0;
while ($index < count($Innovative_Evaluation)) {
    $section1->addListItem($Innovative_Evaluation[$index], 0, array('size' => 12));
    $index++;
}

// $section1->addListItem('One-to-one viva on the two topics per student', 0, array('size' => 12));
// $section1->addListItem('Scenario-based questions will be introduced to understand the real-world problems more deeply.', 0, array('size' => 12));
// $section1->addListItem('Best possible online teaching methods and pedagogy to be used to deliver lectures and regular monitoring of student performance.', 0, array('size' => 12));

// $section1->addText('• One-to-one viva on the two topics per student');
// $section1->addText('• Scenario-based questions will be introduced to understand the real-world problems more deeply. ');
// $section1->addText('• Best possible online teaching methods and pedagogy to be used to deliver lectures and regular monitoring of student performance.');
$query4 = "SELECT Course_Coordinator FROM COURSES WHERE Course_Code = '$CourseCode'";
$CourseCoordinator = mysqli_query($conn, $query4)->fetch_assoc()["Course_Coordinator"];

$query5 = "SELECT module_coordinator FROM COURSES WHERE Course_Code = '$CourseCode'";
$module_coordinator = mysqli_query($conn, $query5)->fetch_assoc()["module_coordinator"];

$section1->addText("\n");
$section1->addText("Signature:									Signature:", array('bold' => true, 'size' => 12));
$section1->addText("Module Coordinator:							         Course Coordinator: ", array('bold' => true, 'size' => 12));
$section1->addText(str_replace("&", "&amp;", $module_coordinator)."							".str_replace("&", "&amp;", $CourseCoordinator), array('bold' => true, 'size' => 12));



// $phpWord->save('opening_report.docx');

$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
$outputFile = 'opening_report.docx';
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
