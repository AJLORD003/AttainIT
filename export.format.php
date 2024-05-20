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
    .tooltip {
            position: relative;
            display: inline-block;
            cursor: pointer;
        }
        .tooltip .tooltiptext {
            visibility: hidden;
            width: 120px;
            background-color: #333;
            color: #fff;
            text-align: center;
            border-radius: 5px;
            padding: 5px;
            position: absolute;
            z-index: 1;
            bottom: -32%;
            left: 50%;
            margin-left: -60px;
            opacity: 0;
            transition: opacity 0.3s;
        }
    .tooltip:hover .tooltiptext {
            visibility: visible;
            opacity: 1;
        }

        body {
      background-color: #05051e;
    }

        .format {
  box-shadow:inset 5px 8px 8px rgba(0,0,0,.1),inset -2px -2px 10px hsla(0,0%,100%,.1);
  border-radius: 20px;
}

.tooltip2 {
            position: relative;
            display: inline-block;
            cursor: pointer;
        }
        .tooltip2 .tooltiptext2 {
            visibility: hidden;
            width: 180px;
            background-color: #333;
            color: #fff;
            text-align: center;
            border-radius: 5px;
            padding: 5px;
            position: absolute;
            z-index: 1;
            bottom: -182%;
            left: 80%;
            margin-left: -60px;
            opacity: 0;
            transition: opacity 0.3s;
        }
    .tooltip2:hover .tooltiptext2 {
            visibility: visible;
            opacity: 1;
        }

        .tooltip3 {
            position: relative;
            display: inline-block;
            cursor: pointer;
        }
        .tooltip3 .tooltiptext3 {
            visibility: hidden;
            width: 180px;
            background-color: #333;
            color: #fff;
            text-align: center;
            border-radius: 5px;
            padding: 5px;
            position: absolute;
            z-index: 1;
            top: 112%;
            right: 50%;        
            opacity: 0;
            transition: opacity 0.3s;
        }
    .tooltip3:hover .tooltiptext3 {
            visibility: visible;
            opacity: 1;
        }
  </style>

</head>

