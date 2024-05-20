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

if (isset($_POST['submit'])) {
    session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "JIIT";

$conn = mysqli_connect($servername, $username, $password, $dbname);
$PO = array('PO1','PO2','PO3','PO4','PO5','PO6','PO7','PO8','PO9','PO10','PO11','PO12','PSO1','PSO2');

$NumberOfSuggestions = $_POST['NumberOfSuggestions'];
$CourseCode = $_POST['CourseCode'];
$Semester = $_POST['Semester'];
$Branch = $_POST['Branch'];
$NBACode = $_POST['NBACode'];

$_SESSION['CourseCode'] = $CourseCode;
$_SESSION['Semester'] = $Semester;
$_SESSION['Branch'] = $Branch;
$_SESSION['NBACode'] = $NBACode;

$AcademicYear = $_POST['AcademicYear'];
$parts = explode("-", $AcademicYear);
$start = (int)$parts[0];
$end = (int)$parts[1];

$_SESSION['AcademicYear'] = $AcademicYear;

$query203 = "SELECT * FROM course_po_attainment WHERE Course_Code = '$CourseCode' AND Academic_Year = '".($start-1).'-'.($end-1)."'";
$result203 = mysqli_query($conn, $query203);
$flag=0;
if(mysqli_num_rows($result203) == 0){
    $flag=1;
}


echo "<a href='..\main.php' class='text-xs underline font-semibold absolute ml-4 mt-[4rem] text-[#CCCDDE]'>
<i class='bi bi-arrow-left mr-1 text-[#CCCDDE]'></i>BACK TO OPTIONS
</a>
<div class='flex justify-center font-bold text-2xl pt-8 mt-12 text-[#CCCDDE]'
> TELL US SOME GENERAL DETAILS </div>
<div class='flex justify-center mt-2 text-md text-[#CCCDDE] opacity-60'>
This process is very short and simple, taking less than 5 minutes
to complete </div>
<div class='flex justify-center w-full mt-10 details-container'>
<form name = 'coursedetails' action = 'closing_submit.php' class='w-[45rem] flex flex-col' method = 'post' onsubmit = 'return(validate())'>
<div class='format p-10 bg-gray-100'>";

echo "
<table>
    <tr>
        <th>SN</th>
        <th>Suggestion</th>
        <th>Relevance to CO</th>
        <th>Relevance to PO/PSO</th>
    </tr>";
    for ($i = 1; $i <= $NumberOfSuggestions; $i++) {
        echo "<tr class = 'mt-2'>
            <td>$i</td>
            <td><input type='text' name='Suggestion[]'></td>
            <td><input type='text' name='RelevancetoCO[]'></td>
            <td><input type='text' name='RelevancetoPO/PSO[]'></td>
        </tr>  ";
    }  
echo "</table>";

echo "</div>";

echo "<div class='format mt-10 p-10 bg-gray-100'>

<table>
    <tr>
        <th>PO-PSOs</th>
        <th>Target Attainments</th>
        <th>Attainments in $AcademicYear (previous year)</th>
        <th>Action(s) taken in 2023-24 to improve the attainment</th>
        <th>Proof Document(s) attached in Course File</th>
    </tr>";
    for ($i = 0; $i < count($PO); $i++) {
        echo "<tr>
            <td>$PO[$i]</td>
            <td>1.8</td>";
            if($flag==1){
                echo "<td>No data</td>";
            }
            else{
                echo "<td>".$result203[$PO[$i]]."</td>";
            }
            // <td><input type='text' name='Attainments[]'></td>
        echo "<td><input type='text' name='Actions[]'></td>
            <td><input type='text' name='Proof[]'></td>
        </tr>";
    } 
    echo "</table></div>";
    

echo "<div class='format mt-10 p-10 bg-gray-100'>
<div class='font-bold'>5. Summary of Result Analysis:</div>
<div class='grid grid-cols-2 gap-12 mt-5'>
<div>
<label for='gradeap'>Grade A+:</label>
<input type='number' id='gradeap' name='gradeap' step='0.1' required>
</div>

<div>
<label for='gradea'>Grade A:</label>
<input type='number' id='gradea' name='gradea' step='0.1' required>
</div>
</div>

<div class='grid grid-cols-2 gap-12 mt-3'>
<div>
<label for='gradebp'>Grade B+:</label>
<input type='number' id='gradebp' name='gradebp' step='0.1' required>
</div>

<div>
<label for='gradeb'>Grade B:</label>
<input type='number' id='gradeb' name='gradeb' step='0.1' required>
</div>
</div>

<div class='grid grid-cols-2 gap-12 mt-3'>
<div>
<label for='gradecp'>Grade C+:</label>
<input type='number' id='gradecp' name='gradecp' step='0.1' required>
</div>

<div>
<label for='gradec'>Grade C:</label>
<input type='number' id='gradec' name='gradec' step='0.1' required>
</div>
</div>

<div class='grid grid-cols-2 gap-12 mt-3'>
<div>
<label for='graded'>Grade D:</label>
<input type='number' id='graded' name='graded' step='0.1' required>
</div>

<div>
<label for='gradef'>Grade F:</label>
<input type='number' id='gradef' name='gradef' step='0.1' required>
</div>
</div>

<div class = 'mt-5'>
<div class='font-bold'>6. Innovative Teaching and Learning Method used:</div>
<br>
<textarea placeholder='Use $$ to create new points' name='Innovative_Teaching' class='mt-2'></textarea>
</div>

<div class = 'mt-5'>
<div class='font-bold'>7. Innovative Evaluation Strategy used (If any):</div>
<br>
<textarea placeholder='Use $$ to create new points' name='Innovative_Evaluation' class='mt-2'></textarea>
</div>

</div>";

echo "<div class='format mt-10 p-10 bg-gray-100'> <div class='font-bold'> 11.	Action taken for weak students: </div>
    <div class='grid grid-cols-2 gap-7 mt-3'>
    <div>
        <div> Action taken for weak students </div>
        <div class = 'mt-2'><textarea placeholder='Use $$ to create new points' name='Weak_Learner_Action'></textarea></div>
        </div>
        <div>
        <div> Proof Document(s) attached in Course File </div>
        <div class = 'mt-2'><textarea placeholder='Use $$ to create new points' name='Weak_Learner_Proof'></textarea></div>
        </div>
        </div>";

echo "<div class='mt-5 font-bold'>12.	Action taken for bright students :</div>
<div class='grid grid-cols-2 gap-7 mt-3'>
    <div>
    <div>Action taken for bright students</div>
    <div class = 'mt-2'><textarea placeholder='Use $$ to create new points' name='Bright_Students_Action'></textarea></div>
        </div>
        <div>
        <div>Proof Document(s) attached in Course File</div>
        <div class = 'mt-2'><textarea placeholder='Use $$ to create new points' name='Bright_Students_Proof'></textarea></div>
        </div>
        </div>
<br></div>";

echo "<div class='flex mt-8 justify-center mb-4'>
      <button
        class='font-semibold bg-white border-[1px] border-neutral-800 rounded-xl h-12 flex justify-center items-center text-lg w-60 hover:border-white' type='submit' name='submit'
      >
        NEXT
      </button>
    </div>  

</form></div>";
echo "";

} else {
    echo '<script type="text/javascript">';
    echo 'alert("Something Went Wrong!");';
    echo 'setTimeout(function(){ window.location.href = "../import.course.details.php"; }, 500);';
    echo '</script>';
    exit();
}

?>
    
</body>
</html>


