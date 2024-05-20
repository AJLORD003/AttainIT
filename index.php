<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <link rel="stylesheet" href="/index.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <title>Attain IT</title>

  <style>
    .arrow-container {
  margin-top: 20px;
  animation: blink 1s infinite;
}

.arrow-down {
  animation: bounce 1s infinite;
  color: white;
  font-size: 2rem;
}

@keyframes bounce {
  0%,
  20%,
  50%,
  80%,
  100% {
    transform: translateY(0);
  }
  40% {
    transform: translateY(-10px);
  }
  60% {
    transform: translateY(-5px);
  }
}

@keyframes blink {
  0%,
  100% {
    opacity: 1;
  }
  50% {
    opacity: 0;
  }
}
    .g-border {
  border: 3px solid rgba(255,255,255,0.1);  
  background-color: rgba(0, 0, 0, 0.2);
}
    body {
      background-color: #05051e;
    }

    html {
      scroll-behavior: smooth;
    }

    .sign-shadow:hover {
  box-shadow: white 0px 1px 4px 0px;
}

    .gradient-text {
      background: linear-gradient(45deg, #ab7cef, #fe92b2, #aa8360);
      -webkit-background-clip: text;
      color: transparent;
    }
  </style>
</head>

<body>
  <!-- Navbar -->

  <?php if (isset($_SESSION['toast'])) { ?> <div id="show"><?= $_SESSION['toast']; ?></div> <?php } ?>
  <?php
  session_start();
  ?>

  <!-- <section> -->

  <section class="w-full bg-img">

    <div class="w-full px-10 p-5 overflow-hidden transition-all duration-500 h-auto bg-[#070720] border border-b-[#1D1E37] border-t-0 border-l-0 border-r-0 z-10">
      <div class="flex justify-between items-center">
        <a href="/" class="flex gap-x-3">
          <div>
            <i class="bi bi-record-circle-fill text-indigo-500 text-lg"></i>
          </div>
          <div class="font-semibold leading-normal tracking-wide text-lg text-[#9296AD]">
            ATTAIN IT
          </div>
        </a>
        <div class="flex gap-x-8 nav items-center auth">
          <?php if (isset($_SESSION['email'])) { ?>
            <button id="logoutBtn" class="font-semibold border-[1px] border-[#202139] rounded-xl hover:text-white h-10 flex justify-center items-center text-md w-40 slide-right text-[#9296AD] bg-gradient-to-r from-[#0C0C25] to-[#1C1D36] sign-shadow transition-all duration-300">LOGOUT</a>
        </div>
      <?php } else { ?>
        <div >
          <a href="user.login.php" class="font-semibold border-[1px] border-[#202139] rounded-xl hover:text-white h-10 flex justify-center items-center text-md w-40 slide-right text-[#9296AD] bg-gradient-to-r from-[#0C0C25] to-[#1C1D36] sign-shadow transition-all duration-300">LOGIN</a>      
        </div>
        <div>
          <a href="user.register.php" class="font-semibold border-[1px] border-[#202139] rounded-xl hover:text-white h-10 flex justify-center items-center text-md w-40 slide-right text-[#9296AD] bg-gradient-to-r from-[#0C0C25] to-[#1C1D36] sign-shadow transition-all duration-300">
            SIGN UP
          </a>     
        </div>
      <?php } ?>
      </div>
    </div>
    </div>
  </section>

  <section class="w-full min-h-[40vh] mt-20 flex justify-center items-center flex-col pt-1 px-40 pb-20 border border-b-[#1D1E37] border-t-0 border-l-0 border-r-0">
    <div class="text-center intro-text">
      <div class="uppercase text-[#CCCDDE] text-[3.5rem] font-bold">
        Comprehensive Solution
      </div>
      <div class="uppercase gradient-text text-[3rem] font-bold">
        For goal achievement
      </div>
      <div class="text-[#9B9FB6] text-sx mt-5">
        Streamlining students performance and result calculation for
        teachers
      </div>
    </div>
    <div class="flex justify-center flex-col items-center mt-5 explore">
      <a href="#working" class="font-semibold border-[1px] border-[#202139] rounded-xl hover:text-white h-10 flex justify-center items-center text-md w-40 slide-right text-[#9296AD] bg-gradient-to-r from-[#0C0C25] to-[#1C1D36] sign-shadow transition-all duration-300 mt-3">
        EXPLORE NOW
      </a>
      <div class="arrow-container explore mt-5 text-[1.2rem]">
        <div>
          <a href="#working" smooth>
            <i class="bi bi-chevron-double-down arrow-down text-white"></i>
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- How it Works -->

  <section id="working" class="min-h-[40vh] p-20 pt-24 border border-b-[#1D1E37] border-t-0 border-l-0 border-r-0">
    <div class="uppercase font-bold gradient-text text-[1.8rem]">What we provide</div>

    <div class="flex gap-x-10 mt-16">

    <div>
      <div class="w-[14rem] h-[14rem] flex flex-col p-3 px-5 justify-center hover:border-indigo-400 text-[#CCCDDE] transition-all duration-500 hover:text-white rounded-lg g-border">
        <div class="w-12 h-12 rounded-full bg-indigo-400 flex justify-center items-center">
          <i class="bi bi-calculator text-white text-3xl"></i>
        </div>
        <div class="font-semibold mt-3">Easy</div>
        <div class="font-semibold">Calculations</div>
        <div class="text-xs opacity-80 mt-2">
          We calculate every complex result for you
        </div>
      </div>
    </div>

    <div>

      <div class="w-[14rem] h-[14rem] flex flex-col p-3 px-5 justify-center hover:border-orange-400 text-[#CCCDDE] transition-all duration-500 hover:text-white rounded-lg g-border">
            <div class="w-12 h-12 rounded-full bg-orange-400 flex justify-center items-center">
              <i class="bi bi-calculator text-white text-3xl"></i>
            </div>
            <div class="font-semibold mt-3">Report</div>
            <div class="font-semibold">Generation</div>
            <div class="text-xs opacity-80 mt-2">
              We provide you the final report of events
            </div>
          </div>
          </div>

    <div>

          <div class="w-[14rem] h-[14rem] flex flex-col p-3 px-5 justify-center hover:border-green-400 text-[#CCCDDE] transition-all duration-500 hover:text-white rounded-lg g-border">
            <div class="w-12 h-12 rounded-full bg-green-400 flex justify-center items-center">
              <i class="bi bi-calculator text-white text-3xl"></i>
            </div>
            <div class="font-semibold mt-3">Simple</div>
            <div class="font-semibold">User Journey</div>
            <div class="text-xs opacity-80 mt-2">
              It's really simple to surf the website
            </div>
          </div>
    </div>
    <div>

          <div class="w-[14rem] h-[14rem] rounded-lg flex flex-col p-3 px-5 justify-center hover:border-red-400 text-[#CCCDDE] transition-all duration-500 hover:text-white g-border">
            <div class="w-12 h-12 rounded-full bg-red-400 flex justify-center items-center">
              <i class="bi bi-calculator text-white text-3xl"></i>
            </div>
            <div class="font-semibold mt-3">Data</div>
            <div class="font-semibold">Visualization</div>
            <div class="text-xs opacity-80 mt-2">
              Easy Visualizations through beautiful charts
            </div>
          </div>
    </div>
    </div>

    <div class='flex justify-center flex-col items-center mt-12'>          
                <a href="main.php"
                  class="font-semibold border-[1px] border-[#202139] rounded-xl hover:text-white h-10 flex justify-center items-center text-md w-40 slide-right text-[#9296AD] bg-gradient-to-r from-[#0C0C25] to-[#1C1D36] sign-shadow transition-all duration-300 mt-3"
                > TRY NOW <span class="ml-2"><i class="bi bi-arrow-right"></i></span></a>               
                </div> 

  </section>

  <section class="mt-36 h-[80vh] team transition-all duration-1000">
    <div class="pt-10 lg:text-3xl font-bold flex justify-center text-white">Meet Our Team</div>
    <div class="opacity-70 lg:text-md mt-4 text-white flex justify-center">
      Collaborating to turn visions into reality, we are dedicated in delivering excellence in every project
    </div>

    <div class="flex justify-evenly mt-20 team-div">
      <div class="flex flex-col bg-white drop-shadow-2xl h-[10rem] w-[18rem] relative">
        <div class="absolute -top-[25%] left-[37%] w-[5rem] h-[5rem]">
          <img src="images\me.jpg" alt="me" class="rounded-xl" />
        </div>
        <div class="flex flex-col mt-20 justify-center items-center">
          <div class="font-semibold">Dev Rastogi</div>
          <div>Frontend & Integration</div>
        </div>
      </div>
      <div class="flex flex-col bg-white drop-shadow-2xl h-[10rem] w-[18rem] relative">
        <div class="absolute -top-[25%] left-[37%] w-[5rem] h-[5rem]">
          <img src="images/ankush.jpg" alt="ankush" class="rounded-xl" />
        </div>
        <div class="flex flex-col mt-20 justify-center items-center">
          <div class="font-semibold">Ankush Kumar</div>
          <div>Backend</div>
        </div>
      </div>
      <div class="flex flex-col bg-white drop-shadow-2xl h-[10rem] w-[18rem] relative">
        <div class="absolute -top-[25%] left-[37%] w-[5rem] h-[5rem]">
          <img src="images/jain.jpg" alt="aditya" class="rounded-xl" />
        </div>
        <div class="flex flex-col mt-20 justify-center items-center">
          <div class="font-semibold">Aditya Jain</div>
          <div>Backend</div>
        </div>
      </div>
    </div>
  </section>
  </section>




  <script>
    window.onscroll = function() {
      const scrollPosition = window.scrollY;
      var nav = document.querySelector('.navbar')
      var team = document.querySelector('.team')
      var team_div = document.querySelector('.team-div')
      console.log(scrollPosition);

      if (scrollPosition > 120) {
        nav.classList.add('bg-neutral-800', 'text-white');
      }

      if (scrollPosition > 1298) {
        team.classList.add('bg-neutral-800', 'text-white');
        team_div.classList.add('text-black');
      }

      if (scrollPosition <= 120 && scrollPosition <= 1298) {
        nav.classList.remove('bg-neutral-800', 'text-white');
        team.classList.remove('bg-neutral-800', 'text-white');
      }


    };

    document.getElementById('logoutBtn').addEventListener('click', function() {
      axios.post('logout.php')
        .then(response => {
          const data = response.data;
          if (data.status === 'success') {
            window.location.href = 'index.php';
          } else {
            Toastify({
              text: data.message,
              duration: 3000,
              close: true,
            }).showToast();
          }
        })
        .catch(error => {
          console.error('Error:', error);
        });
    });
  </script>  

</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>

</html>