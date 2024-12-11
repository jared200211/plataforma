<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <title>GRUPO IBARRA</title>
    <style>
      html, body {
    height: 100%;
    margin: 0;
    overflow: hidden; /* Evitar scroll en la página principal */
}

.container {
    height: 100%; /* Altura completa */
    display: flex;
    flex-direction: column;
    justify-content: center; /* Centra verticalmente el contenido */
}
    </style>
</head>
<body>

<form id="formdata" method="POST">

<section class="bg-light-blue py-3 py-md-5 full-height">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
        <div class="card border border-light-subtle rounded-3 shadow-sm">
          <div class="card-body p-3 p-md-4 p-xl-5">
            <div class="text-center mb-3">
              <a href="#!">
                <img src="./images/ib.png" alt="" width="135" height="150">
              </a>
            </div>
            <h2 class="fs-6 fw-normal text-center text-secondary mb-4">GRUPO IBARRA</h2>
            <div class="row gy-2 overflow-hidden">
              <div class="col-12">
                <div class="form-floating mb-3">
                  <input type="text" class="form-control" name="Email" id="Email" placeholder="name@example.com">   
                  <label for="email" class="form-label">Usuario</label>
                </div>
              </div>
              <center>
              <div id="logErrorEmail" class="alert alert-danger" role="alert" style="display: none;">
                Ingrese un Usuario Valido
              </div>
              </center>

              <div class="col-12">
                <div class="form-floating mb-3">
                  <input type="password" class="form-control" name="contrasenia" id="contrasenia" placeholder="Password">
                  <label for="password" class="form-label">Contraseña</label>
                </div>
              </div>

              <center>
              <div id="logErrorPassword" class="alert alert-danger" role="alert" style="display: none;">
                Ingrese una Contraseña Valida
              </div>
              </center>

              <center>
              <div id="logErrorGeneral" class="alert alert-danger" role="alert" style="display: none;">
                Error de Validacion
              </div>
              </center>

              <div class="col-12">
                <div class="d-grid my-3">
                  <button class="btn btn-primary btn-lg" id="botonLogin" type="submit">Iniciar Sesion</button>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</form>

<script src="./js/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

<script>
  document.getElementById("formdata").addEventListener("submit", function(event) {
    event.preventDefault(); // Evitar que el formulario se envíe y recargue la página

    let email = document.getElementById("Email").value;
    let password = document.getElementById("contrasenia").value;

    document.getElementById("logErrorEmail").style.display = "none";
    document.getElementById("logErrorPassword").style.display = "none";
    document.getElementById("logErrorGeneral").style.display = "none";

  
    $.ajax({
      url: 'login.php', 
      type: 'POST',
      dataType: 'json',
      data: {
        Email: email,
        contrasenia: password
      },
      success: function(response) {
        
        if (response.success) {
          window.location.href = 'menu.php'; 
        } else {
          
          document.getElementById("logErrorGeneral").style.display = "block";
          document.getElementById("logErrorGeneral").innerText = response.message;
        }
      },
      error: function(xhr, status, error) {
        
        document.getElementById("logErrorGeneral").style.display = "block";
        document.getElementById("logErrorGeneral").innerText = "Ocurrió un error inesperado.";
      }
    });
  });
</script>

</body>
</html>
