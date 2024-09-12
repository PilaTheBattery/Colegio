<script src="js/JSUsuarios.js"></script>
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
    $idUsuario=$_GET['Id'];

    $Tabla_Niveles = new RegDatos();
    $TodosNiveles = $Tabla_Niveles->Niveles_Obtener_Todos(); //Leer todos los Usuarios
    
    $VInstEstatus=0;
    $Tabla_Institucion = new RegDatos();   
    if($SUsuaNivel==0) {$InstRegis = $Tabla_Institucion->Institucion_Obtener_Todos($VInstEstatus); }   //Leer todas las cedes    
    else { $InstRegis = $Tabla_Institucion->Institucion_Obtener_InstId($SInstId,$VInstEstatus);}   //Leer la cede del usuario    

     
    $Tabla_Usuarios_id = new RegDatos();
    $RUsuarioRegistrado = $Tabla_Usuarios_id->Usuario_Obtener_UsuaId($idUsuario); //Leer todos los Usuarios


    include_once (TEMPLATE_DIR."cabecera.php");    
?>
<main>
    <div class="container-fluid">
        <div >
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="Principal.php">Sistema Control de Notas</a></li>
                <?php if(($SUsuaNivel<2))
                { ?>  
                    <li class="breadcrumb-item"><a href="Usuarios.php">Listado de Usuarios</a></li>
                <?php }?>
                <li class="breadcrumb-item active">Modificar Datos del Usuario </li>
            </ol>
        </div>
        <div class="card mb-4">
            <div class="card-header"><i class="fas fa-table mr-2"></i>Datos del Usuario</div>
            <div class="card-body">
            <?php foreach ($RUsuarioRegistrado as $Usuario) { ?>
                <form id="FormUsuario" name="FormUsuario" enctype="multipart/form-data">

                    <table style="width:100%" >
                        <thead charset="utf8_unicode_ci">
                            <tr>
                                <th>
                                <div class="form-row">
                                <div class="col-md-2">
                                            <div class="form-group">                                            
                                                <label  class="small mb-1" for="TUsuaNivel">Institucion:</label>                                            
                                                
                                            </div>
                                        </div>          
                                <div class="col-md-10">
                                            <div class="form-group">                                            
                                                
                                                <select class="custom-select" id="TInstId" name="TInstId" disabled > // Instituciones
                                                    <option value="<?php echo $Usuario-> InstId; ?>" selected="" ><?php echo $Usuario-> InstNomb; ?> </option>                                                    
                                                </select>   
                                            </div>
                                        </div>  
                                                                        
                                    </div>   

                                    <div class="form-row">
                                    <div class="col-md-2">
                                            <div class="form-group">
                                                <label  class="small mb-1" for="TUsuaUser">Usuario:</label>                                       
                                                
                                            </div>
                                        </div>    
                                        <div class="col-md-10">
                                            <div class="form-group">                                                
                                                <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TUsuaUser" name="TUsuaUser" value="<?php echo $Usuario-> UsuaUser; ?>"   disabled>
                                            </div>
                                        </div>    
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label  class="small mb-1" for="TUsuaNomb">Nombre del Usuario:</label>                                                
                                            </div>    
                                        </div>    
                                        <div class="col-md-10">
                                            <div class="form-group">                                                
                                                <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TUsuaNomb" name="TUsuaNomb" value="<?php echo $Usuario-> UsuaNomb; ?>" disabled>                                        
                                            </div>    
                                        </div>    
									</div>
                                    </div>    
                                    
                                    <div class="form-row">
                                        <div class="col-md-2">
                                            <div class="form-group">                                            
                                                <label  class="small mb-1" for="TUsuaNivel">Nivel de Seguridad:</label>                                            
                                              
                                            </div>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="form-group">                                            
                                              
                                                <select class="custom-select" id="TUsuaNivel" name="TUsuaNivel" disabled >     
                                                    <option value="<?php echo $Usuario-> UsuaNivel; ?>"  selected=""><?php echo $Usuario-> NivelNomb; ?> </option>                                                
                                                </select>   
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label  class="small mb-1" for="TUsuaEstatus1">Status Actual:</label>                                                                                       
                                                <select class="custom-select" id="TUsuaEstatus1" name="TUsuaEstatus1" disabled>                                                         
                                                    <?php if( $Usuario-> UsuaEstatus=="0") {?>
                                                            <option value="0"   selected=""> Activa</option>
                                                    <?php }?>
                                                    <?php if( $Usuario-> UsuaEstatus=="1") {?>
                                                            <option value="1"   selected=""> Inactiva</option>
                                                    <?php }?>
                                                </select>                                                   
                                            </div>
                                        </div>    
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label  class="small mb-1" for="TUsuaEstatus">Nuevo Status:</label>
                                                <select class="custom-select" id="TUsuaEstatus" name="TUsuaEstatus" disabled>                                                         
                                                    <?php if( $Usuario-> UsuaEstatus=="1") {?>
                                                            <option value="0"   selected=""> Activa</option>
                                                    <?php }?>
                                                    <?php if( $Usuario-> UsuaEstatus=="0") {?>
                                                            <option value="1"   selected=""> Inactiva</option>
                                                    <?php }?>
                                                </select>     
                                            </div>    
                                        </div>    
									</div>
                                    <div class="form-row">
                                                                                                                   
                                    </div>                                                                    
                                </th>                                
                            </tr>
                        </thead>        
                        
                    </table>
                    
                                        
                    <div class="card-header" style="text-align: center;" >
                        <?php if( $Usuario-> UsuaEstatus=="0") {?>
                            <a href="#" onclick="CambioEstatusUsuario()" class="btn btn-danger" id="BGuardar" name="BGuardar" >Deshabilitar el Usuario</a>
                        <?php }?>
                        <?php if($Usuario-> UsuaEstatus=="1") {?>
                            <a href="#" onclick="CambioEstatusUsuario()" class="btn btn-success" id="BGuardar" name="BGuardar" >Habilitar el Usuario</a>
                        <?php }?>                        
                        
                    </div>  
                    
                    <div class="input-group mb-3">                     
                        <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TUsuaClave" name="TUsuaClave" value=""  disabled>                        
                        <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TUsuaClave1" name="TUsuaClave1" value=""  disabled>                        
                        <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TUsuaClave2" name="TUsuaClave2" value=""  disabled>                        
                        <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TChequeo" name="TChequeo" value=""  disabled>                        
                        <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TProceso" name="TProceso" value=" "  disabled>
                        <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TUsuaId" name="TUsuaId" value="<?php echo $Usuario-> UsuaId; ?>" disabled>
                    </div>
                </form>
                <?php } ?>
            </div>
        </div>
    </div>
</main>
<?php 
	include_once($_SERVER['DOCUMENT_ROOT'].'/Colegio/Directorios.php');
	include_once (TEMPLATE_DIR."pie.php");
 ?>                