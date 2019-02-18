<div class="clearfix"></div>
<div class="col-md-12">
    <?php
    //Clases
    $usuario = new Clases\Usuarios();
    $pedidos = new Clases\Pedidos();

    $usuario->set("cod", $_SESSION["usuarios"]["cod"]);
    $usuarioData = $usuario->view();

    $filterPedidosAgrupados = array("usuario = '" . $usuarioData['cod'] . "' GROUP BY cod");
    $pedidosArrayAgrupados = $pedidos->list($filterPedidosAgrupados);

    $filterPedidosSinAgrupar = array("usuario = '" . $usuarioData['cod'] . "'");
    $pedidosArraySinAgrupar = $pedidos->list($filterPedidosSinAgrupar);

    if (is_array($pedidosArrayAgrupados)) {
    foreach ($pedidosArrayAgrupados as $key => $value) {
        $precioTotal = 0;
        $fecha = explode(" ", $value["fecha"]);
        $fecha1 = explode("-", $fecha[0]);
        $fecha1 = $fecha1[2] . '-' . $fecha1[1] . '-' . $fecha1[0] . '-';
        $fecha = $fecha1 . $fecha[1];
        ?>
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="heading">
                <h5 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $value["cod"] ?>"
                       aria-expanded="false" aria-controls="collapse<?= $value["cod"] ?>" class="collapsed">
                        Pedido <?= $value["cod"] ?>
                        <span class="hidden-xs hidden-sm">- Fecha <?= $fecha ?></span>
                        <?php
                        if ($value["estado"] == 0) {
                            echo '<span class="btn-primary pull-right">Estado: Carrito no cerrado</span>';
                        } elseif ($value["estado"] == 1) {
                            echo '<span class="btn-warning pull-right">Estado: Pago pendiente</span>';
                        } elseif ($value["estado"] == 2) {
                            echo '<span class="btn-success pull-right">Estado: Pago aprobado</span>';
                        } elseif ($value["estado"] == 3) {
                            echo '<span class="btn-info pull-right">Estado: Pago enviado</span>';
                        } elseif ($value["estado"] == 4) {
                            echo '<span class="btn-danger pull-right">Estado: Pago rechazado</span>';
                        }
                        ?>
                    </a>
                </h5>
            </div>
            <div id="collapse<?= $value["cod"] ?>" class="panel-collapse collapse" role="tabpanel"
                 aria-labelledby="headingOne" aria-expanded="false" style="height: 0px;">
                <div class="panel-body">
                    <table class="table table-striped table-responsive table-hover">
                        <thead>
                        <tr>
                            <th>
                                Producto
                            </th>
                            <th>
                                Cantidad
                            </th>
                            <th class="hidden-xs hidden-sm">
                                Precio
                            </th>
                            <th>
                                Precio Final
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($pedidosArraySinAgrupar as $key2 => $value2) {
                            if ($value2['cod'] == $value["cod"]) {
                                ?>
                                <tr>
                                    <td><?= $value2["producto"] ?></td>
                                    <td><?= $value2["cantidad"] ?></td>
                                    <td>$<?= $value2["precio"] ?></td>
                                    <td>$<?= $value2["precio"] * $value2["cantidad"] ?></td>
                                    <?php $precioTotal = $precioTotal + ($value2["precio"] * $value2["cantidad"]); ?>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                        <tr>
                            <td><b>TOTAL DE LA COMPRA</b></td>
                            <td></td>
                            <td></td>
                            <td><b>$<?= $precioTotal ?></b></td>
                        </tr>
                        </tbody>
                    </table>
                    <hr>
                    <span style="font-size:16px">
                    <b>FORMA DE PAGO</b>
                    <span class="alert-info" style="border-radius: 10px; padding: 10px;">
                        <?php
                        if ($value["tipo"] == 0) {
                            echo 'Transferencia bancaria';
                        } elseif ($value["tipo"] == 1) {
                            echo 'Coordinar con vendedor';
                        } elseif ($value["tipo"] == 2) {
                            echo 'Tarjeta de crédito o débito';
                        }
                        ?>
                    </span>
                </span>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
</div>

<?php
} else {
    echo "<h4 class='mt-20 mb-150 '>No hay pedidos registrados hasta el momento</h4>";
}