<?php
try{
    $db = new PDO("mysql:host=localhost;dbname=auth_db;charset=utf8","root","");
} catch (PDOException $e) {
    echo $e ->getMessage();
}
?>