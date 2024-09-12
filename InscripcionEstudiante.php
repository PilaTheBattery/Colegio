

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
            <form>
            <!-- Campo oculto para la ID del estudiante -->
            <div class="form-group d-none">
                <label for="EstuId">ID Estudiante</label>
                <input type="hidden" class="form-control" id="EstuId" name="EstuId">
            </div>

            <!-- Institución -->
            <div class="form-group">
                <label for="InstId" class="font-weight-bold">Institución</label>
                <input type="hidden" class="form-control" id="InstId" name="InstId">
            </div>

            <!-- Cédula, Nombres y Apellidos -->
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="EstuCedu">Cédula</label>
                    <input type="text" class="form-control" id="EstuCedu" name="EstuCedu">
                </div>
                <div class="form-group col-md-4">
                    <label for="EstuNomb">Nombres</label>
                    <input type="text" class="form-control" id="EstuNomb" name="EstuNomb">
                </div>
                <div class="form-group col-md-4">
                    <label for="EstuApel">Apellidos</label>
                    <input type="text" class="form-control" id="EstuApel" name="EstuApel">
                </div>
            </div>

            <!-- Sexo, Fecha de Nacimiento y Edad -->
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="EstuSexo">Sexo</label>
                    <input type="text" class="form-control" id="EstuSexo" name="EstuSexo">
                </div>
                <div class="form-group col-md-4">
                    <label for="EstuFechNaci">Fecha de Nacimiento</label>
                    <input type="date" class="form-control" id="EstuFechNaci" name="EstuFechNaci">
                </div>
                <div class="form-group col-md-4">
                    <label for="EstuEdad">Edad</label>
                    <input type="text" class="form-control" id="EstuEdad" name="EstuEdad">
                </div>
            </div>

            <!-- Representante -->
            <div class="form-group">
                <label for="EstRepr">Representante</label>
                <input type="text" class="form-control" id="EstuRepr" name="EstuRepr">
            </div>

            <!-- Descripción -->
            <div class="form-group">
                <label for="EstuDesc">Descripción</label>
                <input type="text" class="form-control" id="EstuDesc" name="EstuDesc">
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