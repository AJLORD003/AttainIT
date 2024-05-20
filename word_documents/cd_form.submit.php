<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="index.css">

    <style>
        body {
      background-color: #05051e;
    }
         .format {
  box-shadow:inset 5px 8px 8px rgba(0,0,0,.1),inset -2px -2px 10px hsla(0,0%,100%,.1);
  border-radius: 20px;
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

    $AcademicYear = $_POST['AcademicYear'];
    $Semester = $_POST['Semester'];
    $ASemester = $_POST['AcademicYear'];
    $Month = $_POST['Month'];
    if ($Semester % 2 == 0) {
        $AcademicYear = $AcademicYear . " (Even Semester)";
    } else {
        $AcademicYear = $AcademicYear . " (Odd Semester)";
    }

    $CourseCode = $_POST['CourseCode'];
    $CourseCoordinator = $_POST['CourseCoordinator'];
    $CourseCoordinator_array = explode("$$", $CourseCoordinator);

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    $query3 = "SELECT Course_Name FROM COURSES WHERE Course_Code = '$CourseCode'";
    $CourseName = mysqli_query($conn, $query3);

    if (mysqli_num_rows($CourseName) == 0) {
        echo '<script type="text/javascript">';
        echo 'alert("No Such Course Exist!");';
        echo 'setTimeout(function(){ window.location.href = "import.course.details.php"; }, 500);';
        echo '</script>';
        exit();
    }

    $CourseName = $CourseName->fetch_assoc()["Course_Name"];

    $emp_id = $_SESSION["emp_id"];


    if ($conn) {
        $query1 = "SELECT Credits FROM COURSES WHERE Course_Code = '$CourseCode'";
        $CourseCredits = mysqli_query($conn, $query1);
        $CourseCredits = $CourseCredits->fetch_assoc()["Credits"];
        $query2 = "SELECT Course_Teacher FROM COURSES WHERE Course_Code = '$CourseCode'";
        $Teachers = mysqli_query($conn, $query2);
        $Teachers = $Teachers->fetch_assoc()["Course_Teacher"];
        $Teachers_array = explode("$$", $Teachers);
        $query3 = "SELECT contact_hours FROM COURSES WHERE Course_Code = '$CourseCode'";
        $Contact_Hours = mysqli_query($conn, $query3);
        $Contact_Hours = $Contact_Hours->fetch_assoc()["contact_hours"];
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

        $query5 = "SELECT module_no, Title, content, lectures FROM COURSE_MODULE WHERE Course_Code = '$CourseCode'";
        $result2 = mysqli_query($conn, $query5);

        $module_no = array();
        $Title = array();
        $content = array();
        $lectures = array();

        if ($result2) {
            while ($row = mysqli_fetch_assoc($result2)) {
                $module_no[] = $row['module_no'];
                $Title[] = $row['Title'];
                $content[] = $row['content'];
                $lectures[] = $row['lectures'];
            }
        } else {
            echo "Error: " . mysqli_error($conn);
        }

        $sum_of_lectures = 0;

        foreach ($lectures as $value) {
            $sum_of_lectures += $value;
        }

        $query6 = "SELECT book_no, content, type FROM BOOKS WHERE Course_Code = '$CourseCode' ORDER BY type desc";
        $result3 = mysqli_query($conn, $query6);

        $book_no = array();
        $content2 = array();
        $type = array();

        if ($result3) {
            while ($row = mysqli_fetch_assoc($result3)) {
                $book_no[] = $row['book_no'];
                $type[] = $row['type'];
                $content2[] = $row['content'];
            }

            $textbooks = 0;
            $referencebooks = 0;

            for ($i = 0; $i < count($type); $i++) {
                if ($type[$i] == 'Text Book') {
                    $textbooks += 1;
                } else {
                    $referencebooks += 1;
                }
            }
        } else {
            echo "Error: " . mysqli_error($conn);
        }
        // header("Location: import.questions.php");
        // exit();
    } else {
        echo '<script type="text/javascript">';
        echo 'alert("Database Connection Error!");';
        echo 'setTimeout(function(){ window.location.href = "import.course.details.php"; }, 500);'; // Wait for 2 seconds
        echo '</script>';
        exit();
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

$section1 = $phpWord->addSection();

$section1->addText("Department of Computer Science and Engineering &amp; Information Technology", array('bold' => true, 'size' => 14), array('align' => 'center', 'spaceBefore' => 0, 'spaceAfter' => 0));
if ($Semester % 2 == 0) {
    $section1->addText("AY: " . $ASemester . ", (Even Semester)", array('bold' => true, 'size' => 14), array('align' => 'center', 'spaceBefore' => 0, 'spaceAfter' => 0));
} else {
    $section1->addText("AY: " . $ASemester . ", (Odd Semester)", array('bold' => true, 'size' => 14), array('align' => 'center', 'spaceBefore' => 0, 'spaceAfter' => 0));
}
// $section1->addText("AY: ".$ASemester.", ".$Semester, array('bold' => true));
$section1->addText("\n");
$section1->addText('Detailed Syllabus', array('bold' => true, 'underline' => 'single', 'size' => 11), array('align' => 'center', 'spaceBefore' => 0, 'spaceAfter' => 0));
$section1->addText('Lecture-wise Breakup', array('bold' => true, 'size' => 11), array('align' => 'center', 'spaceBefore' => 0, 'spaceAfter' => 0));

$table1 = $section1->addTable();

$row1 = $table1->addRow();
$row1->addCell(2500, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText('Course Code', ['bold' => true]);
$row1->addCell(2500, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($CourseCode);
$cell1 = $row1->addCell(2500, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50]);
$textRun1 = $cell1->addTextRun();
if ($Semester % 2 == 0) {
    $textRun1->addText("Semester Even", ['bold' => true]);
} else {
    $textRun1->addText("Semester Odd", ['bold' => true]);
}
$textRun1->addTextBreak();
// $textRun1->addText("Semester Odd", ['bold' => true]);
$textRun1->addText("(specify Odd/Even)", ['bold' => true]);

$Semester_R = ['O', 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X'];

$cell1 = $row1->addCell(3000, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50]);
$textRun1 = $cell1->addTextRun();
$textRun1->addText("Semester ", ['bold' => true]);
$textRun1->addText($Semester_R[$Semester], ['bold' => false]);
$textRun1->addText(" Session ", ['bold' => true]);
$textRun1->addText($ASemester, ['bold' => false]);
$textRun1->addTextBreak();
$textRun1->addText("Month from ", ['bold' => true]);
$textRun1->addText($Month, ['bold' => false]);
// $row1->addCell(2500, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText("Semester ".$Semester." Session ".$ASemester."\nMonth From ".$Month);

$row2 = $table1->addRow();
$row2->addCell(2000, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText('Course Name', ['bold' => true]);
$cell1 = $row2->addCell(5500, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50]);
$cell1->getStyle()->setGridSpan(3);
$cell1->addText($CourseName);

$row3 = $table1->addRow();
$row3->addCell(1875, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText('Credits', ['bold' => true]);
$row3->addCell(1875, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($CourseCredits);
$row3->addCell(1875, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText('Contact Hours', ['bold' => true]);
$row3->addCell(1875, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($Contact_Hours);

$section1->addText("\n");

$table2 = $section1->addTable();

$row4 = $table2->addRow();
$row4->addCell(2250, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50, 'vMerge' => 'restart'])->addText('Faculty (Names)', ['bold' => true]);
$row4->addCell(2250, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText('Coordinator(s)', ['bold' => true]);
$cell1 = $row4->addCell(5500, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50]);
$textRun1 = $cell1->addTextRun();
$index = 0;
while ($index < count($CourseCoordinator_array)) {
    $textRun1->addText($CourseCoordinator_array[$index]);
    $index++;
    if ($index < count($CourseCoordinator_array)) {
        $textRun1->addTextBreak();
    }
}


$row4 = $table2->addRow();
$row4->addCell(null, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50, 'vMerge' => 'continue']);
$row4->addCell(2250, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText('Teacher(s) (Alphabetically)', ['bold' => true]);
$cell1 = $row4->addCell(5500, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50]);
$textRun1 = $cell1->addTextRun();
$index = 0;
while ($index < count($Teachers_array)) {
    $textRun1->addText($Teachers_array[$index]);
    $index++;
    if ($index < count($Teachers_array)) {
        $textRun1->addTextBreak();
    }
}

$section1->addText("\n");

$table3 = $section1->addTable();

$row5 = $table3->addRow();
$cell1 = $row5->addCell(8000, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50]);
$cell1->getStyle()->setGridSpan(2);
$cell1->addText('COURSE OUTCOMES', ['bold' => true]);
$row5->addCell(3000, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText('COGNITIVE LEVELS', ['bold' => true]);

for ($i = 0; $i < count($COArray); $i++) {
    $row = $table3->addRow();
    // Add CO cell
    $row->addCell(1500, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($i < count($COArray) ? $COArray[$i] : '');
    // Add Description cell
    $row->addCell(6500, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($i < count($DescriptionArray) ? $DescriptionArray[$i] : '');
    // Add Level cell
    $row->addCell(3000, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($i < count($LevelArray) ? $LevelArray[$i] : '');
}

$section1->addText("\n");

$table4 = $section1->addTable();

$row6 = $table4->addRow();
$row6->addCell(1500, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText('Module No.', ['bold' => true]);
$row6->addCell(2000, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText('Title of the Module', ['bold' => true]);
$row6->addCell(6000, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText('Topics in the Module', ['bold' => true]);
$row6->addCell(1500, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText('No. of Lectures for the module', ['bold' => true]);

for ($i = 0; $i < count($module_no); $i++) {
    $row = $table4->addRow();
    // Add CO cell
    $row->addCell(1500, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($module_no[$i]);
    // Add Description cell
    $row->addCell(2000, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText(str_replace("&", "&amp;", $Title[$i]));
    $row->addCell(6000, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText(str_replace("&", "&amp;", $content[$i]));
    // Add Level cell
    $row->addCell(1500, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText(str_replace("&", "&amp;", $lectures[$i]));
}
$row = $table4->addRow();
$cell1 = $row->addCell(2000, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50]);
$cell1->getStyle()->setGridSpan(3);
$cell1->addText("Total number of Lectures", ['bold' => true]);
$row->addCell(2000, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($sum_of_lectures, ['bold' => true]);
$row = $table4->addRow();
$cell1 = $row->addCell(11000, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50]);
$cell1->getStyle()->setGridSpan(4);
$textRun1 = $cell1->addTextRun();
$textRun1->addText('Evaluation Criteria', ['bold' => true]);
$textRun1->addTextBreak();
$textRun1->addText('Components                                 Maximum Marks ', ['bold' => true]);
$textRun1->addTextBreak();
if ($_POST["coursetype"] == "Lecture") {
    $textRun1->addText('T1                                                    20 ', ['bold' => false]);
    $textRun1->addTextBreak();
    $textRun1->addText('T2                                                    20 ', ['bold' => false]);
    $textRun1->addTextBreak();
    $textRun1->addText('End Semester Examination             35 ', ['bold' => false]);
    $textRun1->addTextBreak();
    $textRun1->addText('TA                                                   25 (Attendance, Quiz/Assignment/Mini Project/Case Study)', ['bold' => false]);
    $textRun1->addTextBreak();
    $textRun1->addText('Total                                               100', ['bold' => true]);
} else {
    $textRun1->addText('Lab Test -1                                       20', ['bold' => false]);
    $textRun1->addTextBreak();
    $textRun1->addText('Lab Test -2                                       20 ', ['bold' => false]);
    $textRun1->addTextBreak();
    $textRun1->addText('Eval 1                                               15', ['bold' => false]);
    $textRun1->addTextBreak();
    $textRun1->addText('Eval2                                                15', ['bold' => false]);
    $textRun1->addTextBreak();
    $textRun1->addText('Project                                              15', ['bold' => false]);
    $textRun1->addTextBreak();
    $textRun1->addText('Attendance                                       15 ', ['bold' => false]);
    $textRun1->addTextBreak();
    $textRun1->addText('Total                                               100', ['bold' => true]);
}


$section1->addText("\n");

$table5 = $section1->addTable();

$row7 = $table5->addRow();
$cell1 = $row7->addCell(11000, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50]);
$cell1->getStyle()->setGridSpan(2);
$textRun1 = $cell1->addTextRun();
$textRun1->addText('Recommended Reading material:', ['bold' => true]);
$textRun1->addText(' Author(s), Title, Edition, Publisher, Year of Publication etc. ( Text books, Reference Books, Journals, Reports, Websites etc. in the IEEE format', ['bold' => false]);

$row8 = $table5->addRow();
$cell1 = $row8->addCell(11000, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50]);
$cell1->getStyle()->setGridSpan(2);
$cell1->addText('Text Books:', ['bold' => true]);

for ($i = 0; $i < $textbooks; $i++) {
    $row = $table5->addRow();
    // Add CO cell
    $row->addCell(500, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($book_no[$i]);
    // Add Description cell
    $row->addCell(10500, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($content2[$i]);
}

$row9 = $table5->addRow();
$cell1 = $row9->addCell(11000, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50]);
$cell1->getStyle()->setGridSpan(2);
$cell1->addText('Reference Books:', ['bold' => true]);

for ($i = 0; $i < $referencebooks; $i++) {
    $row = $table5->addRow();
    // Add CO cell
    $row->addCell(500, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($book_no[$i + $textbooks]);
    // Add Description cell
    $row->addCell(10500, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($content2[$i]);
}

// $phpWord->save('course_description.docx');


$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
$outputFile = 'course_description.docx';
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