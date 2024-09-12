
function NuevoInstitucion()
{      
    document.getElementById("TProceso").value="Nuevo";
    LecturaDatosInstitucion(); // obtener datos del formulario Institucion json     
    EnviarJsonInstitucion();  
    history.go(-2);
    Location: reload();
}
async function ModificarInstitucion()
{    
    document.getElementById("TProceso").value="Modificar";
    DatosInstitucion(); // obtener datos del formulario Institucion json 
    EnviarJsonInstitucion();         
    history.go(-2);
   Location: reload();
}

async function EliminarInstitucion(VInstId)
{
    var mensaje;
    var opcion = confirm("Esta seguro de Querer eliminar la Institució");
    if (opcion == true) {
        document.getElementById("TInstId").value=VInstId;
        document.getElementById("TProceso").value="Eliminar";  // Proceso
        LecturaDatosInstitucion(); // obtener datos del formulario Institucion json 
        EnviarJsonInstitucion();
        mensaje = "Se ha Eliminado la Institucion OK";
    } else {
        mensaje = "Se Cancelo el proceso de eliminación";
    }
    alert(mensaje);
        
}

async function CambioEstatusInstitucion()
{    
    document.getElementById("TProceso").value="Cambiar Estatus";
    DatosInstitucion(); // obtener datos del formulario Institucion json 
    EnviarJsonInstitucion(); 
    window.history.back();
    history.go(-1);  
    //Location: reload();
}
function LecturaDatosInstitucion() {    
    LProceso = document.getElementById("TProceso").value;  // Proceso
    LInstId = document.getElementById("TInstId").value;      
    LInstNomb = document.getElementById("TInstNomb").value; 
    LInstDesc = document.getElementById("TInstDesc").value; 
    LEstaId = document.getElementById('TEstaId').value; 
    LMuniId = document.getElementById('TMuniId').value; 
    LParrId = document.getElementById('TParrId').value; 
    LInstDire= document.getElementById('TInstDire').value;   
    LInstCont= document.getElementById('TInstCont').value;    
    LInstEstatus= document.getElementById('TInstEstatus').value;       
}


function DatosInstitucion() {
    LecturaDatosInstitucion();
    var DatosI={};  
    DatosI.Proceso = LProceso; 
    DatosI.Grupos = "Institucion"; 
    DatosI.InstId = LInstId;
    DatosI.InstNomb = LInstNomb;
    DatosI.InstDesc = LInstDesc;
    DatosI.EstaId = LEstaId;
    DatosI.MuniId = LMuniId;
    DatosI.ParrId = LParrId;
    DatosI.InstDire= LInstDire;
    DatosI.InstCont= LInstCont;
    DatosI.InstEstatus= LInstEstatus;
    Parameters= JSON.stringify(DatosI);
}

function EnviarJsonInstitucion()
{
    DatosInstitucion();
   request =$.ajax({
    
        url:"CSQL/ColegioBd.php",
        type: "POST",
        dataType:"json",
        async:false,
        data:{
            Parameters:Parameters      
             },
             success: function(data){
                  if (data==1) {
                    alert("Proceso realizado Sastifactoriamente");
                    if (document.getElementById("TProceso").value==" ") {
                       document.getElementById('FormInstitucion').reset();
                       document.getElementById("TInstNomb").focus();
    -                   Deshabilitar(); 
                    }else 
                    {
                        history.go(-1);  ;
                    } 

                    
                  }  
                  else {
                    alert("Verificar Información Proceso No realizado");
                  }             
              }
    });
}   

window.onload = function()
{
  
    document.getElementById("TEstaId").onclick=F_MostrarTMunicipios;
    document.getElementById("TEstaId").onchange=F_MostrarTMunicipios;
  
    document.getElementById("TMuniId").onclick= F_MostrarParroquias;
    document.getElementById("TMuniId").onchange= F_MostrarParroquias;
  
    //document.getElementById("TParrId").onclick= F_Parroquias;
    //document.getElementById("TParrId").onchange= F_Parroquias; 
}

function F_MostrarTMunicipios() {
    $('#TMuniId').prop('disabled','');
    $('#TParrId').prop('disabled','false');
    //document.getElementById("TParroquias").value=0;
    var Datos={};
    Datos.Proceso = "Municipios";  
    Datos.Grupos = "Localidad";  
    Datos.IdL = document.getElementById('TEstaId').value;
    Parameters= JSON.stringify(Datos);
    var DMunicipios=""; 
    request =$.ajax({
        url:"CSQL/ColegioBd.php",
        type: "POST",
        dataType:"json",
        async:false,
        data:{
            Parameters:Parameters
             },
             success: function(data){
                data = JSON.stringify(data).replace(/null/g, '""');  //pasa objeto a array y elimina null de los elementos
                data = JSON.parse(data); // pasa de array a objeto
                
                DMunicipios+='<option value="0"  selected="">Seleccione.....</option>';
                for(var i in data)
                {
                    DMunicipios+='<option value="'+data[i].MuniId+'"  >'+data[i].MuniNomb+'</option>';
                }
                //console.log(DMunicipios);
                $('#TMuniId').html(DMunicipios);
                
                //var edicion =document.getElementById("TMunicipios");
                //edicion.innerHTML = DMunicipios;            
              }
    });
} 

function F_MostrarParroquias() {
    $('#TParrId').prop('disabled','');
    var Datos={};
    Datos.Proceso = "Parroquias";
    Datos.Grupos = "Localidad";    
    Datos.IdL = document.getElementById('TMuniId').value;
    Parameters= JSON.stringify(Datos);
    var DParroquias=""; 
    request =$.ajax({
        url:"CSQL/ColegioBd.php",
        type: "POST",
        dataType:"json",
        async:false,
        data:{
            Parameters:Parameters   
             },
             success: function(data){
                data = JSON.stringify(data).replace(/null/g, '""');  //pasa objeto a array y elimina null de los elementos
                data = JSON.parse(data); // pasa de array a objeto
                
                DParroquias+='<option value="0"  selected="">Seleccione..</option>';
                for(var i in data)
                {
                    DParroquias+='<option value="'+data[i].ParrId+'"  >'+data[i].ParrNomb+'</option>';
                }
                
                
                var edicion1 =document.getElementById("TParrId");
                edicion1.innerHTML = DParroquias;            
              }
    });
}


function CFechaActual()  //Obtencion fecha actual
{          
    var now = new Date();
    var Dia = ("0" + now.getDate()).slice(-2);
    var Mes = ("0" + (now.getMonth() + 1)).slice(-2);
    FechaActual = now.getFullYear()+"-"+(Mes)+"-"+(Dia) ;
}	

function CFechaActual()  //Obtencion fecha actual
{          
    var now = new Date();
    var Dia = ("0" + now.getDate()).slice(-2);
    var Mes = ("0" + (now.getMonth() + 1)).slice(-2);
    FechaActual = now.getFullYear()+"-"+(Mes)+"-"+(Dia) ;
}	

function Habilitar()  //Obtencion fecha actual
{          
    $('#TMuniId').prop('disabled','');
    $('#TParrId').prop('disabled','');
}	

function Deshabilitar()  //Obtencion fecha actual
{          
    $('#TMuniId').prop('disabled','false');
    $('#TParrId').prop('disabled','false');
}	