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

$NumberOfTopicstobeintroduced = $_POST['NumberOfTopicstobeintroduced'];
$NumberOfDetailsofModification = $_POST['NumberOfDetailsofModification'];
$CourseCode = $_POST['CourseCode'];
$NBACode = $_POST['NBACode'];
$_SESSION['NBACode'] = $NBACode;

$_SESSION['CourseCode'] = $CourseCode;
$COArray = array();
$query4 = "SELECT CO FROM COURSE_CO_DESCRIPTION WHERE Course_Code = '$CourseCode' ORDER BY CO";
$result = mysqli_query($conn, $query4);
$AcademicYear = $_POST['AcademicYear'];

$parts = explode("-", $AcademicYear);
$start = (int)$parts[0]-1;
$end = (int)$parts[1]-1;

$query5 = "SELECT Attainment FROM course_co_attainment WHERE Course_Code = '$CourseCode' AND Academic_Year = '".$start."-".$end."' ORDER BY CO";
// echo $query5;
$result2 = mysqli_query($conn, $query5);
$flag = 0;
if(mysqli_num_rows($result2) == 0){
    $flag = 1;
}
// echo $flag;

$Semester = $_POST['Semester'];
$Branch = $_POST['Branch'];
$_SESSION['AcademicYear'] = $AcademicYear;
$_SESSION['Semester'] = $Semester;
$_SESSION['Branch'] = $Branch;

if ($result) {
  while ($row = mysqli_fetch_assoc($result)) {
      $COArray[] = $row['CO'];      
  }
} else {
  echo "Error: " . mysqli_error($conn);
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
<form name = 'coursedetails' action = 'opening_submit.php' class='w-[57rem] flex flex-col justify-center' method = 'post' onsubmit = 'return(validate())'>
<div class='format p-10 bg-gray-100'>";

echo "<div>";

echo "
<div class='font-bold'>3. Identified gaps in Syllabus/ Course Description (If Any):</div>
<table class='mt-3'>
<table>
    <tr>
        <th>Topics To Be Introduced</th>
        <th>Strengthens CO</th>
        <th>Strengthens PO,PSO</th>
        <th>Method of Identification</th>
    </tr>";
    for ($i = 0; $i < $NumberOfTopicstobeintroduced; $i++) {
        echo "<tr>
            <td><input type='text' name='TopicsToBeIntroduced[]'></td>
            <td><input type='text' name='StrengthensCO[]'></td>
            <td><input type='text' name='StrengthensPOPSO[]'></td>
            <td><input type='text' name='MethodofIdentification[]'></td>
        </tr>  ";
    }  
echo "</table>";

echo "</div>

<div class='mt-5'>
<div class='font-bold'>4. Modifications in Syllabus/ Course Description (If Any):</div>
<table class='mt-3'>
    <tr>
        <th>Details of Modification</th>
        <th>Justification</th>
        <th>Strengthen POs</th>      
    </tr>";


    for ($i = 0; $i < $NumberOfDetailsofModification; $i++) {
        echo "<tr>
            <td><input type='text' name='DetailsofModification[]'></td>
            <td><input type='text' name='Justification[]'></td>
            <td><input type='text' name='StrengthensPOs[]'></td>    
        </tr>  ";
    } 

    echo "</table>
</div>

<div class='mt-5'>
<div class='font-bold'>5. Actions for Improving CO Attainments</div>
<table class='mt-3'>
    <tr>
        <th>CO</th>
        <th>Attainments in '$start'-'$end' </th>
        <th>Action to be taken in '$start'-'$end' to improve CO attainment</th>
        <th>Strengthen POs</th>        
    </tr>";


    for ($i = 0; $i < count($COArray); $i++) {
        echo "<tr>
            <td>$COArray[$i]</td>";
        if($flag == 1){
            echo "<td class='text-center'>No Data</td>";
        }
        else{
            echo "<td>".$result2->fetch_assoc()["Attainment"]."</td>";
        }
        echo "<td class='text-center'><input type='text' name='Actiontobetaken[]'></td>         
            <td class='text-center'><input type='text' name='StrengthensPOs2[]'></td>    
        </tr>  ";
    } 

    echo "
    </table>
</div>

<div class = 'mt-8'>
<div class='font-bold'>6. Innovative Teaching and Learning Method used:</div>
<br>
<textarea placeholder='Use $$ to create new points' name='Innovative_Teaching'></textarea>
</div>

<div class='font-bold mt-5'> 7.	Strategies for: </div>
    <div class='grid grid-cols-2 gap-7 mt-3'>
    <div>
        <div> Action taken for weak students </div>
        <div class = 'mt-2'><textarea placeholder='Use $$ to create new points' name='Weak_Learners'></textarea></div>
        </div>       
        </div>

<div class='grid grid-cols-2 gap-7 mt-3'>
    <div>
    <div>Action taken for bright students</div>
    <div class = 'mt-2'><textarea placeholder='Use $$ to create new points' name='Bright_Students'></textarea></div>
        </div>       
        </div>

<div class = 'mt-5'>
<div class='font-bold'>8. Innovative Evaluation Strategy to be used (If any):</div>
<br>
<textarea placeholder='Use $$ to create new points' name='Innovative_Evaluation'></textarea>
</div>


</div>

<div class='flex mt-8 justify-center mb-4'>
      <button
        class='font-semibold bg-white border-[1px] border-neutral-800 rounded-xl h-12 flex justify-center items-center text-lg w-60 hover:border-white'           
        type='submit' name='submit'
      >
        NEXT
      </button>
    </div>  

</form></div>";
echo "";

} else {
    echo '<script type="text/javascript">';
    echo 'alert("Something Went Wrong!");';
    echo 'setTimeout(function(){ window.location.href = "import.course.details.php"; }, 500);';
    echo '</script>';
    exit();
}

?>

</body>
</html>