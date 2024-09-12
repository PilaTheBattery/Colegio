
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
	
    $VInstEstatus=2;
    $Tabla_Datos = new RegDatos();    
    $InstRegis = $Tabla_Datos->Institucion_Obtener_Todos($VInstEstatus);    
    $VEstuEstatus=2;
    $EstuRegis = $Tabla_Datos->Estudiante_Obtener_Todos($VEstuEstatus);    
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
                                <a href="Principal.php">Sistema de Control de Colegio</a>
                            </li>
                            <?php if($SUsuaNivel<3){ ?>
                                <li class="breadcrumb-item active">Registro de Estudiantes </li>
                            <?php } ?>
                            </ol>
                        </th>
                        <?php if($SUsuaNivel<3){ ?>
                            <th>
                                <a href="EstudianteReg.php"><img src="imagen/BEstuN.png" data-toggle="tooltip" data-placement="right" title="Nueva Estudiante" width="35" height="35"></a>
                            </th>
                        <?php } ?>
                    </tr>
		        </thead> 
            </table>
        </div>
	    <div class="card mb-1">
            <div class="card-header"><i class="fas fa-table mr-1"></i>Tabla de Estudiantes Registrados</div>
            <div class="card-body">
                <div class="table-responsive"><font size=2>
                    <table class="table-striped table-bordered" id="dataTable" style="width:100%" >
                        <thead>
                            <tr>
                                <th># </th>
                                <th>Cedula</th>
                                <th>Apellidos, Nombres</th  >
                                <th>Sexo</th  >
                                <th>Fecha de Nacimiento</th>                                    
				    			<th>Edad</th>
                                <th>Representante</th>
                                    <th></th>
                                    <th></th>
				                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th># </th>                                    
                                    <th>Cedula</th>
                                    <th>Apellidos, Nombres</th  >
                                    <th>Sexo</th  >
                                    <th>Fecha de Nacimiento</th>                                    
                                    <th>Edad</th>
                                    <th>Representante</th>                                    
                                    <th></th>
                                    <th></th>
				                </tr>
                            </tfoot>
                            <tbody charset="utf8_unicode_ci" id ="TbodyTablaEstudiantes">
                                <?php $Contador=0; foreach ($EstuRegis as $Estudiantes) { $Contador=$Contador+1; ?>
                                    <tr>
                                        <td><?php echo $Contador;  ?></td>
                                        <td><?php echo  $Estudiantes-> EstuCedu; ?></td>
                                        <td><?php echo  $Estudiantes-> EstuApel . ", ". $Estudiantes-> EstuNomb; ?></td>
                                        <td><?php echo  $Estudiantes-> EstuSexo; ?></td>                                        
                                        <td><?php $f= new DateTime($Estudiantes-> EstuFechNaci); echo  $f->format('d/m/Y'); ?></td>
                                        <td>
                                            <?php 
                                                $tiempo = strtotime($Estudiantes-> EstuFechNaci); 
                                                $ahora = time(); 
                                                $edad = ($ahora-$tiempo)/(60*60*24*365.25); 
                                                $edad = floor($edad);
                                                $dia_actual = date("Y-m-d");
                                                $edad_diff = date_diff(date_create($Estudiantes-> EstuFechNaci), date_create($dia_actual));
                                                $Mes= $edad_diff->format('%m');
                                                echo $edad." Años, ".$Mes." Mes"; 
                                            ?>
                                            </td>
                                        <td><?php echo  $Estudiantes-> EstuRepr; ?></td>                            
                                        <td>
                                            <?php if(($Estudiantes-> EstuEstatus==0)&&(($SUsuaNivel==0)||($SInstId==$Estudiantes-> InstId))){ ?>
                                                <a href="EstudianteMod.php?Id=<?php echo  $Estudiantes-> InstId; ?> "><img src="imagen/REditar.png" data-toggle="tooltip" data-placement="left" title="Editar Estudiante" ></a></td>
                                            <?php } ?>
                                        <td>
                                           <?php if($SUsuaNivel<3){ ?>
                                            <a href="EstudianteCambioStatus.php?Id=<?php echo  $Estudiantes-> EstuId; ?> ">
                                                <?php 
                                                    switch ($Estudiantes->EstuEstatus )
                                                    {
                                                    case 0: echo '<img src="imagen/Habilitar0.png" data-toggle="tooltip" data-placement="right" title="Deshabilitar Estudiante">'; break;
                                                    case 1: echo '<img src="imagen/Habilitar1.png" data-toggle="tooltip" data-placement="right" title="Habilitar Estudiante">'; break;
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
                <label  class="small mb-1" for="TEstuEstatus">Estudiantes a Mostrar:</label>
            </div>
            <div class="col-auto">
                <select class="custom-select" id="TEstuEstatus" name="TEstuEstatus" >
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
        document.getElementById("TEstuEstatus").onchange =VisualizarTabla;
    }
    function VisualizarTabla()
    { 
        VEstatus = document.getElementById('TEstuEstatus').value;
        VUsuaNivel= document.getElementById('TUsuaNivel').value;
        VInstId= document.getElementById('TInstId').value;
        VConsulta="Consulta Todo";    //Leer todas las instituciones       
            
        var DatosI={};  
        DatosI.Proceso = VConsulta;         
        DatosI.Grupos ="Estudiantes"; 
        DatosI.InstId =VInstId; 
        DatosI.EstuEstatus =VEstatus;    
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
                    tabla+='<td >'+data[i].EstuCedu+'</td>'; 
                    tabla+='<td >'+data[i].EstuApel+', '+data[i].EstuNomb+'</td>'; 
                    tabla+='<td >'+data[i].EstuSexo+'</td>'; 
                    const nuevaFecha = new Date(data[i].EstuFechNaci).toLocaleDateString('en-US');
                    
                    tabla+='<td >'+nuevaFecha+'</td>';
                    LEstuFechNaci= data[i].EstuFechNaci;   
                    Fedad=calcularEdad(LEstuFechNaci);                    
                    tabla+='<td >'+Fedad+'</td>';                    
                    tabla+='<td >'+data[i].EstuRepr+'</td>';
                    tabla+='<td >';
                        if((data[i].EstuEstatus==0)&&((VUsuaNivel==0)||(VEstuId==data[i].EstuId)))
                        
                        {   tabla+='<a href="EstudianteMod.php?Id='+data[i].EstuId+'"><img src="imagen/REditar.png" data-toggle="tooltip" data-placement="left" title="Editar Estudiante" ></a>'; }
                    tabla+='</td>';

                    tabla+='<td>';
                        if(VUsuaNivel==0)
                        { 
                            tabla+='<a href="EstudianteCambioStatus.php?Id='+data[i].EstuId+' ">';

                            switch (data[i].EstuEstatus) 
                            {
                                case '0': tabla+='<img src="imagen/Habilitar0.png" data-toggle="tooltip" data-placement="right" title="Deshabilitar Estudiante">';  break;
                                case '1': tabla+='<img src="imagen/Habilitar1.png" data-toggle="tooltip" data-placement="right" title="Habilitar Estudiante">'; break;                        
                            }                    
                            tabla+='</a>';
                        } 
                        tabla+='</td>';
                    tabla+='</tr>';
                    reg1+=1;
                }
                
                var edicion =document.getElementById("TbodyTablaEstudiantes");
                edicion.innerHTML = tabla;
            }
        });
    }

    function calcularEdad(fecha) {
    // Si la fecha es correcta, calculamos la edad
    //console.log(fecha);
    if (typeof fecha != "string" && fecha && esNumero(fecha.getTime())) {
        fecha = formatDate(fecha, "yyyy-MM-dd");
    }

    var values = fecha.split("-");
    var dia = values[2];
    var mes = values[1];
    var ano = values[0];

    // cogemos los valores actuales
    var fecha_hoy = new Date();
    var ahora_ano = fecha_hoy.getYear();
    var ahora_mes = fecha_hoy.getMonth() + 1;
    var ahora_dia = fecha_hoy.getDate();

    // realizamos el calculo
    var edad = (ahora_ano + 1900) - ano;
    if (ahora_mes < mes) {   edad--;   }
    if ((mes == ahora_mes) && (ahora_dia < dia)) {    edad--;  }
    if (edad > 1900) {   edad -= 1900;  }

    // calculamos los meses
    var meses = 0;

    if (ahora_mes > mes && dia > ahora_dia)        meses = ahora_mes - mes - 1;
    else if (ahora_mes > mes)     meses = ahora_mes - mes
    if (ahora_mes < mes && dia < ahora_dia)        meses = 12 - (mes - ahora_mes);
    else if (ahora_mes < mes)      meses = 12 - (mes - ahora_mes + 1);
    if (ahora_mes == mes && dia > ahora_dia)        meses = 11;

    // calculamos los dias
    var dias = 0;
    if (ahora_dia > dia)      dias = ahora_dia - dia;
    if (ahora_dia < dia) {
        ultimoDiaMes = new Date(ahora_ano, ahora_mes - 1, 0);
        dias = ultimoDiaMes.getDate() - (dia - ahora_dia);
    }
    return edad + " años, " + meses + " meses ";
    //return edad + " años, " + meses + " meses y " + dias + " días";
}
</script>