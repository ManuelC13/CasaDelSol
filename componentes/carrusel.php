<?php 
echo '<section>
    <div id="carrusel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carrusel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carrusel" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carrusel" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active contenedorImagenes">
                <img src="recursos/imagenes/trompo.jpg" class="d-block w-100 imagenCarrusel" alt="...">
                <div class="carousel-caption top-0 mt-5 d-md-block mb-5 style=bottom: 60%;">
                    <h1 class="display-1 fw-bolder text-capitalize mt-5">Casa del sol</h1>
                    <p class="fs-5 texto">Aquí encontrarás toda clase de artículos artesanales</p>
                    <a href="#seccionProductos" class="btn boton-personalizado px-4 py-1 fs-5 mt-5">Comprar ahora</a>
                </div>
            </div>
            <div class="carousel-item contenedorImagenes">
                <img src="recursos/imagenes/cestas.jpg" class="d-block w-100 imagenCarrusel" alt="...">
                <div class="carousel-caption top-0 mt-5 d-md-block mb-5 style=bottom: 60%;">
                    <h1 class="display-1 fw-bolder mt-5">Descubre el arte detrás de cada pieza</h1>
                </div>
            </div>
            <div class="carousel-item contenedorImagenes">
                <img src="recursos/imagenes/barro.jpg" class="d-block w-100 imagenCarrusel" alt="...">
                <div class="carousel-caption top-0 mt-5 d-md-block mb-5 style=bottom: 60%;">
                    <h1 class="display-1 fw-bolder mt-5">Calidad artesanal que se siente y se ve</h1>
                </div>
            </div>
        </div>
    </div>
</section>'
?>
