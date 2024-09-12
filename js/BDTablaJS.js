// funcion que se ejecuta al cargar la pagina 
// se le agrega los eventos a todo los objetos
//  onclick al hacer clic
//  onkeyup al presionar la tecla
//  onchange  al producirse un cambio
window.onload = function()
{
  document.getElementById("TEstados").onclick=F_MostrarTMunicipios;
  document.getElementById("TEstados").onchange=F_MostrarTMunicipios;

  document.getElementById("TMunicipios").onclick= F_MostrarParroquias;
  document.getElementById("TMunicipios").onchange= F_MostrarParroquias;


  document.getElementById("TParroquias").onclick= F_Parroquias;
  document.getElementById("TParroquias").onchange= F_Parroquias;

 document.getElementById("TEstFechaNacim").onchange=F_Edad;
 document.getElementById("TEstFechaNacim").onkeyup=F_Edad;
 document.getElementById("TEstFechaNacim").onclick=F_Edad;

 CFechaActual();  // ejecuta la funcion que optiene la fecha actual del sistema
 //document.getElementById("TEstFechaNacim").value=FechaActual ;
  document.getElementById("TEdad").value=calcularEdadAM(document.getElementById("TEstFechaNacim").value); //Cacular edad y la muestra

}

// este archivo se actualiza segun la tabla con que se va a trabajar en este caso esta disenado con la tabla estudiante
function UpdateDisplay()
{
    //permite visualizar la foto o la imagen  
    var inputelem = document.getElementById("TEstId").value;
    //window.alert(inputelem);
    if (inputelem!="") {
        document.getElementById("Fot").src="Fotos/"+inputelem+".jpg";
    }
    else
    {
        document.getElementById("Fot").src="Fotos/0000.jpg";
    }
   
}
//Se ejecuta el proceso de envio de datos a el servidor con el proceso nuevo
function NuevoEstudiante()
{  
    document.getElementById("TProceso").value="Nuevo"; //se ejhecuta cuando el proceso enviado es nuevo
    LecturaDatosEstudiates(); // obtener datos del formulario Estudiante en formato json 
    EnviarJsonEstudiante();  // llama al proceso de envio al servidor de los datos convertido en Json
}
//Se ejecuta el proceso de envio de datos a el servidor con el proceso nuevo
async function ModificarEstudiante()
{
    document.getElementById("TProceso").value="Modificar";
    LecturaDatosEstudiates(); // obtener datos del formulario Estudiante en formato json 
    EnviarJsonEstudiante();  // llama al proceso de envio al servidor de los datos convertido en Json
    window.history.back();  // Resetea o actualiza la pagina
}

// ejecuta el proceso de eliminacion del registro que coincida con el campo clave o identificador
async function EliminarEstudiante(VEstId)
{
    var mensaje;
    var opcion = confirm("Esta seguro de Querer eliminar el Estudiante");  // da mensaje de confirmacion de eliminacion
    if (opcion == true) {    // se ejecuta la eliminacion al seleccionar si
        document.getElementById("TEstId").value=VEstId;
        document.getElementById("TProceso").value="Eliminar";  // Proceso
        LecturaDatosEstudiates(); // obtener datos del formulario Estudiante en formato json 
        EnviarJsonEstudiante();  // llama al proceso de envio al servidor de los datos convertido en Json
        mensaje = "Se ha Eliminado el Estudiante OK";
    } else {  // no se ejecuta la eliminacion al seleccionar no
        mensaje = "Se Cancelo el proceso de eliminación";
    }
    alert(mensaje);  // se visualiza el mensaje segun la opcion
        
}

// lectura de los datos del formularios nesesarios que coincciden con la tabla a trabajar y lo guarda en formato json
function LecturaDatosEstudiates() {
    var Datos={};  //crea un registro o vector de datos
    Datos.Proceso = document.getElementById("TProceso").value;  // Indica el tipo de Proceso
    //son todos los datos del formularios que coincide con la tabla
    Datos.EstId = document.getElementById("TEstId").value;      //Id del Estudiante
    Datos.EstNacio = document.getElementById("TEstNacio").value; // Nacionalidad
    Datos.EstCedul = document.getElementById("TEstCedul").value; //Cedula
    Datos.EstApellNombr = document.getElementById('TEstApellNombr').value; // Nombre y apellidos
    Datos.Id_Parroquia = document.getElementById('TId_Parroquia').value; // Id Parroquia
    Datos.EstDirec = document.getElementById('TEstDirec').value; // direccion de trabajo
    Datos.EstSexo= document.getElementById('TEstSexo').value;  // Sexo
    Datos.EstFechaNacim= document.getElementById('TEstFechaNacim').value;  // Fecha nacimiento
    Datos.EstTelef = document.getElementById('TEstTelef').value;   // Telefono
    Datos.EstCorre = document.getElementById('TEstCorre').value;    // Coreo
    Datos.EstEstat = document.getElementById('TEstEstat').value; // Estatus
    Parameters= JSON.stringify(Datos);  // convierte el registro en Json
    
}

// funcion de envio de la cadena Json al Servidor de datos
function EnviarJsonEstudiante()
{
   request =$.ajax({
        url:"CSQL/EstudiantesRegBd.php",  //archivo resceptor de los datos en el servidor para procesarlo
        type: "POST",
        dataType:"json",
        async:false,
        data:{
                Parameters:Parameters      
             },
             success: function(data){
                  if (data==1) {  // se ejecuta si se almaceno el registro de forma positiva
                    alert("Proceso realizado Sastifactoriamente");
                    if (document.getElementById("TProceso").value=="Nuevo") {
                       document.getElementById('FormEstudiante').reset();
                       document.getElementById("TEstId").focus(); 
                    }
                    
                  }  
                  else {
                    alert("Verificar Informacion Proceso No realizado");
                  }             
              }
    });
}   


