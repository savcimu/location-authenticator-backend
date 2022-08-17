<?php
include "connect.php";
include "userInformation.php";

if( $email && $password){
    $result = $db->prepare("select * from users where
        email=:email and
        password=:password
    ");
    $result ->execute(array(
        "email" => $email,
        "password" => $password
    ));
    $user = $result->fetchAll();
    if(@$user[0]){
        include "locationControl.php";
        
            
    }else{
        $response=array(
            'Status'=>'Invalid',
            'message'=>'Wrong email or password'
        );
    }
}else{
    $response=array(
        'Status'=>'Invalid',
        'message'=>'Missing information'
    );
}
if(@$response){
    echo json_encode($response);
}

?>