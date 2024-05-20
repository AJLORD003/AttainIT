<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <script>
        function validate() {
            return true;
        }
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
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
    <section>
        <div class="flex justify-center font-bold text-2xl pt-8 text-[#CCCDDE] mt-8">
            NEW, HERE ?
        </div>

        <div class="w-full flex justify-center mt-12">
            <form action="user.register.php" method="post" onsubmit="return(validate())">
                <div class="bg-gray-100 format p-10">
                    <div class="flex gap-x-5"><label for="Name" class='block text-gray-400 mt-3'>Name: </label>
                        <input type="text" id="Name" name="Name" class='border border-gray-200 mt-2 outline-blue-500 pl-2 text-gray-500 rounded-md h-8' placeholder="Enter Name" required>
                    </div>

                    <div class="flex gap-x-5 mt-4"><label for="email_id" class='block text-gray-400 mt-3'>Email ID: </label>
                        <input type="email" id="email_id" name="email_id" class='border border-gray-200 mt-2 outline-blue-500 pl-2 text-gray-500 rounded-md h-8' placeholder="Enter Email ID" required>
                    </div>

                    <div class="flex gap-x-5 mt-4"><label for="passwords" class='block text-gray-400 mt-3'>Password: </label>
                        <input type="password" id="passwords" name="passwords" class='border border-gray-200 mt-2 outline-blue-500 pl-2 text-gray-500 rounded-md h-8' placeholder="Enter Password" required>
                    </div>


                    <div class='mt-8 mb-1'>
                        <button type="submit" name="submit" class='font-semibold bg-white border-[1px] border-neutral-800 rounded-xl h-12 flex justify-center items-center text-lg w-full slide-right hover:text-white hover:border-white submit-btn'>
                            REGISTER
                        </button>
                    </div>

                    <div class='mt-4'>
                        <a href="login.php" class='font-semibold bg-white border-[1px] border-neutral-800 rounded-xl h-12 flex justify-center items-center text-lg w-full slide-right hover:text-white hover:border-white submit-btn'>
                            LOGIN
                        </a>
                    </div>
                </div>
            </form>
        </div>
        <br>
    </section>

</body>

</html>

<?php
if (isset($_POST['submit'])) {
    session_start();

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "JIIT";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $Name = $_POST['Name'];
    $email_id = $_POST['email_id'];
    $passwords = $_POST['passwords'];

    // Hash the password securely
    $hashedPassword = password_hash($passwords, PASSWORD_DEFAULT);

    // Use prepared statement to avoid SQL injection
    $queryCheckUser = "SELECT Users_key FROM USERS WHERE Email = ?";
    $stmt = mysqli_prepare($conn, $queryCheckUser);
    mysqli_stmt_bind_param($stmt, "s", $email_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    $admin = False;
    $block = False;

    if (mysqli_stmt_num_rows($stmt) == 0) {
        // User does not exist, proceed with registration
        $queryInsertUser = "INSERT INTO USERS(User_Name, Email, User_Password, Admin, Block) VALUES (?, ?, ?, ?, ?)";
        $stmtInsert = mysqli_prepare($conn, $queryInsertUser);
        mysqli_stmt_bind_param($stmtInsert, "sssii", $Name, $email_id, $hashedPassword, $admin, $block);
        mysqli_stmt_execute($stmtInsert);

        $emp_id = mysqli_insert_id($conn); // Retrieve the last inserted ID
        $_SESSION["emp_id"] = $emp_id;
        $_SESSION["email"] = $email_id;

        header("Location: index.php");
        exit();
        // Close connections
        mysqli_stmt_close($stmt);
        mysqli_stmt_close($stmtInsert);
        mysqli_close($conn);
    } else {
        // User already exists
        echo "<script>
            alert('User Already Exists')
        </script>";
    }
}
?>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>