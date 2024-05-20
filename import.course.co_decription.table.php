<!-- changed -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">   
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>   
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
            $total_co = $_POST["totalco"];
            $NBACode = $_SESSION["NBACode"];
            $Course_Code = $_SESSION["CourseCode"];
            $_SESSION["totalco"] = $total_co;
            echo "<form name = 'co_description' action = 'import.course.co_description.table.submit.php' method = 'post' class=w-[40rem]>
            <div class='format p-10 bg-gray-100'>"; // included
            echo "<table>";
            echo "<thead>";
            echo "<tr>";
            $column_names = ["CO", "Description", "level"];
            foreach ($column_names as $value) {
                echo "<th>" . $value . "</th>";
            }
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            $form_column_names = ["Description", "level"];
            for($counter = 1; $counter <= $total_co; $counter++){
                echo "<tr>";
                $co = $NBACode.".".$counter;
                echo "<td>" . $co . "</td>";

                $query1 = "SELECT Description, level FROM course_co_description WHERE Course_Code = '" . $Course_Code . "' AND CO = '" . $co . "'";
                $result1 = mysqli_query($conn, $query1);

                if ($result1 && mysqli_num_rows($result1) > 0){
                    $row = mysqli_fetch_assoc($result1);
                    // var_dump($row);

                    foreach ($form_column_names as $value) {
                        $input_name = "Map[$co][$value]";
                        $existing_value = isset($row[$value]) ? $row[$value] : '';
                        if($value == "level"){
                            echo "<td><select name='$input_name' class='text-black border border-neutral-800 text-gray-700 px-4 pr-8 rounded leading-tight focus:outline-none focus:border-indigo-500 focus:shadow-outline-indigo h-[2.4rem] mt-[1rem] ml-[1rem]'>"; //Changed
                            $cognitive_levels = array(
                                'Remember Level (C1)',
                                'Understand Level (C2)',
                                'Apply Level (C3)',
                                'Analyze Level (C4)',
                                'Evaluate Level (C5)',
                                'Create Level (C6)'
                            );
                            foreach ($cognitive_levels as $level) {
                                if($existing_value == $level){
                                    echo "<option value='$level' selected>$level</option>";
                                }
                                else{
                                    echo "<option value='$level'>$level</option>";
                                }
                                
                            }
                            echo "</select></td>";
                        }
                        else{
                            echo "<td><input type='text' name='$input_name' value='$existing_value' required class='border border-gray-200 mt-2 outline-blue-500 pl-2 text-gray-500 rounded-md h-8'></td>"; //changed
                        }
                    }
                }
                else {
                    for ($i = 0; $i < count($form_column_names); $i++) {
                        if($form_column_names[$i] == "level"){
                            echo "<td><select name='Map[$co][$form_column_names[$i]]' class='text-black border border-neutral-800 text-gray-700 px-4 pr-8 rounded leading-tight focus:outline-none focus:border-indigo-500 focus:shadow-outline-indigo h-[2.4rem] mt-[1rem] ml-[1rem]'>"; // changed
                            $cognitive_levels = array(
                                'Remember Level (C1)',
                                'Understand Level (C2)',
                                'Apply Level (C3)',
                                'Analyze Level (C4)',
                                'Evaluate Level (C5)',
                                'Create Level (C6)'
                            );
                            foreach ($cognitive_levels as $level) {
                                if($existing_value == $level){
                                    echo "<option value='$level' selected>$level</option>";
                                }
                                else{
                                    echo "<option value='$level'>$level</option>";
                                }
                                
                            }
                            echo "</select></td>";
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
            echo "</div></form></div>"; // changed
        }
    ?>
</body>
</html>