$(document).ready(function(){
    $('.carousel.carousel-slider').carousel({fullWidth: true});
    $(".dropdown-button").dropdown(
       { hover: true,
         belowOrigin: true}
    );   
    
    $('select').material_select();
    $.ajax({
        url: "data/mexicanStates.json",
        type: "GET",
        dataType: "json",
        success: function(data){
            $.each(data, function(id, value){
                $("#country").append(
                $("<option </option>").val(value.state).html(value.state));
            }); 
            $("#country").material_select();
        }
    });
    
//------------------------------------------------------

    $("#logIn").on("click", function(){
        var $userNameL = $("#userName");
        var $passwordL = $("#passW");

        inputValidator($userNameL, "Teclea tu nombre de usuario", $("#errorLabelUserName"));
        inputValidator($passwordL, "Teclea tu contraseña", $("#errorLabelPassword"));

        var jsonToSend ={
            "action" : "LOGIN",
            "username" : $("#userName").val(),
            "userPassword" : $("#passW").val(),
            "remember" : $("#filled-in-box").is(":checked")
        };
        $.ajax({
            url : "data/applicationLayer.php",
            type : "POST",
            data : jsonToSend,
            dataType : "json",
            contentType : "application/x-www-form-urlencoded",
            success : function(jsonResponse){
                window.location.replace("index.html");
            },
            error : function(errorMessage){
                alert(errorMessage.responseText);
            }
        });
    });
    
	$("#logout").on("click",function(){
        var jsonToSend ={
            "action" : "LOGOUT"
        };
        $.ajax({
            url : "data/applicationLayer.php",
            data : jsonToSend,
            type : "POST",
            dataType : "json",
            contentType : "application/x-www-form-urlencoded",
            success : function(jsonResponse){   
                $(location).attr('href',"logIn.html");
            },
            error : function(errorMessage){
                alert(errorMessage.responseText);
            }
        });
	});
    $("#submitButton").on("click", function(){	
		var $FN = $("#userFirstName");
		var $LN = $("#userLastName");
		var $USR = $("#userNameR");
		var $email = $("#userEmail");
		var $passwordR = $("#userPassword");
		var $passwordConfirmR = $("#userPasswordConfirmation");
		var $genderF = $("#genderFemale");
		var $genderM = $("#genderMale");
		var $country = $("#country");
		
		// Validating the first name input	
		inputValidator($FN, "Teclea tu nombre", $("#errorLabelFirstName"));	
		
		// Validating the last name input	
		inputValidator($LN, "Teclea tu primer apellido", $("#errorLabelLastName"));	
		
		// Validating the username input	
		inputValidator($USR, "Teclea tu nombre de usuario", $("#errorLabelUser"));	
		
		// Validating the email input
		inputValidator($email, "Teclea tu correo electrónico", $("#errorLabelEmail"));

		// Validating the password inputs
		inputValidator($passwordR, "Teclea tu contraseña", $("#errorLabelPassword2"));

		// Validating that the passwords are the same
		if ($passwordR.val() != $passwordConfirmR.val()){
			$("#errorLabelPasswordMatch").show();
		}
		else{
			$("#errorLabelPasswordMatch").hide();
		}

		// Validating that a country has been selected
		if ($("#country option:selected").val() == 0){
			$("#errorLabelCountry").text("Seleccione un Estado");
		}
		else{
			$("#errorLabelCountry").text("");
		}

		// Validating the gender radio buttons
		if ($("#genderMale").is(":checked") || $("#genderFemale").is(":checked")){
			$("#errorLabelGender").text("");
		}
		else{
			$("#errorLabelGender").text("Seleccione su género");
		}

	if($FN.val()!="" && $LN.val()!="" && $USR.val()!="" && $email.val()!="" && $passwordR.val()!="" && $passwordConfirmR.val() != "" && ($passwordR.val()== $passwordConfirmR.val())&&($("#genderMale").is(":checked") || $("#genderFemale").is(":checked"))&&($("#country option:selected").val() != 0)){
        var jsonObject = {
                    "action"   : "REGISTER",
                    "username" : $("#userNameR").val(),
                    "userPassword" : $("#userPassword").val(),
                    "userFirstName" : $("#userFirstName").val(),
                    "userLastName" : $("#userLastName").val(),
                    "userEmail" : $("#userEmail").val(),
                    "gender" : $('input[name=gender]:checked').val(),
                    "country" : $("#country option:selected").text()
        };
        $.ajax({
                  type: "POST",
                  url: "data/applicationLayer.php",
                  data : jsonObject,
                  dataType : "json",
                  contentType : "application/x-www-form-urlencoded",
                  success: function(jsonData) {
                      window.location.replace("index.html");    
                 },
                error: function(errorMsg){
                    alert(errorMsg.statusText);
                }
        });    
    } 
    });
    
    function inputValidator($currentElement, displayMessage, $targetSpan){
        if ($currentElement.val() == ""){
            $targetSpan.text(displayMessage);
        }
        else{
            $targetSpan.text("");
        }
    }    
});