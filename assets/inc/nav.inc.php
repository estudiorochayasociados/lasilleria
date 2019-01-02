<?php
$categorias = new Clases\Categorias();
$carrito = new Clases\Carrito();
$funciones = new Clases\PublicFunction();
$categorias_side = $categorias->list('');
$carro = $carrito->return();
?>
<div class="header--sidebar"></div>
<!--  Header-->
<header class="header" data-sticky="true">
    <div class="header__top">
        <div class="ps-container">
            <div class="row">
                <div class="col-lg-6 col-md-8 col-sm-6 col-xs-12 ">
                    <p>460 West 34th Street, 15th floor, New York - Hotline: 804-377-3580 - 804-399-3580</p>
                    <i class="furniture-market"></i>
                </div>
                <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12 ">
                    <div class="header__actions">
                        <a href="#" data-toggle="modal" data-target="#myModal">Iniciar sesión</a>
                        <a href="<?= URL ?>/usuarios">Registro</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <nav class="navigation">
        <div class="ps-container">
            <a class="ps-logo" href="index.html">
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
                            $precio_final =+ $carro_["precio"];
                            $opciones = @implode(",",$carro_["opciones"]);
                            ?>
                            <div class="ps-cart-item">
                                <a class="ps-cart-item__close" href="<?= URL ?>/carrito.php?remover=<?= $key ?>"></a>
                                <div class="ps-cart-item__content">
                                    <a class="ps-cart-item__title" href="<?= URL ?>/productos"><?= $carro_["titulo"] ?> <br/> <i style="font-size: 12px"><?= $opciones; ?></i></a>
                                    <?php if($carro_["precio"] != 0) { ?>
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
                        <p>Precio Total:<span>$<?= number_format($carrito->precio_total(),"2",",","."); ?></span></p>
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
                <li>
                    <a href="<?= URL ?>/c/empresa">Empresa</a>
                </li>
                <li class="menu-item-has-children">
                    <a href="#">Productos</a>
                    <ul class="sub-menu">
                        <?php
                        foreach ($categorias_side as $categorias_) {
                            echo '<li  class="menu-item-has-children"><a href="' . URL . '/productos/' . $funciones->normalizar_link($categorias_['titulo']) . '/' . $categorias_['cod'] . '">' . $categorias_['titulo'] . '</a></li>';
                        }
                        ?>
                    </ul>
                </li>
                <li>
                    <a href="#">Contacto</a>
                </li>
            </ul>
        </div>
    </nav>
</header>
