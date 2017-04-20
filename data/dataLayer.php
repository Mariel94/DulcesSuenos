<?php

function connectionToDataBase(){
    //header('Accept: application/json');
    //header('Content-type: application/json');
    
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "DS";

   $conn = new mysqli($servername, $username, $password, $dbname);
    mysqli_query($conn, "SET NAMES 'utf8'");
    if ($conn->connect_error){
        return null;
    }
    else{
        return $conn;
    }
}
    
function usernameDupplication($userName){
    $conn = connectionToDataBase();
    if ($conn != null){
        $sql = "SELECT username FROM Users WHERE username = '$userName'";   
        $result = $conn->query($sql);
        if ($result->num_rows > 0)
        {				
            header('HTTP/1.1 409 Usuario en uso');
            die("Usuario en uso");

            $conn -> close();
            return array("status" => "Usuario en uso");
        }
        else{
            $conn -> close();
            return array("status" => "SUCCESS");
        }
    }else{
        $conn -> close();
        return array("status" => "No se pudo conectar al servidor");
    }
}

function attemptLogin($userName){

    $conn = connectionToDataBase();
    if ($conn != null){

        $sql = "SELECT * FROM Users WHERE username = '$userName'";

        $result = $conn->query($sql);

        if ($result->num_rows > 0)
        {
            while($row = $result->fetch_assoc()) 
            {
                $conn -> close();
                return array("status" => "SUCCESS", "password" => $row['passwrd']);

            }         
        }
        else{
            header('HTTP/1.1 406 User not found');
            die("Usuario no encontrado");
            $conn -> close();
            return array("status" => "Usuario no encontrado");
        }
    }
    else{
        $conn -> close();
        return array("status" => "No se pudo conectar al servidor");
    }
}

function attemptRegister($userName, $userPassword, $userFirstName, $userLastName, $userEmail, $userGender, $userCountry){

    $conn = connectionToDataBase();
    if ($conn != null){
        $sql = "INSERT INTO Users (fName, lName, username, passwrd, email, gender, state) VALUES ('$userFirstName', '$userLastName', '$userName', '$userPassword', '$userEmail','$userGender','$userCountry')";

        if (mysqli_query($conn, $sql))
        {
            $conn -> close();
            return array("status2" => "SUCCESS");
        }
        else{
            $conn -> close();
            return array("status2" => "Usuario no encontrado");
        }
    }
    else{
        header('HTTP/1.1 500 Bad connection, something went wrong while saving your data, please try again later');
        die("Error: " . $sql . "\n" . mysqli_error($conn));
        $conn -> close();
        return array("status" => "No se pudo conectar al servidor");
    }
}

function attemptmyProfile(){
    $conn = connectionToDataBase();
    if ($conn != null){
        session_start();

        if (isset($_SESSION['username'])){
            $userName = $_SESSION['username'];

            $sql = "SELECT username, fName, lName, email, gender, state FROM Users WHERE username = '$userName'";

            $result = $conn->query($sql);

            if ($result->num_rows > 0)
            { 

                while($row = $result->fetch_assoc()) 
                {
                $response = array('username' => $row['username'], 'fName' => $row['fName'],'lName' => $row['lName'], 'email' => $row['email'],'gender' => $row['gender'],'state' => $row['state']);   
                }
                $conn -> close();
                return $response;
            }
            else{
                header('HTTP/1.1 500 Bad connection, something went wrong while saving your data, please try again later');
                die("Error: " . $sql . "\n" . mysqli_error($conn));
                $conn -> close();
                return array("status" => "ERROR");
            }
        }
        else{
            $conn -> close();
            return array("status" => "Favor de iniciar sesión");
        }
    }
    else{
        $conn -> close();
        return array("status" => "CONNECTION WITH DB WENT WRONG");
    }
}

