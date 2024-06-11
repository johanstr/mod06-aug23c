<?php
session_start();

function hasMessage($name)
{
   if(isset($_SESSION['messages'][$name]))
      return true;

   return false;
}

function hasError($name)
{
   if(isset($_SESSION['errors'][$name]))
      return true;

   return false;
}

function getMessage($name)
{
   $message = '';
   if(isset($_SESSION['messages'][$name])) {
      $message = $_SESSION['messages'][$name];
      unset($_SESSION['messages'][$name]);
   }

   return $message;
}

function getError($name)
{
   $error = '';
   if(isset($_SESSION['errors'][$name])) {
      $error = $_SESSION['errors'][$name];
      unset($_SESSION['errors'][$name]);
   }

   return $error;
}