<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manejador de Archivos</title>
  <link rel="stylesheet" href="./style.css">
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      document.querySelector(".boton-listar").addEventListener("click", function() {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "listar_archivos.php", true);
        xhr.onreadystatechange = function() {
          if (xhr.readyState === 4 && xhr.status === 200) {
            document.querySelector(".lista-archivos").innerHTML = xhr.responseText;
            // Agregar evento de clic a los enlaces
            var enlaces = document.querySelectorAll(".lista-archivos a");
            enlaces.forEach(function(enlace) {
              enlace.addEventListener("click", function(event) {
                event.preventDefault();
                var urlArchivo = enlace.getAttribute("href");
                window.open(urlArchivo, "_blank");
              });
            });
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
      <button class="boton-subir">Subir archivos</button>
      <button class="boton-borrar">Borrar archivos</button>
    </div>
    <div class="lista-archivos"></div>
    <button class="boton-salir" onclick="location.href='./login.php'">Cerrar sesión</button>
  </div>
</body>

</html>