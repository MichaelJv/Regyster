<div class="container">
  <div class="row well">
    <div class="col-sm-3">
      <img src="img/Control_Inventario.png" class="img-responsive" alt="Image">
    </div>
    <div class="col-sm-9 lead">
      <h2 class="text-info">Bienvenido al inventario de equipos del Hospital San Juan de Dios de Pisco</h2>
      <p>Es muy fácil de usar, si el Hospital tiene nuevo equipo, puede agregarlo a través de este módulo.<br>Si el equipo está en funcionamiento puedes consultar las <strong>IPs</strong> de los equipos de las diferentes áreas.</p>
    </div>
  </div><!--fin row 1-->

  <div class="row">
    <div class="col-sm-6">
      <div class="panel panel-info">
        <div class="panel-heading text-center"><i class="fa fa-desktop"></i>&nbsp;<strong>Nuevo Equipo</strong></div>
        <div class="panel-body text-center">
          <img src="./img/nuevo_equipo.png" alt="">
          <h4>Abrir un nuevo Equipo</h4>
          <p class="text-justify">Si tienes un problema con cualquiera de nuestros productos repórtalo creando un nuevo ticket y te ayudaremos a solucionarlo. Si desea actualizar una petición ya realizada utiliza el formulario de la derecha <em>Comprobar estado de Ticket</em>, solamente los <strong>usuarios registrados</strong> pueden abrir un nuevo ticket.</p>
          <p>Para abrir un nuevo <strong>ticket</strong> has clic en el siguiente botón</p>
          <a type="button" class="btn btn-info" href="./index.php?view=equiponew">Nuevo Equipo</a>
        </div>
      </div>
    </div><!--fin col-md-6-->
    
    <div class="col-sm-6">
      <div class="panel panel-danger">
        <div class="panel-heading text-center"><i class="fa fa-server"></i>&nbsp;<strong>Consultar IP</strong></div>
        <div class="panel-body text-center">
          <img src="./img/direccion-ip.png" alt="">
          <h4>¿Cuál es mi IP?</h4>
          <form class="form-horizontal" role="form" method="GET" action="./index.php">
            <input type="hidden" name="view" value="equipocon">
            <div class="form-group">
              <label class="col-sm-2 control-label">Hostname</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" name="oficina_consul" placeholder="¿A qué oficina pertenece?" required="">
              </div>
            </div>
            <div class="form-group">
              <label  class="col-sm-2 control-label">User</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" name="user_consul" placeholder="¿Cuál es su usuario?" required="">
              </div>
            </div>
            
              <label  class="col-sm-12">¿Olvido su Hostname o user?</label>
              <p class="text-center">Haga clic en el boton <b>Mostrar oficina</b> le mostrará una guia para poder recordar su Hostname o User.</p>
            
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-8">
                <button type="submit" class="btn btn-success">Consultar</button>
                <input class="btn btn-primary" type="button" id="botonocultamuestra" value="Mostrar Oficinas" style="font-size:14px;cursor:pointer;margin:15px;padding:5px;"/>
              </div>
            </div>
            <style>
            #tabla{
              display: none;
            }
            </style>
            <script>
              $(document).ready(function(){
   $("#botonocultamuestra").click(function(){
      $("#divocultamuestra").each(function() {
        displaying = $(this).css("display");
        if(displaying == "block") {
          $(this).fadeOut('slow',function() {
           $(this).css("display","none");
          });
        } else {
          $(this).fadeIn('slow',function() {
            $(this).css("display","block");
          });
        }
      });
    });
  });
            </script>
            

          </form>
          

        </div>
      </div>    
    </div><!--fin col-md-6-->
    <div class="row">
    <div class="col-sm-12" id="divocultamuestra" style="display:none">
      <div class="panel panel-warning class">
        <div class="panel-heading text-center">
          <i class="fa fa-hospital-o"></i>
          &nbsp;<strong>OFICINAS REGISTRADAS</strong>
        </div>
    <?php if(isset($_SESSION['nombre']) && isset($_SESSION['tipo'])){ ?>
                <br>
                <div class="row">
                  <div class="col-md-12">
                    <div class="table-responsive">
                      <?php
                        $mysqli = mysqli_connect(SERVER, USER, PASS, BD);
                        mysqli_set_charset($mysqli, "utf8");
                        $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
                        $regpagina = 15;
                        $inicio = ($pagina > 1) ? (($pagina * $regpagina) - $regpagina) : 0;
                        $nombre=$_SESSION['nombre_completo'];
                        $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM oficinas LIMIT $inicio, $regpagina";
                        $seloficina=mysqli_query($mysqli,$consulta);
                        $totalregistros = mysqli_query($mysqli,"SELECT FOUND_ROWS()");
                        $totalregistros = mysqli_fetch_array($totalregistros, MYSQLI_ASSOC);

                        $numeropaginas = ceil($totalregistros["FOUND_ROWS()"]/$regpagina);
                                    
                        if(mysqli_num_rows($seloficina)>0):
                      ?>
                    <h3 class="text-center"><b>EJEMPLO:</b></h3>
                    <center><img src="./img/Imagen1.png" width="550"></center>

                      <table class="table table-hover table-striped table-bordered">
                        <thead>
                          <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Oficina</th>
                            <th class="text-center">Iniciales de Oficina</th>
                            <th class="text-center">N° Registros</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
                          $ct=$inicio+1;

                          while ($row=mysqli_fetch_array($seloficina, MYSQLI_ASSOC)): 
                        ?>
                          <tr>
                            <td class="text-center"><?php echo $ct; ?></td>
                            <td class="text-center"><?php echo $row['nombre_oficina']; ?></td>
                            <td class="text-center"><?php echo $row['iniciales_oficina']; ?></td>
                            <td class="text-center"><?php 
                            $nombre=$row['nombre_oficina'];
                            $num_dire=Mysql::consulta("SELECT * FROM equipos WHERE oficina_equipo='$nombre'");
                            $num_total_dire=mysqli_num_rows($num_dire);
                            if($num_total_dire>1){
                              echo "1 - ";
                              echo $num_total_dire;
                            } else{
                              echo $num_total_dire;
                            }
                            
                            ?></td>
                          </tr>
                          <?php
                            $ct++;
                            endwhile; 
                          ?>
                          </tbody>
                          </table>
                          <?php else: ?>
                              <h2 class="text-center">No hay tickets registrados en el sistema</h2>
                          <?php endif; ?>
                    </div>
                      <?php 
                        if($numeropaginas>=1):
                          if(isset($_GET['ticket'])){
                              $ticketselected=$_GET['ticket'];
                          }else{
                              $ticketselected="all";
                          }
                        ?>
                        <nav aria-label="Page navigation" class="text-center">
                            <ul class="pagination">
                                <?php if($pagina == 1): ?>
                                    <li class="disabled">
                                        <a aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                <?php else: ?>
                                    <li>
                                        <a href="./index.php?view=soporte&ticket=<?php echo $ticketselected; ?>&pagina=<?php echo $pagina-1; ?>" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                            
                                        </a>
                                    </li>
                                <?php endif; ?>
                                
                                
                                <?php
                                    for($i=1; $i <= $numeropaginas; $i++ ){
                                        if($pagina == $i){
                                            echo '<li class="active"><a href="./index.php?view=soporte&ticket='.$ticketselected.'&pagina='.$i.'">'.$i.'</a></li>';
                                        }else{
                                            echo '<li><a href="./index.php?view=soporte&ticket='.$ticketselected.'&pagina='.$i.'">'.$i.'</a></li>';
                                        }
                                    }
                                ?>
                                
                                
                                <?php if($pagina == $numeropaginas): ?>
                                    <li class="disabled">
                                        <a aria-label="Previous">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                <?php else: ?>
                                    <li>
                                        <a href="./index.php?view=soporte&ticket=<?php echo $ticketselected; ?>&pagina=<?php echo $pagina+1; ?>" aria-label="Previous">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                            <ul>
                                </ul>
                        </nav>
                        <?php endif; ?>
                    </div>
                </div>
            </div><!--container principal-->
            
    <?php
      }else{
    ?>
      <div class="container">
        <div class="row">
          <div class="col-sm-4">
            <img src="./img/Stop.png" alt="Image" class="img-responsive animated slideInDown"/><br>
                   
          </div>
          <div class="col-sm-7 animated flip">
            <h1 class="text-danger">Lo sentimos esta página es solamente para usuarios de HELPDESK HSJDP</h1>
            <h3 class="text-info text-center">Inicia sesión para poder acceder</h3>
          </div>
          <div class="col-sm-1">&nbsp;</div>
        </div>
      </div>
<?php
}
?>
</div></div></div>
  </div><!--fin row 2-->
</div><!--fin container-->