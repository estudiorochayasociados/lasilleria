<?php

namespace config;
class autoload
{
    public static function runSitio()
    {
        require_once "Config/Minify.php";
        session_start();
        $_SESSION["cod_pedido"] = isset($_SESSION["cod_pedido"]) ? $_SESSION["cod_pedido"] : mb_strtoupper(substr(md5(uniqid(rand())), 0, 10));
        define('URL', "http://" . $_SERVER['HTTP_HOST'] . "/lasilleria");
        define('CANONICAL', "http://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
        define('TITULO', "La Sillería");
        define('TELEFONO', "(03564) 481249 / 481166 / 15631300");
        define('CIUDAD', "Devoto");
        define('PROVINCIA', "Córdoba");
        define('EMAIL', "info@lasilleria.com.ar");
        define('PASS_EMAIL', "inLa2019");
        define('SMTP_EMAIL', "c1470578.ferozo.com");
        define('DIRECCION', "25 de Mayo 339");
        define('LOGO', URL . "/assets/images/logo.png");
        define('APP_ID_FB', "");
        spl_autoload_register(
            function ($clase) {
                $ruta = str_replace("\\", "/", $clase) . ".php";
                include_once $ruta;
            }
        );
    }

    public static function runAdmin()
    {
        session_start();
        define('URLSITE', "http://" . $_SERVER['HTTP_HOST'] . "/lasilleria");
        define('URL', "http://" . $_SERVER['HTTP_HOST'] . "/lasilleria/admin");
        define('CANONICAL', "http://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
        define('MELI_ID',"6191487859296181");
        define('MELI_SECRET',"tFBnDaNNLCKNDyhY1ByAteiTwXTMcKR5");
        require_once "../Clases/Zebra_Image.php";
        require_once "../Clases/Meli.php";
        spl_autoload_register(
            function ($clase) {
                $ruta = str_replace("\\", "/", $clase) . ".php";
                include_once "../" . $ruta;
            }
        );
    }
}
