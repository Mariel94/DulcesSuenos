$(document).ready(function(){
    var jsonToSend ={
        "action" : "MYPROFILE"
    };
    $.ajax({
        url : "data/applicationLayer.php",
        type: "POST",
        data : jsonToSend,
        dataType : "json",
        contentType : "application/x-www-form-urlencoded",
        success : function(jsonResponse){
            $("#profileTable").append("<tr><td id='us'>" + jsonResponse.username 
                                      + "<td id='fn'>" + jsonResponse.fName 
                                      + "<td id='ln'>" + jsonResponse.lName 
                                      + "<td id='em'>" + jsonResponse.email 
                                      + "<td>" + jsonResponse.gender 
                                      + "<td>" + jsonResponse.state 
                                      + "</td></td></td></td></td></td></tr>");
        },
        error : function(errorMessage){
            alert(errorMessage.responseText);
            $(location).attr('href',"logIn.html");
        }
    });
        
    $("#edit").on("click",function(){
        $("#editN").show();
        $("#editL").show();
        $("#editE").show();
        $("#editU").show();
    });
    
    $("#editN").on("click",function(){
        $("#editN").hide();
        $("#profileTable td#fn").empty();
        $("#profileTable td#fn").append("<input id='nameText' type='text-box'/>");
        $("#saveN").show();
    });
    $("#editL").on("click",function(){
        $("#editL").hide();
        $("#profileTable td#ln").empty();
        $("#profileTable td#ln").append("<input id='lastNameText' type='text-box'/>");
        $("#saveL").show();
    });
    $("#editE").on("click",function(){
        $("#editE").hide();
        $("#profileTable td#em").empty();
        $("#profileTable td#em").append("<input id='emailText' type='text-box'/>");
        $("#saveE").show();
    });
    $("#editU").on("click",function(){
        $("#editU").hide();
        $("#profileTable td#us").empty();
        $("#profileTable td#us").append("<input id='usernameText' type='text-box'/>");
        $("#saveU").show();
    });
    $("#saveN").on("click",function(){
        var jsonToSend ={
            "action" : "EDITNAME",
            "name" : $("#nameText").val()
        };
        
        $.ajax({
                  type: "POST",
                  url: "data/applicationLayer.php",
                  data : jsonToSend,
                  dataType : "json",
                  contentType : "application/x-www-form-urlencoded",
                  success: function(jsonResponse) {
                    window.location.replace("wishlist.html");
                 },
                error: function(errorMsg){
                    alert(errorMsg.statusText);
                }
        });     
    });
    $("#saveL").on("click",function(){
        var jsonToSend ={
            "action" : "EDITLASTNAME",
            "lastName" : $("#lastNameText").val()
        };
        
        $.ajax({
                  type: "POST",
                  url: "data/applicationLayer.php",
                  data : jsonToSend,
                  dataType : "json",
                  contentType : "application/x-www-form-urlencoded",
                  success: function(jsonResponse) {
                    window.location.replace("wishlist.html");
                 },
                error: function(errorMsg){
                    alert(errorMsg.statusText);
                }
        });     
    });
    $("#saveE").on("click",function(){
        var jsonToSend ={
            "action" : "EDITEMAIL",
            "emailText" : $("#emailText").val()
        };
        
        $.ajax({
                  type: "POST",
                  url: "data/applicationLayer.php",
                  data : jsonToSend,
                  dataType : "json",
                  contentType : "application/x-www-form-urlencoded",
                  success: function(jsonResponse) {
                    window.location.replace("wishlist.html");
                 },
                error: function(errorMsg){
                    alert(errorMsg.statusText);
                }
        });     
    });
    $("#saveU").on("click",function(){
        var jsonToSend ={
            "action" : "EDITUSER",
            "usernameText" : $("#usernameText").val()
        };
        
        $.ajax({
                  type: "POST",
                  url: "data/applicationLayer.php",
                  data : jsonToSend,
                  dataType : "json",
                  contentType : "application/x-www-form-urlencoded",
                  success: function(jsonResponse) {
                    window.location.replace("wishlist.html");
                 },
                error: function(errorMsg){
                    alert(errorMsg.statusText);
                }
        });     
    });
    $("#delete").on("click",function(){
        var jsonToSend ={
            "action" : "DELETEUSER"
        };
        
        $.ajax({
                  type: "POST",
                  url: "data/applicationLayer.php",
                  data : jsonToSend,
                  dataType : "json",
                  contentType : "application/x-www-form-urlencoded",
                  success: function(jsonResponse) {
                      window.location.replace("logIn.html");
                 },
                error: function(errorMsg){
                    alert(errorMsg.statusText);
                }
        });     
    }); 
    ///////////////////////////////////////////////////////////////////////
    
    var jsonToSend ={
        "action" : "DISPLAYWISHLIST"
    };
    $.ajax({
        url : "data/applicationLayer.php",
        type: "POST",
        data : jsonToSend,
        dataType : "json",
        contentType : "application/x-www-form-urlencoded",
        success : function(jsonResponse){
            for(var i=0; i<jsonResponse.length; i++){
                $("#wishTable").append("<tr><td>" 
                + "<img class='wishlist' src='" 
                + jsonResponse[i].Imagen + "'/>" 
                + "<td>" + jsonResponse[i].Nombre 
                + "<td>" + jsonResponse[i].Descripcion
                + "<td>" + jsonResponse[i].Precio 
                + "<td> <div class='row'><div class='col s3'><a class='btn-floating waves-effect waves-light'><span class='idval1' style='display:none'>"+jsonResponse[i].ID+"</span><i class='buy material-icons'>shopping_cart</i></a></div><div class='col s3'> <a class='btn-floating waves-effect waves-light red'><span class='idval' style='display:none'>"+jsonResponse[i].ID+"</span><i class='eliminar material-icons'>delete</i></a></div></div>" 
                + "</td></td></td></td></td></tr>");
            }
            $(".eliminar").on("click", function(){  
                var idArticulo = $(this).siblings('span').text(); 
                 eliminarWishlist(idArticulo);
                 this.disable=true;
            });
            $(".buy").on("click", function(){  
                var idArticulo = $(this).siblings('span').text();
                comprarProducto(idArticulo);
                this.disable=true;
            });
        }
    });
    
    function eliminarWishlist(idArticulo){
        var jsonToSend={
            "action" : "DELETEFROMWISHLIST",
            "idArticle" : idArticulo
        };
    $.ajax({
        url : "data/applicationLayer.php",
        type : "POST",
        data : jsonToSend,
        dataType : "json",
        contentType : "application/x-www-form-urlencoded",
        success : function(jsonResponse){
            window.location.replace("wishlist.html");
        }
       
    });  
    }
    
    function comprarProducto(idArticulo){
        var jsonToSend={
            "action" : "BUYPRODUCT",
            "idArticle" : idArticulo
        };
    $.ajax({
        url : "data/applicationLayer.php",
        type : "POST",
        data : jsonToSend,
        dataType : "json",
        contentType : "application/x-www-form-urlencoded",
        success : function(jsonResponse){
            var productosCookie=Cookies.get("productos");
            var productos = [{ 
                    'id': idArticulo,
                    'imagen' : jsonResponse.Imagen, 
                    'nombre' : jsonResponse.Nombre, 
                    'precio' : jsonResponse.Precio
            }];
            if (typeof productosCookie != 'undefined' ){
               var productos = {
                    'id': idArticulo,
                    'imagen' : jsonResponse.Imagen, 
                    'nombre' : jsonResponse.Nombre, 
                    'precio' : jsonResponse.Precio
              };
              productosCookie=JSON.parse(productosCookie);
              productosCookie.push(productos);
              productos=productosCookie;
            }
            
            Cookies.set('productos',productos);
            //document.cookie = "imagen"+idArticulo+"="+jsonResponse.Imagen;
            //document.cookie = "nombre"+idArticulo+"="+jsonResponse.Nombre;
            //document.cookie = "precio"+idArticulo+"="+jsonResponse.Precio; 
            //Cookies.set('mydata', {foo:"bar",baz:1});

            window.location.replace("cart.html");
        } 
    });  
    }
    
});