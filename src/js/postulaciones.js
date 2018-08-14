
 M.AutoInit();



$(document).ready(function () {



//Esta Función Genera el Número del Post
function postNumberPost(str){
    var result;
    var dateString = "";
    var newDate = new Date();

    str=str.substring(0,2);
    dateString += newDate.getFullYear();
    dateString += (newDate.getMonth() + 1);
    dateString += newDate.getDate();
    dateString += newDate.getMinutes();
    dateString += newDate.getSeconds();
    dateString += newDate.getMilliseconds();

    result= 'P'+str+dateString;

    return result;
}

    $("form#selectionForm").submit(function(e){
         e.preventDefault();
         var chkArray = [];
         /* look for all checkboes that have a parent id  attached to it and check if it was checked */
          $("#retail input:checked").each(function() {
            chkArray.push({nun : $(this).data("index"),"nom": $(this).next("span").text(),"cat":"retail"});
          });
          $("#administrativo input:checked").each(function() {
               chkArray.push({nun : $(this).data("index"),"nom": $(this).next("span").text(),"cat":"Administrativo"});
          });
          $("#industrial input:checked").each(function() {
               chkArray.push({nun : $(this).data("index"),"nom": $(this).next("span").text(),"cat":"Industrial"});
          });
          $("#otros input:checked").each(function() {
            chkArray.push({nun : $(this).data("index"),"nom": $(this).next("span").text(),"cat":"Otros"});
          });
          
          /* we join the array separated by the comma */
          var selected;
          selected = chkArray.join(' , ') ;
          
          /* check if there is selected checkboxes, by default the length is 1 as it contains one single comma */
          if(selected.length== 0){
              notie.alert({ type: 3, text: 'Selecciona al menos 1 cargo.', position: 'bottom' });

              return false;
          }

          var JSONData={};
          var pid = postNumberPost("test");
            $.ajax({
                        url : "processform.php",
                        type: "post",
                        data:{ action:"firstpagedata",data:chkArray,pid:pid},
                        success:function(data){
                                window.location.href="proceso.php";
                                return false
                        },
                        error:function(){

                        }

            })
        return false;
    })
    $("form#procesoform").submit(function(e){
      e.preventDefault();
          var chkArray = [];
          /* look for all checkboes that have a parent id  attached to it and check if it was checked */
          if($.trim($("#tipo_doc").val()) == "rut") {
            if($.trim($("#rut").val()) != "" ){
                chkArray.push( {"rut" : $("#rut").val()} );
                $('#rut').css('border-color' , '#f2f2f2');
            }else{
                notie.alert({ type: 3, text: 'Debes ingresar rut', position: 'bottom' });
                $('#rut').css('border-color' , 'red');
                return false;
            }
          } else {
            if($.trim($("#pasaporte").val()) != "" ){
                chkArray.push( {"pasaporte" : $("#pasaporte").val()} );
                $('#pasaporte').css('border-color' , '#f2f2f2');
            }else{
                notie.alert({ type: 3, text: 'Debes ingresar pasaporte', position: 'bottom' });
                $('#pasaporte').css('border-color' , 'red');
                return false;
            }
          }
          if($.trim($("#first_name").val()) != "" ){
            chkArray.push( {"noms" : $("#first_name").val()} );
              $('#first_name').css('border-color' , '#f2f2f2');
          }else{
              notie.alert({ type: 3, text: 'Debes ingresar tu nombre', position: 'bottom' });
              $('#first_name').css('border-color' , 'red');
              return false;
          }
          if($.trim($("#last_name").val()) != "" ){
            chkArray.push( {"apeP" : $("#last_name").val()} );
              $('#last_name').css('border-color' , '#f2f2f2');
          }else{
              notie.alert({ type: 3, text: 'Debes ingresar tu apellido', position: 'bottom' });
              $('#last_name').css('border-color' , 'red');
              return false;
          }
          if($.trim($("#last_name_2").val()) != "" ){
            chkArray.push( {"apeM" : $("#last_name_2").val()} );
              $('#last_name_2').css('border-color' , '#f2f2f2');
          }else{
              notie.alert({ type: 3, text: 'Debes ingresar tu apellido materno', position: 'bottom' });
              $('#last_name_2').css('border-color' , 'red');
              return false;
          }
          if($.trim($("#txtDate").val()) != "" ){
            chkArray.push( {"fNaci" : $("#txtDate").val() } );
              $('#txtDate').css('border-color' , '#f2f2f2');
          }else{
              notie.alert({ type: 3, text: 'Debes ingresar tu fecha de nacimiento', position: 'bottom' });
              $('#txtDate').css('border-color' , 'red');
              return false;
          }
          if($.trim($("#sexo").val()) != "" ){
            chkArray.push( {"sexo" : $("#sexo").val()} );
              $('#sexo').css('border-color' , '#f2f2f2');
          }else{
              notie.alert({ type: 3, text: 'Debes ingresar tu sexo', position: 'bottom' });
              $('#sexo').css('border-color' , 'red');
              return false;
          }
          if($.trim($("#estado_civil").val()) != "" ){
            chkArray.push( {"eCivil" : $("#estado_civil").val()} );
              $('#estado_civil').css('border-color' , '#f2f2f2');
          }
          else{
              notie.alert({ type: 3, text: 'Debes ingresar tu estado civil', position: 'bottom' });
              $('#estado_civil').css('border-color' , 'red');
              return false;
          }
          if($.trim($("#nacionalidad").val()) != "" ){
            chkArray.push( {"nacionalidad" : $("#nacionalidad").val()} );
              $('#nacionalidad').css('border-color' , '#f2f2f2');
          }else{
              notie.alert({ type: 3, text: 'Debes ingresar tu nacionalidad', position: 'bottom' });
              $('#nacionalidad').css('border-color' , 'red');
              return false;
          }
          if($.trim($("#telefono").val()) != "" ){
            chkArray.push( {"telefono" : $("#telefono").val()} );
              $('#telefono').css('border-color' , '#f2f2f2');
          }else{
              notie.alert({ type: 3, text: 'Debes ingresar tu numero de teléfono', position: 'bottom' });
              $('#telefono').css('border-color' , 'red');
              return false;
          }
          if($.trim($("#telefono2").val()) != "" ){
            chkArray.push( {"telRec" : $("#telefono2").val()} );
          }
          if($.trim($("#email").val()) != "" ){
            chkArray.push( {"email" : $("#email").val()} );
              $('#email').css('border-color' , '#f2f2f2');
          }else{
              notie.alert({ type: 3, text: 'Debes ingresar tu email', position: 'bottom' });
              $('#email').css('border-color' , 'red');
              return false;
          }
          if($.trim($("#region").val()) != "" ){
            chkArray.push( {"provi" : $("#region").val()} );
              $('#region').css('border-color' , '#f2f2f2');
          }
          else{
              notie.alert({ type: 3, text: 'Debes ingresar tu región', position: 'bottom' });
              $('#region').css('border-color' , 'red');
              return false;
          }
          if($.trim($("#comuna").val()) != "" ){
            chkArray.push( {"comuna" : $("#comuna").val()} );
              $('#comuna').css('border-color' , '#f2f2f2');
          }else{
              notie.alert({ type: 3, text: 'Debes ingresar tu comuna', position: 'bottom' });
              $('#comuna').css('border-color' , 'red');
              return false;
          }
          if($.trim($("#direccion").val()) != "" ){
            chkArray.push( {"direccion" : $("#direccion").val()} );
              $('#direccion').css('border-color' , '#f2f2f2');
          }else{
              notie.alert({ type: 3, text: 'Debes ingresar tu dirección', position: 'bottom' });
              $('#direccion').css('border-color' , 'red');
              return false;
          }

          /* we join the array separated by the comma */
          var selected;
          selected = chkArray.join(' , ') ;
          
          /* check if there is selected checkboxes, by default the length is 1 as it contains one single comma */
          if(selected.length == 0){
              notie.alert({ type: 3, text: 'Error.', position: 'bottom' })

              return false;
          }

          var JSONData={};
               
               $.ajax({
                         url : "processform.php",
                         type:"post",
                         data:{ action:"secondpagedata",data:chkArray},
                         success:function(data){
                                 window.location.href="proceso2.php";
                                 return false
                         },
                         error:function(){

                         }

               })
      return false;
    })
    $("form#proceso2form").submit(function(e){
      e.preventDefault();
          var chkArray = [];
          /* look for all checkboes that have a parent id  attached to it and check if it was checked */
          if($.trim($("#tipoEstudio").val()) != "" ){
            chkArray.push( {"tipoEstudio" : $("#tipoEstudio").val()} );
              $('#tipoEstudio').css('border-color' , '#f2f2f2');
          }else{
              notie.alert({ type: 3, text: 'Debes ingresar tipo de estudios', position: 'bottom' });
              $('#tipoEstudio').css('border-color' , 'red');
              return false;
          }
          if($('#tipoEstudio').val() !== "Media"){
              if($.trim($("#carrera").val()) != "" ){
                  chkArray.push( {"titulo" : $("#carrera").val()} );
                  $('#carrera').css('border-color' , '#f2f2f2');
              }else{
                 notie.alert({ type: 3, text: 'Debes ingresar Titulo de la carrera', position: 'bottom' });
                  $('#carrera').css('border-color' , 'red');
                  return false;
              }
          }
          if($.trim($("#estado_estudio").val()) == "Graduado" ){
              if($.trim($("#txtDate2ftitulacion").val()) != "" ){
                  chkArray.push( {"fecha_titulacion" : $("#txtDate2ftitulacion").val()} );
              }else{
                  notie.alert({ type: 3, text: 'Debes ingresar fecha de titulación', position: 'bottom' });
                  return false;
                }
          }

          if($.trim($("#estado_estudio").val()) != "" ){
            chkArray.push( {"estado_estudio" : $("#estado_estudio").val()} );
          }
          if($.trim($("#fechaEstudio").val()) != "" ){
            chkArray.push( {"fechaEstudio" : $("#fechaEstudio").val()} );
          }
          if($.trim($("#semestres").val()) != "" ){
            chkArray.push( {"semestres" : $("#semestres").val()} );
          }
          if($.trim($("#licencia").val()) != "" ){
            chkArray.push( {"licencia" : $("#licencia").val()} );
          }
          
          var chkArray2 = [];
          if($.trim($("#curso").val()) != "" ){
            chkArray2.push( {"nombre" : $("#curso").val(), "fecha" : $("#txtDate3").val()} );
          }
          if($.trim($("#curso2").val()) != "" ){
            chkArray2.push( {"nombre" : $("#curso2").val(), "fecha" : $("#txtDate3c2").val()} );
          }
          if($.trim($("#curso3").val()) != "" ){
            chkArray2.push( {"nombre" : $("#curso3").val(), "fecha" : $("#txtDate3c3").val()} );
          }

       
          
          /* we join the array separated by the comma */
          var selected;
          selected = chkArray.join(' , ') ;
          
          /* check if there is selected checkboxes, by default the length is 1 as it contains one single comma */
          if(selected.length== 0){
             alert("Selecciona al menos 1 cargo"); 
            return false;
          }

          var JSONData={};
               
               $.ajax({
                         url : "processform.php",
                         type:"post",
                         data:{ action:"thirdpagedata",data:chkArray,data2:chkArray2},
                         success:function(data){
                                 window.location.href="proceso3.php";
                                 return false
                         },
                         error:function(){

                         }

               })
      return false;
    })
    $("form#proceso3form").submit(function(e){
      e.preventDefault();
          var chkArray = [];
          /* look for all checkboes that have a parent id  attached to it and check if it was checked */
          if($.trim($("#empresa").val()) != "" ){
            chkArray.push( {"empresa" : $("#empresa").val(), "cargo" : $("#cargo").val(), "fechaDesde" : $("#txtDate4").val(), "fechaHasta" : $("#txtDate4h").val()} );
          }
          if($.trim($("#empresa2").val()) != "" ){
            chkArray.push( {"empresa" : $("#empresa2").val(), "cargo" : $("#cargo2").val(), "fechaDesde" : $("#txtDate42").val(), "fechaHasta" : $("#txtDate42h").val()} );
          }
          if($.trim($("#empresa3").val()) != "" ){
            chkArray.push( {"empresa" : $("#empresa3").val(), "cargo" : $("#cargo3").val(), "fechaDesde" : $("#txtDate43").val(), "fechaHasta" : $("#txtDate43h").val()} );
          }
          if($.trim($("#experiencia").val()) != "" ){
            chkArray.push( {"experiencia" : $("#experiencia").val()} );
          }
         

          /* we join the array separated by the comma */
          var selected;
          selected = chkArray.join(' , ') ;
          
          /* check if there is selected checkboxes, by default the length is 1 as it contains one single comma */
          if(selected.length== 0){
             alert("Selecciona al menos 1 cargo"); 
            return false;
          }

          var JSONData={};
               
               $.ajax({
                         url : "processform.php",
                         type: "post",
                         data:{ action:"fourthpagedata",data:chkArray},
                         success:function(data){
                                 window.location.href="proceso4.php";
                                 return false
                         },
                         error:function(){

                         }

               })
      return false;
    })
     $("form#proceso4form").submit(function(e){
      e.preventDefault();
          var chkArray = [];
          /* look for all checkboes that have a parent id  attached to it and check if it was checked */
          if($.trim($("#empresaref").val()) != "" ){
            chkArray.push( {"empresa" : $("#empresaref").val(), "nombreContacto" : $("#contactoref").val(), "cargo" : $("#cargoref").val(), "telefono" : $("#telefonoref").val(), "email" : $("#emailref").val()} );
          }
          if($.trim($("#empresaref").val()) != "" ){
            chkArray.push( {"empresa" : $("#empresaref2").val(), "nombreContacto" : $("#contactoref2").val(), "cargo" : $("#cargoref2").val(), "telefono" : $("#telefonoref2").val(), "email" : $("#emailref2").val()} );
          }
          if($.trim($("#empresaref").val()) != "" ){
            chkArray.push( {"empresa" : $("#empresaref3").val(), "nombreContacto" : $("#contactoref3").val(), "cargo" : $("#cargoref3").val(), "telefono" : $("#telefonoref3").val(), "email" : $("#emailref3").val()} );
          }
          if($.trim($("#referencia_laboral").val()) != "" ){
            chkArray.push( {"referencia_laboral" : $("#referencia_laboral").val()} );
          }

        

         

          /* we join the array separated by the comma */
          var selected;
          selected = chkArray.join(' , ') ;
          
          /* check if there is selected checkboxes, by default the length is 1 as it contains one single comma */
          if(selected.length== 0){
             alert("Selecciona al menos 1 cargo"); 
            return false;
          }

          var JSONData={};
               
               $.ajax({
                         url : "processform.php",
                         type: "post",
                         data:{ action:"fifthpagedata",data:chkArray},
                         success:function(data){
                                 window.location.href="proceso5.php";
                                 return false
                         },
                         error:function(){

                         }

               })
      return false;
    })
     $("form#proceso5form").submit(function(e){
      e.preventDefault();
          var chkArray = [];
         var containerDataHoras = $('#containerDataHoras');
         var dias1Data = $('#diasData1');
          /* look for all checkboes that have a parent id  attached to it and check if it was checked */
         if($.trim($("#afp").val()) != "" ){
             chkArray.push( {"afp" : $("#afp").val()} );
             $('#afp').css('border-color' , '#f2f2f2');
         }else{
             notie.alert({ type: 3, text: 'Debes elegir AFP', position: 'bottom' });
             $('#afp').css('border-color' , 'red');
             return false;
         }
         if($.trim($("#isapre").val()) != "" ){
             chkArray.push( {"isapre" : $("#isapre").val()} );
             $('#isapre').css('border-color' , '#f2f2f2');
         }else{
             notie.alert({ type: 3, text: 'Debes elegir tu previsión de salud', position: 'bottom' });
             $('#isapre').css('border-color' , 'red');
             return false;
         }
         if($.trim($("#comunaswork").val()) != "" ){
            chkArray.push( {"region" : $("#regionwork").val(), "comunas" : $("#comunaswork").val()} );
            $('#comunas').css('border-color' , '#f2f2f2');
        }else{
            notie.alert({ type: 3, text: 'Debes elegir las comunas disponibles para trabajar', position: 'bottom' });
            $('#comunas').css('border-color' , 'red');
            return false;
        }
        if($.trim($("#dias").val()) != "" ){
             chkArray.push( {"dias" : $("#dias").val(), "horarios" : $("#id_label_multiple").val()+' a '+$("#id_label_multiple1").val()} );
             $('#dias').siblings('input').css('border-color' , '#f2f2f2');
             $('#id_label_multiple').siblings('input').css('border-color' , '#f2f2f2');
             $('#id_label_multiple1').siblings('input').css('border-color' , '#f2f2f2');
         }else{
             notie.alert({ type: 3, text: 'Debes elegir los dias y horarios disponibles para trabajar', position: 'bottom' });
             $('#dias').siblings('input').css('border-color' , 'red');
             $('#id_label_multiple').siblings('input').css('border-color' , 'red');
             $('#id_label_multiple1').siblings('input').css('border-color' , 'red');
             return false;
         }
         if($.trim($("#dias2").val()) != "" ){
             chkArray.push( {"dias" : $("#dias2").val(), "horarios" : $("#id_label_multiple2").val()+' a '+$("#id_label_multiple12").val()} );
             $('#dias').siblings('input').css('border-color' , '#f2f2f2');
         }
         if($.trim($("#dias3").val()) != "" ){
             chkArray.push( {"dias" : $("#dias3").val(), "horarios" : $("#id_label_multiple3").val()+' a '+$("#id_label_multiple13").val()} );
             $('#dias').siblings('input').css('border-color' , '#f2f2f2');
         }
         if($.trim($("#dias4").val()) != "" ){
             chkArray.push( {"dias" : $("#dias4").val(), "horarios" : $("#id_label_multiple4").val()+' a '+$("#id_label_multiple14").val()} );
             $('#dias').siblings('input').css('border-color' , '#f2f2f2');
         }
         if($.trim($("#dias5").val()) != "" ){
             chkArray.push( {"dias" : $("#dias5").val(), "horarios" : $("#id_label_multiple5").val()+' a '+$("#id_label_multiple15").val()} );
             $('#dias').siblings('input').css('border-color' , '#f2f2f2');
         }
         if ($(containerDataHoras).find(dias1Data).length < 1){
             notie.alert({ type: 3, text: 'Debes Horario Disponible para trabajar', position: 'bottom' });
             $('#comunas1').css('border-color' , 'red');
             return false;
         }



          /* we join the array separated by the comma */
          var selected;
          selected = chkArray.join(' , ') ;
          
          /* check if there is selected checkboxes, by default the length is 1 as it contains one single comma */
          if(selected.length== 0){
             alert("Selecciona al menos 1 cargo"); 
            return false;
          }

          var JSONData={};
               
               $.ajax({
                         url : "processform.php",
                         type: "post",
                         data:{ action:"sixthpagedata",data:chkArray},
                         success:function(data){
                                 window.location.href="proceso6.php";
                                 return false
                         },
                         error:function(){

                         }

               })
      return false;
    })
	 $("form#proceso6form").submit(function(e){
      e.preventDefault();
          var chkArray = [];
          /* look for all checkboes that have a parent id  attached to it and check if it was checked */
         if($.trim($("#uniforme").val()) != "" ){
             chkArray.push( {"uniforme" : $("#uniforme").val()} );
             $('#uniforme').css('border-color' , '#f2f2f2');
         }else{
             notie.alert({ type: 3, text: 'Ingresa tu talla de polera', position: 'bottom' });
             $('#uniforme').css('border-color' , 'red');
             return false;
         }
         if($.trim($("#uniforme2").val()) != "" ){
             chkArray.push( {"uniforme2" : $("#uniforme2").val()} );
             $('#uniforme2').css('border-color' , '#f2f2f2');
         }else{
             notie.alert({ type: 3, text: 'Ingresa tu talla de polerón', position: 'bottom' });
             $('#uniforme2').css('border-color' , 'red');
             return false;
         }
         if($.trim($("#tallaZapato").val()) != "" ){
             chkArray.push( {"tallaZapato" : $("#tallaZapato").val()} );
             $('#tallaZapato').css('border-color' , '#f2f2f2');
         }else{
             notie.alert({ type: 3, text: 'Ingresa tu talla de calzado', position: 'bottom' });
             $('#tallaZapato').css('border-color' , 'red');
             return false;
         }
         if($.trim($("#tallaPantalon").val()) != "" ){
             chkArray.push( {"tallaPantalon" : $("#tallaPantalon").val()} );
             $('#tallaPantalon').css('border-color' , '#f2f2f2');
         }else{
             notie.alert({ type: 3, text: 'Ingresa tu talla de pantalón', position: 'bottom' });
             $('#tallaPantalon').css('border-color' , 'red');
             return false;
         }
         if($.trim($("#renta").val()) != "" ){
             chkArray.push( {"renta" : $("#renta").val()} );
             $('#renta').css('border-color' , '#f2f2f2');
         }else{
             notie.alert({ type: 3, text: 'Debes ingresar tus pretenciones de renta', position: 'bottom' });
             $('#renta').css('border-color' , 'red');
             return false;
         }

         if($.trim($("#cv").val()) != "" ){
             chkArray.push( {"cv" : $("#cv").val()} );
             $('#cv').css('border-color' , '#f2f2f2');
         }
         if($.trim($("#cerAntecedentes").val()) != "" ){
             chkArray.push( {"cerAntecedentes" : $("#cerAntecedentes").val()} );
             $('#cerAntecedentes').css('border-color' , '#f2f2f2');
         }



          /* we join the array separated by the comma */
          var selected;
          selected = chkArray.join(' , ') ;
          
          /* check if there is selected checkboxes, by default the length is 1 as it contains one single comma */
          /*if(selected.length== 0){
             alert("Selecciona al menos 1 cargo");
            return false;
          }*/
          
//        var file_data = $('#cv').prop('files')[0];   
//        var form_data = new FormData();                  
//        form_data.append('file', file_data);
//        //alert(form_data);
//        $.ajax({
//            url: 'processform.php', // point to server-side PHP script 
//            dataType: 'text',  // what to expect back from the PHP script, if anything
//            cache: false,
//            contentType: false,
//            processData: false,
//            data: form_data,                         
//            type: 'post',
//            success: function(php_script_response){
//                //alert(php_script_response); // display response from the PHP script, if any
//            }
//         });

          var JSONData={};
               
               $.ajax({
                         url : "processform.php",
                         type: "post",
                         data:{ action:"seventhpagedata",data:chkArray },
                         success:function(data){
                                 //alert("data has been saved succeesssfully");
                                 window.location.href="postular.php";
                                 return false
                         },
                         error:function(){

                         }

               })
      return false;
    })
    $("form#postularform").submit(function(e){
        e.preventDefault();
        var JSONData={};
               
        $.ajax({
                  url : "processform.php",
                  type: "post",
                  data:{ action:"lastpagedata",data:null },
                  success:function(data){
                          //alert("data has been saved succeesssfully");
                          window.location.href="gracias.php";
                          return false
                  },
                  error:function(){
                  }

        })
        return false;
    })
});


