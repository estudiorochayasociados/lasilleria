<?php
$categorias = new Clases\Categorias();
$carrito = new Clases\Carrito();
$usuarios = new Clases\Usuarios();
$funciones = new Clases\PublicFunction();
$categorias_side = $categorias->list(array('area = "productos"'));
$carro = $carrito->return();
$usuario = $usuarios->view_sesion();
?>
<div class="header--sidebar"></div>
<!--  Header-->
<header class="header" data-sticky="true">
    <div class="header__top">
        <div class="ps-container">
            <div class="row">
                <div class="col-lg-6 col-md-8 col-sm-6 col-xs-12 ">
                    <p><? //DIRECCION . ", " . PROVINCIA . ", " . CIUDAD . " - " . TELEFONO ?></p>
                    <i class="furniture-market"></i>
                </div>
                <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12 ">
                    <div class="header__actions">
                        <?php
                        if (count($usuario) == 0) {
                            ?>
                            <a href="<?= URL ?>/login"><i class="fa fa-sign-in"></i> Iniciar sesión</a>
                            <a href="<?= URL ?>/usuarios"><i class="fa fa-key"></i> Registro</a>
                            <?php
                        } else {
                            ?>
                            <a href="<?= URL ?>/sesion"> <i class="fa fa-user"></i> Hola <?= $usuario["nombre"] . " " . $usuario["apellido"]; ?></a>
                            <a href="<?= URL ?>/sesion/salir"><i class="fa fa-sign-out"></i> Salir</a>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <nav class="navigation">
        <div class="ps-container">
            <a class="ps-logo" href="<?= URL ?>/index">
                <img src="<?= URL ?>/assets/images/logo.png" alt="">
            </a>
            <div class="menu-toggle">
                <span></span>
            </div>
            <div class="ps-cart">
                <a class="ps-cart__toggle" href="#">
                    <img src="<?= URL ?>/assets/images/market.svg" alt="">
                </a>
                <div class="ps-cart__listing">
                    <div class="ps-cart__content">
                        <?php
                        foreach ($carro as $key => $carro_) {
                            $precio_final = +$carro_["precio"];
                            $opciones = @implode(",", $carro_["opciones"]);
                            ?>
                            <div class="ps-cart-item">
                                <a class="ps-cart-item__close" href="<?= URL ?>/carrito.php?remover=<?= $key ?>"></a>
                                <div class="ps-cart-item__content">
                                    <a class="ps-cart-item__title" href="<?= URL ?>/productos"><?= $carro_["titulo"] ?> <br/> <i style="font-size: 12px"><?= $opciones; ?></i></a>
                                    <?php if ($carro_["precio"] != 0) { ?>
                                        <span>Cantidad:<i><?= $carro_["cantidad"] ?></i></span><br/>
                                        <span>Total:<i>$<?= $carro_["precio"] ?></i></span>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="ps-cart__total">
                        <p>Precio Total:<span>$<?= number_format($carrito->precio_total(), "2", ",", "."); ?></span></p>
                    </div>
                    <div class="ps-cart__footer">
                        <a class="ps-btn" href="<?= URL ?>/carrito">Pasar por caja <i class="furniture-next"></i> </a>
                    </div>
                </div>
            </div>
            <ul class="main-menu menu">
                <li>
                    <a href="<?= URL ?>/index">Inicio</a>
                </li>
                <li class="menu-item-has-children hidden-xs hidden-sm">
                    <a href="#">Productos</a>
                    <ul class="sub-menu">
                        <?php
                        foreach ($categorias_side as $categorias_) {
                            echo '<li  class="menu-item-has-children"><a href="' . URL . '/productos/' . $funciones->normalizar_link($categorias_['titulo']) . '/' . $categorias_['cod'] . '">' . $categorias_['titulo'] . '</a></li>';
                        }
                        ?>
                    </ul>
                </li>
                <?php
                foreach ($categorias_side as $categorias_) {
                    echo '<li class="hidden-lg hidden-md"><a href="' . URL . '/productos/' . $funciones->normalizar_link($categorias_['titulo']) . '/' . $categorias_['cod'] . '">' . $categorias_['titulo'] . '</a></li>';
                }
                ?>
                <li class="menu-item-has-children">
                    <a href="#">Tapizados</a>
                    <ul class="sub-menu">
                        <li class="menu-item-has-children"><a href="<?= URL ?>/c/cuerinas-para-tapizados">Cuerinas</a></li>
                        <li class="menu-item-has-children"><a href="<?= URL ?>/c/telas-para-tapizados">Telas</a></li>
                    </ul>
                </li>
                <li>
                    <a href="<?= URL ?>/c/lustres-para-madera">Lustres</a>
                </li>

                <li>
                    <a href="<?= URL ?>/blog">Blog</a>
                </li>
                <li>
                    <a href="<?= URL ?>/contacto">Contacto</a>
                </li>
            </ul>
        </div>
    </nav>
</header>
