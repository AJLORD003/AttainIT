<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>IMPORT Feedback</title>
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

  <a href='main.php' class='text-xs underline font-semibold absolute ml-4 mt-[4rem] text-[#CCCDDE]'>
            <i class='bi bi-arrow-left mr-1'></i>BACK TO OPTIONS
        </a>

  <div class="flex justify-center font-bold text-2xl pt-16 text-[#CCCDDE]">
        IMPORT DATA (in excel format)
    </div>
    <div class="flex justify-center mt-2 text-sm text-[#CCCDDE] opacity-60">
        Your file should have all feedback data of students
    </div>
    <div class="w-full justify-center flex">
        <form method="post" enctype="multipart/form-data" class="mt-10" action="download.report.feedback.submit.php">
            <div class="flex justify-between w-full">
                <div class="w-1/2">
                    <label class='bg-white border-[1px] border-neutral-800 rounded-xl w-44 h-24 font-semibold text-lg flex justify-center items-center hover:text-white hover:border-white slide-right cursor-pointer mt-4'>
                        <input type='file' name='excel' class='hidden' onchange="getFileDetails()" />
                        <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' strokeWidth={1.5} stroke='currentColor' class='w-8 h-8'>
                            <path strokeLinecap='round' strokeLinejoin='round' d='M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z' />
                        </svg>
                        Upload
                    </label>
                </div>
                <div class="cont text-white flex justify-center w-1/2 hidden items-center underline ml-10"></div>
            </div>

            <div class='flex mt-10 justify-center mb-4 w-full'>
                <button type='submit' name='submit' class='font-semibold bg-white border-[1px] border-neutral-800 rounded-xl h-12 flex justify-center items-center w-full text-lg w-full slide-right hover:text-white hover:border-white toggle hidden'>
                    Import File
                </button>

                </div>

        </form>
    </div>

    <script>
        function getFileDetails() {
            const files = event.target.files;
            let names = '';

            for (let i = 0; i < files.length; i++) {
                names += files[i].name + '<br>';
            }

            var div = document.querySelector('.cont');
            div.innerHTML = names;

            var btn = document.querySelector('.toggle');
            if (files.length > 0) {
                div.classList.remove('hidden');
                btn.classList.remove('hidden');
            } else {
                btn.classList.add('hidden');
            }
        }
    </script>
  
  </body>
</html>