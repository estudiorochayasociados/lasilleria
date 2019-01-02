<?php
require_once "Config/Autoload.php";
Config\Autoload::runSitio();
$template = new Clases\TemplateSite();
$funciones = new Clases\PublicFunction();
$contenidos = new Clases\Contenidos();

$template->set("title", "Pinturería Ariel | Inicio");
$template->set("description", "");
$template->set("keywords", "");
$template->set("favicon", LOGO);
$template->themeInit();

$id = isset($_GET["id"]) ? $_GET["id"] : '';
$contenidos->set("cod", $id);
$contenido = $contenidos->view();
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
            <div class="ps-404">
                <div class="container">
                    <h1>404 <span> Page not found</h1>
                    <p>We are looking for your page … but we can’t find it</p><a class="ps-btn" href="#">Back to Home</a><br><img src="images/404.png" alt="">
                </div>
            </div>
        </div>
    </main>
<?php
$template->themeEnd();
?>