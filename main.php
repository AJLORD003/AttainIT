<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Options</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <link rel="stylesheet" href="index.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
</head>

<style>
  body {
      background-color: #05051e;
    }

  .sign-shadow:hover {
  box-shadow: white 0px 1px 4px 0px;
}

.option-btn-1 {
  --borderWidth: 3px;
  background: #1d1f20;
  position: relative;
  border-radius: var(--borderWidth);
}

.option-btn-1:after {
  content: "";
  position: absolute;
  top: calc(-1 * var(--borderWidth));
  left: calc(-1 * var(--borderWidth));
  height: calc(100% + var(--borderWidth) * 2);
  width: calc(100% + var(--borderWidth) * 2);
  background: linear-gradient(
    60deg,
    #f79533,
    #f37055,
    #ef4e7b,
    #a166ab,
    #5073b8,
    #1098ad,
    #07b39b,
    #6fba82
  );
  border-radius: calc(2 * var(--borderWidth));
  z-index: -1;
  animation: animatedgradient 3s ease alternate infinite;
  background-size: 300% 300%;
}

@keyframes animatedgradient {
  0% {
    background-position: 0% 50%;
  }
  50% {
    background-position: 100% 50%;
  }
  100% {
    background-position: 0% 50%;
  }
}

</style>

