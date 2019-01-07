<?php
require_once "Config/Autoload.php";
Config\Autoload::runSitio();
$template = new Clases\TemplateSite();
$funciones = new Clases\PublicFunction();
$template->set("title", "SAN JOSÉ MUEBLES - BLOG");
$template->set("description", "Enterate de las mejores novedades sobres las sillas , banquetas y bancos de guatambu");
$template->set("keywords", "novedades de sillas de madera,tendencias de sillas de madera,sillas de madera guatambu");
$template->set("favicon", LOGO);
$novedades = new Clases\Novedades();
$imagenes = new Clases\Imagenes();
$template->themeInit();

$pagina = isset($_GET["pagina"]) ? $_GET["pagina"] : '0';

$cantidad = 6;

if ($pagina > 0) {
    $pagina = $pagina - 1;
}

if (@count($_GET) > 1) {
    $anidador = "&";
} else {
    $anidador = "?";
}

if (isset($_GET['pagina'])):
    $url = $funciones->eliminar_get(CANONICAL, 'pagina');
else:
    $url = CANONICAL;
endif;

$novedades_data = $novedades->listWithOps("", "", $cantidad * $pagina . ',' . $cantidad);
$numeroPaginas = $novedades->paginador("", $cantidad);
//
?>
<div class="ps-hero bg--cover" data-background="<?= URL ?>/assets/images/hero/bread-1.jpg">
    <div class="ps-container">
        <h3>Blog</h3>
        <div class="ps-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="<?= URL ?>/index">Inicio</a></li>
                <li class="active">Blog</li>
            </ol>
        </div>
    </div>
</div>
<main class="ps-main">
    <div class="ps-container">
        <div class="row">
            <?php
            foreach ($novedades_data as $novedad) {
                $imagenes->set("cod", $novedad['cod']);
                $img = $imagenes->view();
                $fecha = explode("-", $novedad['fecha']);
                switch ($fecha[1]) {
                    case "1":
                        $mes = "ENE";
                        break;
                    case "2":
                        $mes = "FEB";
                        break;
                    case "3":
                        $mes = "MAR";
                        break;
                    case "4":
                        $mes = "ABR";
                        break;
                    case "5":
                        $mes = "MAY";
                        break;
                    case "6":
                        $mes = "JUN";
                        break;
                    case "7":
                        $mes = "JUL";
                        break;
                    case "8":
                        $mes = "AGO";
                        break;
                    case "9":
                        $mes = "SEP";
                        break;
                    case "10":
                        $mes = "OCT";
                        break;
                    case "11":
                        $mes = "NOV";
                        break;
                    case "12":
                        $mes = "DIC";
                        break;
                }
                ?>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 ">
                    <article class="ps-post--vertical">
                        <div class="ps-post__thumbnail" style="  height:200px; background:url(<?= URL . '/' . $img['ruta'] ?>) no-repeat center center/cover;" ><a class="ps-post__overlay" href="<?= URL . '/nota/' . $funciones->normalizar_link($novedad["titulo"]) . '/' . $novedad['cod'] ?>"></a>
                        </div>
                        <div class="ps-post__content">
                            <div class="ps-post__meta">
                                <div class="ps-post__posted"><span class="date"><?= $fecha[2] ?></span><span
                                            class="month"><?=$mes?></span></div>
                            </div>
                            <div class="ps-block__container">
                                <h3 class="ps-post__title"><a
                                            href="<?= URL . '/nota/' . $funciones->normalizar_link($novedad["titulo"]) . '/' . $novedad['cod'] ?>"><?= ucfirst(substr(strip_tags($novedad['titulo']), 0, 50)); ?>…</a>
                                </h3>
                                <p><?= ucfirst(substr(strip_tags($novedad['desarrollo']), 0, 200)); ?>…</p><a
                                        class="ps-post__morelink" href="<?= URL . '/nota/' . $funciones->normalizar_link($novedad["titulo"]) . '/' . $novedad['cod'] ?>">Ver más</a>
                            </div>
                        </div>
                    </article>
                </div>
                <?php
            }
            ?>
        </div>
        <!--
        <div class="ps-pagination">
            <ul class="pagination">
                <li><a href="#"><i class="fa fa-angle-left"></i></a></li>
                <li class="active"><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">4</a></li>
                <li><a href="#"><i class="fa fa-angle-right"></i></a></li>
            </ul>
        </div>-->
        <?php if ($numeroPaginas > 1): ?>
            <div class="ps-pagination">
                <ul class="pagination text-center">
                    <?php if (($pagina + 1) > 1): ?>
                        <li><a href="<?= $url ?><?= $anidador ?>pagina=<?= $pagina ?>"><i
                                        class="fa fa-angle-left" aria-hidden="true"></i></a></li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $numeroPaginas; $i++): ?>
                        <li class="<?php if ($i == $pagina + 1) {
                            echo "active";
                        } ?>"><a href="<?= $url ?><?= $anidador ?>pagina=<?= $i ?>"><?= $i ?></a></li>
                    <?php endfor; ?>

                    <?php if (($pagina + 2) <= $numeroPaginas): ?>
                        <li><a href="<?= $url ?><?= $anidador ?>pagina=<?= ($pagina + 2) ?>"><i
                                        class="fa fa-angle-right" aria-hidden="true"></i></a></li>
                    <?php endif; ?>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</main>
<?php $template->themeEnd() ?>
