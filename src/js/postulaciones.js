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

    function validarRUT(valor)
    {   
        // Se limpian primero los espacios
        var tmpstr = "";   
        for ( i=0; i < valor.length ; i++ )      
          if ( valor.charAt(i) != ' ') // && valor.charAt(i) != '.' && valor.charAt(i) != '-' )
              tmpstr = tmpstr + valor.charAt(i);   
        valor = tmpstr;
        
        // Se calcula el largo mínimo de un RUT igual a 3 caracteres (p.e. 1-9)
        largo = valor.length;
        if ( largo < 3 )   
        {      
          return false;   
        }   
  
        // Se valida que todos los caracteres sean los esperados (números, k, . y -)
        for ( i=0; i < largo ; i++ )   
          if ( '0123456789k.-'.indexOf(valor.charAt(i)) == -1 )
              return false;      
  
        // Se valida que esté en el formato adecuado (12.345.678-9)
        // PENDIENTE      
        
        // Se limpia el string de los . y -
        var numeroRUT = "";
        for ( i=0; i < valor.length ; i++ )      
          if ( valor.charAt(i) != '.' && valor.charAt(i) != '-' )
            numeroRUT = numeroRUT + valor.charAt(i);   
  
        // Se valida el dígito verificador
        if ( validarDigito(numeroRUT) )      
          return true;   
        else
          return false;
    }
  
    function validarDigito(valor)
    {   
        var crut = valor;
        largo = crut.length;   
        if ( largo < 2 )   
        {      
          return false;   
        }   
        if ( largo > 2 )      
          rut = crut.substring(0, largo - 1);   
        else      
        rut = crut.charAt(0);   
        dv = crut.charAt(largo-1);   
        
        if ( dv != '0' && dv != '1' && dv != '2' && dv != '3' && dv != '4' && dv != '5' && dv != '6' && dv != '7' && dv != '8' && dv != '9' && dv != 'k'  && dv != 'K')   
        {      
          return false;   
        }      
  
        if ( rut == null || dv == null )
          return 0;
  
        var dvr = '0'   
        suma = 0   
        mul  = 2   
  
        for (i= rut.length -1 ; i >= 0; i--)   
        {   
          suma = suma + rut.charAt(i) * mul      
          if (mul == 7)         
              mul = 2      
          else             
              mul++   
        }   
        res = suma % 11   
        if (res==1)      
          dvr = 'k'   
        else if (res==0)      
          dvr = '0'   
        else   
        {      
          dvi = 11-res      
          dvr = dvi + ""   
        }
        if ( dvr != dv)   
        {      
          return false;
        }
  
        return true;
    }

    function validarFecha(fecha) {
        // La longitud de la fecha debe tener exactamente 10 caracteres
        if ( fecha.length !== 10 )
            error = true;
    
        // Primero verifica el patron
        if ( !/^\d{1,2}\/\d{1,2}\/\d{4}$/.test(fecha) )
            error = true;
    
        // Mediante el delimitador "/" separa dia, mes y año
        var fecha = fecha.split("/");
        var day = parseInt(fecha[0]);
        var month = parseInt(fecha[1]);
        var year = parseInt(fecha[2]);
    
        // Verifica que dia, mes, año, solo sean numeros
        error = ( isNaN(day) || isNaN(month) || isNaN(year) );
    
        // Lista de dias en los meses, por defecto no es año bisiesto
        var ListofDays = [31,28,31,30,31,30,31,31,30,31,30,31];
        if ( month === 1 || month > 2 )
            if ( day > ListofDays[month-1] || day < 0 || ListofDays[month-1] === undefined )
              error = true;
    
        // Detecta si es año bisiesto y asigna a febrero 29 dias
        if ( month === 2 ) {
            var lyear = ( (!(year % 4) && year % 100) || !(year % 400) );
            if ( lyear === false && day >= 29 )
              error = true;
            if ( lyear === true && day > 29 )
              error = true;
        }
        if ( error === true ) {
          notie.alert({ type: 3, text: 'Fecha Inválida: el formato: dd/mm/aaaa (dia/mes/año) ', position: 'bottom' });
          $('#txtDate').css('border-color' , 'red');
          return false;
        }
        else
        return true;
    }

    function validarEmail(valor) {
        if (/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{1,3})$/.test(valor)){
            return true;
        } else {
            return false;
        }
    }

    function getSelectionFormData() {
        var dataArray = [];
        $("#retail input:checked").each(function() {
            dataArray.push({nun : $(this).data("index"),"nom": $(this).next("span").text(),"cat":"Retail"});
        });
        $("#administrativo input:checked").each(function() {
            dataArray.push({nun : $(this).data("index"),"nom": $(this).next("span").text(),"cat":"Administrativo"});
        });
        $("#industrial input:checked").each(function() {
            dataArray.push({nun : $(this).data("index"),"nom": $(this).next("span").text(),"cat":"Industrial"});
        });
        $("#otros input:checked").each(function() {
            dataArray.push({nun : $(this).data("index"),"nom": $(this).next("span").text(),"cat":"Otros"});
        });
        return dataArray;
    }

    function getFirstStepData() {
        var dataArray = [];
        if($.trim($("#tipo_doc").val()) == "rut") {
            if($.trim($("#rut").val()) != "" ) {
                if (validarRUT($.trim($("#rut").val()))) {
                    dataArray.push( {"rut" : $("#rut").val()} );
                    $('#rut').css('border-color' , '#f2f2f2');
                }
                else {
                    notie.alert({ type: 3, text: 'El rut ingresado no es válido', position: 'bottom' });
                    $('#rut').css('border-color' , 'red');
                    return false;
                }
            } else {
                notie.alert({ type: 3, text: 'Debes ingresar rut', position: 'bottom' });
                $('#rut').css('border-color' , 'red');
                return false;
            }
        } else {
            if($.trim($("#pasaporte").val()) != "" ){
                dataArray.push( {"pasaporte" : $("#pasaporte").val()} );
                $('#pasaporte').css('border-color' , '#f2f2f2');
            } else {
                notie.alert({ type: 3, text: 'Debes ingresar pasaporte', position: 'bottom' });
                $('#pasaporte').css('border-color' , 'red');
                return false;
            }
        }
        if($.trim($("#first_name").val()) != "" ){
            dataArray.push( {"noms" : $("#first_name").val()} );
            $('#first_name').css('border-color' , '#f2f2f2');
        } else {
            notie.alert({ type: 3, text: 'Debes ingresar tu nombre', position: 'bottom' });
            $('#first_name').css('border-color' , 'red');
            return false;
        }
        if($.trim($("#last_name").val()) != "" ){
            dataArray.push( {"apeP" : $("#last_name").val()} );
            $('#last_name').css('border-color' , '#f2f2f2');
        } else {
            notie.alert({ type: 3, text: 'Debes ingresar tu apellido', position: 'bottom' });
            $('#last_name').css('border-color' , 'red');
            return false;
        }
        if($.trim($("#last_name_2").val()) != "" ){
            dataArray.push( {"apeM" : $("#last_name_2").val()} );
            $('#last_name_2').css('border-color' , '#f2f2f2');
        } else {
            notie.alert({ type: 3, text: 'Debes ingresar tu apellido materno', position: 'bottom' });
            $('#last_name_2').css('border-color' , 'red');
            return false;
        }
        if($.trim($("#txtDate").val()) != "" ){
            if (validarFecha($("#txtDate").val())) {
                dataArray.push( {"fNaci" : $("#txtDate").val() } );
                $('#txtDate').css('border-color' , '#f2f2f2');
            }
            else {
                notie.alert({ type: 3, text: 'La fecha ingresada es inválida', position: 'bottom' });
                $('#txtDate').css('border-color' , 'red');
                return false;
            }
        } else {
            notie.alert({ type: 3, text: 'Debes ingresar tu fecha de nacimiento', position: 'bottom' });
            $('#txtDate').css('border-color' , 'red');
            return false;
        }
        if($.trim($("#sexo").val()) != "" ){
            dataArray.push( {"sexo" : $("#sexo").val()} );
            $('#sexo').css('border-color' , '#f2f2f2');
        } else {
            notie.alert({ type: 3, text: 'Debes ingresar tu sexo', position: 'bottom' });
            $('#sexo').css('border-color' , 'red');
            return false;
        }
        if($.trim($("#estado_civil").val()) != "" ){
            dataArray.push( {"eCivil" : $("#estado_civil").val()} );
            $('#estado_civil').css('border-color' , '#f2f2f2');
        } else {
            notie.alert({ type: 3, text: 'Debes ingresar tu estado civil', position: 'bottom' });
            $('#estado_civil').css('border-color' , 'red');
            return false;
        }
        if($.trim($("#nacionalidad").val()) != "" ){
            dataArray.push( {"nacionalidad" : $("#nacionalidad").val()} );
            $('#nacionalidad').css('border-color' , '#f2f2f2');
        } else {
            notie.alert({ type: 3, text: 'Debes ingresar tu nacionalidad', position: 'bottom' });
            $('#nacionalidad').css('border-color' , 'red');
            return false;
        }
        if($.trim($("#telefono").val()) != "" ){
            dataArray.push( {"telefono" : $("#telefono").val()} );
            $('#telefono').css('border-color' , '#f2f2f2');
        } else {
            notie.alert({ type: 3, text: 'Debes ingresar tu numero de teléfono', position: 'bottom' });
            $('#telefono').css('border-color' , 'red');
            return false;
        }
        if($.trim($("#telefono2").val()) != "" ){
            dataArray.push( {"telRec" : $("#telefono2").val()} );
        }
        if($.trim($("#email").val()) != "" ){
            if (validarEmail($("#email").val())) {
                dataArray.push( {"email" : $("#email").val()} );
                $('#email').css('border-color' , '#f2f2f2');
            } else {
                notie.alert({ type: 3, text: 'El email ingresado no es válido', position: 'bottom' });
                $('#email').css('border-color' , 'red');
                return false;
            }
        } else {
            notie.alert({ type: 3, text: 'Debes ingresar tu email', position: 'bottom' });
            $('#email').css('border-color' , 'red');
            return false;
        }
        if($.trim($("#region").val()) != "" ){
            dataArray.push( {"provi" : $("#region").val()} );
            $('#region').css('border-color' , '#f2f2f2');
        } else {
            notie.alert({ type: 3, text: 'Debes ingresar tu región', position: 'bottom' });
            $('#region').css('border-color' , 'red');
            return false;
        }
        if($.trim($("#comuna").val()) != "" ){
            dataArray.push( {"comuna" : $("#comuna").val()} );
            $('#comuna').css('border-color' , '#f2f2f2');
        } else {
            notie.alert({ type: 3, text: 'Debes ingresar tu comuna', position: 'bottom' });
            $('#comuna').css('border-color' , 'red');
            return false;
        }
        if($.trim($("#direccion").val()) != "" ){
            dataArray.push( {"direccion" : $("#direccion").val()} );
            $('#direccion').css('border-color' , '#f2f2f2');
        } else {
            notie.alert({ type: 3, text: 'Debes ingresar tu dirección', position: 'bottom' });
            $('#direccion').css('border-color' , 'red');
            return false;
        }
        return dataArray;
    }

    function getSecondPageDataPart1() {
        var dataArray = [];
        if($.trim($("#tipoEstudio").val()) != "" ){
            dataArray.push( {"tipoEstudio" : $("#tipoEstudio").val()} );
            $('#tipoEstudio').css('border-color' , '#f2f2f2');
        } else {
            notie.alert({ type: 3, text: 'Debes ingresar tipo de estudios', position: 'bottom' });
            $('#tipoEstudio').css('border-color' , 'red');
            return false;
        }
        if($('#tipoEstudio').val() != "Primario" && $('#tipoEstudio').val() != "Secundario"){
            if($.trim($("#carrera").val()) != "" ){
                dataArray.push( {"titulo" : $("#carrera").val()} );
                $('#carrera').css('border-color' , '#f2f2f2');
            } else {
                notie.alert({ type: 3, text: 'Debes ingresar Titulo de la carrera', position: 'bottom' });
                $('#carrera').css('border-color' , 'red');
                return false;
            }
        }
        if($.trim($("#estado_estudio").val()) != "" ){
            dataArray.push( {"estado_estudio" : $("#estado_estudio").val()} );
            if($.trim($("#estado_estudio").val()) == "En Curso" || $.trim($("#estado_estudio").val()) != "En Curso" && $.trim($("#fechaEstudio").val()) != "" ){
                dataArray.push( {"fecha_titulacion" : $("#fechaEstudio").val()} );
            } else {
                notie.alert({ type: 3, text: 'Debes ingresar fecha de titulación', position: 'bottom' });
                $('#txtDate2ftitulacion').css('border-color' , 'red');
                return false;
            }
        } else {
            notie.alert({ type: 3, text: 'Debes indicar el estado de tu carrera', position: 'bottom' });
            $('#estado_estudio').css('border-color' , 'red');
            return false;
        }
        if($.trim($("#semestres").val()) != "" ){
            dataArray.push( {"semestres" : $("#semestres").val()} );
        }
        if($.trim($("#licencia").val()) != "" ){
            dataArray.push( {"licencia" : $("#licencia").val()} );
        } else {
            notie.alert({ type: 3, text: 'Debes ingresar el tipo de licencia de conducir', position: 'bottom' });
            $('#licencia').css('border-color' , 'red');
            return false;
        } 
        return dataArray;
    }

    function getSecondPageDataPart2() {
        var dataArray = [];
        if($.trim($("#curso").val()) != "" ){
            if ($.trim($("#txtDate3").val()) != "") {
                dataArray.push( {"nombre" : $("#curso").val(), "fecha" : $("#txtDate3").val()} );
            } else {
                /* notie.alert({ type: 3, text: 'Debes ingresar la fecha de término del curso', position: 'bottom' });
                $('#txtDate3').css('border-color' , 'red');
                return false; */
            }
        }
        if($.trim($("#curso2").val()) != "" ){
            if ($.trim($("#txtDate3c2").val()) != "") {
                dataArray.push( {"nombre" : $("#curso2").val(), "fecha" : $("#txtDate3c2").val()} );
            } else {
                /* notie.alert({ type: 3, text: 'Debes ingresar la fecha de término del curso', position: 'bottom' });
                $('#txtDate3c2').css('border-color' , 'red');
                return false; */
            }
        }
        if($.trim($("#curso3").val()) != "" ){
            if ($.trim($("#txtDate3c3").val()) != "") {
                dataArray.push( {"nombre" : $("#curso3").val(), "fecha" : $("#txtDate3c3").val()} );
            } else {
                /* notie.alert({ type: 3, text: 'Debes ingresar la fecha de término del curso', position: 'bottom' });
                $('#txtDate3c3').css('border-color' , 'red');
                return false; */
            }
        }   
        return dataArray;
    }

    function getThirdPageData() {
        var dataArray = [];
        if($.trim($("#empresa").val()) != "" ){
            dataArray.push( {"empresa" : $("#empresa").val(), "cargo" : $("#cargo").val(), "fechaDesde" : $("#txtDate4").val(), "fechaHasta" : $("#txtDate4h").val()} );
        }
        if($.trim($("#empresa2").val()) != "" ){
            dataArray.push( {"empresa" : $("#empresa2").val(), "cargo" : $("#cargo2").val(), "fechaDesde" : $("#txtDate42").val(), "fechaHasta" : $("#txtDate42h").val()} );
        }
        if($.trim($("#empresa3").val()) != "" ){
            dataArray.push( {"empresa" : $("#empresa3").val(), "cargo" : $("#cargo3").val(), "fechaDesde" : $("#txtDate43").val(), "fechaHasta" : $("#txtDate43h").val()} );
        }
        if($.trim($("#experiencia").val()) != "" ){
            dataArray.push( {"experiencia" : $("#experiencia").val()} );
        }
        return dataArray;
    }

    function getFourthPageData() {
        var dataArray = [];
        if($.trim($("#empresaref").val()) != "" ){
            dataArray.push( {"empresa" : $("#empresaref").val(), "nombreContacto" : $("#contactoref").val(), "cargo" : $("#cargoref").val(), "telefono" : $("#telefonoref").val(), "email" : $("#emailref").val()} );
        }
        if($.trim($("#empresaref").val()) != "" ){
            dataArray.push( {"empresa" : $("#empresaref2").val(), "nombreContacto" : $("#contactoref2").val(), "cargo" : $("#cargoref2").val(), "telefono" : $("#telefonoref2").val(), "email" : $("#emailref2").val()} );
        }
        if($.trim($("#empresaref").val()) != "" ){
            dataArray.push( {"empresa" : $("#empresaref3").val(), "nombreContacto" : $("#contactoref3").val(), "cargo" : $("#cargoref3").val(), "telefono" : $("#telefonoref3").val(), "email" : $("#emailref3").val()} );
        }
        if($.trim($("#referencia_laboral").val()) != "" ){
            dataArray.push( {"referencia_laboral" : $("#referencia_laboral").val()} );
        }
        return dataArray;
    }

    function getFifthPageData() {
        var dataArray = [];
        if($.trim($("#afp").val()) != "" ){
            dataArray.push( {"afp" : $("#afp").val()} );
            $('#afp').css('border-color' , '#f2f2f2');
        } else {
            notie.alert({ type: 3, text: 'Debes elegir AFP', position: 'bottom' });
            $('#afp').css('border-color' , 'red');
            return false;
        }
        if($.trim($("#isapre").val()) != "" ){
            dataArray.push( {"isapre" : $("#isapre").val()} );
            $('#isapre').css('border-color' , '#f2f2f2');
        } else {
            notie.alert({ type: 3, text: 'Debes elegir tu previsión de salud', position: 'bottom' });
            $('#isapre').css('border-color' , 'red');
            return false;
        }
        if($.trim($("#comunas_disponibles").val()) != "" ){
            var comunas_str = $("#comunas_disponibles").val();
            var comunas_arr = comunas_str.split(";");
            for(var i=0; i<comunas_arr.length; i++) {
                if (comunas_arr[i] != "") {
                    var comuna = comunas_arr[i].split("/");
                    dataArray.push( {"region" : comuna[0], "comunas" : comuna[1]} );
                    $('#comunas').css('border-color' , '#f2f2f2');
                }
            }
        } else {
            notie.alert({ type: 3, text: 'Debes elegir comunas disponibles para trabajar', position: 'bottom' });
            $('#comunas').css('border-color' , 'red');
            return false;
        }
        if($.trim($("#dias").val()) != "" ){
            dataArray.push( {"dias" : $("#dias").val(), "horarios" : $("#id_label_multiple").val()+' a '+$("#id_label_multiple1").val()} );
            $('#dias').siblings('input').css('border-color' , '#f2f2f2');
            $('#id_label_multiple').siblings('input').css('border-color' , '#f2f2f2');
            $('#id_label_multiple1').siblings('input').css('border-color' , '#f2f2f2');
        } else {
            notie.alert({ type: 3, text: 'Debes elegir los dias y horarios disponibles para trabajar', position: 'bottom' });
            $('#dias').siblings('input').css('border-color' , 'red');
            $('#id_label_multiple').siblings('input').css('border-color' , 'red');
            $('#id_label_multiple1').siblings('input').css('border-color' , 'red');
            return false;
        }
        if($.trim($("#dias2").val()) != "" ){
            dataArray.push( {"dias" : $("#dias2").val(), "horarios" : $("#id_label_multiple2").val()+' a '+$("#id_label_multiple12").val()} );
            $('#dias').siblings('input').css('border-color' , '#f2f2f2');
        }
        if($.trim($("#dias3").val()) != "" ){
            dataArray.push( {"dias" : $("#dias3").val(), "horarios" : $("#id_label_multiple3").val()+' a '+$("#id_label_multiple13").val()} );
            $('#dias').siblings('input').css('border-color' , '#f2f2f2');
        }
        if($.trim($("#dias4").val()) != "" ){
            dataArray.push( {"dias" : $("#dias4").val(), "horarios" : $("#id_label_multiple4").val()+' a '+$("#id_label_multiple14").val()} );
            $('#dias').siblings('input').css('border-color' , '#f2f2f2');
        }
        if($.trim($("#dias5").val()) != "" ){
            dataArray.push( {"dias" : $("#dias5").val(), "horarios" : $("#id_label_multiple5").val()+' a '+$("#id_label_multiple15").val()} );
            $('#dias').siblings('input').css('border-color' , '#f2f2f2');
        }
        return dataArray;
    }

    function getSixthPageData() {
        var dataArray = [];
        if($.trim($("#uniforme").val()) != "" ){
            dataArray.push( {"uniforme" : $("#uniforme").val()} );
            $('#uniforme').css('border-color' , '#f2f2f2');
        } else {
            notie.alert({ type: 3, text: 'Ingresa tu talla de polera', position: 'bottom' });
            $('#uniforme').css('border-color' , 'red');
            return false;
        }
        if($.trim($("#uniforme2").val()) != "" ){
            dataArray.push( {"uniforme2" : $("#uniforme2").val()} );
            $('#uniforme2').css('border-color' , '#f2f2f2');
        } else {
            notie.alert({ type: 3, text: 'Ingresa tu talla de polerón', position: 'bottom' });
            $('#uniforme2').css('border-color' , 'red');
            return false;
        }
        if($.trim($("#tallaZapato").val()) != "" ){
            dataArray.push( {"tallaZapato" : $("#tallaZapato").val()} );
            $('#tallaZapato').css('border-color' , '#f2f2f2');
        } else {
            notie.alert({ type: 3, text: 'Ingresa tu talla de calzado', position: 'bottom' });
            $('#tallaZapato').css('border-color' , 'red');
            return false;
        }
        if($.trim($("#tallaPantalon").val()) != "" ){
            dataArray.push( {"tallaPantalon" : $("#tallaPantalon").val()} );
            $('#tallaPantalon').css('border-color' , '#f2f2f2');
        } else {
            notie.alert({ type: 3, text: 'Ingresa tu talla de pantalón', position: 'bottom' });
            $('#tallaPantalon').css('border-color' , 'red');
            return false;
        }
        if($.trim($("#renta").val()) != "" ){
            dataArray.push( {"renta" : $("#renta").val()} );
            $('#renta').css('border-color' , '#f2f2f2');
        } else {
            notie.alert({ type: 3, text: 'Debes ingresar tus pretenciones de renta', position: 'bottom' });
            $('#renta').css('border-color' , 'red');
            return false;
        }
        return dataArray;
    }

    $("form#selectionForm").submit(function(e){
        e.preventDefault();
        var chkArray = getSelectionFormData();
          
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
            data:{ action:"firstpagedata",data:chkArray,pid:pid },
            success:function(data){
                window.location.href="proceso.php";
                return false
            },
            error:function(){
            }
        })
        return false;
    })

    $("form#selectionChange").submit(function(e){
        e.preventDefault();
        var chkArray = getSelectionFormData();
          
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
            data:{ action:"firstpagedata",data:chkArray,pid:pid },
            success:function(data){
                window.location.href=window.location.search.substring(1);
                return false
            },
            error:function(){
            }
        })
        return false;
    })

    $("form#procesoform").submit(function(e){
        e.preventDefault();
        var chkArray = getFirstStepData();

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

        var chkArray = getSecondPageDataPart1();        
        var chkArray2 = getSecondPageDataPart2();

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
        var chkArray = getThirdPageData();

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
        var chkArray = getFourthPageData();

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
        var chkArray = getFifthPageData();
        var containerDataHoras = $('#containerDataHoras');
        var dias1Data = $('#diasData1');

        if ($(containerDataHoras).find(dias1Data).length < 1){
            notie.alert({ type: 3, text: 'Debes indicar horario disponible para trabajar', position: 'bottom' });
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
        var chkArray = getSixthPageData();

        /* we join the array separated by the comma */
        var selected;
        selected = chkArray.join(' , ') ;

        var JSONData={};            
        $.ajax({
            url : "processform.php",
            type: "post",
            data:{ action:"seventhpagedata",data:chkArray },
            success:function(data){
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

        if (!confirm("¿Seguro que quiere enviar su postulación? Esto puede tardar algún tiempo")) {
            return false;
        }

        $("#postularbutton").attr("disabled", true);
        
        var chkArray = [];
        chkArray["Datos"] = getFirstStepData();
        chkArray["Estudios"] = getSecondPageDataPart1();
        chkArray["Cursos"] = getSecondPageDataPart2();
        chkArray["Experiencia"] = getThirdPageData();
        chkArray["Referencia"] = getFourthPageData();
        chkArray["Horarios"] = getFifthPageData();
        chkArray["Documentos"] = getSixthPageData();

        /* we join the array separated by the comma */
        var selected;
        selected = chkArray.join(' , ');
        
        var JSONData={};
        $.ajax({
            url    : "processform.php",
            method : "post",
            data   : { action         :"lastpagedata", 
                       dataDatos      :chkArray["Datos"], 
                       dataEstudios   :chkArray["Estudios"], 
                       dataCursos     :chkArray["Cursos"], 
                       dataExperiencia:chkArray["Experiencia"], 
                       dataReferencia :chkArray["Referencia"], 
                       dataHorarios   :chkArray["Horarios"], 
                       dataDocumentos :chkArray["Documentos"] },
            success: function(data){
                window.location.href="gracias.php";
                return false
            },
            error  : function(){
            }
        })
        return false;
    })

    $("form#gracias").submit(function(e){
        e.preventDefault();

        alert("Gracias por contestar nuestra encuesta. Haga click en botón Ok para volver a postulaciones." );

        var chkArray = [];
        if($("#facebook").is(":checked")){
            chkArray.push({"medio" : "Facebook"});
        }
        if($("#laborum").is(":checked")){
            chkArray.push({"medio" : "Laborum"});
        }
        if($("#linkedin").is(":checked")){
            chkArray.push({"medio" : "Linkedin"});
        }
        if($("#computrabajo").is(":checked")){
            chkArray.push({"medio" : "Computrabajo"});
        }
        if($("#recomendacion").is(":checked")){
            chkArray.push({"medio" : "Recomendacion"});
        }
        if($("#otro").is(":checked")){
            chkArray.push({"medio" : "Otro"});
        }

        /* we join the array separated by the comma */
        var selected;
        selected = chkArray.join(' , ');
        
        var JSONData={};
        $.ajax({
            url    : "processform.php",
            method : "post",
            data   : { action : "graciaspage", 
                       data   : chkArray },
            success: function(data){
                window.location.href="index.php";
                return false
            },
            error  : function(){
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
            months        : ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            monthsShort   : ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            weekdays      : ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado' ],
            weekdaysShort : ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab' ],
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
    if($('#tipoEstudio').val() == 'Primario' || $('#tipoEstudio').val() == 'Secundario' ) {
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
        // console.log('Checked');
        $('#input-fecha-until').hide();
    } else {
        $('#input-fecha-until').show();
    }
});

$('#fechaCargo2').change(function() {
    if ($(this).is(':checked')) {
        // console.log('Checked');
        $('#input-fecha-until2').hide();
    } else {
        $('#input-fecha-until2').show();
    }
});

$('#fechaCargo3').change(function() {
    if ($(this).is(':checked')) {
        // console.log('Checked');
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
    } else {
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
    } else {
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
    } else {
        $(dataFecha2).html("Hasta: " + inputDate2);
    }
}

function elminarExp3(){
    $(inputExp3).addClass('input-not-active').removeClass('input-active');
    $(btnDeleteExp3).hide();
    $(boxDataExp3).hide();

    if ($(inputExp1).hasClass('input-not-active')){
        $(inputExp3).hide();
    } else if ($(inputExp2).hasClass('input-not-active')){
        $(inputExp3).hide();
    } else {
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
    } else if ($(containerHoras).find(inputDiaHora4).length > 0){
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
    // console.log("removed");
}

function removeAntecedentesPath(){
    $(antecedentesPath).val("");
    // console.log("removed");
}

function removeIdPath(){
    $(antecedentesPath).val("");
    // console.log("removed");
}

function removePicturePath(){
    $(antecedentesPath).val("");
    // console.log("removed");
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
