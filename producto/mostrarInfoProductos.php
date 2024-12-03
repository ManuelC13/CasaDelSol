<?php
function mostrarInfoProductos()
{

    global $conexion; // Accede a la variable $conexion declarada fuera de la función
    $sql = "SELECT producto.Sku, 
                producto.Nombre AS NombreProducto, 
                categoria.Nombre AS NombreCategoria, 
                producto.Precio, producto.Imagen,
                producto.Stock, 
                producto.Descripcion
            FROM producto 
            INNER JOIN categoria ON producto.IdCategoria = categoria.Id;";

    $resultado = $conexion->query($sql);

    if ($resultado->num_rows > 0) {
        $productos = [];
        while ($fila = $resultado->fetch_assoc()) {
            $productos[] = $fila;
        }
        return $productos; //Retorna el array de resultados
    } else {
        return []; //Retorna un array vacío si no hay resultados
    }
}
?>