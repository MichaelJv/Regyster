<?php
    if( $_SESSION['nombre']!="" && $_SESSION['clave']!="" && $_SESSION['tipo']=="admin"){ 
?>
        <div class="container">
            <div class="row">
                <div class="col-sm-2">
                    <img src="./img/enrutamiento.png" alt="Image" class="img-responsive animated tada">
                </div>
                <div class="col-sm-10">
                    <p class="lead text-info">Bienvenido administrador, aqui se muestran todos los Equipos en funcionamiento y mantenimiento de HELPDESK HSJDP, en este apartado podra eliminar, modificar e imprimir.</p>
                </div>
            </div>
        </div>
        <?php
            if(isset($_POST['id_del'])){
                $id_edit = MysqlQuery::RequestPost('id_del');
                $uso_edit=  MysqlQuery::RequestPost('uso_edit');
                if(MysqlQuery::Actualizar("equipos", 
                              "usado_equipo='$uso_edit'",
                              "ip_equipos='$id_edit'")){
                    echo '
                        <div class="alert alert-info alert-dismissible fade in col-sm-3 animated bounceInDown" role="alert" style="position:fixed; top:70px; right:10px; z-index:10;"> 
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <h4 class="text-center">IP Liberada </h4>
                            <p class="text-center">
                                IP <strong>192.168.1'.$id_edit.'</strong> ha sido liberada
                            </p>
                        </div>
                    ';
                }else{
                    echo '
                        <div class="alert alert-danger alert-dismissible fade in col-sm-3 animated bounceInDown" role="alert" style="position:fixed; top:70px; right:10px; z-index:10;"> 
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <h4 class="text-center">OCURRIÓ UN ERROR</h4>
                            <p class="text-center">
                                No hemos podido liberar IP
                            </p>
                        </div>
                    '; 
                }
            }

            /* Todos los equipos*/
            $num_equipo_all=Mysql::consulta("SELECT * FROM equipos");
            $num_total_all=mysqli_num_rows($num_equipo_all);

            /* Equipos Funcionamiento*/
            $num_equipo_fun=Mysql::consulta("SELECT * FROM equipos WHERE est_equipos='Funcionamiento'");
            $num_total_fun=mysqli_num_rows($num_equipo_fun);

           /* Equipos Mantenimiento*/
           $num_equipo_man=Mysql::consulta("SELECT * FROM equipos WHERE est_equipos='Mantenimiento'");
           $num_total_man=mysqli_num_rows($num_equipo_man); 

           /* Equipos en Uso*/
           $num_equipo_uso=Mysql::consulta("SELECT * FROM equipos WHERE usado_equipo='1'");
           $num_total_uso=mysqli_num_rows($num_equipo_uso); 

           /* Equipos sin Uso*/
           $num_total_no= 255-$num_total_uso
           /*$num_equipo_no=Mysql::consulta("SELECT * FROM equipos WHERE usado_equipo='0'");
           $num_total_no=mysqli_num_rows($num_equipo_no); */
        ?>

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-justified">
                        <li>
                            <a href="./admin.php?view=equipoadmin&equipo=all">
                                <i class="fa fa-list"></i>
                                &nbsp;&nbsp;Todos&nbsp;&nbsp;
                                <span class="badge">
                                    <?php echo $num_total_all; ?>
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="./admin.php?view=equipoadmin&equipo=funcionamiento">
                                <i class="fa fa-thumbs-o-up"></i>
                                &nbsp;&nbsp;En Funcionamiento&nbsp;&nbsp;
                                <span class="badge">
                                    <?php echo $num_total_fun; ?>
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="./admin.php?view=equipoadmin&equipo=mantenimiento">
                                <i class="fa fa-wrench"></i>
                                &nbsp;&nbsp;En Manteniemiento&nbsp;&nbsp;
                                <span class="badge">
                                    <?php echo $num_total_man; ?>
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="./admin.php?view=equipoadmin&equipo=uso">
                                <i class="fa fa-spinner"></i>
                                &nbsp;&nbsp;En Uso&nbsp;&nbsp;
                                <span class="badge">
                                    <?php echo $num_total_uso; ?>
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="./admin.php?view=equipoadmin&equipo=sinuso">
                                <i class="fa fa-bed"></i>
                                &nbsp;&nbsp;Sin Uso&nbsp;&nbsp;
                                <span class="badge">
                                    <?php echo $num_total_no; ?>
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
                            if(isset($_GET['equipo'])){
                                if($_GET['equipo']=="all"){
                                    $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM equipos LIMIT $inicio, $regpagina";
                                }elseif($_GET['equipo']=="funcionamiento"){
                                    $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM equipos WHERE est_equipos='Funcionamiento' LIMIT $inicio, $regpagina";
                                }elseif($_GET['equipo']=="mantenimiento"){
                                    $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM equipos WHERE est_equipos='Mantenimiento'LIMIT $inicio, $regpagina";
                                }elseif($_GET['equipo']=="uso"){
                                    $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM equipos WHERE usado_equipo='1' LIMIT $inicio, $regpagina";
                                }elseif($_GET['equipo']=="sinuso"){
                                    $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM equipos WHERE usado_equipo!='1' LIMIT $inicio, $regpagina";
                                }else{
                                    $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM equipos LIMIT $inicio, $regpagina";
                                }
                            }else{
                                $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM equipos LIMIT $inicio, $regpagina";
                            }


                            $selequipo=mysqli_query($mysqli,$consulta);

                            $totalregistros = mysqli_query($mysqli,"SELECT FOUND_ROWS()");
                            $totalregistros = mysqli_fetch_array($totalregistros, MYSQLI_ASSOC);
                    
                            $numeropaginas = ceil($totalregistros["FOUND_ROWS()"]/$regpagina);
                            if(mysqli_num_rows($selequipo)>0):
                        ?>
                        <table class="table table-hover table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">IP</th>
                                    <th class="text-center">Sede</th>
                                    <th class="text-center">Marca</th>
                                    <th class="text-center">Hostname</th>
                                    <th class="text-center">MAC</th>
                                    <th class="text-center">Memoria RAM</th>
                                    <th class="text-center">Disco Duro</th>
                                    <th class="text-center">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                    $ct=$inicio+1;
                                    while ($row=mysqli_fetch_array($selequipo, MYSQLI_ASSOC)): 
                                ?>
                                <tr> 
                                    <td class="text-center">192.168.1.<?php echo $row['ip_equipos']; ?></td>
                                    <td class="text-center"><?php echo $row['sede_hospital']; ?></td>
                                    <td class="text-center"><?php echo $row['marca_equipo']; ?></td>
                                    <td class="text-center"><?php echo $row['nombre_equipo']; ?></td>
                                    <td class="text-center"><?php echo $row['mac_equipo']; ?></td>
                                    <td class="text-center"><?php echo $row['memoria_ram']; ?></td>
                                    <td class="text-center"><?php echo $row['disco_duro']; ?></td>
                                    <td class="text-center">
                                        <form role="form" method="GET" action="./index.php"style="display: inline-block;">
                                        <input type="hidden" name="view" value="equipocon">
                                            <input type="hidden" class="form-control" name="oficina_consul" placeholder="¿A qué oficina pertenece?" required="" value="<?php echo $row['nombre_equipo']; ?>" >
                                            <input type="hidden" class="form-control" name="user_consul" placeholder="¿Cuál es su usuario?" required="" value="<?php echo $row['user_equipo']; ?>" >
                                            <button type="submit" class="btn  btn-sm btn-primary"><i class="fa fa-eye" aria-hidden="true"></i></button>
                                        </form>
                                        <a href="admin.php?view=equipoedit&ip_equipos=<?php echo $row['ip_equipos']; ?>" class="btn btn-sm btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                        <?php
                                        $usado=$row['usado_equipo'];
                                        $id=$row['ip_equipos'];
                                        if($usado>=1){
                                            echo '
                                            <form action="" method="POST" style="display: inline-block;">
                                            <input type="hidden" name="id_del" value="'.$id.'">
                                            <input type="hidden" name="uso_edit" value="0">
                                            <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-power-off" aria-hidden="true"></i></button>
                                        </form>
                                            ';
                                        }else{
                                            echo "";
                                        }
                                        ?>
                                    </td>
                                </tr>
                                    <?php
                                        $ct++;
                                        endwhile; 
                                    ?>
                                </tbody>
                            </table>
                        
                            <?php else: ?>
                                <h2 class="text-center">No hay IP registradas en el sistema</h2>
                            <?php endif; ?>
                            <?php 
                        if($numeropaginas>=1):
                        if(isset($_GET['equipos'])){
                            $equiposelected=$_GET['equipos'];
                        }else{
                            $equiposelected="all";
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
                                    <a href="./admin.php?view=equipoadmin&equipo=<?php echo $equiposelected; ?>&pagina=<?php echo $pagina-1; ?>" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <?php endif; ?>
                                
                                <?php
                                    for($i=1; $i <= $numeropaginas; $i++ ){
                                        if($pagina == $i){
                                            echo '<li class="active"><a href="./admin.php?view=equipoadmin&equipo='.$equiposelected.'&pagina='.$i.'">'.$i.'</a></li>';
                                        }else{
                                            echo '<li><a href="./admin.php?view=equipoadmin&equipo='.$equiposelected.'&pagina='.$i.'">'.$i.'</a></li>';
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
                                <a href="./admin.php?view=equipoadmin&equipo==<?php echo $equiposelected; ?>&pagina=<?php echo $pagina+1; ?>" aria-label="Previous">
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