<?php

header('Content-type: application/json');
require_once __DIR__ . '/dataLayer.php';

$action = $_POST["action"];
$subcategoria = $_POST["subcategoria"];

switch($action){
	case "LOGIN" : loginFunction();
        break;
    case "REGISTER" : registerFunction();
        break;
    case "COOKIE" : cookieFunction();
        break;
    case "LOGOUT" : logoutFunction();
        break;
    case "MYPROFILE" : myProfileFunction();
        break;
    case "SESSION" : sessionFunction();
        break;
    case "PRODUCTSBLANCOS" : productsBlancosFunction($subcategoria);
        break;
    case "PRODUCTINFORMATION" : 
    productInfoFunction();
        break;
    case "EDITNAME" : 
    editNameFunction();
        break;
    case "EDITLASTNAME" :
    editLastNameFunction();
        break;
    case "EDITEMAIL" :
    editEmailFunction();
        break;
    case "EDITUSER" :
    editUsernameFunction();
        break;
    case "DELETEUSER" :
    deleteUserFunction();
        break;
    case "INSERTTOWISHLIST":
    inserToWishlistFunction();
        break;
    case "DISPLAYWISHLIST":
    displayWishlistFunction();
        break;
    case "DELETEFROMWISHLIST":
    deleteFromWishlistFunction();
        break;
    case "BUYPRODUCT":
    buyProductFunction();
        break;
    case "MYUSERS"://///
    displayMyUsersFunction();
        break;
    case "DELETESPECIFICUSER"://///
    deleteSpecificUserFunction();
        break;
    case "DELETEINVENTORY":
    deleteInventoryFunction();
        break;
    case "ADDINVENTORY":
    addInventoryFunction();
        break;
    case "MYADMINPROFILE": 
    myAdminFunction();
        break;
    case "EDITADMINNAME" : 
    editAdminNameFunction();
        break;
    case "EDITADMINLASTNAME" :
    editAdminLastNameFunction();
        break;
    case "EDITADMINEMAIL" :
    editAdminEmailFunction();
        break;
}