function attemptProductsBlancos($subcategoria){
    $conn = connectionToDataBase();
    if ($conn != null){
        $sql = "SELECT ID, Imagen, Nombre, Subcategoria FROM Products WHERE Subcategoria = '$subcategoria'";

        $result = $conn->query($sql);
        $commentArray = array();

        if ($result->num_rows >= 0)
        {
            while($row = $result->fetch_assoc()) 
            {
                $response = array('Imagen' => $row['Imagen'], 'Nombre' => $row['Nombre'],'ID'=> $row['ID'], 'Subcategoria' => $row['Subcategoria']); 
                array_push($commentArray, $response);
                
            }
            $conn -> close();
            return $commentArray;
        }
        else 
        {
            $conn -> close();
            return array("status" => "Bad connection");
        }
    }
    else{
        $conn -> close();
        return array("status" => "CONNECTION WITH DB WENT WRONG");
    }
}

function attemptProductInfo($idProducto){
        $conn = connectionToDataBase();
        
        if ($conn != null){
           $sql = "SELECT * FROM Products WHERE ID = '$idProducto'";
                
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0)
                {
                    while($row = $result->fetch_assoc()) 
                    {
                        $response = array('Categoria' => $row['Categoria'], 'Subcategoria' => $row['Subcategoria'], 'Nombre' => $row['Nombre'], 'Precio' => $row['Precio'], 'Descripcion' => $row['Descripcion'], 'Contiene' => $row['Contiene'],'Composicion' => $row['Composicion'], 'Medidas' => $row['Medidas'], 'Imagen' => $row['Imagen']); 
                    }
                    $conn -> close();
				    return $response;
                }
                else 
                {
                    header('HTTP/1.1 500 Bad connection, something went wrong while saving your data, please try again later');
                    die("Error: " . $sql . "\n" . mysqli_error($conn));
                    $conn -> close();
				    return array("status" => "ERROR");
                }
        }
        else{
            $conn -> close();
			return array("status" => "CONNECTION WITH DB WENT WRONG");
        }
}
function attemptEditName($nombre, $username){
     $conn = connectionToDataBase();
    if ($conn != null){
    
        $sql = "UPDATE Users SET fName = '$nombre' WHERE username = '$username'";   

        if (mysqli_query($conn, $sql))
        {
            $conn -> close();
            return array("status2" => "SUCCESS");
        }
        else{
            $conn -> close();
            return array("status2" => "ERROR");
        }
        
    }else{
        header('HTTP/1.1 500 NO CONNECTION');
        die("Error: " . $sql . "\n" . mysqli_error($conn));
        $conn -> close();
        return array("status" => "No se pudo conectar al servidor");
    }
}
function attemptEditLastName($apellido, $username){
     $conn = connectionToDataBase();
    if ($conn != null){
    
        $sql = "UPDATE Users SET lName = '$apellido' WHERE username = '$username'";   

        if (mysqli_query($conn, $sql))
        {
            $conn -> close();
            return array("status2" => "SUCCESS");
        }
        else{
            $conn -> close();
            return array("status2" => "ERROR");
        }
        
    }else{
        header('HTTP/1.1 500 NO CONNECTION');
        die("Error: " . $sql . "\n" . mysqli_error($conn));
        $conn -> close();
        return array("status" => "No se pudo conectar al servidor");
    }
}
function attemptEditEmail($email, $username){
     $conn = connectionToDataBase();
    if ($conn != null){
    
        $sql = "UPDATE Users SET email = '$email' WHERE username = '$username'";   

        if (mysqli_query($conn, $sql))
        {
            $conn -> close();
            return array("status2" => "SUCCESS");
        }
        else{
            $conn -> close();
            return array("status2" => "ERROR");
        }
        
    }else{
        header('HTTP/1.1 500 NO CONNECTION');
        die("Error: " . $sql . "\n" . mysqli_error($conn));
        $conn -> close();
        return array("status" => "No se pudo conectar al servidor");
    }
}

