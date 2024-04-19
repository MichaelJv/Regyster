<?php if(isset($_SESSION['nombre']) && isset($_SESSION['tipo'])){
        

        if(isset($_POST['name_equipo']) && isset($_POST['name_completo'])){

          $oficina_equipo=MysqlQuery::RequestPost('oficina_equipo');
          $sede_equipo=MysqlQuery::RequestPost('sede');
          $usuario_equipo=MysqlQuery::RequestPost('usuario_equipo');
          $ip_equipo=MysqlQuery::RequestPost('ip_equipo');
          $marca_equipo=MysqlQuery::RequestPost('marca_equipo');
          $nombre_equipo= MysqlQuery::RequestPost('name_equipo');
          $nombre_completo=MysqlQuery::RequestPost('name_completo');
          $mac_equipo=MysqlQuery::RequestPost('mac_equipo');
          $user_equipo=MysqlQuery::RequestPost('user_equipo');
          $sistema_operativo=MysqlQuery::RequestPost('sistema_operativo'); 
          $tipo_procesador=MysqlQuery::RequestPost('tipo_procesador');
          $memoria_equipo=MysqlQuery::RequestPost('memoria_equipo');
          $disco_duro=MysqlQuery::RequestPost('disco_duro');
          $placa_equipo=MysqlQuery::RequestPost('placa_equipo');
          $estado_equipo=MysqlQuery::RequestPost('estado_equipo');

            if(MysqlQuery::Guardar(
              "equipos",
              "'oficina_equipo',
              'sede_hospital',
              'usuario_equipo',
              'ip_equipos',
              'marca_equipo',
              'nombre_equipo',
              'nombre_completo',
              'mac_equipo',
              'user_equipo',
              'sistema_operativo',
              'tipo_procesador',
              'memoria_ram',
              'disco_duro',
              'placa_equipo',
              'est_equipos'", 
              "'$oficina_equipo',
              '$sede_equipo',
              '$usuario_equipo',
              '$ip_equipo',
              '$marca_equipo',
              '$nombre_equipo',
              '$nombre_completo',
              '$mac_equipo',
              '$user_equipo',
              '$sistema_operativo',
              '$tipo_procesador',
              '$memoria_equipo',
              '$disco_duro',
              '$placa_equipo',
              '$estado_equipo'")){
                echo '
                <div class="alert alert-info alert-dismissible fade in col-sm-3 animated bounceInDown" role="alert" style="position:fixed; top:70px; right:10px; z-index:10;"> 
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="text-center">IP REGISTRADA</h4>
                    <p class="text-center">
                        Equipo nuevo registrado '.$_SESSION['nombre'].'<br>El nombre del equipo es: <strong>'.$nombre_equipo.'</strong>
                    </p>
                </div>
            ';
          }else{
            echo '
                <div class="alert alert-danger alert-dismissible fade in col-sm-3 animated bounceInDown" role="alert" style="position:fixed; top:70px; right:10px; z-index:10;"> 
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="text-center">OCURRIÓ UN ERROR</h4>
                    <p class="text-center">
                        No hemos podido registar el nuevo equipo. Por favor intente nuevamente.
                    </p>
                </div>
            ';
          }
        }
?>

        <div class="container">
          <div class="row well">
            <div class="col-sm-3">
              <img src="img/ip_nueva.png" class="img-responsive" alt="Image">
            </div>
            <div class="col-sm-9 lead">
              <h2 class="text-info">¿Cómo abrir un nuevo Equipo?</h2>
              <p>Para abrir un nuevo equipo deberá de llenar todos los campos de el siguiente formulario.</p>
            </div>  
          </div><!--fin row 1-->
          
          <div class="row">
          <div class="col-sm-12">
                <a href="./index.php?view=oficina" class="btn btn-primary btn-sm pull-right"><i class="fa fa-hospital-o"></i>&nbsp;&nbsp;Creer una nueva Oficina</a>
            </div>
            <br><br>
            <div class="col-sm-12">
              <div class="panel panel-info">
                <div class="panel-heading">
                  <h3 class="panel-title text-center"><strong><i class="fa fa-desktop"></i>&nbsp;&nbsp;&nbsp;Equipo</strong></h3>
                </div>
                <div class="panel-body">
                  <div class="row">
                    <div class="col-sm-4 text-center">
                      <br><br><br>
                      <img src="img/datos.png" alt=""><br><br>
                      <p class="text-primary text-justify">Por favor llene todos los datos de este formulario para agregar un equipo. Este nuevo dispositivo de la red se incoporará en el inventario del Hospital con su respectiva IP.</p>
                    </div>
                    <div class="col-sm-8">
                      <form class="form-horizontal" role="form" action="" method="POST">
                          <fieldset>
                          <script>
                          var textojuntado1="";
                          var textojuntado2="";
                                function selectNit(e) {
                                  var nit =  e.target.selectedOptions[0].getAttribute("data-nit")
                                  document.getElementById("nombre1").value = nit;
                                  textojuntado1 = document.getElementById('nombre1').value;
                                  document.getElementById('nombre1').value = textojuntado1.replace(/\s/g, '');
                                  document.getElementById("nombre2").value = nit+".HSJDPISCO.GOB.PE";
                                  textojuntado2 = document.getElementById('nombre2').value;
                                  document.getElementById('nombre2').value = textojuntado2.replace(/\s/g, '');
                                }
                              </script>
                          <div class="form-group">
                          <label  class="col-sm-2 control-label">Oficina del Equipo</label>
                          <div class="col-sm-10">
                              <div class='input-group'>
                                <select class="form-control" name="oficina_equipo" onchange="selectNit(event)">
                                <option disabled selected>SELECCIONE DEPARTAMENTO</option>
                                <?php
                               
                                $mysqli = mysqli_connect(SERVER, USER, PASS, BD);
                                $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM oficinas";
                                $selticket=mysqli_query($mysqli,$consulta);
                                while ($row=mysqli_fetch_array($selticket, MYSQLI_ASSOC)){
                                  $oficina=$row['nombre_oficina'];
                                  $num_dire=Mysql::consulta("SELECT * FROM equipos WHERE oficina_equipo='$oficina'");
                                    $num_total_dire=mysqli_num_rows($num_dire);
                                    $suma=$num_total_dire+1;
                                    if($suma>=10){
                                      $resultado=$suma;
                                    }else{
                                      $resultado= '0'.$suma;
                                    }
                                  echo '<option value="'.$row['nombre_oficina'].'" data-nit="'.$row['iniciales_oficina'].$resultado.'" value="'.$row['id_oficina'].'">'.$row['nombre_oficina'].'</option>';
                                }
                                ?>
                                </select>
                                <span class="input-group-addon"><i class="fa fa-users"></i></span>
                              </div> 
                          </div>
                        </div>
                        
                        <div class="form-group">
                          <label  class="col-sm-2 control-label">Sedes</label>
                          <div class="col-sm-10">
                              <div class='input-group'>
                                <select class="form-control" name="sede">
                                  <option value="Hospital San Juan de Dios (Pisco)">Hospital San Juan de Dios (Pisco)</option>
                                  <option value="Puesto de Salud Huancano">Puesto de Salud Huancano</option>
                                  <option value="Centro de Salud Humay">Centro de Salud Humay</option>
                                  <option value="Centro de Salud de Independencia">Centro de Salud de Independencia</option>
                                  <option value="Centro de Salud Parácas">Centro de Salud Paracas</option>
                                  <option value="Centro de Salud San Andres">Centro de Salud San Andres</option>
                                  <option value="Centro de Salud San Clemente">Centro de Salud San Clemente</option>
                                  <option value="Centro de Salud San Miguel">Centro de Salud San Miguel</option>
                                  <option value="Centro de Salud Tupac Amaru Inca">Centro de Salud Tupac Amaru Inca</option>
                                </select>
                                <span class="input-group-addon"><i class="fa fa-ambulance"></i></span>
                              </div> 
                          </div>
                        </div>

                        <div class="form-group">
                          <label  class="col-sm-2 control-label">Usuario</label>
                          <div class="col-sm-10">
                              <div class='input-group'>
                                <input type="text" class="form-control" placeholder="Nombre completo del usuario (En Mayuscula)" required="" name="usuario_equipo" value="" id="usuario" onkeyup="convertir()">
                                <span class="input-group-addon"><i class="fa fa-podcast"></i></span>
                              </div>
                          </div>
                        </div>
                        <script>
                          document.getElementById('usuario').addEventListener('keyup', function(){
                          this.value = this.value.toUpperCase()
                        });
                        </script>
                        <div class="form-group">
                        <label class="col-sm-2 control-label">IP:</label>
                            <div class='col-sm-10'>
                                <div class="input-group">
                                    <input class="form-control" type="text" placeholder="Ej. 192.168.0.1" name="ip_equipo"  value="" id="ip" >
                                    <span class="input-group-addon"><i class="fa fa-map-marker"></i>    
                                    </span>
                                    <span> <span>
                                    
                                </div>
                                <div id="com_form"></div>
                            </div>
                        </div>

                        <div class="form-group">
                          <label  class="col-sm-2 control-label">Marca</label>
                          <div class="col-sm-10">
                              <div class='input-group'>
                                <input type="text" class="form-control" placeholder="Marca del Equipo" required="" name="marca_equipo" value="">
                                <span class="input-group-addon"><i class="fa fa-registered"></i></span>
                              </div>
                          </div>
                        </div>

                        <div class="form-group">
                          <label  class="col-sm-2 control-label">Hostname</label>
                          <div class="col-sm-10">
                              <div class='input-group'>
                              
                                <input type="text" class="form-control" placeholder="Nombre de Equipo" required="" name="name_equipo" disabled value="" id="nombre1">
                                <span class="input-group-addon btn-primary"><button class="button button5" onclick="document.getElementById('nombre1').disabled = false"><i class="fa fa-hospital-o"></i></button></span>
                              </div>
                          </div>
                        </div>

<style>
.button5 {
  background-color: #eeeeee;
  border: none;
  color: white;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  transition-duration: 0.4s;
  cursor: pointer;
}

.button5 {
  background-color: #eeeeee00;
  color: black;
  outline: none;
}

.button5:hover {
  background-color: #3276b1;
  color: white;
}
</style>

                        <div class="form-group">
                          <label  class="col-sm-2 control-label">Nombre Completo</label>
                          <div class="col-sm-10">
                              <div class='input-group'>
                                <input type="text" class="form-control" placeholder="Nombre" required="" readonly name="name_completo" id="nombre2">
                                <span class="input-group-addon"><i class="fa fa-desktop"></i></span>
                              </div>
                          </div>
                        </div>
                        <script>
                        
                        let txtnom = document.getElementById('nombre1');
                        let txtnombre = document.getElementById('nombre2');
  
                        txtnom.addEventListener('keyup', () => {
                        txtnombre.value = txtnom.value + ".HSJDPISCO.GOB.PE"
                        });
                    </script>
                        <div class="form-group">
                          <label  class="col-sm-2 control-label">MAC</label>
                          <div class="col-sm-10">
                              <div class='input-group'>
                                <input type="text" class="form-control" placeholder="Ej. 00:1B:44:11:3A:B7" required="" name="mac_equipo" value="">
                                <span class="input-group-addon"><i class="fa fa-qrcode"></i></span>
                              </div>
                          </div>
                        </div>

                        <div class="form-group">
                          <label  class="col-sm-2 control-label">USER</label>
                          <div class="col-sm-10">
                              <div class='input-group'>
                                <input type="text" class="form-control" placeholder="Ej. MQUISPE (María Quispe)" required="" name="user_equipo" readonly value="" id="user">
                                <span class="input-group-addon"><i class="fa fa-address-book-o"></i></span>
                              </div>
                          </div>
                        </div>

                        <script>
                          function convertir(){   
                            var cadena = $("#usuario").val();
                            separador = " ",
                            arregloDeSubCadenas = cadena.split(separador);
                            subcadena=arregloDeSubCadenas[0].substring(0, 1)+arregloDeSubCadenas[1];
                            $("#user").val(subcadena);
                          }
                        </script>
                        <div class="form-group">
                          <label  class="col-sm-2 control-label">Sistema Operativo</label>
                          <div class="col-sm-10">
                              <div class='input-group'>
                                <input type="text" class="form-control" placeholder="Ej. Windows 7..." required="" name="sistema_operativo" value="">
                                <span class="input-group-addon"><i class="fa fa-windows"></i></span>
                              </div>
                          </div>
                        </div>

                        <div class="form-group">
                          <label  class="col-sm-2 control-label">Procesador</label>
                          <div class="col-sm-10">
                              <div class='input-group'>
                                <input type="text" class="form-control" placeholder="Ej. Intel Core i3..." required="" name="tipo_procesador" value="">
                                <span class="input-group-addon"><i class="fa fa-puzzle-piece"></i></span>
                              </div>
                          </div>
                        </div>

                        <div class="form-group">
                          <label  class="col-sm-2 control-label">Memoria RAM</label>
                          <div class="col-sm-10">
                              <div class='input-group'>
                                <input type="text" class="form-control" placeholder="Memoria del Equipo" required="" name="memoria_equipo" value="">
                                <span class="input-group-addon"><i class="fa fa-microchip"></i></span>
                              </div>
                          </div>
                        </div>

                        <div class="form-group">
                          <label  class="col-sm-2 control-label">Disco Duro</label>
                          <div class="col-sm-10">
                              <div class='input-group'>
                                <input type="text" class="form-control" placeholder="Información del Disco Duro" required="" name="disco_duro" value="">
                                <span class="input-group-addon"><i class="fa fa-database"></i></span>
                              </div>
                          </div>
                        </div>

                        <div class="form-group">
                          <label  class="col-sm-2 control-label">Placa</label>
                          <div class="col-sm-10">
                              <div class='input-group'>
                                <input type="text" class="form-control" placeholder="Producto de Placa Base" required="" name="placa_equipo" value="">
                                <span class="input-group-addon"><i class="fa fa-keyboard-o"></i></span>
                              </div>
                          </div>
                        </div>

                        <div class="form-group">
                          <label  class="col-sm-2 control-label">Estado de Equipo</label>
                          <div class="col-sm-10">
                              <div class='input-group'>
                                <select class="form-control" name="estado_equipo">
                                  <option value="Funcionamiento">Funcionamiento</option>
                                  <option value="Mantenimiento">Mantenimiento</option>
                                </select>
                                <span class="input-group-addon"><i class="fa fa-heartbeat"></i></span>
                              </div> 
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-info">Agregar Equipo</button>
                          </div>
                        </div>
                             </fieldset> 
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        

<?php
}else{
?>
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <img src="./img/Stop.png" alt="Image" class="img-responsive"/><br>
                
            </div>
            <div class="col-sm-7 text-center">
                <h1 class="text-danger">Lo sentimos esta página es solamente para usuarios registrados en HELPDESK HSJDP</h1>
                <h3 class="text-info">Inicia sesión para poder acceder</h3>
            </div>
            <div class="col-sm-1">&nbsp;</div>
        </div>
    </div>
<?php
}
?>
<script>
    $(document).ready(function(){
        $("#ip").keyup(function(){
            $.ajax({
                url:"./process/val_equipo.php?ip_equipos="+$(this).val(),
                success:function(data){
                    $("#com_form").html(data);
                }
            });
        });
    });
</script>