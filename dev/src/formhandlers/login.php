<?php

require_once '../auth/messages.php';

require_once "../Database/Database.php";

if($_SERVER['REQUEST_METHOD'] != 'POST') {
   header('Location: ../../login.php');
   exit();
}

// Ingetikte gegevens in vars
$errors_occured = false;
$email = htmlentities($_POST['email']);
$password = htmlentities($_POST['password']);

if(empty($email)) {
   $errors_occured = true;
   setError('missing-email', 'Email adres is verplicht.');
}

if(empty($password)) {
   $errors_occured = true;
   setError('missing-password', 'Wachtwoord is verplicht.');
}

if($errors_occured) {
   setError('credentials-error', 'Belangrijke gegevens ontbreken, vul deze a.u.b. in.');
   header('Location: ../../login.php');
   exit();
}

// Checken of email in DB zit
// Nee, ga naar register formulier
$sql = "SELECT * FROM customers WHERE email = :email";
$placeholders = array(':email' => $email);

Database::query($sql, $placeholders);
$customer = Database::get();

if(empty($customer)) {
   // Bericht in een sessie cookie
   setError('credentials-error', 'U bent blijkbaar nog niet als gebruiker geregistreerd. Registreer a.u.b.');
   header('Location: ../../register.php');
   exit();
}

// Controleren of wachtwoorden gelijk zijn
if(! password_verify($password, $customer['password'])) {
   // Waarschuwing in een sessie cookie
   setError('credentials-error', 'Onjuiste gegevens, probeer het a.u.b. nog eens.');
   header('Location: ../../login.php');
   exit();
}

// Sessie starten en customer data in sessie cookie
$_SESSION['customer'] = $customer;
unset($_SESSION['customer']['password']);

// Bericht in sessie cookie - succesvolle inlog
//$_SESSION['messages']['login_success'] = "U bne succesvol ingelogd.";
setMessage('login_success', 'U bent succesvol ingelogd');
// Ga naar startpagina
header('Location: ../../index.php');
