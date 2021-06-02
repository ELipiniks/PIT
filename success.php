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
  <!-- Satura apvalks -->
    <div class="content-wrapper">
      <!-- Paziņojums par veiksmīgu reģistrāciju -->
        <div class="notification">
          <!-- Prk logo -->
            <img src="/images/prk.png" alt="PRK logo">
            <!-- Custom paziņojums par veiksmīgu reģistrāciju -->
            <h2>Laipni lūgts,
                <?php echo $_GET['user']; ?>!
            </h2>
            <h3>Lai sāktu darboties - autentificējies!</h3>
            <!-- Poga atpakaļ uz autentifikāciju -->
            <form action="index.php">
                <input type="submit" value="AUTENTIFICĒTIES">
            </form>
        </div>
    </div>
</body>

</html>
