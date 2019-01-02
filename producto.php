<?php
require_once "Config/Autoload.php";
Config\Autoload::runSitio();
$template = new Clases\TemplateSite();
$funciones = new Clases\PublicFunction();
$template->set("title", "Pinturería Ariel | Inicio");
$template->set("description", "");
$template->set("keywords", "");
$template->set("favicon", LOGO);
$template->themeInit();
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
?>
    <div class="ps-hero bg--cover" data-background="<?= URL ?>/assets/images/hero/bread-2.jpg">
        <div class="ps-container">
            <h3>Shop Page</h3>
            <div class="ps-breadcrumb">
                <ol class="breadcrumb">
                    <li><a href="index.html">Home</a></li>
                    <li class="active">Shop Page</li>
                </ol>
            </div>
        </div>
    </div>
    <main class="ps- pt-20">
        <div class="ps-container">
            <div class="ps-product--detail">
                <div class="row">
                    <div class="col-lg-8 col-md-7 col-sm-12 col-xs-12 ">
                        <div class="ps-product__thumbnail">
                            <div class="ps-product__image">
                                <?php
                                if ($contar_imagenes >= 1) {
                                    foreach ($imagenes_productos as $imagen) {
                                        ?>
                                        <div class="item"><a href="<?= URL ?>/<?= $imagen["ruta"] ?>" alt="<?= $producto["titulo"] ?>"><img src="<?= URL ?>/<?= $imagen["ruta"] ?>" alt="<?= $producto["titulo"] ?>"></a></div>
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
                                            <div class="item"><img src="<?= URL ?>/<?= $imagen["ruta"] ?>" alt="<?= $producto["titulo"] ?>" alt=""></div>
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-5 col-sm-12 col-xs-12">
                        <div class="ps-product__info">
                            <h1><?= $producto["titulo"] ?></h1>
                            <p class="ps-product__category"><?= $categoria["titulo"] ?></a></p>
                            <h3 class="ps-product__price">
                                <span>$</span> <span id="precio"><?= $producto["precio"] ?></span>
                            </h3>
                            <div class="ps-product__short-desc">
                                <p><?= $producto["description"] ?></p>
                            </div>
                            <hr/>
                            <form method="post">
                                <?php
                                if (isset($_POST["enviar"])) {
                                    if ($carroEnvio != '') {
                                        $carrito->delete($carroEnvio);
                                    }
                                    $carrito->set("id", $producto['id']);
                                    $carrito->set("cantidad", $_POST["cantidad"]);
                                    $carrito->set("titulo", $producto['titulo']);
                                    $carrito->set("peso", $producto['variable4']);
                                    $opciones = isset($_POST["cuerina"]) ? $_POST["cuerina"] : $_POST["telas"];
                                    $opciones_tipo = isset($_POST["cuerina"]) ? "CUERINA: " : "TELA: ";
                                    $carrito->set("opciones", array($opciones_tipo.$opciones, "LUSTRE: ".$_POST["lustre"]));
                                    $carrito->set("precio", $_POST["precio"]);
                                    $carrito->add();

                                    $funciones->headerMove(CANONICAL . "?success");
                                }
                                if (strpos(CANONICAL, "success") == true) {
                                    echo "<div class='alert alert-success'>Agregaste un producto a tu carrito, querés <a href='" . URL . "/carrito'>pasar por caja</a> o <a href='" . URL . "/productos'>seguir comprando</a></div>";
                                }
                                ?>
                                <input type="hidden" value="" id="precioForm" name="precio"/>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5>Cuerinas</h5>
                                        <select class="form-control" name="cuerina" id="cuerina" onchange="$('#precio').html('<?= $producto["precio_cuerina"] ?>');$('#precioForm').val('<?= $producto["precio_cuerina"] ?>');$('#telas').val('')">
                                            <option selected disabled>Seleccionar cuerina</option>
                                            <?php
                                            if (count($variable_1_explode) >= 1) {
                                                foreach ($variable_1_explode as $var1) {
                                                    $cod = rand(0, 999999999);
                                                    if ($var1 != '') {
                                                        ?>
                                                        <option value="<?= $var1 ?>"><?= $var1 ?></option>
                                                        <?php
                                                    }
                                                }
                                            }
                                            ?>
                                        </select>
                                        <a href="<?= URL ?>/c/telas-y-cuerinas" target="_blank"><i>* Ver Cuerinas</i></a>
                                    </div>
                                    <div class="col-md-6">
                                        <h5>Telas</h5>
                                        <select class="form-control" name="telas" id="telas" onchange="$('#precio').html('<?= $producto["precio_telas"] ?>');$('#precioForm').val('<?= $producto["precio_telas"] ?>');$('#cuerina').val('')">
                                            <option selected disabled>Seleccionar telas</option>
                                            <?php
                                            if (count($variable_2_explode) >= 1) {
                                                foreach ($variable_2_explode as $var2) {
                                                    $cod = rand(0, 999999999);
                                                    if ($var2 != '') {
                                                        ?>
                                                        <option value="<?= $var2 ?>"><?= $var2 ?></option>
                                                        <?php
                                                    }
                                                }
                                            }
                                            ?>
                                        </select>
                                        <div class="clearfix"></div>
                                        <a href="<?= URL ?>/c/telas" target="_blank"><i>* Ver Telas</i></a>
                                    </div>
                                    <div class="col-md-12">
                                        <h5 class="mt-20">Lustre</h5>
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
                                        <a href="<?= URL ?>/c/tipos-de-lustres" target="_blank"><i>* Ver lustres</i></a>
                                    </div>
                                </div>
                                <h5 class="mt-20">Cantidad</h5>
                                <input class="form-control pt-5 pb-5 pl-5" type="number" name="cantidad" value="1" required/>
                                <div class="clearfix"></div>
                                <hr/>
                                <input type="submit" class="ps-btn" name="enviar" value="Agregar al carrito"/>
                            </form>
                        </div>
                        <div class="ps-product__sharing">
                            <p>Compartir en:
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-dribbble"></i></a>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 mt-20">
                    <?= "<h3>Descripción</h3>" . $producto["desarrollo"]; ?>
                </div>
            </div>
        </div>
        </div>
    </main>
<?php $template->themeEnd(); ?>