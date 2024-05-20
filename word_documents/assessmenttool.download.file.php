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
            box-shadow: inset 5px 8px 8px rgba(0, 0, 0, .1), inset -2px -2px 10px hsla(0, 0%, 100%, .1);
            border-radius: 20px;
        }
    </style>
</head>
<body>

<?php
    session_start();
    $Semester = $_SESSION['Semester'];
    $Branch = $_SESSION['Branch'];
    $CourseCode = $_SESSION['CourseCode'];
    $AcademicYear = $_SESSION['AcademicYear'];
    $CourseName = $_SESSION["CourseName"];
    $CourseCoordinator = $_SESSION["CourseCoordinator"];
    $module_coordinator = $_SESSION["module_coordinator"];
    // echo $module_coordinator;
    $Course_Key = $_SESSION["Course_Key"];
    $Semester_R = ['O', 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X'];
    if ($Semester % 2 == 0) {
        $AcademicYear = $AcademicYear . ", (Even Semester)";
    } else {
        $AcademicYear = $AcademicYear . ", (Odd Semester)";
    }

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "JIIT";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    $query1 = "SELECT CO, Description, direct, indirect FROM course_co_description WHERE Course_Code = '$CourseCode'";
    // echo $query1;
    $result1 =  mysqli_query($conn, $query1);

    require_once 'vendor/autoload.php';

    $phpWord = new \PhpOffice\PhpWord\PhpWord();
    $phpWord->setDefaultFontName('Times New Roman');

    $section = $phpWord->addSection(array('orientation' => 'landscape'));
    $table = $section->addTable();

    $row1 = $table->addRow();

    $cell1 = $row1->addCell(17000, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50]);
    $cell1->getStyle()->setGridSpan(4);

    $textRun1 = $cell1->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
    $textRun1->addText("Department of Computer Science and Engineering &amp; Information Technology", array('bold' => true, 'size' => 16));
    $textRun1->addTextBreak();
    $textRun1->addText("AY: ".$AcademicYear, array('bold' => true, 'size' => 14));
    $textRun1->addTextBreak();
    $textRun1->addText("Assessment Tools for CO Attainment", array('bold' => true, 'size' => 12));

    $row2 = $table->addRow();

    $cell2 = $row2->addCell(17000, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50]);
    $cell2->getStyle()->setGridSpan(4);

    $textRun2 = $cell2->addTextRun();
    $textRun2->addText(" Programme Name: B.Tech ".$Branch, array('bold' => true, 'size' => 12));
    $textRun2->addTextBreak();
    $textRun2->addText(" Branch, Semester: ".$Branch.", ".$Semester_R[$Semester], array('bold' => true, 'size' => 12));
    $textRun2->addTextBreak();
    $textRun2->addText(" Course Name, Code: ".$CourseName." &amp; ".$CourseCode, array('bold' => true, 'size' => 12));

    $row3 = $table->addRow();

    $row3->addCell(1500, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText(' CO Code', array('bold' => true, 'size' => 11));
    $row3->addCell(7000, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText(' Description',array('bold' => true, 'size' => 11));
    $row3->addCell(4250, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText(' Direct Assessment Tools (80%)',array('bold' => true, 'size' => 11));
    $row3->addCell(4250, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText(' In-Direct Assessment Tools (20%)',array('bold' => true, 'size' => 11));

    while($row4 = $result1->fetch_assoc()){
        $row5 = $table->addRow();

        $row5->addCell(1500, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($row4["CO"], array('bold' => true, 'size' => 11));
        $row5->addCell(7000, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($row4["Description"],array('bold' => false, 'size' => 11));
        $row5->addCell(4250, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($row4["direct"],array('bold' => false, 'size' => 11));
        $row5->addCell(4250, ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50])->addText($row4["indirect"],array('bold' => false, 'size' => 11));
    }
    $section->addText("\n");
    $section->addText("\n");
    $section->addText("Module Coordinator:                                                                                                                                                                                     Course Coordinator:", array('bold' => true, 'size' => 11));
    $section->addText($module_coordinator."                                                                                                                                                      ".str_replace("&", "&amp;", $CourseCoordinator), array('bold' => false, 'size' => 11));

    // Save the document
    $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
    $outputFile = 'assessment_tool.docx';
    $objWriter->save($outputFile);
        
    


?>

<?php
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