function attemptEditUsername($newUsername, $username){
     $conn = connectionToDataBase();
    if ($conn != null){
    
        $sql = "UPDATE Users SET username = '$newUsername' WHERE username = '$username'";   

        if (mysqli_query($conn, $sql))
        {
            $conn -> close();
            return array("status2" => "SUCCESS");
        }
        else{
            $conn -> close();
            return array("status2" => "ERROR");
        }
        
    }else{
        header('HTTP/1.1 500 NO CONNECTION');
        die("Error: " . $sql . "\n" . mysqli_error($conn));
        $conn -> close();
        return array("status" => "No se pudo conectar al servidor");
    }
}
function attemptDeleteUser($username){
     $conn = connectionToDataBase();
    if ($conn != null){
    
        $sql = "DELETE from Users WHERE username = '$username'";   

        if (mysqli_query($conn, $sql))
        {
            $conn -> close();
            return array("status2" => "SUCCESS");
        }
        else{
            $conn -> close();
            return array("status2" => "ERROR");
        }
        
    }else{
        header('HTTP/1.1 500 NO CONNECTION');
        die("Error: " . $sql . "\n" . mysqli_error($conn));
        $conn -> close();
        return array("status" => "No se pudo conectar al servidor");
    }
}

function attemptDeleteSpecificUser($username){
     $conn = connectionToDataBase();
    if ($conn != null){
    
        $sql = "DELETE from Users WHERE username = '$username'";   

        if (mysqli_query($conn, $sql))
        {
            $conn -> close();
            return array("status2" => "SUCCESS");
        }
        else{
            $conn -> close();
            return array("status2" => "ERROR");
        }
        
    }else{
        header('HTTP/1.1 500 NO CONNECTION');
        die("Error: " . $sql . "\n" . mysqli_error($conn));
        $conn -> close();
        return array("status" => "No se pudo conectar al servidor");
    }
}

function attemptInsertToWishlist($idProduct, $username){
    $conn = connectionToDataBase();
    if ($conn != null){
        $sql1 = "SELECT product FROM Users WHERE username = '$username'";
        $tempProduct = mysqli_query($conn, $sql1);
        $tempProduct=$tempProduct->fetch_assoc();
        $tempProduct=$tempProduct['product'];
        if($tempProduct != null || !empty($tempProduct)){
            
            $tempProduct = json_decode($tempProduct,true);

            array_push($tempProduct,$idProduct);
            $idProduct = json_encode($tempProduct);
            
            $sql = "UPDATE Users SET product = '$idProduct' WHERE username = '$username'";  
            
            if (mysqli_query($conn, $sql))
            {
                $conn -> close();
                return array("status2" => "SUCCESS");
            }
            else{
                $conn -> close();
                return array("status2" => "ERROR");
            }
        }
        else{
            $idProduct=array($idProduct);
            $idProduct=json_encode($idProduct);
            $sql = "UPDATE Users SET product = '$idProduct' WHERE username = '$username'";  
            
            if (mysqli_query($conn, $sql))
            {
                $conn -> close();
                return array("status2" => "SUCCESS");
            }
            else{
                $conn -> close();
                return array("status2" => "ERROR");
            }
        }
        }else{
            header('HTTP/1.1 500 NO CONNECTION');
            die("Error: " . $sql . "\n" . mysqli_error($conn));
            $conn -> close();
            return array("status" => "No se pudo conectar al servidor");
    }    
}

