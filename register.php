

<!DOCTYPE html>
<html lang="lv" dir="ltr">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/style/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap" rel="stylesheet">
		<script type="text/javascript" src="/js/checkCaps.js"></script>
    <title>PRČ</title>
</head>

<body>
	<!-- Satura apvalks -->
    <div class="content-wrapper">
			<!-- Autentifikācijas apvalks -->
        <div class="registration">

            <form class="registration-form" action="/functionality/registerUser.php" method="post">
							<!-- PRK logo -->
                <img src="/images/prk.png" alt="PRK logo">
								<!-- Sadālas nosaukum -->
                <h2>REĢISTRĀCIJA</h2>
								<!-- Lietotājvārds -->
                <input type="text" name="username" placeholder="Lietotājvārds" required>
								<!-- Parole -->
                <input type="password" name="password" id="myInput" placeholder="Parole" required>
                  <input type="text" name="name" id="myInput" placeholder="Vārds" required>
                    <input type="text" name="surname" id="myInput" placeholder="Uzvārds" required>
                      <input type="date" name="dateOfBirth" id="myInput" placeholder="Dzimšanas gads" required>
                        <input type="text" name="placeOfResidence" id="myInput" placeholder="Dzīvesvieta" required>
                          <input type="text" name="club" id="myInput" placeholder="Klubs" required>
                            <input type="text" name="email" id="myInput" placeholder="E=Pasts" required>
								<!-- URL konteineris priekš reģistrācijas un paroles atgriešanas -->

                  <a href="index.php" id="cancel">Atgriezties</a>

                <!-- Ielogošanās poga -->
                <button type="submit" name="button">REĢISTRĒTIES</button>

        </div>
        </form>
    </div>
</body>

</html>
