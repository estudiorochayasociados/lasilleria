<?php
$code_mercadolibre = isset($_GET["code"]) ? $_GET["code"] : '';

$productos = new Clases\Productos();
$imagenes = new Clases\Imagenes();
$zebra = new Clases\Zebra_Image();

$categorias = new Clases\Categorias();
$contenidos = new Clases\Contenidos();

$contenidos->set("cod", "TELAS");
$telas = $contenidos->view();
$telas = explode("||", strip_tags($telas["contenido"]));

$contenidos->set("cod", "CUERINAS");
$cuerinas = $contenidos->view();
$cuerinas = explode("||", strip_tags($cuerinas["contenido"]));

$contenidos->set("cod", "LUSTRES");
$lustre = $contenidos->view();
$lustre = explode("||", strip_tags($lustre["contenido"]));

$data = $categorias->list(array("area = 'productos'"));

$appId = MELI_ID;
$secretKey = MELI_SECRET;
$redirectURI = URL . "/index.php?op=productos&accion=agregar";
$siteId = 'MLA';
$url = 'https://api.mercadolibre.com/oauth/token';
$context = stream_context_create(array(
    'http' => array(
        'method' => 'POST',
        'header' => 'Content-type: application/x-www-form-urlencoded',
        'content' => http_build_query(
            array(
                'grant_type' => 'client_credentials',
                'client_id' => $appId,
                'client_secret' => $secretKey,
            )
        ),
        'timeout' => 60,
    ),
));

$resp = json_decode(file_get_contents($url, false, $context));
$meli = new Meli($appId, $secretKey, $resp->access_token, $resp->refresh_token);

if (isset($_POST["agregar"])) {
    $count = 0;
    $cod = substr(md5(uniqid(rand())), 0, 10);
    $productos->set("cod", $funciones->antihack_mysqli(isset($cod) ? $cod : ''));
    $productos->set("titulo", $funciones->antihack_mysqli(isset($_POST["titulo"]) ? $_POST["titulo"] : ''));
    $productos->set("cod_producto", $funciones->antihack_mysqli(isset($_POST["cod_producto"]) ? $_POST["cod_producto"] : ''));
    $productos->set("precio", $funciones->antihack_mysqli(isset($_POST["precio"]) ? $_POST["precio"] : ''));
    $productos->set("precio_descuento", $funciones->antihack_mysqli(isset($_POST["precio_descuento"]) ? $_POST["precio_descuento"] : '0'));
    $productos->set("stock", $funciones->antihack_mysqli(isset($_POST["stock"]) ? $_POST["stock"] : ''));
    $productos->set("desarrollo", $funciones->antihack_mysqli(isset($_POST["desarrollo"]) ? $_POST["desarrollo"] : ''));

    if (isset($_POST["variable1"])) {
        $productos->set("variable1", mb_strtoupper(implode("||", isset($_POST["variable1"]) ? $_POST["variable1"] : '')));
    }

    if (isset($_POST["variable2"])) {
        $productos->set("variable2", mb_strtoupper(implode("||", isset($_POST["variable2"]) ? $_POST["variable2"] : '')));
    }

    if (isset($_POST["variable3"])) {
        $productos->set("variable3", mb_strtoupper(implode("||", isset($_POST["variable3"]) ? $_POST["variable3"] : '')));
    }

    $productos->set("variable4", $funciones->antihack_mysqli(isset($_POST["peso"]) ? $_POST["peso"] : ''));
    $productos->set("variable5", $funciones->antihack_mysqli(isset($_POST["altura"]) ? $_POST["altura"] : ''));
    $productos->set("variable6", $funciones->antihack_mysqli(isset($_POST["ancho"]) ? $_POST["ancho"] : ''));
    $productos->set("variable7", $funciones->antihack_mysqli(isset($_POST["profundidad"]) ? $_POST["profundidad"] : ''));

    $productos->set("categoria", $funciones->antihack_mysqli(isset($_POST["categoria"]) ? $_POST["categoria"] : ''));
    $productos->set("subcategoria", $funciones->antihack_mysqli(isset($_POST["subcategoria"]) ? $_POST["subcategoria"] : ''));
    $productos->set("keywords", $funciones->antihack_mysqli(isset($_POST["keywords"]) ? $_POST["keywords"] : ''));
    $productos->set("description", $funciones->antihack_mysqli(isset($_POST["description"]) ? $_POST["description"] : ''));
    $productos->set("fecha", $funciones->antihack_mysqli(isset($_POST["fecha"]) ? $_POST["fecha"] : date("Y-m-d")));
    $productos->set("meli", $funciones->antihack_mysqli(isset($_POST["meli"]) ? $_POST["meli"] : ''));
    $productos->set("url", $funciones->antihack_mysqli(isset($_POST["url"]) ? $_POST["url"] : ''));
    $img_meli = '';
    foreach ($_FILES['files']['name'] as $f => $name) {
        $imgMELI = array();
        $imgInicio = $_FILES["files"]["tmp_name"][$f];
        $tucadena = $_FILES["files"]["name"][$f];
        $partes = explode(".", $tucadena);
        $dom = (count($partes) - 1);
        $dominio = $partes[$dom];
        $prefijo = substr(md5(uniqid(rand())), 0, 10);
        if ($dominio != '') {
            $destinoFinal = "../assets/archivos/" . $prefijo . "." . $dominio;
            move_uploaded_file($imgInicio, $destinoFinal);
            chmod($destinoFinal, 0777);
            $destinoRecortado = "../assets/archivos/recortadas/a_" . $prefijo . "." . $dominio;

            $zebra->source_path = $destinoFinal;
            $zebra->target_path = $destinoRecortado;
            $zebra->jpeg_quality = 80;
            $zebra->preserve_aspect_ratio = true;
            $zebra->enlarge_smaller_images = true;
            $zebra->preserve_time = true;

            if ($zebra->resize(800, 700, ZEBRA_IMAGE_NOT_BOXED)) {
                unlink($destinoFinal);
            }

            $imagenes->set("cod", $cod);
            $imagenes->set("ruta", str_replace("../", "", $destinoRecortado));
            $img_meli .= '{"source":"' . URLSITE . str_replace("../", "/", $destinoRecortado) . '"},';
            $imagenes->add();

        }
        $count++;
    }

    if ($meli != '') {
        $productos->set("img", substr($img_meli, 0, -1));
        $add_meli = $productos->add_meli();
        $productos->set("meli", $add_meli["id"]);
    }

    $productos->add();
    $funciones->headerMove(URL . "/index.php?op=productos");
}
?>

