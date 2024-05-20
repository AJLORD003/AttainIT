<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Your Page Title</title>
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

  $Event = $_SESSION["Event"];
  $Tests = explode(" ", $Event);
  $colors = ['bg-blue-500', 'bg-green-500', 'bg-yellow-500', 'bg-red-500'];
  $i = 0;

  echo "
    <div   
    class='flex justify-center font-bold text-2xl mt-16 text-[#CCCDDE]'
  >
    ENTER NUMBER OF QUESTIONS
  </div>
    ";

  echo "<div className='flex w-full justify-center'>
    <form name = 'questions' action = 'import.questions.submit.php' method = 'post' onsubmit = 'return(validate())' class='mt-10'>
    <div class='w-full flex justify-center'>
    <div class='w-[25rem] flex justify-center items-center flex-col p-4 py-8 mt-1 format bg-gray-100'>
    ";
  foreach ($Tests as $Test) {

    if ($Test != "TA") {
      echo "<div class='flex gap-x-5 mt-1'><label for='$Test\_questions'>$Test: </label><input type='number' name='Questions[$Test]' 
      id='$Test\_questions' required class='border border-gray-200 outline-blue-500 pl-2 text-gray-500 h-6 rounded-md w-40'></div>";
    } else {
      echo "<div class='flex gap-x-5 mt-1'><label for='$Test\_questions'>$Test: </label><input type='number' name='Questions[$Test]' 
      id='$Test\_questions' required class='border border-gray-200 outline-blue-500 pl-2 text-gray-500 h-6 rounded-md w-40'></div>";
    }

    $i = $i + 1;
    
  }
  echo "    
  </div>     
  </div>
    <div class='flex mt-20 justify-center mb-4'>
    <button type='submit' name='submit'
      class='font-semibold bg-white border-[1px] border-neutral-800 rounded-xl h-12 flex justify-center items-center text-lg w-60 slide-right hover:text-white hover:border-white'     
    >
      NEXT
    </button>
    </form>
    </div> ";
  ?>

  <script type="text/javascript">
    function validate() {
      var bgColors = [
          "linear-gradient(to right, #ff4b1f, #ff4b1f)",
        ]

        var tests = "<?php echo $_SESSION["Event"]; ?>".split(" ");

      for (var i = 0; i < tests.length; i++) {
        if (document.forms["questions"]["Questions[" + tests[i] + "]"].value < 1 || document.forms["questions"]["Questions[" + tests[i] + "]"].value > 10) {
          Toastify({
            text: "Question Range Should be 1-10 for Test  " + tests[i],
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