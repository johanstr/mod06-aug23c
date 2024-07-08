<?php
$errors_occured = false;

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
if(empty($firstname)) {
   setError('missing-firstname', 'Voornaam ontbreekt, vul deze a.u.b. in');
   $errors_occured = true;
}

if(empty($lastname)) {
   setError('missing-lastname', 'Achternaam ontbreekt, vul deze a.u.b. in');
   $errors_occured = true;
}

if(empty($street)) {
   setError('missing-street', 'Straatnaam ontbreekt, vul deze a.u.b. in');
   $errors_occured = true;
}

if(empty($house_number)) {
   setError('missing-number', 'Huisnummer ontbreekt, vul deze a.u.b. in');
   $errors_occured = true;
}

if(empty($zipcode)) {
   setError('missing-zipcode', 'Postcode ontbreekt, vul deze a.u.b. in');
   $errors_occured = true;
}

if(empty($city)) {
   setError('missing-city', 'Plaatsnaam ontbreekt, vul deze a.u.b. in');
   $errors_occured = true;
}

if(empty($email)) {
   setError('missing-email', 'Email ontbreekt, vul deze a.u.b. in');
   $errors_occured = true;
}

if(empty($password)) {
   setError('missing-password', 'Wachtwoord ontbreekt, vul deze a.u.b. in');
   $errors_occured = true;
}

if(empty($password_confirm)) {
   setError('missing-password-confirm', 'Wachtwoord herhaling ontbreekt, vul deze a.u.b. in');
   $errors_occured = true;
}

if($errors_occured) {
   setError('registration-error', 'Vul a.u.b. alle verplichte velden in');
   header('Location: ../../register.php');
   exit();
}

require_once '../Database/Database.php';

// STAP 4 & 9 - Controle of e-mail al in DB zit, ja dan redirect naar login met melding
$sql = "SELECT * FROM `customers` WHERE `email` = :email";
$placeholders = [':email' => $email];
Database::query($sql, $placeholders);
$customer = Database::get();

if(! empty($customer)) {
   setError('registration-error', 'E-mail adres bestaat al');
   header('Location: ../../login.php');
   exit();
}

// STAP 5 - Gegevens opslaan in DB, want we hebben niks gevonden in de database
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

setMessage('registration_success', 'U bent succesvol geregistreerd. Gebruik uw email en wachtwoord om in te loggen.');
header('Location: ../../index.php');
exit();
// TODO: STAP 6 & 7 - Verificatie mail sturen en redirecten naar index met melding (OPTIONEEL)

