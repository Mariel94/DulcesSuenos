$(document).ready(function(){
    var jsonToSend ={
        "action" : "MYUSERS"
    };
    $.ajax({
        url : "data/applicationLayer.php",
        type: "POST",
        data : jsonToSend,
        dataType : "json",
        contentType : "application/x-www-form-urlencoded",
        success : function(jsonResponse){
            for(var i=0; i<jsonResponse.length; i++){
            $("#usersTable").append("<tr><td>" 
                                    + jsonResponse[i].username + "<td>" 
                                    + jsonResponse[i].fName + "<td>" 
                                    + jsonResponse[i].lName + "<td>" 
                                    + jsonResponse[i].email + "<td>" 
                                    + jsonResponse[i].gender+ "<td>" 
                                    + jsonResponse[i].state + "</td></td></td></td></td></td></tr>");
            }
        }
    });
    
    $("#deleteUser").on("click", function(){    
        var jsonToSend ={
            "action" : "DELETESPECIFICUSER",
            "userToDelete" : $("#userDelete").val()
        };
        $.ajax({
            url : "data/applicationLayer.php",
            type : "POST",
            data : jsonToSend,
            dataType : "json",
            contentType : "application/x-www-form-urlencoded",
            success : function(jsonResponse){
                if($("#userDelete").val()=="admin")
                    alert(jsonResponse.message);
                window.location.replace("admin.html");
            },
            error : function(errorMessage){
                alert(errorMessage.responseText);
            }
        });
    });
    
    $("#deleteFromInventory").on("click", function(){    
        var jsonToSend ={
            "action" : "DELETEINVENTORY",
            "deleteInventory" : $("#deleteIDInventory").val()
        };
        $.ajax({
            url : "data/applicationLayer.php",
            type : "POST",
            data : jsonToSend,
            dataType : "json",
            contentType : "application/x-www-form-urlencoded",
            success : function(jsonResponse){
                alert("Artículo Eliminado");
            }
        });
    });
    //////TERMINAR !!! APP Y DATA!!!!
     $('select').material_select();
     $('#category').on('change',function() {
        var selectedList = $(this).val();
        if(selectedList == "1"){
            $("#subcat1").show();
            $("#subcat2").hide();
            $("#subcat3").hide();
            $("#subcat4").hide();
            $("#subcat5").hide();
        }
        else if(selectedList == "2"){
            $("#subcat1").hide();
            $("#subcat2").show();
            $("#subcat3").hide();
            $("#subcat4").hide();
            $("#subcat5").hide();
            
        }
        else if(selectedList == "3"){
            $("#subcat1").hide();
            $("#subcat2").hide();
            $("#subcat3").show();
            $("#subcat4").hide();
            $("#subcat5").hide();
            
        }
        else if(selectedList == "4"){
            $("#subcat1").hide();
            $("#subcat2").hide();
            $("#subcat3").hide();
            $("#subcat4").show();
            $("#subcat5").hide();
            
        }
        else if(selectedList == "5"){
            $("#subcat1").hide();
            $("#subcat2").hide();
            $("#subcat3").hide();
            $("#subcat4").hide();
            $("#subcat5").show();
            
        }
    });

    $("#addArticle").on("click", function(){   
    
   // $('select').material_select();
    //$('#category').on('change',function() {
      //  var selectedList = $(this).val();
     //});
        
        
        if($("#category option:selected").val()=="1"){
            $temp_subcategoria = $("#subcategory1 option:selected").text();
        }
        else if($("#category option:selected").val()=="2"){
            $temp_subcategoria = $("#subcategory2 option:selected").text();
        }
        else if($("#category option:selected").val()=="3"){
            $temp_subcategoria = $("#subcategory3 option:selected").text();
        }
        else if($("#category option:selected").val()=="4"){
            $temp_subcategoria = $("#subcategory4 option:selected").text();
        }
        else if($("#category option:selected").val()=="5"){
            $temp_subcategoria = $("#subcategory5 option:selected").text();
        }
        var jsonToSend ={
            "action" : "ADDINVENTORY",
            "category" : $("#category option:selected").text(),
            "subcategory" : $temp_subcategoria,
            "nameInventory" : $("#nameArticle").val(),
            "priceInventory": $("#priceArticle").val(),
            "description": $("#description").val(),
            "contains":$("#contains").val(),
            "compose":$("#size").val(),
            "size":$("#size").val(),
            "newPic":$("#newPic").val()
        };
        $.ajax({
            url : "data/applicationLayer.php",
            type : "POST",
            data : jsonToSend,
            dataType : "json",
            contentType : "application/x-www-form-urlencoded",
            success : function(jsonResponse){
                alert("Articulo agregado exitosamente");
            }
        });
    });
	//////////////////////////////////////Cuenta de Admin
    
    var jsonToSend ={
        "action" : "MYADMINPROFILE"
    };
    $.ajax({
        url : "data/applicationLayer.php",
        type: "POST",
        data : jsonToSend,
        dataType : "json",
        contentType : "application/x-www-form-urlencoded",
        success : function(jsonResponse){
            $("#adminTable").append("<tr><td id='usa'>" + jsonResponse.username 
                                      + "<td id='fna'>" + jsonResponse.fName 
                                      + "<td id='lna'>" + jsonResponse.lName 
                                      + "<td id='ema'>" + jsonResponse.email 
                                      + "<td>" + jsonResponse.gender 
                                      + "<td>" + jsonResponse.state 
                                      + "</td></td></td></td></td></td></tr>");
        }
    });
    
    $("#editNA").on("click",function(){
        $("#editNA").hide();
        $("#adminTable td#fna").empty();
        $("#adminTable td#fna").append("<input id='nameAdminText' type='text-box'/>");
        $("#saveNA").show();
    });
    $("#editLA").on("click",function(){
        $("#editLA").hide();
        $("#adminTable td#lna").empty();
        $("#adminTable td#lna").append("<input id='lastNameAdminText' type='text-box'/>");
        $("#saveLA").show();
    });
    $("#editEA").on("click",function(){
        $("#editEA").hide();
        $("#adminTable td#ema").empty();
        $("#adminTable td#ema").append("<input id='emailAdminText' type='text-box'/>");
        $("#saveEA").show();
    });
    $("#saveNA").on("click",function(){
        var jsonToSend ={
            "action" : "EDITADMINNAME",
            "nameA" : $("#nameAdminText").val()
        };
        
        $.ajax({
              type: "POST",
              url: "data/applicationLayer.php",
              data : jsonToSend,
              dataType : "json",
              contentType : "application/x-www-form-urlencoded",
              success: function(jsonResponse) {
                window.location.replace("admin.html");
             },
            error: function(errorMsg){
                alert(errorMsg.statusText);
            }
        });     
    });
    $("#saveLA").on("click",function(){
        var jsonToSend ={
            "action" : "EDITADMINLASTNAME",
            "lastNameA" : $("#lastNameAdminText").val()
        };
        
        $.ajax({
              type: "POST",
              url: "data/applicationLayer.php",
              data : jsonToSend,
              dataType : "json",
              contentType : "application/x-www-form-urlencoded",
              success: function(jsonResponse) {
                window.location.replace("admin.html");
             },
            error: function(errorMsg){
                alert(errorMsg.statusText);
            }
        });     
    });
    $("#saveEA").on("click",function(){
        var jsonToSend ={
            "action" : "EDITADMINEMAIL",
            "emailTextA" : $("#emailAdminText").val()
        };
        
        $.ajax({
              type: "POST",
              url: "data/applicationLayer.php",
              data : jsonToSend,
              dataType : "json",
              contentType : "application/x-www-form-urlencoded",
              success: function(jsonResponse) {
                window.location.replace("admin.html");
             },
            error: function(errorMsg){
                alert(errorMsg.statusText);
            }
        });     
    });
   
});