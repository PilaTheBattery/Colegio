
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
	
    $VInstEstatus=2;
    $Tabla_Datos = new RegDatos();    
    $InstRegis = $Tabla_Datos->Institucion_Obtener_Todos($VInstEstatus);    
    $VSeccEstatus=2;
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
            <table style="width:100%" > 
                <thead>
                    <tr class="breadcrumb mb-2">
                        <th>
                            <ol class="breadcrumb mb-2">
                            <li class="breadcrumb-item">
                                <a href="Principal.php">Sistema de Control de Notas</a>
                            </li>
                            <?php if($SUsuaNivel<3){ ?>
                                <li class="breadcrumb-item active">Registro de Secciones </li>
                            <?php } ?>
                            </ol>
                        </th>
                        <?php if($SUsuaNivel<3){ ?>
                            <th>
                                <a href="SeccionReg.php"><img src="imagen/BSeccN.png" data-toggle="tooltip" data-placement="right" title="Crear Nueva Seccion" width="35" height="35"></a>
                            </th>
                        <?php } ?>
                    </tr>
		        </thead> 
            </table>
        </div>
	    <div class="card mb-1">
            <div class="card-header"><i class="fas fa-table mr-1"></i>Tabla de Secciones Registradas</div>
            <div class="card-body">
                <div class="table-responsive"><font size=2>
                    <table class="table-striped table-bordered" id="dataTable" style="width:100%" >
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
                                        <td>
                                           <?php if($SUsuaNivel<3){ ?>
                                            <a href="SeccionCambioStatus.php?Id=<?php echo  $Seccion-> SeccId; ?> ">
                                                <?php 
                                                    switch ($Seccion->SeccEstatus )
                                                    {
                                                    case 0: echo '<img src="imagen/Habilitar0.png" data-toggle="tooltip" data-placement="right" title="Deshabilitar Sección">'; break;
                                                    case 1: echo '<img src="imagen/Habilitar1.png" data-toggle="tooltip" data-placement="right" title="Habilitar Sección">'; break;
                                                    }
                                                ?>
                                            </a> 
                                            <?php } ?>
                                        </td>
                                    </tr>
				                <?php } ?>
                            </tbody>
			        </table>
                    
                    <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TProceso" name="TProceso" value="Table"  disabled>
                    <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TUsuaNivel" name="TUsuaNivel" value="<?php echo  $SUsuaNivel; ?>"  disabled>
                    <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TInstId" name="TInstId" value="<?php echo  $SInstId; ?>"  disabled>                    
                </font></div>                
		    </div>
        </div>
        <div class="form-row">
            <div class="col-auto">
                <label  class="small mb-1" for="TInstEstatus">Instituciones a Mostrar:</label>
            </div>
            <div class="col-auto">
                <select class="custom-select" id="TSeccEstatus" name="TSeccEstatus" >                                                                                 
                    <option value="0" > Activo</option>
                    <option value="1" > Inactivo</option>                        
                    <option value="2" selected=""> Mostrar Todas </option>
                </select>                         
            </div>
        </div>
    </div>
</main>

<?php 
	include_once($_SERVER['DOCUMENT_ROOT'].'/Colegio/Directorios.php');
	include_once (TEMPLATE_DIR."pie.php");
 ?>


<script>
    $(document).ready(function() {

    } );

    window.onload = function()
    {
        document.getElementById("TSeccEstatus").onchange =VisualizarTabla;
    }
    function VisualizarTabla()
    { 
        VEstatus = document.getElementById('TSeccEstatus').value;
        VUsuaNivel= document.getElementById('TUsuaNivel').value;
        VInstId= document.getElementById('TInstId').value;
        VConsulta="Consulta Todo";    //Leer todas las instituciones       
            
        var DatosI={};  
        DatosI.Proceso = VConsulta;         
        DatosI.Grupos ="Secco"; 
        DatosI.InstId =VInstId;         
        DatosI.SeccEstatus =VEstatus;    
        
        Parameters= JSON.stringify(DatosI);

        var tabla="";
        var reg1=1;
        $.ajax({    
            url:"CSQL/ColegioBd.php",
            type: "POST",
            dataType:"json",
            async:false,
            data:{  Parameters:Parameters },
            success: function(data)
            {
                data = JSON.stringify(data).replace(/null/g, '""');  //pasa objeto a array y elimina null de los elementos
                
                data = JSON.parse(data); // pasa de array a objeto         
                //for(var i in data){reg1+=1;}
                //document.getElementById("TCReg").value=reg1;
                for(var i in data)
                {              
                    tabla+='<tr>';
                    tabla+='<td>'+reg1+'</td>';                 
                    tabla+='<td >'+data[i].SeccNomb+'</td>'; 
                    tabla+='<td >'+data[i].SeccDesc+'</td>';                     
                    tabla+='<td >';
                        if((data[i].SeccEstatus==0)&&((VUsuaNivel==0)||(VSeccId==data[i].SeccId)))
                        
                        {   tabla+='<a href="SeccoMod.php?Id='+data[i].SeccId+'"><img src="imagen/REditar.png" data-toggle="tooltip" data-placement="left" title="Editar Secco" ></a>'; }
                    tabla+='</td>';

                    tabla+='<td>';
                        if(VUsuaNivel==0)
                        { 
                            tabla+='<a href="SeccionCambioStatus.php?Id='+data[i].SeccId+' ">';

                            switch (data[i].SeccEstatus) 
                            {
                                case '0': tabla+='<img src="imagen/Habilitar0.png" data-toggle="tooltip" data-placement="right" title="Deshabilitar Secco">';  break;
                                case '1': tabla+='<img src="imagen/Habilitar1.png" data-toggle="tooltip" data-placement="right" title="Habilitar Secco">'; break;                        
                            }                    
                            tabla+='</a>';
                        } 
                        tabla+='</td>';
                    tabla+='</tr>';
                    reg1+=1;
                }
                
                var edicion =document.getElementById("TbodyTablaSeccion");
                edicion.innerHTML = tabla;
            }
        });
    }

    
</script>