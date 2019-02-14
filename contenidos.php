<?php
require_once "Config/Autoload.php";
Config\Autoload::runSitio();
$template = new Clases\TemplateSite();
$funciones = new Clases\PublicFunction();
$contenidos = new Clases\Contenidos();

$template->set("title", "La Sillería");
$template->set("description", "");
$template->set("keywords", "");
$template->set("favicon", LOGO);
$template->themeInit();

$id = isset($_GET["id"]) ? $_GET["id"] : '';
$replace_id = str_replace('-',' ',$id);
$contenidos->set("cod", $replace_id);
$contenido = $contenidos->view();
?>
    <div class="ps-hero bg--cover mb-60" >
        <div class="ps-container">
            <h3><?php if ($contenido!=null) {echo $contenido['cod']; } else{ echo "ERROR";} ?></h3>
            <div class="ps-breadcrumb">
                <ol class="breadcrumb">
                    <li><a href="<?= URL ?>/index">Inicio</a></li>
                    <li class="active"><?php if ($contenido!=null) {echo $contenido['cod']; } else{ echo "ERROR";} ?></li>
                </ol>
            </div>
        </div>
    </div>
    <main class="container-fluid">
        <div class="ps-container">
            <?php
            if ($contenido!=null){
                echo $contenido['contenido'];
            }else{
                ?>
                <div class="ps-404">
                    <div class="container">
                        <h1>404 <span> Página </h1>
                        <p>Ocurrió un error</p><a class="ps-btn" href="<?= URL ?>/index">Volver al inicio</a><br>
                    </div>
                </div>
                <?php
            }
            ?>

        </div>
    </main>
<?php
$template->themeEnd();
?>