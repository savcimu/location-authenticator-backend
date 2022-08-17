<?php
include "connect.php";
header("Access-Control-Allow-Origin: *");

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

$code = $request->code;
$user_id = $request->user_id;

if($code && $user_id){
    $result = $db->prepare("select * from authenticator where
        code=:code and
        user_id=:user_id
    ");
    $result ->execute(array(
        "code" => $code,
        "user_id" => $user_id
    ));
    $user = $result->fetchAll();
    if(@$user[0]){
        $userLogin = $db->prepare("select * from users where
            id=:user_id
        ");
        $userLogin ->execute(array(
            "user_id" => $user_id
        ));
        $userLogin = $userLogin->fetchAll();

        $response=array(
            'Status'=>'200',
            'message'=>'Verification successful',
            'email'=>$userLogin[0]['email'],
            'first_name'=>$userLogin[0]['first_name'],
            'last_name'=>$userLogin[0]['last_name']
        );
        $deleteAuth = $db->prepare("delete from authenticator where
            user_id=:user_id
        ");
        $deleteAuth ->execute(array(
            "user_id" => $user_id
        ));
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