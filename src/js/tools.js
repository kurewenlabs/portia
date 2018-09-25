  function toUppercase(obj, id){
      obj = obj.toUpperCase();
      document.getElementById(id).value = obj;
  }


  function validarEmail(valor) {
    return true;
    if (/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{1,3})$/.test(valor)){
      return true;
    } else {
          notie.alert({ type: 3, text: 'Formato Inválido:: el formato: casilla@buzon.cl ', position: 'bottom' });
          $('#email').css('border-color' , 'red');
          return false;
    }
  }

  function esfechavalida(fecha) {
    return true;

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

  function esfechavalida2(fecha) {
    return true;

    // La longitud de la fecha debe tener exactamente 10 caracteres
    if ( fecha.length !== 7 )
        error = true;

    // Primero verifica el patron
    if ( !/^\d{1,2}\/\d{4}$/.test(fecha) )
        error = true;

    // Mediante el delimitador "/" separa dia, mes y año
    var fecha = fecha.split("/");
    var month = parseInt(fecha[1]);
    var year = parseInt(fecha[2]);

    // Verifica que mes, año, solo sean numeros
    error = ( isNaN(month) || isNaN(year) );

    if ( error === true ) {
      notie.alert({ type: 3, text: 'Fecha Inválida: el formato: mm/aaaa (mes/año) ', position: 'bottom' });
      $('#txtDate').css('border-color' , 'red');
      return false;
    }
    else
      return true;
  }  
   
  function validaRUT(valor)
  {   
    return true;
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
    return true;
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

  function esRUT(campo){
    return true;

    var id = campo.id;
    var rut = campo.value;
    if (validaRUT(rut)==false){
      notie.alert({ type: 3, text: 'El RUT ingresado no es válido. El formato debe ser 12.345.678-9', position: 'bottom' });
      $('#' + id).css('border-color' , 'red');
      $('#' + id).focus();
      // $('#' + id).setCursor({start:true});
    }
    else {
      $('#' + id).css('border-color' , 'green');
    }
  }

  function actualizaCargo(id, postula) {
    cargo = $('input[name="cargo"]:checked').val();
    url = 'process_editar.php?identificador=' + id + '&postulacion=' + postula + '&pagina=actualizar_cargo&cargo=' + cargo;
    window.location.href=url;
  }