function attemptDisplayWishlist($username){
     $conn = connectionToDataBase();
    if ($conn != null){
        $sql1 = "SELECT product FROM Users WHERE username = '$username'";
        $tempArray = mysqli_query($conn, $sql1);
        $tempArray= $tempArray->fetch_assoc();
        $tempArray=json_decode($tempArray['product']);
        
        $sql = "SELECT ID,Imagen, Nombre, Descripcion, Precio FROM Products WHERE ID in (". implode(',',$tempArray).")";
        
        $result = $conn->query($sql);
        $wishProducts=array();
        if ($result->num_rows >= 0)
        { 
            while($row = $result->fetch_assoc()) 
            {
                $response = array('ID' => $row['ID'],'Imagen' => $row['Imagen'],'Nombre' => $row['Nombre'],'Precio' => $row['Precio'],'Descripcion' => $row['Descripcion']);
                array_push($wishProducts,$response);
            }
            $conn -> close();
            return $wishProducts;
        }
        else{
            //header('HTTP/1.1 500 Bad connection, something went wrong while saving your data, please try again later');
            //die("Error: " . $sql . "\n" . mysqli_error($conn));
            //$conn -> close();
            return array("status" => "No data");
        }
    }
    else{
        $conn -> close();
        return array("status" => "CONNECTION WITH DB WENT WRONG");
    }
}
function attemptDeleteFromWishlist($idProduct, $username){
    $conn = connectionToDataBase();
    if ($conn != null){
        $sql1 = "SELECT product FROM Users WHERE username = '$username'";
        $tempProduct = mysqli_query($conn, $sql1);
        $tempProduct=$tempProduct->fetch_assoc();
        $tempProduct=$tempProduct['product'];
        $tempProduct = json_decode($tempProduct);
       
        $tempProduct = array_values(array_diff($tempProduct,array($idProduct)));
        
        $idProduct=json_encode($tempProduct);
        $sql = "UPDATE Users SET product = '$idProduct' WHERE username = '$username'";  
            
            if (mysqli_query($conn, $sql))
            {
                $conn -> close();
                return array("status2" => "SUCCESS");
            }
            else{
                $conn -> close();
                return array("status2" => "NO");
            }
        }else{
            header('HTTP/1.1 500 NO CONNECTION');
            die("Error: " . $sql . "\n" . mysqli_error($conn));
            $conn -> close();
            return array("status" => "No se pudo conectar al servidor");
    }    
}

function attemptBuyProduct($idProduct){
    $conn = connectionToDataBase();
    if ($conn != null){
         $sql = "SELECT ID,Imagen, Nombre, Descripcion, Precio FROM Products WHERE ID = '$idProduct'";
          
        $result = $conn->query($sql);

            if ($result->num_rows > 0)
            { 

                while($row = $result->fetch_assoc()) 
                {
                $bad_chars=array('$',',',''); 
                $precio=str_replace($bad_chars,'',$row['Precio']);
                $response = array('Nombre' => $row['Nombre'], 'Imagen' => $row['Imagen'],'Precio' => $precio, 'Descripcion' => $row['Descripcion']);   
                }
                $conn -> close();
                return $response;
            }
            else{
                header('HTTP/1.1 500 Bad connection, something went wrong while saving your data, please try again later');
                die("Error: " . $sql . "\n" . mysqli_error($conn));
                $conn -> close();
                return array("status" => "ERROR");
            }
        }else{
            header('HTTP/1.1 500 NO CONNECTION');
            die("Error: " . $sql . "\n" . mysqli_error($conn));
            $conn -> close();
            return array("status" => "No se pudo conectar al servidor");
        }       
}
///////////FALTA VERIFICAR ESTO!!!//////////////////////////
function attemptDisplayMyUsers(){
        $conn = connectionToDataBase();
    if ($conn != null){
        $sql = "SELECT * FROM Users";

        $result = $conn->query($sql);
        $commentArray = array();

        if ($result->num_rows >= 0)
        {
            while($row = $result->fetch_assoc()) 
            {
                $response = array('username' => $row['username'], 'fName' => $row['fName'],'lName' => $row['lName'], 'email' => $row['email'],'gender' => $row['gender'],'state' => $row['state']); 
                array_push($commentArray, $response);
                
            }
            $conn -> close();
            return $commentArray;
        }
        else 
        {
            $conn -> close();
            return array("status" => "Bad connection");
        }
    }
    else{
        $conn -> close();
        return array("status" => "CONNECTION WITH DB WENT WRONG");
    }
}
function attemptDeleteInventory($productDelete){
    $conn = connectionToDataBase();
    if ($conn != null){
         $sql = "DELETE from Products WHERE ID = '$productDelete'";

        if (mysqli_query($conn, $sql))
        {
            $conn -> close();
            return array("status2" => "SUCCESS");
        }
        else{
            $conn -> close();
            return array("status2" => "ERROR");
        }
        
    }else{
        header('HTTP/1.1 500 NO CONNECTION');
        die("Error: " . $sql . "\n" . mysqli_error($conn));
        $conn -> close();
        return array("status" => "No se pudo conectar al servidor");
    }
}

