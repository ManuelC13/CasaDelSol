<?php
session_start();
require 'carrito/funcionesCarrito.php';
require "conexion/conexion.php";
include 'componentes/header.php'; // Incluimos el header
?>

<!-- Carrusel principal -->
<?php include 'componentes/carrusel.php' ?>

<main>
    <!-- Tarjetas Beneficios -->
    <?php include 'componentes/beneficios.php' ?>

    <!-- Tarjetas de productos -->
    <section id="seccionProductos" tabindex="-1">
        <div class="container mt-1 pt-5" id="main">
            <h2 class="text-center mb-4">Nuestros Productos</h2>

            <!-- Formulario para seleccionar categoría -->
            <form method="GET" class="mb-4 text-center">
                <label for="categoria" class="form-label">Elige una categoría:</label>
                <select name="categoria" id="categoria" class="form-select w-auto d-inline-block">
                    <option value="0" selected>Todas</option>
                    <option value="1">Joyería</option>
                    <option value="2">Hogar</option>
                    <option value="3">Textiles</option>
                    <option value="4">Madera</option>
                    <option value="5">Cerámica</option>
                </select>
                <button type="submit" class="btn boton-personalizado text-white">Filtrar</button>
            </form>

            <div class="row">
                <?php

                require "producto/mostrarInfoProductosPorCategoria.php";
                require "producto/mostrarInfoProductos.php";

                // Obtener categoría seleccionada
                $categoriaSeleccionada = isset($_GET['categoria']) ? intval($_GET['categoria']) : 0;

                // Filtrar productos según la categoría
                $informacionProductos = $categoriaSeleccionada > 0
                    ? mostrarInfoProductosPorCategoria($categoriaSeleccionada)
                    : mostrarInfoProductos();

                if (count($informacionProductos) > 0) {
                    foreach ($informacionProductos as $producto) {
                ?>
                        <!-- Tarjeta de producto <div class="col-6 col-md-4 col-lg-3 mb-4">-->
                        <div class="col-xs-6 col-md-4 col-lg-3 mb-4">
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
                    echo '<h4>No hay registros para esta categoría</h4>';
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Tarjetas Nosotros -->
    <?php include 'componentes/nosotros.php' ?>

</main>

<?php include 'componentes/footer.php'; ?> <!--Incluimos el footer-->