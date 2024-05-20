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
        .format {
            box-shadow: inset 5px 8px 8px rgba(0, 0, 0, .1), inset -2px -2px 10px hsla(0, 0%, 100%, .1);
            border-radius: 20px;
        }
        body {
      background-color: #05051e;
    }
    </style>
</head>

<body>

    <?php
    session_start();

    if (isset($_SESSION['email'])) {
    ?>

        <a href='main.php' class='text-xs underline font-semibold absolute ml-4 mt-[4rem] text-[#CCCDDE]'>
            <i class='bi bi-arrow-left mr-1'></i>BACK TO OPTIONS
        </a>
        <div class="flex justify-center font-bold text-2xl pt-8 mt-12 text-[#CCCDDE]">
            ENTER COURSE DETAILS
        </div>

        <div class="flex justify-center w-full mt-10 details-container">

            <form name="course" method="post" onsubmit="return(validate())" action="import.course.submit.php" class="w-[35rem] flex flex-col"> 
            <!-- Changed 39 -->
                <div class="format p-10 bg-gray-100">
                <div class="grid grid-cols-2 gap-12 mt-3">
                    <!-- Included above line -->
                    <div>
                        <label for="CourseCode" class="block text-gray-400">Course Code: </label>
                        <input type="text" id="CourseCode" name="CourseCode" class="border border-gray-200 mt-2 outline-blue-500 pl-2 text-gray-500 rounded-md h-8" placeholder="Enter Course Code" required>
                    </div>

                    <div>
                        <!-- removed class -->
                        <label for="CourseName" class="block text-gray-400">Course Name: </label>
                        <input type="text" id="CourseName" name="CourseName" class="border border-gray-200 mt-2 outline-blue-500 pl-2 text-gray-500 rounded-md h-8" placeholder="Enter Course Name" required>
                    </div>
    </div>

                    <div class="grid grid-cols-2 gap-12 mt-6">

                    <!-- Included -->

                    <div>
                        <!-- Removed class -->
                        <label for="CourseCoordinator" class="block text-gray-400">Course Coordinator: </label>
                        <input type="text" id="CourseCoordinator" name="CourseCoordinator" class="border border-gray-200 mt-2 outline-blue-500 pl-2 text-gray-500 rounded-md h-8" placeholder="Enter Course Coordinator" required>
                    </div>

                    <div>
                        <!-- Removed class -->
                        <label for="Credits" class="block text-gray-400">Course Credits: </label>
                        <input type="int" id="Credits" name="Credits" class="border border-gray-200 mt-2 outline-blue-500 pl-2 text-gray-500 rounded-md h-8" placeholder="Enter Credits" required>
                    </div>

                    </div>

                    <div class="grid grid-cols-2 gap-12 mt-6">

                    <div>
                        <label for="contacthours" class="block text-gray-400">Course Contact Hours: </label>
                        <input type="text" id="contacthours" name="contacthours" class="border border-gray-200 mt-2 outline-blue-500 pl-2 text-gray-500 rounded-md h-8" placeholder="Enter Contact-Hours" required>
                    </div>                    

                    <div>
                    <label class="block text-gray-400" for="NBACode">NBA Code:</label>
                        <input type="text" id="NBACode" name="NBACode" placeholder="Enter NBA Code" class="border border-gray-200 mt-2 outline-blue-500 pl-2 text-gray-500 rounded-md h-8" required>
                        
                        <!-- Changed textarea -->
                    </div>

                    </div>

                    <div class="grid grid-cols-2 gap-12 mt-6">

                    <div>
                        <label for="ModuleCoordinator" class="block text-gray-400">Module Coordinator: </label>
                        <textarea rows=5 columns=200 id="ModuleCoordinator" name="ModuleCoordinator" class="border border-gray-200 mt-2 outline-blue-500 pl-2 text-gray-500 rounded-md" placeholder="Enter Module Coordinator" required></textarea>
                    </div>
                    <div>
                    <label for="CourseTeacher" class="block text-gray-400">Course Teachers: </label>
                        <textarea rows=5 columns=200 id="CourseTeacher" name="CourseTeacher" class="border border-gray-200 mt-2 outline-blue-500 pl-2 text-gray-500 rounded-md" placeholder="Enter Course Teachers" required></textarea>
                    </div>
                    </div>
                </div>

                <div class="flex mt-8 justify-center mb-4">
                    <button class="font-semibold bg-white border-[1px] border-neutral-800 rounded-xl h-12 flex justify-center items-center text-lg w-60 slide-right hover:text-white hover:border-white" type="submit" name="submit">
                        NEXT
                    </button>
                </div>


            </form>

        </div>

    <?php
    }
    ?>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        var form = document.forms['course'];

        form.addEventListener('submit', function (event) {
            if (!validate()) {
                event.preventDefault();
            }
        });

        function validate() {
            var bgColors = [
                "linear-gradient(to right, #ff4b1f, #ff4b1f)",
            ];

            // var name = /^[A-Za-z/- ]+$/;
            var name = /^[0-9\/]+$/;
            var Course_Code = /^[A-Z\d]+$/;

            console.log(form.CourseCode.value.match(name));

            if (!form.CourseCode.value.match(Course_Code)) {
                Toastify({
                    text: "Course Code should contain uppercase alphabets and digits only.  ",
                    duration: 3000,
                    close: true,
                    style: {
                        background: bgColors[0],
                    }
                }).showToast();
                return false;
            }

            if (form.CourseName.value.match(name)) {
                Toastify({
                    text: "Course Name should contain alphabets or '/' character only.  ",
                    duration: 3000,
                    close: true,
                    style: {
                        background: bgColors[0],
                    }
                }).showToast();
                return false;
            }

            if (form.CourseCoordinator.value.match(name)) {
                Toastify({
                    text: "Course Coordinator should contain alphabets or '/' character only ",
                    duration: 3000,
                    close: true,
                    style: {
                        background: bgColors[0],
                    }
                }).showToast();
                return false;
            }

            return true;
        }
    });
</script>

</body>

</html>




<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>