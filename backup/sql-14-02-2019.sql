SET FOREIGN_KEY_CHECKS = 0;
CREATE DATABASE IF NOT EXISTS `lasilleria`;
USE `lasilleria`;

DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO `admin` VALUES("1", "facundo@estudiorochayasoc.com.ar", "faAr2010"); 


DROP TABLE IF EXISTS ` banners`;
CREATE TABLE `banners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cod` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `categoria` varchar(255) NOT NULL,
  `vistas` int(11) NOT NULL DEFAULT '0',
  `link` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



DROP TABLE IF EXISTS ` categorias`;
CREATE TABLE `categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cod` varchar(255) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `area` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

INSERT INTO ` categorias` VALUES("2", "90bba30b6f", "SILLAS", "productos"); 
INSERT INTO ` categorias` VALUES("4", "94dde10cc8", "General", "novedades"); 


DROP TABLE IF EXISTS ` contenidos`;
CREATE TABLE `contenidos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contenido` longtext,
  `cod` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

INSERT INTO ` contenidos` VALUES("4", "<div class=\"btgrid\">
INSERT INTO ` contenidos` VALUES("5", "<h3>&iquest;Quer&eacute;s Recibir tu cup&oacute;n de descuento?</h3>
INSERT INTO ` contenidos` VALUES("6", "<p>&iexcl;Muchas gracias!<br />
INSERT INTO ` contenidos` VALUES("7", "<h2 style=\"text-align:center\"><span style=\"color:#27ae60; font-family:Tahoma,Geneva,sans-serif\"><span style=\"font-size:36px\"><strong>PAGANOS EN<br />
INSERT INTO ` contenidos` VALUES("8", "<p>fasfa</p>
INSERT INTO ` contenidos` VALUES("9", "<div class=\"col-md-6\">San Jos&eacute; Muebles S.R.L., nace 1992 en Devoto (Pcia. de C&oacute;rdoba, un peque&ntilde;o pueblo de algo m&aacute;s de 5000 habitantes, casi como una &ldquo;aventura&rdquo; de tres j&oacute;venes amigos de la infancia (Juan Jos&eacute;, Mauricio Jos&eacute; y Domingo Jos&eacute;), dos de los cuales ten&iacute;an conocimientos de carpinter&iacute;a y el tercero contador p&uacute;blico.
INSERT INTO ` contenidos` VALUES("10", "<p>NATURAL||ROBLE||CEDRO||CAOBA||CEREZO||NOGAL||CHOCOLATE||WENGE</p>
INSERT INTO ` contenidos` VALUES("11", "<div class=\"btgrid\">
INSERT INTO ` contenidos` VALUES("13", "<p>REIK FLORCITAS||AZ&Uacute;CAR DORADO||BELA GRIS||GEOMETRICO TRIANGULO||BELO NEGRO PLATA||GLOSS WALL PERLA||LINO AMBAR AMAPOLA CEMENTO||NEW YORK GAMUZA||ROMA RAYA CARMIN||MOLINO||LINO AMBAR CEREZO BEIGE||PANNE FUCSIA||PANNE OCEANO||REIK BEIGE LINO||REIK AGUA MARINA||RIBON ORANGE||ESLABONAS FUCSIA||ELECTRO ||AGUA||CAPULLOS CORAL||BULGARO DENIM||DELTA CRUDO||GLOSS WALL BEIGE||NORA RAYA PELTRE</p>
INSERT INTO ` contenidos` VALUES("14", "<div class=\"btgrid\">
INSERT INTO ` contenidos` VALUES("15", "<p>AREIA||BEIGE||BLANCO||CHOCOLATE||HUESO||MA&Iacute;Z||NEGRO||ROJO||NOVO SP PATCH NEGRO||NOVO SP PATCH MARFIL||NOVO SP PATCH CHOCOLATE||LINEN GRIS NOCHE||LINEN GRIS NIEBLA||COMFORT MOX LIVING STONE</p>
INSERT INTO ` contenidos` VALUES("16", "<p>&nbsp;</p>
INSERT INTO ` contenidos` VALUES("17", "<div class=\"btgrid\">


DROP TABLE IF EXISTS ` envios`;
CREATE TABLE `envios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cod` varchar(255) NOT NULL,
  `titulo` text NOT NULL,
  `peso` int(11) DEFAULT NULL,
  `precio` float NOT NULL,
  `estado` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

INSERT INTO ` envios` VALUES("1", "390dfb5cef", "Correo Argentino a Sucursal", "5", "500", "0"); 
INSERT INTO ` envios` VALUES("2", "501ff28bc8", "Envio gratis en Devoto", "0", "0", "0"); 
INSERT INTO ` envios` VALUES("3", "cfd6ca5826", "Envio gratis a San Francisco Córdoba", "0", "0", "0"); 
INSERT INTO ` envios` VALUES("4", "56aa199ade", "Envio Correo Argentino", "10", "500", "0"); 
INSERT INTO ` envios` VALUES("5", "5a9153e4e3", "Coordinar con el vendedor", "0", "0", "0"); 


DROP TABLE IF EXISTS ` galerias`;
CREATE TABLE `galerias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cod` varchar(255) DEFAULT NULL,
  `titulo` text,
  `desarrollo` text,
  `categoria` text,
  `keywords` text,
  `description` text,
  `fecha` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO ` galerias` VALUES("1", "ff97738a81", "Nova", "", "e8d2454eca", "", "", "0000-00-00"); 


DROP TABLE IF EXISTS `imagenes`;
CREATE TABLE `imagenes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ruta` varchar(255) NOT NULL,
  `cod` varchar(255) NOT NULL,
  `orden` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=310 DEFAULT CHARSET=latin1;

INSERT INTO `imagenes` VALUES("7", "assets/archivos/recortadas/a_78de20bd5d.jpg", "13fd93791c", "0"); 
INSERT INTO `imagenes` VALUES("8", "assets/archivos/recortadas/a_2d9b41ef54.jpg", "13fd93791c", "0"); 
INSERT INTO `imagenes` VALUES("9", "assets/archivos/recortadas/a_b7efc5ddd1.jpeg", "13fd93791c", "0"); 
INSERT INTO `imagenes` VALUES("10", "assets/archivos/recortadas/a_243e210727.jpeg", "13fd93791c", "0"); 
INSERT INTO `imagenes` VALUES("11", "assets/archivos/recortadas/a_0bcbfbadf0.png", "13fd93791c", "0"); 
INSERT INTO `imagenes` VALUES("12", "assets/archivos/recortadas/a_aa26f6c179.jpg", "13fd93791c", "0"); 
INSERT INTO `imagenes` VALUES("79", "assets/archivos/recortadas/a_4dad2b0bc5.jpg", "78430421e4", "0"); 
INSERT INTO `imagenes` VALUES("80", "assets/archivos/recortadas/a_29bb61531b.JPG", "78430421e4", "0"); 
INSERT INTO `imagenes` VALUES("211", "assets/archivos/recortadas/a_896c3ac504.jpg", "5df14de041", "0"); 
INSERT INTO `imagenes` VALUES("212", "assets/archivos/recortadas/a_9b187ef08f.jpg", "73999a7888", "0"); 
INSERT INTO `imagenes` VALUES("213", "assets/archivos/recortadas/a_c2941d830d.jpg", "e9deb60544", "0"); 
INSERT INTO `imagenes` VALUES("229", "assets/archivos/recortadas/a_66c7ae115f.jpg", "813ba813f7", "0"); 
INSERT INTO `imagenes` VALUES("230", "assets/archivos/recortadas/a_01264855ce.jpg", "6b9026dc17", "0"); 
INSERT INTO `imagenes` VALUES("231", "assets/archivos/recortadas/a_acba31debc.jpg", "5d944da1b6", "0"); 
INSERT INTO `imagenes` VALUES("232", "assets/archivos/recortadas/a_6c2ffe3e5f.jpg", "17f31dd1ef", "0"); 
INSERT INTO `imagenes` VALUES("233", "assets/archivos/recortadas/a_0e2f0e3156.jpg", "8926643dc3", "0"); 
INSERT INTO `imagenes` VALUES("234", "assets/archivos/recortadas/a_0c1272b273.jpg", "f4c5951209", "1"); 
INSERT INTO `imagenes` VALUES("238", "assets/archivos/recortadas/a_7475bdc23f.jpg", "336ee06d42", "0"); 
INSERT INTO `imagenes` VALUES("239", "assets/archivos/recortadas/a_96eccad865.jpg", "6a5652ab88", "0"); 
INSERT INTO `imagenes` VALUES("240", "assets/archivos/recortadas/a_ad8f115708.jpg", "0368b22bb5", "0"); 
INSERT INTO `imagenes` VALUES("241", "assets/archivos/recortadas/a_de78a77546.jpg", "747f2d1c3a", "0"); 
INSERT INTO `imagenes` VALUES("242", "assets/archivos/recortadas/a_f40bc1c3fe.jpg", "747f2d1c3a", "0"); 
INSERT INTO `imagenes` VALUES("243", "assets/archivos/recortadas/a_d3231c397b.jpg", "747f2d1c3a", "0"); 
INSERT INTO `imagenes` VALUES("244", "assets/archivos/recortadas/a_d25d7d3610.jpg", "747f2d1c3a", "0"); 
INSERT INTO `imagenes` VALUES("245", "assets/archivos/recortadas/a_d22d6fcb0a.jpg", "8aa0748ceb", "0"); 
INSERT INTO `imagenes` VALUES("246", "assets/archivos/recortadas/a_a3093b85a1.jpg", "8aa0748ceb", "0"); 
INSERT INTO `imagenes` VALUES("247", "assets/archivos/recortadas/a_2e2c6e229a.jpg", "8aa0748ceb", "0"); 
INSERT INTO `imagenes` VALUES("248", "assets/archivos/recortadas/a_d7717c9f82.jpg", "8aa0748ceb", "0"); 
INSERT INTO `imagenes` VALUES("249", "assets/archivos/recortadas/a_9f677b3ab2.jpg", "aea31613d4", "0"); 
INSERT INTO `imagenes` VALUES("250", "assets/archivos/recortadas/a_3da64136c0.jpg", "aea31613d4", "0"); 
INSERT INTO `imagenes` VALUES("251", "assets/archivos/recortadas/a_936cd6a5e4.jpg", "aea31613d4", "0"); 
INSERT INTO `imagenes` VALUES("252", "assets/archivos/recortadas/a_40f3601731.jpg", "aea31613d4", "0"); 
INSERT INTO `imagenes` VALUES("253", "assets/archivos/recortadas/a_f72db75e53.jpg", "3144520977", "0"); 
INSERT INTO `imagenes` VALUES("254", "assets/archivos/recortadas/a_84569cf0c5.jpg", "3144520977", "0"); 
INSERT INTO `imagenes` VALUES("255", "assets/archivos/recortadas/a_04d8752bb7.jpg", "3144520977", "0"); 
INSERT INTO `imagenes` VALUES("256", "assets/archivos/recortadas/a_745b258acc.jpg", "3144520977", "0"); 
INSERT INTO `imagenes` VALUES("257", "assets/archivos/recortadas/a_c8a7e572be.jpg", "03b7d13619", "0"); 
INSERT INTO `imagenes` VALUES("258", "assets/archivos/recortadas/a_91a70fdd3a.jpg", "03b7d13619", "0"); 
INSERT INTO `imagenes` VALUES("259", "assets/archivos/recortadas/a_5529f06382.jpg", "03b7d13619", "0"); 
INSERT INTO `imagenes` VALUES("260", "assets/archivos/recortadas/a_a2ddc0e918.jpg", "03b7d13619", "0"); 
INSERT INTO `imagenes` VALUES("261", "assets/archivos/recortadas/a_45576656ef.jpg", "84113818c2", "0"); 
INSERT INTO `imagenes` VALUES("262", "assets/archivos/recortadas/a_a1085612e6.jpg", "84113818c2", "0"); 
INSERT INTO `imagenes` VALUES("263", "assets/archivos/recortadas/a_9b76c9656f.jpg", "84113818c2", "0"); 
INSERT INTO `imagenes` VALUES("264", "assets/archivos/recortadas/a_56bfb216d8.jpg", "84113818c2", "0"); 
INSERT INTO `imagenes` VALUES("265", "assets/archivos/recortadas/a_0e317d10f8.jpg", "f2c88eb527", "0"); 
INSERT INTO `imagenes` VALUES("266", "assets/archivos/recortadas/a_711e9489e1.jpg", "f2c88eb527", "0"); 
INSERT INTO `imagenes` VALUES("267", "assets/archivos/recortadas/a_86843031bd.jpg", "f2c88eb527", "0"); 
INSERT INTO `imagenes` VALUES("268", "assets/archivos/recortadas/a_56827892ed.jpg", "f2c88eb527", "0"); 
INSERT INTO `imagenes` VALUES("269", "assets/archivos/recortadas/a_c866f1be75.jpg", "d3b58f1d59", "0"); 
INSERT INTO `imagenes` VALUES("270", "assets/archivos/recortadas/a_d3f5bdcbe2.jpg", "d3b58f1d59", "0"); 
INSERT INTO `imagenes` VALUES("271", "assets/archivos/recortadas/a_59776a0781.jpg", "d3b58f1d59", "0"); 
INSERT INTO `imagenes` VALUES("272", "assets/archivos/recortadas/a_5bfb07406c.jpg", "d3b58f1d59", "0"); 
INSERT INTO `imagenes` VALUES("273", "assets/archivos/recortadas/a_fef91587f0.jpg", "801ee8a9c1", "0"); 
INSERT INTO `imagenes` VALUES("274", "assets/archivos/recortadas/a_fc64620c22.jpg", "801ee8a9c1", "0"); 
INSERT INTO `imagenes` VALUES("275", "assets/archivos/recortadas/a_298a2f453c.jpg", "801ee8a9c1", "0"); 
INSERT INTO `imagenes` VALUES("276", "assets/archivos/recortadas/a_dc73a47f47.jpg", "801ee8a9c1", "0"); 
INSERT INTO `imagenes` VALUES("277", "assets/archivos/recortadas/a_026a95f253.jpg", "4a95084912", "0"); 
INSERT INTO `imagenes` VALUES("278", "assets/archivos/recortadas/a_1c8038756b.jpg", "4a95084912", "0"); 
INSERT INTO `imagenes` VALUES("279", "assets/archivos/recortadas/a_2051fafbe6.jpg", "4a95084912", "0"); 
INSERT INTO `imagenes` VALUES("280", "assets/archivos/recortadas/a_73e401d1b8.jpg", "4a95084912", "0"); 
INSERT INTO `imagenes` VALUES("281", "assets/archivos/recortadas/a_3017eabecb.jpg", "9d9bbf52de", "0"); 
INSERT INTO `imagenes` VALUES("282", "assets/archivos/recortadas/a_af017a6ec3.jpg", "9d9bbf52de", "0"); 
INSERT INTO `imagenes` VALUES("283", "assets/archivos/recortadas/a_fea184d0af.jpg", "9d9bbf52de", "0"); 
INSERT INTO `imagenes` VALUES("284", "assets/archivos/recortadas/a_cde34b9fc5.jpg", "9d9bbf52de", "0"); 
INSERT INTO `imagenes` VALUES("285", "assets/archivos/recortadas/a_5ea2bf6c0a.jpg", "2d4b38d6f1", "0"); 
INSERT INTO `imagenes` VALUES("286", "assets/archivos/recortadas/a_f6cf0d59dc.jpg", "2d4b38d6f1", "0"); 
INSERT INTO `imagenes` VALUES("287", "assets/archivos/recortadas/a_a71f6fcb23.jpg", "2d4b38d6f1", "0"); 
INSERT INTO `imagenes` VALUES("288", "assets/archivos/recortadas/a_f8c77b601b.jpg", "2d4b38d6f1", "0"); 
INSERT INTO `imagenes` VALUES("289", "assets/archivos/recortadas/a_d8f54f8992.jpg", "efade34138", "0"); 
INSERT INTO `imagenes` VALUES("290", "assets/archivos/recortadas/a_d23f76a198.jpg", "efade34138", "0"); 
INSERT INTO `imagenes` VALUES("291", "assets/archivos/recortadas/a_85cbc5d668.jpg", "efade34138", "0"); 
INSERT INTO `imagenes` VALUES("292", "assets/archivos/recortadas/a_21a78d0fe0.jpg", "efade34138", "0"); 
INSERT INTO `imagenes` VALUES("305", "assets/archivos/recortadas/a_efd305e8cb.jpg", "d568746ae6", "0"); 
INSERT INTO `imagenes` VALUES("306", "assets/archivos/recortadas/a_6f31aece10.jpg", "d568746ae6", "1"); 
INSERT INTO `imagenes` VALUES("307", "assets/archivos/recortadas/a_74b2db715d.jpg", "d568746ae6", "0"); 
INSERT INTO `imagenes` VALUES("308", "assets/archivos/recortadas/a_87c935db25.jpg", "d568746ae6", "0"); 
INSERT INTO `imagenes` VALUES("309", "assets/archivos/recortadas/a_dbd629384e.jpg", "6076248150", "0"); 


DROP TABLE IF EXISTS ` novedades`;
CREATE TABLE `novedades` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cod` varchar(255) DEFAULT NULL,
  `titulo` text,
  `desarrollo` text,
  `categoria` text,
  `keywords` text,
  `description` text,
  `fecha` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

INSERT INTO ` novedades` VALUES("6", "813ba813f7", "El estilo Lagom se impone como tendencia deco para un hogar moderno y minimalista", "<p>Siempre es una buena idea renovar las decoraciones del hogar para transformar un ambiente y darle vida. Y el &quot;Lagom&quot; es la nueva tendencia deco que lleg&oacute; para quedarse, y cuyo concepto principal es el &quot;menos es m&aacute;s&quot; proveniente de Suecia.</p>
INSERT INTO ` novedades` VALUES("7", "6b9026dc17", "Tendencias en decoración 2019: el interiorismo que viene, ya en Tiendas On", "<p>En este especial&nbsp;<strong><a href=\"https://www.tiendason.es/nuevos-productos\" rel=\"noopener nofollow noreferrer\" target=\"_blank\">Tendencias en Decoraci&oacute;n 2019</a></strong>,&nbsp;<strong>Tiendas On</strong>&nbsp;ya tiene la vista puesta en todo lo que se llevar&aacute; el pr&oacute;ximo a&ntilde;o. Los&nbsp;<strong>muebles 2019</strong>&nbsp;de los que todos hablar&aacute;n, ya est&aacute;n en el cat&aacute;logo online de&nbsp;<strong><a href=\"https://www.tiendason.es/\" rel=\"noopener nofollow noreferrer\" target=\"_blank\">Tiendas On</a></strong>&nbsp;&iexcl;Descubre antes de nadie todas las tendencias en&nbsp;<strong>Interiorismo 2019</strong>!</p>
INSERT INTO ` novedades` VALUES("8", "5d944da1b6", "Estilos de sillas de comedor", "<p>Son las piezas indispensables para que el comedor resulte confortable y equilibrado. Tanto el material, como la forma o su color conviene elegirlo con detenimiento, para que su integraci&oacute;n con la mesa, que no tiene por qu&eacute; pertenecer a la misma colecci&oacute;n de mobiliario, sea perfecta, responda a tu idea de interiorismo y aporte el estilo que buscas para esta estancia de la casa.</p>
INSERT INTO ` novedades` VALUES("9", "17f31dd1ef", "Colores para el comedor 2019 80 fotos y tendencias modernas", "<p>El comedor es el espacio en el cual uno comparte las comidas con su familia, amigos, festejo de cumplea&ntilde;os, entre otras varias vivencias que a diario ocurren en un hogar. El color que se utiliza para decorarlo, va variando de acuerdo a los gustos de las personas y a las tendencias de moda de la &eacute;poca. Por eso a continuaci&oacute;n, te mostraremos una gran cantidad de ideas de<strong>colores para el comedor</strong>, para que puedas inspirarte y elegir el tuyo.</p>
INSERT INTO ` novedades` VALUES("10", "8926643dc3", "Sillas modernas 2019 fotos y tendencias en diseños", "<h1>Sillas modernas 2019 fotos y tendencias en dise&ntilde;os</h1>
INSERT INTO ` novedades` VALUES("11", "f4c5951209", "Colores para paredes 2019 tendencias para interiores", "<h1>Colores para paredes 2019 tendencias para interiores</h1>


DROP TABLE IF EXISTS ` pagos`;
CREATE TABLE `pagos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` text NOT NULL,
  `leyenda` text NOT NULL,
  `cod` varchar(255) NOT NULL,
  `estado` int(11) NOT NULL,
  `aumento` int(11) DEFAULT '0',
  `disminuir` int(11) DEFAULT '0',
  `defecto` int(11) DEFAULT '0',
  `tipo` int(11) DEFAULT '0' COMMENT '¿TARJETA DE CREDITO? SI ES PARA TARJETA DE CRÉDITO COLOCAR UN 1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

INSERT INTO ` pagos` VALUES("2", "Tarjeta de crédito", "Cuenta de mercadopago", "1fa6124437", "0", "0", "0", "1", "1"); 
INSERT INTO ` pagos` VALUES("7", "TRANSFERENCIA BANCARIA", "25% de descuento en tu compra", "7290d4f6ba", "0", "0", "27", "1", "0"); 


DROP TABLE IF EXISTS ` pedidos`;
CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cod` varchar(255) NOT NULL,
  `producto` varchar(255) NOT NULL,
  `cantidad` int(11) NOT NULL DEFAULT '1',
  `precio` float NOT NULL DEFAULT '0',
  `estado` int(11) DEFAULT '0',
  `tipo` text,
  `usuario` varchar(255) NOT NULL,
  `detalle` text,
  `fecha` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=latin1;

INSERT INTO ` pedidos` VALUES("7", "BE59EB4AC5", "SILLA DE COMEDOR GUATAMBÚ TAPIZADA", "1", "4900", "1", "TRANSFERENCIA BANCARIA", "d7e0a5a58e", "", "2019-02-12 20:38:41"); 
INSERT INTO ` pedidos` VALUES("8", "BE59EB4AC5", "COORDINAR CON EL VENDEDOR", "1", "0", "1", "TRANSFERENCIA BANCARIA", "d7e0a5a58e", "", "2019-02-12 20:38:41"); 
INSERT INTO ` pedidos` VALUES("9", "BE59EB4AC5", "DESCUENTO -27% / TRANSFERENCIA BANCARIA", "1", "-1323", "1", "TRANSFERENCIA BANCARIA", "d7e0a5a58e", "", "2019-02-12 20:38:41"); 
INSERT INTO ` pedidos` VALUES("10", "A26C5A4935", "SILLA DE COMEDOR GUATAMBÚ TAPIZADA", "1", "4900", "1", "TRANSFERENCIA BANCARIA", "d7e0a5a58e", "", "2019-02-12 20:41:31"); 
INSERT INTO ` pedidos` VALUES("11", "A26C5A4935", "ENVIO GRATIS A SAN FRANCISCO CÓRDOBA", "1", "0", "1", "TRANSFERENCIA BANCARIA", "d7e0a5a58e", "", "2019-02-12 20:41:31"); 
INSERT INTO ` pedidos` VALUES("12", "A26C5A4935", "DESCUENTO -27% / TRANSFERENCIA BANCARIA", "1", "-1323", "1", "TRANSFERENCIA BANCARIA", "d7e0a5a58e", "", "2019-02-12 20:41:31"); 
INSERT INTO ` pedidos` VALUES("13", "BFF64A1217", "SILLA DE COMEDOR GUATAMBÚ TAPIZADA", "1", "4900", "1", "TRANSFERENCIA BANCARIA", "d7e0a5a58e", "", "2019-02-12 20:43:27"); 
INSERT INTO ` pedidos` VALUES("14", "BFF64A1217", "ENVIO GRATIS A SAN FRANCISCO CÓRDOBA", "1", "0", "1", "TRANSFERENCIA BANCARIA", "d7e0a5a58e", "", "2019-02-12 20:43:27"); 
INSERT INTO ` pedidos` VALUES("15", "BFF64A1217", "DESCUENTO -27% / TRANSFERENCIA BANCARIA", "1", "-1323", "1", "TRANSFERENCIA BANCARIA", "d7e0a5a58e", "", "2019-02-12 20:43:27"); 
INSERT INTO ` pedidos` VALUES("42", "AD4A576027", "SILLA DE COMEDOR GUATAMBÚ TAPIZADA", "7", "4900", "2", "", "", "", "2019-02-12 21:34:01"); 
INSERT INTO ` pedidos` VALUES("43", "AD4A576027", "SILLA DE COMEDOR GUATAMBÚ TAPIZADA", "1", "4900", "2", "", "", "", "2019-02-12 21:34:01"); 
INSERT INTO ` pedidos` VALUES("44", "AD4A576027", "COORDINAR CON EL VENDEDOR", "1", "0", "2", "", "", "", "2019-02-12 21:34:01"); 


DROP TABLE IF EXISTS ` portfolio`;
CREATE TABLE `portfolio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cod` varchar(255) DEFAULT NULL,
  `titulo` text,
  `desarrollo` text,
  `categoria` text,
  `keywords` text,
  `description` text,
  `fecha` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



DROP TABLE IF EXISTS ` productos`;
CREATE TABLE `productos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cod` varchar(255) DEFAULT NULL,
  `titulo` text,
  `precio` float DEFAULT NULL,
  `precio_descuento` float DEFAULT NULL,
  `stock` int(11) DEFAULT '0',
  `desarrollo` text,
  `categoria` text,
  `subcategoria` text,
  `keywords` text,
  `description` text,
  `variable1` text COMMENT 'cuerina',
  `variable2` text COMMENT 'telas',
  `variable3` text COMMENT 'lustre',
  `variable4` text COMMENT 'peso',
  `variable5` text COMMENT 'altura',
  `variable6` text COMMENT 'ancho',
  `variable7` text COMMENT 'profundidad',
  `variable8` text,
  `variable9` text,
  `variable10` text,
  `fecha` date DEFAULT NULL,
  `meli` varchar(255) DEFAULT NULL,
  `url` text,
  `cod_producto` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

INSERT INTO ` productos` VALUES("4", "d568746ae6", "SILLA DE COMEDOR GUATAMBÚ TAPIZADA", "4900", "0", "20", "<p>SILLAS PARA COMEDORES ELEGANTES, VEST&Iacute; TU COMEDOR CON ESTAS SILLAS DE MADERA GUATAMB&Uacute; Y NO GASTES DINERO EN SILLAS QUE EN POCO TIEMPO TENDR&Iacute;AS QUE CAMBIAR.<br />
INSERT INTO ` productos` VALUES("5", "6076248150", "SILLA DE COMEDOR GUATAMBÚ TAPIZADA", "2", "0", "2", "<p>SILLAS PARA COMEDORES ELEGANTES, SILLAS DE GUATAMBU, SILLAS DE MADERA MASISA, SILLAS RESISTENTES, SILLAS DE MADERA</p>


DROP TABLE IF EXISTS ` servicios`;
CREATE TABLE `servicios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cod` varchar(255) DEFAULT NULL,
  `titulo` text,
  `desarrollo` text,
  `categoria` text,
  `keywords` text,
  `description` text,
  `fecha` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



DROP TABLE IF EXISTS ` sliders`;
CREATE TABLE `sliders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cod` varchar(255) DEFAULT NULL,
  `titulo` text,
  `subtitulo` text,
  `categoria` varchar(255) NOT NULL,
  `fecha` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

INSERT INTO ` sliders` VALUES("3", "0368b22bb5", "", "", "", "2019-01-07"); 
INSERT INTO ` sliders` VALUES("4", "6a5652ab88", "", "", "", "2019-01-07"); 
INSERT INTO ` sliders` VALUES("5", "336ee06d42", "", "", "", "2019-01-07"); 


DROP TABLE IF EXISTS ` subcategorias`;
CREATE TABLE `subcategorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cod` varchar(255) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `categoria` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



DROP TABLE IF EXISTS ` usuarios`;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cod` varchar(255) DEFAULT NULL,
  `nombre` text,
  `apellido` text,
  `doc` text,
  `email` text,
  `password` text,
  `postal` text,
  `direccion` text NOT NULL,
  `localidad` text,
  `provincia` text,
  `pais` text,
  `telefono` text,
  `celular` text,
  `invitado` int(11) NOT NULL DEFAULT '0',
  `descuento` float DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO ` usuarios` VALUES("1", "10a3f5a789", "FACUNDO", "ROCHA", "", "facundo@estudiorochayasoc.com.ar", "", "", "", "SAN FRANCISCO", "Córdoba", "", "3564570789", "", "1", "0", "2018-12-27"); 
INSERT INTO ` usuarios` VALUES("2", "bdb4f399b7", "Facundo", "Rocha", "20149590243", "facundoestudiorocha@gmail.com", "faAr2010", "", "", "San Francisco", "Córdoba", "", "3564570789", "", "1", "0", "2019-01-04"); 


DROP TABLE IF EXISTS ` videos`;
CREATE TABLE `videos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` text,
  `link` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

SET FOREIGN_KEY_CHECKS = 1;