/*Select inicializado*/

  $(document).ready(function(){
    $('select').formSelect();
  });
  /*calendario inicializado */
    $(document).ready(function(){
    $('.datepicker').datepicker();
});
   $(document).ready(function() {
  $('.datepicker').datepicker({
    format: 'dd-mm-yy',
    selectMonths: true, // Creates a dropdown to control month
    selectYears: 10,
    yearRange: 70,

     // internationalization
    i18n: {
      cancel: 'Cancelar',
      clear: 'Clear',
      done: 'Ok',
      previousMonth : '‹',
      nextMonth     : '›',
      months        : [ 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
      monthsShort   : [ 'Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
      weekdays      : ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado' ],
      weekdaysShort : [ 'Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab' ],
      weekdaysAbbrev : ['D', 'L', 'M', 'M', 'J', 'V', 'S' ]
    },
   
    formatSubmit:'dd/mm/yy',
  });
});

/*INICIALIZANDO CHIPS*/
 document.addEventListener('DOMContentLoaded', function() {
    /*var elems = document.querySelectorAll('.chips');
    var instances = M.Chips.init(elems, options);*/
  });
 $('#pasaporte_box').hide();
 $('#tipo_doc').change(function(){
     if($('#tipo_doc').val() == 'rut') {
         $('#rut_box').show();
     } else {
         $('#rut_box').hide();
     }
     if($('#tipo_doc').val() == 'pasaporte') {
         $('#pasaporte_box').show();
     } else {
         $('#pasaporte_box').hide();
     }
 });

 $('#tipoEstudio').change(function(){
     if($('#tipoEstudio').val() == 'basica' || $('#tipoEstudio').val() == 'media' ) {
        $('#carrerabox').hide();
        $('#estudiobox').hide();
    } else {
         $('#carrerabox').show();
         $('#estudiobox').show();
        }
 });
 $('#estado_estudio').change(function(){
     if($('#estado_estudio').val() == 'En Curso') {
         $('#box_estudio').hide();
         $("#fechaEstudio").prop("checked", true);
     } else {
         $('#box_estudio').show();
         $("#fechaEstudio").prop("checked", false);
     }
 });

 $('#container_ref').hide();
 $('#referencia_laboral').change(function(){
     if($('#referencia_laboral').val() == 'Si') {
         $('#container_ref').show();
     } else {
         $('#container_ref').hide();
     }
 });
/*Variables de los cursos.*/
 $('#curso2_box').hide();
 $('#curso3_box').hide();
 $('#btn-delete-curso1').hide();
 $('#btn-delete-curso2').hide();
 $('#btn-delete-curso3').hide();
 $('#cursoData').css('height', 'auto');
 var agregarCurso = $('#cursoData');


function myFunctionCurso1() {
    var x = $('#curso').val();
    var y = $('#txtDate3').val();

    $('#curso_box').appendTo(agregarCurso);
    $('#btn-send-curso1').hide();
    $('#btn-delete-curso1').show();
    $('#curso2_box').show();
}
function myFunctionEliminarCurso1() {
    var x = $('#curso').val();
    var y = $('#txtDate3').val();
    var z = $('.curso1before');
    //x.empty();
    //y.empty();
    $('#curso_box').appendTo(z);
    $('#btn-delete-curso1').hide();
    $('#btn-send-curso1').show();
}
 function myFunctionCurso2() {
     var x = $('#curso2').val();
     var y = $('#txtDate3c2').val();

     $('#curso2_box').appendTo(agregarCurso);
     $('#btn-send-curso2').hide();
     $('#btn-delete-curso2').show();
     $('#curso3_box').show();
 }
 function myFunctionEliminarCurso2() {
     var x = $('#curso2').val();
     var y = $('#txtDate3c2').val();
     var z = $('.curso2before');
     //x.empty();
     //y.empty();
     $('#curso2_box').appendTo(z);
     $('#btn-delete-curso2').hide();
     $('#btn-send-curso2').show();
 }
 function myFunctionCurso3() {
     var x = $('#curso3').val();
     var y = $('#txtDate3c3').val();

     $('#curso3_box').appendTo(agregarCurso);
     $('#btn-send-curso3').hide();
     $('#btn-delete-curso3').show();
 }
 function myFunctionEliminarCurso3() {
     var x = $('#curso3').val();
     var y = $('#txtDate3c3').val();
     var z = $('.curso3before');
     //x.empty();
     //y.empty();
     $('#curso3_box').appendTo(z);
     $('#btn-delete-curso3').hide();
     $('#btn-send-curso3').show();
 }


/*evento agregar experiencia*/

 //Experiencia
 //Asignamos Variables a los input de experiencia
 var inputExp1 = $('#experiencia_box_1');
 var inputExp2 = $('#experiencia_box_2');
 var inputExp3 = $('#experiencia_box_3');

 //Ocultamos los Input de Experiencia 2 y 3
 $(inputExp2).hide();
 $(inputExp3).hide();

 //Ocultamos

 $('#box_experiencia').hide();
 $('#experiencia').change(function(){
     if($('#experiencia').val() == 'Si') {
         $('#box_experiencia').show();
     } else {
         $('#box_experiencia').hide();
     }
 });
 $('#fechaCargo').change(function() {
     if ($(this).is(':checked')) {
         console.log('Checked');
         $('#input-fecha-until').hide();
     } else {
         $('#input-fecha-until').show();
     }
 });
 $('#fechaCargo2').change(function() {
     if ($(this).is(':checked')) {
         console.log('Checked');
         $('#input-fecha-until2').hide();
     } else {
         $('#input-fecha-until2').show();
     }
 });
 $('#fechaCargo3').change(function() {
     if ($(this).is(':checked')) {
         console.log('Checked');
         $('#input-fecha-until3').hide();
     } else {
         $('#input-fecha-until3').show();
     }
 });
 //Asignamos variables a los input de la experiencia
 var inputDataExp1 = $('#experiencia_box_1');
 var inputDataExp2 = $('#experiencia_box_2');
 var inputDataExp3 = $('#experiencia_box_3');

 inputDataExp1.addClass('input-not-active');
 inputDataExp2.addClass('input-not-active');
 inputDataExp3.addClass('input-not-active');

 //Asignamos variables a los box donde se imprime la experiencia
 var boxDataExp1 = $('#boxDataExp1');
 var boxDataExp2 = $('#boxDataExp2');
 var boxDataExp3 = $('#boxDataExp3');

 //Ocultamos los box donde se imprime la experiencia
 $(boxDataExp1).hide();
 $(boxDataExp2).hide();
 $(boxDataExp3).hide();

 //Asignamos Variables a los Botones para borrar la Data de la Experiencia
 var btnDeleteExp1 = $('#btnDeleteExp1');
 var btnDeleteExp2 = $('#btnDeleteExp2');
 var btnDeleteExp3 = $('#btnDeleteExp3');

 //Ocultamos Botones para borrar la data
 $(btnDeleteExp1).hide();
 $(btnDeleteExp1).hide();
 $(btnDeleteExp1).hide();

 var experienciaData = $('.boxexperiencia');
 var experienciaInputContainer = $('#box_experiencia');
 $(experienciaData).css('height', 'auto');

function myFunctionAgregar() {

    var inputEmpresa1 = $('#empresa').val();
    var inputCargo1 = $('#cargo').val();
    var inputDate1 = $('#txtDate4').val();
    var inputDate2 = $('#txtDate4h').val();
    var dataEmpresa = $('#empresaData');
    var dataCargo = $('#cargoData');
    var dataFecha1 = $('#fecha1Data');
    var dataFecha2 = $('#fecha2Data');

    $(inputExp1).hide();
    $(inputExp1).removeClass('input-not-active').addClass('input-active');

    $(dataEmpresa).html("Empresa: " + inputEmpresa1);
    $(dataCargo).html("Cargo: " + inputCargo1);
    $(dataFecha1).html("Desde: " + inputDate1);

    $(btnDeleteExp1).show();
    $(boxDataExp1).show();

    $(inputExp2).show();

    if ($('#fechaCargo').prop("checked") == true){
        $(dataFecha2).html("Hasta: al presente");
    }else {
        $(dataFecha2).html("Hasta: " + inputDate2);
    }
}
function elminarExp1(){
    $(inputExp1).show();
    if ($(experienciaInputContainer).find(inputDataExp2).hasClass('input-not-active')){
        $(inputDataExp2).hide();

    }
    if ($(experienciaInputContainer).find(inputDataExp3).hasClass('input-not-active')){
        $(inputDataExp3).hide();

    }

    $(inputExp1).addClass('input-not-active');
    $(inputExp1).removeClass('input-active');
    $(btnDeleteExp1).hide();
    $(boxDataExp1).hide();
}
 function myFunctionAgregar2() {

     var inputEmpresa1 = $('#empresa2').val();
     var inputCargo1 = $('#cargo2').val();
     var inputDate1 = $('#txtDate42').val();
     var inputDate2 = $('#txtDate42h').val();
     var dataEmpresa = $('#empresaData2');
     var dataCargo = $('#cargoData2');
     var dataFecha1 = $('#fecha1Data2');
     var dataFecha2 = $('#fecha2Data2');

     $(inputExp2).hide();
     $(inputExp2).removeClass('input-not-active').addClass('input-active');

     $(dataEmpresa).html("Empresa: " + inputEmpresa1);
     $(dataCargo).html("Cargo: " + inputCargo1);
     $(dataFecha1).html("Desde: " + inputDate1);

     $(btnDeleteExp2).show();
     $(boxDataExp2).show();

     $(inputExp3).show();

     if ($('#fechaCargo2').prop("checked") == true){
         $(dataFecha2).html("Hasta: al presente");
     }else {
         $(dataFecha2).html("Hasta: " + inputDate2);
     }
 }
 function elminarExp2(){
     $(inputExp2).show();
     $(inputExp2).removeClass('input-active').addClass('input-not-active');

     $(btnDeleteExp2).hide();
     $(boxDataExp2).hide();

     if ($(inputExp3).hasClass('input-not-active')){
         $(inputExp3).hide();
         $(inputExp2).show();
     }
     if($(inputExp1).hasClass('input-not-active')){
         $(inputExp2).hide();
     }


 }
 function myFunctionAgregar3() {

     var inputEmpresa1 = $('#empresa3').val();
     var inputCargo1 = $('#cargo3').val();
     var inputDate1 = $('#txtDate43').val();
     var inputDate2 = $('#txtDate43h').val();
     var dataEmpresa = $('#empresaData3');
     var dataCargo = $('#cargoData3');
     var dataFecha1 = $('#fecha1Data3');
     var dataFecha2 = $('#fecha2Data3');

     $(inputExp3).hide();
     $(inputExp3).removeClass('input-not-active').addClass('input-active');

     $(dataEmpresa).html("Empresa: " + inputEmpresa1);
     $(dataCargo).html("Cargo: " + inputCargo1);
     $(dataFecha1).html("Desde: " + inputDate1);

     $(btnDeleteExp3).show();
     $(boxDataExp3).show();


     if ($('#fechaCargo3').prop("checked") == true){
         $(dataFecha2).html("Hasta: al presente");
     }else {
         $(dataFecha2).html("Hasta: " + inputDate2);
     }
 }
 function elminarExp3(){
     //
     $(inputExp3).addClass('input-not-active').removeClass('input-active');
     $(btnDeleteExp3).hide();
     $(boxDataExp3).hide();

     /*if ($(experienciaInputContainer).find(inputDataExp2).hasClass('input-active')){
         $(inputDataExp3).hide();

     }
     if ($(experienciaInputContainer).find(inputDataExp1).hasClass('input-active')){
         $(inputDataExp3).hide();

     }*/
     if ($(inputExp1).hasClass('input-not-active')){
         $(inputExp3).hide();
     }else if ($(inputExp2).hasClass('input-not-active')){
         $(inputExp3).hide();
     }else{
         $(inputExp3).show();
     }

 }


//Referencias

 var refBox1 = $('#refs_box1');
 var refBox2 = $('#refs_box2');
 var refBox3 = $('#refs_box3');
 var refData = $('.box_referencias');
 var refInput = $('#container_ref');
 var btnAgregarRef1 = $('#boton_refs1');
 var btnAgregarRef2 = $('#boton_refs2');
 var btnAgregarRef3 = $('#boton_refs3');
 var btnEliminarRef1 = $('#btn-delete-ref1');
 var btnEliminarRef2 = $('#btn-delete-ref2');
 var btnEliminarRef3 = $('#btn-delete-ref3');
 $(refBox2).hide();
 $(refBox3).hide();
 $(btnEliminarRef1).hide();
 $(btnEliminarRef2).hide();
 $(btnEliminarRef3).hide();
 $(refData).css('height','auto');



function myFunctionRef() {
    var x = $('#empresaref').val();
    var y = $('#contactoref').val();
    var z = $('#cargoref').val();
    var a = $('#telefonoref').val();
    var b = $('#emailref').val();
    var c = $('#empresaref');
    var d = $('#contactoref');
    var e = $('#cargoref');
    var f = $('#telefonoref');
    var g = $('#emailref');

    $(refBox1).appendTo(refData);
    $(btnEliminarRef1).show();
    $(btnAgregarRef1).hide();
    $(refBox2).show();

    $(c).prop('disabled', true);
    $(d).prop('disabled', true);
    $(e).prop('disabled', true);
    $(f).prop('disabled', true);
    $(g).prop('disabled', true);
}
 function myFunctionEliminarRef1() {
     var x = $('#empresaref').val();
     var y = $('#contactoref').val();
     var z = $('#cargoref').val();
     var a = $('#telefonoref').val();
     var b = $('#emailref').val();
     var c = $('#empresaref');
     var d = $('#contactoref');
     var e = $('#cargoref');
     var f = $('#telefonoref');
     var g = $('#emailref');

     $(refBox1).appendTo(refInput);
     $(btnAgregarRef1).show();
     $(btnEliminarRef1).hide();

     $(c).prop('disabled', false);
     $(d).prop('disabled', false);
     $(e).prop('disabled', false);
     $(f).prop('disabled', false);
     $(g).prop('disabled', false);
     if ($(refInput).find(refBox2).length > 0){
             $(refBox2).hide();

     }
     if ($(refInput).find(refBox3).length > 0){
         $(refBox3).hide();

     }
 }
 function myFunctionRef2() {
     var x = $('#empresaref2').val();
     var y = $('#contactoref2').val();
     var z = $('#cargoref2').val();
     var a = $('#telefonoref2').val();
     var b = $('#emailref2').val();
     var c = $('#empresaref2');
     var d = $('#contactoref2');
     var e = $('#cargoref2');
     var f = $('#telefonoref2');
     var g = $('#emailref2');

     $(refBox2).appendTo(refData);
     $(btnEliminarRef2).show();
     $(btnAgregarRef2).hide();
     $(refBox3).show();

     $(c).prop('disabled', true);
     $(d).prop('disabled', true);
     $(e).prop('disabled', true);
     $(f).prop('disabled', true);
     $(g).prop('disabled', true);
 }
 function myFunctionEliminarRef2() {
     var x = $('#empresaref2').val();
     var y = $('#contactoref2').val();
     var z = $('#cargoref2').val();
     var a = $('#telefonoref2').val();
     var b = $('#emailref2').val();
     var c = $('#empresaref2');
     var d = $('#contactoref2');
     var e = $('#cargoref2');
     var f = $('#telefonoref2');
     var g = $('#emailref2');

     $(refBox2).appendTo(refInput);
     $(btnAgregarRef2).show();
     $(btnEliminarRef2).hide();

     $(c).prop('disabled', false);
     $(d).prop('disabled', false);
     $(e).prop('disabled', false);
     $(f).prop('disabled', false);
     $(g).prop('disabled', false);

     if ($(refInput).find(refBox3).length > 0){
         $(refBox3).hide();

     }
     if ($(refInput).find(refBox1).length > 0){
         $(refBox2).hide();

     }

 }
 function myFunctionRef3() {
     var x = $('#empresaref3').val();
     var y = $('#contactoref3').val();
     var z = $('#cargoref3').val();
     var a = $('#telefonoref3').val();
     var b = $('#emailref3').val();
     var c = $('#empresaref3');
     var d = $('#contactoref3');
     var e = $('#cargoref3');
     var f = $('#telefonoref3');
     var g = $('#emailref3');

     $(refBox3).appendTo(refData);
     $(btnEliminarRef3).show();
     $(btnAgregarRef3).hide();

     $(c).prop('disabled', true);
     $(d).prop('disabled', true);
     $(e).prop('disabled', true);
     $(f).prop('disabled', true);
     $(g).prop('disabled', true);
 }
 function myFunctionEliminarRef3() {
     var x = $('#empresaref3').val();
     var y = $('#contactoref3').val();
     var z = $('#cargoref3').val();
     var a = $('#telefonoref3').val();
     var b = $('#emailref3').val();
     var c = $('#empresaref3');
     var d = $('#contactoref3');
     var e = $('#cargoref3');
     var f = $('#telefonoref3');
     var g = $('#emailref3');

     $(refBox3).appendTo(refInput);
     $(btnAgregarRef3).show();
     $(btnEliminarRef3).hide();

     $(c).prop('disabled', false);
     $(d).prop('disabled', false);
     $(e).prop('disabled', false);
     $(f).prop('disabled', false);
     $(g).prop('disabled', false);

     if ($(refInput).find(refBox2).length > 0){
         $(refBox3).hide();

     }
 }





 //horas Proceso 5
 var containerHoras = $('#containerInputHoras');

 var inputDiaHora = $('#inputDiaHora');
 var boxData1 = $('#dias1Box');
 $(boxData1).hide();
 var inputDiaHora2 = $('#inputDiaHora2');
 var boxData2 = $('#dias2Box');
 $(boxData2).hide();
 $(inputDiaHora2).hide();

 var inputDiaHora3 = $('#inputDiaHora3');
 var boxData3 = $('#dias3Box');
 $(boxData3).hide();
 $(inputDiaHora3).hide();
 var inputDiaHora4 = $('#inputDiaHora4');
 var boxData4 = $('#dias4Box');
 $(boxData4).hide();
 $(inputDiaHora4).hide();
 var inputDiaHora5 = $('#inputDiaHora5');
 var boxData5 = $('#dias5Box');
 $(boxData5).hide();
 $(inputDiaHora5).hide();


 function agregarDias1(){
     var dias1Value = $('#dias').val().join(", ");
     var hora1Value = $('#id_label_multiple').val();
     var hora2Value = $('#id_label_multiple1').val();
     var dias1Data = $('#diasData1');
     var hora1Data = $('#horasData1');
     var hora2Data = $('#horasData1h');
     var comunas1Value = $('#comunas1').val();
     var comunas1Data = $('#comunasData1');

     $(boxData1).show();
     $(inputDiaHora).hide();
     $(inputDiaHora2).show();

     $(dias1Data).html(dias1Value);
     $(hora1Data).html(hora1Value);
     $(hora2Data).html(hora2Value);
     $(comunas1Data).html(comunas1Value);

 }
 function myFunctionEliminarHora1(){
     $(boxData1).hide();
     $(inputDiaHora).show();
     $(inputDiaHora).addClass('active-input');

     if ($(containerHoras).find(inputDiaHora).hasClass('active-input')){
         $(inputDiaHora2).hide().removeClass('active-input');
         $(inputDiaHora).show().addClass('active-input');
         $(inputDiaHora3).hide().removeClass('active-input');
         $(inputDiaHora4).hide().removeClass('active-input');
         $(inputDiaHora5).hide().removeClass('active-input');
     }

 }

 function agregarDias2(){
     var dias1Value = $('#dias2').val().join(", ");
     var hora1Value = $('#id_label_multiple2').val();
     var hora2Value = $('#id_label_multiple12').val();
     var dias1Data = $('#diasData2');
     var hora1Data = $('#horasData2');
     var hora2Data = $('#horasData2h');
     var comunas1Value = $('#comunas2').val();
     var comunas1Data = $('#comunasData2');

     $(boxData2).show();
     $(inputDiaHora2).hide();
     $(inputDiaHora3).show();

     $(dias1Data).html(dias1Value);
     $(hora1Data).html(hora1Value);
     $(hora2Data).html(hora2Value);
     $(comunas1Data).html(comunas1Value);
 }
 function myFunctionEliminarHora2(){
     $(boxData2).hide();
     $(inputDiaHora2).show().addClass('active-input');
     if ($(containerHoras).find(inputDiaHora).hasClass('active-input')){
         $(inputDiaHora2).hide().removeClass('active-input');
         $(inputDiaHora3).hide().removeClass('active-input');
         $(inputDiaHora).show().addClass('active-input');
         $(inputDiaHora4).hide().removeClass('active-input');
         $(inputDiaHora5).hide().removeClass('active-input');
     }else if ($(containerHoras).find(inputDiaHora3).length > 0){
         $(inputDiaHora2).show().addClass('active-input');
         $(inputDiaHora3).hide().removeClass('active-input');
         $(inputDiaHora4).hide().removeClass('active-input');
         $(inputDiaHora5).hide().removeClass('active-input');
     }
 }

 function agregarDias3(){
     var dias1Value = $('#dias3').val().join(", ");
     var hora1Value = $('#id_label_multiple3').val();
     var hora2Value = $('#id_label_multiple13').val();
     var dias1Data = $('#diasData3');
     var hora1Data = $('#horasData3');
     var hora2Data = $('#horasData3h');
     var comunas1Value = $('#comunas3').val();
     var comunas1Data = $('#comunasData3');

     $(boxData3).show();
     $(inputDiaHora3).hide();
     $(inputDiaHora4).show();

     $(dias1Data).html(dias1Value);
     $(hora1Data).html(hora1Value);
     $(hora2Data).html(hora2Value);
     $(comunas1Data).html(comunas1Value);
 }
 function myFunctionEliminarHora3(){
     $(boxData3).hide();
     $(inputDiaHora3).show().addClass('active-input');

     if ($(containerHoras).find(inputDiaHora).hasClass('active-input')){
         $(inputDiaHora2).hide().removeClass('active-input');
         $(inputDiaHora3).hide().removeClass('active-input');
         $(inputDiaHora4).hide().removeClass('active-input');
         $(inputDiaHora).show().addClass('active-input');
         $(inputDiaHora5).hide().removeClass('active-input');
     }else if ($(containerHoras).find(inputDiaHora4).length > 0){
         $(inputDiaHora3).show().addClass('active-input');
         $(inputDiaHora4).hide().removeClass('active-input');
         $(inputDiaHora5).hide().removeClass('active-input');
     }
 }
 function agregarDias4(){
     var dias1Value = $('#dias4').val().join(", ");
     var hora1Value = $('#id_label_multiple4').val();
     var hora2Value = $('#id_label_multiple14').val();
     var dias1Data = $('#diasData4');
     var hora1Data = $('#horasData4');
     var hora2Data = $('#horasData4h');
     var comunas1Value = $('#comunas4').val();
     var comunas1Data = $('#comunasData4');

     $(boxData4).show();
     $(inputDiaHora4).hide();
     $(inputDiaHora5).show();

     $(dias1Data).html(dias1Value);
     $(hora1Data).html(hora1Value);
     $(hora2Data).html(hora2Value);
     $(comunas1Data).html(comunas1Value);
 }
 function myFunctionEliminarHora4(){
     $(boxData4).hide();
     $(inputDiaHora4).show().addClass('active-input');

     if ($(containerHoras).find(inputDiaHora).hasClass('active-input')){
         $(inputDiaHora2).hide().removeClass('active-input');
         $(inputDiaHora).show().addClass('active-input');
         $(inputDiaHora3).hide().removeClass('active-input');
         $(inputDiaHora4).hide().removeClass('active-input');
         $(inputDiaHora5).hide().removeClass('active-input');
     }else if ($(containerHoras).find(inputDiaHora5).length > 0){
         $(inputDiaHora4).show().addClass('active-input');
         $(inputDiaHora5).hide().removeClass('active-input');
     }

 }
 function agregarDias5(){
     var dias1Value = $('#dias5').val().join(", ");
     var hora1Value = $('#id_label_multiple5').val();
     var hora2Value = $('#id_label_multiple15').val();
     var dias1Data = $('#diasData5');
     var hora1Data = $('#horasData5');
     var hora2Data = $('#horasData5h');
     var comunas1Value = $('#comunas5').val();
     var comunas1Data = $('#comunasData5');


     $(boxData5).show();
     $(inputDiaHora5).hide();

     $(dias1Data).html(dias1Value);
     $(hora1Data).html(hora1Value);
     $(hora2Data).html(hora2Value);
     $(comunas1Data).html(comunas1Value);
 }
 function myFunctionEliminarHora5(){
     $(boxData5).hide();
     $(inputDiaHora5).show();

     if ($(containerHoras).find(inputDiaHora).hasClass('active-input')){
         $(inputDiaHora2).hide().removeClass('active-input');
         $(inputDiaHora3).hide().removeClass('active-input');
         $(inputDiaHora4).hide().removeClass('active-input');
         $(inputDiaHora).show().addClass('active-input');
         $(inputDiaHora5).hide().removeClass('active-input');
     }else if ($(containerHoras).find(inputDiaHora5).length > 0){
         //$(inputDiaHora4).show().addClass('active-input');
         //$(inputDiaHora5).hide().removeClass('active-input');
     }
 }

 //Botón filepath
 var cvPath = $('#cv-path');
 var antecedentesPath = $('#antecedentes-path');
 var idPath = $('#id-path');
 var picturePath = $('#picture-path');

 var removeCv = $('#remove-cv');
 var removeAntecedentes = $('#remove-antecedentes');
 var removeId = $('#remove-ide');
 var removePicture = $('#remove-picture');

 function removeCvPath(){
     $(cvPath).val("");
     console.log("removed");
 }
 function removeAntecedentesPath(){
     $(antecedentesPath).val("");
     console.log("removed");
 }
 function removeIdPath(){
     $(antecedentesPath).val("");
     console.log("removed");
 }
 function removePicturePath(){
     $(antecedentesPath).val("");
     console.log("removed");
 }

/*MULTIPLE SELECT 2*/
/* $(document).ready(function() {
    $(".js-example-theme-multiple").select2({
        theme: "classic"
    });
}); */



/*TABS INIT*/
  $(document).ready(function(){
    $('.tabs').tabs();
  });

  /*MODAL INIT*/
   $(document).ready(function(){ 
    $('.modal').modal();
  });


function myFunctionGracias() {
    alert("Gracias por contestar nuestra encuesta.  Haga click en botón Ok para volver a postulaciones." );
    window.location.href="index.php";
}

// Admin
$("form#login").submit(function(e){
    e.preventDefault();
    var chkArray = [];
    if($.trim($("#email").val()) != "" ){
        chkArray.push( {"email" : $("#email").val()} );
        $('#email').css('border-color' , '#f2f2f2');
    } else {
        notie.alert({ type: 3, text: 'Debes ingresar tu nombre de usuario (correo electrónico)', position: 'bottom' });
        $('#email').css('border-color' , 'red');
        return false;
    }
    if($.trim($("#password").val()) != "" ){
        chkArray.push( {"password" : $("#password").val()} );
        $('#password').css('border-color' , '#f2f2f2');
    } else {
        notie.alert({ type: 3, text: 'Debes ingresar tu contraseña', position: 'bottom' });
        $('#password').css('border-color' , 'red');
        return false;
    }
    $.ajax({
        url : "adminform.php",
        type: "post",
        data: { action:"login", data:chkArray },
        success:function(data) {
            if (data == 'FAIL') {
                notie.alert({ type: 3, text: 'Nombre de usuario o contraseña inválidos', position: 'bottom' });
                $('#email').css('border-color' , 'red');    
            } else {
                window.location.href="userportia.html.php";
            }
            return false;
        },
        error:function() {
            return false;
        }
    })
    return false;
});
