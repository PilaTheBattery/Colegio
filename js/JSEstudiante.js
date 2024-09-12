
function NuevoEstudiante()
{      
    document.getElementById("TProceso").value="Nuevo";
    LecturaDatosEstudiante(); // obtener datos del formulario Estudiante json     
    EnviarJsonEstudiante();      
    history.go(-2);
    Location: reload();
}
async function ModificarEstudiante()
{    
    document.getElementById("TProceso").value="Modificar";
    DatosEstudiante(); // obtener datos del formulario Estudiante json 
    EnviarJsonEstudiante();   
    history.go(-2);      
   Location: reload();
}

async function EliminarEstudiante(VEstuId)
{
    var mensaje;
    var opcion = confirm("Esta seguro de Querer eliminar El estudiante");
    if (opcion == true) {
        document.getElementById("TEstuId").value=VEstuId;
        document.getElementById("TProceso").value="Eliminar";  // Proceso
        LecturaDatosEstudiante(); // obtener datos del formulario Estudiante json 
        EnviarJsonEstudiante();
        mensaje = "Se ha Eliminado la Estudiante OK";
    } else {
        mensaje = "Se Cancelo el proceso de eliminación";
    }
    alert(mensaje);
        
}

async function CambioEstatusEstudiante()
{    
    document.getElementById("TProceso").value="Cambiar Estatus";
    DatosEstudiante(); // obtener datos del formulario Estudiante json 
    EnviarJsonEstudiante(); 
    window.history.back();
    history.go(-1);  
    //Location: reload();
}
function LecturaDatosEstudiante() {    
    LProceso = document.getElementById("TProceso").value;  // Proceso
    LEstuId = document.getElementById("TEstuId").value;      
    LInstId = document.getElementById("TInstId").value; 
    LEstuCedu = document.getElementById("TEstuCedu").value; 
    LEstuNomb = document.getElementById('TEstuNomb').value; 
    LEstuApel = document.getElementById('TEstuApel').value; 
    LEstuSexo = document.getElementById('TEstuSexo').value; 
    LEstuFechNaci= document.getElementById('TEstuFechNaci').value;   
    LEstuRepr= document.getElementById('TEstuRepr').value;    
    LEstuDesc= document.getElementById('TEstuDesc').value;       
    LEstuEstatus= document.getElementById('TEstuEstatus').value; 
}


function DatosEstudiante() {
    LecturaDatosEstudiante();
    var DatosI={};  
    DatosI.Proceso = LProceso; 
    DatosI.Grupos = "Estudiantes"; 
    DatosI.EstuId = LEstuId;
    DatosI.InstId = LInstId;
    DatosI.EstuCedu = LEstuCedu;
    DatosI.EstuNomb = LEstuNomb;
    DatosI.EstuApel = LEstuApel;
    DatosI.EstuSexo = LEstuSexo;
    DatosI.EstuFechNaci = LEstuFechNaci;
    DatosI.EstuRepr= LEstuRepr;
    DatosI.EstuDesc= LEstuDesc;
    DatosI.EstuEstatus= LEstuEstatus;
    Parameters= JSON.stringify(DatosI);
}

function EnviarJsonEstudiante()
{
    DatosEstudiante();
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
                    if (document.getElementById("TProceso").value=="Nuevo") {
                       document.getElementById('FormEstudiante').reset();
                       document.getElementById("TEstuCedu").focus();
                       Deshabilitar(); 
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
    document.getElementById("TEstuFechNaci").onchange=F_Edad;
      //document.getElementById("TParrId").onchange= F_Parroquias; 
}

function F_Edad()  //Obtencion fecha actual
{          
    LEstuFechNaci= document.getElementById('TEstuFechNaci').value;   
    Fedad=calcularEdad(LEstuFechNaci);
    document.getElementById('TEstuEdad').value= Fedad;

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

