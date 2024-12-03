<?php
// Usar archivo de conexión
require '../../conexion/conexion.php';

// Verifica si se ha enviado el ID
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // La conexión ya está establecida en el archivo `conexion.php`

    // Realiza la consulta para eliminar al usuario
    $consulta = "DELETE FROM usuario WHERE Id = ?";
    $stmt = $conexion->prepare($consulta);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No se pudo eliminar el usuario']);
    }

    // Cerrar la conexión
    $stmt->close();
    $conexion->close();
} else {
    echo json_encode(['success' => false, 'message' => 'ID no proporcionado']);
}
?>

