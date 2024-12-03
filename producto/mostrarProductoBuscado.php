<?php

function mostrarProductoBuscado($query)
{
    global $conexion;

    $stmt = $conexion->prepare("SELECT * FROM producto WHERE Nombre LIKE ?");

    if ($stmt === false) {
        die("Error al preparar la consulta.");
    }

    $searchTerm = "%$query%";
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    return $resultBuscar = $stmt->get_result();
}
