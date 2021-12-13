<?php


//ERROR FIRST'
require_once(__DIR__.'/../globals.php');
$db = _db_connect();

//Validate firstName
if( !isset($_POST['firstName']) ){_res('400',['info' => "Name is required"]);}
if( strlen($_POST['firstName']) < _NAME_MIN_LEN ){_res('400',['info' => "Name must be at least 2 characters"]);}
if( strlen($_POST['firstName']) > _NAME_MAX_LEN ){_res('400',['info' => "Name cannot be more than 40 characters"]);}

//Validate lastName
if( !isset($_POST['lastName']) ){_res('400',['info' => "Last name is required"]);}
if( strlen($_POST['lastName']) < _NAME_MIN_LEN ){_res('400',['info' => "Last name must be at least 2 characters"]);}
if( strlen($_POST['lastName']) > _NAME_MAX_LEN ){_res('400',['info' => "Last name cannot be more than 40 characters"]);}

//Validate email
if( !isset($_POST['email']) ){_res('400',['info' => "Email is required"]);}
if( !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL ) ){_res('400',['info' => 'Email is invalid']);}


if( !isset($_POST['password']) ){_res('400',['info' => "Please provide a password"]);}
if( strlen($_POST['password']) < _PASSWORD_MIN_LEN ){_res('400',['info' => 'Password must be at least '. _PASSWORD_MIN_LEN .' characters']);}
if( strlen($_POST['password']) > _PASSWORD_MAX_LEN ){_res('400',['info' => 'Password can be no more than '. _PASSWORD_MAX_LEN .' characters']);}

if( $_POST['isAdmin'] == 1 ) {
    $admin = 1;
} else {
    $admin = 0;
}
$password = $_POST['password'];
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insert data in the DB
try{
    $query = $db->prepare('SELECT * FROM users WHERE email = :email');
    $query->bindValue(":email", $_POST['email']);
    $query->execute();
    $row = $query->fetch();
    if($row){_res('400', 'Email is already in use');}
    else { 
        try{;
            if($_POST['isAdmin'] == 1){
                $query = $db->prepare('CALL create_admin(:first_name, :last_name, :email, :admin, :password)');
            } else{
                $query = $db->prepare('CALL create_user(:first_name, :last_name, :email, :admin, :password)');
            }
            $query->bindValue(":first_name", $_POST['firstName']);
            $query->bindValue(":last_name", $_POST['lastName']);
            $query->bindValue(":email", $_POST['email']);
            $query->bindValue(":admin", $admin);
            $query->bindValue(":password", $hashedPassword);
            $query->execute();
            _res('200', ['info' => 'Successfully created user']);
        } catch(Exception $ex){
            http_response_code(500);
            $errResponse = ["info" => 'System under maintainance '.__LINE__];
            echo json_encode($errResponse);
            exit();
        }
    }   
    
} catch(Exception $ex){
    http_response_code(500);
    $errResponse = ["info" => 'System under maintainance '.__LINE__];
    echo json_encode($errResponse);
    exit();
}
