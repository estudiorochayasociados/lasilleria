<?php
require_once "Config/Autoload.php";
Config\Autoload::runSitio();
$template = new Clases\TemplateSite();
$funciones = new Clases\PublicFunction();
$carrito = new Clases\Carrito();
$envios = new Clases\Envios();
$pagos = new Clases\Pagos();

$template->set("title", "La Sillería - CARRITO");
$template->set("description", "Finalizá tu carrito de compra");
$template->set("keywords", "comprar sillas de madera guatambu, sillas de madera guatambu en el interior, compra sillas online");
$template->set("favicon", LOGO);

$template->themeInit();
$precio_final = 0;
$carro = $carrito->return();
$carroEnvio = $carrito->checkEnvio();

$remover = isset($_GET["remover"]) ? $_GET["remover"] : '';
if ($remover != '') {
    $carrito->delete($remover);
    $funciones->headerMove(URL . "/carrito");
}

?>
    <div class="ps-hero bg--cover mb-60">
        <div class="ps-container " id="envioA">
            <h3>CARRITO DE COMPRA</h3>
            <div class="ps-breadcrumb">
                <ol class="breadcrumb">
                    <li><a href="index.html">Home</a></li>
                    <li class="active">CARRITO DE COMPRA</li>
                </ol>
            </div>
        </div>
    </div>
    <main class="ps-container">
        <div class="shoppingcart">
            <div class="col-md-12">
                <div class="envio">
                    <?php
                    $metodos_de_envios = $envios->list(array("peso >= " . $carrito->peso_final() . " OR peso = 0"));
                    if ($carroEnvio == '') {
                        echo "<h3>Seleccioná el envió que más te convenga:</h3>";
                        if (isset($_POST["envio"])) {
                            if ($carroEnvio != '') {
                                $carrito->delete($carroEnvio);
                            }
                            $envio_final = $_POST["envio"];
                            $envios->set("cod", $envio_final);
                            $envio_final_ = $envios->view();
                            $carrito->set("id", "Envio-Seleccion");
                            $carrito->set("cantidad", 1);
                            $carrito->set("titulo", $envio_final_["titulo"]);
                            $carrito->set("precio", $envio_final_["precio"]);
                            $carrito->add();
                            $funciones->headerMove(CANONICAL . "");
                        }
                        ?>
                        <form method="post" id="envio">
                            <select name="envio" class="form-control" id="envio" onchange="this.form.submit()">
                                <option value="" selected disabled>Elegir envío</option>
                                <?php
                                foreach ($metodos_de_envios as $metodos_de_envio_) {
                                    if ($metodos_de_envio_["precio"] == 0) {
                                        $metodos_de_envio_precio = "¡Gratis!";
                                    } else {
                                        $metodos_de_envio_precio = "$" . $metodos_de_envio_["precio"];
                                    }
                                    echo "<option value='" . $metodos_de_envio_["cod"] . "'>" . $metodos_de_envio_["titulo"] . " -> " . $metodos_de_envio_precio . "</option>";
                                }
                                ?>
                            </select>
                        </form>
                        <hr/>
                        <?php
                    }
                    ?>
                </div>
                <table class="table table-hover">
                    <thead>
                    <th>PRODUCTO</th>
                    <th>PRECIO UNITARIO</th>
                    <th>CANTIDAD</th>
                    <th>TOTAL</th>
                    <th></th>
                    </thead>
                    <tbody>
                    <?php
                    if (isset($_GET["remover"])) {
                        $carrito->delete($_GET["remover"]);
                        $funciones->headerMove(URL . "/carrito");
                    }
                    $i = 0;
                    $precio = 0;
                    foreach ($carro as $key => $carroItem) {
                        $precio += ($carroItem["precio"] * $carroItem["cantidad"]);
                        $opciones = @implode(" - ", $carroItem["opciones"]);
                        if ($carroItem["id"] == "Envio-Seleccion" || $carroItem["id"] == "Metodo-Pago") {
                            $clase = "text-bold";
                            $none = "hidden";
                        } else {
                            $clase = '';
                            $none = '';
                        }
                        ?>
                        <tr class="<?= $clase ?>">
                            <td><b><?= mb_strtoupper($carroItem["titulo"]); ?></b><br/><?= mb_strtoupper($opciones) ?></td>
                            <td><span class="<?= $none ?>"><?= "$" . $carroItem["precio"]; ?></span></td>
                            <td><span class="<?= $none ?>"><?= $carroItem["cantidad"]; ?></span></td>
                            <td>
                                <?php
                                if ($carroItem["precio"] != 0) {
                                    echo "$" . ($carroItem["precio"] * $carroItem["cantidad"]);
                                } else {
                                    echo "¡Gratis!";
                                }
                                ?>
                            </td>
                            <td>
                                <a href="<?= URL ?>/carrito.php?remover=<?= $key ?>"><i class="fa fa-remove"></i></a>
                            </td>
                        </tr>
                        <?php
                        $i++;
                    }
                    ?>
                    </tbody>
                </table>
            </div>
            <form class="form-right pull-right col-md-6 jumbotron" method="post" action="<?= URL ?>/carrito">
                <?php
                $metodo = isset($_POST["metodos-pago"]) ? $_POST["metodos-pago"] : '';
                $metodo_get = isset($_GET["metodos-pago"]) ? $_GET["metodos-pago"] : '';
                if ($metodo != '') {
                    $key_metodo = $carrito->checkPago();
                    $carrito->delete($key_metodo);
                    $pagos->set("cod", $metodo);
                    $pago__ = $pagos->view();
                    $precio_final_metodo = $carrito->precio_total();
                    if ($pago__["aumento"] != 0 || $pago__["disminuir"] != 0) {
                        if ($pago__["aumento"]) {
                            $numero = (($precio_final_metodo * $pago__["aumento"]) / 100);
                            $carrito->set("id", "Metodo-Pago");
                            $carrito->set("cantidad", 1);
                            $carrito->set("titulo", "CARGO +" . $pago__['aumento'] . "% / " . mb_strtoupper($pago__["titulo"]));
                            $carrito->set("precio", $numero);
                            $carrito->add();
                        } else {
                            $numero = (($precio_final_metodo * $pago__["disminuir"]) / 100);
                            $carrito->set("id", "Metodo-Pago");
                            $carrito->set("cantidad", 1);
                            $carrito->set("titulo", "DESCUENTO -" . $pago__['disminuir'] . "% / " . mb_strtoupper($pago__["titulo"]));
                            $carrito->set("precio", "-" . $numero);
                            $carrito->add();
                        }
                    }
                    $funciones->headerMove(CANONICAL . "/" . $metodo);
                }
                ?>
                <div class="form-bd">
                    <h3 class="mb-0">
                        <span class="text3"><b>TOTAL:</b></span>
                        <span class="text4">$<?= number_format($carrito->precio_total(), "2", ",", "."); ?></span>
                    </h3>
                    <?php
                    if ($carroEnvio == '') {
                        ?>
                        <span class="btn btn-default mt-10 mb-10 style-bd" onclick="$('#envio').addClass('alert alert-danger');">¿CÓMO PEREFERÍS EL ENVÍO DEL PEDIDO?</span>
                        <span><br/>¡Necesitamos que nos digas como querés realizar <br/>tu envío para que lo tengas listo cuanto antes!</span>
                        <?php
                    } else {
                        echo "<p class='mt-10'><b>Seleccioná tu medio de pago</b></p>";
                        $lista_pagos = $pagos->list(array(" estado = 0 "));
                        foreach ($lista_pagos as $pago) {
                            $precio_total = $carrito->precioSinMetodoDePago();
                            if ($pago["aumento"] != 0 || $pago["disminuir"] != 0) {
                                if ($pago["aumento"] > 0) {
                                    $precio_total = (($precio_total * $pago["aumento"]) / 100) + $precio_total;
                                } else {
                                    $precio_total = $precio_total - (($precio_total * $pago["disminuir"]) / 100);
                                }
                            }
                            ?>
                            <div class="radioButtonPay mt-10 mb-10">
                                <input type="radio" id="<?= ($pago["cod"]) ?>" name="metodos-pago" value="<?= ($pago["cod"]) ?>" onclick="this.form.submit()" <?php if ($metodo_get === $pago["cod"]) {
                                    echo " checked ";
                                } ?>>
                                <label for="<?= ($pago["cod"]) ?>"><b><?= mb_strtoupper($pago["titulo"]) ?></b></label>
                                <div class="block">
                                    <?= $pago["leyenda"] . " | Total: $" . $precio_total; ?>

                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    <?php } ?>
                    <?php if ($metodo_get != '') { ?>
                        <a href="<?= URL ?>/pagar/<?= $metodo_get ?>" class="btn btn-lg btn-success mt-20"><i class="fa fa-shopping-cart"></i> IR A PAGAR EL CARRITO</a>
                    <?php } ?>
                </div>
            </form>
            </table>
    </main>
<?php
$template->themeEnd();
?>