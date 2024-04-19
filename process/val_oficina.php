<?php
include '../lib/class_mysql.php';
include '../lib/config.php';

$sql=  Mysql::consulta("SELECT iniciales_oficina FROM oficinas WHERE iniciales_oficina='".MysqlQuery::RequestGet('id_oficina')."'");

if(mysqli_num_rows($sql)>0){
    echo '<span class="glyphicon glyphicon-remove form-control-feedback"></span>';
    echo '<label class="control-label" for="inputSuccess2" style="margin-top:10px;";>Oficina ya existente, por favor elige otro identificador de Oficina</label>';
}else{
    echo '<span class="glyphicon glyphicon-ok form-control-feedback"></span>';
}
