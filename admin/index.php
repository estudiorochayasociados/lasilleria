<?php
require_once "../Config/Autoload.php";
Config\Autoload::runAdmin();

$template = new Clases\TemplateAdmin();
$template->set("title", "Admin");
$template->set("description", "Admin");
$template->set("keywords", "Inicio");
$template->set("favicon", "url");
$template->themeInit();
$admin = new Clases\Admin();
$funciones = new Clases\PublicFunction();

if (!isset($_SESSION["admin"])) {
    $admin->loginForm();
} else {
    $op = isset($_GET["op"]) ? $_GET["op"] : 'inicio';
    $accion = isset($_GET["accion"]) ? $_GET["accion"] : 'ver';
    if ($op != '') {
        if ($op == "salir") {
            session_destroy();
            $funciones->headerMove(URL . "/index.php");
        } else {
            $appId = MELI_ID;
            $secretKey = MELI_SECRET;
            $redirectURI = URL;
            $siteId = 'MLA';
            require_once '../Clases/Meli.php';
            $meli = new Meli($appId, $secretKey);
            if (isset($_SESSION['access_token'])) {
                $json_user = json_decode($funciones->curl("GET", "https://api.mercadolibre.com/users/me?access_token=" . $_SESSION["access_token"], ""));
                $json_orders = json_decode($funciones->curl("GET", "https://api.mercadolibre.com/orders/search?seller=$json_user->id&access_token=" . $_SESSION["access_token"], ""));
//echo "<pre>";var_dump($json_orders->results);echo "</pre>";
                $cantidad_de_productos = 0;
                $cantidad_de_plata = 0;
                foreach ($json_orders->results as $value) {
                    //echo "Cantidad: ".$value->order_items[0]->quantity." | ";
                    //echo "$".$value->total_amount." | ";
                    //echo "Estado: ".$value->payments[0]->status." | <hr/>";
                    $cantidad_de_productos += $value->order_items[0]->quantity;
                    $cantidad_de_plata += $value->total_amount;
                }
                if (is_object($json_user)) {
                    echo "<h2>Cantidad de productos vendidos en <img src='" . URL . "/img/meli.png' /> : $cantidad_de_productos ";
                    echo " | Cantidad de dinero recaudado en <img src='" . URL . "/img/meli.png' /> : $$cantidad_de_plata</h2>";
                }
            }

            include "inc/" . $op . "/" . $accion . ".php";
        }
    }
}

$template->themeEnd();
