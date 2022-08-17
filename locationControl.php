<?php
$locataionQuery = $db->prepare("select * from location where
lat=:lat and
lng=:lng and
user_id=:user_id
");
$locataionQuery ->execute(array(
    "user_id" => $user[0]['id'],
    "lat" => $lat,
    "lng" => $lng
));
$locataionQ = $locataionQuery->fetchAll();

if(@$locataionQ[0]['lat']!=$lat || @$locataionQ[0]['lng']!=$lng){

    $randomNumber = random_int(100000, 999999);
    include "mailsend.php";

    $locationInsert = $db->prepare("insert into location set
        user_id=:user_id,
        lat=:lat,
        lng=:lng
    ");
    $locationInsert ->execute(array(
        "user_id" => $user[0]['id'],
        "lat" => $lat,
        "lng" => $lng
    ));

    $codeInsert = $db->prepare("insert into authenticator set
        user_id=:user_id,
        code=:code
    ");
    $codeInsert ->execute(array(
        "user_id" => $user[0]['id'],
        "code" => $randomNumber
    ));
    http_response_code(201);
    $response=array(
        'Status'=>'201',
        'user_id'=>$user[0]['id']
    );
}else{
    http_response_code(200);
        $out="";
        $out .= '{"email":"' . $user[0]['email'] . '",';
        $out .= '"first_name":"' . $user[0]['first_name'] . '",';
        $out .= '"last_name":"' . $user[0]['last_name'] . '",';
        $out .= '"Status":"200"}';
        echo $out;
}
?>