function attemptAddInventory($category,$subcategory,$nameInventory,$priceInventory,$description,$contains,$compose,$size,$newPic){
    $conn = connectionToDataBase();
        
        if ($conn != null){
            $sql = "INSERT INTO Products (Categoria, Subcategoria, Nombre, Precio, Descripcion, Contiene, Composicion,Medidas, Imagen) VALUES ('$category', '$subcategory','$nameInventory','$priceInventory','$description','$contains','$compose','$size','$newPic')";
            
            if (mysqli_query($conn, $sql))
            {
                $conn -> close();
				return array("status" => "SUCCESS");
            }
            else{
                header('HTTP/1.1 500 Bad connection, something went wrong while saving your data, please try again later');
			    die("Error: " . $sql . "\n" . mysqli_error($conn));
                $conn -> close();
				return array("status" => "Bad connection");
            }
        }
        else{
            $conn -> close();
			return array("status" => "CONNECTION WITH DB WENT WRONG");
        }
    
}
//////////////////////Admin
function attemptMyAdminProfile(){
    $conn = connectionToDataBase();
    if ($conn != null){
        session_start();

        $userName = $_SESSION['username'];

        $sql = "SELECT username, fName, lName, email, gender, state FROM Users WHERE username = '$userName'";

        $result = $conn->query($sql);

        if ($result->num_rows > 0)
        { 
            while($row = $result->fetch_assoc()) 
            {
            $response = array('username' => $row['username'], 'fName' => $row['fName'],'lName' => $row['lName'], 'email' => $row['email'],'gender' => $row['gender'],'state' => $row['state']);   
            }
            $conn -> close();
            return $response;
        }
        else{
            header('HTTP/1.1 500 Bad connection, something went wrong while saving your data, please try again later');
            die("Error: " . $sql . "\n" . mysqli_error($conn));
            $conn -> close();
            return array("status" => "ERROR");
        }
    }
    else{
        $conn -> close();
        return array("status" => "CONNECTION WITH DB WENT WRONG");
    }
}
function attemptAdminEditName($nombre, $username){
     $conn = connectionToDataBase();
    if ($conn != null){
    
        $sql = "UPDATE Users SET fName = '$nombre' WHERE username = '$username'";   

        if (mysqli_query($conn, $sql))
        {
            $conn -> close();
            return array("status2" => "SUCCESS");
        }
        else{
            $conn -> close();
            return array("status2" => "ERROR");
        }
        
    }else{
        header('HTTP/1.1 500 NO CONNECTION');
        die("Error: " . $sql . "\n" . mysqli_error($conn));
        $conn -> close();
        return array("status" => "No se pudo conectar al servidor");
    }
}
function attemptAdminEditLastName($apellido, $username){
     $conn = connectionToDataBase();
    if ($conn != null){
    
        $sql = "UPDATE Users SET lName = '$apellido' WHERE username = '$username'";   

        if (mysqli_query($conn, $sql))
        {
            $conn -> close();
            return array("status2" => "SUCCESS");
        }
        else{
            $conn -> close();
            return array("status2" => "ERROR");
        }
        
    }else{
        header('HTTP/1.1 500 NO CONNECTION');
        die("Error: " . $sql . "\n" . mysqli_error($conn));
        $conn -> close();
        return array("status" => "No se pudo conectar al servidor");
    }
}
function attemptAdminEditEmail($email, $username){
     $conn = connectionToDataBase();
    if ($conn != null){
    
        $sql = "UPDATE Users SET email = '$email' WHERE username = '$username'";   

        if (mysqli_query($conn, $sql))
        {
            $conn -> close();
            return array("status2" => "SUCCESS");
        }
        else{
            $conn -> close();
            return array("status2" => "ERROR");
        }
        
    }else{
        header('HTTP/1.1 500 NO CONNECTION');
        die("Error: " . $sql . "\n" . mysqli_error($conn));
        $conn -> close();
        return array("status" => "No se pudo conectar al servidor");
    }
}
?>