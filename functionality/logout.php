<?php
session_start();
//Pārtraukt lietotāja sesiju
session_destroy();
// un nosūtīt uz autentifikācijas lapu
header('Location: /index.php');
?>
