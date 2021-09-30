<?php

if(!isset($_SESSION)) {
    session_start();
}

// filter data from ui
$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
$_SESSION["email"] = $email;
$_SESSION["name"] = $name;



require_once './Connect.php';
$connect = new Connect();

require_once './User.php';

// get all users from db
$users_data = $connect->getAllUsers();
$usersArray = json_decode($users_data);


// convert users to user objects
$userList = array();
foreach ($usersArray as $user) {
    $newUser = new User($user->name, $user->email);
    $newUser->buildFrom($user);
    array_push($userList, $newUser);
}




$isUserExist = false;

// check if the user already in db
for ($i = 0; $i < count($userList); $i++) {

    if ($userList[$i]->email === $email) {
        
        // update existing user info
        $userList[$i]->updateUserOnLogin($userList[$i]);
        $usersJSON = json_encode($userList);

        // update db
        $connect->updateUsersDB($usersJSON);

        $isUserExist = true;
        break;
    }
}


// if it's a new user, create and add to db
if ($isUserExist == false) {
    //cearte new user
    $newUser = new User($name, $email);
    $newUser->buildNew();

    // add user to users array
    array_push($userList, $newUser);
    $usersJSON = json_encode($userList);

    // update db
    $connect->updateUsersDB($usersJSON);
}


header("Location: ../dashboard.php");


?>

<head>
    <meta charset="UTF-8" />
    <title>User Login</title>
</head>