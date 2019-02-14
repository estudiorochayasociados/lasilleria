<?php
require_once "Config/Autoload.php";
Config\Autoload::runSitio();
$template = new Clases\TemplateSite();
$funciones = new Clases\PublicFunction();
$template->set("title", "La Sillería - CONTACTO");
$template->set("description", "Envianos un formulario de consulta y solicitá tu pedido de sillas de madera guatambu");
$template->set("keywords", "fábrica de sillas de madera guatambu,mayorista de sillas de madera guatambu");
$template->set("favicon", LOGO);
$novedades = new Clases\Novedades();
$imagenes = new Clases\Imagenes();
$enviar = new Clases\Email();
$template->themeInit();
?>
<div class="ps-hero bg--cover" data-background="<?=URL?>/assets/images/hero/bread-1.jpg">
    <div class="ps-container">
        <h3>Contacto</h3>
        <div class="ps-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="<?= URL ?>/index">Inicio</a></li>
                <li class="active">Contacto</li>
            </ol>
        </div>
    </div>
</div>

<div class="ps-contact">
    <div class="ps-container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                <?php
                if(isset($_POST['enviar'])){
                    $mensaje = "Nuevo mensaje de contacto <br/>";
                    $mensaje .= "Nombre: ".$_POST["nombre"]."<br/>";
                    $mensaje .= "Email: ".$_POST["email"]."<br/>";
                    $mensaje .= "Mensaje: ".$_POST["mensaje"]."<br/>";
                    $asunto = "Contacto";
                    $receptor = EMAIL;
                    $emisor = $_POST['email'];

                    $enviar->set("asunto", $asunto);
                    $enviar->set("receptor", $receptor);
                    $enviar->set("emisor", $emisor);
                    $enviar->set("mensaje", $mensaje);
                    $enviar->emailEnviar();
                    if ($enviar->emailEnviar()==1){
                        echo "<div class='alert alert-success'> Enviado con éxito. </div>";
                    }else{
                        echo "<div class='alert alert-danger'> Ocurrió un error, pruebe nuevamente. </div>";
                    }
                }
                ?>
                <form class="ps-form--contact" id="enviar" action="" method="post">
                    <div id="mensaje" class='col-md-12'>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                            <div class="form-group">
                                <label>Nombre <sup>*</sup></label>
                                <input class="form-control" name="nombre" type="text" placeholder="">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                            <div class="form-group">
                                <label>Email <sup>*</sup></label>
                                <input class="form-control" name="email" type="text" placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Tu mensaje <sup>*</sup></label>
                        <textarea class="form-control" name="mensaje" rows="7"></textarea>
                    </div>
                    <div class="form-group submit">
                       <!-- <button class="ps-btn pl-60 pr-60" name="enviar">Enviar</button>-->
                        <input type="submit" class="ps-btn pl-60 pr-60" name="enviar" value="Enviar" >
                    </div>
                </form>
            </div>
        </div>
    </div>
    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d4815.803965369139!2d-62.30371667996142!3d-31.406200191679925!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x642bb035403fc0c9!2sSan+Jose+Muebles!5e0!3m2!1ses!2sar!4v1546554734412" width="800" height="600" frameborder="0" style="border:0" allowfullscreen></iframe>
</div>
<?php $template->themeEnd() ?>
