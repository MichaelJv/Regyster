<?php
include '../lib/class_mysql.php';
include '../lib/config.php';

$sql=  Mysql::consulta("SELECT ip_equipos FROM equipos WHERE ip_equipos='".MysqlQuery::RequestGet('ip_equipos')."'");

if(mysqli_num_rows($sql)>0){
    echo '<span class="glyphicon glyphicon-remove form-control-feedback" style="color: #a94442;";></span>';
    echo '<label class="control-label" for="inputSuccess2" style="margin-top:10px;color: #a94442;";>La IP ya existe, por favor elige otro número de IP</label>';
}else{
    
}