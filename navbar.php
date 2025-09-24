<?php
// Asegurarse de que no haya salidas antes de modificar encabezados
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__. '/config/conexion.php';
require_once __DIR__. '/model/carrito_model.php';
require_once __DIR__.'/model/detalle_carrito_model.php';



//$categorias = [];

//try {
  //  $stmt = $pdo->query("SELECT id_categoria, nombre AS nombre FROM categoria ORDER BY nombre ASC");
    //$categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
//} catch (PDOException $e) {
  //  error_log("Error al obtener categorías: " . $e->getMessage());
//}
    $carritoModel = new CarritoModel($pdo);
    $detalleModel = new DetalleCarritoModel($pdo);

    $totalProductos = 0;

if (isset($_SESSION['user_id_usuario'])) {
    $id_usuario = $_SESSION['user_id_usuario'];
    $carrito = $carritoModel->obtenerCarritoPorUsuario($id_usuario);

    if ($carrito) {
        $totalProductos = $detalleModel->contarProductosUnicos($carrito['id_carrito']);
    }
}
   

?>
<!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="/Plaza-M-vil-3.1/css/styles.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>-->

<!-- Updated styles for buttons -->
<style>

</style>
<nav class="navbar navbar-expand-sm navbar-light bg-light-green fixed-top">
    <div class="container-fluid">
        <!-- Espacio para una imagen horizontal -->

        <a class="navbar-brand" href="/Plaza-M-vil-3.1/index.php"> <!-- Redirige al index.php -->
            <img src="/Plaza-M-vil-3.1/img/logohorizontal.png" alt="Logo" style="height: 40px;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto">
                <!-- Enlace de Inicio -->
                <li class="nav-item">
                    <a class="nav-link" href="/Plaza-M-vil-3.1/index.php">Inicio</a> <!-- Redirige al index.php -->
                </li>

                <!-- Enlace de ¿Quienes Somos? -->
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/Plaza-M-vil-3.1/view/quienes_somos.php">¿Quienes Somos?</a>
                </li>

                <!-- Enlace de Categorías
                <li class="nav-item dropdown">               
                    <a class="nav-link dropdown-toggle" href="#" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Categorías
                    </a>
                    <ul class="dropdown-menu">
                       // php foreach ($categorias as $cat): ?>
                            <li>
                                <a class="dropdown-item" href="/Plaza-M-vil-3.1/index.php?id_categoria=php echo $cat['id_categoria']; ?>">
                                    php echo htmlspecialchars($cat['nombre']); ?>
                                </a>
                            </li>
                        php endforeach; ?>
                        
                    </ul>
                </li> -->

                <!-- Opciones según el rol -->
                <?php if (isset($_SESSION['user_id_rol'])): ?>
                    <?php $id_rol = $_SESSION['user_id_rol']; ?>
                    <?php if ($id_rol === 1): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/Plaza-M-vil-3.1/view/dashboard.php">Dashboard</a>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>

                <!-- Botón de Notificaciones -->
               <!--  <li class="nav-item dropdown">
                    <a class="nav-link position-relative dropdown-toggle" href="#" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-bell" style="font-size: 1.5rem;"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                            id="notification-count">
                        /*  ?php echo isset($notificaciones) ? count($notificaciones) : 0; ?>   */
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        ?php if (!empty($notificaciones)): ?>
                            ?php foreach ($notificaciones as $notificacion): ?>
                                <li><a class="dropdown-item" href="#">?php echo htmlspecialchars($notificacion); ?></a></li>
                            ?php endforeach; ?>
                        ?php else: ?>
                            <li><span class="dropdown-item text-muted">No hay notificaciones</span></li>
                        ?php endif; ?>
                    </ul>
                </li> -->

                <!-- Botón Carrito de Compras -->
                <li class="nav-item">
                    <a class="nav-link" href="/Plaza-M-vil-3.1/view/carritoview.php">
                        <i class="bi bi-cart3"></i>
                        <?php if ($totalProductos > 0): ?>
                            <span class="badge bg-danger rounded-pill"><?php echo $totalProductos; ?></span>
                        <?php endif; ?>
                    </a>
                </li>

                <!-- Menú de Usuario -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Usuario
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="/Plaza-M-vil-3.1/view/perfil.php">Mi Perfil</a></li>
                        <?php if (isset($id_rol) && $id_rol == 3): ?>
                            <li><a class="dropdown-item" href="/Plaza-M-vil-3.1/view/mis_productos.php">Mis Productos</a></li>
                        <?php endif; ?>
                        <?php if (isset($id_rol) && $id_rol == 1): ?>
                            <li><a class="dropdown-item" href="/Plaza-M-vil-3.1/view/dashboard.php">Dashboard</a></li>
                        <?php endif; ?>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form action="/Plaza-M-vil-3.1/controller/logincontroller.php" method="POST" style="margin:0;">
                                <input type="hidden" name="action" value="logout">
                                <button type="submit" class="dropdown-item text-danger" style="width:100%;text-align:left;">
                                    Cerrar Sesión
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Botón flotante PQRS -->
<style>
#pqrs-float-btn {
    position: fixed;
    bottom: 30px;
    right: 30px;
    z-index: 9999;
    background: #198754;
    color: #fff;
    border-radius: 50%;
    width: 60px;
    height: 60px;
    font-size: 2rem;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    cursor: pointer;
}
</style>
<div id="pqrs-float-btn" data-bs-toggle="modal" data-bs-target="#modalPQRS" title="PQRS">
    <i class="bi bi-chat-dots"></i>
</div>

<!-- Modal PQRS -->
<div class="modal fade" id="modalPQRS" tabindex="-1" aria-labelledby="modalPQRSLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content" method="POST" action="/Plaza-M-vil-3.1/controller/registrar_pqrs.php" enctype="multipart/form-data">
      <div class="modal-header">
        <h5 class="modal-title" id="modalPQRSLabel">PQRS: Peticiones, Quejas, Reclamos y Sugerencias</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="tipo" class="form-label">Tipo</label>
          <select class="form-select" name="tipo" id="tipo" required>
            <option value="">Seleccione...</option>
            <option value="peticion">Petición</option>
            <option value="queja">Queja</option>
            <option value="reclamo">Reclamo</option>
            <option value="sugerencia">Sugerencia</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="asunto" class="form-label">Asunto</label>
          <input type="text" class="form-control" name="asunto" id="asunto" maxlength="150" required>
        </div>
        <div class="mb-3">
          <label for="descripcion" class="form-label">Descripción</label>
          <textarea class="form-control" name="descripcion" id="descripcion" rows="3" maxlength="250" required></textarea>
        </div>
        <div class="mb-3">
          <label for="adjunto" class="form-label">Adjuntar archivo (opcional)</label>
          <input type="file" class="form-control" name="adjunto" id="adjunto" accept="image/*,application/pdf">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-success">Enviar PQRS</button>
      </div>
    </form>
  </div>
</div>

<?php if (isset($_GET['pqrs']) && $_GET['pqrs'] === 'ok'): ?>
<script>
    alert('PQRS registrada con éxito');
</script>
<?php endif; ?>