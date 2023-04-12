<?php

// Inicia el autocargador.
require_once 'ReCaptcha/autoload.php';


// Hay que registrar las claves API en https://www.google.com/recaptcha/admin
// Y copiarlas  
$siteKey = '6LfZlSETAAAAAC5VW4R4tQP8Am_to4bM3dddxkEt';
$secret = '6LfZlSETAAAAAOi4lh7GHcSOO0pbXnAMJRhnsr7O';

// reCAPTCHA admite más de 40 idiomas enumerados aquí: https://developers.google.com/recaptcha/docs/language
$lang = 'en';

// If No key
if ($siteKey === '' || $secret === ''):
  die('CPT001');
elseif (isset($_POST['g-recaptcha-response'])):

  // Si el envío del formulario incluye el campo "g-captcha-response"
  // Crea una instancia del servicio usando el pass
  $recaptcha = new \ReCaptcha\ReCaptcha($secret);

  // Realiza la llamada para verificar la respuesta y también pasa la dirección IP del usuario
  $resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);

  if ($resp->isSuccess()):
    // Si la respuesta es un éxito.
    die('CPT000');
  else:
    // Problemas
    die('CPT002');
  endif;

endif;
?>
