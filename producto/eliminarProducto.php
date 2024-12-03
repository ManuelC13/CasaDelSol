<?php
//Verifica si se ha enviado el Sku
if (isset($_POST['sku'])) {
    $sku = $_POST['sku'];

    //Conectarse a la base de datos
    $conexion = mysqli_connect("localhost", "root", "", "db_casa_del_sol");

    //Verifica la conexión
    if (!$conexion) {
        echo json_encode(['success' => false, 'message' => 'Error de conexión']);
        exit;
    }

    //Realiza la consulta para eliminar al usuario
    // $consulta = "DELETE FROM producto WHERE Sku = ?";\
    $consulta = "UPDATE producto SET Stock = 0 WHERE Sku = ?";

    $stmt = $conexion->prepare($consulta);
    // $stmt->bind_param("i", $sku);
    $stmt->bind_param("s", $sku);

    if ($stmt->execute()) {
        // echo json_encode(['success' => true]);
        echo json_encode(['success' => true, 'message' => 'El stock del producto ha sido dado de baja']);
    } else {
        echo json_encode(['success' => false, 'message' => 'No se pudo eliminar el usuario']);
    }

    //Cerrar la conexión
    $stmt->close();
    $conexion->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Sku no proporcionado']);
}
?>
