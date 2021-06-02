<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="lv" dir="ltr">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/style/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap" rel="stylesheet">
    <!-- Izvēlnes animācijas skripts -->
    <script type="text/javascript" src="/js/openNav.js"></script>
    <title>PRČ</title>
</head>

<body>
    <!-- Satura apvalks -->
    <div class="content-wrapper">
        <!-- Slīdošā izvēlne -->
        <nav id="sideNavigation">
            <!-- X krusts, lai aizvērtu navigāciju -->
            <a href="javascript:void(0)" id="close" class="closebtn" onclick="closeNav()">&times;</a>
            <!-- PRK logo -->
            <img src="/images/prk.png" alt="PRK logo">
            <a href="/index.php">SĀKUMS</a>
            <a href="#">KARTE</a>
            <a href="#">PROGRAMMA</a>
            <a href="#">REZULTĀTI</a>
            <a href="#">NOTEIKUMI</a>
            <a href="#">INFORMĀCIJA</a>
            <a href="#">ANKETA</a>
            <a href="#">FOTO</a>
        </nav>
        <!-- Galvene -->
        <header>
            <div class="header-menu">
                <!-- Poga, lai izsauktu izvēlni -->
                <span onclick="openNav()">&#9776; PROFILS</span>
                <!-- Lietotāja profila konteineris -->
                <div class="header-profile">
                    <!-- Lietotāja profils -->
                    <a href="#">
                        <?php echo $_SESSION['name'] . " " . $_SESSION['surname'];  ?>
                    </a>
                    <!-- Izlogošanās -->
                    <a href="/functionality/logout.php">Izlogoties</a>
                </div>
            </div>


        </header>
        <!-- Profila konteineris -->
        <div class="main-profile-container">
            <!-- Profila bildes konteineris -->
            <div class="main-profile-picture">
                <!-- Profila bildes "Placeholder" -->
                <img src="/images/profile.png" alt="Profile picture placeholder">
            </div>
            <!-- Galvenā informācija par lietotāju -->
            <div class="main-profile-title">
                <!-- Vārds un Uzvārds -->
                <h1>
                    <?php echo $_SESSION['name'] . " " . $_SESSION['surname'] . " - " .  $_SESSION['username'];  ?>
                </h1>
                <!-- Klubs un pilsēta -->
                <p>
                    <?php echo $_SESSION['club'] ?> -
                    <?php echo $_SESSION['residence'] ?>
                </p>
                <!-- Informācija par lietotāju -->
                <div class="main-profile-information">
                    <label>Dzimšanas gads:</label>
                    <input type="text" name="" value="<?php echo $_SESSION['dateOfBirth'] ?>">
                    </br>
                    <label>Epasts:</label>
                    <input type="text" name="" value="<?php echo $_SESSION['email'] ?>">
                    </br>
                    <label>ID:</label>
                    <input type="text" name="" value="<?php echo $_SESSION['id'] ?>">
                    </br>
                    <label>Dalībnieka statuss:</label>
                    <input type="text" name="" value="<?php echo $_SESSION['status'] ?>">
                    </br>
                    <label>Loma:</label>
                    <input type="text" name="" value="<?php echo $_SESSION['role'] ?>">
                    </br>
                    <button>PIETEIKT TEHNISKO DISKVALIFIJĀCIJU</button>
                    </br>
                    <button>REĢISTRĒT ROBOTU</button>
                </div>
            </div>
        </div>

    </div>
</body>

</html>