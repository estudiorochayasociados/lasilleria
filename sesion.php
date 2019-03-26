<?php
require_once "Config/Autoload.php";
Config\Autoload::runSitio();
$template = new Clases\TemplateSite();
$funciones = new Clases\PublicFunction();
$template->set("title", "La Sillería - Sesión");
$template->set("description", "Registrate como cliente y obtené grandes beneficios por ser usuario mayorista");
$template->set("keywords", "madera guatambu,sillas de madera, sillas, fabrica de sillas,comprar sillas online");
$template->set("favicon", LOGO);
$template->themeInit();
$carrito = new Clases\Carrito();
$usuarios = new Clases\Usuarios();
$op = isset($_GET["op"]) ? $_GET["op"] : '';
$usuarioSesion = $usuarios->view_sesion();
?>
    <div class="ps-hero bg--cover mb-40">
        <div class="ps-container">
            <h3>Mi cuenta</h3>
            <h4>Ingreso de usuarios</h4>
        </div>
    </div>
    <div id="sns_wrapper">
        <div class="ps-container mt-30">
            <div class="u-nav">
                <div class="col-md-3">
                    <a href="<?= URL ?>/sesion/pedidos" class="btn btn-default btn-block mb-30 pt-25 pb-20">
                        <i class="fa fa-list fa-2x"></i>
                        <h4>Mis Pedidos</h4>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="<?= URL ?>/sesion/datos" class="btn btn-default btn-block mb-30 pt-25 pb-20">
                        <i class="fa fa-edit fa-2x"></i>
                        <h4>Mis datos</h4>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="<?= URL ?>/contacto" class="btn btn-default btn-block mb-30 pt-25 pb-20">
                        <i class="fa fa-whatsapp fa-2x"></i>
                        <h4>Contactar</h4>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="<?= URL ?>/sesion/salir" class="btn btn-default btn-block mb-30 pt-25 pb-20">
                        <i class="fa fa-sign-out fa-2x"></i>
                        <h4>Salir</h4>
                    </a>
                </div>
            </div>
            <?php
            if ($op != '') {
                include("assets/inc/sesion/" . $op . ".inc.php");
            } else {
                include("assets/inc/sesion/pedidos.inc.php");
            }
            ?>
        </div>
    </div>
<?php
$template->themeEnd();
?>