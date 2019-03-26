<?php
require_once "Config/Autoload.php";
Config\Autoload::runSitio();
$template = new Clases\TemplateSite();
$funciones = new Clases\PublicFunction();
$template->set("title", "Pinturería Ariel | Inicio");
$template->set("description", "");
$template->set("keywords", "");
$template->set("favicon", LOGO);
//
$producto_id = isset($_GET["id"]) ? $_GET["id"] : '0';

//Clases
$productos = new Clases\Productos();
$carrito = new Clases\Carrito();
$categorias = new Clases\Categorias();
$imagenes = new Clases\Imagenes();

$productos->set("id", $producto_id);
$producto = $productos->view();

$imagenes->set("cod", $producto['cod']);
$categorias->set("cod", $producto['categoria']);

$categoria = $categorias->view();
$imagenes_productos = $imagenes->listForProduct();
$contar_imagenes = count($imagenes_productos);


$variable_1_explode = explode("||", $producto["variable1"]);
sort($variable_1_explode);
$variable_2_explode = explode("||", $producto["variable2"]);
sort($variable_2_explode);
$variable_3_explode = explode("||", $producto["variable3"]);
sort($variable_3_explode);

$carro = $carrito->return();
$carroEnvio = $carrito->checkEnvio();
$carroPago = $carrito->checkPago();

$template->set("title", $producto["titulo"] . "");
$template->set("description", $producto["description"]);
$template->set("keywords", $producto["keywords"]);
$template->set("imagen", URL."/".$imagenes_productos[0]["ruta"]);
$template->set("favicon", LOGO);

$template->themeInit();

?>
    <div class="ps-hero bg--cover" data-background="">
        <div class="ps-container">
            <h1><?= $producto["titulo"] ?></h1>
            <div class="ps-breadcrumb">
                <ol class="breadcrumb">
                    <li><a href="<?= URL ?>">Productos</a></li>
                    <li class="active"><?= $producto["titulo"] ?></li>
                </ol>
            </div>
        </div>
    </div>
    <main class="ps- pt-20">
        <div class="ps-container">
            <div class="ps-product--detail">
                <div class="row">
                    <div class="col-lg-5 col-md-7 col-sm-12 col-xs-12 ">
                        <div class="ps-product__thumbnail">
                            <div class="ps-product__image">
                                <?php
                                if ($contar_imagenes >= 1) {
                                    foreach ($imagenes_productos as $imagen) {
                                        ?>
                                        <div class="item">
                                            <a href="<?= URL ?>/<?= $imagen["ruta"] ?>" alt="<?= $producto["titulo"] ?>">
                                                <img src="<?= URL ?>/<?= $imagen["ruta"] ?>" alt="<?= $producto["titulo"] ?>" width="100%">
                                            </a>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                            <div class="ps-product__preview">
                                <div class="ps-product__variants">
                                    <?php
                                    if ($contar_imagenes >= 1) {
                                        foreach ($imagenes_productos as $imagen) {
                                            ?>
                                            <div class="item">
                                                <img src="<?= URL ?>/<?= $imagen["ruta"] ?>" alt="<?= $producto["titulo"] ?>" width="100%">
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-5 col-sm-12 col-xs-12">
                        <div class="ps-product__info">
                            <h1><?= $producto["titulo"] ?></h1>
                            <p class="ps-product__category"><?= $categoria["titulo"] ?></a></p>
                            <h3 class="ps-product__price">
                                <span class="fs-35 block bold">$<?= number_format(($producto["precio"] * 0.75), 2, ",", "."); ?> <span class="fs-14">(contado)</span></span>
                                <span class="fs-17">6 cuotas de $<?= number_format(($producto["precio"] / 6), 2, ",", "."); ?> con tarjeta de crédito</span>
                            </h3>
                            <div class="ps-product__short-desc">
                                <p><?= $producto["description"] ?></p>
                            </div>
                            <hr/>
                            <form method="post">
                                <?php
                                if (isset($_POST["enviar"])) {
                                    if ($carroPago != '') {
                                        $carrito->delete($carroPago);
                                    }
                                    if ($carroEnvio != '') {
                                        $carrito->delete($carroEnvio);
                                    }
                                    $carrito->set("id", $producto['id']);
                                    $carrito->set("cantidad", $_POST["cantidad"]);
                                    $carrito->set("titulo", $producto['titulo']);
                                    $carrito->set("peso", $producto['variable4']);
                                    $carrito->set("opciones", array("LUSTRE: " . $_POST["lustre"]));
                                    $carrito->set("precio", $_POST["precio"]);
                                    $carrito->add();

                                    $funciones->headerMove(URL . "/carrito");
                                }
                                ?>
                                <input type="hidden" value="<?= $producto["precio"] ?>" name="precio"/>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5 class="">Lustre</h5>
                                        <select class="form-control" name="lustre" required>
                                            <option value="" selected disabled>Seleccionar Lustre</option>
                                            <?php
                                            if (count($variable_3_explode) >= 1) {
                                                foreach ($variable_3_explode as $var3) {
                                                    $cod = rand(0, 999999999);
                                                    if ($var3 != '') {
                                                        ?>
                                                        <option value="<?= $var3 ?>"><?= $var3 ?></option>
                                                        <?php
                                                    }
                                                }
                                            }
                                            ?>
                                        </select>
                                        <div class="clearfix"></div>
                                        <a href="<?= URL ?>/c/lustres-para-madera" target="_blank"><i>* Ver lustres</i></a>
                                    </div>
                                    <div class="col-md-6">
                                        <h5>Cantidad</h5>
                                        <input class="form-control pt-5 pb-5 pl-5" type="number" name="cantidad" value="1" required/>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <hr/>
                                <input type="submit" class="ps-btn" name="enviar" value="Agregar al carrito"/>
                            </form>
                        </div>
                        <!-- AddToAny BEGIN -->
                        <div class="a2a_kit a2a_kit_size_32 a2a_default_style mt-20">
                            <h5>Compartir en:</h5>
                            <a class="a2a_button_facebook"></a>
                            <a class="a2a_button_twitter"></a>
                            <a class="a2a_button_google_plus"></a>
                            <a class="a2a_button_pinterest"></a>
                            <a class="a2a_button_whatsapp"></a>
                            <a class="a2a_button_google_gmail"></a>
                        </div>
                        <script async src="https://static.addtoany.com/menu/page.js"></script>
                    </div>
                </div>

                <div class="col-md-12 mt-40 pt-20">
                    <hr/>
                    <?php
                    if ($producto["desarrollo"] != '') {
                        echo "<h3>DESCRIPCIÓN DEL PRODUCTO</h3>" . $producto["desarrollo"];
                    }
                    ?>
                </div>
            </div>
        </div>
        </div>
    </main>
<?php $template->themeEnd(); ?>