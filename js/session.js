$(document).ready(function(){
    var jsonToSend ={
        "action" : "SESSION"
    };
    $.ajax({
        url : "data/applicationLayer.php",
        type: "POST",
        data : jsonToSend,
        dataType : "json",
        contentType : "application/x-www-form-urlencoded",
        success : function(jsonResponse){
            $("#usershow").append( "¡Bienvenid@ "+ jsonResponse.username + "!");
            $("#logout").show();
            $("#log").hide();
            $(document).ajaxStop(function(){
                $( '.cora' ).show();
                 
            });
    ////////////////////////////////////////////////
           if(jsonResponse.username == "admin"){
               $("#admin").show();
               $("#wish").hide();
               $("#cart").hide();
               $("#adminFooter").hide();
               $(document).ajaxStop(function(){
                   $(".idval").show();   
                   $( '.cora' ).hide();
               });
           }
        }
    });
      
});