function loginFunction(){
    $userName = $_POST['username'];
    $userRemember = $_POST['remember'];

	$result = attemptLogin($userName);

	if ($result["status"] == "SUCCESS"){
        $decryptedPassword = decryptPassword($result['password']);
        $password = $_POST['userPassword'];
        if ($decryptedPassword === $password)
        {	
            startSession($userName);
            if($userRemember == "true"){
                setcookie("cookieUserN", $userName,time()+3600 * 24 * 30);
            }
            echo json_encode(array("message" => "SUCCESS"));
        }
        else{
            header('HTTP/1.1 306 Wrong credentials');
            die("Usuario no encontrado");
        }
	}	
	else{
		header('HTTP/1.1 500' . $result["status"]);
		die($result["status"]);
	}	
}
function registerFunction(){
    $userName = $_POST['username'];
    
    $resultName = usernameDupplication($userName);
    
    if ($resultName["status"] == "SUCCESS"){
       
        $userFirstName = $_POST['userFirstName'];
        $userLastName = $_POST['userLastName'];
        $userEmail = $_POST['userEmail'];
        $userGender = $_POST['gender'];
        $userCountry = $_POST['country'];
        
        $userPassword = encryptPassword();

		
        $register = attemptRegister($userName, $userPassword, $userFirstName, $userLastName, $userEmail, $userGender, $userCountry);
        
        if($register["status2"] == "SUCCESS"){
          startSession($userName);
          echo json_encode(array("message" => "Nuevo usuario registrado"));  
        }
        else{
		  header('HTTP/1.1 500' . $result["status2"]);
		  die($result["status2"]);
        }
	}	
	else{
		header('HTTP/1.1 500' . $result["status"]);
		die($result["status"]);
	}	
}
function cookieFunction(){
	if (isset($_COOKIE['cookieUserN']))
	{
		$response = array('cookieUserN' => $_COOKIE['cookieUserN']); 
            echo json_encode($response);
    }
    else{
        header('HTTP/1.1 406 Cookie not set yet.');
	    die("¡Bienvenido!");
    }
}
function logoutFunction(){
    session_start();
    
    if (isset($_SESSION['username']))
    {
        unset($_SESSION['username']);
        session_destroy();
        echo json_encode(array("message" => "Session deleted"));
    }
    else{
        header('No has iniciado sesión');
	    die("No has iniciado sesión");
    }
}
function decryptPassword($password){
    $key = pack('H*', "bcb04b7e103a05afe34763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3");

    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);

    $ciphertext_dec = base64_decode($password);
    $iv_dec = substr($ciphertext_dec, 0, $iv_size);
    $ciphertext_dec = substr($ciphertext_dec, $iv_size);

    $password = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $ciphertext_dec, MCRYPT_MODE_CBC, $iv_dec);


    $count = 0;
    $length = strlen($password);

    for ($i = $length - 1; $i >= 0; $i --)
    {
        if (ord($password{$i}) === 0)
        {
            $count ++;
        }
    }

    $password = substr($password, 0,  $length - $count); 

    return $password;
}
function encryptPassword(){
    $userPassword = $_POST['userPassword'];

	$key = pack('H*', "bcb04b7e103a05afe34763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3");
	$key_size =  strlen($key);
	    
    $plaintext = $userPassword;

	$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
	$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
	    
	$ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $plaintext, MCRYPT_MODE_CBC, $iv);
	$ciphertext = $iv . $ciphertext;
	    
	$userPassword = base64_encode($ciphertext);

	return $userPassword;
}
function myProfileFunction(){

	$result = attemptmyProfile();

	if($result["status"]!= "Favor de iniciar sesión"){
            echo json_encode($result);
    }
    else{
        header('HTTP/1.1 500' . $result["status"]);
        die($result["status"]);
        }	   
}
function startSession($username){
    // Starting the session
    session_start();
    $_SESSION['username'] = $username;
}
function sessionFunction(){
    // Starting the session
    session_start();
    if(empty($_SESSION)){
        $var=1;
    }else{
        $username=$_SESSION['username'];
        echo json_encode(array("username" => $username));
    }
    
}
function productsBlancosFunction($subcategoria){
    $result = attemptProductsBlancos($subcategoria);
        if ($result["status"] != "Bad connection"){
            echo json_encode($result);
        }	
        else{
            header('HTTP/1.1 500' . $result["status"]);
            die($result["status"]);
        }	
}
function productInfoFunction(){
    $ID=$_POST['ID'];
  
    $result = attemptProductInfo($ID);
    if ($result["status"] != "ERROR"){
        echo json_encode($result);
    }	
    else{
        header('HTTP/1.1 500' . $result["status"]);
        die($result["status"]);
    }	
}
function editNameFunction(){
    $nombre = $_POST['name'];
    // Starting the session
    session_start();
 
    if(isset($_SESSION['username'])){
        $username=$_SESSION['username'];
    }
    $result = attemptEditName($nombre, $username);
    if ($result["status2"] == "SUCCESS"){
        echo json_encode($result);
    }	
    else{
        header('HTTP/1.1 500' . $result["status2"]);
        die($result["status2"]);
    }	
}
function editLastNameFunction(){
    $apellido = $_POST['lastName'];
    // Starting the session
    session_start();
 
    if(isset($_SESSION['username'])){
        $username=$_SESSION['username'];
    }
    $result = attemptEditLastName($apellido, $username);
    if ($result["status2"] == "SUCCESS"){
        echo json_encode($result);
    }	
    else{
        header('HTTP/1.1 500' . $result["status2"]);
        die($result["status2"]);
    }
    
}
function editEmailFunction(){
    $email = $_POST['emailText'];
    // Starting the session
    session_start();
 
    if(isset($_SESSION['username'])){
        $username=$_SESSION['username'];
    }
    $result = attemptEditEmail($email, $username);
    if ($result["status2"] == "SUCCESS"){
        echo json_encode($result);
    }	
    else{
        header('HTTP/1.1 500' . $result["status2"]);
        die($result["status2"]);
    }
    
}
function editUsernameFunction(){
    $newUsername = $_POST['usernameText'];
    // Starting the session
    session_start();
 
    if(isset($_SESSION['username'])){
        $username=$_SESSION['username'];
    }
    $resultName = usernameDupplication($newUsername);
    
    if ($resultName["status"] == "SUCCESS"){
        $result = attemptEditUsername($newUsername, $username);
        if ($result["status2"] == "SUCCESS"){
            $_SESSION['username']=$newUsername;
            echo json_encode($result);
        }	
        else{
            header('HTTP/1.1 500' . $result["status2"]);
            die($result["status2"]);
        }
    }	
	else{
		header('HTTP/1.1 500' . $result["status"]);
		die($result["status"]);
	}	
}
function deleteUserFunction(){
    session_start();
    if(isset($_SESSION['username'])){
        $username=$_SESSION['username'];
    }
    $result = attemptDeleteUser($username);
    if ($result["status2"] == "SUCCESS"){
        unset($_SESSION['username']);
        session_destroy();
        echo json_encode($result);
    }	
    else{
        header('HTTP/1.1 500' . $result["status2"]);
        die($result["status2"]);
    }
}
function inserToWishlistFunction(){
    $idProduct = $_POST['idArticle'];
    session_start();
    if(isset($_SESSION['username'])){
        $username=$_SESSION['username'];
    }
    $result = attemptInsertToWishlist($idProduct, $username);
    if ($result["status2"] != "ERROR"){
        echo json_encode($result);
    }	
    else{
        header('HTTP/1.1 500' . $result["status2"]);
        die($result["status2"]);
    }	   
}
function displayWishlistFunction(){
    session_start();
    if(isset($_SESSION['username'])){
        $username=$_SESSION['username'];
    }
    $result = attemptDisplayWishlist($username);
    if($result["status"]!= "ERROR"){
            echo json_encode($result);
    }
    else{
        //header('HTTP/1.1 500' . $result["status"]);
        //die($result["status"]);
        echo json_encode($result);

        }	 
}
function deleteFromWishlistFunction(){
    $idProduct = $_POST['idArticle'];
    session_start();
    if(isset($_SESSION['username'])){
        $username=$_SESSION['username'];
    }
    $result = attemptDeleteFromWishlist($idProduct, $username);
    if ($result["status2"] != "ERROR"){
        echo json_encode($result);
    }	
    else{
        header('HTTP/1.1 500' . $result["status2"]);
        die($result["status2"]);
    }	   
}
function buyProductFunction(){
    $idProduct = $_POST['idArticle'];
    $result = attemptBuyProduct($idProduct);
    if ($result["status2"] != "ERROR"){
        echo json_encode($result);
    }	
    else{
        header('HTTP/1.1 500' . $result["status2"]);
        die($result["status2"]);
    }	 
}
/////////////////////////CHECAR QUE JALE BIEN ////////////////
function displayMyUsersFunction(){
    $result = attemptDisplayMyUsers();

	if($result["status"]!= "ERROR"){
            echo json_encode($result);
    }
    else{
        header('HTTP/1.1 500' . $result["status"]);
        die($result["status"]);
    }	 
}
function deleteSpecificUserFunction(){
    session_start();
    if(isset($_SESSION['username'])){
        $username=$_SESSION['username'];
    }
    $userDelete = $_POST['userToDelete'];
    if($username == $userDelete){
        echo json_encode(array("message"=>"No borrar admin")); 
    }
    else{
        $result = attemptDeleteSpecificUser($userDelete);
        if ($result["status2"] == "SUCCESS"){
            echo json_encode($result);
        }	
        else{
            header('HTTP/1.1 500' . $result["status2"]);
            die($result["status2"]);
        }
    }
}
function deleteInventoryFunction(){
    $productDelete = $_POST['deleteInventory'];
    $result = attemptDeleteInventory($productDelete);
    if ($result["status2"] != "ERROR"){
        echo json_encode($result);
    }	
    else{
        header('HTTP/1.1 500' . $result["status2"]);
        die($result["status2"]);
    }
}
function addInventoryFunction(){
    $category = $_POST['category'];
    $subcategory = $_POST['subcategory'];
    $nameInventory = $_POST['nameInventory'];
    $priceInventory = $_POST['priceInventory'];
    $description = $_POST['description'];
    $contains = $_POST['contains'];
    $compose = $_POST['compose'];
    $size = $_POST['size'];
    $newPic = "/FinalProject/images/NuevoInventorio/".$_POST['newPic'];
    $result= attemptAddInventory($category,$subcategory,$nameInventory,$priceInventory,$description,$contains,$compose,$size,$newPic);
    if($result["status"]== "SUCCESS"){
            echo json_encode($result);
    }
    else{
        header('HTTP/1.1 500' . $result["status"]);
        die($result["status"]);
    }	 
}
/////////////////////Admin
function myAdminFunction(){

	$result = attemptMyAdminProfile();

	if($result["status"]!= "ERROR"){
            echo json_encode($result);
    }
    else{
        header('HTTP/1.1 500' . $result["status"]);
        die($result["status"]);
        }	   
}

