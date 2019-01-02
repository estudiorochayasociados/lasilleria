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
$pagina = isset($_GET["pagina"]) ? $_GET["pagina"] : '0';
$categoria = isset($_GET["categoria"]) ? $_GET["categoria"] : '';
$subcategoria = isset($_GET["subcategoria"]) ? $_GET["subcategoria"] : '';
$filter = array();

//$filter = '';
if ($categoria != '') {
    array_push($filter, "categoria = '$categoria'");
}

//Clases
$productos = new Clases\Productos();
$categorias = new Clases\Categorias();
$imagenes = new Clases\Imagenes();
$productos_data = $productos->list($filter, '', (24 * $pagina) . ',' . 24);
$productos_paginador = $productos->paginador($filter, 24);

if (@count($_GET) == 0) {
    $anidador = "?";
} else {
    if ($pagina >= 0) {
        $anidador = "&";
    } else {
        $anidador = "?";
    }
}

$template->themeInit();
?>
    <div class="ps-hero bg--cover mb-60" >
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
    <main class="container-fluid">
        <div class="ps-container">
            <div class="row">
                <aside class="ps-sidebar col-md-3">
                    <aside class="widget widget_sidebar widget_category hidden-xs hidden-sm">
                        <h3 class="widget-title">Categorias</h3>
                        <ul class="ps-list--checked">
                            <?php
                            $categorias_side = $categorias->list('');
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

                    <aside class="widget widget_sidebar widget_category hidden-lg hidden-md">
                        <h3 class="widget-title">Categorias</h3>
                        <select name="categoria">
                            <?php
                            $categorias_side = $categorias->list('');
                            foreach ($categorias_side as $categorias_) {
                                echo '<option value="' . $categorias_['cod'] . '">' . $categorias_['titulo'] . '</option>';
                            }
                            ?>
                        </select>
                    </aside>
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
                            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 ">
                                <div class="ps-product">
                                    <div class="ps-product__thumbnail">
                                        <div style="background:url('<?= URL ?>/<?= $imagenes_productos[0]["ruta"] ?>') no-repeat center center/contain;width:100%;height:200px"></div>
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
                    <div class="ps-pagination mb-70">
                        <ul class="pagination">
                            <li><a href="#"><i class="fa fa-angle-left"></i></a></li>
                            <?php
                            if ($productos_paginador != 1 && $productos_paginador != 0) {
                                $links = '';
                                $links .= "<li><a href='" . CANONICAL . "" . $anidador . "pagina=1'>1</a></li>";
                                $i = max(2, $pagina - 5);

                                if ($i > 2) {
                                    $links .= "<li><a href='#'>...</a></li>";
                                }
                                for (; $i < min($pagina + 6, $productos_paginador); $i++) {
                                    $links .= "<li><a href='" . CANONICAL . "" . $anidador . "pagina=" . $i . "'>" . $i . "</a></li>";
                                }
                                if ($i != $productos_paginador) {
                                    $links .= "<li><a href='#'>...</a></li>";
                                    $links .= "<li><a href='" . CANONICAL . "" . $anidador . "pagina=" . $productos_paginador . "'>" . $productos_paginador . "</a></li>";
                                }
                                echo $links;
                                echo "";
                            }
                            ?>
                            <li><a href="#"><i class="fa fa-angle-right"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>
<?php $template->themeEnd() ?>