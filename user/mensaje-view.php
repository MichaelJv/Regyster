<div class="container">
  <div class="row well">
    <div class="col-sm-3">
      <img src="img/mensaje_ticket.png" class="img-responsive" alt="Image">
    </div>
    <div class="col-sm-9 lead">
        <h2 class="text-info">Bienvenido a la bandeja de mensajes HELPDESK HSJDP</h2>
        <p>Puedes <strong>visualizar</strong> todos los mensajes de su cuenta o <strong>eliminar</strong> de manera permanente los mensajes de HELPDESK HSJDP</p>    </div>
  </div><!--fin row 1-->


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
                        $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM ticket WHERE nombre_usuario='$nombre' and estado_mensaje>='1' ORDER BY fecha_atencion DESC LIMIT $inicio, $regpagina";
                        $selticket=mysqli_query($mysqli,$consulta);
                        $totalregistros = mysqli_query($mysqli,"SELECT FOUND_ROWS()");
                        $totalregistros = mysqli_fetch_array($totalregistros, MYSQLI_ASSOC);
                        
                        $numeropaginas = ceil($totalregistros["FOUND_ROWS()"]/$regpagina);

                        if(mysqli_num_rows($selticket)>0):
                      ?>
                      <table class="table table-hover sol">
                        <thead>
                          <tr>
                            <th class="text-center" colspan="6">N° Mensajes</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
                          $ct=$inicio+1;

                          while ($row=mysqli_fetch_array($selticket, MYSQLI_ASSOC)): 
                        ?>
                          <tr class="
                                    <?php
                                        if($row['estado_mensaje']=='1'){
                                        $color='bg-info';
                                        }else{
                                            $color='table-light';
                                        }
                                        echo $color;
                                    ?>">
                            <td class="text-center" hidden><?php echo $ct;?></td>
                            <td class="text-center"><?php echo $row['serie']; ?></td>
                            <td class="text-center"><?php echo $row['asunto']; ?></td>
                            <td class="text-center"><?php echo $row['mensaje']; ?></td>
                            <td class="text-center">Solución enviada</td>
                            <td class="text-center"><?php echo $row['fecha_atencion']; ?></td>
                            <td class="text-center">
                            <form action="./index.php?view=ticketcon&email_consul=<?php echo $row['email_cliente']; ?>&id_consul=<?php echo $row['serie']; ?>" method="post" role="form">
                    <div class="form-group" hidden>
                      <label class="text-primary"><i class="fa fa-male"></i>&nbsp;&nbsp;ID</label>
                      <input type="text" name="id_del" value="<?php echo $row['id']; ?>">
                    </div>
                    <div class="form-group  has-success has-feedback" hidden>

                      <label class="text-primary"><i class="fa fa-user"></i>&nbsp;&nbsp;Nombre de usuario nuevo</label>
                      <input type="text" readonly="" class="form-control"  name="mensaje_usuario" readonly="" value="2">
                      <div id="com_form"></div>
                    </div>
                    <button type="submit" class="btn btn-info"><i class="fa fa-eye" aria-hidden="true"></i></button>
                  </form>
                            </td>
                            

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