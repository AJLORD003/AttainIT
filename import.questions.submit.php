<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Question Details</title>
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
    if (isset($_POST['submit'])) {
        $Event = $_SESSION["Event"];
        $Tests = explode(" ", $Event);

        $Questions = [];
        foreach ($Tests as $Test) {
            $Questions[$Test] = $_POST['Questions'][$Test];
        }
        $_SESSION["Questions"] = $Questions;

        if ($Event == "TA") {
            header("Location: import.TA.marks.php");
            exit();
        }

        $count = 1;
        $testCount = 0;     

        echo " 
        <div class='flex justify-center font-bold text-2xl pt-16 text-[#CCCDDE]'>
        ENTER DETAILS FOR EVENTS
    </div>
        <div class='flex w-full justify-center mt-10'>
       
        <form name = 'question_marks' action = 'import.questions.marks.submit.php' method = 'post' onsubmit = 'return(validate())' class='mt-10 mb-10'>
        <div class='flex justify-center gap-10 px-10 flex-wrap'>";

        foreach ($Tests as $Test) {
            $total_questions = $Questions[$Test];
            $testCount = $testCount + 1;

            if ($Test != "TA") {

                echo "<div class='flex justify-center items-center flex-col p-4 py-8 format mt-1 box conditional-show bg-gray-100' id='$Test'>
                <div class='w-full flex justify-center font-bold underline'>$Test Details</div>
                <div class='flex flex-col gap-2 mt-5'>            
                ";

                for ($counter = 1; $counter <= $total_questions; $counter++) {
                    echo "<div class='flex gap-x-5 mt-5'><div class='mt-[1.3rem] font-semibold underline'>Question $counter:</div><div class='ml-[2rem]'><label class='block text-gray-400' for='marks_$Test\_$counter\_CO'>Course Outcome:</label>";
                    echo "<select name='Marks[$Test][$counter][CO]' id='marks_$Test\_$counter\_CO' class='bg-white mt-2 border border-gray-200 text-gray-500 pl-2 rounded-md focus:outline-none focus:border-indigo-500 focus:shadow-outline-indigo h-8 pt-1'>
                                     <option value='-1' selected>Please Select CO</option>
                                     <option value='1'>CO1</option>
                                     <option value='2'>CO2</option>
                                     <option value='3'>CO3</option>
                                     <option value='4'>CO4</option>
                                     <option value='5'>CO5</option>
                                     <option value='6'>CO6</option>
                                     <option value='7'>CO7</option>
                                    <option value='8'>CO8</option>
                                    <option value='9'>CO9</option>
                                    <option value='10'>CO10</option>
                                </select></div>
                                
                        <div><label class='block text-gray-400' for='marks_$Test\_$counter\_MM'>Maximum Marks:</label>
                        <input class='border border-gray-200 mt-2 outline-blue-500 pl-2 text-gray-500 rounded-md h-8'  type='number' name='Marks[$Test][$counter][MM]' id='marks_$Test\_$counter\_MM' placeholder='Enter Maximum Marks' required>
                        </div></div>";
                }              

                if (count($Tests) == 4) {
                    if ($testCount == 3) {
                        echo "<div class='flex mt-10 justify-center mb-4'>
                        <button type='submit' name='submit'
                          class='font-semibold bg-white border-[1px] border-neutral-800 rounded-xl h-12 flex justify-center items-center text-lg w-60 slide-right hover:text-white hover:border-white box-id'     
                        >
                          NEXT
                        </button></div>";
                    }
                } else {

                    if ($testCount == count($Tests)) {
                        echo "<div class='flex mt-10 justify-center mb-4'>
                        <button type='submit' name='submit'
                          class='font-semibold bg-white border-[1px] border-neutral-800 rounded-xl h-12 flex justify-center items-center text-lg w-60 slide-right hover:text-white hover:border-white box-id'     
                        >
                          NEXT
                        </button></div>";
                    }
                }

                echo "</div></div>";
            }
        }

        echo "</div>";
        echo "</form></div>";
    }
    ?>

    <script type="text/javascript">

        var bgColors = [
                "linear-gradient(to right, #ff4b1f, #ff4b1f)",                             
            ]   

        // document.addEventListener('DOMContentLoaded', function() {
        //     setCurrentIndex("T1");
        // });

        // function handleButtonClick(id) {
        //     setCurrentIndex(id);

        //     if (validate()) {
        //         return true;
        //     } else {
        //         return false;
        //     }
        // }

        // function setCurrentIndex(id) {
        //     const allContentDivs = document.querySelectorAll('.conditional-show');
        //     allContentDivs.forEach(div => {
        //         div.classList.add('hidden');
        //     });

        //     const selectedContentDiv = document.getElementById(id);
        //     selectedContentDiv.classList.remove('hidden');
        // }


        function validate() {
            // var btn = document.getElementByClassName('box-id')
            var tests = <?php echo json_encode($_SESSION['Event']); ?>.split(" ");
            var questionsData = <?php echo json_encode($_SESSION['Questions']); ?>;

            for (var i = 0; i < tests.length; i++) {
            var test = tests[i];
            var total_Questions = questionsData[test];
            var expected_Total_Marks = (test === "T3") ? 35 : 20;
            var total_Marks = 0;
            
            for (var j = 1; j <= total_Questions; j++) {
                var coSelect = document.forms["question_marks"]["Marks[" + test + "][" + j + "][CO]"];
                var mmInput = document.forms["question_marks"]["Marks[" + test + "][" + j + "][MM]"];
                
                // Check if CO is selected
                if (coSelect.value === '-1') {
                        Toastify({
                            text: "Please choose a Course Outcome for Question " + j + " in " + test,
                            duration: 3000,
                            close: true,
                            style: {
                                background: bgColors[0],
                            }
                        }).showToast();             
                        return false;
                    }

                    // Check for non-numeric or negative marks
                    var marks = parseInt(mmInput.value, 10);
                    if (isNaN(marks) || marks <= 0) {
                        Toastify({
                            text: "Maximum Marks must be a positive number for Question " + j + " in " + test,
                            duration: 3000,
                            close: true,
                            style: {
                                background: bgColors[0],
                            }
                        }).showToast();                   
                        return false;
                    }
                    if (marks > expected_Total_Marks) {
                        Toastify({
                            text: "Maximum Marks for Q" + j + " in " + test + " cannot exceed the total marks for the test.",
                            duration: 3000,
                            close: true,
                            style: {
                                background: bgColors[0],
                            }
                        }).showToast();                          
                        return false;
                    }

                    // Add marks to the total marks
                    total_Marks += marks;
                }

                // Validate the total marks for the test
                if (total_Marks !== expected_Total_Marks) {
                    Toastify({
                            text: "Total marks for " + test + " should be " + expected_Total_Marks,
                            duration: 3000,
                            close: true,
                            style: {
                                background: bgColors[0],
                            }
                        }).showToast();                        
                    return false;
                }
            }
        // All validations passed, continue with the form submission
        return true;
    }
    </script>

</body>

</html>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>