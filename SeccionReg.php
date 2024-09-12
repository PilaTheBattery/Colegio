<script src="js/JSSecciones.js"></script>

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
    $VPeriEstatus=0;
    $Tabla_Periodo = new RegDatos();    
    $PeriRegis = $Tabla_Periodo->Periodos_Obtener_InstId($SInstId,$VPeriEstatus);

    $Tabla_Datos = new RegDatos(); 
    $VSeccEstatus=0;
    $SeccRegis = $Tabla_Datos->Seccion_Obtener_Todos($VSeccEstatus);    

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
        <div >
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="Principal.php">Sistema Control de Notas</a></li>
                    <li class="breadcrumb-item"><a href="SeccionList.php">Listado de Secciones Creados</a></li>
                    <li class="breadcrumb-item active">Nueva Sección </li>
                </ol>
            </div>
            <form id="FormSeccion" name="FormSeccion" enctype="multipart/form-data">
            

            <!-- Grado ID y Periodo ID (Select) -->
            <div class="form-row">
            <div class="form-group col-md-6">
                    <label for="TPeriId">Periodo</label>
                    <select class="form-control" id="TPeriId" name="TPeriId">
                        <option value="">Seleccionar Periodo</option>
                        <?php  foreach ($PeriRegis as $LPeriodo) { ?>
                            <option value="<?php echo $LPeriodo-> PeriId; ?>"  ><?php echo $LPeriodo-> PeriNomb; ?> </option>
                        <?php } ?>
                        <!-- Opciones adicionales aquí -->
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="TGradId">Grado</label>
                    <select class="form-control" id="TGradId" name="TGradId" disabled> 
                        <option value="0"  selected="">Seleccione..</option>                           
                            
                        <!-- Opciones adicionales aquí -->
                    </select>
                </div>
                
            </div>
            <div class="form-row">
            <div class="form-group col-md-3">
                    <label for="TSeccNomb">Nombre</label>
                    <input type="text" class="form-control" id="TSeccNomb" name="TSeccNomb" disabled>
                </div>
                <!-- Descripción -->
                <div class="form-group col-md-9">
                    <label for="TSeccDesc">Descripción</label>
                    <input type="text" class="form-control" id="TSeccDesc" name="TSeccDesc" disabled>
                </div>
            </div>

            <!-- Cantidad Máxima y Cantidad Inscritos -->
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="TSeccCantMaxEstu">Cantidad Máxima</label>
                    <input type="number" class="form-control" id="TSeccCantMaxEstu" name="TSeccCantMaxEstu" disabled>
                </div>
                <div class="form-group col-md-6">
                    <label for="TSeccCantInsc">Cantidad Inscritos</label>
                    <input type="number" class="form-control" id="TSeccCantInsc" name="TSeccCantInsc" Value="0" disabled>
                </div>
            </div>

   
            <div class="card-header" style="text-align: center;" >
                <a href="#" onclick="NuevaSeccion()" class="btn btn-primary"  >Guardar Nuevo Registro</a>
            </div>  
                    
            <div class="input-group mb-3">                     
            <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TProceso" name="TProceso" value=" "  >  
            <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TSeccId" name="TSeccId" value=0  >
            <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TInstId" name="TInstId" value=<?php echo $SInstId; ?>  >
            <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TSeccEstatus" name="TSeccEstatus" value=0  >
                        
            </div>
        </form>
        <div class="card-header" style="text-align: center;" >
        <div class="table-responsive"><font size=2>
                    <table class="table table-bordered" id="dataTable" style="width:100%" >
                        <thead>
                            <tr>
                                <th># </th>
                                <th>Periodo</th>
                                <th>Grado</th>
                                <th>Seccion</th>
                                <th>Cant. Est. Max. </th>
                                <th>Cant. Est. Isc</th>
                                <th>Descripción</th>
                                <th></th>
                                <th></th>
				                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th># </th>
                                    <th>Periodo</th>
                                    <th>Grado</th>
                                    <th>Seccion</th>
                                    <th>Cant. Est. Max. </th>
                                    <th>Cant. Est. Isc</th>
                                    <th>Descripción</th>
                                    <th></th>
                                    <th></th>
				                </tr>
                            </tfoot>
                            <tbody charset="utf8_unicode_ci" id ="TbodyTablaSeccion">
                                <?php $Contador=0; foreach ($SeccRegis as $Seccion) { $Contador=$Contador+1; ?>
                                    <tr>
                                        <td><?php echo $Contador;  ?></td>
                                        <td><?php echo  $Seccion-> PeriNomb; ?></td>
                                        <td><?php echo  $Seccion-> GradNomb; ?></td>
                                        <td><?php echo  $Seccion-> SeccNomb; ?></td>
                                        <td><?php echo  $Seccion-> SeccCantMaxEstu; ?></td>
                                        <td><?php echo  $Seccion-> SeccCantInsc; ?></td>
                                        <td><?php echo  $Seccion-> SeccDesc; ?></td>
                                        <td> 
                                            <?php if(($Seccion-> SeccEstatus==0)&&(($SUsuaNivel==0)||($SInstId==$Seccion-> InstId))){ ?>
                                                <a href="SeccionMod.php?Id=<?php echo  $Seccion-> SeccId; ?> "><img src="imagen/REditar.png" data-toggle="tooltip" data-placement="left" title="Editar Sección" ></a></td>
                                            <?php } ?>        
                                        </td>                                        
                                        <td> 
                                            <?php if(($Seccion-> SeccCantInsc==0)){ ?>
                                                <a onclick="EliminarSeccion(<?php echo  $Seccion-> SeccId; ?>)" ><img src="imagen/Reliminar.png" data-toggle="tooltip" data-placement="left" title="Eliminar Sección" ></a>   
                                            <?php } ?>        
                                        </td>
                                    </tr>
				                <?php } ?>
                            </tbody>
			        </table>
            </div>  
    </div>
</main>

<?php 
	include_once($_SERVER['DOCUMENT_ROOT'].'/Colegio/Directorios.php');
	include_once (TEMPLATE_DIR."pie.php");
 ?>