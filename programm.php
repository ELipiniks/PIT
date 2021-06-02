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
    <!-- Sli -->
    <nav id="sideNavigation">
        <!-- X krusts, lai aizvērtu navigāciju -->
        <a href="javascript:void(0)" id="close" class="closebtn" onclick="closeNav()">&times;</a>
        <!-- PRK logo -->
        <img src="/images/prk.png" alt="PRK logo">
        <!-- Navigācijā esošās saites -->
        <a href="main.php">SĀKUMS</a>
        <a href="map.php">KARTE</a>
        <a href="programm.php">PROGRAMMA</a>
        <a href="#">REZULTĀTI</a>
        <a href="#">NOTEIKUMI</a>
        <a href="#">INFORMĀCIJA</a>
        <a href="#">ANKETA</a>
        <a href="#">FOTO</a>
    </nav>
    <header>
        <!-- Navigācijas galvene -->
        <div class="header-menu">
            <!-- Poga, lai atvērtu navigāciju -->
            <span onclick="openNav()">&#9776; PROGRAMMA</span>
            <!-- Lietotāja profila un izlogošanās sadaļa -->
            <div class="header-profile">
                <!-- Profila saite -->
                <a href="/profile.php"><?php echo $_SESSION['name'] . " " . $_SESSION['surname']; ?></a>
                <!-- Izlogošanās sadaļa -->
                <a href="/functionality/logout.php">Izlogoties</a>
            </div>
        </div>
        <!-- Custom paziņojums -->
        <h2><?= $_SESSION['name'] ?>, Iepazīsties ar mūsu programmu!</h2>
    </header>
    <main>
      <iframe src="/images/PRC2020_norises_programma.pdf" width="100%" style="height:100%"></iframe>
    </main>

</div>
</body>
</html>
