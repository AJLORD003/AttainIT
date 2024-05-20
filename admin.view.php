<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BLOCK USER</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

</head>
<body>
    <a href="admin.home.php" class="text-xs underline font-semibold absolute ml-4">
        <i class="bi bi-arrow-left mr-1"></i>BACK TO OPTIONS
    </a>
</body>
</html>
<?php
    session_start();

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "JIIT";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $query1 = "Select User_Name, Email, Block FROM USERS WHERE Admin = False";
    $result1 = mysqli_query($conn, $query1);

    echo "User_Name | Email | Block <br>";
    while($row1 = $result1->fetch_assoc()){
        echo $row1["User_Name"]." | ".$row1["Email"]." | ".$row1["Block"]."<br>";
    }
?>