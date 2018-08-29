function aMayusculas(obj,id){
    obj = obj.toUpperCase();
    document.getElementById(id).value = obj;
}


function validarEmail(valor) {
if (/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{1,3})$/.test(valor)){
   return true;
  } else {
        notie.alert({ type: 3, text: 'Formato Inválido:: el formato: casilla@buzon.cl ', position: 'bottom' });
        $('#email').css('border-color' , 'red');
        return false;
  }
}




   function esfechavalida(fecha) {
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
        return false;
      }
      else
      return true;
   }

    function esfechavalida2(fecha) {
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
        return false;
      }
      else
      return true;
   }
   
   
    function EsRut(texto)
    {   
       var tmpstr = "";   
       for ( i=0; i < texto.length ; i++ )      
          if ( texto.charAt(i) != ' ' && texto.charAt(i) != '.' && texto.charAt(i) != '-' )
             tmpstr = tmpstr + texto.charAt(i);   
       texto = tmpstr;   
       largo = texto.length;   

       if ( largo < 2 )   
       {      
          return false;   
       }   

       for (i=0; i < largo ; i++ )   
       {         
          if ( texto.charAt(i) !="0" && texto.charAt(i) != "1" && texto.charAt(i) !="2" && texto.charAt(i) != "3" && texto.charAt(i) != "4" && texto.charAt(i) !="5" && texto.charAt(i) != "6" && texto.charAt(i) != "7" && texto.charAt(i) !="8" && texto.charAt(i) != "9" && texto.charAt(i) !="k" && texto.charAt(i) != "K" )
          {         
             return false;      
          }   
       }   

       var invertido = "";   
       for ( i=(largo-1),j=0; i>=0; i--,j++ )      
          invertido = invertido + texto.charAt(i);   
       var dtexto = "";   
       dtexto = dtexto + invertido.charAt(0);   
       dtexto = dtexto + '-';   
       cnt = 0;   

       for ( i=1,j=2; i<largo; i++,j++ )   
       {      
          if ( cnt == 3 )      
          {         
             dtexto = dtexto + '.';         
             j++;         
             dtexto = dtexto + invertido.charAt(i);         
             cnt = 1;      
          }      
          else      
          {            
             dtexto = dtexto + invertido.charAt(i);         
             cnt++;      
          }   
       }   

       invertido = "";   
       for ( i=(dtexto.length-1),j=0; i>=0; i--,j++ )      
          invertido = invertido + dtexto.charAt(i);   

       if ( revisarDigito(texto) )      
          return true;   

       return false;
    }

    function revisarDigito(componente)
    {   
       var crut =  componente
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
          return 0   

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
          return false   
       }

       return true
    }

function esrut(rut){

	if (EsRut(rut)==false){
		notie.alert({ type: 3, text: 'El RUT no es válido ', position: 'bottom' });
        $('#txtDate').css('border-color' , 'red');
	}else{
		if (rut.length==9){
			var la=rut.substring(0,8);
			var digito=rut.charAt(8);
		}else{
			var la=rut.substring(0,8);
			var digito=rut.charAt(9);
		}
	}
}