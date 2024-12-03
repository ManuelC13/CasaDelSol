<?php

session_start();
require 'carrito/funcionesCarrito.php';

require 'conexion/conexion.php';
// Incluir conexión a la base de datos

// Incluir header
include_once 'componentes/header.php';

// Recuperar el término de búsqueda
$query = isset($_GET['query']) ? $_GET['query'] : '';
?>

<main class="min-vh-100">
    <div class="container mt-5 pt-5">
        <h2 class="text-center">Resultados de Búsqueda</h2>
        <div class="row">
            <?php
            if (!empty($query)) {

                include 'producto/mostrarProductoBuscado.php';

                $result = mostrarProductoBuscado($query);

                if ($result->num_rows > 0) {
                    while ($producto = $result->fetch_assoc()) {
                        $foto = 'producto/imgProductos/' . $producto['Imagen'];
            ?>
                        <!-- Tarjeta de producto <div class="col-6 col-md-4 col-lg-3 mb-4">-->
                        <div class="col-6 col-md-4 col-lg-3 mb-4">
                            <!-- Tarjeta de producto -->
                            <div class="card h-100 tarjeta-producto">
                                <!-- Encabezado de la tarjeta -->
                                <div class="card-header bg-dark text-center">
                                    <!-- <h4 class="titulo-producto">
                                    <?php print $producto['NombreProducto'] ?></h4> -->
                                    <h4 class="mb-2 titulo-producto text-white"><?php if (isset($producto['NombreProducto'])) print $producto['NombreProducto'];
                                                                                else  print $producto['Nombre'];  ?></h4>
                                </div>

                                <!-- Cuerpo de la tarjeta -->
                                <div class="card-body text-center ratio ratio-1x1">
                                    <?php
                                    $foto = 'producto/imgProductos/' . $producto['Imagen'];
                                    if (file_exists($foto)) {
                                    ?>
                                        <img src="<?php print $foto; ?>" class="img-fluid">
                                    <?php } else { ?>
                                        <img src="producto/imgProductos/noHayImagen.jpg" class="img-fluid">
                                    <?php } ?>
                                </div>

                                <!-- Muestra el detalle del producto -->
                                <div class="card-footer text-sm-start overflow-auto p-2 bg-Light scroll-personalizado">
                                    <?php $descripcion = isset($producto['Descripcion']) ? $producto['Descripcion'] : 'Sin descripción disponible'; ?>
                                    <p class="text-dark text-justify">
                                        <?php echo htmlspecialchars($descripcion, ENT_QUOTES, 'UTF-8'); ?>
                                    </p>
                                </div>

                                <!-- Pie de la tarjeta -->
                                <?php if ($producto['Stock'] > 0) {
                                ?>
                                    <div class="card-footer bg-dark">
                                        <div class="row mb-2">
                                            <!-- Mostrar precio -->
                                            <div class="col-6 text-start mt-2">
                                                <span class="badge precios">
                                                    $<?php echo htmlspecialchars($producto['Precio']); ?>
                                                </span>
                                            </div>

                                            <!-- Mostrar stock -->
                                            <div class="col-6 text-end mt-2">
                                                <span class="badge disponibilidad">
                                                    Stock: <?php echo isset($producto['Stock']) ? htmlspecialchars($producto['Stock']) : 'No disponible'; ?>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="row w-100 mx-auto">
                                            <!-- Botón para agregar al carrito -->
                                            <a class="shadow-lg boton-carrito col text-dark btn w-100 btn-fixed mb-2" href="carrito/carrito.php?sku=<?php print $producto['Sku'] ?>">
                                                <i class="bi bi-cart-fill"></i> Agregar al carrito
                                            </a>
                                        </div>
                                    </div>
                                <?php
                                } else {
                                    print '<div class="card-footer text-center btn btn-danger w-100 disabled mx-auto p-4">
                                            Sin stock
                                        </div>';
                                }
                                ?>
                            </div>
                        </div>
            <?php
                    }
                } else {
                    echo "<p class='text-center'>No se encontraron productos con el término '<strong>" . htmlspecialchars($query) . "</strong>'</p>";
                }
            } else {
                echo "<p class='text-center'>Ingrese un término de búsqueda.</p>";
            }
            ?>
        </div>
    </div>
</main>
<?php
// Incluir footer
include 'componentes/footer.php';
?>