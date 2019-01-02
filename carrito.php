<?php
require_once "Config/Autoload.php";
Config\Autoload::runSitio();
$template = new Clases\TemplateSite();
$funciones = new Clases\PublicFunction();
$carrito = new Clases\Carrito();
$envios= new Clases\Envios();

$template->set("title", "Pinturería Ariel | Inicio");
$template->set("description", "");
$template->set("keywords", "");
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
                    $metodos_de_envios = $envios->list(array("peso >= ".$carrito->peso_final()." OR peso = 0"));
                    if ($carroEnvio == '') {
                        echo "<h3>Seleccioná el envió que más te convenga:</h3>";
                        if (isset($_POST["envio"])) {
                            if ($carroEnvio != '') {
                                $carrito->delete($carroEnvio);
                            }
                            $envio_final =$_POST["envio"];
                            $envios->set("cod",$envio_final);
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
                                    if($metodos_de_envio_["precio"] == 0) {
                                        $metodos_de_envio_precio = "¡Gratis!";
                                    } else {
                                        $metodos_de_envio_precio = "$".$metodos_de_envio_["precio"];
                                    }
                                    echo "<option value='".$metodos_de_envio_["cod"]."'>".$metodos_de_envio_["titulo"]." -> ".$metodos_de_envio_precio."</option>";
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
                    if (isset($_POST["eliminarCarrito"])) {
                        $carrito->delete($_POST["eliminarCarrito"]);
                    }

                    $i = 0;
                    $precio = 0;
                    foreach ($carro as $key => $carroItem) {
                        $precio += ($carroItem["precio"] * $carroItem["cantidad"]);
                        $opciones = @implode(" - ", $carroItem["opciones"]);
                        if ($carroItem["id"] == "Envio-Seleccion") {
                            $clase = "text-bold";
                            $none = "hidden";
                        } else {
                            $clase;
                            $none;
                        }
                        ?>
                        <tr class="<?= $clase ?>">
                            <td><b><?= $carroItem["titulo"]; ?></b><br/><?= $opciones ?></td>
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
            <form class="form-right pull-right col-md-6 well well-lg mb-50 col-xs-12" method="post" action="<?= URL ?>/pagar">
                <div class="form-bd">
                    <h3 class="mb-0">
                        <span class="text3"><b>TOTAL A PAGAR:</b> $<?= number_format($carrito->precio_total(), "2", ",", "."); ?></span>
                    </h3>
                    <?php if ($carroEnvio == '') { ?>
                        <a href="#envioA" class="btn btn-default mt-10 mb-10" onclick="$('#envio').addClass('alert alert-danger');">¿DECIDISTE EL ENVÍO DEL PEDIDO?</a><br/>
                        <b>¡Necesitamos que nos digas como querés realizar tu envío para que lo tengas listo cuanto antes!</b>
                    <?php } else { ?>
                        <div class="radioButtonPay mt-20 mb-10">
                            <input type="radio" id="0" name="metodos-pago" value="0">
                            <label for="0">Transferencia Bancaria</label>
                        </div>
                        <div class="radioButtonPay mt-20 mb-10">
                            <input type="radio" id="1" name="metodos-pago" value="1">
                            <label for="1">Coordinar con vendedor</label>
                        </div>
                        <div class="radioButtonPay mt-20 mb-10">
                            <input type="radio" id="2" name="metodos-pago" value="2" checked>
                            <label for="2">Tarjeta de crédito o débito
                                <div class="hidden-xs hidden-sm"><span class="fa fa-arrow-right"></span> <b class="ml-5">¡Recomendado!</b></div>
                            </label>
                        </div>
                        <button type="submit" name="pagar" class="mb-10 mt-10 btn btn-success btn-lg pull-left">PAGAR EL CARRITO</button>
                    <?php } ?>
                </div>
            </form>
        </div>
    </main>
<?php
$template->themeEnd();
?>