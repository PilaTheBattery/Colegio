
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
    $VGradEstatus=2;
    $GradRegis = $Tabla_Datos->Grado_Obtener_Todos($VGradEstatus);    
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
                                <li class="breadcrumb-item active">Registro de Grados </li>
                            <?php } ?>
                            </ol>
                        </th>
                        <?php if($SUsuaNivel<3){ ?>
                            <th>
                                <a href="GradosReg.php"><img src="imagen/BGradN.png" data-toggle="tooltip" data-placement="right" title="Crear Nuevo Grado" width="35" height="35"></a>
                            </th>
                        <?php } ?>
                    </tr>
		        </thead> 
            </table>
        </div>
	    <div class="card mb-1">
            <div class="card-header"><i class="fas fa-table mr-1"></i>Tabla de Grados Registrados</div>
            <div class="card-body">
                <div class="table-responsive"><font size=2>
                    <table class="table-striped table-bordered" id="dataTable" style="width:100%" >
                        <thead>
                            <tr>
                                <th># </th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                    <th></th>
                                    <th></th>
				                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th># </th>
                                    <th>Nombre</th>
                                    <th>Descripción</th  >
                                    <th></th>
                                    <th></th>
				                </tr>
                            </tfoot>
                            <tbody charset="utf8_unicode_ci" id ="TbodyTablaGrados">
                                <?php $Contador=0; foreach ($GradRegis as $Grados) { $Contador=$Contador+1; ?>
                                    <tr>
                                        <td><?php echo $Contador;  ?></td>
                                        <td><?php echo  $Grados-> GradNomb; ?></td>
                                        <td><?php echo  $Grados-> GradDesc; ?></td>                                        
                                        <td>
                                            <?php if(($Grados-> GradEstatus==0)&&(($SUsuaNivel==0)||($SInstId==$Grados-> InstId))){ ?>
                                                <a href="GradosMod.php?Id=<?php echo  $Grados-> GradId; ?> "><img src="imagen/REditar.png" data-toggle="tooltip" data-placement="left" title="Editar Grado" ></a></td>
                                            <?php } ?>
                                        <td>
                                           <?php if($SUsuaNivel<3){ ?>
                                            <a href="GradosCambioStatus.php?Id=<?php echo  $Grados-> GradId; ?> ">
                                                <?php 
                                                    switch ($Grados->GradEstatus )
                                                    {
                                                    case 0: echo '<img src="imagen/Habilitar0.png" data-toggle="tooltip" data-placement="right" title="Deshabilitar Grado">'; break;
                                                    case 1: echo '<img src="imagen/Habilitar1.png" data-toggle="tooltip" data-placement="right" title="Habilitar Grado">'; break;
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
                <select class="custom-select" id="TGradEstatus" name="TGradEstatus" >                                                                                 
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
        document.getElementById("TGradEstatus").onchange =VisualizarTabla;
    }
    function VisualizarTabla()
    { 
        VEstatus = document.getElementById('TGradEstatus').value;
        VUsuaNivel= document.getElementById('TUsuaNivel').value;
        VInstId= document.getElementById('TInstId').value;
        VConsulta="Consulta Todo";    //Leer todas las instituciones       
            
        var DatosI={};  
        DatosI.Proceso = VConsulta;         
        DatosI.Grupos ="Grado"; 
        DatosI.InstId =VInstId;         
        DatosI.GradEstatus =VEstatus;    
        
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
                    tabla+='<td >'+data[i].GradNomb+'</td>'; 
                    tabla+='<td >'+data[i].GradDesc+'</td>';                     
                    tabla+='<td >';
                        if((data[i].GradEstatus==0)&&((VUsuaNivel==0)||(VGradId==data[i].GradId)))
                        
                        {   tabla+='<a href="GradoMod.php?Id='+data[i].GradId+'"><img src="imagen/REditar.png" data-toggle="tooltip" data-placement="left" title="Editar Grado" ></a>'; }
                    tabla+='</td>';

                    tabla+='<td>';
                        if(VUsuaNivel==0)
                        { 
                            tabla+='<a href="GradosCambioStatus.php?Id='+data[i].GradId+' ">';

                            switch (data[i].GradEstatus) 
                            {
                                case '0': tabla+='<img src="imagen/Habilitar0.png" data-toggle="tooltip" data-placement="right" title="Deshabilitar Grado">';  break;
                                case '1': tabla+='<img src="imagen/Habilitar1.png" data-toggle="tooltip" data-placement="right" title="Habilitar Grado">'; break;                        
                            }                    
                            tabla+='</a>';
                        } 
                        tabla+='</td>';
                    tabla+='</tr>';
                    reg1+=1;
                }
                
                var edicion =document.getElementById("TbodyTablaGrados");
                edicion.innerHTML = tabla;
            }
        });
    }

    
</script>