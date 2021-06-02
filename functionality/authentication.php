<?php

/*
* authentication.php nodrošina lietotāja autentifikāciju pret datubāzi,
* verificējot jauktas(hashed) paroles sakritību ar datubāzi un ielādē
* sesijas superglobāļos informāciju par lietotāju turpmākām manipulācijām.
*/
session_start();

//Pieslēgts datubāzes objekta fails
include 'connectToDB.php';

//Izveidots datubāzes objekts un izveidots savienojums ar datubāzi.
$db = new Db();
$con = $db->connect();
if ($con->connect_error) {
    die("Savienojums neizdevās: " . $con->connect_error);
}
//Tiek izvēlēta robotistu datubāze, kā arī izveidota, ja neeksistē.
$db->select_db("robotists");

/*
  Validācija vai lietotājs ir nosūtījis lietotājvārdu un parolu uz serveri,
  tehniski, nevajadzētu šim būt iespējamam dēļ (required), bet papildus drošībai
  tika ielikts.
*/
if (!isset($_POST['username'], $_POST['password'])) {
    exit('Aizpildiet Lietotājvārda un Paroles ailes!');
}

/*
  Ar prepared statements izgūstam lietotāja informāciju no datubāzes, lai autentificētu
  lietotāju kā arī ievietot viņa informāciju iekš sesijas superglobāļa.
*/
if ($stmt = $con->prepare('SELECT ID, Password, Name, Surname, DateOfBirth, Residence, Club, Email, Status, Role FROM accounts WHERE Username = ?')) {

    //Saistām ievadīto lietotājvārdu pret datubāzi.
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
    //Saglabājam iegūtos rezultātus
    $stmt->store_result();

    /*
      Pārbaude vai rezultātu skaits ir lielāks par nulli, ja nulle, tad lietotājs neeksistē,
      vairāk par nulli - eksistē
    */
    if ($stmt->num_rows > 0) {
        //Pieprasām saglabātos mainīgos
        $stmt->bind_result($ID, $Password, $Name, $Surname, $DateOfBirth, $Residence, $Club, $Email, $Status, $Role);
        //Izgūstam mainīgos
        $stmt->fetch();
        /*
          Lai izvairītos, ka parole ievadīta ar tukšumu un netiktu jaukta(hashed)
          nepareiza secība, paroles superglobālis tiek tīrīts (trim).
        */
        $_POST['password'] = trim($_POST['password']);

        /*
          Jaukt ievadīto paroli ar noklusējuma jaukšanas algoritmu un auto ģenerētu "Sāli",
          jo jābūt pietiekami stipram HASH algoritmam kā arī auto ģenerēta "sāls" nav uzmināma.
        */
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        //Pārbaudīt vai paroles sakrīt/pareiza un to "Sāls" sakrīt arī.
        if (password_verify($_POST['password'], $password)) {

            //Autentifikācija veiksmīga - ģenerē sesijas id un saglabā datus sesijas superglobālī
            session_regenerate_id();
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $_POST['username'];
            $_SESSION['id'] = $ID;
            $_SESSION['name'] = $Name;
            $_SESSION['surname'] = $Surname;
            $_SESSION['dateOfBirth'] = $DateOfBirth;
            $_SESSION['residence'] = $Residence;
            $_SESSION['club'] = $Club;
            $_SESSION['email'] = $Email;
            $_SESSION['status'] = $Status;
            $_SESSION['role'] = $Role;
            //Doties uz galveno lapu
            header('Location:/main.php');
        } else {

            echo 'Nepareiza parole vai lietotājvārds';
        }
    } else {

        echo 'Nepareiza parole vai lietotājvārds';
    }

    //pārtraucam prepared statements.
    $stmt->close();
}
