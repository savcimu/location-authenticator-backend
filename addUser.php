<?php
error_reporting(0);
include "connect.php";
header("Access-Control-Allow-Origin: *");

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$first_name = $request->first_name;
$last_name = $request->last_name;
$email = $request->email;
$password = $request->password;
$lat= $request->lat;
$lng= $request->lng;


if($first_name && $last_name && $email && $password){
    if($lat && $lng){
        $control = $db->prepare("select * from users where
            email=:email 
        ");
        $control->bindParam(':email', $email);
        $control->execute();
        $control = $control->fetchAll();
        if(!$control){
            $insert = $db->prepare("insert into users set
                first_name=:first_name,
                last_name=:last_name,
                email=:email,
                password=:password
            ");
            $userAddControl = $insert->execute(array(
                "first_name" => $first_name,
                "last_name" => $last_name,
                "email" => $email,
                "password" => $password
            ));
            $select = $db->prepare("select id from users where
                email=:email
            ");
            $select->bindParam(':email', $email);
            $select->execute();
            $user_id = $select->fetchAll();
            $insert2 = $db->prepare("insert into location set
                user_id=:user_id,
                lat=:lat,
                lng=:lng
            ");
                    
            $locataionAddcontrol = $insert2 ->execute(array(
                "user_id" => $user_id[0][0],
                "lat" => $lat,
                "lng" => $lng
            ));
            if($userAddControl && $locataionAddcontrol){
                $response=array(
                    'Status'=>'valid',
                    'message'=>'new user created'
                    
                );
            }else{
                $response=array(
                    'Status'=>'Invalid',
                    'message'=>'Failed to create new user'
                );
            }   
        }else{
            $response=array(
                'Status'=>'Invalid',
                'message'=>'User already exists'
            );
        }
        
    }else{
        $response=array(
            'Status'=>'Invalid',
            'message'=>'Location information could not be obtained'
        );
    }
}else{
    $response=array(
        'Status'=>'Invalid',
        'message'=>'Missing information'
    );
}

echo json_encode($response);
?>