// permite enviar al servidor una solicitud de consulta de los municipios perteneciente al estado seleccionado
function F_MostrarTMunicipios() {
    $('#TMunicipios').prop('disabled','');
    $('#TParroquias').prop('disabled','false');
    //document.getElementById("TParroquias").value=0;
    var Datos={};
    Datos.Proceso = "Municipios";     // define la tabla a consultar
    Datos.IdL = document.getElementById('TEstados').value; // indica el codigo id del estado
    Parameters= JSON.stringify(Datos);
    var DMunicipios=""; 
    request =$.ajax({
        url:"CSQL/LocalidadRegBd.php",    //define del archivo en el servidor que recibe los datos
        type: "POST",
        dataType:"json",
        async:false,
        data:{
                Parameters:Parameters   
             },
             success: function(data){
                data = JSON.stringify(data).replace(/null/g, '""');  //pasa objeto a array y elimina null de los elementos
                data = JSON.parse(data); // pasa de array a objeto
                //los resultados de la consulta lo convierte en una cadena html de tipo select
                DMunicipios+='<option value="0"  selected="">Seleccione..</option>';
                for(var i in data)
                {
                    DMunicipios+='<option value="'+data[i].Id_Municipio+'"  >'+data[i].NombMuni+'</option>';
                }
                $('#TMunicipios').html(DMunicipios);  // actualiza el select municipio con la nueva cadena de los datos
                
                //var edicion =document.getElementById("TMunicipios");
                //edicion.innerHTML = DMunicipios;            
              }
    });
}

// permite enviar al servidor una solicitud de consulta de las parroquias perteneciente al municipio seleccionado
function F_MostrarParroquias() {
    $('#TParroquias').prop('disabled','');
    var Datos={};
    Datos.Proceso = "Parroquias";  // define la tabla a consultar
    Datos.IdL = document.getElementById('TMunicipios').value; // indica el codigo id del municipio
    Parameters= JSON.stringify(Datos);
    var DParroquias=""; 
    request =$.ajax({
        url:"CSQL/LocalidadRegBd.php", //define del archivo en el servidor que recibe los datos
        type: "POST",
        dataType:"json",
        async:false,
        data:{
                Parameters:Parameters   
             },
             success: function(data){
                data = JSON.stringify(data).replace(/null/g, '""');  //pasa objeto a array y elimina null de los elementos
                data = JSON.parse(data); // pasa de array a objeto
                //los resultados de la consulta lo convierte en una cadena html de tipo select
                DParroquias+='<option value="0"  selected="">Seleccione..</option>';  
                for(var i in data)
                {
                    DParroquias+='<option value="'+data[i].Id_Parroquia+'"  >'+data[i].NombParr+'</option>';
                }
                                
                var edicion1 =document.getElementById("TParroquias"); 
                edicion1.innerHTML = DParroquias;   // actualiza el select PArroquia con la nueva cadena de los datos         
              }
    });
}

function F_Parroquias() {
    
    //Cacular edad
   document.getElementById("TId_Parroquia").value=document.getElementById("TParroquias").value;
   
}



//Funcion de Obtencion fecha actual del sistema
function CFechaActual()  
{          
    var now = new Date();
    var Dia = ("0" + now.getDate()).slice(-2);
    var Mes = ("0" + (now.getMonth() + 1)).slice(-2);
    FechaActual = now.getFullYear()+"-"+(Mes)+"-"+(Dia) ;
}	

// envia solicitud del calculo de la edad aswgun la fecha de nacimiento y lo muestra
function F_Edad() {
    
     //Cacular edad
    document.getElementById("TEdad").value=calcularEdadAM(document.getElementById("TEstFechaNacim").value);
    
}
// funcion que calcula la edad eb años
function calcularEdadA(fecha) {
    var hoy = new Date();
    var cumpleanos = new Date(fecha);
    var edad = hoy.getFullYear() - cumpleanos.getFullYear();
    var m = hoy.getMonth() - cumpleanos.getMonth();

    if (m < 0 || (m === 0 && hoy.getDate() < cumpleanos.getDate())) {
        edad--;
    }

    return edad;
}

// funcion que calcula la edad eb años y mes
function calcularEdadAM(fecha) {
    // Si la fecha es correcta, calculamos la edad

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
    if (ahora_mes < mes) {
        edad--;
    }
    if ((mes == ahora_mes) && (ahora_dia < dia)) {
        edad--;
    }
    if (edad > 1900) {
        edad -= 1900;
    }

    // calculamos los meses
    var meses = 0;

    if (ahora_mes > mes && dia > ahora_dia)
        meses = ahora_mes - mes - 1;
    else if (ahora_mes > mes)
        meses = ahora_mes - mes
    if (ahora_mes < mes && dia < ahora_dia)
        meses = 12 - (mes - ahora_mes);
    else if (ahora_mes < mes)
        meses = 12 - (mes - ahora_mes + 1);
    if (ahora_mes == mes && dia > ahora_dia)
        meses = 11;

    // calculamos los dias
    var dias = 0;
    if (ahora_dia > dia)
        dias = ahora_dia - dia;
    if (ahora_dia < dia) {
        ultimoDiaMes = new Date(ahora_ano, ahora_mes - 1, 0);
        dias = ultimoDiaMes.getDate() - (dia - ahora_dia);
    }

    return edad + " años, y " + meses + " meses ";
}