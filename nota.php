<?php
require_once "Config/Autoload.php";
Config\Autoload::runSitio();
$template = new Clases\TemplateSite();
$funciones = new Clases\PublicFunction();
$novedades = new Clases\Novedades();
$imagenes = new Clases\Imagenes();

$cod = isset($_GET["cod"]) ? $_GET["cod"] : '0';
$novedades->set("cod",$cod);
$novedad=$novedades->view();
$imagenes->set("cod",$cod);
$img = $imagenes->view();

$template->set("title", $novedad["titulo"] . "");
$template->set("description", $novedad["description"]);
$template->set("keywords", $novedad["keywords"]);
$template->set("imagen", URL."/".$img["ruta"]);
$template->set("favicon", LOGO);


$template->themeInit();


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

<script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "NewsArticle",
        "mainEntityOfPage": {
            "@type": "WebPage",
            "@id": "https://google.com/article"
        },
        "headline": "<?= $novedad['titulo'] ?>",
        "image": [
            "<?=URL .'/'.$img['ruta'] ?>"
        ],
        "datePublished": "<?= $novedad['fecha'] ?>",
        "dateModified": "<?= $novedad['fecha'] ?>",
        "author": {
            "@type": "Person",
            "name": "La Silleria"
        },
        "publisher": {
            "@type": "Organization",
            "name": "La Silleria",
            "logo": {
                "@type": "ImageObject",
                "url": "<?= LOGO ?>"
            }
        },
        "description": "<?= $novedad['description'] ?>"
    }
</script>

<div class="ps-hero bg--cover" data-background="<?=URL?>/assets/images/hero/bread-1.jpg">
    <div class="ps-container">
        <h3><?=ucfirst($novedad['titulo'])?></h3>
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
        <div class="ps-blog">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                    <div class="ps-post--detail">
                        <h3 class="ps-post__title"><?=ucfirst($novedad['titulo'])?></h3>
                        <div class="ps-post__thumbnail"><img src="<?=URL .'/'.$img['ruta'] ?>" alt="<?=ucfirst($novedad['titulo'])?>"></div>
                        <div class="ps-post__content">
                            <div class="ps-post__meta">
                                <div class="ps-post__posted"><span class="date"><?=$fecha[2]?></span><span class="month"><?=$mes?></span></div>
                            </div>
                            <div class="ps-post__container">
                                <?=ucfirst($novedad['desarrollo'])?>
                            </div>
                        </div>
                        <!-- AddToAny BEGIN -->
                        <div class="a2a_kit a2a_kit_size_32 a2a_default_style derecha">
                            <a class="a2a_button_facebook"></a>
                            <a class="a2a_button_twitter"></a>
                            <a class="a2a_button_google_plus"></a>
                            <a class="a2a_button_pinterest"></a>
                            <a class="a2a_button_whatsapp"></a>
                            <a class="a2a_button_google_gmail"></a>
                        </div>
                        <script async src="https://static.addtoany.com/menu/page.js"></script>
                        <!-- AddToAny END -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php $template->themeEnd() ?>
