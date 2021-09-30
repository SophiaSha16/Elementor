<?php
session_start();


?>

<html>

<head>
    <meta charset="UTF-8" />
    <title>Welcome to user live dashboard</title>
    <link rel="stylesheet" href="css/style.css" />

</head>





<body>
    
    <header>
        <p class="pageTitle">
            Welcome to the live users dashboard, <br> 
            please login to acsess the dashboard
        <p>
    </header>


    <main>
        <!-- todo validation on empty input -->
        <form action="./api/userLogin.php" method="POST" novalidate="" name="" class="loginForm" id="">
            <div>
                <p class="pText">Enter your name and email<p>
            </div>

            <div class="loginDiv">
                <div class="inputs">
                    <div class="inputDiv">
                        <label for="name" class="inputLabel">Name:</label>
                        <input type="text" name="name" placeholder="" required="" class="name">
                    </div>

                    <div class="inputDiv">
                        <label for="email" class="inputLabel">Email:</label>
                        <input type="text" name="email" placeholder="" required="">
                    </div>
                </div>

                <button type="submit" class="btn">
                    Enter
                </button>
            </div>
        </form>


    </main>


    <script src="./js/main.js?v=<?= filemtime('js/main.js') ?>" type="text/javascript"></script>

</body>

</html>