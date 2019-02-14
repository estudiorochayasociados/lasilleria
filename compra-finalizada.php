<?php
require_once "Config/Autoload.php";
Config\Autoload::runSitio();
$template = new Clases\TemplateSite();
$funciones = new Clases\PublicFunction();
$template->set("title", "Admin");
$template->set("description", "Admin");
$template->set("keywords", "Inicio");
$template->set("favicon", LOGO);
$template->themeInit();
$estado_get = isset($_GET["estado"]) ? $_GET["estado"] : '';
$pedidos = new Clases\Pedidos();
$carritos = new Clases\Carrito();
$cod_pedido = $_SESSION["cod_pedido"];
$pedidos->set("cod", $cod_pedido);

if ($estado_get != '') {
    $pedidos->set("estado", $estado_get);
    $pedidos->cambiar_estado();
}

echo $estado_get;

$pedido = $pedidos->view();

switch ($pedido[0]["estado"]) {
    case "0":
        $estado = "Carrito No Cerrado";
        break;
    case "1":
        $estado = "Pendiente";
        break;
    case "2":
        $estado = "Exitoso";
        break;
    case "3":
        $estado = "Enviado";
    break;
    case "4":
        $estado = "Rechazado";
        break;
}

?>
    <div class="ps-404">
        <div class="container">
            <div class="well well-lg pt-100 pb-100">
                <h2>COMPRA FINALIZADA
                    <hr/>
                    CÓDIGO: <span> <?= $cod_pedido ?></span></h2>
                <p>
                    <b>Estado:</b> <?= $estado ?><br/>
                    <b>Método de pago:</b> <?= $pedido[0]["tipo"] ?>
                </p>
                <table class="table table-hover text-left hidden-xs hidden-sm">
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
                        } else {
                            $clase;
                            $none;
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
$carritos->destroy();
unset($_SESSION["cod_pedido"]);
$template->themeEnd();
?>