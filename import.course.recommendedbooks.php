<!-- Changed whole styling -->

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

<a href='main.php' class='text-xs underline font-semibold absolute ml-4 mt-[4rem] text-[#CCCDDE]'>
            <i class='bi bi-arrow-left mr-1 text-[#CCCDDE]'></i>BACK TO OPTIONS
        </a>
        <div class="flex justify-center font-bold text-2xl pt-8 mt-12 text-[#CCCDDE]">
            ENTER BOOK DETAILS
        </div>

        <div class="flex justify-center w-full mt-10 details-container">
    <form action="import.course.recommendedbooks.table.php" method="post">
    <label for="total_books" class="text-[#CCCDDE]">Enter total number of Books:</label>
        <input type="number" id="total_books" name="total_books" required class="text-black border border-neutral-800 text-gray-700 px-4 pr-8 rounded leading-tight focus:outline-none focus:border-indigo-500 focus:shadow-outline-indigo h-[2.4rem] mt-[1rem] ml-[1rem]">
        <div class="flex mt-8 justify-center mb-4">
                    <button class="font-semibold bg-white border-[1px] border-neutral-800 rounded-xl h-12 flex justify-center items-center text-lg w-60 slide-right hover:text-white hover:border-white" type="submit" name="submit">
                        NEXT
                    </button>
                </div>
    </form>
        </div>
</body>
</html>