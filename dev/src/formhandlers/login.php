<?php

session_start();

require_once "../Database/Database.php";

if($_SERVER['REQUEST_METHOD'] != 'POST') {
   header('Location: ../../login.php');
   exit();
}

// Ingetikte gegevens in vars
$email = htmlentities($_POST['email']);
$password = htmlentities($_POST['password']);

// Checken of email in DB zit
// Nee, ga naar register formulier
$sql = "SELECT * FROM customers WHERE email = :email";
$placeholders = array(':email' => $email);

Database::query($sql, $placeholders);
$customer = Database::get();

if(empty($customer)) {
   // TODO: Bericht in een sessie cookie
   header('Location: ../../register.php');
   exit();
}

// Controleren of wachtwoorden gelijk zijn
// TODO: Ga naar login formulier met foutmelding
if(! password_verify($password, $customer['password'])) {
   // TODO: Waarschuwing in een sessie cookie
   header('Location: ../../login.php');
   exit();
}

// Sessie starten en customer data in sessie cookie
$_SESSION['customer'] = $customer;
unset($_SESSION['customer']['password']);

// TODO: Bericht in sessie cookie - succesvolle inlog
$_SESSION['messages']['login_success'] = "U bne succesvol ingelogd.";
// Ga naar startpagina
header('Location: ../../index.php');
