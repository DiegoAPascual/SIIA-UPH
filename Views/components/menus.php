<a href="#" class="content-menu-toggle btn btn-primary"><i class="material-icons">menu</i> content</a>
<div class="content-menu content-menu-right">
    <ul class="list-unstyled">
        <li><a href="<?php echo BASE_URL . 'archivos/pagina'; ?>" class="<?php echo ($data['active'] == 'todos') ? 'active' : ''; ?>">Ver todos</a></li>
        <li><a href="<?php echo BASE_URL . 'recursos'; ?>" class="<?php echo ($data['active'] == 'recent') ? 'active' : ''; ?>">Ver recientes</a></li>
        <li><a href="<?php echo BASE_URL . 'archivos/recicle'; ?>" class="<?php echo ($data['active'] == 'deleted') ? 'active' : ''; ?>">Ver eliminados</a></li>
        <li class="divider"></li>
        <li><a href="#" class="<?php echo ($data['active'] == 'detail') ? 'active' : ''; ?>">Ver detalle</a></li>
    </ul>
</div>