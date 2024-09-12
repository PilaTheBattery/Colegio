

<?php 

	session_start();
	
	if(!isset($_SESSION['SUsuaId'])){
		header("Location: index.php");
	}
	
	$Sid = $_SESSION['SUsuaId'];
	$SUsuaId = $_SESSION['SUsuaId'];
    $SUsuaNombr = $_SESSION['SUsuaNombr'];
	$SUsuaNivel = $_SESSION['SUsuaNivel'];
	$SInstId = $_SESSION['SInstId'];
    $SAreaId = $_SESSION['SAreaId'];
    $STexto = $_SESSION['STexto'];
	$SFondo = $_SESSION['SFondo'];
    
	include_once($_SERVER['DOCUMENT_ROOT'].'/Mantenimiento/Template/inicio.php');
    include_once($_SERVER['DOCUMENT_ROOT'].'/Mantenimiento/Directorios.php');
    include_once (CSQL_DIR."MantenimientosRegBd.php");
	include_once (CSQL_DIR."InstitucionRegBd.php");
    include_once (CSQL_DIR."AreasRegBd.php");

    $VMantEstatus=4;
    $Tabla_Mantenimientos = new RMantenimientos();
    if($SUsuaNivel==0) { $TodosMantenimientos = $Tabla_Mantenimientos->Obtener_Mantenimientos_todo($VMantEstatus); }   //Leer todos los Mantenimientos    
    else { $TodosMantenimientos = $Tabla_Mantenimientos->Obtener_Mantenimientos_cede($SInstId,$VMantEstatus);} //Leer todos los Mantenimientos    
  
    $VInstEstatus=0;
    $Tabla_Institucion = new RInstitucion();    
    if($SUsuaNivel==0) {$InstRegis = $Tabla_Institucion->Obtener_Institucion_Todos($VInstEstatus); }   //Leer todas las cedes    
    else { $InstRegis = $Tabla_Institucion->Obtener_Institucion_Id($SInstId,$VInstEstatus);}   //Leer la cede del usuario    

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
                                <a href="Principal.php">Sistema de Control de Mantenimiento</a>
                            </li>                            
                                <li class="breadcrumb-item active">Registro de Solicitudes </li>                            
                            </ol>
                        </th>                        
                            <th>
                                <a href="SolicitudesReg.php"><img src="imagen/NSoli.png" data-toggle="tooltip" data-placement="right" title="Nueva Solicitus" width="35" height="35"></a>
                            </th>                        
                    </tr>    
		</thead> 
            </table>
        </div>
	<div class="card mb-1">
            <div class="card-header"><i class="fas fa-table mr-1"></i>Tabla de Solicitudes Registradas</div>
               <div class="card-body">
                    <div class="table-responsive"><font size=2>
                        <table class="table-striped table-bordered" id="dataTable" name="dataTable" style="width:100%" >
                            <thead>
                                <tr>
                                    <th># </th>
                                    <?php if($SUsuaNivel==0){ ?>
                                        <th>Sede</th>
                                    <?php } ?> 
                                    <th>Area</th>
                                    <th>No Solicitud</th>
                                    <th>Nombre Solicitante</th>
                                    <th>Fecha Creación</th>
                                    <th>Equipo</th>
                                    <th>Falla Reportada</th>
                                    <th>Estatus Solicitud</th>
                                    <th></th>
				                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                <th># </th>
                                    <?php if($SUsuaNivel==0){ ?>
                                        <th>Sede</th>
                                    <?php } ?> 
                                    <th>Area</th>
                                    <th>No Solicitud</th>
                                    <th>Nombre Solicitante</th>
                                    <th>Fecha Creación</th>
                                    <th>Equipo</th>
                                    <th>Falla Reportada</th>
                                    <th>Estatus Solicitud</th>                                    
                                    <th></th>
				                </tr>
                            </tfoot>
                            <tbody charset="utf8_unicode_ci" id ="TbodyTablaSol">
                                <?php  $Contador=0; foreach ($TodosMantenimientos as $Mantenimientos) { $Contador=$Contador+1; ?>
                                    <tr>
                                        <td>                                               
                                            <?php echo $Contador; ?>
                                        </td>
                                        <?php if($SUsuaNivel==0){ ?>
                                            <td><?php echo  $Mantenimientos-> InstNomb; ?></td>
                                        <?php } ?>
                                        <td><?php echo  $Mantenimientos-> AreaNomb; ?></td>
                                        <td><?php echo  $Mantenimientos-> MantId; ?></td>
                                        <td><?php echo  $Mantenimientos-> MantNombSoli; ?></td>
                                        <td><?php echo  $Mantenimientos-> MantFechSoli; ?></td>
                                        <td><?php echo  $Mantenimientos-> EquiCodi . "->". $Mantenimientos-> EquiDesc ; ?></td>
                                        <td><?php echo  $Mantenimientos-> MantFallRepo; ?></td>                                        
                                        <td>
                                        <?php 
                                        
                                        switch ($Mantenimientos-> MantEstatus) {
                                            case '0': ?><img src="imagen/E0.png" data-toggle="tooltip" data-placement="right" width="20" height="20"> <?php  echo "Creada";  break;
                                            case '1': ?><img src="imagen/E1.png" data-toggle="tooltip" data-placement="right" width="20" height="20"> <?php  echo "Procesando"; break;
                                            case '2': ?><img src="imagen/E2.png" data-toggle="tooltip" data-placement="right" width="20" height="20"> <?php  echo "Culminada"; break;
                                            case '3': ?><img src="imagen/E3.png" data-toggle="tooltip" data-placement="right" width="20" height="20"> <?php  echo "Deshabilitada"; break;
                                            default: break;
                                        }
                                        
                                        
                                        ?></td>  
                                        <td><a href="MantenimientoPlanilla.php?Id=<?php echo  $Mantenimientos-> MantId; ?> ">
                                             <img src="imagen/plan.png" data-toggle="tooltip" data-placement="right" title="Planilla" width="30" height="30">                                             
                                         </a> </td>
                                    </tr>
				                <?php } ?>
                            </tbody>
			</table>
                <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TId" name="TId" value="0"  disabled>
                <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TProceso" name="TProceso" value="Table"  disabled>
                <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TUsuaNivel" name="TUsuaNivel" value="<?php echo  $SUsuaNivel; ?>"  disabled>
                <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TInstId" name="TInstId" value="<?php echo  $SInstId; ?>"  disabled>
                    </font></div>
		</div>
        <div class="form-row">
            <div class="col-auto">
                <label  class="small mb-1" for="TMantEstatus">Solicitudes a Mostrar:</label>
            </div>
            <div class="col-auto">
                    <select class="custom-select" id="TMantEstatus" name="TMantEstatus" >                                                                                 
                        <option value="0" > Creada</option>
                        <option value="1" > Procesando</option>
                        <option value="2" > Culminada </option>
                        <option value="3" > Deshabilitada</option>
                        <option value="4" selected=""> Mostrar Todas </option>
                    </select>     
                </div>    
            </div>
        </div>
    </div>
