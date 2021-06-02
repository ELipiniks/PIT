<?php

session_start();
/*
	Ja lietototājam ir 'loggedin'==true, tad sūtām uz galveno lapu, lai ja nejaušām
	tiek uz index.php nav atkal jaautentificējas.
*/
if (isset($_SESSION['loggedin'])) {
	header('Location: main.php');
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
    <title>PRČ</title>
</head>

<body>
    <div class="content-wrapper">
        <div class="page-error">
            <h1>Ups, šī sadaļa vēl taps, piedod, pagaidām jātrenē atmiņa atcerēties! ;) </h1>
            <a href="index.php">Atpakaļ</a>
        </div>
    </div>
</body>

</html>
