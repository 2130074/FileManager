<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>¿Olvidaste tu contraseña?</title>
  <link rel="stylesheet" href="./estilos/styles.css">
</head>
<body>
  <div class="background"></div>
  <div class="card">
    <h2>Bienvenidos</h2>
    <form class="form" action="./login.php" method="post">
      <input type="text" placeholder="Nombre" name="nombre" id="nombre">
      <input type="password" placeholder="Contraseña" name="password" id="password">
      <button type="submit">Iniciar sesión</button>
      <a class="registro" href="./registro.php">Registrarse</a>
      <a class="olvido" href="./contraseñaOlvidada.php">¿Olvidaste tu contraseña?</a>
    </form>

  </div>
  </body>
</html>