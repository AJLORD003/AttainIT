<!-- changed -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>  
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">   
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
         $servername = "localhost";
         $username = "root";
         $password = "";
         $dbname = "JIIT";

         // Included:
        echo "
        <a href='main.php' class='text-xs underline font-semibold absolute ml-4 mt-[4rem] text-[#CCCDDE]'>
            <i class='bi bi-arrow-left mr-1 text-[#CCCDDE]'></i>BACK TO OPTIONS
        </a>
        <div class='flex justify-center font-bold text-2xl pt-8 mt-12 text-[#CCCDDE]'>
            ENTER CO DETAILS
        </div>

        <div class='flex justify-center w-full mt-10 details-container'>
        ";
 
         $conn = mysqli_connect($servername, $username, $password, $dbname);
         if (isset($_POST['submit'])){
            $total_module = $_POST["total_module"];
            // $NBACode = $_SESSION["NBACode"];
            $Course_Code = $_SESSION["CourseCode"];
            $_SESSION["total_module"] = $total_module;
            echo "<form name = 'co_module' action = 'import.course.module.table.submit.php' method = 'post'> 
            <div class='format p-10 bg-gray-100'>"; // included"
            echo "<table>";
            echo "<thead>";
            echo "<tr>";
            $column_names = ["Module No.", "Title", "Contents", "No. Of Lectures"];
            foreach ($column_names as $value) {
                echo "<th>" . $value . "</th>";
            }
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            $form_column_names = ["Title", "content", "lectures"];
            for($counter = 1; $counter <= $total_module; $counter++){
                echo "<tr>";
                echo "<td>" . $counter . "</td>";
                $co = $counter;

                $query1 = "SELECT Title	, content, lectures FROM course_module WHERE Course_Code = '" . $Course_Code . "' AND module_no = " . $counter;
                $result1 = mysqli_query($conn, $query1);

                if ($result1 && mysqli_num_rows($result1) > 0){
                    $row = mysqli_fetch_assoc($result1);
                    // var_dump($row);

                    foreach ($form_column_names as $value){
                        $input_name = "Map[$co][$value]";
                        $existing_value = isset($row[$value]) ? $row[$value] : ''; // Use values from the second query
    
                        if($value == "lectures"){
                            echo "<td><input type='number' name='$input_name' value='$existing_value' required class='border border-gray-200 mt-2 outline-blue-500 pl-2 text-gray-500 rounded-md h-8'></td>"; // changed
                        }
                        else{
                            echo "<td><input type='text' name='$input_name' value='$existing_value' required class='border border-gray-200 mt-2 outline-blue-500 pl-2 text-gray-500 rounded-md h-8'></td>"; // changed
                        }
                    }
                }
                else{
                    for ($i = 0; $i < count($form_column_names); $i++){
                        if($form_column_names[$i] == "lectures"){
                            echo "<td><input type='number' name='Map[$co][$form_column_names[$i]]' required class='border border-gray-200 mt-2 outline-blue-500 pl-2 text-gray-500 rounded-md h-8'></td>"; // changed
                        }
                        else{
                            echo "<td><input type='text' name='Map[$co][$form_column_names[$i]]' required class='border border-gray-200 mt-2 outline-blue-500 pl-2 text-gray-500 rounded-md h-8'></td>"; // changed
                        }
                    }
                 }
                 echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
            echo "<div class='flex mt-8 justify-center mb-4'>
            <button class='font-semibold bg-white border-[1px] border-neutral-800 rounded-xl h-12 flex justify-center items-center text-lg w-60 slide-right hover:text-white hover:border-white' type='submit' name='submit'>
                NEXT
            </button>
        </div>"; // included
            echo "</div></form></div>"; // CHANGED
         }
         
    ?>
</body>
</html>