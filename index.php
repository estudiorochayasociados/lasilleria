<?php
require_once "Config/Autoload.php";
Config\Autoload::runSitio();
$template = new Clases\TemplateSite();
$funciones = new Clases\PublicFunction();

$template->set("title", "SAN JOSÉ MUEBLES");
$template->set("description", "Fábrica de sillas de madera guatambú muy resistentes");
$template->set("keywords", "fábrica de sillas de madera guatambu,mayorista de sillas de madera guatambu,comprar sillas de madera online");
$template->set("favicon", LOGO);

$productos = new Clases\Productos();
$slider = new Clases\Sliders();
$categorias = new Clases\Categorias();
$imagenes = new Clases\Imagenes();
$novedades = new Clases\Novedades();
$productos_data = $productos->list('', '', '0,8');
$novedades_data = $novedades->listWithOps('', '', '5');
$sliders = $slider->list('');
$template->themeInit();
?>
    <div class="ps-slider--banner owl-slider" data-owl-auto="true" data-owl-loop="true" data-owl-speed="9000"
         data-owl-gap="0" data-owl-nav="false" data-owl-dots="true" data-owl-item="1" data-owl-item-xs="1"
         data-owl-item-sm="1" data-owl-item-md="1" data-owl-item-lg="1" data-owl-duration="1000"
         data-owl-mousedrag="on">
        <?php
        foreach ($sliders as $sliders_) {
            $imagenes->set("cod", $sliders_['cod']);
            $img = $imagenes->view();
            ?>
            <div class="ps-product--banner">
                <div class="ps-product__thumbnail"
                     style="background:url('<?= URL . "/" . $img["ruta"]; ?>') no-repeat center center/cover;height:500px;width:100%"></div>
                <div class="ps-product__content">
                    <h3><?= $sliders_["titulo"] ?></h3>
                    <select class="ps-rating">
                        <option value="1">1</option>
                        <option value="1">2</option>
                        <option value="1">3</option>
                        <option value="1">4</option>
                        <option value="1">5</option>
                    </select>
                    <p><?= $sliders_["subtitulo"] ?></p>
                    <div class="ps-product__actions">
                        <a class="ps-btn" href="<?= URL . "/produtos"; ?>">Más información</a>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
    <div class="ps-section ps-home-best-product">
        <div class="ps-container">
            <div class="ps-section__header text-center">
                <p>Productos 100% calidad argentina</p>
                <h3 class="ps-section__title">Productos más visitados </h3><span class="ps-section__line"></span>
            </div>
            <div class="ps-section__content mt-100">
                <div class="row">
                    <?php
                    foreach ($productos_data as $producto) {
                        $imagenes->set("cod", $producto['cod']);
                        $categorias->set("cod", $producto['categoria']);
                        $categoria = $categorias->view();
                        $imagenes_productos = $imagenes->listForProduct();
                        ?>
                        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 ">
                            <div class="ps-product">
                                <div class="ps-product__thumbnail">
                                    <div style="background:url('<?= URL ?>/<?= $imagenes_productos[0]["ruta"] ?>') no-repeat center center/contain;width:100%;height:200px"></div>
                                    <div class="ps-product__content full">
                                        <a class="ps-product__title"
                                           href="<?= URL . "/producto/" . $funciones->normalizar_link($producto["titulo"]) . "/" . $producto["id"] ?>">
                                            <?= $producto["titulo"] ?>
                                        </a>
                                        <div class="ps-product__categories"><a
                                                    href="<?= URL . "/productos/" . $funciones->normalizar_link($categoria["titulo"]) ?>"><?= $categoria["titulo"] ?></a>
                                        </div>
                                        <p class="ps-product__price">
                                            $<?= $producto["precio"] ?>
                                        </p>
                                        <a class="ps-btn ps-btn--sm"
                                           href="<?= URL . "/producto/" . $funciones->normalizar_link($producto["titulo"]) . "/" . $producto["id"] ?>">
                                            Ver más
                                        </a>
                                    </div>
                                </div>
                                <div class="ps-product__content">
                                    <a class="ps-product__title"
                                       href="<?= URL . "/producto/" . $funciones->normalizar_link($producto["titulo"]) . "/" . $producto["id"] ?>">
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
<?php
if (@count($novedades_data) > 1) {
    ?>
    <div class="ps-section ps-home-blog">
        <div class="ps-container">
            <div class="ps-section__header text-center">
                <h3 class="ps-section__title">Blog</h3><span class="ps-section__line"></span>
            </div>
            <div class="ps-section__content">
                <div class="row">
                    <?php
                    if (@count($novedades_data) == 2) {
                        foreach ($novedades_data as $novedad) {
                            $imagenes->set("cod", $novedad['cod']);
                            $img = $imagenes->view();
                            $fecha = explode("-", $novedad['fecha']);
                            ?>
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 ">
                                <div class="ps-post--inside">
                                    <div class="ps-post__thumbnail"
                                         style="  height:500px; background:url(<?= URL . '/' . $img['ruta'] ?>) no-repeat center center/cover;">
                                        <a class="ps-post__overlay"
                                           href="<?= URL . '/nota/' . $funciones->normalizar_link($novedad["titulo"]) . '/' . $novedad['cod'] ?>"></a>
                                    </div>
                                    <div class="ps-post__content"><span
                                                class="ps-post__meta"><?= $fecha[2] . '/' . $fecha[1] . '/' . $fecha[0] ?></span><a
                                                class="ps-post__title"
                                                href="blog-detail.html"><?= ucfirst(substr(strip_tags($novedad['titulo']), 0, 50)); ?>
                                            …</a>
                                        <p><?= ucfirst(substr(strip_tags($novedad['desarrollo']), 0, 200)); ?>…</p><a
                                                class="ps-post__morelink"
                                                href="<?= URL . '/nota/' . $funciones->normalizar_link($novedad["titulo"]) . '/' . $novedad['cod'] ?>">Ver
                                            más</a>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    } elseif (@count($novedades_data) > 2) {
                    foreach ($novedades_data as $novedad) {
                        $imagenes->set("cod", $novedad['cod']);
                        $img = $imagenes->view();
                        $fecha = explode("-", $novedad['fecha']);
                        ?>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 visible-md visible-lg">
                            <div class="ps-post--inside">
                                <div class="ps-post__thumbnail hidden-xs"
                                     style="  height:510px; background:url(<?= URL . '/' . $img['ruta'] ?>) no-repeat center center/cover;">
                                    <a class="ps-post__overlay"
                                       href="<?= URL . '/nota/' . $funciones->normalizar_link($novedad["titulo"]) . '/' . $novedad['cod'] ?>"></a>
                                </div>
                                <div class="ps-post__content"><span
                                            class="ps-post__meta"><?= $fecha[2] . '/' . $fecha[1] . '/' . $fecha[0] ?></span><a
                                            class="ps-post__title"
                                            href="<?= URL . '/nota/' . $funciones->normalizar_link($novedad["titulo"]) . '/' . $novedad['cod'] ?>"><?= ucfirst(substr(strip_tags($novedad['titulo']), 0, 50)); ?>
                                        …</a>
                                    <p><?= ucfirst(substr(strip_tags($novedad['desarrollo']), 0, 200)); ?>…</p>
                                    <a
                                            class="ps-post__morelink"
                                            href="<?= URL . '/nota/' . $funciones->normalizar_link($novedad["titulo"]) . '/' . $novedad['cod'] ?>">Ver
                                        más</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 visible-xs">
                            <div class="ps-post--inside">
                                <div class="ps-post__thumbnail hidden-xs"
                                     style="  height:240px; background:url(<?= URL . '/' . $img['ruta'] ?>) no-repeat center center/cover;">
                                    <a class="ps-post__overlay"
                                       href="<?= URL . '/nota/' . $funciones->normalizar_link($novedad["titulo"]) . '/' . $novedad['cod'] ?>"></a>
                                </div>
                                <div class="ps-post__content"><span
                                            class="ps-post__meta"><?= $fecha[2] . '/' . $fecha[1] . '/' . $fecha[0] ?></span><a
                                            class="ps-post__title"
                                            href="<?= URL . '/nota/' . $funciones->normalizar_link($novedad["titulo"]) . '/' . $novedad['cod'] ?>"><?= ucfirst(substr(strip_tags($novedad['titulo']), 0, 50)); ?>
                                        …</a>
                                    <p><?= ucfirst(substr(strip_tags($novedad['desarrollo']), 0, 200)); ?>…</p>
                                    <a
                                            class="ps-post__morelink"
                                            href="<?= URL . '/nota/' . $funciones->normalizar_link($novedad["titulo"]) . '/' . $novedad['cod'] ?>">Ver
                                        más</a>
                                </div>
                            </div>
                        </div>
                        <?php
                        break;
                    }
                    ?>
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 ">
                        <div class="row">
                            <?php
                            foreach ($novedades_data as $novedad) {
                                $imagenes->set("cod", $novedad['cod']);
                                $img = $imagenes->view();
                                $fecha = explode("-", $novedad['fecha']);
                                ?>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                                    <div class="ps-post--inside small" data-mh="small">
                                        <div class="ps-post__thumbnail"
                                             style="  height:240px; background:url(<?= URL . '/' . $img['ruta'] ?>) no-repeat center center/cover;">
                                            <a class="ps-post__overlay"
                                               href="<?= URL . '/nota/' . $funciones->normalizar_link($novedad["titulo"]) . '/' . $novedad['cod'] ?>"></a>
                                        </div>
                                        <div class="ps-post__content"><span
                                                    class="ps-post__meta"><?= $fecha[2] . '/' . $fecha[1] . '/' . $fecha[0] ?></span><a
                                                    class="ps-post__title"
                                                    href="<?= URL . '/nota/' . $funciones->normalizar_link($novedad["titulo"]) . '/' . $novedad['cod'] ?>"><?= ucfirst(substr(strip_tags($novedad['titulo']), 0, 50)); ?></a><a
                                                    class="ps-post__morelink"
                                                    href="<?= URL . '/nota/' . $funciones->normalizar_link($novedad["titulo"]) . '/' . $novedad['cod'] ?>">Ver
                                                más</a>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>
<?php $template->themeEnd() ?>