<body>

  <?php
  session_start();

  if (isset($_SESSION['email'])) {
  ?>

    <section class="h-screen w-full">

    <a href='index.php' class='text-xs underline font-semibold absolute ml-4 mt-[4rem] text-[#CCCDDE]'>
            <i class='bi bi-arrow-left mr-1'></i>HOME PAGE
        </a>

        <div class="flex justify-center font-bold text-2xl pt-8 text-[#CCCDDE]">
      WHAT DO YOU WANT TO DO
    </div>

      <div class="flex mt-20 justify-center gap-10 items-center flex-wrap">

      <a href="import.course.php" class="w-[24rem] min-h-[15rem] cursor-pointer border-[#CCCDDE] rounded-lg flex flex-col option-btn-1 p-4 sign-shadow">
      <div class='text-sm w-8 h-8 text-white border font-bold rounded-full flex justify-center items-center'>1</div>
      <div class='p-4 mt-2'>                           
              <div>
              <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-book-fill text-[#CCCDDE]" viewBox="0 0 16 16">
  <path d="M8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783"/>
</svg>
              </div>

              <div class="mt-4 font-semibold text-xl text-[#CCCDDE]">
                New Course
              </div>   
              <div class='text-[#CCCDDE] text-xs mt-2'>Empower teachers to seamlessly integrate new courses into the system with ease.</div>    
      </div>       
            </a>            
          <!-- </a> -->
        <!-- </div> -->

        <a href=".\word_documents\cd_form.php" class="w-[24rem] min-h-[15rem] cursor-pointer border-[#CCCDDE] rounded-lg flex flex-col option-btn-1 p-4 sign-shadow">
      <div class='text-sm w-8 h-8 text-white border font-bold rounded-full flex justify-center items-center'>2</div>
      <div class='p-4 mt-2'>                           
              <div>
              <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-file-earmark-word-fill text-[#CCCDDE]" viewBox="0 0 16 16">
  <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0M9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1M5.485 6.879l1.036 4.144.997-3.655a.5.5 0 0 1 .964 0l.997 3.655 1.036-4.144a.5.5 0 0 1 .97.242l-1.5 6a.5.5 0 0 1-.967.01L8 9.402l-1.018 3.73a.5.5 0 0 1-.967-.01l-1.5-6a.5.5 0 1 1 .97-.242z"/>
</svg>
              </div>

              <div class="mt-4 font-semibold text-xl text-[#CCCDDE]">
                Course Description
              </div>   
              <div class='text-[#CCCDDE] text-xs mt-2'>Empower teachers to seamlessly integrate new courses into the system with ease.</div>    
      </div>       
            </a>  

            
            <a href=".\word_documents\opening_ask.php" class="w-[24rem] min-h-[15rem] cursor-pointer border-[#CCCDDE] rounded-lg flex flex-col option-btn-1 p-4 sign-shadow">
      <div class='text-sm w-8 h-8 text-white border font-bold rounded-full flex justify-center items-center'>3</div>
      <div class='p-4 mt-2'>                           
              <div>
              <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-file-earmark-word-fill text-[#CCCDDE]" viewBox="0 0 16 16">
  <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0M9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1M5.485 6.879l1.036 4.144.997-3.655a.5.5 0 0 1 .964 0l.997 3.655 1.036-4.144a.5.5 0 0 1 .97.242l-1.5 6a.5.5 0 0 1-.967.01L8 9.402l-1.018 3.73a.5.5 0 0 1-.967-.01l-1.5-6a.5.5 0 1 1 .97-.242z"/>
</svg>
              </div>

              <div class="mt-4 font-semibold text-xl text-[#CCCDDE]">
              Opening Report
              </div>   
              <div class='text-[#CCCDDE] text-xs mt-2'>Empower teachers to seamlessly integrate new courses into the system with ease.</div>    
      </div>       
            </a>   
         
        <a href="export.event.php" class="w-[24rem] min-h-[15rem] cursor-pointer border-[#CCCDDE] rounded-lg flex flex-col option-btn-1 p-4 sign-shadow">
      <div class='text-sm w-8 h-8 text-white border font-bold rounded-full flex justify-center items-center'>4</div>
      <div class='p-4 mt-2'>                           
              <div>
              <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-cloud-arrow-down-fill text-[#CCCDDE]" viewBox="0 0 16 16">
  <path d="M8 2a5.53 5.53 0 0 0-3.594 1.342c-.766.66-1.321 1.52-1.464 2.383C1.266 6.095 0 7.555 0 9.318 0 11.366 1.708 13 3.781 13h8.906C14.502 13 16 11.57 16 9.773c0-1.636-1.242-2.969-2.834-3.194C12.923 3.999 10.69 2 8 2m2.354 6.854-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 1 1 .708-.708L7.5 9.293V5.5a.5.5 0 0 1 1 0v3.793l1.146-1.147a.5.5 0 0 1 .708.708"/>
</svg>
              </div>

              <div class="mt-4 font-semibold text-xl text-[#CCCDDE]">
              Download Format
              </div>   
              <div class='text-[#CCCDDE] text-xs mt-2'>Empower users with seamless Excel file generation and download for enhanced data management</div>    
      </div>       
            </a>   

            <a href="import.course.details.php" class="w-[24rem] min-h-[15rem] cursor-pointer border-[#CCCDDE] rounded-lg flex flex-col option-btn-1 p-4 sign-shadow">
      <div class='text-sm w-8 h-8 text-white border font-bold rounded-full flex justify-center items-center'>5</div>
      <div class='p-4 mt-2'>                           
              <div>
              <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-cloud-arrow-up-fill text-[#CCCDDE]" viewBox="0 0 16 16">
  <path d="M8 2a5.53 5.53 0 0 0-3.594 1.342c-.766.66-1.321 1.52-1.464 2.383C1.266 6.095 0 7.555 0 9.318 0 11.366 1.708 13 3.781 13h8.906C14.502 13 16 11.57 16 9.773c0-1.636-1.242-2.969-2.834-3.194C12.923 3.999 10.69 2 8 2m2.354 5.146a.5.5 0 0 1-.708.708L8.5 6.707V10.5a.5.5 0 0 1-1 0V6.707L6.354 7.854a.5.5 0 1 1-.708-.708l2-2a.5.5 0 0 1 .708 0z"/>
</svg>
</svg>
              </div>

              <div class="mt-4 font-semibold text-xl text-[#CCCDDE]">
              Upload Data
              </div>   
              <div class='text-[#CCCDDE] text-xs mt-2'>Simplify data input by enabling users to upload Excel files for efficient marks calculation</div>    
      </div>       
            </a>  
            
                 
            
            <a href="download.report.details.php" class="w-[24rem] min-h-[15rem] cursor-pointer border-[#CCCDDE] rounded-lg flex flex-col option-btn-1 p-4 sign-shadow">
      <div class='text-sm w-8 h-8 text-white border font-bold rounded-full flex justify-center items-center'>6</div>
      <div class='p-4 mt-2'>                           
              <div>
              <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-cloud-arrow-down-fill text-[#CCCDDE]" viewBox="0 0 16 16">
  <path d="M8 2a5.53 5.53 0 0 0-3.594 1.342c-.766.66-1.321 1.52-1.464 2.383C1.266 6.095 0 7.555 0 9.318 0 11.366 1.708 13 3.781 13h8.906C14.502 13 16 11.57 16 9.773c0-1.636-1.242-2.969-2.834-3.194C12.923 3.999 10.69 2 8 2m2.354 6.854-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 1 1 .708-.708L7.5 9.293V5.5a.5.5 0 0 1 1 0v3.793l1.146-1.147a.5.5 0 0 1 .708.708"/>
</svg>
</svg>
              </div>

              <div class="mt-4 font-semibold text-xl text-[#CCCDDE]">
              Attainment Report
              </div>   
              <div class='text-[#CCCDDE] text-xs mt-2'>Effortlessly download files in Excel and PDF formats for convenient data access and sharing</div>    
      </div>       
            </a> 
        
            <a href=".\word_documents\assessmenttool.php" class="w-[24rem] min-h-[15rem] cursor-pointer border-[#CCCDDE] rounded-lg flex flex-col option-btn-1 p-4 sign-shadow">
      <div class='text-sm w-8 h-8 text-white border font-bold rounded-full flex justify-center items-center'>7</div>
      <div class='p-4 mt-2'>                           
              <div>
              <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-file-earmark-word-fill text-[#CCCDDE]" viewBox="0 0 16 16">
  <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0M9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1M5.485 6.879l1.036 4.144.997-3.655a.5.5 0 0 1 .964 0l.997 3.655 1.036-4.144a.5.5 0 0 1 .97.242l-1.5 6a.5.5 0 0 1-.967.01L8 9.402l-1.018 3.73a.5.5 0 0 1-.967-.01l-1.5-6a.5.5 0 1 1 .97-.242z"/>
</svg>
</svg>
              </div>

              <div class="mt-4 font-semibold text-xl text-[#CCCDDE]">
                Assessment Tools
              </div>   
              <div class='text-[#CCCDDE] text-xs mt-2'>Empower teachers to seamlessly integrate new courses into the system with ease.</div>    
      </div>       
            </a>     

              
             

            <a href=".\word_documents\closing_ask.php" class="w-[24rem] min-h-[15rem] cursor-pointer border-[#CCCDDE] rounded-lg flex flex-col option-btn-1 p-4 sign-shadow">
      <div class='text-sm w-8 h-8 text-white border font-bold rounded-full flex justify-center items-center'>8</div>
      <div class='p-4 mt-2'>                           
              <div>
              <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-file-earmark-word-fill text-[#CCCDDE]" viewBox="0 0 16 16">
  <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0M9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1M5.485 6.879l1.036 4.144.997-3.655a.5.5 0 0 1 .964 0l.997 3.655 1.036-4.144a.5.5 0 0 1 .97.242l-1.5 6a.5.5 0 0 1-.967.01L8 9.402l-1.018 3.73a.5.5 0 0 1-.967-.01l-1.5-6a.5.5 0 1 1 .97-.242z"/>
</svg>
              </div>

              <div class="mt-4 font-semibold text-xl text-[#CCCDDE]">
              Closing Report
              </div>   
              <div class='text-[#CCCDDE] text-xs mt-2'>Empower teachers to seamlessly integrate new courses into the system with ease.</div>    
      </div>       
            </a>   

      </div>
      
        <div class="absolute right-[2rem] top-10"><div class='tooltip2'><a href="help.php" class="text-white"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle-fill hover:text-indigo-500 cursor-pointer" viewBox="0 0 16 16">
            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2" />
          </svg></a><div class='text-white'>Need Help?</div></div>          
      </div>
    </section>

  <?php
  } else {
    header("Location: user.login.php");
  }

  ?>

</body>

</html>