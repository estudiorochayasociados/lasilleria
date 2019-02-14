<?php
require_once "Config/Autoload.php";
Config\Autoload::runSitio();
$template = new Clases\TemplateSite();
$funciones = new Clases\PublicFunction();
$template->set("title", "La Sillería - USUARIOS");
$template->set("description", "Registrate como cliente y obtené grandes beneficios por ser usuario mayorista");
$template->set("keywords", "madera guatambu,sillas de madera, sillas, fabrica de sillas,comprar sillas online");
$template->set("favicon", LOGO);
$template->themeInit();
$carrito = new Clases\Carrito();
$usuarios = new Clases\Usuarios();
$usuarioSesion = $usuarios->view_sesion();
if (count($usuarioSesion) != 0) {
    $funciones->headerMove(URL . "/sesion");
}
?>
    <div class="ps-hero bg--cover mb-60">
        <div class="ps-container">
            <h3>Ingreso de cliente</h3>
            <h4>Ingresá como clientes a todos los beneficios</h4>
        </div>
    </div>
    <div id="sns_wrapper">
    <div class="ps-container mt-30">
        <div class="well well-lg pt-50 pb-30 pr-70 pl-70">
            <form method="post" class="row">
                <h4>Ingreso de cliente</h4>
                <hr/>
                <div class="clearfix"></div>
                <?php
                if (isset($_POST["login"])) {
                    $error = 0;
                    $email = $funciones->antihack_mysqli(isset($_POST["email"]) ? $_POST["email"] : '');
                    $password = $funciones->antihack_mysqli(isset($_POST["password"]) ? $_POST["password"] : '');

                    $usuarios->set("email", $email);
                    $usuarios->set("password", $password);
                    $log = $usuarios->login();
                    if($log == 1) {
                        $funciones->headerMove(URL . "/sesion");
                    } else {
                        echo "<div class='alert alert-danger'>Los datos no corresponden a una cuenta existente.</div><div class=\"clearfix\"></div>";
                    }
                }
                ?>
                <div class="clearfix"></div>
                <div class="row">
                    <div class="col-md-12">Email:<br/>
                        <input class="form-control  mb-10" type="email" value="<?php echo isset($_POST["email"]) ? $_POST["email"] : '' ?>" placeholder="Escribir email" name="email" required/>
                    </div>
                    <div class="col-md-12 col-xs-12 password">Contraseña:<br/>
                        <input class="form-control  mb-10" type="password" value="<?php echo isset($_POST["password"]) ? $_POST["password"] : '' ?>" placeholder="Escribir password" name="password" required/>
                    </div>
                    <div class="col-md-12 col-xs-12 mb-50">
                        <input class="btn btn-success btn-lg" type="submit" value="¡Iniciar sesión!" name="login"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php
$template->themeEnd();
?>