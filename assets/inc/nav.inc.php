<?php
$funcionesNav = new Clases\PublicFunction();
//Clases
$imagenesNav = new Clases\Imagenes();
$categoriasNav = new Clases\Categorias();
$bannersNav = new Clases\Banner();
$carrito = new Clases\Carrito();
//Banners
$categoriasDataNav = $categoriasNav->list('');
foreach($categoriasDataNav as $valNav){
    if($valNav['titulo']=='Botonera' && $valNav['area']=='banners'){ 
        $bannersNav->set("categoria",$valNav['cod']);
        $banDataBotonera = $bannersNav->listForCategory();
    }
}
$carro = $carrito->return(); 
?>
    <div id="sns_wrapper">      
        <!-- HEADER -->
        <div id="sns_header" class="wrap">
            <!-- Header Top -->
            <div class="sns_header_top" >
                <div class="container">
                    <div class="sns_module">

                        <div class="header-setting">
                            <div class="module-setting visible-lg visible-md mt-10">
                                    <span style="color: white;"> (03564) 438484-443393 , Las Malvinas 930 - San Francisco (CBA).</span>
                            </div>
                            <div class="module-setting visible-xs mt-10">
                                <span style="color: white;"> (03564) 438484-443393</span>
                            </div>
                        </div>
                        <div class="header-account">
                            <div class="myaccount">
                                <div class="tongle">
                                    <i class="fa fa-user"></i>
                                    <span>Mi cuenta</span>
                                    <i class="fa fa-angle-down"></i>
                                </div>
                                <div class="customer-ct content">
                                    <ul class="links">
                                        <li>
                                            <a class="top-link-cart" title="Checkout" href="#">Carrito</a>
                                        </li>
                                        <li class=" last">
                                            <a class="top-link-login" title="Log In" href="#">Iniciar sesión</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Header Logo -->
            <div id="sns_header_logo">
                <div class="container">
                    <div class="container_in">
                        <div class="row">
                            <h1 id="logo" class=" responsv col-md-3">
                                <a href="<?=URL . '/index' ?>">
                                 <img alt="" src="<?=URL?>/assets/archivos/logo-grande.png"> 
                             </a>
                         </h1>
                         <div class="col-md-9 policy">
                            <?php
                            if (count($banDataBotonera)!=''){
                                $banRandBotonera = $banDataBotonera[array_rand($banDataBotonera)];
                                $imagenesNav->set("cod",$banRandBotonera['cod']);
                                $imgRandBotonera = $imagenesNav->view();
                                $bannersNav->set("id",$banRandBotonera['id']);
                                $valueNav=$banRandBotonera['vistas']+1;
                                $bannersNav->set("vistas",$valueNav);
                                $bannersNav->increaseViews();
                                ?>
                                <div class="block banner_left2 block_cat">
                                    <a class="banner5" href="<?= $banRandBotonera['link'] ?>">
                                        <img src="<?=URL. '/' . $imgRandBotonera['ruta'] ?>" alt="<?= $banRandBotonera['nombre']?>" style="width:100%;margin-top:10px;">
                                    </a>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Menu -->
        <div id="sns_menu" >
            <div class="container">
                <div class="sns_mainmenu">
                    <div id="sns_mainnav">
                        <div id="sns_custommenu" class="visible-md visible-lg visible-sm">
                            <ul class="mainnav">
                                <li class="level0 custom-item active">
                                    <a class="menu-title-lv0 pd-menu116" href="<?=URL . '/index' ?>" target="_self">
                                        <span class="title">Inicio</span>
                                    </a>
                                </li>
                                <li class="level0 custom-item">
                                    <a class=" menu-title-lv0" href="<?=URL . '/productos' ?>">
                                        <span class="title">Todos los productos</span>
                                    </a> 
                                </li>
                                <li class="level0 custom-item">
                                    <a class="menu-title-lv0" href="<?=URL . '/blogs' ?>">
                                        <span class="title">Blog</span>
                                    </a>
                                </li>
                                <li class="level0 custom-item">
                                    <a class="menu-title-lv0" href="<?=URL . '/contacto' ?>">
                                        <span class="title">Contactanos</span>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div id="sns_mommenu" class="menu-offcanvas hidden-md hidden-lg ">
                            <div id="sns_mommenu" class="menu-offcanvas hidden-md hidden-lg">

                                <span class="btn2 btn-navbar offcanvas">
                                        <i class="fa fa-align-justify"></i>
                                        <span class="overlay"></span>
                                    </span>
                                <span class="btn2 btn-navbar rightsidebar">
                                        <i class="fa fa-align-right"></i>
                                        <span class="overlay"></span>
                                    </span>
                                <div id="menu_offcanvas" class="offcanvas">
                                    <ul class="mainnav">
                                        <li class="level0 custom-item">
                                            <div class="accr_header">
                                                <a class="menu-title-lv0" href="<?=URL . '/inicio' ?>">
                                                    <span class="title">Inicio</span>
                                                </a>
                                            </div>
                                        </li>

                                        <li class="level0 nav-5 first active">
                                            <div class="accr_header">
                                                <a class=" menu-title-lv0" href="<?=URL . '/productos' ?>">
                                                    <span>Todos los productos</span>
                                                </a>
                                            </div>
                                        </li>

                                        <li class="level0 nav-5 first active">
                                            <div class="accr_header">
                                                <a class=" menu-title-lv0" href="<?=URL . '/blogs' ?>">
                                                    <span>Blog</span>
                                                </a>
                                            </div>
                                        </li>
                                        <li class="level0 nav-5 first active">
                                            <div class="accr_header">
                                                <a class=" menu-title-lv0" href="<?=URL . '/contacto' ?>">
                                                    <span>Contacto</span>
                                                </a>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="sns_menu_right">
                        <div class="block_topsearch">
                         <div class="top-cart">
                            <div class="mycart mini-cart">
                                <div class="block-minicart">
                                    <div class="tongle">
                                        <i class="fa fa-shopping-cart"></i>
                                        <div class="summary">
                                            <span class="amount">
                                                <a href="#">
                                                    <span><?= count($carro) ?></span>
                                                    ( items )
                                                </a>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="block-content content">
                                        <div class="block-inner">
                                            <ol id="cart-sidebar" class="mini-products-list">
                                               <?php
                                               if(isset($_POST["eliminarCarrito"])) {
                                                   $carrito->delete($_POST["eliminarCarrito"]);
                                               }

                                               $i=0;
                                               $precio = 0;
                                               foreach($carro as $carroItem) {
                                                $precio += ($carroItem["precio"]*$carroItem["cantidad"]);
                                                ?>
                                                <li class="item odd">
                                                    <div class="product-details">
                                                        <form method="post">
                                                            <input type="hidden" name="eliminarCarrito" value="<?= $i ?>">
                                                            <button class="btn-remove" onclick="return confirm('Are you sure you would like to remove this item from the shopping cart?').;" type="submit">Remove This Item</button>                                                                    
                                                        </form>
                                                        <p class="product-name">
                                                            <?= $carroItem["titulo"]; ?> (<?= $carroItem["cantidad"]; ?>)
                                                        </p>
                                                        <span class="price"><?= "$".$carroItem["precio"]; ?></span>
                                                    </div>
                                                </li> 
                                                <?php 
                                                $i++;
                                            } 
                                            ?>
                                        </ol>
                                        <p class="cart-subtotal">
                                            <span class="label">Total:</span>
                                            <span class="price">$ <?= $precio ?></span>
                                        </p>
                                        <div class="actions">
                                            <a href="<?= URL."/carrito" ?>">Pasar por caja</a>                                        
                                            <a class="button gfont go-to-cart" href="<?= URL."/productos" ?>">Seguir comprando</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <span class="icon-search"></span>
                    <div class="top-search">
                        <div id="sns_serachbox_pro11739847651442478087" class="sns-serachbox-pro">
                            <div class="sns-searbox-content">
                                <form id="search_mini_form3703138361442478087" method="get" action="http://demo.snstheme.com/sns-simen/index.php/catalogsearch/result/">
                                    <div class="form-search">
                                        <input id="search3703138361442478087" class="input-text" type="text" value="" name="q" placeholder="Que desea buscar...." size="30" autocomplete="off">
                                        <button class="button form-button" title="Search" type="submit">Buscar</button>
                                        <div id="search_autocomplete3703138361442478087" class="search-autocomplete" style="display: none;"></div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
    </div>
            <!-- AND HEADER -->