<?php
require_once "Config/Autoload.php";
Config\Autoload::runSitio();
$template = new Clases\TemplateSite();
$funciones = new Clases\PublicFunction();
$pedidos = new Clases\Pedidos();
$carritos = new Clases\Carrito();
$correo = new Clases\Email();

$template->set("title", "Admin");
$template->set("description", "Admin");
$template->set("keywords", "Inicio");
$template->set("favicon", LOGO);
$template->themeInit();
$estado_get = isset($_GET["estado"]) ? $_GET["estado"] : '';

$cod_pedido = $_SESSION["cod_pedido"];
$pedidos->set("cod", $cod_pedido);

if ($estado_get != '') {
    $pedidos->set("estado", $estado_get);
    $pedidos->cambiar_estado();
}

$pedido = $pedidos->view();

$estado = $pedidos->ver_estado($pedido[0]["estado"]);

$clase = '';
$none = '';

?>
    <div class="ps-404">
        <div class="container" >
            <div class="well well-lg pt-100 pb-100">
                <?php ob_start() ?>
                <h2>COMPRA FINALIZADA
                    <hr/>
                    CÓDIGO: <span> <?= $cod_pedido ?></span></h2>
                <p>
                    <b>Estado del Pago:</b> <?= $estado ?><br/>
                    <b>Método de Pago:</b> <?= $pedido[0]["tipo"] ?>
                </p>
                <table class="table table-hover text-left hidden-xs hidden-sm"  id="pedido">
                    <thead>
                    <th><b>PRODUCTO</b></th>
                    <th><b>PRECIO UNITARIO</b></th>
                    <th><b>CANTIDAD</b></th>
                    <th><b>TOTAL</b></th>
                    </thead>
                    <tbody>
                    <?php
                    $precio = 0;
                    foreach ($pedido as $pedido_) {
                        $precio += ($pedido_["precio"] * $pedido_["cantidad"]);
                        if ($pedido_["id"] == "Envio-Seleccion") {
                            $clase = "text-bold";
                            $none = "hidden";
                        }
                        ?>
                        <tr class="<?= $clase ?>">
                            <td><?= $pedido_["producto"]; ?></td>
                            <?php
                            if ($pedido_["precio"] != 0) {
                                ?>
                                <td><span class="<?= $none ?>"><?= "$" . $pedido_["precio"]; ?></span></td>
                                <td><span class="<?= $none ?>"><?= $pedido_["cantidad"]; ?></span></td>
                                <td><?= "$" . ($pedido_["precio"] * $pedido_["cantidad"]); ?></td>
                                <?php
                            } else {
                                echo '<td></td><td></td>';
                                echo "<td>¡Gratis!</td>";
                            }
                            ?>

                        </tr>
                        <?php
                    }
                    ?>
                    <tr>
                        <td><h3>TOTAL</h3></td>
                        <td></td>
                        <td></td>
                        <td><h3>$<?= number_format($precio, "2", ",", ".") ?></h3></td>
                    </tr>
                    </tbody>
                </table>
                <?php
                $tabla = ob_get_contents();
                ob_end_clean();
                echo $tabla;
                ?>
                <div class="table table-hover hidden-lg hidden-md">
                    <?php
                    if (isset($_POST["eliminarCarrito"])) {
                        $carrito->delete($_POST["eliminarCarrito"]);
                    }
                    $i = 0;
                    $precio = 0;
                    foreach ($pedido as $pedido_) {
                        $precio += ($pedido_["precio"] * $pedido_["cantidad"]);
                        $opciones = @implode(" - ", $pedido_["opciones"]);
                        if ($pedido_["id"] == "Envio-Seleccion") {
                            $clase = "text-bold";
                            $none = "hidden";
                        } else {
                            $clase;
                            $none;
                        }
                        ?>
                        <div class="row">
                            <div class="col-xs-10">
                                <b><?= $pedido_["producto"]; ?></b><br/><?= $opciones ?><br/>
                                <span class="<?= $none ?>"><?= "$" . $pedido_["precio"]; ?> x <?= $pedido_["cantidad"]; ?></span><br/>
                                <?php
                                if ($pedido_["precio"] != 0) {
                                    echo "$" . ($pedido_["precio"] * $pedido_["cantidad"]);
                                } else {
                                    echo "¡Gratis!";
                                }
                                ?>
                            </div>
                            <div class="col-xs-1"><a href="<?= URL ?>/carrito.php?remover=<?= $key ?>"><i class="fa fa-remove"></i></a></div>
                        </div>
                        <hr/>
                        <?php
                        $i++;
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
<?php
//MENSAJE = DATOS USUARIO COMPRADOR
$datos_usuario = "<b>Nombre y apellido:</b> " . $_SESSION["usuarios"]["nombre"] . "<br/>";
$datos_usuario .= "<b>Email:</b> " . $_SESSION["usuarios"]["email"] . "<br/>";
$datos_usuario .= "<b>Provincia:</b> " . $_SESSION["usuarios"]["provincia"] . "<br/>";
$datos_usuario .= "<b>Localidad:</b> " . $_SESSION["usuarios"]["localidad"] . "<br/>";
$datos_usuario .= "<b>Teléfono:</b> " . $_SESSION["usuarios"]["telefono"] . "<br/>";

//USUARIO EMAIL
$carroDetalle = $tabla;
$carroDetalle .= '<br/><hr/>';
$carroDetalle .= '<h3>Datos de usuario:</h3>';
$carroDetalle .= $datos_usuario;

$mensajeCompraUsuario = '¡Muchas gracias por tu nueva compra!<br/>En el transcurso de las 24 hs un operador se estará contactando con usted para pactar la entrega y/o pago del pedido. A continuación te dejamos el pedido que nos realizaste.<hr/>'.$carroDetalle;
$mensajeCompraAdmin = '¡Nueva compra desde la web!<br/>A continuación te dejamos el detalle del pedido.<hr/>'.$carroDetalle;

$correo->set("asunto", "Muchas gracias por tu nueva compra");
$correo->set("receptor", $_SESSION["usuarios"]["email"]);
$correo->set("emisor", EMAIL);
$correo->set("mensaje", $mensajeCompraUsuario);
$correo->emailEnviar();

$correo->set("asunto", "NUEVA COMPRA ONLINE");
$correo->set("receptor", EMAIL);
$correo->set("emisor", EMAIL);
$correo->set("mensaje", $mensajeCompraAdmin);
$correo->emailEnviar();

$carritos->destroy();
unset($_SESSION["cod_pedido"]);
$template->themeEnd();
?>
