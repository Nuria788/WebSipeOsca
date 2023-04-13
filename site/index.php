<?php
session_start();

// Configuración de la base de datos
$db_host = 'localhost';
$db_name = 'nombre_de_la_base_de_datos';
$db_user = 'nombre_de_usuario';
$db_pass = 'contraseña';

// Conexión a la base de datos
try {
  $db = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  echo 'Error al conectarse a la base de datos: ' . $e->getMessage();
  exit;
}

// Verifica si el usuario ha enviado el formulario de registro
if (isset($_POST['register'])) {
  // Recupera los datos enviados por el usuario
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  
  // Inserta al usuario en la base de datos
  try {
    $stmt = $db->prepare("INSERT INTO usuarios (username, email, password) VALUES (?, ?, ?)");
    $stmt->execute([$username, $email, $password]);
    $success = '¡Te has registrado exitosamente! Inicia sesión para continuar.';
  } catch(PDOException $e) {
    echo 'Error al registrar al usuario: ' . $e->getMessage();
    exit;
  }
}

// Verifica si el usuario ha enviado el formulario de inicio de sesión
if (isset($_POST['login'])) {
  // Recupera los datos enviados por el usuario
  $username = $_POST['username'];
  $password = $_POST['password'];
  
  // Busca al usuario en la base de datos
  try {
    $stmt = $db->prepare("SELECT * FROM usuarios WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();
  } catch(PDOException $e) {
    echo 'Error al buscar al usuario: ' . $e->getMessage();
    exit;
  }
  
  // Verifica si el usuario y la contraseña son correctos
  if ($user && password_verify($password, $user['password'])) {
    // Inicia la sesión y redirecciona al usuario a la página protegida
    $_SESSION['username'] = $username;
    header('Location: pagina_protegida.php');
    exit;
  } else {
    // Si el usuario y la contraseña no son correctos, muestra un mensaje de error
    $error = 'El nombre de usuario o la contraseña son incorrectos';
  }
}
?>

<!-- HTML del formulario de registro -->
<h2>Registro</h2>
<form method="post">
  <label for="username">Nombre de usuario:</label>
  <input type="text" id="username" name="username" required>

  <label for="email">Correo electrónico:</label>
  <input type="email" id="email" name="email" required>

  <label for="password">Contraseña:</label>
  <input type="password" id="password" name="password" required>

  <button type="submit" name="register">Registrarse</button>
</form>

<!-- HTML del formulario de inicio de sesión -->
<h2>Iniciar sesión</h2>
<form method="post">
  <label for="username">Nombre de usuario:</label>
  <input type="text" id="username" name="username