<div class="col-md-12">
    <h4>
        Productos
        <div class="pull-right">
            <input type="checkbox" class="form-check-input mt-10" name="meli" id="meli">
            <a href="<?= $meli->getAuthUrl($redirectURI, Meli::$AUTH_URL['MLA']) ?>" class="btn">
                ¿Publicar en MercadoLibre?
            </a>
        </div>
    </h4>
    <hr/>
    <form method="post" class="row" enctype="multipart/form-data">
        <label class="col-md-3">
            Título:<br/>
            <input type="text" name="titulo" required>
        </label>
        <label class="col-md-3">
            Categoría:<br/>
            <select name="categoria" required>
                <option value="" disabled selected>-- categorías --</option>
                <?php
                foreach ($data as $categoria) {
                    echo "<option value='" . $categoria["cod"] . "'>" . $categoria["titulo"] . "</option>";
                }
                ?>
            </select>
        </label>
        <label class="col-md-3">
            Stock:<br/>
            <input type="number" name="stock">
        </label>
        <label class="col-md-3">
            Código:<br/>
            <input type="text" name="cod_producto">
        </label>
        <label class="col-md-4">
            Precio:<br/>
            <input type="text" name="precio" required>
        </label>
        <div class="clearfix"></div>
        <label class="col-md-2">
            Altura: (cm)<br/>
            <input type="number" name="altura" required>
        </label>
        <label class="col-md-2">
            Ancho: (cm)<br/>
            <input type="number" name="ancho" required>
        </label>
        <label class="col-md-2">
            Profundidad: (cm)<br/>
            <input type="number" name="profundidad" required>
        </label>
        <label class="col-md-2">
            Peso: (kg)<br/>
            <input type="number" name="peso" required>
        </label>
        <div class="clearfix">
        </div>
        <div class="mt-10 col-md-12">
            Lustres
            <button type="button" class="ml-10 mb-5 btn btn-info pull-right" onclick="agregar_input('variaciones3Input','variable3')"> +</button>
            <div class="">
                <div id="variaciones3Input" class="row">
                    <?php
                    foreach ($lustre as $var3) {
                        $cod = rand(0, 999999999);
                        if ($var3 != '') {
                            ?>
                            <div class="col-md-3 input-group" id="<?= $cod ?>"><input type="text" value="<?= $var3 ?>" class="form-control mb-10 mr-10" name="variable3[]">
                                <div class="input-group-addon"><a href="#" onclick="$('#<?= $cod ?>').remove()" class="btn btn-danger"> - </a></div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <label class="col-md-12">
            Desarrollo:<br/>
            <textarea name="desarrollo" class="ckeditorTextarea">
                <h1><span style="font-size:16px">SILLAS DE MADERA GUATAMBÚ</span></h1>
                <b>MODELO:</b><br/>
                <b>DIMENSIONES:</b><br/>
                ALTO: cm<br/>
                ANCHO: cm<br/>
                PROFUNDIDAD: cm
                <hr/>
                LAS SILLAS DE <a href="https://lasilleria.com.ar" target="_blank">LASILLERIA.COM.AR</a> SON LA CONJUNCION DEL DISEÑO Y CALIDAD.<br/>
                CONSTRUIDA INTEGRAMENTE EN MADERA DE GUATAMBÚ SELECCIONADO DE PRIMERA CALIDAD CON SECADO NATURAL, LO QUE ASEGURA SU VIDA ETERNA.<br/>
                TONOS DE LUSTRE Y TAPIZADOS A ELECCIÓN INGRESANDO EN:<br/>
                <a href="https://lasilleria.com.ar/c/lustres-para-madera" target="_blank">https://lasilleria.com.ar/c/lustres-para-madera</a><br/><br/>
                POR TRATARSE DE <b>PRODUCTOS 100% PERSONALIZADOS ROGAMOS A LOS INTERESADOS CONSULTAR POR LA DEMORA EN LA ENTREGA.</b><br/>
                LAS SILLAS SE ENTREGAN EMBALADAS DE A DOS EN CAJAS DE CARTÓN CORRUGADO DE DOBLE FAZ ESPECIALMENTE DISEÑADAS PARA PROTEGERLAS EN EL TRAYECTO DESDE FÁBRICA HASTA SU HOGAR.<br/>
                PAGALAS HASTA EN <b>12 CUOTAS</b><br/>
            </textarea>
        </label>
        <div class="clearfix"></div>
        <label class="col-md-12">
            Palabras claves dividas por ,<br/>
            <input type="text" name="keywords">
        </label>
        <label class="col-md-12">
            Descripción breve<br/>
            <textarea name="description">
            </textarea>
        </label>
        <div class="col-md-12">
            <div class="form-group form-check">
                <?php
                if (isset($_GET['code']) || isset($_SESSION['access_token'])) {
                    if (isset($_GET['code']) && !isset($_SESSION['access_token'])) {
                        try {
                            $user = $meli->authorize($_GET["code"], $redirectURI);
                            $_SESSION['access_token'] = $user['body']->access_token;
                            $_SESSION['expires_in'] = time() + $user['body']->expires_in;
                            $_SESSION['refresh_token'] = $user['body']->refresh_token;
                        } catch (Exception $e) {
                            echo "Exception: ", $e->getMessage(), "\n";
                        }
                    } else {
                        if ($_SESSION['expires_in'] < time()) {
                            try {
                                $refresh = $meli->refreshAccessToken();
                                $_SESSION['access_token'] = $refresh['body']->access_token;
                                $_SESSION['expires_in'] = time() + $refresh['body']->expires_in;
                                $_SESSION['refresh_token'] = $refresh['body']->refresh_token;
                            } catch (Exception $e) {
                                echo "Exception: ", $e->getMessage(), "\n";
                            }
                        }
                    }
                    echo '<input type="checkbox" class="form-check-input" id="meli" name="meli" value="1"> <label class="form-check-label " style="font-size:19px" for="meli">¿Publicar en MercadoLibre?</label>';
                } else {
                    echo '<div class="ml-0 pl-0 mt-20 mb-20"><a  target="_blank" href="' . $meli->getAuthUrl($redirectURI, Meli::$AUTH_URL[$siteId]) . '"><img src="' . URL . '/img/meli.png" width="30" /> ¿Ingresar a Mercadolibre para publicar el producto <i class="fa fa-square green">?</i></a></div>';
                }
                ?>
            </div>
        </div>
        <label class="col-md-7">
            Imágenes:<br/>
            <input type="file" id="file" name="files[]" multiple="multiple" accept="image/*"/>
        </label>
        <div class="clearfix">
        </div>
        <br/>
        <div class="col-md-12">
            <input type="submit" class="btn btn-primary" name="agregar" value="Crear Productos"/>
        </div>
    </form>
</div>
