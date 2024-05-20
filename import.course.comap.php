<!--  changed -->

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

    $conn = mysqli_connect($servername, $username, $password, $dbname);

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
    
        $total_co = $_SESSION["totalco"];
        $NBACode = $_SESSION["NBACode"];
        $Course_Code = $_SESSION["CourseCode"];
        echo "<form name = 'comap' action = 'import.course.comap.submit.php' method = 'post'>";
        echo "<table>";
        echo "<thead>";
        echo "<tr>";
        $column_names = ["CO", "PO1", "PO2", "PO3", "PO4", "PO5", "PO6", "PO7", "PO8", "PO9", "PO10", "PO11", "PO12", "PSO1", "PSO2"];
        foreach ($column_names as $value) {
            echo "<th class = 'text-[#CCCDDE]'>" . $value . "</th>";
        }
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        $form_column_names = ["PO1", "PO2", "PO3", "PO4", "PO5", "PO6", "PO7", "PO8", "PO9", "PO10", "PO11", "PO12", "PSO1", "PSO2"];
        for($counter = 1; $counter <= $total_co; $counter++){
            echo "<tr class ='text-[#CCCDDE]'>";
            $co = $NBACode.".".$counter;
            echo "<td>" . $co . "</td>";

            $query1 = "SELECT * FROM co_map WHERE Course_Code = '" . $Course_Code . "' AND CO = '" . $co . "'";
            // echo $query1;
            $result1 = mysqli_query($conn, $query1);

            if ($result1 && mysqli_num_rows($result1) > 0){
                $row = mysqli_fetch_assoc($result1);
                // var_dump($row);

                foreach ($form_column_names as $value){
                    $input_name = "Map[$co][$value]";
                    $existing_value = isset($row[$value]) ? $row[$value] : ''; // Use values from the second query

                    echo "<td><input type='number' name='$input_name' value='$existing_value' class='text-black' style='width: 50px;' required></td>";
                }
            }
            else {
                // Handle the case when no data is found in co_map for the current CO
                for ($i = 0; $i < count($form_column_names); $i++) {
                    echo "<td><input type='number' name='Map[$co][$form_column_names[$i]]' class='text-black' style='width: 50px;' required></td>";
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
        echo "</form></div>"; // chanegd
    
    ?>
</body>
</html>