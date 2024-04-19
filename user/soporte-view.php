<div class="container">
  <div class="row well">
    <div class="col-sm-3">
      <img src="img/tux_repair.png" class="img-responsive" alt="Image">
    </div>
    <div class="col-sm-9 lead">
      <h2 class="text-info">Bienvenido al centro de soporte del Hospital San Juan de Dios de Pisco</h2>
      <p>Es muy fácil de usar, si usted tiene problemas con nuestros equipos nos puede enviar un nuevo ticket, nosotros lo respondemos y solucionaremos su problema.<br>Si ya nos ha enviado un ticket puede consultar el estado de este mediante su <strong>Ticket ID</strong>.</p>
    </div>
  </div><!--fin row 1-->

  <div class="row">
    <div class="col-sm-6">
      <div class="panel panel-info">
        <div class="panel-heading text-center"><i class="fa fa-file-text"></i>&nbsp;<strong>Nuevo Ticket</strong></div>
        <div class="panel-body text-center">
          <img src="./img/new_tickets.png" alt="">
          <h4>Abrir un nuevo ticket</h4>
          <p class="text-justify">Si tienes un problema con cualquiera de nuestros productos repórtalo creando un nuevo ticket y te ayudaremos a solucionarlo. Si desea actualizar una petición ya realizada utiliza el formulario de la derecha <em>Comprobar estado de Ticket</em>, solamente los <strong>usuarios registrados</strong> pueden abrir un nuevo ticket.</p>
          <p>Para abrir un nuevo <strong>ticket</strong> has clic en el siguiente botón</p>
          <a type="button" class="btn btn-info" href="./index.php?view=ticket">Nuevo Ticket</a>
        </div>
      </div>
    </div><!--fin col-md-6-->
    
    <div class="col-sm-6">
      <div class="panel panel-danger">
        <div class="panel-heading text-center"><i class="fa fa-link"></i>&nbsp;<strong>Comprobar estado de Ticket</strong></div>
        <div class="panel-body text-center">
          <img src="./img/ticket_soporte.png" alt="">
          <h4>Consultar estado de ticket</h4>
          <form class="form-horizontal" role="form" method="GET" action="./index.php">
            <input type="hidden" name="view" value="ticketcon">
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
              <div class="col-sm-10">
                  <input type="email" class="form-control" name="email_consul" placeholder="Email" required="">
              </div>
            </div>
            <div class="form-group">
              <label  class="col-sm-2 control-label">ID Ticket</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" name="id_consul" placeholder="ID Ticket" required="">
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-8">
                <button type="submit" class="btn btn-success">Consultar</button>
                <input class="btn btn-primary" type="button" id="botonocultamuestra" value="Mostrar ticket" style="font-size:14px;cursor:pointer;margin:15px;padding:5px;"/>
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
          <i class="fa fa-ticket"></i>
          &nbsp;<strong>Ticket Generados</strong>
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
                        $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM ticket WHERE nombre_usuario='$nombre' ORDER BY id DESC LIMIT $inicio, $regpagina";
                        $selticket=mysqli_query($mysqli,$consulta);
                        $totalregistros = mysqli_query($mysqli,"SELECT FOUND_ROWS()");
                        $totalregistros = mysqli_fetch_array($totalregistros, MYSQLI_ASSOC);
                        
                        $numeropaginas = ceil($totalregistros["FOUND_ROWS()"]/$regpagina);

                        if(mysqli_num_rows($selticket)>0):
                      ?>
                      <table class="table table-hover table-striped table-bordered">
                        <thead>
                          <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Fecha</th>
                            <th class="text-center">Serie</th>
                            <th class="text-center">Nombre</th>
                            <th class="text-center">Departamento</th>
                            <th class="text-center">Mensaje</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
                          $ct=$inicio+1;

                          while ($row=mysqli_fetch_array($selticket, MYSQLI_ASSOC)): 
                        ?>
                          <tr>
                            <td class="text-center"><?php echo $ct; ?></td>
                            <td class="text-center"><?php echo $row['fecha']; ?></td>
                            <td class="text-center"><?php echo $row['serie']; ?></td>
                            <td class="text-center"><?php echo $row['nombre_usuario']; ?></td>
                            <td class="text-center"><?php echo $row['departamento']; ?></td>
                            <td class="text-center"><?php echo $row['mensaje']; ?></td>
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