</main>


<?php 
	include_once($_SERVER['DOCUMENT_ROOT'].'/Mantenimiento/Directorios.php');
	include_once (TEMPLATE_DIR."pie.php");
 ?>

 
<script>
$(document).ready(function() {

} );

window.onload = function()
{
    document.getElementById("TMantEstatus").onchange=MostrarSolicitudes;
}
function MostrarSolicitudes()
{ 
    Estatus = document.getElementById('TMantEstatus').value;
    VUsuaNivel= document.getElementById('TUsuaNivel').value;
    VInstId= document.getElementById('TInstId').value;
    VConsulta="";
    if(VUsuaNivel==0) { VConsulta="Consulta Todo"; }   //Leer todos los Mantenimientos    
    else { VConsulta="Consulta Cede";} //Leer todos los Mantenimientos    
    
    var DatosT={};  
    DatosT.Proceso = VConsulta; 
    DatosT.MantId = 0;
    DatosT.InstId = VInstId;
    DatosT.AreaId = 0;
    DatosT.EquiId = 0;    
    DatosT.UsuaId = 0;
    DatosT.MantNombSoli = "X";
    DatosT.MantFechSoli = "X";
    DatosT.MantFechInicServ = "X";
    DatosT.MantFallRepo = "X";
    DatosT.MantTipoServ = "X";
    DatosT.MantFallEnco = "X";
    DatosT.MantActiReal = "X";
    DatosT.MantRespUsad = "X";
    DatosT.MantEquiEsta = "X";
    DatosT.MantFechFinServ = "X";
    DatosT.TecnId = 0;
    DatosT.MantObse = "X";
    DatosT.MantEstatus= Estatus;
    Parameters_Mant= JSON.stringify(DatosT);
    $("#TbodyTablaSol").empty(); 
    $('#dataTable > tbody').empty();
	var tabla="";
	var reg1=1;
    $.ajax({    
        url:"CSQL/MantenimientosRegBd.php",
        type: "POST",
        dataType:"json",
        async:false,
        data:{
            Parameters_Mant:Parameters_Mant      
        },
        success: function(data){
            data = JSON.stringify(data).replace(/null/g, '""');  //pasa objeto a array y elimina null de los elementos
			data = JSON.parse(data); // pasa de array a objeto         
            //for(var i in data){reg1+=1;}
			//document.getElementById("TCReg").value=reg1;
			for(var i in data)
			{                                   
					tabla+='<tr>';
                    tabla+='<td>'+reg1+'</td>';
                     if(VUsuaNivel==0){                                            
					    tabla+='<td >'+data[i].InstNomb+'</td>';
                     }
					 tabla+='<td >'+data[i].AreaNomb+'</td>';
					 tabla+='<td >'+data[i].MantId+'</td>';
					 tabla+='<td >'+data[i].MantNombSoli+'</td>';
					 tabla+='<td >'+data[i].MantFechSoli+'</td>';
					 tabla+='<td >'+data[i].EquiCodi+ '->'+data[i].EquiDesc+'</td>';
					 tabla+='<td >'+data[i].MantFallRepo+'</td>';
					 tabla+='<td >';					
					 		
                     switch (data[i].MantEstatus) {
                        case '0': tabla+='<img src="imagen/E0.png" data-toggle="tooltip" data-placement="right" width="20" height="20"> Creada';  break;
                        case '1': tabla+='<img src="imagen/E1.png" data-toggle="tooltip" data-placement="right" width="20" height="20"> Procesando'; break;
                        case '2': tabla+='<img src="imagen/E2.png" data-toggle="tooltip" data-placement="right" width="20" height="20"> Culminada'; break;
                        case '3': tabla+='<img src="imagen/E3.png" data-toggle="tooltip" data-placement="right" width="20" height="20"> Deshabilitada'; break;
                        default: break;
                    }
                    tabla+='</td>';
                    tabla+='<td><a href="MantenimientoPlanilla.php?Id='+data[i].MantId+'>';
                    tabla+='<img src="imagen/plan.png" data-toggle="tooltip" data-placement="right" title="Planilla" width="30" height="30">';
                    tabla+='</a> </td>';

                    tabla+='</tr>';
					reg1+=1;
				}               
				
				//tabla+='<tr><td>&nbsp;</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>';
				var edicion =document.getElementById("TbodyTablaSol");
				edicion.innerHTML = tabla;
        }
    });
}
</script>