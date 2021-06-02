<?php

/*
* registerUser.php iegūst lietotāja ievadītos datus, apstrādā tos, validē, šifrē
* un ieraksta lietotāju datubāzē.
*/

//Atkļūdošanas nolūkos atkomentēt
#error_reporting(E_ALL);
#ini_set('error_reporting', E_ALL);
#ini_set('display_errors', 'on');

//Pieslēgts datubāzes objekta fails
include 'connectToDB.php';


//Izveidots datubāzes objekts un izveidots savienojums ar datubāzi.
$db = new Db();
$con = $db->connect();
if ($con->connect_error) {
    die("Savienojums neizdevās: " . $con->connect_error);
}

//Tiek izvēlēta robotikas datubāze, kā arī izveidota, ja neeksistē.
$db->select_db("robotists");

//Validācija vai eksistē lietotāju kontu tabula. Ja neeksistē - izveido.
$db->initializeAccounts();


/*
  Validācija vai lietotājs patiešām ir nosūtījs savu informāciju reģistrējoties,
  tehniski tam nav jābūt iespējami, bet
  "FailSafe" drošības nolūkos tiek pārbaudīts.
*/
if (!isset($_POST['username'], $_POST['name'], $_POST['surname'], $_POST['dateOfBirth'], $_POST['placeOfResidence'], $_POST['club'], $_POST['email'], $_POST['password'])) {
    exit('Lūdzu aizpildiet visas ailes!');
}

//Validācija vai ievadītās vērtības nav tukšumi
if (
    empty($_POST['username']) || empty($_POST['name']) || empty($_POST['surname']) || empty($_POST['dateOfBirth']) || empty($_POST['placeOfResidence']) || empty($_POST['club']) || empty($_POST['email']) ||
    empty($_POST['password'])
) {
    exit('Lūdzu nesūtiet tukšas vērtības');
}

if (preg_match('/^[a-zA-Z0-9]+$/', $_POST['username']) == 0) {
    exit('LLietotājvārds ir nepareiza formāta - Atļautie simboli: a-z/A-Z/0-9');
}

if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    exit('Epasts nav pareiza formāta!');
}
if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
    exit('Parole nedrīkst būt īsāka par 5 un garāka par 20 simboliem.');
}
//Pārbaude pret datubāzi vai lietotājs jau eksistē
if ($stmt = $con->prepare('SELECT ID, Password FROM accounts WHERE Username = ?')) {
    //Saistām lietotājvārdu pret datubāzi.
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
    //Saglabājam iegūtos rezultātus
    $stmt->store_result();
    /*
        Pārbaude vai rezultātu ir vairāk par nulli, ja ir, tad konts jau eksistē,
        pretēji - neeksistē un turpināt reģistrāciju.
      */
    if ($stmt->num_rows > 0) {
        //Lietotājs jau eksistē
        echo 'Lietotājvārds ir aizņemts, lūdzu, izvēlieties citu.';
    } else {
        //Lietotājs neeksistē - reģistrēt.
        //Sagatavojam prepared statement, norādot, ko mēs vēlamies ierakstīt datubāzē
        if ($stmt = $con->prepare('INSERT INTO accounts (Username, Name, Surname, DateOfBirth, Residence, Club, Email, Password, Status, Role) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)')) {

            /*
              Lai izvairītos, ka parole ievadīta ar tukšumu un netiktu jaukta(hashed)
              nepareiza secība, paroles superglobālis tiek tīrīts (trim).
            */
            $password = trim($_POST['password']);
            /*
              Jaukt ievadīto paroli ar noklusējuma jaukšanas algoritmu un auto ģenerētu "Sāli",
              jo jābūt pietiekami stipram HASH algoritmam kā arī auto ģenerēta "sāls" nav uzmināma.
            */
            $status = 'Neapstiprināts';
            $role = 'Viesis';
            //Veikt jauna ieraksta pievienošanu iekš lietotāju tabulas datubāzē.
            $stmt->bind_param('ssssssssss', $_POST['username'], $_POST['name'], $_POST['surname'], $_POST['dateOfBirth'], $_POST['placeOfResidence'], $_POST['club'], $_POST['email'], $password, $status, $role);
            $stmt->execute();
            //Veiksmīgi ierakstot datubāže sūtam uz "izdevies" lapu kopā ar lietotāja vārdu.
            header('Location:/success.php?user=' . $_POST['name']);
        } else {
            //Paziņot, ka neizdevās ierakstīt datubāzē.
            echo 'Neizdevās sagatavot 2. vaicājumu!';   
        }
    }
    $stmt->close();
} else {
    //Paziņot, ka neizdevās ierakstīt datubāzē.
    echo 'Neizdevās sagatavot 1. vaicājumu';
}
$con->close();
