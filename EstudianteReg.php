<script src="js/JSEstudiante.js"></script>
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

<main>
    <div class="container-fluid">
        
        <div > 
        <div class="container-fluid">
        <div >
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="Principal.php">Sistema Control de Notas</a></li>
                <li class="breadcrumb-item"><a href="EstudianteList.php">Listado de Estudiantes</a></li>
                <li class="breadcrumb-item active">Nuevo Estudiante </li>
            </ol>
        </div> 
            <form>
            <!-- Campo oculto para la ID del estudiante -->


           
            <!-- Cédula, Nombres y Apellidos -->
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="TEstuCedu">Cédula</label>
                    <input type="text" class="form-control" id="TEstuCedu" name="TEstuCedu">
                </div>
                <div class="form-group col-md-4">
                    <label for="TEstuNomb">Nombres</label>
                    <input type="text" class="form-control" id="TEstuNomb" name="TEstuNomb">
                </div>
                <div class="form-group col-md-4">
                    <label for="TEstuApel">Apellidos</label>
                    <input type="text" class="form-control" id="TEstuApel" name="TEstuApel">
                </div>
            </div>

            <!-- Sexo, Fecha de Nacimiento y Edad -->
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="TEstuSexo">Sexo</label>
                    <select class="custom-select" id="TEstuSexo" name="TEstuSexo" > 
                        <option value="X"  selected="">Seleccione..</option>      
                        <option value="M"  >Masculino</option> 
                        <option value="F"  >Femenino</option> 
                        <option value="O"  >Otro</option> 
                                                                      
                    </select> 
                </div>
                <div class="form-group col-md-4">
                    <label for="TEstuFechNaci">Fecha de Nacimiento</label>
                    <input type="date" class="form-control" id="TEstuFechNaci" name="TEstuFechNaci">
                </div>
                <div class="form-group col-md-4">
                    <label for="TEstuEdad">Edad</label>
                    <input type="text" class="form-control" id="TEstuEdad" name="TEstuEdad" disabled>
                </div>
            </div>

            <!-- Representante -->
            <div class="form-group">
                <label for="TEstuRepr">Representante</label>
                <input type="text" class="form-control" id="TEstuRepr" name="TEstuRepr">
            </div>

            <!-- Descripción -->
            <div class="form-group">
                <label for="TEstuDesc">Descripción</label>
                <textarea class="form-control" id="TEstuDesc" name="TEstuDesc"> </textarea>
            </div>
            <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TProceso" name="TProceso" value=" "  >
            <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TEstuId" name="TEstuId" value=0  >
            <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TInstId" name="TInstId" value=<?php echo $SInstId; ?>  >
            <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TEstuEstatus" name="TEstuEstatus" value=0  >
                    
            <!-- Botón de envío -->
            <div class="card-header" style="text-align: center;" >
            <a href="#" onclick="NuevoEstudiante()" class="btn btn-primary"  >Guardar Nuevo Registro</a>
                    </div> 
            
        </form> 
    </div>
</main>

<?php 
	include_once($_SERVER['DOCUMENT_ROOT'].'/Colegio/Directorios.php');
	include_once (TEMPLATE_DIR."pie.php");
 ?>