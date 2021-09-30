<?php

if(!isset($_SESSION)) {
    session_start();
}

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


for ($i = 0; $i < count($userList); $i++) {

    // find the user by email in the array
    if ($userList[$i]->email === $_SESSION["email"]) {
        
        // update the user's online status
        $userList[$i]->updateUserOnLogout($userList[$i]);

        $usersJSON = json_encode($userList);

        // update db
        $connect->updateUsersDB($usersJSON);

    }
}

$usersJSON = json_encode($userList);


echo ($usersJSON) ;

?>