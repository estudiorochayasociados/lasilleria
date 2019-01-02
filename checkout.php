<?php
require_once "Config/Autoload.php";
Config\Autoload::runSitio();
$template = new Clases\TemplateSite();
$funciones = new Clases\PublicFunction();
$template->set("title", "Admin");
$template->set("description", "Admin");
$template->set("keywords", "Inicio");
$template->set("favicon", LOGO);
$template->themeInit();

$cod_pedido = isset($_GET["cod_pedido"]) ? $_GET["cod_pedido"] : '';
$tipo_pedido = isset($_GET["tipo_pedido"]) ? $_GET["tipo_pedido"] : '';
$carrito = new Clases\Carrito();
$pedidos = new Clases\Pedidos();
$pedidos->set("cod", $cod_pedido);
$pedido = $pedidos->view();
$usuarios = new Clases\Usuarios();
$usuarioSesion = $usuarios->view_sesion();
$carro = $carrito->return();
$precio = $carrito->precio_total();
$pedidos = new Clases\Pedidos();
if (is_array($pedido)) {
    $pedidos->set("cod", $cod_pedido);
    $pedidos->delete();
    foreach ($carro as $carroItem) {
        $opciones = @implode(",", $carroItem["opciones"]);
        $pedidos->set("cod", $cod_pedido);
        if ($opciones != '') {
            $pedidos->set("producto", mb_strtoupper($carroItem["titulo"] . " - " . $opciones));
        } else {
            $pedidos->set("producto", mb_strtoupper($carroItem["titulo"]));
        }
        $pedidos->set("cantidad", $carroItem["cantidad"]);
        $pedidos->set("precio", $carroItem["precio"]);
        $pedidos->set("estado", 0);
        $pedidos->set("tipo", $tipo_pedido);
        $pedidos->set("usuario", $usuarioSesion["cod"]);
        $pedidos->set("detalle", "");
        $pedidos->set("fecha", date('Y-m-d'));
        $pedidos->add();
    }
} else {
    foreach ($carro as $carroItem) {
        $opciones = @implode(",", $carroItem["opciones"]);
        $pedidos->set("cod", $cod_pedido);
        if ($opciones != '') {
            $pedidos->set("producto", mb_strtoupper($carroItem["titulo"] . " - " . $opciones));
        } else {
            $pedidos->set("producto", mb_strtoupper($carroItem["titulo"]));
        }
        $pedidos->set("cantidad", $carroItem["cantidad"]);
        $pedidos->set("precio", $carroItem["precio"]);
        $pedidos->set("estado", 0);
        $pedidos->set("tipo", $tipo_pedido);
        $pedidos->set("usuario", $usuarioSesion["cod"]);
        $pedidos->set("detalle", "");
        $pedidos->set("fecha", date('Y-m-d'));
        $pedidos->add();
    }
}

switch ($tipo_pedido) {
    case 0:
        //Transferencia o depósito bancario
        $pedidos->set("cod", $cod_pedido);
        $pedidos->set("estado", 0);
        $pedidos->cambiar_estado();
        $funciones->headerMove(URL . "/compra-finalizada.php");
        break;
    case 1:
        //Coordinar con el vendedor
        $pedidos->set("cod", $cod_pedido);
        $pedidos->set("estado", 0);
        $pedidos->cambiar_estado();
        $funciones->headerMove(URL . "/compra-finalizada.php");
        break;
    case 2:
        include("vendor/mercadopago/sdk/lib/mercadopago.php");
        $mp = new MP ("3087431389449841", "8V6jXmINfMLcpoEqV1cnVGQbEMnVwyjK");
        $preference_data = array(
            "items" => array(
                array(
                    "id" => $cod_pedido,
                    "title" => "COMPRA CÓDIGO N°:" . $cod_pedido,
                    "quantity" => 1,
                    "currency_id" => "ARS",
                    "unit_price" => $precio
                )
            ),
            "payer" => array(
                "name" => $usuarioSesion["nombre"],
                "surname" => $usuarioSesion["apellido"],
                "email" => $usuarioSesion["email"]
            ),
            "back_urls" => array(
                "success" => "/compra-finalizada.php?estado=1",
                "pending" => "/compra-finalizada.php?estado=0",
                "failure" => "/compra-finalizada.php?estado=2"
            ),
            "external_reference" => $cod_pedido,
            "auto_return" => "all",
            //"client_id" => $usuarioSesion["cod"],
            "payment_methods" => array(
                "excluded_payment_methods" => array(),
                "excluded_payment_types" => array(
                    array("id" => "ticket"),
                    array("id" => "atm")
                )
            )
        );
        $preference = $mp->create_preference($preference_data);
        echo "<iframe src='" . $preference["response"]["sandbox_init_point"] . "' width='100%' height='700px'></iframe>";
        break;
}
$template->themeEnd();
?>
