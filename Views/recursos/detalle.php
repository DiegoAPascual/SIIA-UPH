<?php include_once 'Views/template/header.php'; ?>
<div class="card">
    <div class="card-body">
        <div class="alert alert-custom alert-indicator-left indicator-info" role="alert">
            <div class="alert-content text-center">
                <span class="alert-text">Directorio</span>
                <span class="alert-title"><?php echo $data['carpeta']['nombre']; ?></span>
            </div>
        </div>
        <input type="hidden" id="id_carpeta" value="<?php echo $data['id_carpeta']; ?>">
        <div class="table-resposive">
            <table class="table table-striped table-hover display nowrap" style="width: 100%;" id="tblDetalle">
                <thead>
                    <tr>
                        <th></th>
                        <th>Correo</th>
                        <th>Archivo</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include_once 'Views/template/footer.php'; ?>