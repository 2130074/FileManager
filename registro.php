<?php
// Incluir la conexión a la base de datos y funciones de cifrado
include('conexion.php');
include('funciones_cifrado.php');

// Inicializar variables de error
$errors = array();

// Procesar el formulario cuando se envía
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar campos
    $nombre = trim($_POST['nombre']);
    $apellidos = trim($_POST['apellidos']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $genero = $_POST['genero'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];

    // Validar que no haya campos vacíos
    if (empty($nombre) || empty($apellidos) || empty($username) || empty($password) || empty($confirm_password) || empty($genero) || empty($fecha_nacimiento)) {
        $errors[] = "Todos los campos son obligatorios.";
    }

    // Validar dirección de correo electrónico
    if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "El username debe ser una dirección de correo electrónico válida.";
    }

    // Validar que las contraseñas coincidan
    if ($password != $confirm_password) {
        $errors[] = "Las contraseñas no coinciden.";
    }

    // Validar que el username no esté registrado
    $query = "SELECT * FROM usuarios WHERE username='$username'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        $errors[] = "Ya existe un usuario registrado con ese correo electrónico.";
    }

    // Si no hay errores, registrar al usuario
    if (empty($errors)) {
        // Generar salt aleatorio
        $salt = generateSalt();

        // Generar hash SHA512 de la contraseña con el salt
        $password_encrypted = hash('sha512', $password . $salt);

        // Insertar usuario en la base de datos
        $query = "INSERT INTO usuarios (nombre, apellidos, username, password_encrypted, password_salt, genero, fecha_nacimiento) VALUES ('$nombre', '$apellidos', '$username', '$password_encrypted', '$salt', '$genero', '$fecha_nacimiento')";
        if (mysqli_query($conn, $query)) {
            // Redirigir a la página de éxito
            header("Location: registro_exitoso.php");
            exit();
        } else {
            $errors[] = "Error al registrar al usuario.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Usuario</title>
    <link rel="stylesheet" href="./estilos/registro.css">
</head>

<body>
    <div class="background"></div>
    <div class="card">
        <h2>Registro nuevos usuarios</h2>
        <form class="form" action="./registro.php" method="post">
            <input type="text" placeholder="Nombre" name="nombre" id="nombre" required>
            <input type="text" placeholder="Apellidos" name="apellidos" id="apellidos" required>
            <input type="email" placeholder="Correo electrónico" name="correo" id="correo" required>
            <input type="password" placeholder="Contraseña" name="password" id="password" required>
            <input type="password" placeholder="Confirmar Contraseña" name="confirm_password" id="confirm_password" required>
            <div class="gender-date-container">
                <select name="genero" id="genero" required>
                    <option value="">Seleccionar género</option>
                    <option value="M">Masculino</option>
                    <option value="F">Femenino</option>
                    <option value="X">Prefiero no especificar</option>
                </select>
                <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" required>
            </div>
            <button type="submit">Registrarse</button>
        </form>
    </div>
</body>

</html>
