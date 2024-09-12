<script src="js/JSGrado.js"></script>
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
            <div >
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="Principal.php">Sistema Control de Notas</a></li>
                    <li class="breadcrumb-item"><a href="GradosList.php">Listado de Grados Creados</a></li>
                    <li class="breadcrumb-item active">Nuevo Grado </li>
                </ol>
            </div>
            <form id="FormGrado" name="FormGrado" enctype="multipart/form-data">
               <!-- Grado Nombre -->
            <div class="form-group">
                <label for="TGradNomb">Grado Nombre</label>
                <input type="text" class="form-control" id="TGradNomb" name="TGradNomb">
            </div>

            <!-- Descripción -->
            <div class="form-group">
                <label for="TGradDesc">Descripción</label>
                <textarea class="form-control" id="TGradDesc" name="TGradDesc"> </textarea>
            </div>

            <!-- Ocultos -->            
            <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TProceso" name="TProceso" value=" "  >
            <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TGradId" name="TGradId" value=0  >
            <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TInstId" name="TInstId" value=<?php echo $SInstId; ?>  >
            <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TGradEstatus" name="TGradEstatus" value=0  >

            <!-- Botón de envío -->
            <div class="card-header" style="text-align: center;" >
                <a href="#" onclick="NuevoGrado()" class="btn btn-primary"  >Guardar Nuevo Registro</a>
            </div>
        </form>
    </div>
</main>

<?php 
	include_once($_SERVER['DOCUMENT_ROOT'].'/Colegio/Directorios.php');
	include_once (TEMPLATE_DIR."pie.php");
 ?>