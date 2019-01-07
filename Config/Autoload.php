<?php
namespace config;
class autoload
{
    public static function runSitio()
    {
        session_start();
        $_SESSION["cod_pedido"] = isset($_SESSION["cod_pedido"]) ? $_SESSION["cod_pedido"] : mb_strtoupper(substr(md5(uniqid(rand())), 0, 10));
        define('URL', "http://".$_SERVER['HTTP_HOST']."/sanjosemuebles");
        define('CANONICAL', "http://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]);
        define('TITULO', "San José Muebles");
        define('TELEFONO', "(03564) 481249 / 481166 / 15631300");
        define('CIUDAD', "Devoto");
        define('PROVINCIA', "Córdoba");
        define('EMAIL', "sanjosemueblesdevoto@gmail.com");
        define('PASS_EMAIL', "");
        define('SMTP_EMAIL', "");
        define('DIRECCION', "25 de Mayo 339");
        define('LOGO', URL . "/assets/images/logo.png");
        define('APP_ID_FB', "");
        spl_autoload_register(
            function($clase)
            {
                $ruta = str_replace("\\", "/", $clase) . ".php";
                include_once $ruta;
            }
        );
    }

    public static function runAdmin()
    {
        session_start();
        define('URLSITE',"http://".$_SERVER['HTTP_HOST']."/sanjosemuebles");
        define('URL', "http://".$_SERVER['HTTP_HOST']."/sanjosemuebles/admin");
        define('CANONICAL', "http://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]);

        require_once "../Clases/Zebra_Image.php";
        require_once "../Clases/Meli.php";
        spl_autoload_register(
            function ($clase)
            {
                $ruta = str_replace("\\", "/", $clase) . ".php";
                include_once "../" . $ruta;
            }
        );
    }
}
