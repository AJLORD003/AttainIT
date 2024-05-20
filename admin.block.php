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
    <div class="flex justify-center font-bold text-2xl mt-20">BLOCK USER</div>

    <div class="flex justify-center mt-2 text-md text-black opacity-60">Enter the email of user to be blocked</div>

    <div class="w-full flex justify-center mt-16">
            <form action="#" method = "post" onsubmit = "return(validate())">
                <div class="bg-gray-100 format p-10">
                    <div class="flex gap-x-5"><label for="email_id" class='block text-gray-400 mt-3'>Email ID: </label>
                    <input type="email" id="email_id" name="email_id" placeholder="Enter Email ID" class='border border-gray-200 mt-2 outline-blue-500 pl-2 text-gray-500 rounded-md h-8' required></div>                                       

                    <div class='mt-8 mb-1'>
                        <button type="submit" name="submit" class='font-semibold bg-white border-[1px] border-neutral-800 rounded-xl h-12 flex justify-center items-center text-lg w-full slide-right hover:text-white hover:border-white submit-btn'>
                            BLOCK USER
                        </button>
                    </div>
                </div>
            </form>
        </div>

    <script type="text/javascript">
        var bgColors = [
                "linear-gradient(to right, #ff4b1f, #ff4b1f)",                             
            ],
            i = 0;

        function validate() {
            return true;
        }
    </script>
</body>

</html>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

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

    $email_id = $_POST['email_id'];

    // Use prepared statement to avoid SQL injection
    $queryCheckUser = "SELECT Admin, Block FROM USERS WHERE Email = ?";
    $stmt = mysqli_prepare($conn, $queryCheckUser);
    mysqli_stmt_bind_param($stmt, "s", $email_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        // User exists, verify the password
        mysqli_stmt_bind_result($stmt, $admin, $block);
        mysqli_stmt_fetch($stmt);

        if($admin == FALSE){
            if($block == FALSE){
                $blockquery = "UPDATE USERS SET Block = True WHERE Email = ?";
                $stmt = mysqli_prepare($conn, $blockquery);
                mysqli_stmt_bind_param($stmt, "s", $email_id);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);

                echo "<script>
                    alert('User Blocked Successfully')
                </script>";
            }
            else{
                echo "<script>
                    alert('User is already Blocked')
                </script>";
            }
        }
        else{
            echo "<script>
                alert('You cannot block another Admin')
            </script>";
        }
    } else {
        // User does not exist
        echo "<script>
            alert('User Not Found')
        </script>";
    }

    // Close connections
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>