<?php

// STAP 1 & 8 - Is het een POST-request, nee dan redirect naar fout page (laatste is OPTIONEEL)
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
   // The request is using the POST method
   header('Location: ../../index.php');   // Geen fout page dus
   exit();
}
// STAP 2 - Ophalen ingetikte gegevens in vars en beveiligen
$firstname = htmlentities($_POST['firstname']);
$prefixes = htmlentities($_POST['prefixes']);
$lastname = htmlentities($_POST['lastname']);
$street = htmlentities($_POST['street']);
$house_number = htmlentities($_POST['housenumber']);
$addition = htmlentities($_POST['addition']);
$zipcode = htmlentities($_POST['zipcode']);
$city = htmlentities($_POST['city']);
$email = htmlentities($_POST['email']);
$password = $_POST['password'];
$password_confirm = $_POST['password_confirm'];

// TODO: STAP 3 - Controle op verplichte velden, redirecten als niet alles is ingevuld naar registratie met melding

// TODO: STAP 4 & 9 - Controle of e-mail al in DB zit, ja dan redirect naar registratie met melding

// STAP 5 - Gegevens opslaan in DB
require_once '../Database/Database.php';

$sql = "
   INSERT INTO `customers`(`firstname`, `prefixes`, `lastname`, `street`, `house_number`, `addition`, `zipcode`, `city`, `email`, `password`)
   VALUES(:firstname, :prefixes, :lastname, :street, :house_number, :addition, :zipcode, :city, :email, :password)
";
$placeholders = [
   ':firstname' => $firstname,
   ':prefixes' => $prefixes,
   ':lastname' => $lastname,
   ':street' => $street,
   ':house_number' => $house_number,
   ':addition' => $addition,
   ':zipcode' => $zipcode,
   ':city' => $city,
   ':email' => $email,
   ':password' => password_hash($password, PASSWORD_DEFAULT),
];
Database::query($sql, $placeholders);

header('Location: ../../index.php');
exit();
// TODO: STAP 6 & 7 - Verificatie mail sturen en redirecten naar index met melding (OPTIONEEL)

