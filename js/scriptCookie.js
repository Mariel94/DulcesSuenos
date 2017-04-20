$(document).ready(function(){
    var jsonToSend ={
        "action" : "COOKIE"
    };
    $.ajax({
        url : "data/applicationLayer.php",
        type : "POST",
        data: jsonToSend,
        dataType : "json",
        success : function(jsonResponse){
            $("#userName").val(jsonResponse.cookieUserN);
        }
    });
});