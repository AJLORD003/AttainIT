<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IMPORT RECORDS</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="index.css">

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

if(isset($_SESSION['email'])){
  ?>
  <a href='main.php' class='text-xs underline font-semibold absolute ml-4 mt-[4rem] text-[#CCCDDE]'>
                  <i class='bi bi-arrow-left mr-1 text-[#CCCDDE]'></i>BACK TO OPTIONS
                </a>
  <div
  class="flex justify-center font-bold text-2xl pt-8 mt-12 text-[#CCCDDE]"
>
  TELL US SOME GENERAL DETAILS
</div>
<div    
  class="flex justify-center mt-2 text-md text-[#CCCDDE] opacity-60"
>
  This process is very short and simple, taking less than 5 minutes
  to complete
</div>
<div class="flex justify-center w-full mt-10 details-container">
  <form name = "coursedetails" action = "import.course.details.submit.php" method = "post" onsubmit = "return(validate())">
      <div class="format p-10 bg-gray-100">
      <div>
            <label class="block text-gray-400" for="Institute">Institute: </label>
            <select class="bg-white mt-2 border border-gray-200 text-gray-700 pl-2 rounded-md focus:outline-none focus:border-indigo-500 focus:shadow-outline-indigo" name="Institute" id="Institute"><br><br>
              <option value="-1" selected>Please Select An Institute</option>
              <option value="JAYPEE INSTITUTE OF INFORMATION TECHNOLOGY">JAYPEE INSTITUTE OF INFORMATION TECHNOLOGY</option>
            </select>
          </div>
      <div class="grid grid-cols-2 gap-12 mt-3">
          <div>    
              <label class="block text-gray-400" for="Semester">Semester: </label>

      <select name="Semester" id="Semester" class="bg-white mt-2 border border-gray-200 text-gray-700 pl-2 rounded-md focus:outline-none focus:border-indigo-500 focus:shadow-outline-indigo">
          <option value="-1" class="text-sm" selected>Please Select A Semester</option>
          <option value="1" class="text-sm">I</option>
          <option value="2" class="text-sm">II</option>
          <option value="3" class="text-sm">III</option>
          <option value="4" class="text-sm">IV</option>
          <option value="5" class="text-sm">V</option>
          <option value="6" class="text-sm">VI</option>
          <option value="7" class="text-sm">VII</option>
          <option value="8" class="text-sm">VIII</option>
          <option value="9" class="text-sm">IX</option>
          <option value="10" class="text-sm">X</option>
      </select>
      </div>

      <div>
          <label for="Branch" class="block text-gray-400">Branch: </label>
          <select name="Branch" id="Branch" class="bg-white border border-gray-200 mt-2 text-gray-700 pl-2 rounded-md focus:outline-none focus:border-indigo-500 focus:shadow-outline-indigo">
              <option value="-1" class="text-sm" selected>Please Select A Branch</option>
              <option value="CSE" class="text-sm">CSE</option>
              <option value="IT" class="text-sm">IT</option>
              <option value="ECE" class="text-sm">ECE</option>
              <option value="BT" class="text-sm">BT</option>
          </select>
      </div>
      </div>

      <div class="grid grid-cols-2 gap-12 mt-3">
          <div>
            <label class="block text-gray-400" for="NBACode">NBA Code:</label>
            <input type="text" id="NBACode" name="NBACode" placeholder="Enter NBA Code" class="border border-gray-200 mt-2 outline-blue-500 pl-2 text-gray-500 rounded-md h-8" required>
            </div>

            <div>
              <label class="block text-gray-400" for="CourseCode">Course Code:</label>
              <input type="text" id="CourseCode" name="CourseCode" placeholder="Enter Course Code" class="border border-gray-200 mt-2 outline-blue-500 pl-2 text-gray-500 rounded-md h-8" required>
              </div>
      </div>

      <div class="grid grid-cols-2 gap-12 mt-3">
          <div>
              <label for="AcademicYear" class="block text-gray-400 mt-3">Academic Year: </label>
              <input type="text" id="AcademicYear" name="AcademicYear" placeholder="Enter Academic Year" required class="border border-gray-200 mt-2 outline-blue-500 pl-2 text-gray-500 rounded-md h-8">     
          </div>
          <div>
              <label for="Event" class="block text-gray-400 mt-3">Choose an event:</label>
              <select id="Event" name="Event" size="1" class="bg-white border border-gray-200 mt-2 text-gray-700 pl-2 rounded-md focus:outline-none focus:border-indigo-500 focus:shadow-outline-indigo">
                  <option value='-1' class="text-sm" selected>Please Select An Event</option>
                  <option value="T1" class="text-sm">T1</option>
                  <option value="T2" class="text-sm">T2</option>
                  <option value="T3" class="text-sm">T3</option>
                  <option value="TA" class="text-sm">TA</option>
                  <option value="T1 T2 T3" class="text-sm">T1, T2 & T3</option>
                  <option value="T1 T2 T3 TA" class="text-sm">T1, T2, T3 & TA</option>
                  <option value="T1 T2 T3 TA CO" class="text-sm">All</option>
              </select>
          </div>
      </div>                                            

  </div>    
  <div class="flex mt-8 justify-center mb-4">
      <button
        class="font-semibold bg-white border-[1px] border-neutral-800 rounded-xl h-12 flex justify-center items-center text-lg w-60 slide-right hover:text-white hover:border-white"           
        type="submit" name="submit"
      >
        NEXT
      </button>
    </div>   
  </form>
  </div>

  <script type="text/javascript">
      var bgColors = [
              "linear-gradient(to right, #ff4b1f, #ff4b1f)",                             
          ],
          i = 0;
      function validate(){
          var Year = /^\d{4}-\d{2}$/
          var name = /^[A-Za-z/ ]+$/
          var NBA_Code = /^[A-Z]\d{3}-\d$/
          var Course_Code = /^[A-Z\d]+$/

          if(document.coursedetails.Institute.value == -1){
            Toastify({
                  text: "Please choose an Institute  ",
                  duration: 3000,
                  close: true,
                  style: {
                      background: bgColors[0],
                  }
              }).showToast(); 

                return false;
            }
        
          if (!document.coursedetails.AcademicYear.value.match(Year)) {
              Toastify({
                  text: "Academic Year should be of format: XXXX-XX  ",
                  duration: 3000,
                  close: true,
                  style: {
                      background: bgColors[0],
                  }
              }).showToast();    
             
              return false;
          }
          if(document.coursedetails.Semester.value == -1){
              Toastify({
                  text: "Please Choose a Semester  ",
                  duration: 3000,
                  close: true,
                  style: {
                      background: bgColors[0],
                  }
              }).showToast();                   
              return false;
          }
          if(document.coursedetails.Branch.value == -1){
              Toastify({
                  text: "Please Choose a Branch  ",
                  duration: 3000,
                  close: true,
                  style: {
                      background: bgColors[0],
                  }
              }).showToast();              
              return false;
          }
          
          if (!document.coursedetails.CourseCode.value.match(Course_Code)) {
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
          if(document.coursedetails.Event.value == '-1'){
              Toastify({
                  text: "Please Choose an Event  ",
                  duration: 3000,
                  close: true,
                  style: {
                      background: bgColors[0],
                  }
              }).showToast();                  
              return false;
          }

          return true
      }
    </script>
  <?php
}
?>    

</body>
</html>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>