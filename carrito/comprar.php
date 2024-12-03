<?php
session_start();

include '../conexion/conexion.php'; 

if (!isset($_SESSION['usuario'])) {
    die("Por favor inicia sesión antes de realizar una compra.");
}

$usuario = $_SESSION['usuario'];
$usuario_id = $_SESSION['idUsuario']; // Obtén el ID del usuario logueado
$carrito = $_SESSION['carritos'][$usuario] ?? [];

if (empty($carrito)) {
    die("Tu carrito está vacío.");
}

// Iniciar una transacción
$conexion->begin_transaction();

try {
    // 1. Registrar la compra en la tabla `compras`
    $total = 0;
    foreach ($carrito as $producto) {
        $total += $producto['precio'] * $producto['cantidad'];
    }

    $stmt = $conexion->prepare("INSERT INTO compras (usuario_id, total) VALUES (?, ?)");
    $stmt->bind_param("id", $usuario_id, $total);
    $stmt->execute();
    $compra_id = $stmt->insert_id; // Obtén el ID de la compra generada
    $stmt->close();

    // 2. Registrar los productos en la tabla `detalle_compras` y actualizar el stock
    foreach ($carrito as $sku => $producto) {
        $stmt = $conexion->prepare("INSERT INTO detalle_compras (compra_id, sku, cantidad, precio) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isid", $compra_id, $sku, $producto['cantidad'], $producto['precio']);
        $stmt->execute();
        $stmt->close();

        // Actualizar el stock del producto
        $stmt = $conexion->prepare("UPDATE producto SET stock = stock - ? WHERE sku = ?");
        $stmt->bind_param("is", $producto['cantidad'], $sku);
        $stmt->execute();
        $stmt->close();
    }

    // 3. Vaciar el carrito
    unset($_SESSION['carritos'][$usuario]);

    // Confirmar la transacción
    $conexion->commit();

    // Redirigir con mensaje de éxito
    header("Location: confirmacion.php?status=success");
    exit;

} catch (Exception $e) {
    // Si algo falla, revertir la transacción
    $conexion->rollback();
    die("Error al procesar la compra: " . $e->getMessage());
}
?>

?>