<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>    
    <script src="https://cdn.tailwindcss.com"></script>  
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <style>
        .format {
            box-shadow: inset 5px 8px 8px rgba(0, 0, 0, .1), inset -2px -2px 10px hsla(0, 0%, 100%, .1);
            border-radius: 20px;
        }
    </style>

<script type="text/javascript">

        function validate(){   

            var bgColors = [
                "linear-gradient(to right, #ff4b1f, #ff4b1f)",                             
            ]

            if(document.contact_form.Name.value == ""){
                Toastify({
                    text: "Please fill your name  ",
                    duration: 3000,
                    close: true,
                    style: {
                        background: bgColors[0],
                    }
                }).showToast();
                return false;
            }   

            if(document.contact_form.email_id.value == ""){
                Toastify({
                    text: "Please fill your email  ",
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
</head>

<body>
    <section>
        <div class="flex justify-center font-bold text-2xl pt-8 text-black mt-8">
            CONTACT US
        </div>

        <div class="w-full flex justify-center mt-12">
            <form action="register.php" method="post" onsubmit="return(validate())" name="contact_form">
                <div class="bg-gray-100 format p-10">
                    <div class="flex gap-x-5"><label for="Name" class='block text-gray-400 mt-3'>Name: </label>
                    <input type="text" id="Name" name="Name" class='border border-gray-200 mt-2 outline-blue-500 pl-2 text-gray-500 rounded-md h-8' placeholder="Enter Name" required></div>    
                    
                    <div class="flex gap-x-5 mt-4"><label for="email_id" class='block text-gray-400 mt-3'>Email ID: </label>
                    <input type="email" id="email_id" name="email_id" class='border border-gray-200 mt-2 outline-blue-500 pl-2 text-gray-500 rounded-md h-8' placeholder="Enter Email ID" required></div>                   
                                        

                    <div class='mt-8 mb-1'>
                        <a href = "mailto:devrastogii280@gmail.com?subject=Query" class='font-semibold bg-white border-[1px] border-neutral-800 rounded-xl h-12 flex justify-center items-center text-lg w-full slide-right hover:text-white hover:border-white submit-btn' type="submit" name='submit'>
                            SEND EMAIL
                        </a>
                    </div>                   
                </div>
            </form>
        </div>
        <br>
    </section>

</body>
</html>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>