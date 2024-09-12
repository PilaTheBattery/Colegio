

<?php 

	session_start();
	
	if(!isset($_SESSION['SUsuaId'])){
		header("Location: index.php");
	}
	
	$Sid = $_SESSION['SUsuaId'];
	$SUsuaId = $_SESSION['SUsuaId'];
    $SUsuaNomb = $_SESSION['SUsuaNomb'];
	$SUsuaNivel = $_SESSION['SUsuaNivel'];
	$SInstId = $_SESSION['SInstId'];
    $STexto = $_SESSION['STexto'];
	$SFondo = $_SESSION['SFondo'];
    

	include_once($_SERVER['DOCUMENT_ROOT'].'/Colegio/Template/inicio.php');
    include_once($_SERVER['DOCUMENT_ROOT'].'/Colegio/Directorios.php');
    
    include_once (CSQL_DIR."ColegioBd.php");

    $VUsuaEstatus=2;
    $Tabla_Usuarios = new RegDatos();
    if($SUsuaNivel==0) { $TodosUsuarios = $Tabla_Usuarios->Usuarios_Obtener_Todos($VUsuaEstatus); }  //Leer todos los Usuarios
    else { $TodosUsuarios = $Tabla_Usuarios->Usuarios_Obtener_InstId($SInstId,$VUsuaEstatus);} //Leer todos los Usuarios
    
    $VInstEstatus=0;
    $Tabla_Institucion = new RegDatos();    
    if($SUsuaNivel==0) {$InstRegis = $Tabla_Institucion->Institucion_Obtener_Todos($VInstEstatus); }   //Leer todas las cedes    
    else { $InstRegis = $Tabla_Institucion->Institucion_Obtener_InstId($SInstId,$VInstEstatus);}   //Leer la cede del usuario    

    include_once (TEMPLATE_DIR."cabecera.php");
    
?>
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "scrollX": true
            "autoWidth": false
            var table = $('#dataTable').DataTable();
            table.columns.adjust().draw();
        });
    } );
</script>
<main>
    <div class="container-fluid">
        
        <div >
            <table style="width:100%" > 
                <thead>
                    <tr class="breadcrumb mb-2">
                        <th>
                            <ol class="breadcrumb mb-2">
                            <li class="breadcrumb-item">
                                <a href="Principal.php">Sistema de Control de Notas</a>
                            </li>
                            <li class="breadcrumb-item active">Registro de Usuarios </li>
                            </ol>
                        </th>
			            <th>
                            <a href="UsuariosReg.php"><img src="imagen/PersonaN.png" data-toggle="tooltip" data-placement="right" title="Nuevo Usuarios" width="35" height="35"></a>
                        </th>
                    </tr>
		</thead> 
            </table>
        </div>
	<div class="card mb-1">
            <div class="card-header"><i class="fas fa-table mr-1"></i>Tabla de Usuarios Registrados</div>
               <div class="card-body">
                    <div class="table-responsive"><font size=2>
                        <table class="table-striped table-bordered" id="dataTable" style="width:100%" >
                            <thead>
                                <tr>
                                    <th># </th>
                                    <?php if($SUsuaNivel==0){ ?>
                                        <th>Sede</th>
                                    <?php } ?>
                                    <th>Usuario Nombre</th>
                                    <th>Usuario Descripción</th>                                    
									<th>Nivel</th>
                                    <th></th>
                                    <th></th>
				                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th># </th>
                                    <?php if($SUsuaNivel==0){ ?>
                                        <th>Sede</th>
                                    <?php } ?>

                                    <th>Usuario Nombre</th>
                                    <th>Usuario Descripción</th>                                    
									<th>Nivel</th>
                                    <th></th>
                                    <th></th>
				                </tr>
                            </tfoot>
                            <tbody charset="utf8_unicode_ci">
                                <?php $Contador=0; foreach ($TodosUsuarios as $Usuarios) { $Contador=$Contador+1;?>
                                    <tr>
                                        <td><?php echo $Contador; ?></td>
                                        <?php if($SUsuaNivel==0){ ?>
                                            <td><?php echo  $Usuarios-> InstNomb; ?></td>
                                        <?php } ?>
                                        <td><?php echo  $Usuarios-> UsuaUser; ?></td>
                                        <td><?php echo  $Usuarios-> UsuaNomb; ?></td>
                                        <td><?php echo  $Usuarios-> NivelNomb; ?></td>  

                                        <td>
                                            <?php if($Usuarios-> UsuaEstatus==0){ ?>
                                                <a href="UsuariosMod.php?Id=<?php echo  $Usuarios-> UsuaId; ?> "><img src="imagen/REditar.png" data-toggle="tooltip" data-placement="left" title="Editar Datos del Usuario" ></a>
                                            <?php } ?>
                                        </td>

                                        <td><a href="UsuariosCambioStatus.php?Id=<?php echo  $Usuarios-> UsuaId; ?> ">
                                        <?php 
                                            switch ($Usuarios->UsuaEstatus )
                                            {
                                             case 0: echo '<img src="imagen/Habilitar0.png" data-toggle="tooltip" data-placement="right" title="Deshabilitar Usuario">'; break;
                                             case 1: echo '<img src="imagen/Habilitar1.png" data-toggle="tooltip" data-placement="right" title="Habilitar Usuario">'; break;
                                            }
                                        ?>
                                         </a> </td>

                                    </tr>
				                <?php } ?>
                            </tbody>
			</table>
                <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TId" name="TId" value="0"  disabled>
                <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TProceso" name="TProceso" value="Table"  disabled>
                    </font></div>
		</div>
            </div>
    </div>
</main>

<?php 
	include_once($_SERVER['DOCUMENT_ROOT'].'/Colegio/Directorios.php');
	include_once (TEMPLATE_DIR."pie.php");
 ?>