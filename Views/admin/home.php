<?php include_once 'Views/template/header.php'; ?>
<div class="container">
    <div class="row">
        <div class="col">
            <div class="page-description">
                <center><h1>Bienvenido al</h1></center>
                <center><h1>Sistema Integral de Información Académica de la UPH</h1></center>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-4">
            <div class="card widget widget-stats">
                <div class="card-body">
                    <div class="widget-stats-container d-flex">
                        <div class="widget-stats-icon widget-stats-icon-primary">
                            <i class="material-icons-outlined">notifications</i>
                        </div>
                        <div class="widget-stats-content flex-fill">
                            <span class="widget-stats-title">Ir a la sección de</span>
                            <a href="<?php echo BASE_URL . 'compartidos'; ?>" class="widget-stats-amount" style="text-decoration: none;">Notificaciones</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card widget widget-stats">
                <div class="card-body">
                    <div class="widget-stats-container d-flex">
                        <div class="widget-stats-icon widget-stats-icon-danger">
                            <i class="material-icons-outlined">cloud_queue</i>
                        </div>
                        <div class="widget-stats-content flex-fill">
                            <span class="widget-stats-title">Ir a la sección de</span>
                            <a href="<?php echo BASE_URL . 'recursos'; ?>" class="widget-stats-amount" style="text-decoration: none;">Recursos</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card widget widget-stats">
                <div class="card-body">
                    <div class="widget-stats-container d-flex">
                        <div class="widget-stats-icon widget-stats-icon-warning">
                            <i class="material-icons-outlined">info</i>
                        </div>
                        <div class="widget-stats-content flex-fill">
                            <span class="widget-stats-title">Ir a la sección de</span>
                            <a href="<?php echo BASE_URL . 'acercade'; ?>" class="widget-stats-amount" style="text-decoration: none;">Acerca de</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once 'Views/template/footer.php'; ?>