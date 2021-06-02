<?php

/*
  ConnectDB.php atbild par to, lai savienojums ar datubāzi būtu stabils
  attiecīgi, pirms katras ierakstu ievietošanas, tiek veikta pārbaude vai
  vispār savienojums eksistē, ja nē, tad tiek veikta pieslēgšanās.
*/

class Db
{
    // Pieslēgšanās vērtība ir konstanta
    protected static $connection;

    //Funkcija pieslēdzas datubāzei
    public function connect()
    {
        //Tiek pārbaudīts vai savienojums jau neeksistē
        if (!isset(self::$connection)) {

            //Pieslēgts config.ini fails ar datiem.
            $config = parse_ini_file('config.ini');
            //Tiek veitka pieslēgšanās
            //Izveidot savienojumu ar datubāzi
            self::$connection = new mysqli('localhost', $config['username'], $config['password']);
        }
        //Savienojums neizdevies
        if (self::$connection === false) {
            // Var pievienot arī savu kļūdas paziņojumu
            return false;
        }

        return self::$connection;
    }


    public function query($query)
    {

        $connection = $this->connect();

        // Tiek atgriezta datubāzes tekošā sitūacija - savienojums eksistē vai nē.
        $result = $connection->query($query);
        return $result;
    }


    //Izvēlas datubāzi pirms darba, bet ja tāda neeksistē, tad izveido.
    public function select_db($database)
    {
        $connection = $this->connect();
        $db_selected = $connection->select_db($database);
        if (!$db_selected) {
            // Create database
            $sql = "CREATE DATABASE $database";
            if ($this->query($sql) === TRUE) {
                echo "Datubāze veiksmīgi izveidota";
            }
        }
    }

    //Eksperimentāla funkcija, lai aizvērtu stmt savienojumu
    public function close()
    {
        $connection = $this->connect();
        $stmt->close();
    }


    /* Nedroša funkcija datu izgūšanai - pārtaisīt kaut kā ar prepared statement.
    public function select($query)
    {
        $rows = array();
        $result = $this->query($query);
        if ($result === false) {
            return false;
        }
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }
    */

    /* Eksperimentāla funkcija - kļūdas paziņojuma funkcija
    public function error()
    {
        $connection = $this->connect();
        return $connection->error;
    }
    */

    //Izveidot robotikas lietotāju tabulu ja tāda neeksistē.
    public function initializeAccounts()
    {
        $table = "CREATE TABLE IF NOT EXISTS accounts (
    -- Lietotāja unikālais ID
    ID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    -- Lietotājvārds
    Username VARCHAR(30) NOT NULL,
    -- Vārds
    Name VARCHAR(30) NOT NULL,
    -- Uzvārds
    Surname VARCHAR(30) NOT NULL,
    -- Epasts
    DateOfBirth DATE NOT NULL,
    -- Lietotāja loma/pieejas līmenis šajā interfeisā
    Residence VARCHAR(60) NOT NULL,
    -- Kad pēdējo reizi redzēts tiešsaistē
    Club VARCHAR(60) NOT NULL,
    -- Pēdējā veiktā darbība intefeisā
    Email VARCHAR(60) NOT NULL,
    -- Pēdējās veiktās darbības iemesls
    Password VARCHAR(50),
    -- Dalībnieka sacensību statuss
    Status VARCHAR(60) NOT NULL,
    
    Role VARCHAR(60) NOT NULL)";
        $result = $this->query($table);

        if ($result === false) {
            echo "Neizdevas izveidot kontu tabulu! Nepieciešama koda pārbaude!";
        }
    }
}
