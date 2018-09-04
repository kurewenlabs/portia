$(function() {
     $('input.a').setCursor();

     $('button.a').click(function(){
        $('input.a').setCursor({start:true});
     })

      $('button.b').click(function(){
        $('input.a').setCursor({last:true});
     })

      $('button.c').click(function(){
        $('input.a').setCursor({select:true});
     })
      $('button.d').click(function(){
        $('input.a').setCursor({after:2});
     })
})