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
}

$productos_data = $productos->list($filter, '', (24 * $pagina) . ',' . 24);
$categorias->set("cod", $categoria);
$categoria__ = $categorias->view();
$productos_paginador = $productos->paginador($filter, 24);


$template->set("title", "SAN JOSÉ MUEBLES - " . $categoria__["titulo"]);
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
                <aside class="ps-sidebar col-md-3">
                    <aside class="widget widget_sidebar widget_category hidden-xs hidden-sm">
                        <h3 class="widget-title">Categorias</h3>
                        <ul class="ps-list--checked">
                            <?php
                            foreach ($categorias_side as $categorias_) {
                                if ($categorias_["cod"] == $categoria) {
                                    $current = "current";
                                } else {
                                    $current = '';
                                }
                                echo '<li class="' . $current . '" ><a  href="' . URL . '/productos/' . $funciones->normalizar_link($categorias_['titulo']) . '/' . $categorias_['cod'] . '">' . $categorias_['titulo'] . '</a></li>';
                            }
                            ?>
                        </ul>
                    </aside>
                </aside>
                <aside class="hidden-lg hidden-md">
                    <h3 class="widget-title">Categorias</h3>
                    <form method="get" action="<?= URL ?>/productos">
                        <select name="categoria" class="form-control" onChange='this.form.submit()'>
                            <option>Elegí la categoría que estás buscando</option>
                            <?php
                            foreach ($categorias_side as $categorias_) {
                                if ($categorias_["cod"] == $categoria) {
                                    echo '<option value="' . $categorias_['cod'] . '" selected>' . strtoupper($categorias_['titulo']) . '</option>';
                                } else {
                                    echo '<option value="' . $categorias_['cod'] . '">' . strtoupper($categorias_['titulo']) . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </form>
                </aside>
                <div class="col-md-9 col-sm-12">
                    <div class="ps-row">
                        <?php
                        foreach ($productos_data as $producto) {
                            $imagenes->set("cod", $producto['cod']);
                            $categorias->set("cod", $producto['categoria']);
                            $categoria = $categorias->view();
                            //$imagenes_productos = $imagenes->view();
                            $imagenes_productos = $imagenes->listForProduct();
                            ?>
                            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6 ">
                                <div class="ps-product">
                                    <div class="ps-product__thumbnail">
                                        <a href="<?= URL . "/producto/" . $funciones->normalizar_link($producto["titulo"]) . "/" . $producto["id"] ?>">
                                            <div style="background:url('<?= URL ?>/<?= $imagenes_productos[0]["ruta"] ?>') no-repeat center center/contain;width:100%;height:200px"></div>
                                        </a>
                                        <div class="ps-product__content full">
                                            <a class="ps-product__title" href="<?= URL . "/producto/" . $funciones->normalizar_link($producto["titulo"]) . "/" . $producto["id"] ?>">
                                                <?= $producto["titulo"] ?>
                                            </a>
                                            <div class="ps-product__categories"><a href="<?= URL . "/productos/" . $funciones->normalizar_link($categoria["titulo"]) ?>"><?= $categoria["titulo"] ?></a></div>
                                            <p class="ps-product__price">
                                                $<?= $producto["precio"] ?>
                                            </p>
                                            <a class="ps-btn ps-btn--sm" href="<?= URL . "/producto/" . $funciones->normalizar_link($producto["titulo"]) . "/" . $producto["id"] ?>">
                                                Ver más
                                            </a>
                                        </div>
                                    </div>
                                    <div class="ps-product__content">
                                        <a class="ps-product__title" href="<?= URL . "/producto/" . $funciones->normalizar_link($producto["titulo"]) . "/" . $producto["id"] ?>">
                                            <?= $producto["titulo"] ?>
                                        </a>
                                        <div class="ps-product__categories">
                                            <a href="<?= URL . "/productos/" . $funciones->normalizar_link($producto["categoria"]); ?>">
                                                <?= $categoria["titulo"] ?>
                                            </a>
                                        </div>
                                        <p class="ps-product__price">
                                            $<?= $producto["precio"] ?>
                                        </p>
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