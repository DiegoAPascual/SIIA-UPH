<?php include_once 'Views/template/header.php'; ?>
<div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">
    <a href="#"><center><h2>Seleccione alguna categoría</h2></center></a>
    <div class="carousel-item active" data-bs-interval="2000">
      <img src="<?php echo BASE_URL . 'Assets/images/hogar.png'; ?>" class="d-block img-fluid mx-auto carousel-image" alt="...">
      <br><br><br><br><br><br>
      <div class="carousel-caption d-none d-md-block">
        <a href="<?php echo BASE_URL . 'admin'; ?>"><h2>Inicio</h2></a>
        <p>Seleccione para dirigirse a la sección de inicio.</p>
      </div>
    </div>
    <div class="carousel-item" data-bs-interval="2000">
      <img src="<?php echo BASE_URL . 'Assets/images/notificacion.png'; ?>" class="d-block img-fluid mx-auto carousel-image" alt=" ...">
      <br><br><br><br><br><br>
      <div class="carousel-caption d-none d-md-block">
        <a href="<?php echo BASE_URL . 'compartidos'; ?>"><h2>Archivos compartidos</h2></a>
        <p>Seleccione para dirigirse a la sección de archivos compartidos.</p>
      </div>
    </div>
    <div class="carousel-item" data-bs-interval="2000">
      <img src="<?php echo BASE_URL . 'Assets/images/recursos.png'; ?>" class="d-block img-fluid mx-auto carousel-image" alt=" ...">
      <br><br><br><br><br><br>
      <div class="carousel-caption d-none d-md-block">
        <a href="<?php echo BASE_URL . 'recursos'; ?>"><h2>Centro de recursos</h2></a>
        <p>Seleccione para dirigirse a la sección de centro de recursos.</p>
      </div>
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

<style>
  a {
    text-decoration: none;
    color: #621333;
  }

  a:hover {
    color: #8b1f4b;
    /* Cambia el color del texto del enlace cuando se pasa el cursor por encima */
  }

  .carousel-image {
    max-width: 100%;
    /* ajusta el ancho máximo de la imagen al 100% del contenedor */
    max-height: 400px;
    /* ajusta la altura máxima de la imagen */
  }

  /* Media query for smaller screens */
  @media (max-width: 768px) {

    /* Hide carousel images on smaller screens */
    .carousel-item img {
      display: none;
    }

    /* Show only the active carousel caption (text) on smaller screens */
    .carousel-caption {
      display: block !important;
      /* Force display even on smaller screens */
    }
  }
</style>
<?php include_once 'Views/template/footer.php'; ?>