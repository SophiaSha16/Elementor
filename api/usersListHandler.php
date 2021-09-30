<?php

require_once './User.php';
require_once './Connect.php';
$connect = new Connect();


// get all users from db
$users_data = $connect->getAllUsers();
$usersArray = json_decode($users_data);



$userList = array();
foreach ($usersArray as $user) {
    $newUser = new User($user->name, $user->email);
    $newUser->buildFrom($user);
    array_push($userList, $newUser);
}


$usersJSON = json_encode($userList);

echo ($usersJSON) ;

?>