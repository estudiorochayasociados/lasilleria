<?php

namespace Clases;

class Productos
{

    //Atributos
    public $id;
    public $cod;
    public $titulo;
    public $precio;
    public $precio_cuerina;
    public $precio_telas;
    public $precio_descuento;
    public $stock;
    public $desarrollo;
    public $categoria;
    public $subcategoria;
    public $keywords;
    public $description;
    public $variable1;
    public $variable2;
    public $variable3;
    public $variable4;
    public $variable5;
    public $variable6;
    public $variable7;
    public $variable8;
    public $variable9;
    public $variable10;
    public $fecha;
    public $meli;
    public $url;
    private $con;

    //Metodos
    public function __construct()
    {
        $this->con = new Conexion();
    }

    public function set($atributo, $valor)
    {
        $this->$atributo = $valor;
    }

    public function get($atributo)
    {
        return $this->$atributo;
    }

    public function add()
    {
        $sql = "INSERT INTO `productos`(`cod`, `titulo`,`cod_producto`, `precio`, `precio_cuerina`, `precio_telas`, `precio_descuento`, `stock`, `desarrollo`, `categoria`, `subcategoria`, `keywords`, `description`,`variable1`,`variable2`,`variable3`, `fecha`, `meli`, `url`) VALUES ('{$this->cod}', '{$this->titulo}','{$this->cod_producto}', '{$this->precio}','{$this->precio_cuerina}', '{$this->precio_telas}', '{$this->precio_descuento}', '{$this->stock}', '{$this->desarrollo}', '{$this->categoria}', '{$this->subcategoria}', '{$this->keywords}', '{$this->description}','{$this->variable1}','{$this->variable2}','{$this->variable3}', '{$this->fecha}', '{$this->meli}', '{$this->url}')";
        $query = $this->con->sql($sql);
        return $query;
    }

    public function edit()
    {
        $sql = "UPDATE `productos` SET
        `cod` = '{$this->cod}',
        `titulo` = '{$this->titulo}',
        `precio` = '{$this->precio}',
        `cod_producto` = '{$this->cod_producto}',
        `precio_telas` = '{$this->precio_telas}',
        `precio_cuerina` = '{$this->precio_cuerina}',
        `precio_descuento` = '{$this->precio_descuento}',
        `stock` = '{$this->stock}',
        `desarrollo` = '{$this->desarrollo}',
        `categoria` = '{$this->categoria}',
        `subcategoria` = '{$this->subcategoria}',
        `keywords` = '{$this->keywords}',
        `variable1` = '{$this->variable1}',
        `variable2` = '{$this->variable2}',
        `variable3` = '{$this->variable3}',
        `description` = '{$this->description}',
        `fecha` = '{$this->fecha}',
        `meli` = '{$this->meli}',
        `url` = '{$this->url}'
        WHERE `id`='{$this->id}'";
        $query = $this->con->sql($sql);
        return $query;
    }

    public function delete()
    {
        $sql = "DELETE FROM `productos` WHERE `cod`  = '{$this->cod}'";
        $query = $this->con->sql($sql);
        return $query;
    }

    public function view()
    {
        $sql = "SELECT * FROM `productos` WHERE id = '{$this->id}' ||  cod = '{$this->cod}' ORDER BY id DESC";
        $notas = $this->con->sqlReturn($sql);
        $row = mysqli_fetch_assoc($notas);
        return $row;
    }

    function list($filter, $order, $limit)
    {
        $array = array();
        if (is_array($filter)) {
            $filterSql = "WHERE ";
            $filterSql .= implode(" AND ", $filter);
        } else {
            $filterSql = '';
        }

        if ($order != '') {
            $orderSql = $order;
        } else {
            $orderSql = "id DESC";
        }

        if ($limit != '') {
            $limitSql = "LIMIT " . $limit;
        } else {
            $limitSql = '';
        }

        $sql = "SELECT * FROM `productos` $filterSql  ORDER BY $orderSql $limitSql";
        $notas = $this->con->sqlReturn($sql);
        if ($notas) {
            while ($row = mysqli_fetch_assoc($notas)) {
                $array[] = $row;
            }
            return $array;
        }
    }

    function paginador($filter, $cantidad)
    {
        $array = array();
        if (is_array($filter)) {
            $filterSql = "WHERE ";
            $filterSql .= implode(" AND ", $filter);
        } else {
            $filterSql = '';
        }
        $sql = "SELECT * FROM `productos` $filterSql";
        $contar = $this->con->sqlReturn($sql);
        $total = mysqli_num_rows($contar);
        $totalPaginas = $total / $cantidad;
        return floor($totalPaginas);
    }
}
