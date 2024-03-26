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
                // Agregar evento de clic a los botones de borrar
                var botonesBorrar = document.querySelectorAll(".boton-borrar");
                botonesBorrar.forEach(function(boton) {
                  boton.addEventListener("click", function() {
                    var nombreArchivo = boton.getAttribute("data-nombre"); // Obtiene el nombre del archivo del atributo data-nombre
                    var confirmacion = confirm("¿Está seguro que desea borrar " + nombreArchivo + "?");
                    if (confirmacion) {
                      var fila = boton.closest("tr");
                      var xhrBorrar = new XMLHttpRequest();
                      xhrBorrar.open("GET", "borrar_archivo.php?nombre=" + encodeURIComponent(nombreArchivo), true);
                      xhrBorrar.onreadystatechange = function() {
                        if (xhrBorrar.readyState === 4 && xhrBorrar.status === 200) {
                          fila.remove(); // Eliminar la fila del archivo de la tabla
                          alert("El archivo ha sido borrado exitosamente.");
                        }
                      };
                      xhrBorrar.send();
                    }
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
    </div>
    <div class="lista-archivos"></div>

    <div id="formulario-subida" style="display: none;">
      <form id="form-subir-archivo" enctype="multipart/form-data">
        <label for="nombre-archivo">Nombre del archivo (opcional):</label>
        <input type="text" id="nombre-archivo" name="nombre-archivo">
        <label for="archivo">Seleccione el archivo:</label>
        <input type="file" id="archivo" name="archivo">
        <input type="submit" value="Subir archivo">
      </form>
    </div>

    <button class="boton-salir" onclick="location.href='./login.php'">Cerrar sesión</button>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
$(document).ready(function(){
    // Mostrar el formulario de subida al hacer clic en el botón "Subir archivos"
    $(".boton-subir").click(function(){
        $("#formulario-subida").show();
    });

    // Manejar la subida de archivos mediante AJAX
    $("#form-subir-archivo").submit(function(event){
        event.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: 'subir_archivo.php',
            method: 'POST',
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function(){
                // Mostrar un mensaje de carga
                console.log('Subiendo archivo...');
            },
            success: function(data){
                // Procesar la respuesta del servidor
                try {
                    var response = JSON.parse(data);
                    if (response.success) {
                        // Mostrar mensaje de éxito
                        alert(response.message);
                        console.log('Archivo subido exitosamente.');
                        // Agregar el nuevo archivo a la lista de archivos
                        if (response.nombreArchivo) {
                            var nuevoArchivoHTML = '<a href="archivo.php?nombre=' + encodeURIComponent(response.nombreArchivo) + '" target="_blank">' + response.nombreArchivo + '</a>';
                            $(".lista-archivos").append("<div>" + nuevoArchivoHTML + "</div>");
                        }
                    } else {
                        // Mostrar mensaje de error
                        alert(response.message);
                    }
                } catch (error) {
                    console.error('Error al procesar la respuesta del servidor:', error);
                    // Mostrar un mensaje de error genérico
                    alert('Error al procesar la respuesta del servidor.');
                }
            },
            error: function(xhr, status, error){
                // Manejar errores de la solicitud AJAX
                console.error('Error en la solicitud AJAX:', status, error);
                alert('Error en la solicitud AJAX.');
            }
        });
    });
});
</script>
</body>

</html>