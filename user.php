<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manejador de Archivos</title>
  <link rel="stylesheet" href="./estilos/styless.css">

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      document.querySelector(".boton-listar").addEventListener("click", function() {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "./listar_archivos_user.php", true);
        xhr.onreadystatechange = function() {
          if (xhr.readyState === 4 && xhr.status === 200) {
            document.querySelector(".lista-archivos").innerHTML = xhr.responseText;
          }
        };
        xhr.send();
      });
    });
  </script>

</head>
<body>
<div class="contenedor-transparente">
<h2>¡Bienvenida/o!</h2> 

<div class="botones-container">
    <button class="boton-listar">Listar archivos</button>
 </div>
 <div class="lista-archivos"></div>
 <button class="boton-salir" onclick="cerrarSesion()">Cerrar sesión</button>

 <button class="boton-salir" onclick="cerrarSesion()">Cerrar sesión</button>
<script>
function cerrarSesion() {
    // Realizar una solicitud AJAX al script PHP para cerrar la sesión
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "cerrar_sesion.php", true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Redirigir al usuario a login.php después de cerrar la sesión
            location.href = './login.php';
        }
    };
    xhr.send();
}
</script>

</body>
</html>