function editAdminNameFunction(){
    $nombre = $_POST['nameA'];
    // Starting the session
    session_start();
 
    if(isset($_SESSION['username'])){
        $username=$_SESSION['username'];
    }
    $result = attemptAdminEditName($nombre, $username);
    if ($result["status2"] == "SUCCESS"){
        echo json_encode($result);
    }	
    else{
        header('HTTP/1.1 500' . $result["status2"]);
        die($result["status2"]);
    }	
}
function editAdminLastNameFunction(){
    $apellido = $_POST['lastNameA'];
    // Starting the session
    session_start();
 
    if(isset($_SESSION['username'])){
        $username=$_SESSION['username'];
    }
    $result = attemptAdminEditLastName($apellido, $username);
    if ($result["status2"] == "SUCCESS"){
        echo json_encode($result);
    }	
    else{
        header('HTTP/1.1 500' . $result["status2"]);
        die($result["status2"]);
    }
    
}
function editAdminEmailFunction(){
    $email = $_POST['emailTextA'];
    // Starting the session
    session_start();
 
    if(isset($_SESSION['username'])){
        $username=$_SESSION['username'];
    }
    $result = attemptAdminEditEmail($email, $username);
    if ($result["status2"] == "SUCCESS"){
        echo json_encode($result);
    }	
    else{
        header('HTTP/1.1 500' . $result["status2"]);
        die($result["status2"]);
    }
    
}
?>