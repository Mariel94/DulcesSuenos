$(document).ready(function(){
  var cosa =JSON.parse(Cookies.get("productos"));

if(product != ""){
for(var i in cosa) {
     var imagen = cosa[i].imagen;
     var product = cosa[i].nombre;
     var price = cosa[i].precio;
$('#myShoppingCart').append("<tr><td>"
                + "<img class='wishlist' src='" 
                + imagen + "'/>"
                + "<td>" + product 
                + "<td class='prices'>$" + price 
                + "<td>" + "<div class='row'><div class='col s6'><input type='number' class='quantity validate valid'/></div>" 
                         + "<div class='col s6'><a class='calculate btn-floating waves-effect waves-light'><i class='material-icons'>forward</i></a></div></div>"
                + "<td class='total'>" 
                + "0</td></td></td></td></td></tr>");

   
}

$(".calculate").on("click", function(){ 
        var precio = $(this).parent().parent().parent().parent().find(".prices").text();
        var preAmount = $(this).parent().parent().find('.quantity').val();
        
        var amount = Number(preAmount);        var totalAmount = Number(precio.replace('$','')) * amount;
        $(this).parent().parent().parent().parent().find('.total').text(totalAmount);
        var sum = 0;

        $(".total").each(function() {
            var val = $.trim( $(this).text() );

        if ( val ) {
        val = parseFloat( val.replace( /^\$/, "" ) );

        sum += !isNaN( val ) ? val : 0;
    }
});
        $('#canTotal').text(sum);

});


$("#shop").on("click", function(){ 
    alert("Artículo Comprado");
    Cookies.remove("productos"); 
    window.location.replace("wishlist.html");

});
    }
function getCookie(cname) {
var name = cname + "=";
var decodedCookie = decodeURIComponent(document.cookie);
var ca = decodedCookie.split(';');
for(var i = 0; i <ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') {
        c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
    }
}
return "";
} 

function DeleteCookie(name){
  document.cookie = name +'=; expires=Thu, 01 Jan 1970 00:00:01 GMT; path=/FinalProject';
    return "";
}
    
});