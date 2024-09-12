

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
                            <li class="breadcrumb-item active">Crear Periodo </li>
                            </ol>
                        </th>
			            <th>
                            <a href="UsuariosReg.php"><img src="imagen/PersonaN.png" data-toggle="tooltip" data-placement="right" title="Nuevo Usuarios" width="35" height="35"></a>
                        </th>
                    </tr>
		</thead> 
            </table>
            <form>
            <!-- Campo oculto para la ID de la institución -->
            <div class="form-group d-none">
                <label for="InstId" class="font-weight-bold">Institución</label>
                <input type="text" class="form-control" id="InstId" name="InstId">
            </div>

            <!-- Fechas de Inicio y Fin del Periodo -->
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="PeriFechInic">Periodo Fecha Inicio</label>
                    <input type="date" class="form-control" id="PeriFechInic" name="PeriFechInic">
                </div>
                <div class="form-group col-md-6">
                    <label for="PeriFechFina">Periodo Fecha Fin</label>
                    <input type="date" class="form-control" id="PeriFechFina" name="PeriFechFina">
                </div>
            </div>

            <!-- Estatus -->
            <div class="form-group">
                <label for="PeriEsta">Estatus</label>
                <input type="text" class="form-control" id="PeriEsta" name="PeriEsta">
            </div>

            <!-- Botón de envío -->
            <button type="submit" class="btn btn-primary">Registrar</button>
        </form>
    </div>
</main>

<?php 
	include_once($_SERVER['DOCUMENT_ROOT'].'/Colegio/Directorios.php');
	include_once (TEMPLATE_DIR."pie.php");
 ?>