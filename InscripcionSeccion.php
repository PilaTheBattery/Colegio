

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
                            <li class="breadcrumb-item active">Crear Seccion </li>
                            </ol>
                        </th>
			            <th>
                            <a href="UsuariosReg.php"><img src="imagen/PersonaN.png" data-toggle="tooltip" data-placement="right" title="Nuevo Usuarios" width="35" height="35"></a>
                        </th>
                    </tr>
		</thead> 
            </table>
            <form>
            <!-- ID Sección (Hidden Label) -->
            <div class="form-group d-none">
                <label for="SeccionId" class="font-weight-bold">ID Sección</label>
                <input type="text" class="form-control" id="SeccionId" name="SeccionId">
            </div>

            <!-- Grado ID y Periodo ID (Select) -->
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="GradoId">Grado ID</label>
                    <select class="form-control" id="GradoId" name="GradoId">
                        <option value="">Seleccionar Grado</option>
                        <!-- Opciones adicionales aquí -->
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="PeriodoId">Periodo ID</label>
                    <select class="form-control" id="PeriodoId" name="PeriodoId">
                        <option value="">Seleccionar Periodo</option>
                        <!-- Opciones adicionales aquí -->
                    </select>
                </div>
            </div>

            <!-- Cantidad Máxima y Cantidad Inscritos -->
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="CantMax">Cantidad Máxima</label>
                    <input type="number" class="form-control" id="CantMax" name="CantMax">
                </div>
                <div class="form-group col-md-6">
                    <label for="CantInscritos">Cantidad Inscritos</label>
                    <input type="number" class="form-control" id="CantInscritos" name="CantInscritos">
                </div>
            </div>

            <!-- Descripción -->
            <div class="form-group">
                <label for="Descripcion">Descripción</label>
                <input type="text" class="form-control" id="Descripcion" name="Descripcion">
            </div>

            <!-- Estatus -->
            <div class="form-group">
                <label for="Estatus">Estatus</label>
                <input type="text" class="form-control" id="Estatus" name="Estatus">
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