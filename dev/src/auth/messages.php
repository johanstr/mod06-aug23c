<?php
/**
 * Helper functions voor een message systeem
 * Functies:
 *    hasMessage, hasError    Controleren of een bepaalde message aanwezig is in de sessie array
 *    getMessage, getError    Geeft de tekst van de message terug en verwijdert deze uit de sessie array,
 *                            hierdoor wordt een message niet nog een tweede keer getoond
 *
 *    setMessage, setError
 *                            Deze functies moeten het makkelijker maken om messages en/of errors aan
 *                            de sessie array toe te voegen.
 *
 */
session_start();

/**
 * hasMessage
 * ----------
 * Controleer of een message met de naam $name in de sessie array aanwezig is
 *
 * @param string $name  De naam van de message (index van de sessie array)
 * @return bool         true: Message is aanwezig, false: niet gevonden
 */
function hasMessage(string $name): bool
{
   if(isset($_SESSION['messages'][$name]))
      return true;

   return false;
}

/**
 * hasError
 * ----------
 * Controleer of een error met de naam $name in de sessie array aanwezig is
 *
 * @param string $name  De naam van de error (index van de sessie array)
 * @return bool         true: Error is aanwezig, false: niet gevonden
 */
function hasError(string $name): bool
{
   if(isset($_SESSION['errors'][$name]))
      return true;

   return false;
}

/**
 * getMessage
 * ----------
 * Haal het bericht met de naam $name in de sessie array op en geef deze terug
 *
 * @param string $name              De naam van het bericht (index van de sessie array)
 * @param bool $removeFromMessages  Moet het bericht na het terugsturen ook verwijdert worden? Standaard is JA
 * @return string                   Het bericht
 */
function getMessage(string $name, bool $removeFromMessages = true): string
{
   $message = '';
   if(isset($_SESSION['messages'][$name])) {
      $message = $_SESSION['messages'][$name];

      if($removeFromMessages)
         unset($_SESSION['messages'][$name]);
   }

   return $message;
}

/**
 * getError
 * ----------
 * Haal de error met de naam $name in de sessie array op en geef deze terug
 *
 * @param string $name              De naam van de error (index van de sessie array)
 * @param bool $removeFromErrors    Moet de error na het terugsturen ook verwijdert worden? Standaard is JA
 * @return string                   De error
 */
function getError(string $name, bool $removeFromErrors = true): string
{
   $error = '';
   if(isset($_SESSION['errors'][$name])) {
      $error = $_SESSION['errors'][$name];

      if($removeFromErrors)
         unset($_SESSION['errors'][$name]);
   }

   return $error;
}

/**
 * setError
 * --------
 * Bewaar een error bericht in de sessie array op de juiste plek
 *
 * @param string $name
 * @param string $error_message
 * @return void
 */
function setError(string $name, string $error_message): void
{
   $_SESSION['errors'][$name] = $error_message;
}

/**
 * setMessage
 * ----------
 * Bewaar een bericht in de sessie array op de juiste plek
 *
 * @param string $name
 * @param string $message
 * @return void
 */
function setMessage(string $name, string $message): void
{
   $_SESSION['messages'][$name] = $message;
}