$(document).ready(function(){
    var ID = getUrlVars()["id"];
    
    var jsonToSend ={
        "action" : "PRODUCTINFORMATION",
         "ID" : ID

    };

    $.ajax({
        url : "data/applicationLayer.php",
        type : "POST",
        data : jsonToSend,
        dataType : "json",
        contentType : "application/x-www-form-urlencoded",
        success : function(jsonResponse){
            $("#nombreProducto").append(jsonResponse.Nombre);
            $("#descripcionProducto").append("<h5 class='purple-text'>Descripción</h5><span class='info'>"+jsonResponse.Descripcion+"</span>");
            $("#contieneProducto").append("<br/><h5 class='purple-text'>Contiene</h5><span class='info'>"+jsonResponse.Contiene+"</span>");
            $("#medidaProducto").append("<br/><h5 class='purple-text'>Medidas</h5><span class='info'>"+jsonResponse.Medidas+"</span>");
            $("#composicionProducto").append("<br/><h5 class='purple-text'>Composición</h5><span class='info'>"+jsonResponse.Composicion+"</span>");
            $("#precioProducto").append("<br/><h5 class='purple-text'>Precio</h5><span class='info'>"+jsonResponse.Precio+"</span>");
            $("#picture").append("<img class='responsive-img' src='" 
                + jsonResponse.Imagen + "'/>");
            
        },
        error : function(errorMessage){
            alert(errorMessage.responseText);
        }
    });
    
function getUrlVars() {
var vars = {};
var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
vars[key] = value;
});
return vars;
}
    
});
