<?php
$oficina_consul=  MysqlQuery::RequestGet('oficina_consul');
$user_consul= MysqlQuery::RequestGet('user_consul');

$consulta_tablaTicket=Mysql::consulta("SELECT * FROM equipos WHERE nombre_equipo= '$oficina_consul' AND user_equipo='$user_consul'");
if(mysqli_num_rows($consulta_tablaTicket)>=1){
  $lsT=mysqli_fetch_array($consulta_tablaTicket, MYSQLI_ASSOC);   
?>
        <div class="container">
        
            <!--<div class="row well">
            <div class="col-sm-2">
                <img src="img/status.png" class="img-responsive" alt="Image">
            </div>
            <div class="col-sm-10 lead text-justify">
              <h2 class="text-info">Estado de equipos registrados</h2>
              <p>Si su <strong>ticket</strong> no ha sido solucionado aún, espere
              pacientemente, estamos trabajando para poder resolver su problema y 
              darle una solución.</p>
            </div>
          </div>--><!--fin row well-->
          <div class="row">
          <div class="col-sm-12">
                <a href="./index.php?view=equipos" class="btn btn-primary btn-sm pull-right"><i class="fa fa-reply"></i>&nbsp;&nbsp;Volver a Consultar</a>
            </div>
            <br><br>
              <div class="col-sm-12">
                    <div class="panel panel-success">
                        <div class="panel-heading text-center"><h4><i class="fa fa-map-marker"></i> IP &nbsp;#<?php echo $lsT['ip_equipos']; ?></h4></div>
                      <div class="panel-body">
                          <div class="container">
                              <div class="col-sm-12">
                                  <div class="row">
                                      <div class="col-sm-4">
                                          <img class="img-responsive" alt="Image" src="img/Control_Inventario.png">
                                      </div>
                                      <div class="col-sm-8">
                                          <div class="row">
                                              <div class="col-sm-6"><strong>Oficina:</strong> <?php echo $lsT['oficina_equipo']; ?></div>
                                              <div class="col-sm-6"><strong>Usuario:</strong> <?php echo $lsT['usuario_equipo']; ?></div>
                                          </div>
                                          <br>
                                          <div class="row">
                                              <div class="col-sm-6"><strong>Marca:</strong> <?php echo $lsT['marca_equipo']; ?></div>
                                              <div class="col-sm-6"><strong>Hostname:</strong> <?php echo $lsT['nombre_equipo']; ?></div>
                                          </div>
                                          <br>
                                          <div class="row">
                                              <div class="col-sm-6"><strong>Nombre Completo:</strong> <?php echo $lsT['nombre_completo']; ?></div>
                                              <div class="col-sm-6"><strong>Marca:</strong> <?php echo $lsT['mac_equipo']; ?></div>
                                          </div>
                                          <br>
                                          <div class="row">
                                              <div class="col-sm-6"><strong>User:</strong> <?php echo $lsT['user_equipo']; ?></div>
                                              <div class="col-sm-6"><strong>Sistema Operativo:</strong> <?php echo $lsT['sistema_operativo']; ?></div>
                                          </div>
                                          <br>
                                          <div class="row">
                                              <div class="col-sm-6"><strong>Tipo de Procesador:</strong> <?php echo $lsT['tipo_procesador']; ?></div>
                                              <div class="col-sm-6"><strong>Memoria RAM:</strong> <?php echo $lsT['memoria_ram']; ?></div>
                                          </div>
                                          <br>
                                          <div class="row">
                                              <div class="col-sm-6"><strong>Disco Duro:</strong> <?php echo $lsT['disco_duro']; ?></div>
                                              <div class="col-sm-6"><strong>Placa:</strong> <?php echo $lsT['placa_equipo']; ?></div>
                                          </div>
                                          <br>
                                          <div class="row">
                                              <div class="col-sm-6"><strong>Estado:</strong> <?php echo $lsT['est_equipos']; ?></div>
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

 <?php }else{ ?>
        <div class="container">
            <div class="row  animated fadeInDownBig">
                <div class="col-sm-4">
                    <img src="img/error.png" alt="Image" class="img-responsive"/><br>
                    
                </div>
                <div class="col-sm-7 text-center">
                    <h1 class="text-danger">Lo sentimos el equipo no ha sido registrado, debe realizar lo siguiente:</h1>
                    <h3 class="text-primary"><i class="fa fa-check"></i> Verificar si los datos son correctos.</h3>
                    <h3 class="text-primary"><i class="fa fa-check"></i> Informar al personal de soporte para habilitar su IP..</h3>
                    <br>
                    <h4><a href="./index.php?view=equipos" class="btn btn-primary"><i class="fa fa-reply"></i> Regresar a equipo</a></h4>
                </div>
                <div class="col-sm-1">&nbsp;</div>
            </div>
        </div>
        <br><br><br><br>
        
<?php } ?>
<script>
  $(document).ready(function(){
    $("button#save").click(function (){
       window.open ("./lib/pdf_user.php?id="+$(this).attr("data-id"));
    });
  });
</script>
                            <?php if(!$_SESSION['nombre']==""&&!$_SESSION['tipo']==""){ 

/*Script para actualizar datos de cuenta*/
if(isset($_POST['id_del']) && isset($_POST['mensaje_usuario'])){

  $id=MysqlQuery::RequestPost('id_del');
  $mensaje_usuario=MysqlQuery::RequestPost('mensaje_usuario');
   $sql=Mysql::consulta("SELECT * FROM ticket WHERE id= '$id'");
   
  if(MysqlQuery::Actualizar("ticket", "estado_mensaje='$mensaje_usuario'", "id='$id'")){

    echo '
      <div class="alert alert-info alert-dismissible fade in col-sm-3 animated bounceInDown" role="alert" style="position:fixed; top:70px; right:10px; z-index:10;"> 
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
          <h4 class="text-center">LISTO</h4>
          <p class="text-center">
            ¡Esperamos haber solucionado su problema!
          </p>
      </div>
    ';
    
  }else{
    echo '
      <div class="alert alert-danger alert-dismissible fade in col-sm-3 animated bounceInDown" role="alert" style="position:fixed; top:70px; right:10px; z-index:10;"> 
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
          <h4 class="text-center">OCURRIO UN ERROR</h4>
          <p class="text-center">
            Asegurese que los datos ingresados son validos. Por favor intente nuevamente</p>
          </p>
      </div>
    '; 
  }
}
?>
  
            
       

<?php
}else{
?>
<div class="container">
<div class="row">
    <div class="col-sm-4">
        <img src="img/Stop.png" alt="Image" class="img-responsive animated slideInDown"/><br>
        
    </div>
    <div class="col-sm-7 animated flip">
        <h1 class="text-danger">Lo sentimos esta página es solamente para usuarios registrados en HELPDESK HSJDP</h1>
        <h3 class="text-info text-center">Inicia sesión para poder acceder</h3>
    </div>
    <div class="col-sm-1">&nbsp;</div>
</div>
</div>
<?php
}
?>
