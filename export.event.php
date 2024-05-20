<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EXPORT FORMAT</title>
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
    session_start();
    ?>
    <a href="main.php" class="text-xs underline font-semibold absolute ml-4 text-[#CCCDDE]">
                  <i class="bi bi-arrow-left mr-1 text-[#CCCDDE]"></i>BACK TO OPTIONS
                </a>
    <div class="flex justify-center font-bold text-2xl mt-20 text-[#CCCDDE]">GENERATE ACCEPTABLE FORMAT</div>

    <div class="flex justify-center mt-2 text-md opacity-60 text-[#CCCDDE]">Enter below details and our team will generate a format for you</div>

    <form name="Test" action="#" method="post" onsubmit="return(validate())">

        <div class="flex justify-center mt-5">

            <label class="block mt-[1.3rem] text-[#CCCDDE]" for="Event">Event:</label>
            <select class="text-black border border-neutral-800 text-gray-700 px-4 pr-8 rounded leading-tight focus:outline-none focus:border-indigo-500 focus:shadow-outline-indigo h-[2.4rem] mt-[1rem] ml-[1rem] " id="Event" name="Event" size="1">
                <option value='-1' selected>Select An Event</option>
                <option value="T1">T1</option>
                <option value="T2">T2</option>
                <option value="T3">T3</option>
                <option value="TA">TA</option>
                <option value="T1 T2 T3">T1, T2 & T3</option>
                <option value="T1 T2 T3 TA">All</option>
            </select>

        </div>

        <div class="flex w-full justify-center mt-10">
            <button class="font-semibold bg-white border-[1px] border-neutral-800 rounded-xl h-12 flex justify-center items-center text-lg w-52 slide-right hover:text-white hover:border-white" type="submit" name="submit" value="Next" id="new-toast">Next</button>
        </div>
    </form>

    <script type="text/javascript">
        var bgColors = [
                "linear-gradient(to right, #ff4b1f, #ff4b1f)",                             
            ],
            i = 0;

        function validate() {
            if (document.Test.Event.value == '-1') {
                Toastify({
                    text: "Please fill the event  ",
                    duration: 3000,
                    close: true,
                    style: {
                        background: bgColors[0],
                    }
                }).showToast();
                i++;
                return false;
            }
            return true;
        }
    </script>
</body>

</html>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

<?php
if (isset($_POST['submit'])) {
    $Event = $_POST["Event"];
    $_SESSION["Event"] = $Event;
    header("Location: export.format.php");
    exit();
}
?>