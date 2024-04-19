<?php
    if( $_SESSION['nombre']!="" && $_SESSION['clave']!="" && $_SESSION['tipo']=="admin"){ 
?>
        <div class="container">
            <div class="row">
                <div class="col-sm-2">
                    <img src="./img/msj.png" alt="Image" class="img-responsive animated tada">
                </div>
                <div class="col-sm-10">
                    <p class="lead text-info">Bienvenido administrador, aqui se muestran todos los Tickets de HELPDESK HSJDP los cuales podra eliminar, modificar e imprimir.</p>
                </div>
            </div>
        </div>
        <?php
            if(isset($_POST['id_del'])){
                $id = MysqlQuery::RequestPost('id_del');
                if(MysqlQuery::Eliminar("ticket", "id='$id'")){
                    echo '
                        <div class="alert alert-info alert-dismissible fade in col-sm-3 animated bounceInDown" role="alert" style="position:fixed; top:70px; right:10px; z-index:10;"> 
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <h4 class="text-center">TICKET ELIMINADO</h4>
                            <p class="text-center">
                                El ticket fue eliminado del sistema con exito
                            </p>
                        </div>
                    ';
                }else{
                    echo '
                        <div class="alert alert-danger alert-dismissible fade in col-sm-3 animated bounceInDown" role="alert" style="position:fixed; top:70px; right:10px; z-index:10;"> 
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <h4 class="text-center">OCURRIÓ UN ERROR</h4>
                            <p class="text-center">
                                No hemos podido eliminar el ticket
                            </p>
                        </div>
                    '; 
                }
            }

            /* Todos los tickets*/
            $num_ticket_all=Mysql::consulta("SELECT * FROM ticket");
            $num_total_all=mysqli_num_rows($num_ticket_all);

            /* Tickets pendientes*/
            $num_ticket_pend=Mysql::consulta("SELECT * FROM ticket WHERE estado_ticket='Pendiente'");
            $num_total_pend=mysqli_num_rows($num_ticket_pend);

            /* Tickets en proceso*/
            $num_ticket_proceso=Mysql::consulta("SELECT * FROM ticket WHERE estado_ticket='En proceso'");
            $num_total_proceso=mysqli_num_rows($num_ticket_proceso);

            /* Tickets resueltos*/
            $num_ticket_res=Mysql::consulta("SELECT * FROM ticket WHERE estado_ticket='Resuelto'");
            $num_total_res=mysqli_num_rows($num_ticket_res);

            /* Tickets cerrado*/
            $num_ticket_cer=Mysql::consulta("SELECT * FROM ticket WHERE estado_ticket='Cerrado'");
            $num_total_cer=mysqli_num_rows($num_ticket_cer);

            /* Tickets por usuario*/
            $nombre=$_SESSION['nombre_completo'];
            $num_ticket_us=Mysql::consulta("SELECT * FROM ticket WHERE atencion_usuario='$nombre'");
            $num_total_us=mysqli_num_rows($num_ticket_us);
        ?>

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-justified">
                        <li>
                            <a href="./admin.php?view=ticketadmin&ticket=all">
                                <i class="fa fa-list"></i>
                                &nbsp;&nbsp;Todos&nbsp;&nbsp;
                                <span class="badge">
                                    <?php echo $num_total_all; ?>
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="./admin.php?view=ticketadmin&ticket=pending">
                                <i class="fa fa-envelope"></i>
                                &nbsp;&nbsp;Pendientes&nbsp;&nbsp;
                                <span class="badge">
                                    <?php echo $num_total_pend; ?>
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="./admin.php?view=ticketadmin&ticket=process">
                                <i class="fa fa-folder-open"></i>
                                &nbsp;&nbsp;Proceso&nbsp;&nbsp;
                                <span class="badge">
                                    <?php echo $num_total_proceso; ?>
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="./admin.php?view=ticketadmin&ticket=resolved">
                                <i class="fa fa-thumbs-o-up"></i>
                                &nbsp;&nbsp;Resueltos&nbsp;&nbsp;
                                <span class="badge">
                                    <?php echo $num_total_res; ?>
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="./admin.php?view=ticketadmin&ticket=cerrado">
                                <i class="fa fa-window-close-o"></i>
                                &nbsp;&nbsp;Cerrado&nbsp;&nbsp;
                                <span class="badge">
                                    <?php echo $num_total_cer; ?>
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="./admin.php?view=ticketadmin&ticket=usuario">
                                <i class="fa fa-id-badge"></i>
                                &nbsp;&nbsp;<?php echo $_SESSION['nombre_completo']; ?>&nbsp;&nbsp;
                                <span class="badge">
                                        <?php echo $num_total_us; ?>
                                </span>
                            </a>
                        </li>
                        <li><a href="GenerarExcel.php">
                                <i class="fa fa-table"></i>
                                &nbsp;&nbsp;Generar Excel&nbsp;&nbsp;
                                <span class="badge"></span>
                            </a>
                        </li>
							</button>
								<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
									<li><a href="form_contacto.php">Registrar</a></li>
									<li><a href="GenerarExcel.php">Generar Fichero Excel</a></li>
								</ul>
							
                    </ul>
                </div>
            </div>
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
                            if(isset($_GET['ticket'])){
                                if($_GET['ticket']=="all"){
                                    $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM ticket LIMIT $inicio, $regpagina";
                                }elseif($_GET['ticket']=="pending"){
                                    $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM ticket WHERE estado_ticket='Pendiente' LIMIT $inicio, $regpagina";
                                }elseif($_GET['ticket']=="process"){
                                    $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM ticket WHERE estado_ticket='En proceso' LIMIT $inicio, $regpagina";
                                }elseif($_GET['ticket']=="resolved"){
                                    $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM ticket WHERE estado_ticket='Resuelto' LIMIT $inicio, $regpagina";
                                }elseif($_GET['ticket']=="cerrado"){
                                    $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM ticket WHERE estado_ticket='Cerrado' LIMIT $inicio, $regpagina";
                                }elseif($_GET['ticket']=="usuario"){
                                    $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM ticket WHERE atencion_usuario='$nombre' LIMIT $inicio, $regpagina";
                                }else{
                                    $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM ticket LIMIT $inicio, $regpagina";
                                }
                            }else{
                                $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM ticket WHERE estado_ticket!='Cerrado' LIMIT $inicio, $regpagina";
                            }


                            $selticket=mysqli_query($mysqli,$consulta);

                            $totalregistros = mysqli_query($mysqli,"SELECT FOUND_ROWS()");
                            $totalregistros = mysqli_fetch_array($totalregistros, MYSQLI_ASSOC);
                    
                            $numeropaginas = ceil($totalregistros["FOUND_ROWS()"]/$regpagina);
                            if(mysqli_num_rows($selticket)>0):
                        ?>
                        <table class="table table-hover  table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Fecha</th>
                                    <th class="text-center">Serie</th>
                                    <th class="text-center">Estado</th>
                                    <th class="text-center">Nombre</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Atención</th>
                                    <th class="text-center">Departamento</th>
                                    <th class="text-center">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $ct=$inicio+1;
                                    while ($row=mysqli_fetch_array($selticket, MYSQLI_ASSOC)): 
                                ?>
                                <tr class="<?php
                                        $firstDate = $row['fecha'];
                                        
                                        $secondDate = date("Y/m/d");
                                        
                                        $dateDifference = abs(strtotime($secondDate) - strtotime($firstDate));
                                    
                                        $years  = floor($dateDifference / (365 * 60 * 60 * 24));
                                        $months = floor(($dateDifference - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                                        $days   = floor(($dateDifference - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 *24) / (60 * 60 * 24));
                                        
                                        if($row['estado_ticket']=='Cerrado'){
                                        $color='bg-success';
                                        }else{
                                            if($days>2){
                                                $color='bg-danger';
                                            }else{
                                                if($months>0){
                                                    $color='bg-danger';
                                                }else{
                                                    if($years>0){
                                                        $color='bg-danger';
                                                    }else{
                                                        $color='';
                                                    }
                                                }
                                            }
                                        }
                                        echo $color;
                                    ?>
                                    ">
                                    
                                    <td class="text-center"><?php echo $ct; ?></td>
                                    <td class="text-center"><?php echo $row['fecha']; ?></td>
                                    <td class="text-center"><?php echo $row['serie']; ?></td>
                                    <td class="text-center"><?php echo $row['estado_ticket']; ?></td>
                                    <td class="text-center"><?php echo $row['nombre_usuario']; ?></td>
                                    <td class="text-center"><?php echo $row['email_cliente']; ?></td>
                                    <td class="text-center"><?php echo $row['atencion_usuario']; ?></td>
                                    <td class="text-center"><?php echo $row['departamento']; ?></td>
                                    <td class="text-center">
                                        <a href="./lib/pdf.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-success" target="_blank"><i class="fa fa-print" aria-hidden="true"></i></a>
                                        <a href="admin.php?view=ticketedit&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                        <form action="" method="POST" style="display: inline-block;">
                                            <input type="hidden" name="id_del" value="<?php echo $row['id']; ?>">
                                            <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                    <?php
                                        $ct++;
                                        endwhile; 
                                    ?>
                            </tbody>
                        </table>
                        
                            
                            <?php endif; ?>
                    </div>
                    
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
                <h1 class="text-danger">Lo sentimos esta página es solamente para administradores de HELPDESK HSJDP</h1>
                <h3 class="text-info text-center">Inicia sesión como administrador para poder acceder</h3>
            </div>
            <div class="col-sm-1">&nbsp;</div>
        </div>
    </div>
<?php
}
?>