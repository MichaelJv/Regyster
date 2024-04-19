<?php	     
	$id = MysqlQuery::RequestGet('ip_equipos');
    $sql = Mysql::consulta("SELECT * FROM equipos WHERE ip_equipos= '$id'");
    $reg=mysqli_fetch_array($sql, MYSQLI_ASSOC);
?>


        <!--************************************ Page content******************************-->
        <div class="container">
          <div class="row">
            <div class="col-sm-3">
                <img src="./img/Edit.png" alt="Image" class="img-responsive animated tada">
            </div>
            <div class="col-sm-9">
                <a href="./admin.php?view=equipoadmin" class="btn btn-primary btn-sm pull-right"><i class="fa fa-reply"></i>&nbsp;&nbsp;Volver administrar Equipos</a>
            </div>
            <div class="col-sm-3">
                <center><h1>192.168.1.<?php echo $id;?></h1></center>
          </div>
          </div>
        </div>
        

        <div class="container">
            <div class="col-sm-12">
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
            </div><!--col-md-12-->
        </div><!--container-->