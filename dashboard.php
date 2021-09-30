<?php
if(!isset($_SESSION)) {
    session_start();
}

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
            Hello <?php if (isset($_SESSION["name"])) {
                        echo $_SESSION["name"];
                    } ?>, welcome to the dashboard
        <p>
    </header>




    <div>

        <p class="pText">Here you can see all the online users<p>

        <br>

        <div id="onlineList" class="onlineList">
        </div>
    </div>


    <!-- Modal -->
    <div id="myModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
            <div id="chosenUserInfo"></div>
        </div>

    </div>


    <script src="./js/dashboard.js?v=<?= filemtime('js/dashboard.js') ?>" type="text/javascript"></script>
    <script language=javascript>
        window.onload = generateOnlineSection()
    </script>


</body>

</html>