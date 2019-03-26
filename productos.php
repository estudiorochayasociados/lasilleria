<?php
require_once "Config/Autoload.php";
Config\Autoload::runSitio();
$template = new Clases\TemplateSite();
$funciones = new Clases\PublicFunction();
$productos = new Clases\Productos();
$categorias = new Clases\Categorias();
$imagenes = new Clases\Imagenes();

$pagina = isset($_GET["pagina"]) ? $_GET["pagina"] : '0';
$categoria = isset($_GET["categoria"]) ? $_GET["categoria"] : '';
$categorias_side = $categorias->list(array('area = "productos"'));

$filter = array();

if ($categoria != '') {
    array_push($filter, "categoria = '$categoria'");
} else {
    $filter = '';
}

$productos_data = $productos->list($filter, '', (24 * $pagina) . ',' . 24);
$categorias->set("cod", $categoria);
$categoria__ = $categorias->view();
$productos_paginador = $productos->paginador($filter, 24);


$template->set("title", "La Sillería - " . $categoria__["titulo"]);
$template->set("description", "");
$template->set("keywords", $categoria__["titulo"] . ",madera guatambu,sillas de madera, sillas, fabrica de sillas,comprar sillas online");
$template->set("favicon", LOGO);

$template->themeInit();
?>
    <div class="ps-hero bg--cover mb-60">
        <div class="ps-container">
            <h1><?= strtoupper($categoria__["titulo"]); ?> DE MADERA GUATAMBÚ</h1>
            <div class="ps-breadcrumb">
                <ol class="breadcrumb">
                    <li><a href="<?= URL ?>/productos">Productos</a></li>
                    <li class="active"><?= strtoupper($categoria__["titulo"]); ?></li>
                </ol>
            </div>
        </div>
    </div>
    <main class="container-fluid">
        <div class="ps-container">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="ps-row">
                        <?php

                        foreach ($productos_data as $producto) {
                            $imagenes->set("cod", $producto['cod']);
                            $categorias->set("cod", $producto['categoria']);
                            $categoria = $categorias->view();
                            $imagenes_productos = $imagenes->listForProduct();
                            ?>
                            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-6 ">
                                <div class="ps-product">
                                    <a href="<?= URL . "/producto/" . $funciones->normalizar_link($producto["titulo"]) . "/" . $producto["id"] ?>">
                                        <div class="mb-10" style="background:url('<?= URL ?>/<?= $imagenes_productos[0]["ruta"] ?>') no-repeat center center/contain;width:100%;height:250px"></div>
                                    </a>
                                    <div class="pl-10 pr-10">
                                        <a class=" fs-14" href="<?= URL . "/producto/" . $funciones->normalizar_link($producto["titulo"]) . "/" . $producto["id"] ?>">
                                            <?= $producto["titulo"] ?>
                                        </a>
                                        <div class="ps-product__categories"><a href="<?= URL . "/productos/" . $funciones->normalizar_link($categoria["titulo"]) ?>"><?= $categoria["titulo"] ?></a></div>
                                        <span class="fs-17 verde block">$<?= number_format(($producto["precio"] * 0.75), 2, ",", "."); ?>  <span class="fs-12">(contado)</span> </span>
                                        <span class="fs-13">6 cuotas de $<?= number_format(($producto["precio"] / 6), 2, ",", "."); ?></span>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
<?php $template->themeEnd() ?>