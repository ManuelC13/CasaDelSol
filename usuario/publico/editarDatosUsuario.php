<?php
session_start();

require_once '../../conexion/conexion.php';

if (!isset($_SESSION['idUsuario'])) {
    //Redirigir si no hay sesión activa
    header("Location: ../../usuario/publico/inicioDeSesion.php");
    exit;
}

// Recuperar el id del usuario desde la sesión
$idUsuario = $_SESSION['idUsuario'];

// Consulta para obtener los datos del usuario
$query = "SELECT * FROM usuario WHERE id = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $idUsuario);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    $usuario = $resultado->fetch_assoc(); // Obtener los datos del usuario
} else {
    echo "Error: Usuario no encontrado.";
    exit;
}

// Consulta para obtener la dirección del usuario
$query_direccion = "SELECT * FROM direccion WHERE UsuarioId = ?";
$stmt_direccion = $conexion->prepare($query_direccion);
$stmt_direccion->bind_param("i", $idUsuario);
$stmt_direccion->execute();
$resultado_direccion = $stmt_direccion->get_result();

if ($resultado_direccion->num_rows > 0) {
    $direccion = $resultado_direccion->fetch_assoc();
} else {
    echo "Error: Dirección no encontrada.";
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/c570243db9.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../../css/estiloRegistro.css">
    <title>Registro de Usuario</title>
</head>
<body>

    <div class="container formulario-contenedor mb-4 mt-5 shadow-lg p-4 col-xl-w-50 col bg col-md-5 col-lg-5 col-xl-6">
        <!-- Título y descripción-->    
        <h1 class="fw-bold text-center texto-naranja mb-2">Actualizar Datos</h1>
        <p class="text-center text-muted">Proporciona la siguiente información para actualizar sus datos.</p>
        <hr>

        <!-- Formulario -->
        <form id="formulario-registro" action="actualizarDatosUsuario.php" method="post" onsubmit="return validarContraseña()" class="needs-validation">

            <!-- Nombre y Apellido -->
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="nombre" class="form-label">Nombre(s):</label>
                    <input type="text" id="nombre" name="nombre" class="form-control form-control-sm" required value="<?php echo htmlspecialchars($usuario['Nombre']); ?>">
                </div>
                <div class="col-md-6">
                    <label for="apellido" class="form-label">Apellido(s):</label>
                    <input type="text" id="apellido" name="apellido" class="form-control form-control-sm" required value="<?php echo htmlspecialchars($usuario['Apellido']); ?>">
                </div>
            </div>

            <!-- Género -->
            <div class="mb-3 mt-2">
                <label class="form-label">Género:</label>
                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="genero" id="masculino" value="Masculino" required value="Masculino" <?= ($usuario['Genero'] == 'M') ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="masculino">Masculino</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="genero" id="femenino" value="Femenino" required value="Femenino" <?= ($usuario['Genero'] == 'F') ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="femenino">Femenino</label>
                    </div>
                </div>
            </div>

            <!-- Intereses -->
            <div class="mb-3">
                <label class="form-label">Intereses (Opcional):</label>

                <?php
                // Separar preferencias y eliminar espacios
                $intereses = array_map('trim', explode(',', $usuario['Intereses']));
                ?>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="intereses[]" id="accesorios" value="Accesorios" <?= in_array('Accesorios', $intereses) ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="accesorios">Joyería y accesorios</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="intereses[]" id="decoracion" value="Decoración" <?= in_array('Decoración', $intereses) ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="decoracion">Decoración para el hogar</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="intereses[]" id="textiles" value="Textiles" <?= in_array('Textiles', $intereses) ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="textiles">Ropa y textiles</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="intereses[]" id="madera" value="Madera" <?= in_array('Madera', $intereses) ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="madera">Arte en madera</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="intereses[]" id="ceramica" value="Cerámica" <?= in_array('Cerámica', $intereses) ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="ceramica">Cerámica y alfarería</label>
                </div>
            </div>

            <!-- Edad -->
            <div class="mb-3">
                <label for="edad" class="form-label">Edad:</label>
                <select id="edad" name="edad" class="form-select" required>
                    <option value="" selected disabled>Seleccionar</option>
                    <option value="18-24" <?php echo ($usuario['Edad'] == '18-24') ? 'selected' : ''; ?>>18 a 24 años</option>
                    <option value="25-34" <?php echo ($usuario['Edad'] == '25-34') ? 'selected' : ''; ?>>25 a 34 años</option>
                    <option value="35-44" <?php echo ($usuario['Edad'] == '35-44') ? 'selected' : ''; ?>>35 a 44 años</option>
                    <option value="45"    <?php echo ($usuario['Edad'] == '45') ? 'selected' : ''; ?>>Más de 44 años</option>
                </select>
            </div>

            <!-- Dirección -->
            <h4 class="texto-naranja">Dirección</h4>
            <div class="row g-3">
                <!-- Calle y Cruzamientos -->
                <div class="col-md-6">
                    <label for="calle" class="form-label">Calle:</label>
                    <input type="text" id="calle" name="calle" class="form-control form-control-sm" required value="<?php echo($direccion['Calle']); ?>">
                </div>
                <div class="col-md-6">
                    <label for="cruzamientos" class="form-label">Cruzamientos:</label>
                    <input type="text" id="cruzamientos" name="cruzamientos" class="form-control form-control-sm" required value="<?php echo($direccion['Cruzamiento']); ?>">
                </div>
                <!-- Ciudad y Código Postal -->
                <div class="col-md-6">
                    <label for="ciudad" class="form-label">Ciudad:</label>
                    <input type="text" id="ciudad" name="ciudad" class="form-control" required value="<?php echo($direccion['Ciudad']); ?>">
                </div>
                <div class="col-md-3">
                    <label for="codigoPostal" class="form-label">CP:</label>
                    <input type="text" id="codigoPostal" name="codigoPostal" class="form-control form-control-sm" required value="<?php echo($direccion['CodigoPostal']); ?>">
                </div>
                <div class="col-md-3">
                    <label for="numeroDeCasa" class="form-label">No. Casa:</label>
                    <input type="text" id="numeroDeCasa" name="numeroDeCasa" class="form-control form-control-sm" required value="<?php echo($direccion['NumeroCasa']); ?>">
                </div>
            </div>

            <!--Contacto-->
            <div class="row g-3 mt-3">
                <div class="col-md-6">
                    <label for="correo" class="form-label">Correo Electrónico:</label>
                    <input type="email" id="correo" name="correoElectronico" class="form-control form-control-sm" required value="<?php echo($usuario['Email']); ?>">
                </div>
                <div class="col-md-6">
                    <label for="telefono" class="form-label">Teléfono:</label>
                <input type="text" id="telefono" name="telefono" class="form-control form-control-sm" required required value="<?php echo($usuario['Telefono']); ?>">
                </div>
            </div>

            <!--Contraseña-->
            <div class="row g-3 mt-3">
                <div class="col-md-6">
                    <label for="contrasenia" class="form-label">Contraseña:</label>
                    <input type="password" id="contrasenia" name="contrasenia" class="form-control form-control-sm" required required value="<?php echo($usuario['Contrasenia']); ?>">
                </div>
                <div class="col-md-6">
                    <label for="confirmacionDeContrasenia" class="form-label">Repetir Contraseña:</label>
                    <input type="password" id="confirmacionDeContrasenia" name="confirmacionDeContrasenia" class="form-control form-control-sm" required value="<?php echo($usuario['Contrasenia']); ?>">
                </div>
            </div>

            <!-- Botón -->
            <div class="text-center mt-5">
                <button type="submit" class="btn boton-personalizado shadow"><i class="fa-solid fa-pen"></i> Actualizar mis datos</button>
            </div>
            <div class="text-center mt-4">
                <a href="../../index.php" class="btn btn-outline-danger shadow">Cancelar</a>
            </div>
        </form>
    </div>

    <?php include '../../componentes/footer.php'; ?>

    <script>
            // Función para mostrar el campo que solicita al usuario la clave de administrador cunado éste ha indicado que lo es
            function mostrarCampoClaveAdministrador() {
                const campoAdministrador = document.getElementById('campo-administrador');
                const esAdministrador = document.getElementById('si');

                if (esAdministrador.checked) {
                    campoAdministrador.style.display = "block"; // Mostrar el campo
                } else {
                    campoAdministrador.style.display = "none"; // Ocultar el campo
                }
            }

        
        // Función para validar si las contraseñas coinciden
        function validarContraseña() {
            // Obtener el valor de la contraseña y la confirmación de contraseña
            var contrasenia = document.forms["formulario-registro"]["contrasenia"].value;
            var confirmacionDeContrasenia = document.forms["formulario-registro"]["confirmacionDeContrasenia"].value;
            
            //Si las contraseñas son diferentes
            if (contrasenia !== confirmacionDeContrasenia) {
                alert("Las contraseñas no coinciden. Inténtalo de nuevo.");
                return false; // Evitar que se envíe el formulario
            }

            return true; // Permitir el envío del formulario
        }

    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>