<?php
    if(isset($_POST['iniciales'])){
        $nombre_of=MysqlQuery::RequestPost('name_oficina');
        $iniciales=MysqlQuery::RequestPost('iniciales');
        if(MysqlQuery::Guardar("oficinas", 
                                "nombre_oficina,
                                iniciales_oficina", 
                                "'$nombre_of',
                                '$iniciales'")){

            /*----------  Enviar correo con los datos de la cuenta 
                mail($email_reg, $asunto, $mensaje_mail, $cabecera);
            ----------*/

            echo '
                <div class="alert alert-info alert-dismissible fade in col-sm-3 animated bounceInDown" role="alert" style="position:fixed; top:70px; right:10px; z-index:10;"> 
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="text-center">REGISTRO EXITOSO</h4>
                    <p class="text-center">
                        Oficina agregada exitosamente, ahora puedes registrar su equipo.
                    </p>
                </div>
            ';
        }else{
            echo '
                <div class="alert alert-danger alert-dismissible fade in col-sm-3 animated bounceInDown" role="alert" style="position:fixed; top:70px; right:10px; z-index:10;"> 
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="text-center">OCURRIÓ UN ERROR</h4>
                    <p class="text-center">
                        ERROR AL REGISTRARSE: Por favor intente nuevamente.
                    </p>
                </div>
            '; 
        }
    }
?>
<div class="container">
  <div class="row">
  <div class="col-sm-12">
                <a href="./index.php?view=equiponew" class="btn btn-primary btn-sm pull-right"><i class="fa fa-reply"></i>&nbsp;&nbsp;Regresar a Equipos</a>
            </div>
            <br><br>
    <div class="col-sm-8">
      <div class="panel panel-success">
        <div class="panel-heading text-center"><strong>Para poder registrarte debes de llenar todos los campos de este formulario</strong></div>
        <div class="panel-body">
            <form role="form" action="" method="POST">
            <div class="form-group">
              <label><i class="fa fa-hospital-o"></i>&nbsp;Nombre de Oficina</label>
              <input type="text" class="form-control" name="name_oficina" placeholder="Nombre completo de Oficina" required="" pattern="[a-zA-Z ]{1,40}" maxlength="40" id="nombre_ofic">
            </div>
            <script>
                document.getElementById('nombre_ofic').addEventListener('keyup', function(){
                this.value = this.value.toUpperCase()
                });
            </script>
            <div class="form-group has-success has-feedback">
              <label class="control-label"><i class="fa fa-buysellads"></i>&nbsp;Iniciales</label>
              <input type="text" id="inic" class="form-control" name="iniciales" placeholder="Identificador de la Oficina" required="" pattern="[a-zA-Z0-9]{1,15}" maxlength="20">
              <div id="com_form"></div>
              <script>
                document.getElementById('inic').addEventListener('keyup', function(){
                this.value = this.value.toUpperCase()
                });
            </script>
            </div>
            <button type="submit" class="btn btn-danger">Agregar</button>
          </form>
        </div>
      </div>
    </div>

    <div class="col-sm-4 text-center hidden-xs">
      <center><img src="img/of_hospital.png" class="img-responsive" alt="Image" width="260"  height="260"><center>
      <h2 class="text-primary">¡Gracias! Por preferirnos</h2>
    </div>

  </div>
</div>
<script>
    $(document).ready(function(){
        $("#inic").keyup(function(){
            $.ajax({
                url:"./process/val_oficina.php?id_oficina="+$(this).val(),
                success:function(data){
                    $("#com_form").html(data);
                }
            });
        });
    });
</script>