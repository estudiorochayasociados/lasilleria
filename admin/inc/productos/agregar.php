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

$appId = '2850401307770843';
$secretKey = 'FAyHI1wvuM4Q0ylT0YrlaKh4uBmv1ZNv';
$redirectURI = "http://localhost/sanjosemuebles/admin/index.php?op=productos&accion=agregar";
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
                'client_secret' => $secretKey
            )
        ),
        'timeout' => 60
    )
));

$resp = json_decode(file_get_contents($url, FALSE, $context));
$meli = new Meli($appId, $secretKey, $resp->access_token, $resp->refresh_token);

if (isset($_POST["agregar"])) {
    $count = 0;
    $cod = substr(md5(uniqid(rand())), 0, 10);
    $productos->set("cod", $funciones->antihack_mysqli(isset($cod) ? $cod : ''));
    $productos->set("titulo", $funciones->antihack_mysqli(isset($_POST["titulo"]) ? $_POST["titulo"] : ''));
    $productos->set("cod_producto", $funciones->antihack_mysqli(isset($_POST["cod_producto"]) ? $_POST["cod_producto"] : ''));
    $productos->set("precio", $funciones->antihack_mysqli(isset($_POST["precio"]) ? $_POST["precio"] : ''));
    $productos->set("precio_cuerina", $funciones->antihack_mysqli(isset($_POST["precio_cuerina"]) ? $_POST["precio_cuerina"] : ''));
    $productos->set("precio_telas", $funciones->antihack_mysqli(isset($_POST["precio_tela"]) ? $_POST["precio_tela"] : ''));
    $productos->set("precio_descuento", $funciones->antihack_mysqli(isset($_POST["precio_descuento"]) ? $_POST["precio_descuento"] : ''));
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
            $imagenes->add();
            array_push($imgMELI, array("source" => URLSITE . '/' . str_replace("../", "", $destinoRecortado)));
        }
        $count++;
    }

    if (isset($_POST["meli"])) {
        $user = $meli->authorize($_GET["code"], $redirectURI);
        $_SESSION['access_token'] = $user['body']->access_token;
        $_SESSION['expires_in'] = $user['body']->expires_in;
        $_SESSION['refresh_token'] = $user['body']->refresh_token;
        if ($_SESSION['expires_in'] + time() + 1 < time()) {
            try {
                print_r($meli->refreshAccessToken());
            } catch (Exception $e) {
                echo "Exception: ", $e->getMessage(), "\n";
            }
        }
        $itemAdd = array(
            "title" => $_POST["titulo"],
            "category_id" => "MLA1627",
            "price" => $_POST["precio"],
            "currency_id" => "ARS",
            "available_quantity" => $_POST["stock"],
            "buying_mode" => "buy_it_now",
            "listing_type_id" => "gold_special",
            "condition" => "new",
            "description" => "",
            "shipping" => array(
                "mode" => "me2",
                "dimensions" => $_POST["ancho"] . "x" . $_POST["altura"] . "x" . $_POST["profundidad"] . "," . $_POST["peso"] . "",
                "local_pick_up" => true,
                "free_shipping" => false,
                "logistic_type" => "cross_docking",
                "store_pick_up" => false
            ),
            "attributes" => array(
                array(
                    "id" => "UPHOLSTERED",
                    "name" => "Tapizado",
                    "value_id" => null,
                    "value_name" => "SI",
                    "value_struct" => null,
                    "attribute_group_id" => "DFLT",
                    "attribute_group_name" => "Otros"
                ),
                array(
                    "id" => "BRAND",
                    "name" => "Marca",
                    "value_id" => null,
                    "value_name" => "SAN JOSÉ MUEBLES",
                    "value_struct" => null,
                    "attribute_group_id" => "OTHERS",
                    "attribute_group_name" => "Otros"
                ),
                array(
                    "id" => "CHAIR_DESIGN",
                    "name" => "Diseño de la silla",
                    "value_id" => null,
                    "value_name" => "RT",
                    "value_struct" => null,
                    "attribute_group_id" => "OTHERS",
                    "attribute_group_name" => "Otros"
                ),
                array(
                    "id" => "CHAIR_HEIGHT",
                    "name" => "Altura total",
                    "value_id" => null,
                    "value_name" => $_POST["altura"] . " cm",
                    "value_struct" => array(
                        "number" => $_POST["altura"],
                        "unit" => "cm"
                    ),
                    "attribute_group_id" => "OTHERS",
                    "attribute_group_name" => "Otros"
                ),
                array(
                    "id" => "CHAIR_WIDTH",
                    "name" => "Ancho de la silla",
                    "value_id" => null,
                    "value_name" => $_POST["altura"] . " cm",
                    "value_struct" => array(
                        "number" => $_POST["altura"],
                        "unit" => "cm"
                    ),
                    "attribute_group_id" => "OTHERS",
                    "attribute_group_name" => "Otros"
                ),
                array(
                    "id" => "CHAIR_DEPTH",
                    "name" => "Profundidad de la silla",
                    "value_id" => null,
                    "value_name" => $_POST["profundidad"] . " cm",
                    "value_struct" => array(
                        "number" => $_POST["profundidad"],
                        "unit" => "cm"
                    ),
                    "attribute_group_id" => "OTHERS",
                    "attribute_group_name" => "Otros"
                ),
                array(
                    "id" => "GTIN",
                    "name" => "Código universal de producto",
                    "value_id" => "-1",
                    "value_name" => null,
                    "value_struct" => null,
                    "attribute_group_id" => "OTHERS",
                    "attribute_group_name" => "Otros"
                ),
                array(
                    "id" => "INCLUDES_UPHOLSTERY",
                    "name" => "Incluye tapizado",
                    "value_id" => "242085",
                    "value_name" => "Sí",
                    "value_struct" => null,
                    "attribute_group_id" => "OTHERS",
                    "attribute_group_name" => "Otros"
                ),
                array(
                    "id" => "ITEM_CONDITION",
                    "name" => "Condición del ítem",
                    "value_id" => "2230284",
                    "value_name" => "Nuevo",
                    "value_struct" => null,
                    "attribute_group_id" => "OTHERS",
                    "attribute_group_name" => "Otros"
                ),
                array(
                    "id" => "MANUFACTURER",
                    "name" => "Fabricante",
                    "value_id" => null,
                    "value_name" => "SAN JOSÉ MUEBLES",
                    "value_struct" => null,
                    "attribute_group_id" => "OTHERS",
                    "attribute_group_name" => "Otros"
                ),
                array(
                    "id" => "MODEL",
                    "name" => "Modelo",
                    "value_id" => null,
                    "value_name" => $_POST["titulo"],
                    "value_struct" => null,
                    "attribute_group_id" => "OTHERS",
                    "attribute_group_name" => "Otros"
                ),
                array(
                    "id" => "NUMBER_OF_CHAIRS_BY_SET",
                    "name" => "Número de sillas por set",
                    "value_id" => "-1",
                    "value_name" => null,
                    "value_struct" => null,
                    "attribute_group_id" => "OTHERS",
                    "attribute_group_name" => "Otros"
                ),
                array(
                    "id" => "SEAT_MATERIAL",
                    "name" => "Material del asiento",
                    "value_id" => null,
                    "value_name" => "SILLA EN GUATAMBU TAPIZADO",
                    "value_struct" => null,
                    "attribute_group_id" => "OTHERS",
                    "attribute_group_name" => "Otros"
                ),
                array(
                    "id" => "SEAT_MATERIAL",
                    "name" => "Material del asiento",
                    "value_id" => null,
                    "value_name" => "SILLA EN GUATAMBU TAPIZADO",
                    "value_struct" => null,
                    "attribute_group_id" => "OTHERS",
                    "attribute_group_name" => "Otros"
                ),
                array(
                    "id" => "STRUCTURE_MATERIALS",
                    "name" => "Materiales de la estructura",
                    "value_id" => "432174",
                    "value_name" => "Madera",
                    "value_struct" => null,
                    "attribute_group_id" => "OTHERS",
                    "attribute_group_name" => "Otros"
                ),
                array(
                    "id" => "NUMBER_OF_CHAIRS_BY_SET",
                    "name" => "Número de sillas por set",
                    "value_id" => null,
                    "value_name" => "1",
                    "value_struct" => null,
                    "attribute_group_id" => "OTHERS",
                    "attribute_group_name" => "Otros"
                ),
                array(
                    "id" => "UPHOLSTERY_FABRIC",
                    "name" => "Tela del tapizado",
                    "value_id" => null,
                    "value_name" => "Tela/Cuerina/Madera",
                    "value_struct" => null,
                    "attribute_group_id" => "OTHERS",
                    "attribute_group_name" => "Otros"
                )
            ),
            "pictures" => array(//$imgMELI
            ));
        $valor = $meli->post('/items', $itemAdd, array('access_token' => $_SESSION['access_token']));
        if ($valor["httpCode"] != "200" || $valor["httpCode"] != "201") {
            echo $valor["body"]->id;
            $productos->set("meli", $valor["body"]->id);
        }
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
        <label class="col-md-4">
            Precio Cuerina:<br/>
            <input type="text" name="precio_cuerina" required>
        </label>
        <label class="col-md-4">
            Precio Tela:<br/>
            <input type="text" name="precio_tela" required>
        </label>
        <div class="clearfix"></div>
        <label class="col-md-3">
            Altura: (cm)<br/>
            <input type="number" name="altura" required>
        </label>
        <label class="col-md-3">
            Ancho: (cm)<br/>
            <input type="number" name="ancho" required>
        </label>
        <label class="col-md-3">
            Profundidad: (cm)<br/>
            <input type="number" name="profundidad" required>
        </label>
        <label class="col-md-3">
            Peso: (cm)<br/>
            <input type="number" name="peso" required>
        </label>
        <div class="clearfix">
        </div>
        <div class="mt-10 col-md-12">
            Cuerinas
            <button type="button" class="ml-10 mb-5 btn btn-info pull-right" onclick="agregar_input('variaciones1Input','variable1')"> +</button>
            <div class="">
                <div id="variaciones1Input" class="row">
                    <?php
                    foreach ($cuerinas as $var1) {
                        $cod = rand(0, 999999999);
                        if ($var1 != '') {
                            ?>
                            <div class="col-md-3 input-group" id="<?= $cod ?>"><input type="text" value="<?= $var1 ?>" class="form-control mb-10 mr-10" name="variable1[]">
                                <div class="input-group-addon"><a href="#" onclick="$('#<?= $cod ?>').remove()" class="btn btn-danger"> - </a></div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="mt-10 col-md-12">
            Telas
            <button type="button" class="ml-10 mb-5 btn btn-info pull-right" onclick="agregar_input('variaciones2Input','variable2')"> +</button>
            <div class="">
                <div id="variaciones2Input" class="row">
                    <?php
                    foreach ($telas as $var2) {
                        $cod = rand(0, 999999999);
                        if ($var2 != '') {
                            ?>
                            <div class="col-md-3 input-group" id="<?= $cod ?>"><input type="text" value="<?= $var2 ?>" class="form-control mb-10 mr-10" name="variable2[]">
                                <div class="input-group-addon"><a href="#" onclick="$('#<?= $cod ?>').remove()" class="btn btn-danger"> - </a></div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
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
        <div class="clearfix">
        </div>
        <label class="col-md-12">
            Desarrollo:<br/>
            <textarea name="desarrollo" class="ckeditorTextarea">
            </textarea>
        </label>
        <div class="clearfix">
        </div>
        <label class="col-md-12">
            Palabras claves dividas por ,<br/>
            <input type="text" name="keywords">
        </label>
        <label class="col-md-12">
            Descripción breve<br/>
            <textarea name="description">
            </textarea>
        </label>
        <br/>
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
