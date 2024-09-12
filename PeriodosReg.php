
<script src="js/JSPeriodos.js"></script>
<?php 

session_start();
            
    if(!isset($_SESSION['SUsuaId'])){
        header("Location: index.php");
    }
    
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
                    <li class="breadcrumb-item"><a href="PeriodosList.php">Listado de Periodos Creados</a></li>
                    <li class="breadcrumb-item active">Nuevo Periodo </li>
                </ol>
            </div>
            <form id="FormPriodos" name="FormPriodos" enctype="multipart/form-data">
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="TPeriNomb">Nombre</label>
                    <input type="Text" class="form-control" id="TPeriNomb" name="TPeriNomb" >
                </div>
                
            </div>
            <!-- Fechas de Inicio y Fin del Periodo -->
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="TPeriFechInic">Periodo Fecha Inicio</label>
                    <input type="date" class="form-control" id="TPeriFechInic" name="TPeriFechInic">
                </div>
                <div class="form-group col-md-6">
                    <label for="TPeriFechFina">Periodo Fecha Fin</label>
                    <input type="date" class="form-control" id="TPeriFechFina" name="TPeriFechFina">
                </div>
            </div>
            <div class="form-row">                
                <div class="form-group col-md-12">
                    <label for="TPeriDesc">Descripción</label>
                    <textarea class="form-control" id="TPeriDesc" name="TPeriDesc"> </textarea>
                </div>
            </div>
            <!-- Ocultos -->
            
            <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TProceso" name="TProceso" value=" "  >  
            <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TPeriId" name="TPeriId" value=0  >
            <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TInstId" name="TInstId" value=<?php echo $SInstId; ?>  >
            <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TPeriEstatus" name="TPeriEstatus" value=0  >
            <!-- Botón de envío -->
            <div class="card-header" style="text-align: center;" >
                <a href="#" onclick="NuevoPeriodo()" class="btn btn-primary"  >Guardar Nuevo Registro</a>
            </div>  
        </form>
    </div>
</main>

<?php 
	include_once($_SERVER['DOCUMENT_ROOT'].'/Colegio/Directorios.php');
	include_once (TEMPLATE_DIR."pie.php");
 ?>