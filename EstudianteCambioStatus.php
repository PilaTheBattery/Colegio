<script src="js/JSEstudiante.js"></script>
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
    
    include_once (CSQL_DIR."ColegioBd.php");
    $IdEstudiante=$_GET['Id'];

    $VUsuaEstatus=2;
    $Tabla_Usuarios = new RegDatos();
    if($SUsuaNivel==0) { $TodosUsuarios = $Tabla_Usuarios->Usuarios_Obtener_Todos($VUsuaEstatus); }  //Leer todos los Usuarios
    else { $TodosUsuarios = $Tabla_Usuarios->Usuarios_Obtener_InstId($SInstId,$VUsuaEstatus);} //Leer todos los Usuarios
    
    $VInstEstatus=0;
    $Tabla_Institucion = new RegDatos();    
    if($SUsuaNivel==0) {$InstRegis = $Tabla_Institucion->Institucion_Obtener_Todos($VInstEstatus); }   //Leer todas las cedes    
    else { $InstRegis = $Tabla_Institucion->Institucion_Obtener_InstId($SInstId,$VInstEstatus);}   //Leer la cede del usuario    
    $Tabla_Estudiante = new RegDatos();    
    $REstudianteRegistrado = $Tabla_Estudiante->Estudiante_Obtener_EstuId($IdEstudiante); //Leer todos los Institucions
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


            <?php foreach ($REstudianteRegistrado as $LEstudiante) { ?>
            <!-- Cédula, Nombres y Apellidos -->
            <div class="form-row">

                <div class="form-group col-md-4">
                    <label for="TEstuCedu">Cédula</label>
                    <input type="text" class="form-control" id="TEstuCedu" name="TEstuCedu" value="<?php echo $LEstudiante-> EstuCedu; ?>" disabled>
                </div>
                <div class="form-group col-md-4">
                    <label for="TEstuNomb">Nombres</label>
                    <input type="text" class="form-control" id="TEstuNomb" name="TEstuNomb" value="<?php echo $LEstudiante-> EstuNomb; ?>" disabled>
                </div>
                <div class="form-group col-md-4">
                    <label for="TEstuApel">Apellidos</label>
                    <input type="text" class="form-control" id="TEstuApel" name="TEstuApel" value="<?php echo $LEstudiante-> EstuApel; ?>"disabled>
                </div>
            </div>

            <!-- Sexo, Fecha de Nacimiento y Edad -->
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="TEstuSexo">Sexo</label>
                    <select class="custom-select" id="TEstuSexo" name="TEstuSexo" disabled> 
                        <option value="X"  >Seleccione..</option>      
                        <option value="M"  <?php if($LEstudiante-> EstuSexo== "M"){echo 'selected="selected"';}  ?> >Masculino</option> 
                        <option value="F"  <?php if($LEstudiante-> EstuSexo== "F"){echo 'selected="selected"';}  ?> >Femenino</option> 
                        <option value="O"  <?php if($LEstudiante-> EstuSexo== "O"){echo 'selected="selected"';}  ?>>Otro</option> 
                                                                      
                    </select> 
                </div>
                <div class="form-group col-md-4">
                    <label for="TEstuFechNaci">Fecha de Nacimiento</label>
                    <input type="date" class="form-control" id="TEstuFechNaci" name="TEstuFechNaci" value="<?php echo $LEstudiante-> EstuFechNaci; ?>" disabled>
                </div>
                <div class="form-group col-md-4">
                    <label for="TEstuEdad">Edad</label>
                    <input type="text" class="form-control" id="TEstuEdad" name="TEstuEdad" disabled>
                </div>
            </div>

            <!-- Representante -->
            <div class="form-group">
                <label for="TEstuRepr">Representante</label>
                <input type="text" class="form-control" id="TEstuRepr" name="TEstuRepr"  value="<?php echo $LEstudiante-> EstuRepr; ?>" disabled>
            </div>

            <!-- Descripción -->
            <div class="form-group">
                <label for="TEstuDesc">Descripción</label>
                <input type="text" class="form-control" id="TEstuDesc" name="TEstuDesc" value="<?php echo $LEstudiante-> EstuDesc; ?>" disabled>
            </div>
            <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TProceso" name="TProceso" value=""  >
            <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TEstuId" name="TEstuId" value="<?php echo $LEstudiante-> EstuId; ?>"  >
            <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TInstId" name="TInstId" value=<?php echo $SInstId; ?>  >            
            <!-- Botón de envío -->
            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label  class="small mb-1" for="EstuEstatus1">Status Actual:</label>
                        <select class="custom-select" id="EstuEstatus1" name="EstuEstatus1" disabled>                                                         
                            <?php if( $LEstudiante-> EstuEstatus=="0") {?>
                                <option value="0"   selected=""> Activa</option>
                            <?php }?>
                            <?php if( $LEstudiante-> EstuEstatus=="1") {?>
                                <option value="1"   selected=""> Inactiva</option>
                            <?php }?>
                        </select>                                                   
                   </div>
                </div>    
                <div class="col-md-6">
                    <div class="form-group">
                        <label  class="small mb-1" for="TEstuEstatus">Nuevo Status:</label>
                        <select class="custom-select" id="TEstuEstatus" name="TEstuEstatus" disabled>
                            <?php if( $LEstudiante-> EstuEstatus=="1") {?>
                                <option value="0"   selected=""> Activa</option>
                            <?php }?>
                            <?php if( $LEstudiante-> EstuEstatus=="0") {?>
                                <option value="1"   selected=""> Inactiva</option>
                            <?php }?>
                        </select>     
                    </div>    
                </div>    
            </div> 
        </form> 
        <div class="card-header" style="text-align: center;" >
            <?php if(( $LEstudiante-> EstuEstatus=="0")) {?>
                <a href="#" onclick="CambioEstatusEstudiante()" class="btn btn-danger"  >Deshabilitar Estudiante</a>
             <?php }?>
            <?php if( $LEstudiante-> EstuEstatus=="1") {?>
                <a href="#" onclick="CambioEstatusEstudiante()" class="btn btn-success"  >Habilitar Estudianteº</a>
            <?php }?>
                        
                        
        </div>  
   <?php    } ?>        
   
    </div>
</main>

<?php 
	include_once($_SERVER['DOCUMENT_ROOT'].'/Colegio/Directorios.php');
	include_once (TEMPLATE_DIR."pie.php");
 ?>