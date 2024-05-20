<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CO MAP</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="index.css">
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>

    <style>
        body {
      background-color: #05051e;
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
$Course_Key = $_SESSION['Course_Key'];

$query13 = "SELECT Course_Code FROM COURSE_DETAILS WHERE Course_Key = '$Course_Key'";
$Course_Code = mysqli_query($conn, $query13)->fetch_assoc()["Course_Code"];

$query1 = "SELECT CO FROM final_attainment WHERE Course_Key = " . $Course_Key . " AND Test = 'feedback' ORDER BY CO";
$result1 = mysqli_query($conn, $query1);
$co_map = array();
$flag = 0;

$column_names = ["CO", "PO1", "PO2", "PO3", "PO4", "PO5", "PO6", "PO7", "PO8", "PO9", "PO10", "PO11", "PO12", "PSO1", "PSO2"];

echo "<a href='main.php' class='text-xs underline font-semibold absolute ml-4 mt-[4rem] text-[#CCCDDE]'>
<i class='bi bi-arrow-left mr-1'></i>BACK TO OPTIONS
</a>";

echo "<div class='flex justify-center font-bold text-2xl pt-16 text-[#CCCDDE]'>
IMPORT DATA (in excel format)
</div>";

echo "<div class='flex justify-center items-center w-full flex-col'><table border='1' class='mt-10' style='width: 100%; border-collapse: collapse; margin-bottom: 20px;'>";
echo "<thead>";
echo "<tr>";
foreach ($column_names as $value) {
    echo "<th class='text-[#CCCDDE]' style='padding: 8px; border: 1px solid #ccc; text-align: center;'>" . $value . "</th>";
}
echo "</tr>";
echo "</thead>";

echo "<tbody>";

while ($row = $result1->fetch_assoc()) {
    $co_map[] = $row["CO"];
    echo "<tr>";
    $query2 = "SELECT * FROM co_map WHERE Course_Code = '" . $Course_Code . "' AND CO = '" . $row["CO"] . "'";
    $result2 = mysqli_query($conn, $query2);
    if (mysqli_num_rows($result2) == 0) {
        if ($flag == 0) {
            echo "<td colspan='15' class = 'text-[#CCCDDE]' style='padding: 8px; text-align: center; border: 1px solid #ccc;'>" . "No Data About PO & PSO Mapping Found in Database. Please Fill The Data Below<br>" . "</td>";
            $flag++;
        }
    } else {
        while ($row2 = $result2->fetch_assoc()) {
            foreach ($column_names as $value) {
                echo "<td class='text-[#CCCDDE]' style='padding: 8px; border: 1px solid #ccc; text-align: center;'>" . $row2["$value"] . "</td>";
            }
        }
    }
    echo "</tr>";
}
echo "</tbody>";
echo "</table></div>";

$form_column_names = ["PO1", "PO2", "PO3", "PO4", "PO5", "PO6", "PO7", "PO8", "PO9", "PO10", "PO11", "PO12", "PSO1", "PSO2"];

echo "<div class='flex w-full justify-center text-[#CCCDDE]'>
    <form name='comap' action='download.report.comap.submit.php' method='post' class='mt-5' style='width: 100%; text-align: center;'>
    <div class='flex justify-center items-center flex-col mt-1 text-[#CCCDDE]'><div class='flex justify-center font-bold text-2xl pt-16 text-[#CCCDDE]'>EDIT DATA</div>";
    
echo "<table border='1' class='mt-5' style='width: 100%; border-collapse: collapse; margin-bottom: 20px;'>";
echo "<thead>";
echo "<tr>";
foreach ($column_names as $value) {
    echo "<th class='text-[#CCCDDE]' style='padding: 8px; border: 1px solid #ccc; text-align: center;'>" . $value . "</th>";
}
echo "</tr>";
echo "</thead>";

echo "<tbody>";
foreach ($co_map as $co) {
    echo "<tr>";
    echo "<td class='text-[#CCCDDE]' style='padding: 8px; border: 1px solid #ccc; text-align: center;'>" . $co . "</td>";

    $query2 = "SELECT * FROM co_map WHERE Course_Code = '" . $Course_Code . "' AND CO = '" . $co . "'";
    $result2 = mysqli_query($conn, $query2);

    if ($result2 && mysqli_num_rows($result2) > 0) {
        $row2 = mysqli_fetch_assoc($result2);

        foreach ($form_column_names as $value) {
            $input_name = "Map[$co][$value]";
            $existing_value = isset($row2[$value]) ? $row2[$value] : ''; // Use values from the second query

            echo "<td class='text-[#CCCDDE]' style='padding: 8px; border: 1px solid #ccc; text-align: center;'><input type='number' class='text-black' name='$input_name' value='$existing_value' style='width: 50px;' required></td>";
        }
    } else {
        // Handle the case when no data is found in co_map for the current CO
        for ($i = 0; $i < count($form_column_names); $i++) {
            echo "<td class='text-[#CCCDDE]' style='padding: 8px; border: 1px solid #ccc; text-align: center;'><input type='number' class='text-black' name='Map[$co][$form_column_names[$i]]' style='width: 50px;' required></td>";
        }
    }

    echo "</tr>";
}
echo "</tbody>";
echo "</table>";

echo "</div>";
echo "</div></div>";
echo "<div class='flex mt-10 justify-center mb-4'>
    <button type='submit' name='submit'
        class='font-semibold bg-white border-[1px] border-neutral-800 rounded-xl h-12 flex justify-center items-center text-lg w-60 slide-right hover:text-white hover:border-white'     
    >
        NEXT
    </button>
    </form>
    </div>";
?>

</body>
</html>