<body>

  <?php
  session_start();

  require 'vendor/autoload.php';

  use PhpOffice\PhpSpreadsheet\Spreadsheet;
  use PhpOffice\PhpSpreadsheet\IOFactory;
  use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

  $Event = $_SESSION["Event"];
  $Tests = explode(" ", $Event);

  echo "
  <a href='main.php' class='text-xs underline font-semibold absolute ml-4 text-[#CCCDDE]'>
                  <i class='bi bi-arrow-left mr-1 text-[#CCCDDE]'></i>BACK TO OPTIONS
                </a>
    <div   
    class='flex justify-center font-bold text-2xl mt-16 text-[#CCCDDE]'
  >
    ENTER NUMBER OF QUESTIONS
  </div>
    ";

  echo "<div class='flex w-full justify-center'>
    <form name = 'Details' method = 'post' enctype = 'multipart/form-data' onsubmit = 'return(validate())' class='mt-10'>";
    echo "<div class='w-[30rem] flex justify-center items-center flex-col p-4 py-8 mt-1 format bg-gray-100'>";
  foreach ($Tests as $Test) {


    if ($Test != "TA") {
      echo "<div class='flex gap-x-5 mt-1'><label for='$Test\_questions' class='block text-gray-400 mt-3'>$Test: </label> <input type='number' class='border border-gray-200 mt-2 outline-blue-500 pl-2 text-gray-500 rounded-md h-8' name='Questions[$Test]' id='$Test\_questions' required></div>";
    } else {
      echo "<div class='flex gap-x-5 mt-1'><label for='$Test\_questions' class='block text-gray-400 mt-3'>$Test: </label> <input type='number' class='border border-gray-200 mt-2 outline-blue-500 pl-2 text-gray-500 rounded-md h-8' name='Questions[$Test]' id='$Test\_questions' required></div>";
    }

    // echo "<br><br>";
  }
  echo "<label for='INFO' class='block mt-10 text-gray-400'>Select file with student data (only excel format):</label>

    <div class='flex justify-between'>
    <div class='w-1/2'>
    <div class='tooltip'>
              <label class='bg-white border-[1px] border-neutral-800 rounded-xl w-44 h-24 font-semibold text-lg flex justify-center items-center hover:text-white hover:border-white slide-right cursor-pointer mt-4'>
              <input
                    type='file'
                    name='excel'
                    id='INFO'               
                    class='hidden'
                  />
                  <svg
                    xmlns='http://www.w3.org/2000/svg'
                    fill='none'
                    viewBox='0 0 24 24'
                    strokeWidth={1.5}
                    stroke='currentColor'
                    class='w-8 h-8'
                  >
                    <path
                      strokeLinecap='round'
                      strokeLinejoin='round'
                      d='M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z'
                    />
                  </svg>
                  
                  Upload
                  
                  </label>
                  <div class='tooltiptext'>Upload a file</div>
                </div>                
              </div>
              <div class='text-[#CCCDDE] flex justify-start w-1/2 items-center underline'>
                
              </div>
            </div>
            </div>

            <div class='mt-5 mb-3 flex justify-center'>
              <button
                class='font-semibold bg-white border-[1px] border-neutral-800 rounded-xl h-12 w-[16rem] flex justify-center items-center text-lg hover:border-white submit-btn' type='submit' name='submit' value='Generate Format'         
              >
                GENERATE FORMAT
              </button>
            </div>
    </form>
    </div>
    
    <div class='absolute right-[2rem] top-10'><div class='tooltip3'><a href='help.php' class='text-[#CCCDDE]'><svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentColor' class='bi bi-info-circle-fill hover:text-indigo-500 cursor-pointer text-[#CCCDDE]' viewBox='0 0 16 16'>
    <path d='M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2' />
  </svg></a><div class='tooltiptext3'>Show Format</div></div> </div>
  ";    
  ?>

  <script type="text/javascript">
    var bgColors = [
        "linear-gradient(to right, #ff4b1f, #ff4b1f)",
      ],
      i = 0;

    function validate() {

      var tests = "<?php echo $_SESSION["Event"]; ?>".split(" ");

      for (var i = 0; i < tests.length; i++) {
        if (document.forms["Details"]["Questions[" + tests[i] + "]"].value < 1 || document.forms["Details"]["Questions[" + tests[i] + "]"].value > 10) {
          Toastify({
            text: "Question Range Should be 1-10 for Test " + tests[i],
            duration: 3000,
            close: true,
            style: {
              background: bgColors[0],
            }
          }).showToast();
          i++;
          return false;
        }        
      }
      var fileInput = document.getElementById('INFO');
      if (fileInput.files.length === 0) {
        Toastify({
          text: "Please select a file  ",
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

  <?php
  if (isset($_POST['submit'])) {
    $allowed_ext = ['xlsx', 'xls', 'csv'];
    $filename = $_FILES['excel']['name'];
    $checking = explode(".", $filename);
    $file_ext = strtolower(end($checking));
    if (in_array($file_ext, $allowed_ext)) {
      $Event = $_SESSION["Event"];
      $Tests = explode(" ", $Event);
      $length = count($Tests);

      $targetpath = $_FILES['excel']['tmp_name'];
      $reader = IOFactory::load($targetpath);
      $source_spreadsheet = $reader->getActiveSheet()->toArray();
      array_shift($source_spreadsheet);


      $sheet_counter = 0;
      $spreadsheet = new Spreadsheet();

      for ($counter = 0; $counter < $length; $counter++) {
        $fields = ["Roll_no", "Student_Name", "Batch"];
        $field_counter = 1;
        $field_limit = $_POST['Questions'][$Tests[$counter]];
        if ($Tests[$counter] == "TA") {
          $common = "Event ";
        } else {
          $common = "Q";
        }
        while ($field_counter <= $field_limit) {
          $fields[] = $common . $field_counter;
          $field_counter++;
        }
        if ($counter + 1 != $length) {
          $spreadsheet->createSheet();
        }
        $target_spreadsheet = $spreadsheet->getSheet($sheet_counter);
        $sheet_counter++;
        $target_spreadsheet->setTitle($Tests[$counter]);
        $target_spreadsheet->fromArray($fields, NULL, 'A1');
        $target_spreadsheet->fromArray($source_spreadsheet, NULL, 'A2');
      }

      $outputFile = 'Format.xlsx';
      $writer = new Xlsx($spreadsheet);
      $writer->save($outputFile);

      echo "
            <div class='flex justify-center w-full mb-10'>
            <div class='tooltip2'>
                <div class='mt-3 text-black'>
                    New Excel file generated: <a href='$outputFile' class='font-semibold underline'>$outputFile</a>
                </div>
                <div class='tooltiptext2'>Click to download the format</div>      
                </div>      
            </div>";
    } else {
      echo "<script type='text/javascript'>alert('Invalid File');</script>";
    }
  }
  ?>

</body>

</html>


<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
