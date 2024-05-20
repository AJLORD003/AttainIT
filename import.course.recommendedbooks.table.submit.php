<?php
    session_start();

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "JIIT";

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    $Course_Code = $_SESSION["CourseCode"];
    $NBACode = $_SESSION["NBACode"];
    $total_books = $_SESSION["total_books"];

    $column_names = ["Course_Code", "book_no", "content", "type"];
    $form_column_names = ["content", "type"];
    $query3_part1 = "";
    foreach($column_names as $key => $value){
        $query3_part1 = $query3_part1.$value.", ";
    }
    $query3_part1 = rtrim($query3_part1,", ");

    for($counter = 1; $counter <= $total_books; $counter++){
        $query3_part2 = "'";
        foreach($form_column_names as $key => $value){
            $query3_part2 = $query3_part2.$_POST['Map'][$counter][$value]."', '";
        }
        $query3_part2 = rtrim($query3_part2,", '");
        $query3_part2 = $query3_part2."'";
        $query2 = "SELECT * FROM books WHERE Course_Code = '" . $Course_Code . "' AND book_no = " . $counter;
        $query3 = "INSERT INTO books(".$query3_part1.") VALUES ('".$Course_Code."', ".$counter.", ".$query3_part2.")";
        $query4 = "UPDATE books SET content = '".$_POST['Map'][$counter]["content"]."', type = '".$_POST['Map'][$counter]["type"]."' WHERE Course_Code = '".$Course_Code."' AND book_no = " . $counter; 
        // echo $query2."<br>";
        // echo $query3."<br>";
        // echo $query4."<br>";
        $result2 = mysqli_query($conn, $query2);
        if (mysqli_num_rows($result2) == 0){
            mysqli_query($conn, $query3);
        }
        else{
            mysqli_query($conn, $query4);
        }
    }
    header("Location: main.php");
    exit();
?>