<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TA Marks</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <style>
        body {
      background-color: #05051e;
    }
        .format {
  box-shadow:inset 5px 8px 8px rgba(0,0,0,.1),inset -2px -2px 10px hsla(0,0%,100%,.1);
  border-radius: 20px;
}
    </style>
</head>

<body>

    <?php
    session_start();
    $total_events = $_SESSION["Questions"]["TA"];
    echo "<div class='flex w-full justify-center'>
    <form name='TA_marks' action='import.TA.marks.submit.php' method='post' onsubmit='return validate()' class='mt-10'>
    <div class='w-full flex justify-center gap-x-10 px-10 flex-wrap gap-y-5'>";
    for ($counter = 1; $counter <= $total_events; $counter++) {
        echo "<div class='w-[28rem] flex justify-center items-center flex-col p-4 py-8 mt-1 bg-gray-100 format'>
        <div class='w-full flex justify-center font-bold underline'>Event $counter</div>
        <div class='flex flex-col gap-2 mt-5'>  ";

        echo "<div class='flex gap-x-5 mt-5'><label for='marks_TA_${counter}_Type' class='block text-gray-400'>Event type: </label>";
        echo "<select name='Marks_TA[$counter][Type]' id='marks_TA_${counter}_Type' required class='bg-white border border-gray-200 text-gray-500 pl-2 rounded-md focus:outline-none focus:border-indigo-500 focus:shadow-outline-indigo h-8 pt-1'>
                <option value='-1'>Select an event type</option>
                <option value='quiz'>Quiz</option>
                <option value='assignment'>Assignment</option>
                <option value='project'>Project</option>
            </select></div>";

        echo "<div class='flex gap-x-5 mb-3'><label class='block text-gray-400 mt-2' for='marks_TA_${counter}_TT'>Total Marks: </label>";
        echo "<input class='border border-gray-200 mt-2 outline-blue-500 pl-2 text-gray-500 rounded-md h-8' type='number' name='Marks_TA[$counter][TT]' id='marks_TA_${counter}_TT' placeholder='Enter Total Marks' required min='1'></div></div>";

        for ($co = 1; $co <= 10; $co++) {
            echo "<div class='flex gap-x-5 mt-2'><label class='block text-gray-400 mt-3' for='marks_TA_${counter}_CO$co'>CO-$co </label>";
            echo "<input class='border border-gray-200 mt-2 outline-blue-500 pl-2 text-gray-500 rounded-md h-8' type='number' name='Marks_TA[$counter][CO][$co]' id='marks_TA_${counter}_CO$co' placeholder='CO $co' required min='0' value='0'></div>";
        }
        echo "</div>";
    }
    echo "</div><div class='flex mt-10 justify-center mb-4'>
    <button type='submit' name='submit'
      class='font-semibold bg-white border-[1px] border-neutral-800 rounded-xl h-12 flex justify-center items-center text-lg w-60 slide-right hover:text-white hover:border-white box-id'     
    >
      NEXT
    </button></div></form></div>";
    ?>

    <script type="text/javascript">
        var bgColors = [
            "linear-gradient(to right, #ff4b1f, #ff4b1f)",
        ]

        function validate() {
            var totalEvents = <?php echo $total_events; ?>;
            for (var counter = 1; counter <= totalEvents; counter++) {
                var eventType = document.getElementById('marks_TA_' + counter + '_Type').value;
                if (eventType == -1) {
                    Toastify({
                        text: 'Please select an event type for Event ' + counter,
                        duration: 3000,
                        close: true,
                        style: {
                            background: bgColors[0],
                        }
                    }).showToast();
                    return false;
                }

                var totalMarks = parseInt(document.getElementById('marks_TA_' + counter + '_TT').value);
                var sumCO = 0;
                for (var co = 1; co <= 10; co++) {
                    sumCO += parseInt(document.getElementById('marks_TA_' + counter + '_CO' + co).value);
                }
                if (sumCO !== totalMarks) {
                    Toastify({
                        text: 'Total marks for COs do not match the total marks for Event ' + counter,
                        duration: 3000,
                        close: true,
                        style: {
                            background: bgColors[0],
                        }
                    }).showToast();
                    return false;
                }
            }
            return true;
        }
    </script>

</body>

</html>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>